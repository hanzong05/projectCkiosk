<?php
require_once '../../class/connection.php';

if (isset($_POST['id']) && isset($_POST['name'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    if (empty($id) || empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    try {
        $stmt = $connect->prepare("UPDATE room_tbl SET room_name = :name WHERE room_id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Update failed: " . $errorInfo[2]);
            echo json_encode(['success' => false, 'message' => 'Update failed']);
        }
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>
