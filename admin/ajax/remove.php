<?php
// clean_events.php

// Database connection setup
$dsn = 'mysql:host=localhost;dbname=ckiosk;charset=utf8'; // Replace with your actual database name
$pdo = new PDO($dsn, 'root', ''); // Replace 'root' and '' with actual username and password

// Clean past events
$today = date('Y-m-d');
$stmt = $pdo->prepare("DELETE FROM calendar_tbl WHERE calendar_date < :today");
$stmt->execute([':today' => $today]);

echo "Clean-up successful!";
?>
