<?php
// Initialize the session
session_start();

// Include your database connection file
require_once '../class/mainClass.php';

// Create an instance of mainClass
$db = new mainClass();
$connection = $db->getConnection(); // Use this if you added a getConnection method

// Check if the user is logged in and has a valid session
if (isset($_SESSION['aid'])) {
    // Get the user ID from the session
    $user_id = $_SESSION['aid'];
    $usermember_id = $_SESSION['id'];
   // User ID not found in users_tbl, now check orgmembers_tbl
   $update_sql_orgmembers = "UPDATE orgmembers_tbl SET is_active = 0 WHERE id = :usermember_id";
   $stmt = $connection->prepare($update_sql_orgmembers);
   $stmt->bindParam(":usermember_id", $usermember_id, PDO::PARAM_INT);
  
    
    // Execute the update for users_tbl
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // Successfully updated is_active in users_tbl
            error_log("Successfully updated is_active in users_tbl for user ID $user_id.");
        } else {
         
              // First, try to update is_active in users_tbl
    $update_sql_users = "UPDATE users_tbl SET is_active = 0 WHERE users_id = :user_id";
    $stmt = $connection->prepare($update_sql_users);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            // Execute the update for orgmembers_tbl
            if ($stmt->execute()) {
                // Check if any rows were affected
                if ($stmt->rowCount() > 0) {
                    // Successfully updated is_active in orgmembers_tbl
                    error_log("Successfully updated is_active in orgmembers_tbl for user ID $user_id.");
                } else {
                    // User ID not found in orgmembers_tbl
                    error_log("User ID $user_id not found in both users_tbl and orgmembers_tbl.");
                }
            } else {
                // Handle potential errors in the execution of orgmembers_tbl update
                error_log("Error executing the update in orgmembers_tbl: " . implode(", ", $stmt->errorInfo()));
            }
        }
    } else {
        // Handle potential errors in the execution of users_tbl update
        error_log("Error executing the update in users_tbl: " . implode(", ", $stmt->errorInfo()));
    }
} else {
    error_log("No active session found. User ID not available.");
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("location: index.php");
exit;
?>
