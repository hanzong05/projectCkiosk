<?php
session_start();
require_once '../class/mainClass.php';

header('Content-Type: application/json'); // Ensure the content type is JSON

$mainClass = new mainClass();

if (isset($_POST['org_id']) && !empty($_POST['org_id'])) {
    $orgId = intval($_POST['org_id']); // Ensure it's an integer

    // Log the received org ID for debugging
    error_log("Received org_id: $orgId");

    try {
        // Fetch announcements by organization ID
        $announcements = $mainClass->get_announcements_by_org($orgId);

        // Log the announcements for debugging
        error_log("Fetched announcements: " . print_r($announcements, true));

        if (!empty($announcements)) {
            $response = [
                'org_name' => 'Example Org Name', // Replace with actual org name if needed
                'announcements' => $announcements
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'No announcements found.']);
        }
    } catch (Exception $e) {
        // Log any exceptions
        error_log("Exception: " . $e->getMessage());
        echo json_encode(['error' => 'An error occurred while fetching announcements.']);
    }
} else {
    echo json_encode(['error' => 'Invalid organization ID']);
}
