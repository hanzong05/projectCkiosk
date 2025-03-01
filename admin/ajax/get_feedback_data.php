<?php
// ajax/get_feedback_data.php
session_start();

// Set JSON content type
header('Content-Type: application/json');

// Error handling configuration
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

// Debug log file
define('DEBUG_LOG_FILE', __DIR__ . '/debug_log.txt');

// Utility Functions
function debugLog($message, $data = null) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    if ($data !== null) {
        $logMessage .= "\nData: " . print_r($data, true);
    }
    $logMessage .= "\n" . str_repeat('-', 50) . "\n";
    error_log($logMessage, 3, DEBUG_LOG_FILE);
}

function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function validateDateRange($timeFilter) {
    $validRanges = ['all', 'month', 'week'];
    return in_array($timeFilter, $validRanges) ? $timeFilter : 'all';
}

function getDateRangeCondition($timeFilter, $type) {
    $dateField = $type === 'office' ? 'feedback_date' : 'created_at';
    switch($timeFilter) {
        case 'month':
            return "$dateField >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        case 'week':
            return "$dateField >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
        default:
            return null;
    }
}

function getUserOrgId($connect, $userId) {
    $stmt = $connect->prepare("SELECT users_org FROM users_tbl WHERE users_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
}

function getOfficeFeedbackData($connect, $whereConditions, $params) {
    $sqdFields = [
        'sqd0_satisfaction',
        'sqd1_time',
        'sqd2_requirements',
        'sqd3_steps',
        'sqd4_information'
    ];

    // Get SQD metrics
    $sqdMetricsSQL = "SELECT " . 
        implode(", ", array_map(function($field) {
            return "COALESCE(AVG($field), 0) as avg_" . str_replace('sqd', '', $field);
        }, $sqdFields)) . 
        ", COUNT(*) as total_feedback
        FROM office_feedback" .
        (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "");

    $stmt = $connect->prepare($sqdMetricsSQL);
    $stmt->execute($params);
    $metrics = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get SQD distributions
    $distributions = [];
    foreach ($sqdFields as $field) {
        $sql = "SELECT $field, COUNT(*) as count 
               FROM office_feedback " .
               (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "") .
               " GROUP BY $field 
               ORDER BY $field";

        $stmt = $connect->prepare($sql);
        $stmt->execute($params);
        $distributions[$field] = array_map('intval', $stmt->fetchAll(PDO::FETCH_KEY_PAIR));
    }

    // Get trend data
    $trendSQL = "SELECT 
        DATE(feedback_date) as date,
        ROUND(AVG((sqd0_satisfaction + sqd1_time + sqd2_requirements + sqd3_steps + sqd4_information) / 5), 2) as avg_rating
        FROM office_feedback " .
        (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "") .
        " GROUP BY DATE(feedback_date)
        ORDER BY date ASC
        LIMIT 10";

    $stmt = $connect->prepare($trendSQL);
    $stmt->execute($params);
    $trend = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // CC Metrics Calculation
    $ccSQL = "SELECT
        -- Awareness
        COUNT(CASE WHEN cc_awareness IN ('learned', 'aware_saw') THEN 1 END) as awareness_positive_count,
        COUNT(CASE WHEN cc_awareness = 'aware_not_saw' THEN 1 END) as awareness_neutral_count,
        COUNT(CASE WHEN cc_awareness = 'unaware' THEN 1 END) as awareness_negative_count,
        
        -- Visibility
        COUNT(CASE WHEN cc_visibility = 'easy' THEN 1 END) as visibility_positive_count,
        COUNT(CASE WHEN cc_visibility = 'moderate' THEN 1 END) as visibility_neutral_count,
        COUNT(CASE WHEN cc_visibility = 'hard' THEN 1 END) as visibility_negative_count,
        
        -- Helpfulness
        COUNT(CASE WHEN cc_helpfulness = 'helped_very_much' THEN 1 END) as helpfulness_positive_count,
        COUNT(CASE WHEN cc_helpfulness = 'helped' THEN 1 END) as helpfulness_neutral_count,
        COUNT(CASE WHEN cc_helpfulness = 'not_helped' THEN 1 END) as helpfulness_negative_count,
        
        -- Totals
        COUNT(CASE WHEN cc_awareness IS NOT NULL THEN 1 END) as total_awareness,
        COUNT(CASE WHEN cc_visibility IS NOT NULL THEN 1 END) as total_visibility,
        COUNT(CASE WHEN cc_helpfulness IS NOT NULL THEN 1 END) as total_helpfulness
        
        FROM office_feedback" .
        (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "");

    $stmt = $connect->prepare($ccSQL);
    $stmt->execute($params);
    $ccCounts = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calculate CC metrics
    $calculatePercentage = function($count, $total) {
        return $total > 0 ? round(($count / $total) * 100, 1) : 0;
    };

    $ccDistribution = [
        'awareness' => [
            'positive' => $calculatePercentage($ccCounts['awareness_positive_count'], $ccCounts['total_awareness']),
            'neutral' => $calculatePercentage($ccCounts['awareness_neutral_count'], $ccCounts['total_awareness']),
            'negative' => $calculatePercentage($ccCounts['awareness_negative_count'], $ccCounts['total_awareness'])
        ],
        'visibility' => [
            'positive' => $calculatePercentage($ccCounts['visibility_positive_count'], $ccCounts['total_visibility']),
            'neutral' => $calculatePercentage($ccCounts['visibility_neutral_count'], $ccCounts['total_visibility']),
            'negative' => $calculatePercentage($ccCounts['visibility_negative_count'], $ccCounts['total_visibility'])
        ],
        'helpfulness' => [
            'positive' => $calculatePercentage($ccCounts['helpfulness_positive_count'], $ccCounts['total_helpfulness']),
            'neutral' => $calculatePercentage($ccCounts['helpfulness_neutral_count'], $ccCounts['total_helpfulness']),
            'negative' => $calculatePercentage($ccCounts['helpfulness_negative_count'], $ccCounts['total_helpfulness'])
        ]
    ];

    // Calculate average scores for metric cards
    $ccMetricsSQL = "SELECT
        AVG(CASE 
            WHEN cc_awareness IN ('learned', 'aware_saw') THEN 3
            WHEN cc_awareness = 'aware_not_saw' THEN 2
            WHEN cc_awareness = 'unaware' THEN 1
            ELSE NULL 
        END) as avg_cc_awareness,
        
        AVG(CASE 
            WHEN cc_visibility = 'easy' THEN 3
            WHEN cc_visibility = 'moderate' THEN 2
            WHEN cc_visibility = 'hard' THEN 1
            ELSE NULL 
        END) as avg_cc_visibility,
        
        AVG(CASE 
            WHEN cc_helpfulness = 'helped_very_much' THEN 3
            WHEN cc_helpfulness = 'helped' THEN 2
            WHEN cc_helpfulness = 'not_helped' THEN 1
            ELSE NULL 
        END) as avg_cc_helpfulness
        
        FROM office_feedback" .
        (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "");

    $stmt = $connect->prepare($ccMetricsSQL);
    $stmt->execute($params);
    $ccMetrics = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return all data
    return [
        'metrics' => array_merge($metrics, [
            'avg_cc_awareness' => round(floatval($ccMetrics['avg_cc_awareness'] ?? 0), 1),
            'avg_cc_visibility' => round(floatval($ccMetrics['avg_cc_visibility'] ?? 0), 1),
            'avg_cc_helpfulness' => round(floatval($ccMetrics['avg_cc_helpfulness'] ?? 0), 1)
        ]),
        'distributions' => $distributions,
        'trend' => $trend,
        'cc_metrics' => [
            'cc_awareness' => round(floatval($ccMetrics['avg_cc_awareness'] ?? 0), 1),
            'cc_visibility' => round(floatval($ccMetrics['avg_cc_visibility'] ?? 0), 1),
            'cc_helpfulness' => round(floatval($ccMetrics['avg_cc_helpfulness'] ?? 0), 1)
        ],
        'cc_distribution' => $ccDistribution
    ];
}

function getOrgFeedbackData($connect, $whereConditions, $params) {
    $ratingFields = [
        'event_quality_rating',
        'communication_rating',
        'inclusivity_rating',
        'leadership_rating',
        'skill_dev_rating',
        'impact_rating'
    ];

    // Get metrics
    $metricsSQL = "SELECT " . 
        implode(", ", array_map(function($field) {
            return "COALESCE(AVG($field), 0) as avg_" . str_replace('_rating', '', $field);
        }, $ratingFields)) . 
        ", COUNT(*) as total_feedback
        FROM org_feedback" .
        (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "");

    debugLog('Organization Metrics Query', ['sql' => $metricsSQL, 'params' => $params]);

    $stmt = $connect->prepare($metricsSQL);
    $stmt->execute($params);
    $metrics = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get distributions
    $distributions = [];
    foreach ($ratingFields as $field) {
        $sql = "SELECT $field, COUNT(*) as count 
               FROM org_feedback " .
               (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "") .
               " GROUP BY $field 
               ORDER BY $field";

        $stmt = $connect->prepare($sql);
        $stmt->execute($params);
        $distributions[$field] = array_map('intval', $stmt->fetchAll(PDO::FETCH_KEY_PAIR));
    }

    // Get trend data
    $avgFields = "(" . implode(" + ", $ratingFields) . ") / " . count($ratingFields);
    $trendSQL = "SELECT 
            DATE(created_at) as date,
            ROUND(AVG($avgFields), 2) as avg_rating
            FROM org_feedback" .
            (!empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : "") .
            " GROUP BY DATE(created_at)
            ORDER BY date DESC
            LIMIT 10";

    $stmt = $connect->prepare($trendSQL);
    $stmt->execute($params);
    $trend = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'metrics' => $metrics,
        'distributions' => $distributions,
        'trend' => $trend
    ];
}

