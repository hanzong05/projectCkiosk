<?php
// Prevent any output before headers
ob_start();

// Error handling configuration
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/excel_upload_errors.log');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../class/connection.php';
require_once '../../vendor/autoload.php';

class ExcelEventHandler {
    private $db;
    private $user_id;
    private $account_id;
    private $creator_name;
    private $max_file_size = 5242880; // 5MB
    private $allowed_mime_types = [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
        'application/octet-stream'
    ];

    public function __construct($db, $user_id, $account_id, $creator_name) {
        $this->db = $db;
        $this->user_id = $user_id;
        $this->account_id = $account_id;
        $this->creator_name = $creator_name;
    }

    public function downloadTemplate() {
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $sheet->setCellValue('A1', 'Start Date (YYYY-MM-DD)');
            $sheet->setCellValue('B1', 'End Date (YYYY-MM-DD)');
            $sheet->setCellValue('C1', 'Event Details');

            // Add sample data
            $sheet->setCellValue('A2', date('Y-m-d'));
            $sheet->setCellValue('B2', date('Y-m-d', strtotime('+1 day')));
            $sheet->setCellValue('C2', 'Sample Event Details');

            // Style headers
            $sheet->getStyle('A1:C1')->getFont()->setBold(true);
            $sheet->getStyle('A1:C1')->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setRGB('CCCCCC');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(40);

            // Add instructions
            $sheet->setCellValue('A4', 'Instructions:');
            $sheet->getStyle('A4')->getFont()->setBold(true);
            $sheet->setCellValue('A5', '1. Dates must be in YYYY-MM-DD format');
            $sheet->setCellValue('A6', '2. Event details must not exceed 250 characters');
            $sheet->setCellValue('A7', '3. End date must be after or equal to start date');

            // Create Excel file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="calendar_events_template.xlsx"');
            header('Cache-Control: max-age=0');

            // Save to output
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            error_log("Template generation failed: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error generating template']);
            exit;
        }
    }

    public function processExcelUpload($file) {
        try {
            $this->validateFile($file);

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            // Get and validate headers
            $headerRow = $worksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0];
            $expectedHeaders = [
                'Start Date (YYYY-MM-DD)',
                'End Date (YYYY-MM-DD)',
                'Event Details'
            ];

            if ($headerRow !== $expectedHeaders) {
                throw new Exception('Invalid file format. Please use the provided template.');
            }

            // Initialize counters
            $successful = 0;
            $failed = 0;
            $errors = [];

            // Start transaction
            $this->db->beginTransaction();

            // Process data rows
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false)[0];

                if ($this->isEmptyRow($rowData)) {
                    continue;
                }

                try {
                    // Validate and sanitize data
                    $startDate = $this->validateDate(trim($rowData[0]));
                    $endDate = $this->validateDate(trim($rowData[1]));
                    $details = $this->sanitizeString(trim($rowData[2]));

                    // Additional validations
                    if (!$startDate || !$endDate) {
                        throw new Exception("Invalid date format. Use YYYY-MM-DD");
                    }
                    if (empty($details)) {
                        throw new Exception("Event details cannot be empty");
                    }
                    if (strlen($details) > 250) {
                        throw new Exception("Event details exceed 250 characters");
                    }
                    if (strtotime($endDate) < strtotime($startDate)) {
                        throw new Exception("End date cannot be before start date");
                    }

                    // Insert into database
                    $stmt = $this->db->prepare("
                        INSERT INTO calendar_tbl (
                            calendar_start_date,
                            calendar_end_date,
                            calendar_details,
                            created_by,
                            event_creator,
                            updated_at
                        ) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
                    ");

                    $success = $stmt->execute([
                        $startDate,
                        $endDate,
                        $details,
                        $this->user_id,
                        $this->account_id
                    ]);

                    if ($success) {
                        $successful++;
                    } else {
                        throw new Exception("Database insertion failed");
                    }

                } catch (Exception $e) {
                    $failed++;
                    $errors[] = "Row $row: " . $e->getMessage();
                }
            }

            if ($successful > 0) {
                $this->db->commit();
                $this->logAudit($successful, $failed);

                return [
                    'success' => true,
                    'message' => "Successfully uploaded $successful events" . ($failed > 0 ? " ($failed failed)" : ""),
                    'successful_count' => $successful,
                    'failed_count' => $failed,
                    'errors' => $errors
                ];
            } else {
                throw new Exception('No valid events were found in the file');
            }

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'successful_count' => 0,
                'failed_count' => 1,
                'errors' => [$e->getMessage()]
            ];
        }
    }

    private function validateFile($file) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            throw new Exception('No file uploaded');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload failed with error code: ' . $file['error']);
        }

        if ($file['size'] > $this->max_file_size) {
            throw new Exception('File size exceeds maximum limit of 5MB');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        
        if (!in_array($mimeType, $this->allowed_mime_types)) {
            throw new Exception('Invalid file type. Only Excel files (.xlsx, .xls) are allowed');
        }
    }

    private function isEmptyRow($rowData) {
        return empty(array_filter($rowData, function($cell) {
            return !empty(trim((string)$cell));
        }));
    }

    private function validateDate($date) {
        $format = 'Y-m-d';
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date ? $date : false;
    }

    private function sanitizeString($str) {
        return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
    }

    private function logAudit($successful, $failed) {
        try {
            $message = "{$this->creator_name} uploaded {$successful} events" . 
                      ($failed > 0 ? " ({$failed} failed)" : "");
            
            $stmt = $this->db->prepare("
                INSERT INTO audit_trail (message, actions, created_at) 
                VALUES (?, 'add', CURRENT_TIMESTAMP)
            ");
            
            $stmt->execute([$message]);
        } catch (Exception $e) {
            error_log("Audit log error: " . $e->getMessage());
        }
    }
}

// Clear any existing output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Handle the request
try {
    if (!isset($_SESSION['aid']) || !isset($_SESSION['id'])) {
        throw new Exception('Unauthorized access');
    }

    $handler = new ExcelEventHandler(
        $connect,
        $_SESSION['aid'],
        $_SESSION['id'],
        $_SESSION['name'] ?? 'System Upload'
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
        $result = $handler->processExcelUpload($_FILES['excelFile']);
        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    } elseif (isset($_GET['download_template'])) {
        $handler->downloadTemplate();
        exit;
    } else {
        throw new Exception('Invalid request');
    }

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
?>