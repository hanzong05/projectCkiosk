<?php
// Database connection
include '../../class/connection.php';

try {
    // Use the existing connection
    $pdo = $connect; // Use the $connect variable from connection.php

    // Query to get ratings per month
    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') AS month_year,
            COUNT(rating) AS total_ratings
        FROM 
            feedback
        GROUP BY 
            YEAR(created_at), MONTH(created_at)
        ORDER BY 
            YEAR(created_at), MONTH(created_at)
    ");

    $labels = [];
    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Ensure to fetch as associative array
        $labels[] = $row['month_year'];
        $data[] = $row['total_ratings'];
    }

    // Convert the PHP arrays to JSON format to pass to JavaScript
    $labels_json = json_encode($labels);
    $data_json = json_encode($data);

    // Return the data as a JSON response
    echo json_encode(['labels' => $labels_json, 'data' => $data_json]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
