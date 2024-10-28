<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Comment;

// Create an instance of PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the headers for Name, Department, and Consultation Time
$headers = ['Name', 'Department', 'Consultation Time'];
$sheet->fromArray($headers, NULL, 'A1'); // Set headers starting at cell A1

// Define comments for each column
$comments = [
    'A2' => "Enter the full name of the faculty member.",
    'B2' => "Enter the department (e.g., 'IT DEPARTMENT', 'MIS DEPARTMENT').",
    'C2' => "Provide the consultation time (e.g., 'Monday - Thursday 8:00 AM to 4:00 PM')."
];

// Add comments to each cell
foreach ($comments as $cell => $text) {
    $sheet->getComment($cell)->getText()->createTextRun($text);
    $sheet->getComment($cell)->setAuthor('Admin');
}

// Optionally, set some formatting (e.g., bold headers)
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
];
$sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

// Set headers for the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="faculty_format.xlsx"');
header('Cache-Control: max-age=0');

// Save the spreadsheet to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
