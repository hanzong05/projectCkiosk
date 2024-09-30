<?php
$username = "root";
$password = "";

try {
    $connect = new PDO("mysql:host=localhost;dbname=ckiosk", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
