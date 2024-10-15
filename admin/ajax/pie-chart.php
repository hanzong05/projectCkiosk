<?php
// Include the database connection
include '../../class/connection.php';

try {
    // Query to get the count and total sum of ratings from the feedback table
    $stmt = $connect->prepare("
        SELECT rating, COUNT(*) AS count, SUM(rating) AS total 
        FROM feedback 
        WHERE rating IN (1, 2, 3, 4, 5) 
        GROUP BY rating 
        ORDER BY rating
    ");
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Initialize counts and totals for each rating
    $ratingsCount = [
        1 => ['count' => 0, 'total' => 0],
        2 => ['count' => 0, 'total' => 0],
        3 => ['count' => 0, 'total' => 0],
        4 => ['count' => 0, 'total' => 0],
        5 => ['count' => 0, 'total' => 0]
    ];

    // Populate counts and totals based on the query result
    foreach ($result as $row) {
        $ratingsCount[$row['rating']]['count'] = (int)$row['count'];
        $ratingsCount[$row['rating']]['total'] = (int)$row['total'];
    }

    // Calculate total counts and total ratings for averages
    $totalCount = 0;
    $totalRatings = 0;

    foreach ($ratingsCount as $rating => $data) {
        $totalCount += $data['count'];
        $totalRatings += $data['total'];
    }

    // Calculate averages
    $averageRatings = [];

    if ($totalCount > 0) {
        foreach ($ratingsCount as $rating => $data) {
            $averageRatings[$rating] = round(($data['total'] / $totalCount), 2); // Average rating value
        }
    } else {
        // If no feedbacks, set all averages to 0
        $averageRatings = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];
    }

    // Return JSON response with counts and averages
    echo json_encode([
        'counts' => array_column($ratingsCount, 'count'), // Extract only counts
        'averages' => $averageRatings
    ]);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
