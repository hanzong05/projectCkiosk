<?php

require_once '../class/connection.php';
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/errorlog.txt'); // Corrected path for error log file

// Response array
$response = [
    'success' => false,
    'message' => 'An error occurred'
];

try {
    // Check if required POST data is set
    if (!isset($_POST['rating']) || empty($_POST['rating'])) {
        throw new Exception('Rating is required.');
    }

    // Prepare other fields (name, email, address, etc.)
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $college = $_POST['college'] ?? '';
    $year = $_POST['year'] ?? '';
    $feedback = $_POST['feedback'] ?? '';
    $rating = $_POST['rating'];

    // Handle image upload
  // Handle image upload
// Handle image upload
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = __DIR__ . "/../uploaded/feedUploaded/"; // Absolute path for uploads
    // Create the uploads directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Get the original file extension
    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
    // Create a unique filename using the email
    // Sanitize the email to create a valid filename
    $sanitizedEmail = strtolower(str_replace(['@', '.'], ['_', '_'], $email));
    $uniqueFilename = $sanitizedEmail . '_' . uniqid() . '.' . $fileExtension;
    
    $targetFile = $targetDir . $uniqueFilename; // Use the new filename
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Store only the filename for database entry
        $imagePath = $uniqueFilename; 
    } else {
        throw new Exception('Image upload failed');
    }
}

// Prepare SQL statement
$sql = "INSERT INTO feedback (email, name, address, college, year, rating, feedback_text, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $connect->prepare($sql);

// Check if statement preparation was successful
if ($stmt === false) {
    throw new Exception('SQL error: ' . implode(", ", $connect->errorInfo()));
}

// Execute statement with parameters
$stmt->execute([$email, $name, $address, $college, $year, $rating, $feedback, $imagePath]);

// Set success response
$response['success'] = true;
$response['rating'] = $rating;
$response['feedback'] = $feedback; // Adjust this as necessary
$response['image'] = $imagePath; // Include image filename in the response if needed




} catch (Exception $e) {
    $response['message'] = $e->getMessage(); // Capture any error message
    error_log($e->getMessage()); // Log the error message
}

// Return JSON response
echo json_encode($response);
?>
