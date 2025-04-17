<?php
// Turn off error display for production, but log errors
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/event_eval_error.log');
error_reporting(E_ALL);

// Set JSON header
header('Content-Type: application/json');

require_once('../../class/connection.php');

// Check if user is logged in
session_start();
if (!isset($_SESSION['atype'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    // Get filter parameters
    $timeFilter = isset($_GET['time']) ? $_GET['time'] : 'all';
    $orgFilter = isset($_GET['org']) ? $_GET['org'] : 'all';
    
    // Determine the organization ID
    $orgId = null;
    if ($orgFilter !== 'all') {
        $orgId = $orgFilter;
    } else if ($_SESSION['atype'] == '2') {
        // Get org ID for org admin
        $userStmt = $connect->prepare("SELECT users_org FROM users_tbl WHERE users_id = :user_id");
        $userStmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $userStmt->execute();
        $userOrg = $userStmt->fetch(PDO::FETCH_ASSOC);
        if ($userOrg) {
            $orgId = $userOrg['users_org'];
        }
    } else if ($_SESSION['atype'] == '3') {
        // Get org ID for org member
        $userStmt = $connect->prepare("SELECT org_type FROM orgmembers_tbl WHERE id = :user_id");
        $userStmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $userStmt->execute();
        $userOrg = $userStmt->fetch(PDO::FETCH_ASSOC);
        if ($userOrg) {
            $orgId = $userOrg['org_type'];
        }
    }
    
    // Debug information
    $debug = [
        'time_filter' => $timeFilter,
        'org_filter' => $orgFilter,
        'account_type' => $_SESSION['atype'],
        'user_id' => $_SESSION['id'] ?? null,
        'determined_org_id' => $orgId
    ];
    
    // If no organization ID could be determined, return zeros
    if (!$orgId) {
        $response = [
            'metrics' => [
                'participant_rating' => 0,
                'video_quality' => 0,
                'audio_quality' => 0,
                'overall_impact' => 0
            ],
            'performance_metrics' => [
                'content_quality' => 0,
                'engagement' => 0,
                'time_management' => 0,
                'activity_relevance' => 0
            ],
            'methodology_metrics' => [
                'clarity' => 0,
                'engagement' => 0,
                'interactivity' => 0,
                'resources' => 0,
                'time_management' => 0
            ],
            'debug' => $debug,
            'message' => 'No organization ID could be determined'
        ];
        echo json_encode($response);
        exit;
    }
    
    // Base query to get metrics - USING THE EXACT COLUMN NAMES
    $sql = "SELECT 
        AVG(mastery_rating) as mastery_rating,
        AVG(video_quality) as video_quality,
        AVG(audio_quality) as audio_quality,
        AVG(activity_relevance) as activity_relevance,
        AVG(time_management) as time_management,
        AVG(conduct) as conduct,
        AVG(topic_informative) as topic_informative
    FROM event_feedback 
    WHERE organization_id = :org_id";

    // Add time filter
    if ($timeFilter === 'week') {
        $sql .= " AND submitted_at >= DATE_SUB(CURRENT_DATE, INTERVAL 1 WEEK)";
    } else if ($timeFilter === 'month') {
        $sql .= " AND submitted_at >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
    }

    $debug['sql'] = $sql;
    $debug['params'] = ['org_id' => $orgId];

    // Prepare and execute the query
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':org_id', $orgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Also check how many rows we have in total
    $countSql = "SELECT COUNT(*) as count FROM event_feedback WHERE organization_id = :org_id";
    $countStmt = $connect->prepare($countSql);
    $countStmt->bindParam(':org_id', $orgId, PDO::PARAM_INT);
    $countStmt->execute();
    $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);
    
    $debug['has_rows'] = ($stmt->rowCount() > 0);
    $debug['total_rows'] = $countResult['count'] ?? 0;
    $debug['raw_result'] = $result;

    // Ensure we have numerical values, even if null
    $response = [
        'metrics' => [
            'participant_rating' => floatval($result['mastery_rating'] ?? 0),
            'video_quality' => floatval($result['video_quality'] ?? 0),
            'audio_quality' => floatval($result['audio_quality'] ?? 0),
            'overall_impact' => floatval($result['activity_relevance'] ?? 0)
        ],
        'performance_metrics' => [
            'content_quality' => floatval($result['topic_informative'] ?? 0),
            'engagement' => floatval($result['conduct'] ?? 0),
            'time_management' => floatval($result['time_management'] ?? 0),
            'activity_relevance' => floatval($result['activity_relevance'] ?? 0)
        ],
        // Add methodology metrics (using existing data as placeholders)
        'methodology_metrics' => [
            'clarity' => floatval($result['conduct'] ?? 0),
            'engagement' => floatval($result['conduct'] ?? 0),
            'interactivity' => floatval($result['conduct'] ?? 0),
            'resources' => floatval($result['topic_informative'] ?? 0),
            'time_management' => floatval($result['time_management'] ?? 0)
        ],
        'debug' => $debug
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error occurred',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
} catch (Exception $e) {
    error_log('General error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'An error occurred',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?>
