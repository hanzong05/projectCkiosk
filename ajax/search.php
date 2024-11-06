<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../class/connection.php");
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ckiosk', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['query'])) {
        $query = $_POST['query'];
        $stmt = $pdo->prepare("SELECT room_id, floor_id FROM room_tbl WHERE room_name LIKE :query");
        $stmt->execute(['query' => '%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Extract room IDs and floor IDs from results
        $roomIds = array_column($results, 'room_id');
        $floorIds = array_unique(array_column($results, 'floor_id'));

        // Fetch the room names, IDs, and floor IDs for displaying in the table
        $stmt = $pdo->query("SELECT room_id, room_name, floor_id FROM room_tbl");
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return room details, IDs to be highlighted, and floor IDs
        echo json_encode(['rooms' => $rooms, 'highlight' => $roomIds, 'floor' => $floorIds]);
    } else {
        echo json_encode(['rooms' => [], 'highlight' => [], 'floor' => []]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
