<?php

include "../../class/connection.php"; // Adjust the path as needed
// Enable error logging
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt'); // Log to error_log.txt

// Log POST and FILES data for debugging
error_log('POST Data: ' . print_r($_POST, true));
error_log('FILES Data: ' . print_r($_FILES, true));

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
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);/// Collect POST data
        if ($type === 'announcement') {
          // Extract the POST and FILES data
$aid = $_POST['aid'] ?? '';  // Announcement ID
$details = $_POST['announcement_details'] ?? '';  // New details
$update = $_POST['announcement_creator'] ?? '';  // User updating the announcement
$previousImages = $_POST['previous_image'] ?? [];  // Array of previous images
$removedImages = $_POST['removed_images'] ?? '';  // Images marked for deletion
$newImages = $_FILES['new_image']['name'] ?? [];  // New images uploaded
$added = $_POST['added_image'] ?? [];  // Added images uploaded
$date = date('Y-m-d H:i:s');

// Log POST and FILES data for troubleshooting
error_log('POST Data: ' . print_r($_POST, true));
error_log('FILES Data: ' . print_r($_FILES, true));

// Define arrays to keep track of replaced, kept, and added images
$replacedImages = [];
$addedImages = [];  // Array to track newly added images
$keptImages = $previousImages;  // Initially, keep all previous images

// Determine which images are being replaced
foreach ($previousImages as $index => $prevImage) {
    if (!empty($newImages[$index])) {  // If there is a new image at the same index
        $replacedImages[] = $prevImage;  // Mark old image as replaced
        $keptImages[$index] = $newImages[$index];  // Update the kept images with the new one
        $addedImages[] = $added[$index] ?? '';  // Add the new image to addedImages, ensure the index exists
    }
}

// Log replaced, kept, and added images
error_log('Replaced Images: ' . print_r($replacedImages, true));
error_log('Kept Images (updated previous images): ' . print_r($keptImages, true));
error_log('Added Images: ' . print_r($addedImages, true));

// Convert removed_images string to array
$removedImagesArray = array_filter(explode(',', $removedImages));

// Log removed images array for verification
error_log('Removed Images Array: ' . print_r($removedImagesArray, true));

// Directory path for uploaded images
$uploadTo = __DIR__ . "/../../uploaded/annUploaded/";
if (!file_exists($uploadTo)) {
    mkdir($uploadTo, 0777, true);
}

// Handle image replacements: Remove old images from database and server, then upload new ones
foreach ($replacedImages as $oldImage) {
    // Delete the old image from the server
    $imagePath = $uploadTo . $oldImage;
    if (file_exists($imagePath)) {
        if (unlink($imagePath)) {
            error_log("Successfully deleted image: " . $oldImage);
        } else {
            error_log("Failed to delete image: " . $oldImage);
        }
    } else {
        error_log("File does not exist: " . $oldImage);
    }

    // Remove the old image entry from the database
    $deleteImageQuery = "DELETE FROM announcement_images WHERE announcement_id = :aid AND image_path = :image";
    $deleteImageStmt = $connect->prepare($deleteImageQuery);
    $deleteImageStmt->execute([':aid' => $aid, ':image' => $oldImage]);
}

// Upload and handle new images
if (!empty($newImages)) {
    foreach ($newImages as $index => $fileName) {
        if ($_FILES['new_image']['error'][$index] === UPLOAD_ERR_OK) {
            $tempPath = $_FILES["new_image"]["tmp_name"][$index];
            $originalPath = $uploadTo . basename($fileName);

            if (move_uploaded_file($tempPath, $originalPath)) {
                // Insert the new image into the database
                $image_sql = "INSERT INTO announcement_images (announcement_id, image_path) VALUES (:aid, :image)";
                $image_stmt = $connect->prepare($image_sql);
                $image_stmt->execute([':aid' => $aid, ':image' => basename($fileName)]);
            } else {
                error_log("Failed to upload new image: " . $fileName);
            }
        } else {
            error_log("Error uploading image index {$index}: " . $_FILES['new_image']['error'][$index]);
        }
    }
}

// Process and remove images from the server and database
if (!empty($removedImagesArray)) {
    foreach ($removedImagesArray as $oldImage) {
        $imagePath = $uploadTo . $oldImage;

        // Check if file exists before attempting to delete
        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                // Successfully deleted, now remove from database
                $deleteImageQuery = "DELETE FROM announcement_images WHERE announcement_id = :aid AND image_path = :image";
                $deleteImageStmt = $connect->prepare($deleteImageQuery);
                $deleteImageStmt->execute([':aid' => $aid, ':image' => $oldImage]);
            } else {
                error_log("Failed to delete file: " . $oldImage);
            }
        } else {
            error_log("File does not exist: " . $oldImage);
        }
    }
} else {
    error_log("No images to remove.");
}

// Update the announcement details in the database
$sql = "UPDATE `announcement_tbl` SET announcement_details = :details, updated_at = :date, updated_by = :update WHERE announcement_id = :aid";
$stmt = $connect->prepare($sql);
$stmt->execute([':details' => $details, ':date' => $date, ':update' => $update, ':aid' => $aid]);

// Check for errors during the announcement update
if ($stmt->errorCode() != '00000') {
    $response['message'] = 'Error updating announcement: ' . implode(', ', $stmt->errorInfo());
    echo json_encode($response);
    exit;
}

