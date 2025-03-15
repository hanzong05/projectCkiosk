<?php
// Include the database connection
include '../../class/connection.php';

header('Content-Type: application/json'); // Set JSON content type for the response

try {
    // Check if the summary type (feedback_purpose) is set via AJAX
    if (isset($_GET['purpose']) && !empty($_GET['purpose'])) {
        // If 'purpose' is provided, filter by it
        $purpose = $_GET['purpose'];

        // Prepare and execute the query based on the selected purpose
        $stmt = $connect->prepare("
            SELECT rating, COUNT(*) AS count 
            FROM feedback 
            WHERE feedback_purpose = :purpose 
            AND rating IN (1, 2, 3, 4, 5) 
            GROUP BY rating 
            ORDER BY rating
        ");
        $stmt->bindValue(':purpose', $purpose, PDO::PARAM_STR);
    } else {
        // If no 'purpose' is provided, fetch data for all purposes
        $stmt = $connect->prepare("
            SELECT rating, COUNT(*) AS count 
            FROM feedback 
            WHERE rating IN (1, 2, 3, 4, 5) 
            GROUP BY rating 
            ORDER BY rating
        ");
    }
    
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize counts for each rating (to always return data)
    $ratingsCount = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0
    ];

    // If there is data, populate the counts based on the query result
    foreach ($result as $row) {
        $ratingsCount[$row['rating']] = (int)$row['count'];
    }

    // Return JSON response
    echo json_encode($ratingsCount);

} catch (PDOException $e) {
    // Return JSON error response on database error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
