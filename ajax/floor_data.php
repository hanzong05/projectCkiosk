<?php
include_once("../class/connection.php");
if (isset($_POST['floor_id'])) {
    $floorId = $_POST['floor_id'];

    try {
        // Prepare and execute the query
        $stmt = $connect->prepare('SELECT room_id, room_name FROM room_tbl WHERE floor_id = :floor_id');
        $stmt->execute(['floor_id' => $floorId]);
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the result as a JSON string
        header('Content-Type: application/json');
        echo json_encode($rooms);
    } catch (PDOException $e) {
        // Handle and log SQL errors
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit; // Ensure no additional output is added
}
?>
