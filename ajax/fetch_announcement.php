<?php
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
    // Inspect the database schema first
    logError("Checking database schema");
    
    // Check orgmembers_tbl
    try {
        $schemaQuery = "DESCRIBE orgmembers_tbl";
        $schemaStmt = $db->query($schemaQuery);
        $columns = $schemaStmt->fetchAll(PDO::FETCH_COLUMN);
        logError("orgmembers_tbl columns: " . implode(", ", $columns));
    } catch (Exception $e) {
        logError("Error checking orgmembers_tbl schema: " . $e->getMessage());
    }
    
    // Base query using the exact schema structure
    $query = "
    SELECT 
        a.*,
        u_creator.users_username AS creator_name,
        u_created_by.users_username AS created_by_name,
        om.username AS org_member_name,
        o.org_name,
        o.org_image,
        GROUP_CONCAT(ai.image_path) AS announcement_images
    FROM announcement_tbl a 
    LEFT JOIN users_tbl u_creator ON a.announcement_creator = u_creator.users_id
    LEFT JOIN users_tbl u_created_by ON a.created_by = u_created_by.users_id
    LEFT JOIN orgmembers_tbl om ON a.created_by = om.id
    LEFT JOIN organization_tbl o ON u_creator.users_org = o.org_id
    LEFT JOIN announcement_images ai ON a.announcement_id = ai.announcement_id
    WHERE a.is_archived = 0
    AND (u_creator.users_org = :orgId OR u_created_by.users_org = :orgId)
    GROUP BY a.announcement_id
    ";

    $params = [':orgId' => $orgId];
    
    // Log the base query
    logError("Base query: " . $query);

    // Add search filter if provided
    if (!empty($searchTerm)) {
        $query = str_replace("WHERE a.is_archived = 0", 
            "WHERE a.is_archived = 0 AND (
                a.announcement_title LIKE :search 
                OR a.announcement_details LIKE :search 
                OR u_creator.users_username LIKE :search
                OR u_created_by.users_username LIKE :search
                OR om.username LIKE :search
            )", $query);
        $params[':search'] = "%$searchTerm%";
        logError("Search filter added for: '$searchTerm'");
    }

    // Add category filter if provided
    if (!empty($category) && $category !== 'all') {
        $query = str_replace("WHERE a.is_archived = 0", 
            "WHERE a.is_archived = 0 AND a.category = :category", $query);
        $params[':category'] = $category;
        logError("Category filter added for: '$category'");
    }

    // Add date filters if provided
    if (!empty($dateFrom)) {
        $query = str_replace("WHERE a.is_archived = 0", 
            "WHERE a.is_archived = 0 AND DATE(a.created_at) >= :dateFrom", $query);
        $params[':dateFrom'] = $dateFrom;
        logError("Date from filter added: $dateFrom");
    }
    
    if (!empty($dateTo)) {
        $query = str_replace("WHERE a.is_archived = 0", 
            "WHERE a.is_archived = 0 AND DATE(a.created_at) <= :dateTo", $query);
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

    // Process each announcement
    $processedCount = 0;
    $unknownAuthorCount = 0;
    
    foreach ($announcements as &$announcement) {
        // Log the current announcement being processed
        logError("Processing announcement ID: " . $announcement['announcement_id'] . ", Title: " . $announcement['announcement_title']);
        
        // Split images
        $announcement['images'] = $announcement['announcement_images'] ? explode(',', $announcement['announcement_images']) : [];
        unset($announcement['announcement_images']);
        
        // Set the author name based on available data
        if (!empty($announcement['creator_name'])) {
            $announcement['author_name'] = $announcement['creator_name'];
            logError("Using creator_name for author: " . $announcement['author_name']);
        } elseif (!empty($announcement['created_by_name'])) {
            $announcement['author_name'] = $announcement['created_by_name'];
            logError("Using created_by_name for author: " . $announcement['author_name']);
        } elseif (!empty($announcement['org_member_name'])) {
            $announcement['author_name'] = $announcement['org_member_name'];
            logError("Using org_member_name for author: " . $announcement['author_name']);
        } else {
            logError("No author found in main query, trying direct lookups");
            
            // Last resort - try direct lookups
            $creatorId = $announcement['announcement_creator'] ?? 0;
            $createdById = $announcement['created_by'] ?? 0;
            
            logError("Creator ID: $creatorId, Created By ID: $createdById");
            
            if ($creatorId > 0) {
                $userQuery = "SELECT users_username FROM users_tbl WHERE users_id = :id";
                $userStmt = $db->prepare($userQuery);
                $userStmt->execute([':id' => $creatorId]);
                $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($userResult && !empty($userResult['users_username'])) {
                    $announcement['author_name'] = $userResult['users_username'];
                    $announcement['creator_name'] = $userResult['users_username'];
                    logError("Found author via direct users_tbl lookup: " . $announcement['author_name']);
                }
            }
            
            if (empty($announcement['author_name']) && $createdById > 0) {
                // Try looking up in orgmembers_tbl
                $memberQuery = "SELECT username FROM orgmembers_tbl WHERE id = :id";
                $memberStmt = $db->prepare($memberQuery);
                $memberStmt->execute([':id' => $createdById]);
                $memberResult = $memberStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($memberResult && !empty($memberResult['username'])) {
                    $announcement['author_name'] = $memberResult['username'];
                    $announcement['creator_name'] = $memberResult['username'];
                    logError("Found author via direct orgmembers_tbl lookup: " . $announcement['author_name']);
                }
            }
            
            // Default if all else fails
            if (empty($announcement['author_name'])) {
                $announcement['author_name'] = 'Unknown';
                $announcement['creator_name'] = 'Unknown';
                logError("Could not find author name for announcement ID: " . $announcement['announcement_id']);
                $unknownAuthorCount++;
            }
        }
        
        // Clean up redundant fields but keep creator_name
        unset($announcement['created_by_name']);
        unset($announcement['org_member_name']);
        
        // Determine category based on content or use existing category field
        if (!empty($announcement['category'])) {
            logError("Using existing category: " . $announcement['category']);
        } else {
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
            logError("Determined category: " . $announcement['category']);
        }
        
        $processedCount++;
    }
    
    logError("Processing complete. Total announcements: " . count($announcements) . ", Unknown authors: $unknownAuthorCount");

    // Check for problematic announcements
    $checkQuery = "
    SELECT a.announcement_id, a.announcement_title, a.announcement_creator, a.created_by
    FROM announcement_tbl a
    LEFT JOIN users_tbl u1 ON a.announcement_creator = u1.users_id
    LEFT JOIN users_tbl u2 ON a.created_by = u2.users_id
    LEFT JOIN orgmembers_tbl om ON a.created_by = om.id
    WHERE u1.users_username IS NULL AND u2.users_username IS NULL AND om.username IS NULL
    ";
    $checkStmt = $db->query($checkQuery);
    $problematicAnnouncements = $checkStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($problematicAnnouncements)) {
        logError("Found " . count($problematicAnnouncements) . " announcements with missing author information:");
        foreach ($problematicAnnouncements as $pa) {
            logError("ID: " . $pa['announcement_id'] . ", Title: " . $pa['announcement_title'] . 
                     ", Creator ID: " . $pa['announcement_creator'] . ", Created By ID: " . $pa['created_by']);
        }
    } else {
        logError("No problematic announcements found.");
    }

    // Prepare the response
    $response = [
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
            'processed_count' => $processedCount,
            'unknown_authors' => $unknownAuthorCount,
            'problematic_announcements' => count($problematicAnnouncements)
        ]
    ];

    // Log the response summary
    logError("Response prepared. Total announcements: " . count($announcements) . 
             ", Processed: $processedCount, Unknown authors: $unknownAuthorCount");

    // Send the JSON response
    echo json_encode($response);

} catch (Exception $e) {
    logError("Error occurred: " . $e->getMessage());
    echo json_encode(['error' => 'An error occurred while processing the request: ' . $e->getMessage()]);
}

// Log the end of the API request
logError("API Request completed");