<?php
session_start();
require_once '../class/mainClass.php';

header('Content-Type: application/json'); // Ensure the content type is JSON

// Database connection parameters
$dbHost = 'localhost';
$dbName = 'ckiosk';
$dbUser = 'root';
$dbPass = '';

// Create a PDO instance for database connection
try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if (isset($_POST['org_id']) && !empty($_POST['org_id'])) {
    $orgId = intval($_POST['org_id']); // Ensure it's an integer

    // Log the received org ID for debugging
    error_log("Received org_id: $orgId");

    try {
        // Fetch announcements by organization ID
        $query = "
            SELECT a.*, 
                   u.users_username AS author_name, 
                   COALESCE(c.users_username, o.username, 'Unknown Creator') AS creator_name, 
                   org.org_name, 
                   org.org_image 
            FROM announcement_tbl a 
            LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
            LEFT JOIN users_tbl c ON a.created_by = c.users_id  
            LEFT JOIN orgmembers_tbl o ON a.created_by = o.id  
            LEFT JOIN organization_tbl org ON u.users_org = org.org_id  
            WHERE u.users_org = :userOrgId AND a.is_archived = 0
        ";

        $statement = $db->prepare($query);
        $statement->bindValue(':userOrgId', $orgId, PDO::PARAM_INT);
        $statement->execute();
        $announcements = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Log the announcements for debugging
        error_log("Fetched announcements: " . print_r($announcements, true));

        // Return a success response with announcements (even if empty)
        $response = [
            'org_name' => 'Example Org Name', // You might want to fetch the actual organization name here
            'announcements' => $announcements // Will be an empty array if no announcements found
        ];
        echo json_encode($response);
    } catch (Exception $e) {
        // Log any exceptions
        error_log("Exception: " . $e->getMessage());
        echo json_encode(['error' => 'An error occurred while fetching announcements.']);
    }
} else {
    echo json_encode(['error' => 'Invalid organization ID']);
}
