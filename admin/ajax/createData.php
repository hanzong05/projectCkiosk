
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
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($type === 'announcement') {
            $id = $_POST['id'] ?? null; // Existing announcement ID (if updating)
            $uid = $_POST['uid'] ?? null; // User ID from session
            $cid = $_POST['cid'] ?? null; // Creator ID from session
            $details = $_POST['announcement_details'] ?? null; // Announcement details
        
            // Set the timezone
            date_default_timezone_set('Asia/Manila'); // No need for error check since it's common
            // Get the current timestamp
            $date = date('Y-m-d H:i:s');
        
            $imagePath = "";
        
            // Handle file upload if a file was uploaded
            if (isset($_FILES['ann_img']) && $_FILES['ann_img']['error'] === UPLOAD_ERR_OK) {
                $uploadTo = __DIR__ . "/../../uploaded/annUploaded/";
        
                // Create directory if it doesn't exist
                if (!file_exists($uploadTo) && !mkdir($uploadTo, 0777, true)) {
                    error_log('Failed to create announcement directory.');
                    $response['message'] = 'Failed to create upload directory.';
                    echo json_encode($response);
                    exit;
                }
        
                // Generate a unique image name
                $imagePath = time() . "_" . basename($_FILES['ann_img']['name']);
                $tempPath = $_FILES["ann_img"]["tmp_name"];
                $originalPath = $uploadTo . $imagePath;
        
                // Move the uploaded file
                if (move_uploaded_file($tempPath, $originalPath)) {
                    // Prepare SQL statements
                    if ($id) {
                        // Update existing announcement
                        $sql = "UPDATE `announcement_tbl` 
                                SET announcement_details = :details, 
                                    announcement_creator = :uid, 
                                    announcement_image = :imagePath, 
                                    updated_at = :date, 
                                    created_by = :cid
                                WHERE announcement_id = :id";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':details' => $details,
                            ':uid' => $uid,
                            ':imagePath' => $imagePath,
                            ':date' => $date,
                            ':id' => $id,
                            ':cid' => $cid
                        ]);
                    } else {
                        // Insert new announcement
                        $sql = "INSERT INTO `announcement_tbl` 
                                (announcement_details, announcement_creator, 
                                announcement_image, created_at, updated_at, created_by) 
                                VALUES (:details, :uid, :imagePath, :date, :date, :cid)";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([
                            ':details' => $details,
                            ':uid' => $uid,
                            ':imagePath' => $imagePath,
                            ':date' => $date,
                            ':cid' => $cid
                        ]);
                    }
        
                    $response['success'] = true;
                    $response['message'] = $id ? 'Announcement updated successfully.' : 'Announcement added successfully.';
                } else {
                    $response['message'] = 'Announcement file upload failed to move.';
                }
            } else {
                // Handle case where no image is uploaded
                if ($id) {
                    // Update existing announcement without image
                    $sql = "UPDATE `announcement_tbl` 
                            SET announcement_details = :details, 
                                announcement_creator = :uid, 
                                updated_at = :date, 
                                created_by = :cid
                            WHERE announcement_id = :id";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':details' => $details,
                        ':uid' => $uid,
                        ':date' => $date,
                        ':cid' => $cid,
                        ':id' => $id
                    ]);
                } else {
                    // Insert new announcement without image
                    $sql = "INSERT INTO `announcement_tbl` 
                            (announcement_details, announcement_creator, 
                            created_at, updated_at, created_by) 
                            VALUES (:details, :uid, :date, :date, :cid)";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([
                        ':details' => $details,
                        ':uid' => $uid,
                        ':date' => $date,
                        ':cid' => $cid
                    ]);
                }
        
                $response['success'] = true;
                $response['message'] = $id ? 'Announcement updated successfully.' : 'Announcement added successfully.';
            }
        }
        
        // Output the response
        
         elseif ($type === 'event') {
            $details = $_POST['event_details'] ?? null;
            $date = $_POST['event_date'] ?? null;
            $creator = $_POST['uid'] ?? null;
            $ecreator = $_POST['aid'] ?? null; // Get the event creator from the input
        
            // Adjust the SQL to include event_creator
            $sql = "INSERT INTO `calendar_tbl` (calendar_date, calendar_details, event_creator,created_by) VALUES (:date, :details, :creator, :ecreator)";
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':date' => $date,
                ':details' => $details,
                ':ecreator' => $ecreator,
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

        }if ($type === 'faculty') {
            $name = $_POST['faculty_name'] ?? null;
            $dept = $_POST['department'] ?? null;
            $specialization = $_POST['specialization'] ?? null;
            $consultationTime = $_POST['consultation_time'] ?? null;
            $imagePath = '';
        
            // Restricted department IDs that should not allow duplicates but update existing records
            $restrictedDeptIds = [5, 6, 7, 8, 9, 10, 11, 12, 13];
        
            if (in_array($dept, $restrictedDeptIds)) {
                // Check if the department already exists
                $existingDeptQuery = $connect->prepare("SELECT faculty_id FROM faculty_tbl WHERE faculty_dept = :dept");
                $existingDeptQuery->execute([':dept' => $dept]);
                $existingFaculty = $existingDeptQuery->fetch(PDO::FETCH_ASSOC);
        
                if ($existingFaculty) {
                    // Update the existing faculty member's information if the department exists
                    $updateStmt = $connect->prepare("UPDATE faculty_tbl SET faculty_name = :name, specialization = :specialization, consultation_time = :consultation_time WHERE faculty_dept = :dept");
                    $updateStmt->execute([
                        ':name' => $name,
                        ':specialization' => $specialization,
                        ':consultation_time' => $consultationTime,
                        ':dept' => $dept
                    ]);
                    $response['success'] = true;
                    $response['message'] = 'Faculty member information updated successfully.';
                    echo json_encode($response);
                    exit;
                }
            }
        
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
        
            } else {
                $sql = "INSERT INTO `faculty_tbl` (faculty_name, faculty_dept, specialization, consultation_time) VALUES (:name, :dept, :specialization, :consultation_time)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':dept' => $dept,
                    ':specialization' => $specialization,
                    ':consultation_time' => $consultationTime
                ]);
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
                error_log('Error: ' . $e->getMessage());
                $response['message'] = 'An error occurred while checking for duplicate organization names.';
                echo json_encode($response);
                exit;
            }
        
            // Process image upload if provided
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
                    // Insert organization with image
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
                // Insert organization without image
                $sql = "INSERT INTO `organization_tbl` (org_name) VALUES (:name)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([':name' => $name]);
        
                $response['success'] = true;
                $response['message'] = 'Organization added successfully without an image.';
            }
        
            echo json_encode($response);
        }
        elseif ($type === 'account') {
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
        
            // Check for duplicates
            try {
                $checkSql = "SELECT COUNT(*) FROM `users_tbl` WHERE users_username = :username OR users_org = :org";
                $checkStmt = $connect->prepare($checkSql);
                $checkStmt->execute([
                    ':username' => $username,
                    ':org' => $org
                ]);
                $count = $checkStmt->fetchColumn();
        
                if ($count > 0) {
                    $response['success'] = false;
                    $response['message'] = 'Duplicate entry: The username or organization already exists.';
                    echo json_encode($response);
                    exit;
                }
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                $response['success'] = false;
                $response['message'] = 'An error occurred while checking for duplicates.';
                echo json_encode($response);
                exit;
            }
        
            // Hash the password using SHA-256
            $hashedPassword = hash('sha256', $password);
        
            try {
                // Insert account into database
                $sql = "INSERT INTO `users_tbl` (users_username, users_password, users_type, users_org) VALUES (:username, :password, :user_type, :org)";
                $stmt = $connect->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':user_type' => $user_type,
                    ':org' => $org
                ]);
        
                // Get the last inserted ID
                $lastId = $connect->lastInsertId();
        
                // Ensure the ID is an odd number
                if ($lastId % 2 === 0) {
                    $newOddId = $lastId + 1; // Increment to make it odd
                    // Update the ID in the database
                    $updateSql = "UPDATE `users_tbl` SET id = :newOddId WHERE id = :lastId";
                    $updateStmt = $connect->prepare($updateSql);
                    $updateStmt->execute([
                        ':newOddId' => $newOddId,
                        ':lastId' => $lastId,
                    ]);
                }
        
                $response['success'] = true;
                $response['message'] = 'Account created successfully.';
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                $response['success'] = false;
                $response['message'] = 'An error occurred while processing your request.';
            }
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

        // Get the last inserted ID
        $lastId = $connect->lastInsertId();

        // Ensure the ID is an even number
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
} if ($type === 'excel_import') {
    // Check if the file is uploaded without errors
    if (isset($_FILES['faculty_excel']) && $_FILES['faculty_excel']['error'] === UPLOAD_ERR_OK) {
        // Define the paths for the temporary and original files
        $tempPath = $_FILES['faculty_excel']['tmp_name'];
        $originalPath = __DIR__ . '/' . basename($_FILES['faculty_excel']['name']); // Adjust the path

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

        // Define the department mapping
        $deptMapping = [
            'it department' => 1,
            'cs department' => 2,
            'mis department' => 3,
            'mit' => 4,
            'dean' => 5,
            // Add any additional mappings as needed
        ];

        // Get the data from the active sheet
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        error_log("Sheet Data: " . print_r($sheetData, true)); // Log the entire sheet data for review

        $insertedCount = 0; // Count of inserted records
        $updatedCount = 0;  // Count of updated records

        // Prepare statements
        $insertStmt = $connect->prepare("INSERT INTO faculty_tbl (faculty_name, faculty_dept, consultation_time, faculty_image) VALUES (:faculty_name, :faculty_dept, :consultation_time, :faculty_image)");
        $updateStmt = $connect->prepare("UPDATE faculty_tbl SET consultation_time = :consultation_time, faculty_image = :faculty_image WHERE faculty_name = :faculty_name");

        // Loop through the sheet data
        foreach ($sheetData as $rowIndex => $row) {
            if ($rowIndex === 1) continue; // Skip header row

            // Get and trim each column
            $faculty_name = trim($row['A'] ?? null);
            $faculty_dept = strtolower(trim($row['B'] ?? null)); // Convert department to lowercase for mapping
            $consultation_time = trim($row['C'] ?? null); // Assuming Consultation Time is in column C
            $faculty_image = $row['D'] ?? 'dfi.jfif'; // Use 'dfi.jfif' as default if no image is provided

            // Log the current row data for debugging
            error_log("Processing Row $rowIndex: Name: '$faculty_name', Dept: '$faculty_dept', Consultation Time: '$consultation_time', Image: '$faculty_image'");

            // Check for faculty department mapping
            $faculty_dept_id = null;
            if ($faculty_dept && isset($deptMapping[$faculty_dept])) {
                $faculty_dept_id = $deptMapping[$faculty_dept];
            } else {
                error_log("Invalid department '$faculty_dept' at Row $rowIndex. Skipping.");
                continue; // Skip this row if the department is not valid
            }

            // Proceed if faculty name is provided
            if ($faculty_name) {
                // Check if the faculty member already exists in the database
                $existingQuery = $connect->prepare("SELECT faculty_dept, consultation_time FROM faculty_tbl WHERE faculty_name = :faculty_name");
                $existingQuery->execute([':faculty_name' => $faculty_name]);
                $existingData = $existingQuery->fetch(PDO::FETCH_ASSOC);

                // Check for duplicates in departments 5 to 13
                $restrictedDepts = [5, 6, 7, 8, 9, 10, 11, 12, 13];
                if (in_array($faculty_dept_id, $restrictedDepts)) {
                    $duplicateQuery = $connect->prepare("SELECT faculty_name FROM faculty_tbl WHERE faculty_dept = :faculty_dept AND faculty_name != :faculty_name");
                    $duplicateQuery->execute([':faculty_dept' => $faculty_dept_id, ':faculty_name' => $faculty_name]);
                    if ($duplicateQuery->fetch(PDO::FETCH_ASSOC)) {
                        error_log("Duplicate department found for '$faculty_name'. Updating existing record.");
                        // Update the existing record
                        try {
                            $updateStmt->execute([
                                ':faculty_name' => $faculty_name,
                                ':consultation_time' => $consultation_time,
                                ':faculty_image' => $faculty_image // Update faculty image
                            ]);
                            $updatedCount++; // Increment the count of updated records
                        } catch (PDOException $e) {
                            error_log('Update error: ' . $e->getMessage());
                            $response['success'] = false;
                            $response['message'] = 'Error updating data: ' . $e->getMessage();
                            echo json_encode($response);
                            exit;
                        }
                        continue; // Skip to the next row
                    }
                }

                if ($existingData) {
                    // If the faculty member exists, check if an update is necessary
                    if ($existingData['consultation_time'] != $consultation_time) {
                        // Update the record if consultation time has changed
                        error_log("Updating: Name: '$faculty_name', New Consultation Time: '$consultation_time', Image: '$faculty_image'");
                        try {
                            $updateStmt->execute([
                                ':faculty_name' => $faculty_name,
                                ':consultation_time' => $consultation_time,
                                ':faculty_image' => $faculty_image // Update faculty image
                            ]);
                            $updatedCount++; // Increment the count of updated records
                        } catch (PDOException $e) {
                            error_log('Update error: ' . $e->getMessage());
                            $response['success'] = false;
                            $response['message'] = 'Error updating data: ' . $e->getMessage();
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        // Log that no update is needed
                        error_log("No update necessary for '$faculty_name'. Existing data matches the imported data.");
                    }
                } else {
                    // If the faculty member does not exist, insert a new record
                    error_log("Inserting: Name: '$faculty_name', Dept ID: $faculty_dept_id, Consultation Time: '$consultation_time', Image: '$faculty_image'");
                    try {
                        $insertStmt->execute([
                            ':faculty_name' => $faculty_name,
                            ':faculty_dept' => $faculty_dept_id, // Use the mapped department ID
                            ':consultation_time' => $consultation_time, // Insert the consultation time
                            ':faculty_image' => $faculty_image // Insert default or provided image
                        ]);
                        $insertedCount++; // Increment the count of inserted records
                    } catch (PDOException $e) {
                        error_log('Insert error: ' . $e->getMessage());
                        $response['success'] = false;
                        $response['message'] = 'Error inserting data: ' . $e->getMessage();
                        echo json_encode($response);
                        exit;
                    }
                }
            } else {
                error_log("Row $rowIndex skipped: No Faculty Name provided.");
            }
        }

        // Set the response message after processing
        $response['success'] = true;
        $response['message'] = "$insertedCount faculty members imported successfully. $updatedCount records updated.";
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
        $response['message'] = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : 'No Excel file uploaded or there was an upload error.';
        error_log("Upload error code: $errorCode - " . $response['message']);
    }

    exit; // Terminate the script
}


else {
    $response['message'] = 'Saved.';
}

echo json_encode($response);
?>
