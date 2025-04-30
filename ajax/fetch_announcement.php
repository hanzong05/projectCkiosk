<?php
// Turn off error display for production
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Start output buffering to prevent any unexpected output
ob_start();

require_once '../class/mainClass.php';
header('Content-Type: application/json');

// Set up error logging to a specific file
$logFile = '../logs/announcement_api_errors.log';

// Create logs directory if it doesn't exist
if (!file_exists('../logs')) {
    mkdir('../logs', 0755, true);
}

// Function to log errors to our custom file
function logError($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    error_log($logMessage, 3, $logFile);
}

// Log the start of the API request
logError("API Request started - org_id: " . ($_POST['org_id'] ?? 'not set'));

try {
    // Check if org_id is provided
    if (!isset($_POST['org_id']) || empty($_POST['org_id'])) {
        throw new Exception("Missing required parameter: org_id");
    }

    // Database connection parameters
    $dbHost = 'localhost';
    $dbName = 'ckiosk';
    $dbUser = 'root';
    $dbPass = '';

    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    logError("Database connection established successfully");
    
} catch (PDOException $e) {
    logError("Database connection failed: " . $e->getMessage());
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    logError("Initialization error: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Get and sanitize input parameters
$orgId = (int) $_POST['org_id'];
$searchTerm = trim($_POST['search'] ?? '');
$category = trim($_POST['category'] ?? '');
$dateFrom = trim($_POST['date_from'] ?? '');
$dateTo = trim($_POST['date_to'] ?? '');

// Log the input parameters
logError("Parameters: org_id=$orgId, search='$searchTerm', category='$category', date_from='$dateFrom', date_to='$dateTo'");

try {
    // Simpler base query to reduce potential errors
    $query = "
    SELECT 
        a.*,
        u.users_username AS author_name,
        o.org_name,
        o.org_image
    FROM announcement_tbl a 
    LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id
    LEFT JOIN organization_tbl o ON u.users_org = o.org_id
    WHERE a.is_archived = 0
    AND u.users_org = :orgId
    ";

    $params = [':orgId' => $orgId];
    
    // Log the base query
    logError("Base query: " . $query);

    // Add search filter if provided
    if (!empty($searchTerm)) {
        $query .= " AND (
                a.announcement_title LIKE :search 
                OR a.announcement_details LIKE :search 
                OR u.users_username LIKE :search
            )";
        $params[':search'] = "%$searchTerm%";
        logError("Search filter added for: '$searchTerm'");
    }

    // Add date filters if provided
    if (!empty($dateFrom)) {
        $query .= " AND DATE(a.created_at) >= :dateFrom";
        $params[':dateFrom'] = $dateFrom;
        logError("Date from filter added: $dateFrom");
    }
    
    if (!empty($dateTo)) {
        $query .= " AND DATE(a.created_at) <= :dateTo";
        $params[':dateTo'] = $dateTo;
        logError("Date to filter added: $dateTo");
    }

    // Order by most recent first
    $query .= " ORDER BY a.created_at DESC";

    // Log the final query with parameters
    $logQuery = $query;
    foreach ($params as $key => $value) {
        $logQuery = str_replace($key, "'$value'", $logQuery);
    }
    logError("Final query: " . $logQuery);

    // Execute the query
    $statement = $db->prepare($query);
    $statement->execute($params);
    $announcements = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    logError("Query executed, found " . count($announcements) . " announcements");

    // Separately fetch images for announcements
    if (!empty($announcements)) {
        $announcementIds = array_column($announcements, 'announcement_id');
        $placeholders = implode(',', array_fill(0, count($announcementIds), '?'));
        
        $imageQuery = "SELECT announcement_id, image_path FROM announcement_images WHERE announcement_id IN ($placeholders)";
        $imageStmt = $db->prepare($imageQuery);
        $imageStmt->execute($announcementIds);
        $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Group images by announcement_id
        $imagesByAnnouncement = [];
        foreach ($images as $image) {
            $announcementId = $image['announcement_id'];
            if (!isset($imagesByAnnouncement[$announcementId])) {
                $imagesByAnnouncement[$announcementId] = [];
            }
            $imagesByAnnouncement[$announcementId][] = $image['image_path'];
        }
        
        // Add images to each announcement
        foreach ($announcements as &$announcement) {
            $id = $announcement['announcement_id'];
            $announcement['images'] = $imagesByAnnouncement[$id] ?? [];
            
            // Set default category if not specified
            if (empty($announcement['category'])) {
                $announcement['category'] = 'general';
            }
        }
    }
    
    logError("Final processing complete. Total announcements: " . count($announcements));

    $response = [
        'status' => 'success',
        'announcements' => $announcements,
        'filters_applied' => [
            'search' => $searchTerm,
            'category' => $category,
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ]
    ];
    
    logError("API Request completed successfully");
    
    // Clear any previous output
    ob_end_clean();
    
    // Send JSON response
    echo json_encode($response);

} catch (PDOException $e) {
    logError("Database error: " . $e->getMessage());
    logError("Query that caused error: " . ($query ?? 'No query available'));
    
    // Clear any previous output
    ob_end_clean();
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Error fetching data: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    logError("General error: " . $e->getMessage());
    logError("Trace: " . $e->getTraceAsString());
    
    // Clear any previous output
    ob_end_clean();
    
    echo json_encode([
        'status' => 'error',
        'message' => 'An unexpected error occurred: ' . $e->getMessage()
    ]);
}
?>