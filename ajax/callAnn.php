<?php
// Include database connection
include_once("../class/connection.php");

function getAnnouncements($connection) {
    // Example query to fetch announcements (adjust as needed)
    $query = "
        SELECT a.*, 
            u.users_username AS author_name, 
            COALESCE(c.users_username, o.username, 'Unknown Creator') AS creator_name, 
            org.org_name, 
            org.org_image,
            GROUP_CONCAT(ai.image_path) AS announcement_images
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN users_tbl c ON a.created_by = c.users_id  
        LEFT JOIN orgmembers_tbl o ON a.created_by = o.id  
        LEFT JOIN organization_tbl org ON u.users_org = org.org_id  
        LEFT JOIN announcement_images ai ON a.announcement_id = ai.announcement_id
        WHERE a.is_archived = 0
        GROUP BY a.announcement_id
        ORDER BY a.created_at DESC
    ";

    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Ensure the data is correctly formatted
        foreach ($result as &$row) {
            if (!empty($row['created_at'])) {
                $timestamp = strtotime($row['created_at']);
                if ($timestamp !== false) {
                    $row['created_at_formatted'] = date('c', $timestamp); // ISO 8601 format
                    $row['created_at_timestamp'] = $timestamp;
                } else {
                    $row['created_at_formatted'] = null;
                    $row['created_at_timestamp'] = null;
                }
            }

            $row['org_image'] = !empty($row['org_image']) ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8') : 'default_org_image.jpg';
            $row['announcement_images'] = !empty($row['announcement_images']) ? explode(',', $row['announcement_images']) : [];
            $row['creator_name'] = !empty($row['creator_name']) ? htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Creator';
            $row['org_name'] = !empty($row['org_name']) ? htmlspecialchars($row['org_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Organization';
            $row['announcement_details'] = $row['announcement_details'] ?? '';
        }

        // Send the result as JSON
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
}

getAnnouncements($connect); // Call the function to output the data
?>
