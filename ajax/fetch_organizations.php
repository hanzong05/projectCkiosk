<?php 
require_once('../class/connection.php');

try {
    $query = "SELECT * FROM organization_tbl";
    $stmt = $connect->query($query);
    $organizations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'organizations' => $organizations
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error'
    ]);
}