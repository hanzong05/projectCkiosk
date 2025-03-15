<?php
// Enable error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Set JSON content type

require_once '../class/connection.php'; // Ensure this path is correct

try {
    // Assuming connection.php handles the database connection
    $pdo = new PDO("mysql:host=localhost;dbname=ckiosk", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the feedback table
    $stmt = $pdo->prepare("SELECT rating, feedback_text, name FROM feedback ORDER BY created_at DESC");
    $stmt->execute();
    
    // Fetch results as an associative array
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Ensure $feedbacks is an array (optional check)
    if (!is_array($feedbacks)) {
        $feedbacks = [];
    }

    // Calculate total feedback and average rating
    $totalFeedback = count($feedbacks);
    $averageRating = $totalFeedback ? array_sum(array_column($feedbacks, 'rating')) / $totalFeedback : 0;

    // Prepare the response
    $response = [
        'total_feedback' => $totalFeedback,
        'average_rating' => round($averageRating, 1),
        'feedbacks' => $feedbacks
    ];

    // Send response as JSON
    echo json_encode($response);

} catch (PDOException $e) {
    // Handle errors and send a JSON response with the error message
    echo json_encode(['error' => $e->getMessage()]);
}
