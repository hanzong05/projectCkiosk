<?php
// Include database connection
require_once '../../class/connection.php';

// Response array
$response = [
    'success' => false,
    'message' => 'Unknown error occurred'
];

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $room_id = filter_input(INPUT_POST, 'room_id', FILTER_SANITIZE_STRING);
    $room_name = filter_input(INPUT_POST, 'room_name', FILTER_SANITIZE_STRING);
    $room_description = filter_input(INPUT_POST, 'room_description', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($room_id)) {
        $response['message'] = 'Room ID is required';
        http_response_code(400);
        echo json_encode($response);
        exit;
    }

    try {
        // Prepare SQL statement
        $stmt = $connect->prepare("UPDATE rooms 
                                   SET room_name = :room_name, 
                                       room_description = :room_description 
                                   WHERE room_id = :room_id");
        
        // Bind parameters
        $stmt->bindParam(':room_name', $room_name, PDO::PARAM_STR);
        $stmt->bindParam(':room_description', $room_description, PDO::PARAM_STR);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            // Check if any rows were actually updated
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'Room details updated successfully';
            } else {
                $response['message'] = 'No changes made. Room not found or details are the same.';
            }
        } else {
            $response['message'] = 'Database error: ' . implode(': ', $stmt->errorInfo());
            http_response_code(500);
        }
    } catch (PDOException $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
        http_response_code(500);
        
        // Log the full error details
        error_log('Room update error: ' . $e->getMessage() . "\n", 3, __DIR__ . '/error_log.txt');
    }
} else {
    // Method not allowed
    http_response_code(405);
    $response['message'] = 'Method Not Allowed';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>