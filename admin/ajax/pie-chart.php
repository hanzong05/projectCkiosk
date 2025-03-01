<?php
// Include the database connection
include '../../class/connection.php';

try {
    // Check if 'purpose' is set and not empty
    if (isset($_GET['purpose']) && !empty($_GET['purpose'])) {
        $purpose = $_GET['purpose'];

        // Prepare query with filtering by purpose if 'purpose' is set
        $stmt = $connect->prepare("
            SELECT rating, COUNT(*) AS count, SUM(rating) AS total 
            FROM feedback 
            WHERE rating IN (1, 2, 3, 4, 5) 
            AND feedback_purpose = :purpose  -- Assuming 'purpose_column' is the column for 'purpose'
            GROUP BY rating 
            ORDER BY rating
        ");
        $stmt->bindParam(':purpose', $purpose);
    } else {
        // Default query if no 'purpose' is set
        $stmt = $connect->prepare("
            SELECT rating, COUNT(*) AS count, SUM(rating) AS total 
            FROM feedback 
            WHERE rating IN (1, 2, 3, 4, 5) 
            GROUP BY rating 
            ORDER BY rating
        ");
    }

    // Execute the query
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Initialize counts and totals for each rating
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

    // Log the fetched counts to a file for debugging
    file_put_contents('log.txt', print_r($ratingsCount, true), FILE_APPEND);

    // Return JSON response with counts
    echo json_encode([
        'counts' => array_values($ratingsCount) // Extract only counts
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
