<?php
// Include the database connection file
require_once '../class/connection.php'; // Ensure this path is correct

// Query to fetch all faculty data from the database
$query = "SELECT faculty_id, faculty_name, faculty_image, specialization, consultation_time FROM faculty_tbl";
$stmt = $connect->prepare($query);  // Use $connect instead of $pdo
$stmt->execute();

// Fetch all faculty as an associative array
$faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the results as JSON
echo json_encode($faculty);
?>
