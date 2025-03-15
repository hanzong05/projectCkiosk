<?php
include_once("../class/connection.php");

try {
    $orgQuery = "SELECT COUNT(*) FROM org_feedback";
    $officeQuery = "SELECT COUNT(*) FROM office_feedback";
    
    $orgCount = $connect->query($orgQuery)->fetchColumn();
    $officeCount = $connect->query($officeQuery)->fetchColumn();
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'org_count' => $orgCount,
        'office_count' => $officeCount
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error'
    ]);
}
?>