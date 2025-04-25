<?php
// api/rooms.php - Endpoint to serve room data from database

// Set content type to JSON
header('Content-Type: application/json');

// Include your database connection file
include_once '../class/connection.php'; // Adjust path as needed

try {
    // SQL query to get all rooms and their details
    $stmt = $connect->prepare("SELECT room_id, floor_id, room_name FROM rooms");
    $stmt->execute();
    
    // Fetch all rooms as associative array
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Create formatted response
    $response = [];
    
    foreach ($rooms as $room) {
        $response[$room['room_id']] = [
            'name' => $room['room_name'],
            'floor_id' => $room['floor_id']
        ];
    }
    
    // Return the JSON response
    echo json_encode($response);
    
} catch(PDOException $e) {
    // Return error message
    $error = ['error' => 'Database query failed: ' . $e->getMessage()];
    echo json_encode($error);
}

// Close connection
$connect = null;
?>