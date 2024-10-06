<?php
include "../../class/connection.php"; // Adjust the path as needed

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

        if ($type === 'announcement') {
            $aid = $_POST['aid'] ?? '';
            $details = $_POST['announcement_details'] ?? '';
            $update = $_POST['announcement_creator'] ?? '';
            $previousImage = $_POST['previous_image'] ?? '';
            $date = date('Y-m-d H:i:s');
            $image = $previousImage;
    
            // File upload handling for announcement image
            if (isset($_FILES['ann_img']) && $_FILES['ann_img']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/annUploaded/";
                if (!file_exists($uploadTo)) {
                    if (!mkdir($uploadTo, 0777, true)) {
                        error_log('Failed to create announcement directory.');
                        $response['message'] = 'Failed to create upload directory.';
                        echo json_encode($response);
                        exit;
                    }
                }
    
                $image = basename($_FILES['ann_img']['name']);
                $tempPath = $_FILES["ann_img"]["tmp_name"];
                $originalPath = $uploadTo . $image;
    
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
    
            // Update announcement in the database
            $sql = "UPDATE `announcement_tbl` 
            SET announcement_details = :details, 
                announcement_image = :image, 
                updated_at = :date, 
                updated_by = :update
            WHERE announcement_id = :aid";
    
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':details' => $details,
                ':image' => $image,
                ':date' => $date,
                ':update' => $update,
                ':aid' => $aid
            ]);
    
            $response['success'] = true;
            $response['message'] = 'Announcement updated successfully.';
    
        } elseif ($type === 'event') {
            $cid = $_POST['cid'] ?? '';
            $details = $_POST['event_details'] ?? '';
             $update = $_POST['event_creator'] ?? '';
            $date = $_POST['event_date'] ?? '';

            // Update event in the database
            $sql = "UPDATE `calendar_tbl` 
                    SET calendar_details = :details, 
                        calendar_date = :date,
                        updated_by = :update 
                    WHERE calendar_id = :cid";

            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':details' => $details,
                ':date' => $date,
                ':update' => $update,
                ':cid' => $cid
            ]);

            $response['success'] = true;
            $response['message'] = 'Event updated successfully.';
        }
        elseif ($type === 'faculty') {
            $fid = $_POST['fid'] ?? '';
            $name = $_POST['faculty_name'] ?? '';
            $dept = $_POST['department'] ?? '';
            $previousImage = $_POST['previous'] ?? '';
            $specialization = $_POST['specialization'] ?? ''; // Get specialization from POST data
            $consultationTime = $_POST['consultation_time'] ?? ''; // Get consultation time from POST data
            $newImage = $previousImage;
        
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
        
            // Update faculty in the database
            $sql = "UPDATE `faculty_tbl` 
                    SET faculty_name = :name, faculty_dept = :dept, faculty_image = :image, 
                        specialization = :specialization, consultation_time = :consultation_time
                    WHERE faculty_id = :fid";
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':dept' => $dept,
                ':image' => $newImage,
                ':specialization' => $specialization, // Include specialization
                ':consultation_time' => $consultationTime, // Include consultation time
                ':fid' => $fid
            ]);
        
            $response['success'] = true;
            $response['message'] = 'Faculty member updated successfully.';
        }
         elseif ($type === 'organization') {
            $orgId = $_POST['org_id'] ?? '';
            $orgName = $_POST['org_name'] ?? '';
            $previousImage = $_POST['previous_image'] ?? '';
            $newImage = $previousImage; // Default to previous image

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

            $response['success'] = true;
            $response['message'] = 'Organization updated successfully.';
        } elseif ($type === 'faq') {
            $fid = $_POST['fid'] ?? '';
            $question = htmlspecialchars_decode($_POST['faqs_question'] ?? '');
            $answer = htmlspecialchars_decode($_POST['faqs_answer'] ?? '');

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

            $response['success'] = true;
            $response['message'] = 'FAQ updated successfully.';
        } elseif ($type === 'account') {
            // Fetch existing user data
            $sql = 'SELECT users_password FROM users_tbl WHERE users_id = :uid';
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $existingPasswordHash = $stmt->fetchColumn();

                // Validate password if a new one is provided
                if (!empty($password)) {
                    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>_]/', $password)) {
                        $response['success'] = false;
                        $response['message'] = 'Password must contain at least one uppercase letter and one special character.';
                        echo json_encode($response);
                        exit;
                    }
                
                    $hashedPassword = hash('sha256', $password);
                } else {
                    $hashedPassword = $existingPasswordHash;
                }

                // Update the account details in the database
                $updateSql = "UPDATE users_tbl 
                SET users_username = :username, users_password = :password, users_org = :org
                WHERE users_id = :uid";
                $stmt = $connect->prepare($updateSql);
                
                // Debug: Log query and parameters
                error_log("Executing query: " . $updateSql);
                error_log("Parameters: Username = $username, Password = $hashedPassword, Org = $org, UID = $uid");
                
                $success = $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':org' => $org,
                    ':uid' => $uid
                ]);
                
                if ($success) {
                    $response['success'] = true;
                    $response['message'] = 'Account updated successfully.';
                } else {
                    $response['message'] = 'Failed to update account.';
                    error_log("Failed to update account for UID = $uid");
                }
            } else {
                $response['message'] = 'User not found.';
            }
        } elseif ($type === 'membersaccount') {
            // Get input values
            $name = $_POST['name'] ?? null;
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $position = $_POST['position'] ?? null; 
            $org = $_POST['org'] ?? null;
            $uid = $_POST['uid'] ?? null; // Assume the UID is sent for updating the member
        
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
                                  SET name =:name , username = :username, password = :password, position = :position, org_type = :org 
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
        
                    $response['success'] = true;
                    $response['message'] = 'Account updated successfully.';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'User not found.';
                }
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                $response['success'] = false;
                $response['message'] = 'An error occurred while processing your request.';
            }
        } else {
            $response['message'] = 'Invalid type specified.';
        }
    } catch (PDOException $e) {
        error_log("PDOException: " . $e->getMessage());
        $response['message'] = 'Database error occurred.';
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        $response['message'] = 'An error occurred.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>