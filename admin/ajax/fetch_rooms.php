<?php
// api/rooms.php - Endpoint to serve room data from database

// Set content type to JSON
header('Content-Type: application/json');

// Include your database connection file
include_once '../../class/connection.php'; // Adjust path as needed

try {
    // SQL query to get all rooms and their details
    // Added room_description to include all available data
    $stmt = $connect->prepare("SELECT room_id, floor_id, room_name, room_description FROM rooms");
    $stmt->execute();
    
    // Fetch all rooms as associative array
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Create formatted response
    $response = [];
    
    if (count($rooms) > 0) {
        foreach ($rooms as $room) {
            $response[$room['room_id']] = [
                'id' => $room['room_id'],
                'name' => $room['room_name'] ?? 'Unnamed Room',
                'floor_id' => $room['floor_id'],
                'description' => $room['room_description'] ?? ''
            ];
        }
        
        // Return the JSON response
        echo json_encode($response);
    } else {
        // No rooms found
        echo json_encode([]);
    }
    
} catch(PDOException $e) {
    // Log error for server-side debugging
    error_log("Database error in rooms.php: " . $e->getMessage(), 0);
    
    // Return error message - with limited details for security
    http_response_code(500);
    $error = ['error' => 'Database query failed. Please contact administrator.'];
    echo json_encode($error);
}

// Close connection
$connect = null;
?>