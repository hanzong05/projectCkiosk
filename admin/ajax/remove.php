<?php
// clean_events.php

// Database connection setup
$dsn = 'mysql:host=localhost;dbname=ckiosk;charset=utf8'; // Replace with your actual database name
$pdo = new PDO($dsn, 'root', ''); // Replace 'root' and '' with actual username and password

// Clean past events from calendar_tbl
$today = date('Y-m-d');
$stmt = $pdo->prepare("DELETE FROM calendar_tbl WHERE calendar_date < :today");
$stmt->execute([':today' => $today]);

// Archive announcements older than 14 days
$currentDate = new DateTime();
$archiveThresholdDate = $currentDate->modify('-14 days')->format('Y-m-d');

// Prepare the update query for archiving
$updateSql = '
    UPDATE 
        announcement_tbl 
    SET 
        is_archived = 1 
    WHERE 
        created_at < :archiveThreshold AND 
        is_archived = 0
';
$updateStmt = $pdo->prepare($updateSql);
$updateStmt->bindValue(':archiveThreshold', $archiveThresholdDate);
$updateStmt->execute();

?>
