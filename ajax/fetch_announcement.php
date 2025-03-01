<?php
require_once '../class/mainClass.php';
header('Content-Type: application/json');

// Database connection parameters
$dbHost = 'localhost';
$dbName = 'ckiosk';
$dbUser = 'root';
$dbPass = '';

try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get and sanitize input parameters
$orgId = (int) $_POST['org_id'];
$searchTerm = trim($_POST['search'] ?? '');
$category = trim($_POST['category'] ?? '');
$dateFrom = trim($_POST['date_from'] ?? '');
$dateTo = trim($_POST['date_to'] ?? '');

try {
    // Base query with category as a subquery
    $query = "
    WITH CategorizedAnnouncements AS (
        SELECT 
            a.*,
            u.users_username AS author_name,
            COALESCE(c.users_username, o.username, 'Unknown Creator') AS creator_name,
            org.org_name,
            org.org_image,
            GROUP_CONCAT(ai.image_path) AS announcement_images,
            CASE 
                WHEN LOWER(a.announcement_title) LIKE '%event%' OR LOWER(a.announcement_details) LIKE '%event%' 
                    THEN 'event'
                WHEN LOWER(a.announcement_title) LIKE '%academic%' OR LOWER(a.announcement_details) LIKE '%academic%' 
                    THEN 'academic'
                WHEN LOWER(a.announcement_title) LIKE '%meeting%' OR LOWER(a.announcement_details) LIKE '%meeting%' 
                    THEN 'org'
                ELSE 'general'
            END AS announcement_category
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN users_tbl c ON a.created_by = c.users_id 
        LEFT JOIN orgmembers_tbl o ON a.created_by = o.id 
        LEFT JOIN organization_tbl org ON u.users_org = org.org_id 
        LEFT JOIN announcement_images ai ON a.announcement_id = ai.announcement_id
        WHERE u.users_org = :userOrgId AND a.is_archived = 0
        GROUP BY a.announcement_id
    )
    SELECT * FROM CategorizedAnnouncements 
    WHERE 1=1
    ";

    $params = [':userOrgId' => $orgId];

    // Add search filter if provided
    if (!empty($searchTerm)) {
        $query .= " AND (
            announcement_title LIKE :search 
            OR announcement_details LIKE :search 
            OR author_name LIKE :search
            OR creator_name LIKE :search
        )";
        $params[':search'] = "%$searchTerm%";
    }

    // Add category filter
    if (!empty($category) && $category !== 'all') {
        $query .= " AND announcement_category = :category";
        $params[':category'] = $category;
    }

    // Add date range filters
    if (!empty($dateFrom)) {
        $query .= " AND DATE(created_at) >= :dateFrom";
        $params[':dateFrom'] = $dateFrom;
    }
    if (!empty($dateTo)) {
        $query .= " AND DATE(created_at) <= :dateTo";
        $params[':dateTo'] = $dateTo;
    }

    // Add order by
    $query .= " ORDER BY created_at DESC";

    $statement = $db->prepare($query);
    $statement->execute($params);
    $announcements = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Process announcements
    foreach ($announcements as &$announcement) {
        // Split images
        $announcement['images'] = $announcement['announcement_images'] ? explode(',', $announcement['announcement_images']) : [];
        unset($announcement['announcement_images']);
        
        // Set category based on content
        $title = strtolower($announcement['announcement_title']);
        $details = strtolower($announcement['announcement_details']);
        
        if (strpos($title, 'event') !== false || strpos($details, 'event') !== false) {
            $announcement['category'] = 'event';
        } 
        elseif (strpos($title, 'academic') !== false || strpos($details, 'academic') !== false) {
            $announcement['category'] = 'academic';
        } 
        elseif (strpos($title, 'meeting') !== false || strpos($details, 'meeting') !== false) {
            $announcement['category'] = 'org';
        } 
        else {
            $announcement['category'] = 'general';
        }
        
        // Debug log
        error_log(sprintf(
            "Announcement ID: %d, Title: %s, Content: %s, Assigned Category: %s",
            $announcement['announcement_id'],
            $announcement['announcement_title'],
            substr($announcement['announcement_details'], 0, 50),
            $announcement['category']
        ));
    }$response = [
        'status' => 'success',
        'announcements' => $announcements,
        'filters_applied' => [
            'search' => $searchTerm,
            'category' => $category,
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ],
        'debug' => [
            'total_count' => count($announcements),
            'categories_found' => array_column($announcements, 'category')
        ]
    ];
    
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error fetching data: ' . $e->getMessage()
    ]);
}
?>