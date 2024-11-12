<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Set JSON content type

require_once '../class/connection.php'; // Make sure this path is correct

try {
    // Your existing code to fetch data from the database
    // Example:
    $pdo = new PDO("mysql:host=localhost;dbname=ckiosk", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT rating, feedback_text, name FROM feedback ORDER BY created_at DESC");
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalFeedback = count($feedbacks);
    $averageRating = $totalFeedback ? array_sum(array_column($feedbacks, 'rating')) / $totalFeedback : 0;

    $response = [
        'total_feedback' => $totalFeedback,
        'average_rating' => round($averageRating, 1),
        'feedbacks' => $feedbacks
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
