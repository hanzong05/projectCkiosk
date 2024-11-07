<?php
include "../../class/connection.php"; // Adjust the path as needed
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the error log file
ini_set('error_log', 'error_log.php');

// Set the header for JSON response
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

// Log the received POST data for debugging
error_log("POST data: " . print_r($_POST, true));
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? null;

    // Log the received type for debugging
    error_log("Received type: " . $type);

    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Announcement Update
        if ($_POST['type'] === 'announcement') {
            $aid = $_POST['aid'] ?? '';
            $details = $_POST['announcement_details'] ?? '';
            $update = $_POST['announcement_creator'] ?? '';
            $removedImages = $_POST['removed_images'] ?? ''; 
              $removedImages = $_POST['removed_images'] ?? ''; // Removed images
            $newImages = $_FILES['ann_imgs'] ?? []; // New uploaded images
            $date = date('Y-m-d H:i:s'); // Current timestamp for updated_at
            $replacedImages = $_POST['replaced_images'] ?? '';
        
            $response = [
                'success' => true,
                'message' => '',
            ];
        
            // Validate required fields
            if (empty($aid) || empty($details) || empty($update)) {
                $response['success'] = false;
                $response['message'] = 'Missing required fields.';
                echo json_encode($response);
                error_log("Error: Missing required fields - Announcement ID: $aid\n", 3, 'error_log.txt');
                exit;
            }
        
            // Handle removed images
            if (!empty($removedImages)) {
                error_log("Removed Images: " . print_r($removedImages, true) . "\n", 3, 'error_log.txt');
            }
        
            // Update announcement details
            $sql = "UPDATE `announcement_tbl` 
                    SET announcement_details = :details, 
                        updated_at = :date, 
                        updated_by = :update
                    WHERE announcement_id = :aid";
            $stmt = $connect->prepare($sql);
            if (!$stmt->execute([
                ':details' => $details,
                ':date' => $date,
                ':update' => $update,
                ':aid' => $aid
            ])) {
                $response['success'] = false;
                $response['message'] = 'Failed to update announcement: ' . implode(", ", $stmt->errorInfo());
                echo json_encode($response);
                error_log("Error: Failed to update announcement - " . implode(", ", $stmt->errorInfo()) . "\n", 3, 'error_log.txt');
                exit;
            }
        
 
            // Remove deleted images
            if (!empty($replacedImages)) {
                $foundImages = false; // Track if any image is processed
                
                foreach ($replacedImages as $image) {
                    $image = trim($image);
                    
                    if (!empty($image)) {
                        $foundImages = true;
                        // Log requested replacement image
                        error_log("Requested Replacement of Image: $image\n", 3, 'error_log.txt');
                        
                        // Delete from database
                        $deleteStmt = $connect->prepare("DELETE FROM announcement_images WHERE image_path = :imagePath");
                        if ($deleteStmt->execute([':imagePath' => $image])) {
                            error_log("Deleted image from database: $image\n", 3, 'error_log.txt');
                        } else {
                            error_log("Failed to delete image from database: $image\n", 3, 'error_log.txt');
                        }
            
                        // Delete from filesystem
                        $filePath = "C:/xampp/htdocs/ckiosk/uploaded/annUploaded/" . $image;
                        if (file_exists($filePath)) {
                            if (unlink($filePath)) {
                                error_log("Deleted replaced image file: $filePath\n", 3, 'error_log.txt');
                            } else {
                                error_log("Failed to delete file from filesystem: $filePath\n", 3, 'error_log.txt');
                            }
                        } else {
                            error_log("File not found on filesystem: $filePath\n", 3, 'error_log.txt');
                        }
                    }
                }
                
                if (!$foundImages) {
                    error_log("Error: No valid images found in replacedImages array.\n", 3, 'error_log.txt');
                }
            } else {
                error_log("Error: No images provided in replacedImages array.\n", 3, 'error_log.txt');
            }            // Handle new images upload (Defined here within the if block)
            if (!empty($newImages) && is_array($newImages['name'])) {
                $uploadedFiles = [];
                foreach ($newImages['name'] as $key => $fileName) {
                    $fileTmp = $newImages['tmp_name'][$key];
                    $fileSize = $newImages['size'][$key];
                    $fileType = $newImages['type'][$key];
        
                    // Specify upload directory
                    $uploadDirectory = '../../uploaded/annUploaded/';
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true); // Create directory if it doesn't exist
                    }
        
                    // Generate a unique file name
                    $uniqueFileName = uniqid() . '-' . basename($fileName);
                    $targetFilePath = $uploadDirectory . $uniqueFileName;
        
                    // Optional validation (file type, size)
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $maxFileSize = 5 * 1024 * 1024; // 5MB
        
                    if (!in_array($fileType, $allowedTypes)) {
                        error_log("Error: Invalid file type for file: $fileName\n", 3, 'error_log.txt');
                        continue;
                    }
        
                    if ($fileSize > $maxFileSize) {
                        error_log("Error: File size exceeds the limit for file: $fileName\n", 3, 'error_log.txt');
                        continue;
                    }
        
                    // Attempt to move the uploaded file
                    if (move_uploaded_file($fileTmp, $targetFilePath)) {
                        $uploadedFiles[] = $uniqueFileName;
                        error_log("File uploaded successfully: $fileName -> $targetFilePath\n", 3, 'error_log.txt');
                    } else {
                        error_log("Error: Failed to upload file: $fileName\n", 3, 'error_log.txt');
                    }
                }
        
                // Insert uploaded image paths into the database
                foreach ($uploadedFiles as $uploadedFile) {
                    $insertImageStmt = $connect->prepare("INSERT INTO announcement_images (announcement_id, image_path) VALUES (:aid, :imagePath)");
                    if (!$insertImageStmt->execute([':aid' => $aid, ':imagePath' => $uploadedFile])) {
                        $response['success'] = false;
                        $response['message'] = 'Failed to upload image to the database.';
                        echo json_encode($response);
                        error_log("Error: Failed to upload image - $uploadedFile\n", 3, 'error_log.txt');
                        exit;
                    }
                }
            }
        
            // Remove deleted images
            if (!empty($removedImages)) {
                $removedImagesArray = explode(',', $removedImages);
                foreach ($removedImagesArray as $image) {
                    $image = trim($image);
                    if (!empty($image)) {
                        $deleteStmt = $connect->prepare("DELETE FROM announcement_images WHERE image_path = :imagePath");
                        $deleteStmt->execute([':imagePath' => $image]);
        
                        $filePath = "C:/xampp/htdocs/ckiosk/uploaded/annUploaded/" . $image;
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
            }
        
            // Audit Trail
            $creator_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :update");
            $creator_stmt->execute([':update' => $update]);
            $updater_name = $creator_stmt->fetchColumn();
        
            if (!$updater_name) {
                $creator_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE id = :update");
                $creator_stmt->execute([':update' => $update]);
                $updater_name = $creator_stmt->fetchColumn() ?: 'Unknown User';
            }
        
            $audit_message = "{$updater_name} updated an announcement: {$details}";
            $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
            $audit_stmt->execute([':message' => $audit_message]);
        
            $response['success'] = true;
            $response['message'] = 'Announcement updated successfully.';
            ob_end_clean(); // Clear output buffer before sending the response
            echo json_encode($response);
            exit;
        }
        

        
        elseif ($type === 'event') {
            $cid = $_POST['cid'] ?? '';
            $details = $_POST['event_details'] ?? '';
            $update = $_POST['event_editor'] ?? '';
            $date = $_POST['event_date'] ?? '';
        
            // Update event in the database
            $sql = "UPDATE `calendar_tbl` 
                    SET calendar_details = :details, 
                        calendar_date = :date,
                        updated_by = :update,
                        updated_at = NOW()  -- Set updated_at to the current timestamp
                    WHERE calendar_id = :cid";
        
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':details' => $details,
                ':date' => $date,
                ':update' => $update,
                ':cid' => $cid
            ]);
        
            // Fetch editor's name, first from `users_tbl`, and if not found, from `orgmembers_tbl`
            $editor_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :update");
            $editor_stmt->execute([':update' => $update]);
            $editor_name = $editor_stmt->fetchColumn();
        
            if (!$editor_name) {
                // If not found in `users_tbl`, search in `orgmembers_tbl`
                $editor_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE id = :update");
                $editor_stmt->execute([':update' => $update]);
                $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
            }
        
            // Audit trail
            $audit_message = "{$editor_name} updated an event: {$details}";
            $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
            $audit_stmt->execute([':message' => $audit_message]);
        
            $response['success'] = true;
            $response['message'] = 'Event updated successfully.';
        }
        
   if ($type === 'faculty') {
    // Get POST data
    $fid = $_POST['fid'] ?? '';
    $name = $_POST['faculty_name'] ?? '';
    $specialization = $_POST['specialization'] ?? '';
    $consultationTime = $_POST['consultation_time'] ?? '';
    $previousImage = $_POST['previous'] ?? '';
    $editor_id = $_POST['editor_id'] ?? ''; // ID of the person making the update
    $departmentIds = $_POST['department'] ?? []; // Array of department IDs (should be passed as an array)

    // Default to the previous image if no new image is uploaded
    $newImage = $previousImage;

    // Check for duplicate faculty member by name and department
    $duplicate_check_sql = "SELECT COUNT(*) FROM faculty_tbl WHERE faculty_name = :name AND faculty_id != :fid";
    $duplicate_stmt = $connect->prepare($duplicate_check_sql);
    $duplicate_stmt->execute([':name' => $name, ':fid' => $fid]);

    if ($duplicate_stmt->fetchColumn() > 0) {
        $response['success'] = false;
        $response['message'] = 'A faculty member with the same name and department already exists.';
        echo json_encode($response);
        exit;
    }

    // File upload handling for faculty image
    if (isset($_FILES['faculty_image']) && $_FILES['faculty_image']['error'] === UPLOAD_ERR_OK) {
        $uploadTo = __DIR__ . "/../../uploaded/facultyUploaded/";

        if (!file_exists($uploadTo)) {
            if (!mkdir($uploadTo, 0777, true)) {
                error_log('Failed to create faculty directory.');
                $response['message'] = 'Failed to create upload directory.';
                echo json_encode($response);
                exit;
            }
        }

        $newImage = basename($_FILES['faculty_image']['name']);
        $tempPath = $_FILES["faculty_image"]["tmp_name"];
        $originalPath = $uploadTo . $newImage;

        if (!move_uploaded_file($tempPath, $originalPath)) {
            $response['message'] = 'Failed to move uploaded file.';
            echo json_encode($response);
            exit;
        }

        // Remove old image if it exists
        if ($previousImage && file_exists($uploadTo . $previousImage)) {
            unlink($uploadTo . $previousImage);
        }
    }

    // Update faculty details in the faculty_tbl
    $sql = "UPDATE `faculty_tbl` 
            SET faculty_name = :name, faculty_image = :image, specialization = :specialization, 
                consultation_time = :consultation_time
            WHERE faculty_id = :fid";
    $stmt = $connect->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':image' => $newImage,
        ':specialization' => $specialization,
        ':consultation_time' => $consultationTime,
        ':fid' => $fid
    ]);

    // Update the faculty's associated departments
    // First, remove the old departments
    $deleteDeptSql = "DELETE FROM faculty_departments_tbl WHERE faculty_id = :fid";
    $deleteDeptStmt = $connect->prepare($deleteDeptSql);
    $deleteDeptStmt->execute([':fid' => $fid]);

    // Now, add the new departments
    foreach ($departmentIds as $deptId) {
        $insertDeptSql = "INSERT INTO faculty_departments_tbl (faculty_id, department_id) VALUES (:fid, :deptId)";
        $insertDeptStmt = $connect->prepare($insertDeptSql);
        $insertDeptStmt->execute([
            ':fid' => $fid,
            ':deptId' => $deptId
        ]);
    }

    // Fetch editor's name, first from `users_tbl`, and if not found, from `orgmembers_tbl`
    $editor_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn();

    if (!$editor_name) {
        // If not found in `users_tbl`, search in `orgmembers_tbl`
        $editor_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
        $editor_stmt->execute([':editor_id' => $editor_id]);
        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
    }

    // Audit trail
    $audit_message = "{$editor_name} updated faculty member: Name - {$name}, Specialization - {$specialization}, Consultation Time - {$consultationTime}";
    $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
    $audit_stmt->execute([':message' => $audit_message]);

    $response['success'] = true;
    $response['message'] = 'Faculty member updated successfully.';
    echo json_encode($response);
}
        elseif ($type === 'organization') {
            $orgId = $_POST['org_id'] ?? '';
            $orgName = $_POST['org_name'] ?? '';
            $previousImage = $_POST['previous_image'] ?? '';
            $newImage = $previousImage; // Default to previous image
            $editor_id = $_POST['editor_id'] ?? ''; // ID of the person making the update
        
            // Check for duplicate organization by name
            $duplicate_check_sql = "SELECT COUNT(*) FROM organization_tbl WHERE org_name = :name AND org_id != :id";
            $duplicate_stmt = $connect->prepare($duplicate_check_sql);
            $duplicate_stmt->execute([':name' => $orgName, ':id' => $orgId]);
        
            if ($duplicate_stmt->fetchColumn() > 0) {
                $response['success'] = false;
                $response['message'] = 'An organization with the same name already exists.';
                echo json_encode($response);
                exit;
            }
        
            // File upload handling for organization image
            if (isset($_FILES['org_image']) && $_FILES['org_image']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/orgUploaded/";
                if (!file_exists($uploadTo)) {
                    if (!mkdir($uploadTo, 0777, true)) {
                        error_log('Failed to create organization directory.');
                        $response['message'] = 'Failed to create upload directory.';
                        echo json_encode($response);
                        exit;
                    }
                }
        
                $newImage = basename($_FILES['org_image']['name']);
                $tempPath = $_FILES["org_image"]["tmp_name"];
                $originalPath = $uploadTo . $newImage;
        
                if (move_uploaded_file($tempPath, $originalPath)) {
                    // Remove old image if it exists
                    if ($previousImage && file_exists($uploadTo . $previousImage)) {
                        unlink($uploadTo . $previousImage);
                    }
                } else {
                    error_log('Failed to move uploaded file.');
                    $response['message'] = 'Failed to move uploaded file.';
                    echo json_encode($response);
                    exit;
                }
            }
        
            // Update organization in the database
            $sql = "UPDATE organization_tbl 
                    SET org_name = :name, org_image = :image
                    WHERE org_id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':name' => $orgName,
                ':image' => $newImage,
                ':id' => $orgId
            ]);
        
            // Fetch editor's name, first from `users_tbl`, and if not found, from `orgmembers_tbl`
            $editor_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
            $editor_stmt->execute([':editor_id' => $editor_id]);
            $editor_name = $editor_stmt->fetchColumn();
        
            if (!$editor_name) {
                // If not found in `users_tbl`, search in `orgmembers_tbl`
                $editor_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
                $editor_stmt->execute([':editor_id' => $editor_id]);
                $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
            }
        
            // Audit trail
            $audit_message = "{$editor_name} updated organization '{$orgName}' (ID: {$orgId})";
            $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
            $audit_stmt->execute([':message' => $audit_message]);
        
            $response['success'] = true;
            $response['message'] = 'Organization updated successfully.';
            echo json_encode($response);
        }
        
        elseif ($type === 'faq') {
            $fid = $_POST['fid'] ?? '';
            $question = htmlspecialchars_decode($_POST['faqs_question'] ?? '');
            $answer = htmlspecialchars_decode($_POST['faqs_answer'] ?? '');
            $editor_id = $_POST['editor_id'] ?? ''; // ID of the person making the update
        
            // Update FAQ in the database
            $sql = "UPDATE faqs_tbl 
                    SET faqs_question = :question, faqs_answer = :answer
                    WHERE faqs_id = :fid";
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':question' => $question,
                ':answer' => $answer,
                ':fid' => $fid
            ]);
        
            // Fetch editor's name, first from `users_tbl`, and if not found, from `orgmembers_tbl`
            $editor_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
            $editor_stmt->execute([':editor_id' => $editor_id]);
            $editor_name = $editor_stmt->fetchColumn();
        
            if (!$editor_name) {
                // If not found in `users_tbl`, search in `orgmembers_tbl`
                $editor_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
                $editor_stmt->execute([':editor_id' => $editor_id]);
                $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
            }
        
            // Audit trail
            $audit_message = "{$editor_name} updated FAQ with Question - '{$question}'";
            $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
            $audit_stmt->execute([':message' => $audit_message]);
        
            $response['success'] = true;
            $response['message'] = 'FAQ updated successfully.';
        }
       
        
        elseif ($type === 'membersaccount') {
            // Get input values
            $name = $_POST['name'] ?? null;
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $position = $_POST['position'] ?? null; 
            $org = $_POST['org'] ?? null;
            $uid = $_POST['uid'] ?? null; // Assume the UID is sent for updating the member
            $editor_id = $_POST['editor_id'] ?? ''; // ID of the person making the update
        
            // Initialize an array to collect validation errors
            $errors = [];
            
            // Validate input values
            if ($username === null || empty(trim($username))) {
                $errors[] = 'Username is required.';
            }
        
            // Password validation (can be skipped if not updating password)
            if ($password !== null && !empty(trim($password))) {
                // Validate password strength
                if (strlen($password) < 8 || strlen($password) > 16) {
                    $errors[] = 'Password must be between 8 and 16 characters long.';
                }
        
                if (!preg_match('/[A-Z]/', $password)) {
                    $errors[] = 'Password must contain at least one uppercase letter.';
                }
        
                if (!preg_match('/[0-9]/', $password)) {
                    $errors[] = 'Password must contain at least one number.';
                }
        
                if (!preg_match('/[!@#$%^&*(),.?":{}|<>_]/', $password)) {
                    $errors[] = 'Password must contain at least one special character.';
                }
            }
        
            // Validate position
            if ($position === null || empty(trim($position))) {
                $errors[] = 'Position is required.';
            }
        
            // If there are validation errors, return them all at once
            if (!empty($errors)) {
                $response['success'] = false;
                $response['message'] = implode('<br>', $errors);
                echo json_encode($response);
                exit;
            }
        
            // Debugging: Log the account update parameters
            error_log('Account Update - Username: ' . $username);
            error_log('Account Update - Position: ' . $position); // Log the position
        
            // Prepare to update user account
            try {
                // Get the existing password hash if password is not being updated
                $sql = 'SELECT password FROM orgmembers_tbl WHERE id = :uid';
                $stmt = $connect->prepare($sql);
                $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->rowCount() === 1) {
                    $existingPasswordHash = $stmt->fetchColumn();
        
                    // If a new password is provided, hash it; otherwise, keep the existing password
                    $hashedPassword = !empty($password) ? hash('sha256', $password) : $existingPasswordHash;
        
                    // Update account details in the database
                    $updateSql = "UPDATE orgmembers_tbl 
                                  SET name = :name, username = :username, password = :password, position = :position, org_type = :org 
                                  WHERE id = :uid";
                    $updateStmt = $connect->prepare($updateSql);
                    $updateStmt->execute([
                        ':name' => $name,
                        ':username' => $username,
                        ':password' => $hashedPassword,
                        ':position' => $position,
                        ':org' => $org, // Assuming this is the correct field for organization type
                        ':uid' => $uid
                    ]);
        
                    // Fetch editor's name
                    $editor_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
                    $editor_stmt->execute([':editor_id' => $editor_id]);
                    $editor_name = $editor_stmt->fetchColumn();
        
                    if (!$editor_name) {
                        // If not found in `users_tbl`, search in `orgmembers_tbl`
                        $editor_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE orgmember_id = :editor_id");
                        $editor_stmt->execute([':editor_id' => $editor_id]);
                        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
                    }
        
                    // Audit trail
                    $audit_message = "{$editor_name} updated member account with ID {$uid}: Username - '{$username}', Position - '{$position}'";
                    $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
                    $audit_stmt->execute([':message' => $audit_message]);
        
                    $response['success'] = true;
                    $response['message'] = 'Account updated successfully.';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'User not found.';
                }
            } catch (Exception $e) {
                // Log the exception message
                error_log('Error occurred: ' . $e->getMessage(), 3, 'error_log.php');
                $response['success'] = false;
                $response['message'] = 'An error occurred. Please try again.';
                echo json_encode($response);
            }
        }
        else {
            $response['success'] = false;
            $response['message'] = 'Invalid request type.';
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Log database-related errors
        error_log('Database error: ' . $e->getMessage(), 3, 'error_log.php');
        $response['success'] = false;
        $response['message'] = 'Database error occurred.';
        echo json_encode($response);
    } catch (Exception $e) {
        // Log general errors
        error_log('General error: ' . $e->getMessage(), 3, 'error_log.php');
        $response['success'] = false;
        $response['message'] = 'An error occurred.';
        echo json_encode($response);
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>