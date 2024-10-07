<?php
require_once '../class/connection.php'; // Ensure this path is correct

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ckiosk", "root", ""); // Update these parameters as needed
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the query to fetch feedback
    $stmt = $pdo->prepare("SELECT rating, feedback_text, email, name, address, college, year, image FROM feedback ORDER BY created_at DESC");
    $stmt->execute();

    // Fetch all feedback records
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define the directory where images are stored
    $imageDirectory = 'uploaded/feedUploaded/'; // Update this path as needed

    // Update the image URLs in the feedbacks array
    foreach ($feedbacks as &$feedback) {
        if (!empty($feedback['image'])) {
            $feedback['image'] = $imageDirectory . $feedback['image'];
        } else {
            $feedback['image'] = $imageDirectory . 'default.jpg'; // Default image URL
        }
    }

    // Return the feedbacks as JSON
    header('Content-Type: application/json');
    echo json_encode($feedbacks);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
