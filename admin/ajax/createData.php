
<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1); // Display errors on the page for debugging
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/error_log.txt'); // Specify the path for the error log

include "../../class/connection.php"; // Include your database connection
require __DIR__ . '/vendor/autoload.php'; // Adjust the path as needed
use PhpOffice\PhpSpreadsheet\IOFactory;

$response = ['success' => false, 'message' => 'Error!']; // Initialize the response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? null;

    // Debugging: Log the type parameter
    error_log('Type parameter: ' . $type);

    try { 
        if ($type === 'announcement') {
            $id = $_POST['id'] ?? null; // Existing announcement ID (if updating)
            $uid = $_POST['uid'] ?? null; // User ID from session
            $cid = $_POST['cid'] ?? null; // Creator ID from session
            $title = $_POST['announcement_title'] ?? null; // Announcement title
            $details = $_POST['announcement_details'] ?? null; // Announcement details
    
            // Set the timezone
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d H:i:s');
    
            $response = ['success' => false, 'message' => ''];
    
            // Directory for uploaded images
            $uploadTo = __DIR__ . "/../../uploaded/annUploaded/";
            if (!file_exists($uploadTo) && !mkdir($uploadTo, 0777, true)) {
                error_log('Failed to create announcement directory.');
                $response['message'] = 'Failed to create upload directory.';
                echo json_encode($response);
                exit;
            }
    
            try {
                // Insert or update the main announcement record
                if ($id) {
                    $sql = "UPDATE `announcement_tbl` 
                            SET announcement_title = :title, 
                                announcement_details = :details, 
                                announcement_creator = :uid, 
                                updated_at = :date, 
                                created_by = :cid
                            WHERE announcement_id = :id";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':details' => $details,
                        ':uid' => $uid,
                        ':date' => $date,
                        ':cid' => $cid,
                        ':id' => $id
                    ]);
                } else {
                    $sql = "INSERT INTO `announcement_tbl` 
                            (announcement_title, announcement_details, announcement_creator, created_at, updated_at, created_by) 
                            VALUES (:title, :details, :uid, :date, :date, :cid)";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':details' => $details,
                        ':uid' => $uid,
                        ':date' => $date,
                        ':cid' => $cid
                    ]);
                    $id = $connect->lastInsertId();
                }
    
                // Image upload logic
                if (isset($_FILES['ann_img']['name']) && is_array($_FILES['ann_img']['name'])) {
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    
                    // Image counter for naming
                    $imageCounter = 1; 
    
                    foreach ($_FILES['ann_img']['name'] as $index => $imageName) {
                        $fileTmpName = $_FILES['ann_img']['tmp_name'][$index];
                        $fileSize = $_FILES['ann_img']['size'][$index];
                        $fileMimeType = mime_content_type($fileTmpName);
    
                        // Check mime type and file size
                        if (in_array($fileMimeType, $allowedMimeTypes) && $fileSize <= $maxFileSize) {
                            // Sanitize the title to create a valid filename
                            $titleSanitized = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($title)); // Clean title
                            
                            // Generate a unique filename using the specified format
                            $imagePath = "{$titleSanitized}_img{$imageCounter}." . pathinfo($imageName, PATHINFO_EXTENSION);
                            $originalPath = $uploadTo . $imagePath;
    
                            if (move_uploaded_file($fileTmpName, $originalPath)) {
                                // Insert each image path into the announcement_images table
                                $imageSql = "INSERT INTO `announcement_images` (announcement_id, image_path, uploaded_at) 
                                             VALUES (:announcement_id, :image_path, :uploaded_at)";
                                $imageStmt = $connect->prepare($imageSql);
                                $imageStmt->execute([
                                    ':announcement_id' => $id,
                                    ':image_path' => $imagePath,
                                    ':uploaded_at' => $date
                                ]);
    
                                // Log success for each file
                                error_log("Image uploaded and saved: " . $imagePath);
                            } else {
                                error_log("Failed to move uploaded file: " . $imagePath);
                            }
                        } else {
                            error_log("Invalid file type or size for file: " . $imageName);
                        }
                        // Increment the counter for the next image
                        $imageCounter++;
                    }
                }
    
                // Fetch creator's name
                $creator_stmt = $connect->prepare("SELECT users_username FROM users_tbl WHERE users_id = :cid");
                $creator_stmt->execute([':cid' => $cid]);
                $creators_name = $creator_stmt->fetchColumn() ?: 'Unknown User';
    
                // Audit trail
                $audit_message = "{$creators_name} created an announcement: {$details}";
                $audit_stmt = $connect->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
                $audit_stmt->execute([':message' => $audit_message]);
    
                $response['success'] = true;
                $response['message'] = $id ? 'Announcement updated successfully.' : 'Announcement added successfully.';
    
            } catch (PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                $response['message'] = 'Database operation failed.';
            }
    
            echo json_encode($response);
        }
        
        elseif ($type === 'event') {
            $details = $_POST['event_details'] ?? null;
            $date = $_POST['event_date'] ?? null;
            $creator = $_POST['uid'] ?? null;
            $ecreator = $_POST['aid'] ?? null; // Get the event creator ID
        
            $response = ['success' => false, 'message' => ''];
        
            try {
                // Insert event into calendar_tbl
                $sql = "INSERT INTO `calendar_tbl` (calendar_date, calendar_details, event_creator, created_by) 
                        VALUES (:date, :details, :creator, :ecreator)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':date' => $date,
                    ':details' => $details,
                    ':creator' => $creator,
                    ':ecreator' => $ecreator
                ]);
        
                // Fetch the creator's name from users_tbl
                $creator_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :ecreator";
                $creator_stmt = $connect->prepare($creator_name_sql);
                $creator_stmt->execute([':ecreator' => $ecreator]);
                $creators_name = $creator_stmt->fetchColumn();
        
                // If not found, check orgmembers_tbl
                if (!$creators_name) {
                    $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :ecreator";
                    $org_member_stmt = $connect->prepare($org_member_sql);
                    $org_member_stmt->execute([':ecreator' => $ecreator]);
                    $creators_name = $org_member_stmt->fetchColumn();
                }
        
                // If no name found, default to 'Unknown User'
                $creators_name = $creators_name ?: 'Unknown User';
        
                // Add entry to audit trail
                $audit_message = "{$creators_name} created an event: {$details} on {$date}";
                $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                $audit_stmt = $connect->prepare($audit_sql);
                $audit_stmt->execute([':message' => $audit_message]);
        
                $response['success'] = true;
                $response['message'] = 'Event added successfully.';
            } catch (PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                $response['message'] = 'Failed to add event due to a database error.';
            }
        
            echo json_encode($response);
        }
        
        elseif ($type === 'faqs') {
            $question = $_POST['faqs_question'] ?? null;
            $answer = $_POST['faqs_answer'] ?? null;
            $id = $_POST['id'] ?? null; // Existing FAQ ID (if updating)
            $uid = $_POST['uid'] ?? null; // User ID from session
            $cid = $_POST['cid'] ?? null; // Creator ID from session
        
            $response = ['success' => false, 'message' => ''];
        
            if ($question && $answer) {
                try {
                    if ($id) {
                        // Update existing FAQ
                        $sql = "UPDATE `faqs_tbl` SET faqs_question = :question, faqs_answer = :answer WHERE id = :id";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':question' => $question,
                            ':answer' => $answer,
                            ':id' => $id
                        ]);
                        $action = 'updated';
                    } else {
                        // Insert new FAQ
                        $sql = "INSERT INTO `faqs_tbl` (faqs_question, faqs_answer) VALUES (:question, :answer)";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':question' => $question,
                            ':answer' => $answer
                        ]);
                        $action = 'added';
                    }
        
                    // Fetch the creator's name from users_tbl
                    $creator_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :cid";
                    $creator_stmt = $connect->prepare($creator_name_sql);
                    $creator_stmt->execute([':cid' => $cid]);
                    $creators_name = $creator_stmt->fetchColumn();
        
                    // If not found, check orgmembers_tbl
                    if (!$creators_name) {
                        $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :cid";
                        $org_member_stmt = $connect->prepare($org_member_sql);
                        $org_member_stmt->execute([':cid' => $cid]);
                        $creators_name = $org_member_stmt->fetchColumn();
                    }
        
                    // If no name found, default to 'Unknown User'
                    $creators_name = $creators_name ?: 'Unknown User';
        
                    // Add to audit trail with creator ID
                    $audit_message = "{$creators_name} {$action} a FAQ: Question - {$question}";
                    $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                    $audit_stmt = $connect->prepare($audit_sql);
                    $audit_stmt->execute([':message' => $audit_message]);
        
                    $response['success'] = true;
                    $response['message'] = $id ? 'FAQ updated successfully.' : 'FAQ added successfully.';
                } catch (PDOException $e) {
                    error_log("Database Error: " . $e->getMessage());
                    $response['message'] = 'Failed to save FAQ due to a database error.';
                }
            } else {
                $response['message'] = 'Question and answer are required.';
            }
        
            echo json_encode($response);
        }
        if ($type === 'faculty') {
            $name = $_POST['faculty_name'] ?? null;
            $dept = $_POST['department'] ?? null;
            $specialization = $_POST['specialization'] ?? null;
            $consultationTime = $_POST['consultation_time'] ?? null;
            $imagePath = '';
        
            $uid = $_POST['uid'] ?? null; // User ID from session
            $cid = $_POST['cid'] ?? null; // Creator ID from session
        
            // Initialize creators_name to 'Unknown User'
            $creators_name = 'Unknown User';
        
            // Fetch the creator's name from users_tbl
            $creator_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :cid";
            $creator_stmt = $connect->prepare($creator_name_sql);
            $creator_stmt->execute([':cid' => $cid]);
            $creators_name = $creator_stmt->fetchColumn();
        
            // If not found, check orgmembers_tbl
            if (!$creators_name) {
                $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :cid";
                $org_member_stmt = $connect->prepare($org_member_sql);
                $org_member_stmt->execute([':cid' => $cid]);
                $creators_name = $org_member_stmt->fetchColumn();
            }
        
            // If no name found, default to 'Unknown User'
            $creators_name = $creators_name ?: 'Unknown User';
        
            // Restricted department IDs that should not allow duplicates but update existing records
            $restrictedDeptIds = [5, 6, 7, 8, 9, 10, 11, 12, 13];
        
            // Check for duplicate faculty member
            $duplicateCheckQuery = $connect->prepare("SELECT faculty_id FROM faculty_tbl WHERE faculty_name = :name AND faculty_dept = :dept");
            $duplicateCheckQuery->execute([':name' => $name, ':dept' => $dept]);
            $existingFaculty = $duplicateCheckQuery->fetch(PDO::FETCH_ASSOC);
        
            if ($existingFaculty) {
                $response['success'] = false;
                $response['message'] = 'Faculty member already exists in this department.';
                echo json_encode($response);
                exit;
            }
        
            // Existing faculty ID (if updating)
            $id = $_POST['id'] ?? null;
        
            // If no existing faculty member in the restricted department, insert a new one
            if (isset($_FILES['faculty_image']) && $_FILES['faculty_image']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/facultyUploaded/";
        
                if (!file_exists($uploadTo) && !mkdir($uploadTo, 0777, true)) {
                    $response['message'] = 'Failed to create upload directory.';
                    echo json_encode($response);
                    exit;
                }
        
                $imagePath = basename($_FILES['faculty_image']['name']);
                $tempPath = $_FILES["faculty_image"]["tmp_name"];
                $originalPath = $uploadTo . $imagePath;
        
                if (!move_uploaded_file($tempPath, $originalPath)) {
                    $response['message'] = 'Failed to move uploaded file.';
                    echo json_encode($response);
                    exit;
                }
        
                $sql = "INSERT INTO `faculty_tbl` (faculty_name, faculty_dept, faculty_image, specialization, consultation_time) VALUES (:name, :dept, :image, :specialization, :consultation_time)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':dept' => $dept,
                    ':image' => $imagePath,
                    ':specialization' => $specialization,
                    ':consultation_time' => $consultationTime
                ]);
        
                // Add to audit trail for new faculty addition
                $audit_message = "{$creators_name} added a new faculty member: Name - {$name}, Department ID - {$dept}";
                $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                $audit_stmt = $connect->prepare($audit_sql);
                $audit_stmt->execute([':message' => $audit_message]);
        
            } else {
                $sql = "INSERT INTO `faculty_tbl` (faculty_name, faculty_dept, specialization, consultation_time) VALUES (:name, :dept, :specialization, :consultation_time)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':dept' => $dept,
                    ':specialization' => $specialization,
                    ':consultation_time' => $consultationTime
                ]);
        
                // Add to audit trail for new faculty addition without an image
                $audit_message = "{$creators_name} added a new faculty member: Name - {$name}, Department ID - {$dept}";
                $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                $audit_stmt = $connect->prepare($audit_sql);
                $audit_stmt->execute([':message' => $audit_message]);
            }
        
            $response['success'] = true;
            $response['message'] = 'Faculty member added successfully.';
            echo json_encode($response);
            exit;
        }
        elseif ($type === 'organization') {
            $name = $_POST['org_name'] ?? null;
            $imagePath = '';
        
            // Initialize response
            $response = ['success' => false, 'message' => ''];
        
            // Validate organization name
            if (empty($name)) {
                $response['message'] = 'Organization name is required.';
                echo json_encode($response);
                exit;
            }
        
            // Check for duplicate organization name
            try {
                $duplicateCheckSql = "SELECT COUNT(*) FROM `organization_tbl` WHERE org_name = :name";
                $duplicateCheckStmt = $connect->prepare($duplicateCheckSql);
                $duplicateCheckStmt->execute([':name' => $name]);
                $duplicateCount = $duplicateCheckStmt->fetchColumn();
        
                if ($duplicateCount > 0) {
                    $response['message'] = 'The organization name is already taken.';
                    echo json_encode($response);
                    exit;
                }
            } catch (Exception $e) {
                error_log('Error checking for duplicate name: ' . $e->getMessage());
                $response['message'] = 'An error occurred while checking for duplicate organization names.';
                echo json_encode($response);
                exit;
            }
        
            // Get user ID and creator ID from POST data
            $uid = $_POST['uid'] ?? null; // User ID from session
            $cid = $_POST['cid'] ?? null; // Creator ID from session
        
            // Fetch the creator's name from users_tbl
            $creator_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :cid";
            $creator_stmt = $connect->prepare($creator_name_sql);
            $creator_stmt->execute([':cid' => $cid]);
            $creators_name = $creator_stmt->fetchColumn();
        
            // If not found, check orgmembers_tbl
            if (!$creators_name) {
                $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :cid";
                $org_member_stmt = $connect->prepare($org_member_sql);
                $org_member_stmt->execute([':cid' => $cid]);
                $creators_name = $org_member_stmt->fetchColumn();
            }
        
            // If no name found, default to 'Unknown User'
            $creators_name = $creators_name ?: 'Unknown User';
        
            // Process image upload if provided
            if (isset($_FILES['org_image']) && $_FILES['org_image']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/orgUploaded/";
        
                // Ensure upload directory exists
                if (!file_exists($uploadTo) && !mkdir($uploadTo, 0777, true)) {
                    $response['message'] = 'Failed to create upload directory.';
                    echo json_encode($response);
                    exit;
                }
        
                // Define image name and path
                $newImage = $name . "_" . basename($_FILES['org_image']['name']);
                $tempPath = $_FILES["org_image"]["tmp_name"];
                $originalPath = $uploadTo . $newImage;
        
                // Move the uploaded file
                if (move_uploaded_file($tempPath, $originalPath)) {
                    // Insert organization with image
                    try {
                        $sql = "INSERT INTO `organization_tbl` (org_name, org_image) VALUES (:name, :image)";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':name' => $name,
                            ':image' => $newImage
                        ]);
        
                        // Add to audit trail
                        $audit_message = "{$creators_name} added a new organization: Name - {$name}";
                        $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                        $audit_stmt = $connect->prepare($audit_sql);
                        $audit_stmt->execute([':message' => $audit_message]);
        
                        $response['success'] = true;
                        $response['message'] = 'Organization added successfully.';
                    } catch (Exception $e) {
                        error_log('Error inserting organization with image: ' . $e->getMessage());
                        $response['message'] = 'An error occurred while saving the organization with image.';
                    }
                } else {
                    $response['message'] = 'Failed to move uploaded image file.';
                    error_log('Image upload failed: Could not move file to ' . $originalPath);
                }
            } else {
                // Insert organization without image
                try {
                    $sql = "INSERT INTO `organization_tbl` (org_name) VALUES (:name)";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([':name' => $name]);
        
                    // Add to audit trail
                    $audit_message = "{$creators_name} added a new organization: Name - {$name}";
                    $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                    $audit_stmt = $connect->prepare($audit_sql);
                    $audit_stmt->execute([':message' => $audit_message]);
        
                    $response['success'] = true;
                    $response['message'] = 'Organization added successfully without an image.';
                } catch (Exception $e) {
                    error_log('Error inserting organization without image: ' . $e->getMessage());
                    $response['message'] = 'An error occurred while saving the organization.';
                }
            }
        
            echo json_encode($response);
            exit;
        }
        elseif ($type === 'account') {
            $user_type = $_POST['user_type'] ?? '2';
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $org = $_POST['org'] ?? null;
        
            $errors = [];
        
            // Validate username and password
            if ($username === null || empty(trim($username))) {
                $errors[] = 'Username is required.';
            }
        
            if ($password === null || empty(trim($password))) {
                $errors[] = 'Password is required.';
            } else {
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
        
            // Return validation errors, if any
            if (!empty($errors)) {
                $response['success'] = false;
                $response['message'] = implode('<br>', $errors);
                echo json_encode($response);
                exit;
            }
        
            error_log("Duplicate Check Started for Username: $username\n", 3, __DIR__ . '/error_log.txt');
        
            try {
                // Check for duplicate username
                $checkSql = "SELECT COUNT(*) FROM `users_tbl` WHERE users_username = :username";
                $checkStmt = $connect->prepare($checkSql);
                $checkStmt->execute([':username' => $username]);
                $count = $checkStmt->fetchColumn();
        
                if ($count > 0) {
                    $response['success'] = false;
                    $response['message'] = 'Duplicate entry: The username already exists.';
                    echo json_encode($response);
                    exit;
                }
        
                // Get user ID and creator ID from POST data
                $uid = $_POST['uid'] ?? null; // User ID from session
                $cid = $_POST['cid'] ?? null; // Creator ID from session
        
                // Fetch the creator's name from users_tbl
                $creator_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :cid";
                $creator_stmt = $connect->prepare($creator_name_sql);
                $creator_stmt->execute([':cid' => $cid]);
                $creators_name = $creator_stmt->fetchColumn();
        
                // If not found, check orgmembers_tbl
                if (!$creators_name) {
                    $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :cid";
                    $org_member_stmt = $connect->prepare($org_member_sql);
                    $org_member_stmt->execute([':cid' => $cid]);
                    $creators_name = $org_member_stmt->fetchColumn();
                }
        
                // If no name found, default to 'Unknown User'
                $creators_name = $creators_name ?: 'Unknown User';
        
                error_log("Hashing Password for User: $username\n", 3, __DIR__ . '/error_log.txt');
        
                // Hash the password using SHA-256
                $hashedPassword = hash('sha256', $password);
        
                error_log("Inserting Account for User: $username\n", 3, __DIR__ . '/error_log.txt');
        
                // Insert account into database
                $sql = "INSERT INTO `users_tbl` (users_username, users_password, users_type, users_org) VALUES (:username, :password, :user_type, :org)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':user_type' => $user_type,
                    ':org' => $org
                ]);
        
                // Add to audit trail
                $audit_message = "{$creators_name} created an account: Username - {$username}";
                $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                $audit_stmt = $connect->prepare($audit_sql);
                $audit_stmt->execute([':message' => $audit_message]);
        
                // Set the success response
                $response['success'] = true;
                $response['message'] = 'Account created successfully.';
        
            } catch (Exception $e) {
                // Log the exception message
                error_log('Error inserting account: ' . $e->getMessage() . "\n", 3, __DIR__ . '/error_log.txt');
                // Send a generic error message to the response
                $response['success'] = false;
                $response['message'] = 'An error occurred while processing your request. Please try again later.';
            }
        
            // Always return the response
            echo json_encode($response);
        }
        elseif ($type === 'membersaccount') {
            // Gather form inputs
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $position = $_POST['position'] ?? null; 
            $org = $_POST['org'] ?? null;
            $name = $_POST['name'] ?? null;
        
            // Initialize an array to collect validation errors
            $errors = [];
            
            // Determine user type based on position
            if ($position === "President" || $position === "Secretary") {
                $user_type = '2'; // Set user type to '2' for President or Secretary
            } else {
                $user_type = '3'; // Default to '3' (standard user) for other positions
            }
        
            // Validate required fields
            if ($name === null || empty(trim($name))) {
                $errors[] = 'Name is required.';
            }
            if ($username === null || empty(trim($username))) {
                $errors[] = 'Username is required.';
            }
            if ($password === null || empty(trim($password))) {
                $errors[] = 'Password is required.';
            } else {
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
            if ($position === null || empty(trim($position))) {
                $errors[] = 'Position is required.';
            }
        
            // Check for errors
            if (!empty($errors)) {
                $response['success'] = false;
                $response['message'] = implode('<br>', $errors);
                echo json_encode($response);
                exit;
            }
        
            try {
                // Check for duplicate username or name
                $checkSql = "SELECT COUNT(*) FROM `orgmembers_tbl` WHERE `username` = :username OR `name` = :name";
                $checkStmt = $connect->prepare($checkSql);
                $checkStmt->execute([
                    ':username' => $username,
                    ':name' => $name
                ]);
                $count = $checkStmt->fetchColumn();
        
                if ($count > 0) {
                    $response['success'] = false;
                    $response['message'] = 'Username or Name already exists. Please choose a different one.';
                    echo json_encode($response);
                    exit;
                }
        
                // Process image upload
                $member_img = null; // Default to null
                if (isset($_FILES['org_image']) && $_FILES['org_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadTo = __DIR__ . "/../../uploaded/orgUploaded/";
                    if (!file_exists($uploadTo) && !mkdir($uploadTo, 0777, true)) {
                        $response['message'] = 'Failed to create upload directory.';
                        echo json_encode($response);
                        exit;
                    }
                    $newImage = $username . "_" . $_FILES['org_image']['name']; // Use username for unique name
                    $tempPath = $_FILES["org_image"]["tmp_name"];
                    $basename = basename($newImage);
                    $originalPath = $uploadTo . $basename;
        
                    if (move_uploaded_file($tempPath, $originalPath)) {
                        $member_img = $basename; // Set the member_img to the uploaded file name
                    } else {
                        $response['message'] = 'Failed to move uploaded file.';
                        echo json_encode($response);
                        exit;
                    }
                }
        
                // Hash the password using SHA-256
                $hashedPassword = hash('sha256', $password);
        
                // Insert account into database
                $sql = "INSERT INTO `orgmembers_tbl` (name, username, password, users_type, position, org_type, member_img) VALUES (:name, :username, :password, :user_type, :position, :org, :member_img)";
                $stmt = $connect->prepare($sql);
        
                // Execute the statement
                $stmt->execute([
                    ':name' => $name,
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':user_type' => $user_type,
                    ':position' => $position,
                    ':org' => $org,
                    ':member_img' => $member_img // Insert image filename, can be null
                ]);
        
                // Get user ID and creator ID from POST data
                $uid = $_POST['uid'] ?? null; // User ID from session
                $cid = $_POST['cid'] ?? null; // Creator ID from session
        
                // Fetch the creator's name from users_tbl
                $creator_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :cid";
                $creator_stmt = $connect->prepare($creator_name_sql);
                $creator_stmt->execute([':cid' => $cid]);
                $creators_name = $creator_stmt->fetchColumn();
        
                // If not found, check orgmembers_tbl
                if (!$creators_name) {
                    $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :cid";
                    $org_member_stmt = $connect->prepare($org_member_sql);
                    $org_member_stmt->execute([':cid' => $cid]);
                    $creators_name = $org_member_stmt->fetchColumn();
                }
        
                // If no name found, default to 'Unknown User'
                $creators_name = $creators_name ?: 'Unknown User';
        
                // Add to audit trail
                $audit_message = "{$creators_name} created a member account: Username - {$username}";
                $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                $audit_stmt = $connect->prepare($audit_sql);
                $audit_stmt->execute([':message' => $audit_message]);
        
                // Ensure the ID is an even number
                $lastId = $connect->lastInsertId();
                if ($lastId % 2 !== 0) {
                    $newEvenId = $lastId + 1; // Increment to make it even
                    // Update the ID in the database
                    $updateSql = "UPDATE `orgmembers_tbl` SET id = :newEvenId WHERE id = :lastId";
                    $updateStmt = $connect->prepare($updateSql);
                    $updateStmt->execute([
                        ':newEvenId' => $newEvenId,
                        ':lastId' => $lastId,
                    ]);
                }
        
                // Set success response only after all operations are successful
                $response['success'] = true;
                $response['message'] = 'Account created successfully.';
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                $response['success'] = false;
                $response['message'] = 'An error occurred while processing your request.';
            }
        
            echo json_encode($response);
        }
        
        
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        $response['message'] = 'An error occurred while processing your request.';
    }
}if ($type === 'excel_import') {
    // Check if the file is uploaded without errors
    if (isset($_FILES['faculty_excel']) && $_FILES['faculty_excel']['error'] === UPLOAD_ERR_OK) {
        // Define the paths for the temporary and original files
        $tempPath = $_FILES['faculty_excel']['tmp_name'];
        $originalPath = __DIR__ . '/' . basename($_FILES['faculty_excel']['name']);

        // Attempt to move the uploaded file to the desired directory
        if (!move_uploaded_file($tempPath, $originalPath)) {
            error_log("Failed to move uploaded file to $originalPath");
            $response['success'] = false;
            $response['message'] = 'Failed to move uploaded Excel file.';
            echo json_encode($response);
            exit;
        }

        // Load the spreadsheet
        try {
            $spreadsheet = IOFactory::load($originalPath);
            error_log("Spreadsheet loaded successfully.");
        } catch (Exception $e) {
            error_log("Error loading Excel file: " . $e->getMessage());
            $response['success'] = false;
            $response['message'] = 'Error loading the Excel file: ' . $e->getMessage();
            echo json_encode($response);
            exit;
        }

        // Get the data from the active sheet
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $updatedCount = 0;  // Count of updated records

        // Prepare update statement
        $updateStmt = $connect->prepare("UPDATE faculty_tbl SET consultation_time = :consultation_time WHERE faculty_name = :faculty_name");

        // Get user information for audit trail
        $uid = $_POST['uid'] ?? null;
        $cid = $_POST['cid'] ?? null;
        
        // Fetch the updater's name
        $updater_name_sql = "SELECT users_username FROM users_tbl WHERE users_id = :cid";
        $updater_stmt = $connect->prepare($updater_name_sql);
        $updater_stmt->execute([':cid' => $cid]);
        $updater_name = $updater_stmt->fetchColumn();
        
        if (!$updater_name) {
            $org_member_sql = "SELECT name FROM orgmembers_tbl WHERE id = :cid";
            $org_member_stmt = $connect->prepare($org_member_sql);
            $org_member_stmt->execute([':cid' => $cid]);
            $updater_name = $org_member_stmt->fetchColumn();
        }
        
        $updater_name = $updater_name ?: 'Unknown User';

        // Loop through the sheet data
        foreach ($sheetData as $rowIndex => $row) {
            if ($rowIndex === 1) continue; // Skip header row

            // Get and trim faculty name and consultation time
            $faculty_name = trim($row['A'] ?? null);
            $consultation_time = trim($row['C'] ?? null);

            if ($faculty_name && $consultation_time) {
                // Check if the faculty member exists
                $existingDataQuery = $connect->prepare("SELECT consultation_time FROM faculty_tbl WHERE faculty_name = :faculty_name");
                $existingDataQuery->execute([':faculty_name' => $faculty_name]);
                $existingData = $existingDataQuery->fetch(PDO::FETCH_ASSOC);

                if ($existingData) {
                    // Only update if consultation time is different
                    if ($existingData['consultation_time'] !== $consultation_time) {
                        try {
                            $updateStmt->execute([
                                ':faculty_name' => $faculty_name,
                                ':consultation_time' => $consultation_time
                            ]);
                            $updatedCount++;

                            // Add to audit trail
                            $audit_message = "{$updater_name} updated '$faculty_name': New Consultation Time - '$consultation_time'";
                            $audit_sql = "INSERT INTO audit_trail (message) VALUES (:message)";
                            $audit_stmt = $connect->prepare($audit_sql);
                            $audit_stmt->execute([':message' => $audit_message]);

                        } catch (PDOException $e) {
                            error_log('Update error: ' . $e->getMessage());
                            continue; // Skip this record and continue with the next one
                        }
                    }
                }
                // If faculty doesn't exist, silently continue to the next record
            }
        }

        // Set the response message after processing
        $response['success'] = true;
        $response['message'] = "$updatedCount faculty consultation schedules updated successfully.";

    } else {
        // Handle specific upload errors
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
        ];

        $errorCode = $_FILES['faculty_excel']['error'];
        $response['success'] = false;
        $response['message'] = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : 'An unknown error occurred during file upload.';
    }

    // Output the JSON response
    echo json_encode($response);
}
?>
