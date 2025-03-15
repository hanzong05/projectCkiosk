<?php
// Turn off error display - very important for JSON responses
ini_set('log_errors', 1);
ini_set('error_log', '/error.log');
error_reporting(E_ALL);

// Set JSON header right at the start
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
    
    // Base query to get metrics
    $sql = "SELECT 
        AVG(mastery_rating) as mastery_rating,
        AVG(video_quality) as video_quality,
        AVG(audio_quality) as audio_quality,
        AVG(activity_relevance) as activity_relevance,
        AVG(time_management) as time_mgmt,
        AVG(conduct) as conduct,
        AVG(topic_informative) as topic_info
    FROM event_feedback 
    WHERE 1=1";

    // Add time filter
    if ($timeFilter === 'week') {
        $sql .= " AND submitted_at >= DATE_SUB(CURRENT_DATE, INTERVAL 1 WEEK)";
    } else if ($timeFilter === 'month') {
        $sql .= " AND submitted_at >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
    }

    // Add organization filter
    if ($orgFilter !== 'all') {
        $sql .= " AND organization_id = :org_id";
    }

    // Account type specific filters
    if ($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') {
        $sql .= " AND organization_id = (
            SELECT users_org 
            FROM users_tbl 
            WHERE users_id = :user_id
        )";
    }

    // Prepare and execute the query
    $stmt = $connect->prepare($sql);

    // Bind parameters
    if ($orgFilter !== 'all') {
        $stmt->bindParam(':org_id', $orgFilter, PDO::PARAM_INT);
    }
    if ($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') {
        $stmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    }

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get performance metrics data
    $performanceSQL = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN video_quality >= 4 THEN 1 ELSE 0 END) as video_excellent,
        SUM(CASE WHEN video_quality = 3 THEN 1 ELSE 0 END) as video_good,
        SUM(CASE WHEN video_quality = 2 THEN 1 ELSE 0 END) as video_fair,
        SUM(CASE WHEN video_quality <= 1 THEN 1 ELSE 0 END) as video_poor
    FROM event_feedback 
    WHERE 1=1";

    // Add same filters as above
    if ($timeFilter === 'week') {
        $performanceSQL .= " AND submitted_at >= DATE_SUB(CURRENT_DATE, INTERVAL 1 WEEK)";
    } else if ($timeFilter === 'month') {
        $performanceSQL .= " AND submitted_at >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
    }
    if ($orgFilter !== 'all') {
        $performanceSQL .= " AND organization_id = :org_id";
    }
    if ($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') {
        $performanceSQL .= " AND organization_id = (
            SELECT users_org 
            FROM users_tbl 
            WHERE users_id = :user_id
        )";
    }

    $perfStmt = $connect->prepare($performanceSQL);
    if ($orgFilter !== 'all') {
        $perfStmt->bindParam(':org_id', $orgFilter, PDO::PARAM_INT);
    }
    if ($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') {
        $perfStmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    }
    $perfStmt->execute();
    $perfResult = $perfStmt->fetch(PDO::FETCH_ASSOC);

    // Ensure we have numerical values, even if null
    $response = [
        'metrics' => [
            'participant_rating' => is_null($result['mastery_rating']) ? 0 : floatval($result['mastery_rating']),
            'video_quality' => is_null($result['video_quality']) ? 0 : floatval($result['video_quality']),
            'audio_quality' => is_null($result['audio_quality']) ? 0 : floatval($result['audio_quality']),
            'overall_impact' => is_null($result['activity_relevance']) ? 0 : floatval($result['activity_relevance'])
        ],
        'quality_distribution' => [
            'video_excellent' => intval($perfResult['video_excellent'] ?? 0),
            'video_good' => intval($perfResult['video_good'] ?? 0),
            'video_fair' => intval($perfResult['video_fair'] ?? 0),
            'video_poor' => intval($perfResult['video_poor'] ?? 0)
        ],
        'performance_metrics' => [
            'content_quality' => is_null($result['topic_info']) ? 0 : floatval($result['topic_info']),
            'engagement' => is_null($result['conduct']) ? 0 : floatval($result['conduct']),
            'time_management' => is_null($result['time_mgmt']) ? 0 : floatval($result['time_mgmt']),
            'activity_relevance' => is_null($result['activity_relevance']) ? 0 : floatval($result['activity_relevance'])
        ]
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
} catch (Exception $e) {
    error_log('General error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred']);
}
?>