// Success response
// Success response
$response['success'] = true;
$response['message'] = 'Announcement updated successfully';
echo json_encode($response);
exit;  // Ensure no further code is executed after success


        }
        elseif ($type === 'event') {
            $cid = $_POST['cid'] ?? '';
            $details = $_POST['event_details'] ?? '';
            $update = $_POST['event_editor'] ?? '';
            $start_date = $_POST['event_start_date'] ?? '';  // Changed to reflect the start date field
            $end_date = $_POST['event_end_date'] ?? '';  // New field for end date
            
            try {
                // Update event in the database
                $sql = "UPDATE `calendar_tbl` 
                        SET calendar_details = :details, 
                            calendar_start_date = :start_date,
                            calendar_end_date = :end_date,
                            updated_by = :update,
                            updated_at = NOW()  -- Set updated_at to the current timestamp
                        WHERE calendar_id = :cid";
                
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':details' => $details,
                    ':start_date' => $start_date,  // Bind the new start date
                    ':end_date' => $end_date,  // Bind the new end date
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
        
                // Success response
                $response = [
                    'success' => true,
                    'message' => 'Event updated successfully.'
                ];
        
            } catch (Exception $e) {
                // Error handling
                $response = [
                    'success' => false,
                    'message' => 'There was an error updating the event: ' . $e->getMessage()
                ];
            }
        
            // Output the response as JSON
            echo json_encode($response);
            exit; // Make sure to terminate after sending the response
        }
        
        
        if ($type === 'faculty') {
            // Fetch and sanitize basic data
            $fid = isset($_POST['fid']) ? (int)$_POST['fid'] : 0;
            $name = isset($_POST['faculty_name']) ? filter_var($_POST['faculty_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
            $specialization = isset($_POST['specialization']) ? filter_var($_POST['specialization'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
            $consultationTime = isset($_POST['consultation_time']) ? filter_var($_POST['consultation_time'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
            $previousImage = isset($_POST['previous']) ? $_POST['previous'] : '';
            $editor_id = isset($_POST['editor_id']) ? (int)$_POST['editor_id'] : 0;
            $addedDepartments = isset($_POST['addedDepartments']) ? json_decode($_POST['addedDepartments'], true) : [];
            $newImage = $previousImage ?: '';
            
            // Check for duplicate faculty member
            $duplicate_check_sql = "SELECT COUNT(*) FROM faculty_tbl WHERE faculty_name = :name AND faculty_id != :fid";
            $duplicate_stmt = $connect->prepare($duplicate_check_sql);
            $duplicate_stmt->execute([':name' => $name, ':fid' => $fid]);
            
            if ($duplicate_stmt->fetchColumn() > 0) {
                $response['success'] = false;
                $response['message'] = 'A faculty member with the same name already exists.';
                header('Content-Type: application/json');
                echo json_encode($response);
                ob_end_clean();
                exit;
            }
        
            // Handle image upload (code omitted for brevity)
        
            // Update faculty details
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
        
            // Step 1: Fetch current departments associated with the faculty
            $getCurrentDepartmentsSql = "SELECT department_id FROM faculty_departments_tbl WHERE faculty_id = :fid";
            $getCurrentDepartmentsStmt = $connect->prepare($getCurrentDepartmentsSql);
            $getCurrentDepartmentsStmt->execute([':fid' => $fid]);
            $currentDepartments = $getCurrentDepartmentsStmt->fetchAll(PDO::FETCH_COLUMN);
        
            // Step 2: Collect department IDs from POST data with preg_replace
            $departmentIds = [];
            foreach ($_POST as $key => $value) {
                if (preg_match('/^department_\d+$/', $key)) {
                    $departmentIds[] = (int)$value;  // Collect department IDs based on pattern match
                }
            }
        
            // Calculate the added and removed departments
            $departmentsToAdd = array_diff($departmentIds, $currentDepartments);
            $departmentsToRemove = array_diff($currentDepartments, $departmentIds);
        
            // Log changes (for debugging)
            error_log('Departments to add: ' . json_encode($departmentsToAdd));
            error_log('Departments to remove: ' . json_encode($departmentsToRemove));
        
            // Insert new departments
            foreach ($departmentsToAdd as $departmentId) {
                $insertDeptSql = "INSERT INTO faculty_departments_tbl (faculty_id, department_id) VALUES (:fid, :department_id)";
                $insertDeptStmt = $connect->prepare($insertDeptSql);
                $insertDeptStmt->execute([':fid' => $fid, ':department_id' => $departmentId]);
            }
        
            // Remove old departments
            if (!empty($departmentsToRemove)) {
                $deleteDeptSql = "DELETE FROM faculty_departments_tbl WHERE faculty_id = :fid AND department_id IN (" . implode(',', array_map('intval', $departmentsToRemove)) . ")";
                $deleteDeptStmt = $connect->prepare($deleteDeptSql);
                $deleteDeptStmt->execute([':fid' => $fid]);
            }
        
            // Fetch editor's name for the audit trail
            $editor_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
            $editor_stmt->execute([':editor_id' => $editor_id]);
            $editor_name = $editor_stmt->fetchColumn();
            
            if (!$editor_name) {
                $editor_stmt = $connect->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
                $editor_stmt->execute([':editor_id' => $editor_id]);
                $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
            }
        
            // Audit trail
            $audit_message = "{$editor_name} updated faculty member: Name - {$name}, Specialization - {$specialization}, Consultation Time - {$consultationTime}";
            $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
            $audit_stmt->execute([':message' => $audit_message]);
        
            // Final response
            $response['success'] = true;
            $response['message'] = 'Faculty member updated successfully.';
            header('Content-Type: application/json');
            echo json_encode($response);
            ob_end_clean();
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