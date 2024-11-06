<?php
// vote_feedback.php
require 'class/connection.php'; // Include your database connection

$data = json_decode(file_get_contents('php://input'), true);
$feedbackId = $data['id'];
$action = $data['action'];

if ($action === 'upvote') {
    // Increment upvote count in the database
    $stmt = $pdo->prepare("UPDATE feedback SET like = upvotes + 1 WHERE id = :id");
    $stmt->execute(['id' => $feedbackId]);
} elseif ($action === 'downvote') {
    // Increment downvote count in the database
    $stmt = $pdo->prepare("UPDATE feedback SET unlikes = downvotes + 1 WHERE id = :id");
    $stmt->execute(['id' => $feedbackId]);
}

// Optionally return some data
echo json_encode(['status' => 'success']);
?>
