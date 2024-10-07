<?php
include '../class/connection.php'; // Ensure this points to your connection file

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the header for JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $college = $_POST['college'] ?? '';
    $year = $_POST['year'] ?? 0; // Default to 0 if year is not set
    $rating = $_POST['rating'] ?? 0; // Default to 0 if rating is not set
    $feedback = $_POST['feedback'] ?? '';
    
    // Handle image upload
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Specify your upload directory
        // Create the uploads directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile; // Store the path if the upload was successful
        } else {
            echo json_encode(['success' => false, 'message' => 'Image upload failed']);
            exit; // Stop further execution
        }
    }

    // Prepare SQL statement
    $sql = "INSERT INTO feedback_tbl (email, name, address, college, year, rating, feedback, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssssis", $email, $name, $address, $college, $year, $rating, $feedback, $imagePath);

    // Execute statement and handle potential errors
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $connect = null;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
