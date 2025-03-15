<?php
$username = "root";
$password = "";
$dsn = "mysql:host=localhost;dbname=ckiosk";

// Report errors (only in development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $connect = new PDO($dsn, $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage() . "\n", 3, __DIR__ . '/error_log.txt');
    echo "We are currently experiencing technical issues. Please try again later.";
    exit;
}

// Later in your script
// $connect = null; // Close connection when done
?>
