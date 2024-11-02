<?php
session_start();
require_once '../class/mainClass.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$username = "root";
$password = "";
$dbName = "ckiosk";

try {
    // Establishing the connection
    $connect = new PDO("mysql:host=localhost;dbname=$dbName", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the org_id is set
    if (isset($_POST['org_id'])) {
        $org_id = $_POST['org_id'];

        // Prepare the SQL query to fetch members based on the org_id
        $query = "SELECT * FROM orgmembers_tbl WHERE org_type = :org_id";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT); // Binding parameter
        $stmt->execute();

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if members were found and return as JSON
        if (!empty($members)) {
            echo json_encode(['members' => $members]);
        } else {
            echo json_encode(['error' => 'No members found.']);
        }
    } else {
        echo json_encode(['error' => 'Organization ID not provided.']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