try {
    // Include database connection
    require_once "../../class/connection.php";

    // Verify user authentication
    if (!isset($_SESSION['atype'])) {
        throw new Exception('User not authenticated');
    }

    // Get parameters
    $accountType = $_SESSION['atype'];
    $userId = $_SESSION['id'] ?? null;
    $type = isset($_GET['type']) ? sanitizeInput($_GET['type']) : 'office';
    $timeFilter = validateDateRange($_GET['time'] ?? 'all');
    $orgId = isset($_GET['org']) ? sanitizeInput($_GET['org']) : 'all';

    debugLog('Request parameters', [
        'accountType' => $accountType,
        'userId' => $userId,
        'type' => $type,
        'timeFilter' => $timeFilter,
        'orgId' => $orgId
    ]);

    // Build base query conditions
    $whereConditions = [];
    $params = [];

    // Add date range condition
    $dateRangeCondition = getDateRangeCondition($timeFilter, $type);
    if ($dateRangeCondition) {
        $whereConditions[] = $dateRangeCondition;
    }

    // Add organization-specific conditions
    if ($type === 'org') {
        if ($accountType == '3') {
            $whereConditions[] = "org_id IN (
                SELECT org_type 
                FROM orgmembers_tbl 
                WHERE id = :member_id 
                AND is_active = 1
            )";
            $params[':member_id'] = $userId;
        } else if ($accountType == '2') {
            $userOrgId = getUserOrgId($connect, $userId);
            if (!$userOrgId) {
                throw new Exception('User organization not found');
            }
            $whereConditions[] = "org_id = :org_id";
            $params[':org_id'] = $userOrgId;
        } else if ($orgId !== 'all') {
            $whereConditions[] = "org_id = :org_id";
            $params[':org_id'] = $orgId;
        }
    }

    // Get feedback data based on type
    $data = ($type === 'office') 
        ? getOfficeFeedbackData($connect, $whereConditions, $params)
        : getOrgFeedbackData($connect, $whereConditions, $params);

    // Add organizations list for org type
    if ($type === 'org' && $accountType === '4') {
        $orgQuery = "SELECT org_id, org_name FROM organization_tbl ORDER BY org_name";
        $stmt = $connect->prepare($orgQuery);
        $stmt->execute();
        $data['organizations'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    debugLog('Response data', $data);
    echo json_encode($data);

} catch (PDOException $e) {
    debugLog('Database error', ['message' => $e->getMessage()]);
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Database error occurred',
        'debug' => DEBUG_MODE ? $e->getMessage() : null
    ]);
} catch (Exception $e) {
    debugLog('General error', ['message' => $e->getMessage()]);
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'debug' => DEBUG_MODE ? $e->getMessage() : null
    ]);
}