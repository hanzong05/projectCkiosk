<?php
// Include the database connection
include '../../class/connection.php';

try {
    $stmt = $connect->prepare("SELECT rating, COUNT(*) AS count FROM feedback WHERE rating IN (1, 2, 3, 4, 5) GROUP BY rating ORDER BY rating");
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Initialize counts for each rating
    $ratingsCount = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0
    ];

    // Populate counts based on the query result
    foreach ($result as $row) {
        $ratingsCount[$row['rating']] = (int)$row['count'];
    }

    // Return JSON response
    echo json_encode($ratingsCount);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
