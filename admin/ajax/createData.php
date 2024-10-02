<?php
include "../../class/connection.php"; // Ensure this path is correct

// Enable error reporting and logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Debugging: Log POST and FILES data
error_log('POST Data: ' . print_r($_POST, true));
error_log('FILES Data: ' . print_r($_FILES, true));

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? null;

    // Debugging: Log the type parameter
    error_log('Type parameter: ' . $type);

    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($type === 'announcement') {
            $id = $_POST['id'] ?? null;
            $uid = $_POST['uid'] ?? null;
            $details = $_POST['announcement_details'] ?? null;
            $date = date('Y-m-d H:i:s');
            $date2 = time();
            $imagePath = "";

            if (isset($_FILES['ann_img']) && $_FILES['ann_img']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/annUploaded/";
                if (!file_exists($uploadTo)) {
                    if (mkdir($uploadTo, 0777, true)) {
                        error_log('Announcement directory created successfully.');
                    } else {
                        error_log('Failed to create announcement directory.');
                        $response['message'] = 'Failed to create upload directory.';
                        echo json_encode($response);
                        exit;
                    }
                }

                $imagePath = $date2 . "_" . basename($_FILES['ann_img']['name']);
                $tempPath = $_FILES["ann_img"]["tmp_name"];
                $originalPath = $uploadTo . $imagePath;

                // Debugging: Log file paths
                error_log('Announcement Temp Path: ' . $tempPath);
                error_log('Announcement Original Path: ' . $originalPath);

                if (move_uploaded_file($tempPath, $originalPath)) {
                    if ($id) {
                        // Update existing announcement
                        $sql = "UPDATE `announcement_tbl` 
                                SET announcement_details = :details, announcement_creator = :uid, announcement_image = :imagePath, updated_at = :date
                                WHERE announcement_id = :id";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':details' => $details,
                            ':uid' => $uid,
                            ':imagePath' => $imagePath,
                            ':date' => $date,
                            ':id' => $id
                        ]);
                    } else {
                        // Insert new announcement
                        $sql = "INSERT INTO `announcement_tbl` (announcement_details, announcement_creator, announcement_image, created_at, updated_at) 
                                VALUES (:details, :uid, :imagePath, :date, :date)";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':details' => $details,
                            ':uid' => $uid,
                            ':imagePath' => $imagePath,
                            ':date' => $date
                        ]);
                    }

                    $response['success'] = true;
                    $response['message'] = $id ? 'Announcement updated successfully.' : 'Announcement added successfully.';
                } else {
                    $response['message'] = 'Announcement file upload failed to move.';
                }
            } else {
                if ($id) {
                    // Update existing announcement without image
                    $sql = "UPDATE `announcement_tbl` 
                            SET announcement_details = :details, announcement_creator = :uid, updated_at = :date
                            WHERE announcement_id = :id";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':details' => $details,
                        ':uid' => $uid,
                        ':date' => $date,
                        ':id' => $id
                    ]);
                } else {
                    // Insert new announcement without image
                    $sql = "INSERT INTO `announcement_tbl` (announcement_details, announcement_creator, created_at, updated_at) 
                            VALUES (:details, :uid, :date, :date)";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':details' => $details,
                        ':uid' => $uid,
                        ':date' => $date
                    ]);
                }

                $response['success'] = true;
                $response['message'] = $id ? 'Announcement updated successfully.' : 'Announcement added successfully.';
            }

        } elseif ($type === 'event') {
            $details = $_POST['event_details'] ?? null;
            $date = $_POST['event_date'] ?? null;
            $creator = $_POST['uid'] ?? null; // Get the event creator from the input
        
            // Adjust the SQL to include event_creator
            $sql = "INSERT INTO `calendar_tbl` (calendar_date, calendar_details, event_creator) VALUES (:date, :details, :creator)";
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':date' => $date,
                ':details' => $details,
                ':creator' => $creator // Bind the creator value
            ]);
        
            $response['success'] = true;
            $response['message'] = 'Event added successfully.';
        }
        elseif ($type === 'faqs') {
            $question = $_POST['faqs_question'] ?? null;
            $answer = $_POST['faqs_answer'] ?? null;

            if ($question && $answer) {
                $sql = "INSERT INTO `faqs_tbl` (faqs_question, faqs_answer) VALUES (:question, :answer)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':question' => $question,
                    ':answer' => $answer
                ]);

                $response['success'] = true;
                $response['message'] = 'FAQ added successfully.';
            } else {
                $response['message'] = 'Question and answer are required.';
            }

        }elseif ($type === 'faculty') {
            $name = $_POST['faculty_name'] ?? null;
            $dept = $_POST['department'] ?? null;
            $imagePath = '';

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

                $sql = "INSERT INTO `faculty_tbl` (faculty_name, faculty_dept, faculty_image) VALUES (:name, :dept, :image)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':dept' => $dept,
                    ':image' => $imagePath
                ]);
            } else {
                $sql = "INSERT INTO `faculty_tbl` (faculty_name, faculty_dept) VALUES (:name, :dept)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':dept' => $dept
                ]);
            }

            $response['success'] = true;
            $response['message'] = 'Faculty member added successfully.';

        } elseif ($type === 'organization') {
            $name = $_POST['org_name'] ?? null;
            $imagePath = '';

            if (isset($_FILES['org_image']) && $_FILES['org_image']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/orgUploaded/";

                if (!file_exists($uploadTo) && !mkdir($uploadTo, 0777, true)) {
                    $response['message'] = 'Failed to create upload directory.';
                    echo json_encode($response);
                    exit;
                }

                $newImage = $name . "_" . $_FILES['org_image']['name'];
                $tempPath = $_FILES["org_image"]["tmp_name"];
                $basename = basename($newImage);
                $originalPath = $uploadTo . $basename;

                // Debugging: Log file paths
                error_log('Organization Temp Path: ' . $tempPath);
                error_log('Organization Original Path: ' . $originalPath);

                if (move_uploaded_file($tempPath, $originalPath)) {
                    $sql = "INSERT INTO `organization_tbl` (org_name, org_image) VALUES (:name, :image)";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':name' => $name,
                        ':image' => $basename
                    ]);

                    $response['success'] = true;
                    $response['message'] = 'Organization added successfully.';
                } else {
                    $response['message'] = 'Organization file upload failed to move.';
                }
            } else {
                $sql = "INSERT INTO `organization_tbl` (org_name) VALUES (:name)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':name' => $name
                ]);

                $response['success'] = true;
                $response['message'] = 'Organization added successfully without an image.';
            }

        } elseif ($type === 'account') {
            $user_type = $_POST['user_type'] ?? '2'; // Default to '2' (standard user) if not provided
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $org = $_POST['org'] ?? null;

            // Initialize an array to collect validation errors
            $errors = [];

            // Validate username and password
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

            // If there are validation errors, return them all at once
            if (!empty($errors)) {
                $response['success'] = false;
                $response['message'] = implode('<br>', $errors);
                echo json_encode($response);
                exit;
            }

            // Debugging: Log the account creation parameters
            error_log('Account Creation - Username: ' . $username);
            error_log('Account Creation - User Type: ' . $user_type);

            // Hash the password using SHA-256
            $hashedPassword = hash('sha256', $password);

            try {
                $sql = "INSERT INTO `users_tbl` (users_username, users_password, users_type, users_org) VALUES (:username, :password, :user_type, :org)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':user_type' => $user_type,
                    ':org' => $org
                ]);

                $response['success'] = true;
                $response['message'] = 'Account created successfully.';
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                $response['success'] = false;
                $response['message'] = 'An error occurred while processing your request.';
            }

        } elseif ($type === 'membersaccount') {
    // Determine user type based on position
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $position = $_POST['position'] ?? null; 
    $org = $_POST['org'] ?? null;
    $name = $_POST['name'] ?? null; // Get the name from the form submission

    // Initialize an array to collect validation errors
    $errors = [];
    if ($position === "President" || $position === "Secretary") {
        $user_type = '2'; // Set user type to '2' for President or Secretary
    } else {
        $user_type = '3'; // Default to '3' (standard user) for other positions
    } // Default to '3' for member type

    // Validate username, password, and name
    if ($name === null || empty(trim($name))) {
        $errors[] = 'Name is required.'; // Validate the name
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

    // Debugging: Log the account creation parameters
    error_log('Account Creation - Name: ' . $name); // Log the name
    error_log('Account Creation - Username: ' . $username);
    error_log('Account Creation - User Type: ' . $user_type);
    error_log('Account Creation - Position: ' . $position); // Log the position

    // Hash the password using SHA-256
    $hashedPassword = hash('sha256', $password);

    try {
        // Update SQL to match your database structure
        $sql = "INSERT INTO `orgmembers_tbl` (name, username, password, users_type, position, org_type) VALUES (:name, :username, :password, :user_type, :position, :org)";
        $stmt = $connect->prepare($sql);

        $stmt->execute([
            ':name' => $name, // Insert the name
            ':username' => $username,
            ':password' => $hashedPassword,
            ':user_type' => $user_type,
            ':position' => $position,
            ':org' => $org // Assuming this is the correct field for organization type
        ]);

        $response['success'] = true;
        $response['message'] = 'Account created successfully.';
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        $response['success'] = false;
        $response['message'] = 'An error occurred while processing your request.';
    }
}

    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        $response['message'] = 'An error occurred while processing your request.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>