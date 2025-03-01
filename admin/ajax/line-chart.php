<?php
// Database connection
include '../../class/connection.php';

try {
    // Use the existing connection
    $pdo = $connect; // Use the $connect variable from connection.php

    // Get the 'purpose' parameter from the URL query string
    $purpose = isset($_GET['purpose']) ? $_GET['purpose'] : ''; // Default to empty if not set

    // Base SQL query
    $sql = "
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') AS month_year,
            COUNT(rating) AS total_ratings
        FROM 
            feedback
        WHERE 
            1 = 1
    ";

    // Add condition for the purpose if it's provided
    if ($purpose) {
        $sql .= " AND feedback_purpose = :purpose"; // Filter by purpose
    }

    // Continue with the grouping and ordering
    $sql .= "
        GROUP BY 
            YEAR(created_at), MONTH(created_at)
        ORDER BY 
            YEAR(created_at), MONTH(created_at)
    ";

    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);

    // Bind the 'purpose' parameter if it's set
    if ($purpose) {
        $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
    }

    $stmt->execute();

    // Arrays to hold the labels and data
    $labels = [];
    $data = [];

    // Fetch the results
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $labels[] = $row['month_year']; // Store month-year for labels
        $data[] = $row['total_ratings']; // Store ratings count for each month
    }

    // Return the data as a JSON response
    echo json_encode(['labels' => $labels, 'data' => $data]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
