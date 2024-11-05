<?php
$username = "root";
$password = "";
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $connect = new PDO("mysql:host=localhost;dbname=ckiosk", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage(), 3, 'error_log.php');
    die('Database connection failed.');
}
?>
