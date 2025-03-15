<?php
require_once('../class/connection.php');

try {
   $query = "SELECT 
       c.calendar_id as event_id,
       c.calendar_details as event_name,
       c.calendar_start_date,
       c.calendar_end_date
   FROM calendar_tbl c
   LEFT JOIN users_tbl u ON c.event_creator = u.users_id 
   LEFT JOIN organization_tbl o ON u.users_org = o.org_id";

   $stmt = $connect->prepare($query);
   $stmt->execute();
   
   $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

   header('Content-Type: application/json');
   echo json_encode([
       'success' => true,
       'events' => $events
   ]);

} catch (Exception $e) {
   http_response_code(400);
   echo json_encode([
       'success' => false,
       'message' => $e->getMessage()
   ]);
}