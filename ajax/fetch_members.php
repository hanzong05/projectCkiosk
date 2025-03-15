<?php
$username = "root";
$password = "";
$dsn = "mysql:host=localhost;dbname=ckiosk";

// Report errors (only in development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Establish the database connection
    $connect = new PDO($dsn, $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage() . "\n", 3, __DIR__ . '/error_log.txt');
    echo "We are currently experiencing technical issues. Please try again later.";
    exit;
}

include_once ("../class/mainClass.php");
header('Content-Type: application/json');

// Assuming orgId is being passed as a POST request
$orgId = isset($_POST['org_id']) ? $_POST['org_id'] : null; // No default if not provided

if ($orgId) {
    // Use $connect to prepare the query
    $stmt = $connect->prepare("SELECT * FROM orgmembers_tbl WHERE org_type = :org_id");
    $stmt->execute(['org_id' => $orgId]);
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($members) {
        echo json_encode(['members' => $members]);
    } else {
        echo json_encode(['error' => 'No members found for the given organization.']);
    }
} else {
    echo json_encode(['error' => 'Organization ID (org_id) is required.']);
}

// Close the database connection
$connect = null;
?>
