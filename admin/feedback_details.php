<?php


session_start();
include_once('../class/connection.php');
// Start the session and include necessary files
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/error_log.txt');
error_log("TEST: Logging is working");
// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['atype']) || !in_array($_SESSION['atype'], ['0', '2', '3', '4'])) {
    header("Location: index.php");
    exit;
}

// Determine which feedback table to use based on atype
$feedback_table = ($_SESSION['atype'] == '0') ? 'office_feedback' : 'org_feedback';
$is_office_feedback = ($_SESSION['atype'] == '0');

// Get date filter parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-6 months'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Ensure dates are in proper format (YYYY-MM-DD)
$start_date_formatted = date('Y-m-d', strtotime($start_date));
$end_date_formatted = date('Y-m-d', strtotime($end_date));

// For database queries, we can use these dates directly
$start_date_full = $start_date_formatted;
$end_date_full = $end_date_formatted;

// Define safe_divide function for percentage calculations
function safe_divide($numerator, $denominator, $default = 0) {
    return ($denominator > 0) ? (($numerator / $denominator) * 100) : $default;
}

try {
    // Initialize data arrays
    $cc1_results = $cc2_results = $cc3_results = [];
    $sqd_stats = [];
    $org_stats = [];
    $org_id = null;
    try {
        if ($_SESSION['atype'] == '2') {
            // For organization admin
            try {
                $userStmt = $connect->prepare("SELECT users_org FROM users_tbl WHERE users_id = :user_id");
                $userStmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
                
                // Log the query details before execution
                error_log("Admin Org Query: " . $userStmt->queryString);
                error_log("User ID: " . $_SESSION['id']);
                
                $userStmt->execute();
                
                // Log the execution result
                $rowCount = $userStmt->rowCount();
                error_log("Number of rows returned: " . $rowCount);
                
                $userOrg = $userStmt->fetch(PDO::FETCH_ASSOC);
                
                // Detailed logging of fetched data
                error_log("Fetched Organization Data: " . print_r($userOrg, true));
                
                if ($userOrg && !empty($userOrg['users_org'])) {
                    $org_id = $userOrg['users_org'];
                    error_log("Organization ID for admin user {$_SESSION['id']}: $org_id");
                } else {
                    error_log("No organization found for admin user ID: {$_SESSION['id']}");
                    error_log("Session Details: " . print_r($_SESSION, true));
                    $org_id = null;
                }
            } catch (PDOException $e) {
                // Comprehensive error logging for admin query
                error_log("Admin Organization Query Error: " . $e->getMessage());
                error_log("Error Code: " . $e->getCode());
                error_log("SQL State: " . $e->getSQLState());
                error_log("Trace: " . $e->getTraceAsString());
                error_log("User ID: " . $_SESSION['id']);
                $org_id = null;
            }
        } else if ($_SESSION['atype'] == '3') {
            // Similar detailed logging for member query
            try {
                $userStmt = $connect->prepare("SELECT org_type FROM orgmembers_tbl WHERE id = :user_id AND is_active = 1");
                $userStmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
                
                error_log("Member Org Query: " . $userStmt->queryString);
                error_log("User ID: " . $_SESSION['id']);
                
                $userStmt->execute();
                
                $rowCount = $userStmt->rowCount();
                error_log("Number of rows returned: " . $rowCount);
                
                $userOrg = $userStmt->fetch(PDO::FETCH_ASSOC);
                
                error_log("Fetched Organization Data: " . print_r($userOrg, true));
                
                if ($userOrg && !empty($userOrg['org_type'])) {
                    $org_id = $userOrg['org_type'];
                    error_log("Organization ID for member user {$_SESSION['id']}: $org_id");
                } else {
                    error_log("No organization found for member user ID: {$_SESSION['id']}");
                    error_log("Session Details: " . print_r($_SESSION, true));
                    $org_id = null;
                }
            } catch (PDOException $e) {
                // Comprehensive error logging for member query
                error_log("Member Organization Query Error: " . $e->getMessage());
                error_log("Error Code: " . $e->getCode());
                error_log("SQL State: " . $e->getSQLState());
                error_log("Trace: " . $e->getTraceAsString());
                error_log("User ID: " . $_SESSION['id']);
                $org_id = null;
            }
        } else {
            // Log unexpected account type
            error_log("Unexpected account type: {$_SESSION['atype']}");
            error_log("Full Session Data: " . print_r($_SESSION, true));
            $org_id = null;
        }
    } catch (Exception $e) {
        // Catch any unexpected exceptions
        error_log("Unexpected Error in Organization Retrieval: " . $e->getMessage());
        error_log("Trace: " . $e->getTraceAsString());
        error_log("Full Session Data: " . print_r($_SESSION, true));
        $org_id = null;
    }
    
    // Critical logging if no organization is found
    if ($org_id === null) {
        error_log("CRITICAL: Failed to retrieve organization");
        error_log("Account Type: " . $_SESSION['atype']);
        error_log("User ID: " . $_SESSION['id']);
        error_log("Full Session Data: " . print_r($_SESSION, true));
        
        // Optional: You might want to set a default value or handle this case
        // For example:
        // $org_id = 0; // or some default organization ID
        // header('Location: error.php'); // redirect to an error page
    }
    // Get total count of feedback for the date range
    if ($is_office_feedback) {
        // Office feedback queries
        $total_sql = "SELECT COUNT(*) FROM {$feedback_table} WHERE feedback_date BETWEEN :start_date AND :end_date";
        $date_field = "feedback_date";
    } else {
        // Organization feedback queries
        $total_sql = "SELECT COUNT(*) FROM {$feedback_table} WHERE created_at BETWEEN :start_date AND :end_date";
        
        // Filter by organization for account types 2 and 3
        if (($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') && $org_id) {
            $total_sql .= " AND org_id = :org_id";
        }
        
        $date_field = "created_at";
    }
    
    $total_stmt = $connect->prepare($total_sql);
    $total_stmt->bindParam(':start_date', $start_date_full);
    $total_stmt->bindParam(':end_date', $end_date_full);
    
    // Bind organization ID if needed
    if (!$is_office_feedback && ($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') && $org_id) {
        $total_stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT);
    }
    
    $total_stmt->execute();
    $total_count = $total_stmt->fetchColumn();
    
    if ($is_office_feedback) {
        // Office Feedback Specific Queries
        // CC1 - Awareness Query with safe calculation
        $cc1_sql = "SELECT 
            cc_awareness,
            COUNT(*) as total
        FROM {$feedback_table} 
        WHERE feedback_date BETWEEN :start_date AND :end_date
        GROUP BY cc_awareness";
        $cc1_stmt = $connect->prepare($cc1_sql);
        $cc1_stmt->bindParam(':start_date', $start_date_full);
        $cc1_stmt->bindParam(':end_date', $end_date_full);
        $cc1_stmt->execute();
        $cc1_results = $cc1_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate percentages safely
        foreach ($cc1_results as &$result) {
            $result['percentage'] = safe_divide($result['total'], $total_count);
        }
        
        // CC2 - Visibility Query with safe calculation
        $cc2_sql = "SELECT 
            cc_visibility,
            COUNT(*) as total
        FROM {$feedback_table} 
        WHERE feedback_date BETWEEN :start_date AND :end_date
        GROUP BY cc_visibility";
        $cc2_stmt = $connect->prepare($cc2_sql);
        $cc2_stmt->bindParam(':start_date', $start_date_full);
        $cc2_stmt->bindParam(':end_date', $end_date_full);
        $cc2_stmt->execute();
        $cc2_results = $cc2_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate percentages safely
        foreach ($cc2_results as &$result) {
            $result['percentage'] = safe_divide($result['total'], $total_count);
        }
        
        // CC3 - Helpfulness Query with safe calculation
        $cc3_sql = "SELECT 
            cc_helpfulness,
            COUNT(*) as total
        FROM {$feedback_table} 
        WHERE feedback_date BETWEEN :start_date AND :end_date
        GROUP BY cc_helpfulness";
        $cc3_stmt = $connect->prepare($cc3_sql);
        $cc3_stmt->bindParam(':start_date', $start_date_full);
        $cc3_stmt->bindParam(':end_date', $end_date_full);
        $cc3_stmt->execute();
        $cc3_results = $cc3_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate percentages safely
        foreach ($cc3_results as &$result) {
            $result['percentage'] = safe_divide($result['total'], $total_count);
        }
        
        // SQD Query
        $sqd_sql = "SELECT 
            COUNT(CASE WHEN sqd0_satisfaction = 1 THEN 1 END) as sqd0_strongly_disagree,
            COUNT(CASE WHEN sqd0_satisfaction = 2 THEN 1 END) as sqd0_disagree,
            COUNT(CASE WHEN sqd0_satisfaction = 3 THEN 1 END) as sqd0_neutral,
            COUNT(CASE WHEN sqd0_satisfaction = 4 THEN 1 END) as sqd0_agree,
            COUNT(CASE WHEN sqd0_satisfaction = 5 THEN 1 END) as sqd0_strongly_agree,
            COUNT(CASE WHEN sqd0_satisfaction IS NULL THEN 1 END) as sqd0_na,
            
            COUNT(CASE WHEN sqd1_time = 1 THEN 1 END) as sqd1_strongly_disagree,
            COUNT(CASE WHEN sqd1_time = 2 THEN 1 END) as sqd1_disagree,
            COUNT(CASE WHEN sqd1_time = 3 THEN 1 END) as sqd1_neutral,
            COUNT(CASE WHEN sqd1_time = 4 THEN 1 END) as sqd1_agree,
            COUNT(CASE WHEN sqd1_time = 5 THEN 1 END) as sqd1_strongly_agree,
            COUNT(CASE WHEN sqd1_time IS NULL THEN 1 END) as sqd1_na,
            
            COUNT(CASE WHEN sqd2_requirements = 1 THEN 1 END) as sqd2_strongly_disagree,
            COUNT(CASE WHEN sqd2_requirements = 2 THEN 1 END) as sqd2_disagree,
            COUNT(CASE WHEN sqd2_requirements = 3 THEN 1 END) as sqd2_neutral,
            COUNT(CASE WHEN sqd2_requirements = 4 THEN 1 END) as sqd2_agree,
            COUNT(CASE WHEN sqd2_requirements = 5 THEN 1 END) as sqd2_strongly_agree,
            COUNT(CASE WHEN sqd2_requirements IS NULL THEN 1 END) as sqd2_na,
            
            COUNT(CASE WHEN sqd3_steps = 1 THEN 1 END) as sqd3_strongly_disagree,
            COUNT(CASE WHEN sqd3_steps = 2 THEN 1 END) as sqd3_disagree,
            COUNT(CASE WHEN sqd3_steps = 3 THEN 1 END) as sqd3_neutral,
            COUNT(CASE WHEN sqd3_steps = 4 THEN 1 END) as sqd3_agree,
            COUNT(CASE WHEN sqd3_steps = 5 THEN 1 END) as sqd3_strongly_agree,
            COUNT(CASE WHEN sqd3_steps IS NULL THEN 1 END) as sqd3_na,
            
            COUNT(CASE WHEN sqd4_information = 1 THEN 1 END) as sqd4_strongly_disagree,
            COUNT(CASE WHEN sqd4_information = 2 THEN 1 END) as sqd4_disagree,
            COUNT(CASE WHEN sqd4_information = 3 THEN 1 END) as sqd4_neutral,
            COUNT(CASE WHEN sqd4_information = 4 THEN 1 END) as sqd4_agree,
            COUNT(CASE WHEN sqd4_information = 5 THEN 1 END) as sqd4_strongly_agree,
            COUNT(CASE WHEN sqd4_information IS NULL THEN 1 END) as sqd4_na,
            
            COUNT(CASE WHEN sqd5_value = 1 THEN 1 END) as sqd5_strongly_disagree,
            COUNT(CASE WHEN sqd5_value = 2 THEN 1 END) as sqd5_disagree,
            COUNT(CASE WHEN sqd5_value = 3 THEN 1 END) as sqd5_neutral,
            COUNT(CASE WHEN sqd5_value = 4 THEN 1 END) as sqd5_agree,
            COUNT(CASE WHEN sqd5_value = 5 THEN 1 END) as sqd5_strongly_agree,
            COUNT(CASE WHEN sqd5_value IS NULL THEN 1 END) as sqd5_na,
            
            COUNT(CASE WHEN sqd6_security = 1 THEN 1 END) as sqd6_strongly_disagree,
            COUNT(CASE WHEN sqd6_security = 2 THEN 1 END) as sqd6_disagree,
            COUNT(CASE WHEN sqd6_security = 3 THEN 1 END) as sqd6_neutral,
            COUNT(CASE WHEN sqd6_security = 4 THEN 1 END) as sqd6_agree,
            COUNT(CASE WHEN sqd6_security = 5 THEN 1 END) as sqd6_strongly_agree,
            COUNT(CASE WHEN sqd6_security IS NULL THEN 1 END) as sqd6_na,
            
            COUNT(CASE WHEN sqd7_support = 1 THEN 1 END) as sqd7_strongly_disagree,
            COUNT(CASE WHEN sqd7_support = 2 THEN 1 END) as sqd7_disagree,
            COUNT(CASE WHEN sqd7_support = 3 THEN 1 END) as sqd7_neutral,
            COUNT(CASE WHEN sqd7_support = 4 THEN 1 END) as sqd7_agree,
            COUNT(CASE WHEN sqd7_support = 5 THEN 1 END) as sqd7_strongly_agree,
            COUNT(CASE WHEN sqd7_support IS NULL THEN 1 END) as sqd7_na,
            
            COUNT(CASE WHEN sqd8_outcome = 1 THEN 1 END) as sqd8_strongly_disagree,
            COUNT(CASE WHEN sqd8_outcome = 2 THEN 1 END) as sqd8_disagree,
            COUNT(CASE WHEN sqd8_outcome = 3 THEN 1 END) as sqd8_neutral,
            COUNT(CASE WHEN sqd8_outcome = 4 THEN 1 END) as sqd8_agree,
            COUNT(CASE WHEN sqd8_outcome = 5 THEN 1 END) as sqd8_strongly_agree,
            COUNT(CASE WHEN sqd8_outcome IS NULL THEN 1 END) as sqd8_na,
            
            COUNT(*) as total_responses
        FROM {$feedback_table} 
        WHERE feedback_date BETWEEN :start_date AND :end_date";
        $sqd_stmt = $connect->prepare($sqd_sql);
        $sqd_stmt->bindParam(':start_date', $start_date_full);
        $sqd_stmt->bindParam(':end_date', $end_date_full);
        $sqd_stmt->execute();
        $sqd_stats = $sqd_stmt->fetch(PDO::FETCH_ASSOC);
        
        // Calculate overall statistics
        $sqd_questions = [
            'SQD0' => 'I am satisfied with the service that I availed.',
            'SQD1' => 'I spent a reasonable amount of time for my transaction.',
            'SQD2' => 'The office followed the transaction\'s requirements and steps.',
            'SQD3' => 'The steps were easy and simple.',
            'SQD4' => 'I easily found information about my transaction.',
            'SQD5' => 'I paid the correct amount of fees.',
            'SQD6' => 'I feel the office was fair to everyone.',
            'SQD7' => 'I was treated courteously by the staff.',
            'SQD8' => 'I got what I needed from the office.'
        ];
        
        // Calculate overall rating
        $total_strongly_disagree = $total_disagree = $total_neutral = 0;
        $total_agree = $total_strongly_agree = $total_na = $grand_total = 0;

        foreach($sqd_questions as $key => $question) {
            $prefix = strtolower($key) . '_';
            $total_strongly_disagree += $sqd_stats[$prefix.'strongly_disagree'];
            $total_disagree += $sqd_stats[$prefix.'disagree'];
            $total_neutral += $sqd_stats[$prefix.'neutral'];
            $total_agree += $sqd_stats[$prefix.'agree'];
            $total_strongly_agree += $sqd_stats[$prefix.'strongly_agree'];
            $total_na += $sqd_stats[$prefix.'na'];
        }
        
        // Calculate overall rating with additional error handling
        $grand_total = $total_strongly_disagree + $total_disagree + $total_neutral + 
                     $total_agree + $total_strongly_agree + $total_na;
                     
        $responses_excluding_na = $grand_total - $total_na;

        $overall_rating = $responses_excluding_na > 0 ? 
            (($total_agree + $total_strongly_agree) / $responses_excluding_na * 100) : 
            0;

        // Calculate most common rating value for visualization
        $sqd_categories = ['strongly_disagree', 'disagree', 'neutral', 'agree', 'strongly_agree', 'na'];
        $sqd_totals = [];
        
        foreach ($sqd_categories as $category) {
            $total = 0;
            for ($i = 0; $i <= 8; $i++) {
                $prefix = "sqd{$i}_";
                $total += $sqd_stats[$prefix . $category];
            }
            $sqd_totals[$category] = $total;
        }
        
    } else {
        // Organization Feedback specific queries
        // Get statistics for organization feedback categories
        $org_sql = "SELECT 
            AVG(event_quality_rating) as avg_event_quality,
            AVG(communication_rating) as avg_communication,
            AVG(inclusivity_rating) as avg_inclusivity,
            AVG(leadership_rating) as avg_leadership,
            AVG(skill_dev_rating) as avg_skill_dev,
            AVG(impact_rating) as avg_impact,
            
            COUNT(CASE WHEN event_quality_rating = 1 THEN 1 END) as eq_1,
            COUNT(CASE WHEN event_quality_rating = 2 THEN 1 END) as eq_2,
            COUNT(CASE WHEN event_quality_rating = 3 THEN 1 END) as eq_3,
            COUNT(CASE WHEN event_quality_rating = 4 THEN 1 END) as eq_4,
            COUNT(CASE WHEN event_quality_rating = 5 THEN 1 END) as eq_5,
            
            COUNT(CASE WHEN communication_rating = 1 THEN 1 END) as comm_1,
            COUNT(CASE WHEN communication_rating = 2 THEN 1 END) as comm_2,
            COUNT(CASE WHEN communication_rating = 3 THEN 1 END) as comm_3,
            COUNT(CASE WHEN communication_rating = 4 THEN 1 END) as comm_4,
            COUNT(CASE WHEN communication_rating = 5 THEN 1 END) as comm_5,
            
            COUNT(CASE WHEN inclusivity_rating = 1 THEN 1 END) as incl_1,
            COUNT(CASE WHEN inclusivity_rating = 2 THEN 1 END) as incl_2,
            COUNT(CASE WHEN inclusivity_rating = 3 THEN 1 END) as incl_3,
            COUNT(CASE WHEN inclusivity_rating = 4 THEN 1 END) as incl_4,
            COUNT(CASE WHEN inclusivity_rating = 5 THEN 1 END) as incl_5,
            
            COUNT(CASE WHEN leadership_rating = 1 THEN 1 END) as lead_1,
            COUNT(CASE WHEN leadership_rating = 2 THEN 1 END) as lead_2,
            COUNT(CASE WHEN leadership_rating = 3 THEN 1 END) as lead_3,
            COUNT(CASE WHEN leadership_rating = 4 THEN 1 END) as lead_4,
            COUNT(CASE WHEN leadership_rating = 5 THEN 1 END) as lead_5,
            
            COUNT(CASE WHEN skill_dev_rating = 1 THEN 1 END) as skill_1,
            COUNT(CASE WHEN skill_dev_rating = 2 THEN 1 END) as skill_2,
            COUNT(CASE WHEN skill_dev_rating = 3 THEN 1 END) as skill_3,
            COUNT(CASE WHEN skill_dev_rating = 4 THEN 1 END) as skill_4,
            COUNT(CASE WHEN skill_dev_rating = 5 THEN 1 END) as skill_5,
            
            COUNT(CASE WHEN impact_rating = 1 THEN 1 END) as impact_1,
            COUNT(CASE WHEN impact_rating = 2 THEN 1 END) as impact_2,
            COUNT(CASE WHEN impact_rating = 3 THEN 1 END) as impact_3,
            COUNT(CASE WHEN impact_rating = 4 THEN 1 END) as impact_4,
            COUNT(CASE WHEN impact_rating = 5 THEN 1 END) as impact_5,
            
            COUNT(*) as total_responses
        FROM {$feedback_table} 
        WHERE created_at BETWEEN :start_date AND :end_date";
        
        // Add organization filter for account types 2 and 3
        if (($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') && $org_id) {
            $org_sql .= " AND org_id = :org_id";
        }
        
        $org_stmt = $connect->prepare($org_sql);
        $org_stmt->bindParam(':start_date', $start_date_full);
        $org_stmt->bindParam(':end_date', $end_date_full);
        
        // Bind organization ID if needed
        if (($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') && $org_id) {
            $org_stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT);
        }
        
        $org_stmt->execute();
        $org_stats = $org_stmt->fetch(PDO::FETCH_ASSOC);
        
        // Calculate overall rating for organization feedback
        $org_categories = [
            'event_quality_rating', 
            'communication_rating', 
            'inclusivity_rating', 
            'leadership_rating', 
            'skill_dev_rating', 
            'impact_rating'
        ];
        
        $total_ratings = 0;
        $sum_ratings = 0;
        
        foreach($org_categories as $category) {
            $avg_cat = 'avg_' . str_replace('_rating', '', $category);
            if (isset($org_stats[$avg_cat]) && !is_null($org_stats[$avg_cat])) {
                $sum_ratings += $org_stats[$avg_cat];
                $total_ratings++;
            }
        }
        
        $overall_rating = ($total_ratings > 0) ? (($sum_ratings / $total_ratings) * 20) : 0; // Convert from 5-point scale to percentage
        
        // Create distribution data for charts
        $org_totals = [
            'rating_1' => $org_stats['eq_1'] + $org_stats['comm_1'] + $org_stats['incl_1'] + $org_stats['lead_1'] + $org_stats['skill_1'] + $org_stats['impact_1'],
            'rating_2' => $org_stats['eq_2'] + $org_stats['comm_2'] + $org_stats['incl_2'] + $org_stats['lead_2'] + $org_stats['skill_2'] + $org_stats['impact_2'],
            'rating_3' => $org_stats['eq_3'] + $org_stats['comm_3'] + $org_stats['incl_3'] + $org_stats['lead_3'] + $org_stats['skill_3'] + $org_stats['impact_3'],
            'rating_4' => $org_stats['eq_4'] + $org_stats['comm_4'] + $org_stats['incl_4'] + $org_stats['lead_4'] + $org_stats['skill_4'] + $org_stats['impact_4'],
            'rating_5' => $org_stats['eq_5'] + $org_stats['comm_5'] + $org_stats['incl_5'] + $org_stats['lead_5'] + $org_stats['skill_5'] + $org_stats['impact_5']
        ];
    }
    
    // Determine rating text (same for both types)
    $rating_text = 'No Data';
    if ($total_count > 0) {
        if ($overall_rating >= 95) {
            $rating_text = "Excellent";
            $rating_color = "#28a745";
        } elseif ($overall_rating >= 90) {
            $rating_text = "Very Satisfactory";
            $rating_color = "#007bff";
        } elseif ($overall_rating >= 85) {
            $rating_text = "Satisfactory";
            $rating_color = "#17a2b8";
        } elseif ($overall_rating >= 80) {
            $rating_text = "Fair";
            $rating_color = "#ffc107";
        } else {
            $rating_text = "Poor";
            $rating_color = "#dc3545";
        }
    }
    
    // Fetch feedback data for the table - different fields based on feedback type
    $account_type = $_SESSION['atype']; 
    
    if ($is_office_feedback) {
        // Office feedback query
        $feedback_query = "SELECT 
            id,
            name,
            feedback_date,
            sqd0_satisfaction,
            sqd1_time,
            sqd2_requirements,
            sqd3_steps,
            sqd4_information,
            improvements
        FROM {$feedback_table} 
        WHERE feedback_date BETWEEN :start_date AND :end_date
        ORDER BY feedback_date DESC";
        
        $feedback_stmt = $connect->prepare($feedback_query);
        $feedback_stmt->bindParam(':start_date', $start_date_full);
        $feedback_stmt->bindParam(':end_date', $end_date_full);
        $feedback_stmt->execute();
        $feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format the date for display
        foreach ($feedbacks as &$feedback) {
            $feedback['formatted_date'] = date('M d, Y', strtotime($feedback['feedback_date']));
        }
    } else {
        // Organization feedback query
        $feedback_query = "SELECT 
            id,
            org_id,
            name,
            email,
            event_quality_rating,
            communication_rating,
            inclusivity_rating,
            leadership_rating,
            skill_dev_rating,
            impact_rating,
            improvements,
            created_at
        FROM {$feedback_table} 
        WHERE created_at BETWEEN :start_date AND :end_date";
        
        // Add organization filter for account types 2 and 3
        if (($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') && $org_id) {
            $feedback_query .= " AND org_id = :org_id";
        }
        
        $feedback_query .= " ORDER BY created_at DESC";
        
        $feedback_stmt = $connect->prepare($feedback_query);
        $feedback_stmt->bindParam(':start_date', $start_date_full);
        $feedback_stmt->bindParam(':end_date', $end_date_full);
        
        // Bind organization ID if needed
        if (($_SESSION['atype'] == '2' || $_SESSION['atype'] == '3') && $org_id) {
            $feedback_stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT);
        }
        
        $feedback_stmt->execute();
        $feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format the date for display
        foreach ($feedbacks as &$feedback) {
            $feedback['formatted_date'] = date('M d, Y', strtotime($feedback['created_at']));
        }
    }
    
} catch (PDOException $e) {
    // Log error
    error_log("Error in feedback report: " . $e->getMessage());
    // We'll show the error message in the page content
    $error_message = "Error generating report: " . $e->getMessage();
}

// Get current month and year for dashboard title
$current_month = date('F');
$current_year = date('Y');

// Determine the title based on the account type
$dashboard_title = ($is_office_feedback) ? "Office Feedback Dashboard" : "Organization Feedback Dashboard";

// Define organization feedback categories for display
$org_categories = [
    'event_quality_rating' => 'Event Quality',
    'communication_rating' => 'Communication', 
    'inclusivity_rating' => 'Inclusivity',
    'leadership_rating' => 'Leadership',
    'skill_dev_rating' => 'Skill Development',
    'impact_rating' => 'Impact'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Campus Kiosk Admin | <?php echo $dashboard_title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Original CSS -->
    <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="assets/css/css.css" rel="stylesheet" />
    
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Additional Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        /* Modern Dashboard Styles */
        :root {
            --primary-color: #4e73df;
            --secondary-color: #6c757d;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            --card-border-radius: 0.75rem;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            color: #434a54;
        }
        
        /* Navbar modifications */
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        
        /* Dashboard Layout */
        .content {
            padding: 1.5rem;
        }
        
        /* Card Designs */
        .dashboard-card {
            background-color: #fff;
            border-radius: var(--card-border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            border: none;
            transition: all var(--transition-speed);
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            box-shadow: 0 0.3rem 2rem 0 rgba(58, 59, 69, 0.2);
            transform: translateY(-5px);
        }
        
        .dashboard-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dashboard-card-body {
            padding: 1.5rem;
            position: relative;
        }
        
        .dashboard-card-title {
            color: var(--dark-color);
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }
        
        .dashboard-card-title i {
            margin-right: 10px;
            color: var(--primary-color);
            opacity: 0.8;
        }
        
        /* Stat Cards */
        .stats-row {
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background-color: #fff;
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            height: 100%;
            transition: all var(--transition-speed);
            border-left: 4px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(78, 115, 223, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: 0;
        }
        
        .stat-card-content {
            position: relative;
            z-index: 1;
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.1);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
        }
        
        .total-feedback-card .stat-icon {
            color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .satisfaction-card .stat-icon {
            color: var(--success-color);
            background-color: rgba(28, 200, 138, 0.1);
        }
        
        .positive-card .stat-icon {
            color: var(--info-color);
            background-color: rgba(54, 185, 204, 0.1);
        }
        
        .rating-card .stat-icon {
            color: var(--warning-color);
            background-color: rgba(246, 194, 62, 0.1);
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            color: #2c2c2c;
        }
        
        .stat-title {
            color: var(--secondary-color);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        /* Ensure consistent table design */
        #feedbackTable {
            min-height: 500px;
            max-height: 1000px;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }
        
        #feedbackTable thead th {
            background-color: #f8f9fc;
            color: var(--dark-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 1px solid #e3e6f0;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        #feedbackTable tbody tr {
            transition: all 0.2s;
        }
        
        #feedbackTable tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
            transform: scale(1.01);
        }
        
        #feedbackTable td {
            padding: 1rem;
            border-bottom: 1px solid #e3e6f0;
            vertical-align: middle;
            color: #5a5c69;
        }
        
        #feedbackTable .no-data-row td {
            text-align: center;
            padding: 3rem !important;
        }
        
        #feedbackTable tbody .no-data-row .alert {
            max-width: 500px;
            margin: 0 auto;
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
        }
        
        /* Star Rating Styling */
        .star-rating {
            display: inline-flex;
        }
        
        .star-rating i {
            margin-right: 2px;
            transition: all 0.2s;
        }
        
        .star-rating:hover i {
            transform: scale(1.2);
        }
        
        .star-rating .fas.fa-star {
            color: #f6c23e;
        }
        
        .star-rating .far.fa-star {
            color: #e3e6f0;
        }
        
        /* Search and Filter Design */
        .controls-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .search-input {
            position: relative;
            min-width: 250px;
            flex-grow: 1;
        }
        
        .search-input input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 1px solid #e3e6f0;
            border-radius: 2rem;
            font-size: 0.9rem;
            transition: all 0.3s;
            background-color: #f8f9fc;
            color: #5a5c69;
        }
        
        .search-input input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            outline: none;
        }
        
        .search-input i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
        
        .filter-select {
            position: relative;
            min-width: 150px;
        }
        
        .filter-select select {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border: 1px solid #e3e6f0;
            border-radius: 2rem;
            font-size: 0.9rem;
            background-color: #f8f9fc;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            color: #5a5c69;
        }
        
        .filter-select::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            pointer-events: none;
        }
        
        .filter-select select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            outline: none;
        }
        
        /* Custom Form Elements */
        .custom-form-group {
            margin-bottom: 1.25rem;
        }
        
        .custom-form-label {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }
        
        .custom-form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s;
            background-color: #f8f9fc;
            color: #5a5c69;
        }
        
        .custom-form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            outline: none;
        }
        
        /* Button Styles */
        .btn-custom {
            border-radius: 0.5rem;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all 0.3s;
            text-transform: none;
            font-size: 0.9rem;
            letter-spacing: 0.025em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .btn-custom-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-custom-primary:hover {
            background-color: #3a5fd1;
        }
        
        .btn-custom-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-custom-outline:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-custom-danger {
            background-color: transparent;
            border: 1px solid var(--danger-color);
            color: var(--danger-color);
        }
        
        .btn-custom-danger:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        /* Download dropdown styling */
        .download-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .download-dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 200px;
            box-shadow: var(--card-shadow);
            z-index: 100;
            border-radius: 0.5rem;
            right: 0;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .download-dropdown-content a {
            color: var(--dark-color);
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }
        
        .download-dropdown-content a:hover {
            background-color: var(--light-color);
            color: var(--primary-color);
        }
        
        .download-dropdown-content a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: var(--primary-color);
        }
        
        .download-dropdown:hover .download-dropdown-content {
            display: block;
        }
        
        .download-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }
        
        .download-btn:hover {
            background-color: #3a5fd1;
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        /* Pagination styling */
        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .pagination-info {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
        
        .pagination-buttons {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .pagination-btn {
            width: 36px;
            height: 36px;
            border: 1px solid #e3e6f0;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .pagination-btn:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .pagination-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Rating chart containers */
        .chart-wrapper {
            height: 300px;
            position: relative;
        }
        
        /* Rating Summary Styling */
        .rating-summary {
            text-align: center;
            padding: 1.5rem 0;
        }
        
        .rating-value {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .rating-text {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            color: white;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
        }
        
        .rating-progress {
            margin-top: 1.5rem;
            height: 8px;
            background-color: #e3e6f0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .rating-progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease-in-out;
        }
        
        /* CSM Report Styling */
        .section-container {
            margin-bottom: 2rem;
        }
        
        .section-header {
            padding: 1rem 1.5rem;
            background-color: rgba(78, 115, 223, 0.05);
            border-left: 5px solid var(--primary-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .section-header i {
            color: var(--primary-color);
            margin-right: 0.75rem;
        }
        
        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .animate-slide-up {
            animation: slideUp 0.5s ease-in-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* SweetAlert2 custom styling */
        .swal2-popup {
            font-family: 'Poppins', sans-serif;
            border-radius: var(--card-border-radius);
            padding: 2rem;
        }
        
        .swal2-icon {
            margin: 1.5rem auto;
        }
        
        .swal2-title {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.5rem;
        }
        
        .swal2-html-container {
            font-size: 1rem;
            margin: 1rem 0;
        }
        
        .swal2-confirm {
            background-color: var(--danger-color) !important;
            border-radius: 2rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
        }
        
        .swal2-cancel {
            background-color: var(--secondary-color) !important;
            border-radius: 2rem !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
        }
        
        /* Table responsive for mobile */
        @media (max-width: 767px) {
            .content {
                padding: 1rem;
            }
            
            .dashboard-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .controls-container {
                width: 100%;
            }
            
            .search-input, 
            .filter-select {
                width: 100%;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            #feedbackTable thead {
                display: none;
            }
            
            #feedbackTable tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e3e6f0;
                border-radius: 0.5rem;
                overflow: hidden;
            }
            
            #feedbackTable td {
                display: block;
                text-align: right;
                padding: 0.75rem 1rem;
                position: relative;
            }
            
            #feedbackTable td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.75rem;
                color: var(--secondary-color);
            }
        }
        
        /* Additional Enhancements */
        .dashboard-welcome {
            background: #2e0f13;
            padding: 2rem;
            border-radius: var(--card-border-radius);
            color: white;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-welcome::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -50px;
        }
        
        .dashboard-welcome::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: 30%;
        }
        
        .welcome-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .welcome-subtitle {
            opacity: 0.8;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        
        /* Enhancement for charts */
        canvas {
            animation: fadeIn 1s ease-in-out;
        }
        
        /* Tooltip enhancements */
        [data-bs-toggle="tooltip"] {
            cursor: help;
        }
        
        .tooltip {
            font-family: 'Poppins', sans-serif;
        }
        
        .tooltip-inner {
            max-width: 300px;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            box-shadow: var(--card-shadow);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'assets/includes/navbar.php'; ?>

        <div class="content">
            <!-- Welcome Banner -->
            <div class="dashboard-welcome animate-fade-in">
                <h1 class="welcome-title"><?php echo $dashboard_title; ?></h1>
                <p class="welcome-subtitle">Monitor and analyze <?php echo ($is_office_feedback) ? 'office' : 'organization'; ?> feedback metrics for <?php echo $current_month . ' ' . $current_year; ?></p>
            </div>
            
            <div class="container-fluid">
                <!-- Stats Cards -->
                <div class="row stats-row animate-slide-up">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card total-feedback-card" style="border-left-color: var(--primary-color);">
                            <div class="stat-card-content">
                                <div class="stat-icon" style="color: var(--primary-color); background-color: rgba(78, 115, 223, 0.1);">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="stat-value"><?php echo number_format($total_count); ?></div>
                                <div class="stat-title">Total Feedbacks</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card satisfaction-card" style="border-left-color: var(--success-color);">
                            <div class="stat-card-content">
                                <div class="stat-icon" style="color: var(--success-color); background-color: rgba(28, 200, 138, 0.1);">
                                    <i class="fas fa-smile"></i>
                                </div>
                                <div class="stat-value"><?php echo number_format($overall_rating, 1); ?>%</div>
                                <div class="stat-title">Satisfaction Rate</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card positive-card" style="border-left-color: var(--info-color);">
                            <div class="stat-card-content">
                                <div class="stat-icon" style="color: var(--info-color); background-color: rgba(54, 185, 204, 0.1);">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <?php if ($is_office_feedback): ?>
                                <div class="stat-value"><?php echo number_format($total_agree + $total_strongly_agree); ?></div>
                                <div class="stat-title">Positive Responses</div>
                                <?php else: ?>
                                <div class="stat-value"><?php echo number_format($org_totals['rating_4'] + $org_totals['rating_5']); ?></div>
                                <div class="stat-title">Positive Ratings (4-5)</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card rating-card" style="border-left-color: <?php echo $rating_color; ?>;">
                            <div class="stat-card-content">
                                <div class="stat-icon" style="color: <?php echo $rating_color; ?>; background-color: <?php echo $rating_color; ?>10;">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="stat-value" style="color: <?php echo $rating_color; ?>;"><?php echo $rating_text; ?></div>
                                <div class="stat-title">Overall Rating</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Date Filter Section -->
               <div class="dashboard-card mb-4 animate-slide-up" style="animation-delay: 0.1s;">
    <div class="dashboard-card-header">
        <h5 class="dashboard-card-title">
            <i class="fas fa-calendar"></i>
            Date Range Filter
        </h5>
    </div>
    <div class="dashboard-card-body">
        <form id="dateFilterForm" class="row g-3" method="GET">
            <div class="col-md-3">
                <div class="custom-form-group">
                    <label class="custom-form-label" for="start_date">Start Date</label>
                    <input type="date" class="custom-form-control" id="start_date" name="start_date" 
                        value="<?php echo date('Y-m-d', strtotime($start_date)); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-form-group">
                    <label class="custom-form-label" for="end_date">End Date</label>
                    <input type="date" class="custom-form-control" id="end_date" name="end_date" 
                        value="<?php echo date('Y-m-d', strtotime($end_date)); ?>">
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-custom btn-custom-primary me-2">
                    <i class="fas fa-filter"></i> Apply Filter
                </button>
                <button type="button" id="resetFilter" class="btn btn-custom btn-custom-outline me-2">
                    <i class="fas fa-undo"></i> Reset
                </button>
                <?php if ($_SESSION['atype'] == '0' || $_SESSION['atype'] == '2'): ?>
                <button type="button" id="deleteFilteredData" class="btn btn-custom btn-custom-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
                <?php endif; ?>
            </div>
            <div class="col-md-3 d-flex align-items-end justify-content-end">
               <?php if ($_SESSION['atype'] == '0'): ?>
<div class="download-dropdown">
    <button type="button" class="download-btn">
        <i class="fas fa-download"></i> Download Data
        <i class="fas fa-caret-down ms-1"></i>
    </button>
    <div class="download-dropdown-content">
        <a href="ajax/exprtfeedback.php?format=csv&start_date=<?php echo date('Y-m-d', strtotime($start_date_full)); ?>&end_date=<?php echo date('Y-m-d', strtotime($end_date_full)); ?>&table=<?php echo $feedback_table; ?>">
            <i class="fas fa-file-csv"></i> CSV Format
        </a>
        <a href="ajax/exprtfeedback.php?format=excel&start_date=<?php echo date('Y-m-d', strtotime($start_date_full)); ?>&end_date=<?php echo date('Y-m-d', strtotime($end_date_full)); ?>&table=<?php echo $feedback_table; ?>">
            <i class="fas fa-file-excel"></i> Excel Format
        </a>
        <a href="ajax/exprtfeedback.php?format=pdf&start_date=<?php echo date('Y-m-d', strtotime($start_date_full)); ?>&end_date=<?php echo date('Y-m-d', strtotime($end_date_full)); ?>&table=<?php echo $feedback_table; ?>">
            <i class="fas fa-file-pdf"></i> PDF Format
        </a>
        <a href="javascript:void(0)" id="printReport">
            <i class="fas fa-print"></i> Print Report
        </a>
    </div>
</div>
<?php endif; ?>
            </div>
        </form>
    </div>
</div>
                <div class="row">
                    <!-- Left Column - Feedback Table -->
                    <div class="col-lg-8 mb-4">
                        <div class="dashboard-card animate-slide-up" style="animation-delay: 0.2s;">
                            <div class="dashboard-card-header">
                                <h5 class="dashboard-card-title">
                                    <i class="fas fa-comments"></i>
                                    Recent Feedback
                                </h5>
                                <div class="controls-container">
                                    <div class="search-input">
                                        <input type="text" id="searchInput" placeholder="Search feedbacks...">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="dashboard-card-body">
                                <!-- Error message display -->
                                <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger rounded-pill">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <?php echo $error_message; ?>
                                </div>
                                <?php endif; ?>

                                <!-- Feedback Table - Different columns based on feedback type -->
                                <div class="table-responsive">
                                    <table id="feedbackTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>DATE</th>
                                                <?php if ($is_office_feedback): ?>
                                                <th>SATISFACTION</th>
                                                <th>TIME</th>
                                                <th>REQUIREMENTS</th>
                                                <th>STEPS</th>
                                                <th>INFORMATION</th>
                                                <?php else: ?>
                                                <th>EVENT QUALITY</th>
                                                <th>COMMUNICATION</th>
                                                <th>INCLUSIVITY</th>
                                                <th>LEADERSHIP</th>
                                                <th>SKILL DEV</th>
                                                <th>IMPACT</th>
                                                <?php endif; ?>
                                                <th>IMPROVEMENTS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($feedbacks) > 0): ?>
                                                <?php foreach ($feedbacks as $feedback): ?>
                                                <tr>
                                                    <td data-label="NAME">
                                                        <?php echo htmlspecialchars($feedback['name'] ?? 'Anonymous'); ?>
                                                    </td>
                                                    <td data-label="DATE">
                                                        <?php echo $feedback['formatted_date']; ?>
                                                    </td>
                                                    
                                                    <?php if ($is_office_feedback): ?>
                                                    <!-- Office Feedback Rating Columns -->
                                                    <?php 
                                                    $ratingKeys = ['sqd0_satisfaction', 'sqd1_time', 'sqd2_requirements', 'sqd3_steps', 'sqd4_information'];
                                                    $ratingLabels = ['SATISFACTION', 'TIME', 'REQUIREMENTS', 'STEPS', 'INFORMATION'];
                                                    
                                                    foreach ($ratingKeys as $index => $key): ?>
                                                    <td data-label="<?php echo $ratingLabels[$index]; ?>">
                                                        <div class="star-rating">
                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                            <i class="<?php echo $i <= $feedback[$key] ? 'fas' : 'far'; ?> fa-star"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </td>
                                                    <?php endforeach; ?>
                                                    
                                                    <?php else: ?>
                                                    <!-- Organization Feedback Rating Columns -->
                                                    <?php 
                                                    $orgRatingKeys = ['event_quality_rating', 'communication_rating', 'inclusivity_rating', 'leadership_rating', 'skill_dev_rating', 'impact_rating'];
                                                    $orgRatingLabels = ['EVENT QUALITY', 'COMMUNICATION', 'INCLUSIVITY', 'LEADERSHIP', 'SKILL DEV', 'IMPACT'];
                                                    
                                                    foreach ($orgRatingKeys as $index => $key): ?>
                                                    <td data-label="<?php echo $orgRatingLabels[$index]; ?>">
                                                        <div class="star-rating">
                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                            <i class="<?php echo $i <= $feedback[$key] ? 'fas' : 'far'; ?> fa-star"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </td>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    
                                                    <td data-label="IMPROVEMENTS">
                                                        <?php 
                                                        $improvements = $feedback['improvements'] ?? '';
                                                        if (strlen($improvements) > 30) {
                                                            echo '<span data-bs-toggle="tooltip" title="' . htmlspecialchars($improvements) . '">' . 
                                                                 htmlspecialchars(substr($improvements, 0, 30)) . '...</span>';
                                                        } else {
                                                            echo htmlspecialchars($improvements); 
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                             <?php else: ?>
                                                <tr class="no-data-row">
                                                    <td colspan="<?php echo $is_office_feedback ? '8' : '9'; ?>" class="text-center p-4">
                                                        <div class="alert alert-info mb-0">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            No feedback data available for the selected date range.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Custom Pagination -->
                                <div class="pagination-wrapper">
                                    <div class="pagination-info">
                                        Showing <span id="showing-start">1</span> to <span id="showing-end">10</span> of <span id="total-entries"><?php echo count($feedbacks); ?></span> entries
                                    </div>
                                    <div class="pagination-buttons">
                                        <button class="pagination-btn" id="prev-page">
                                            <i class="fas fa-angle-left"></i>
                                        </button>
                                        <button class="pagination-btn active">1</button>
                                        <button class="pagination-btn" id="next-page">
                                            <i class="fas fa-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Charts -->
                    <div class="col-lg-4">
                        <!-- Rating Distribution Chart - Different based on feedback type -->
                        <div class="dashboard-card mb-4 animate-slide-up" style="animation-delay: 0.3s;">
                            <div class="dashboard-card-header">
                                <h5 class="dashboard-card-title">
                                    <i class="fas fa-chart-pie"></i>
                                    Rating Distribution
                                </h5>
                            </div>
                            <div class="dashboard-card-body">
                                <div class="chart-wrapper">
                                    <canvas id="ratingDistributionChart"></canvas>
                                </div>
                                
                                <!-- Rating Summary -->
                                <div class="rating-summary mt-4">
                                    <h6 class="text-uppercase text-muted mb-3 fs-6">OVERALL SATISFACTION RATING</h6>
                                    <div class="rating-value" style="color: <?php echo $rating_color; ?>;">
                                        <?php echo number_format($overall_rating, 1); ?>%
                                    </div>
                                    <div class="rating-text" style="background-color: <?php echo $rating_color; ?>;">
                                        <?php echo $rating_text; ?>
                                    </div>
                                    <div class="rating-progress mt-4">
                                        <div class="rating-progress-bar" style="width: <?php echo $overall_rating; ?>%; background-color: <?php echo $rating_color; ?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                       <?php if ($is_office_feedback): ?>
<!-- Citizen's Charter Awareness Chart - Only for Office Feedback -->
<div class="dashboard-card animate-slide-up" style="animation-delay: 0.4s;">
    <div class="dashboard-card-header">
        <h5 class="dashboard-card-title">
            <i class="fas fa-clipboard-check"></i>
            Citizen's Charter Awareness
        </h5>
    </div>
    <div class="dashboard-card-body">
        <div class="chart-wrapper" style="height: 250px;">
            <canvas id="ccAwarenessChart"></canvas>
        </div>
    </div>
</div>
<?php elseif ($_SESSION['atype'] == '0'): ?>
<!-- Category Rating Chart - Only for Admin viewing Organization Feedback -->
<div class="dashboard-card animate-slide-up" style="animation-delay: 0.4s;">
    <div class="dashboard-card-header">
        <h5 class="dashboard-card-title">
            <i class="fas fa-chart-bar"></i>
            Category Ratings
        </h5>
    </div>
    <div class="dashboard-card-body">
        <div class="chart-wrapper" style="height: 250px;">
            <canvas id="categoryRatingsChart"></canvas>
        </div>
    </div>
</div>
<?php endif; ?>
                    </div>
                </div>
                
                <!-- CSM Summary Report Section - Only shown for admin account type 0 -->
               <?php if ($is_office_feedback): ?>
<div class="dashboard-card mt-2 animate-slide-up" style="animation-delay: 0.5s;">
    <div class="dashboard-card-header" style="background: #a3939359;">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-file-alt me-2"></i>
            Client Satisfaction Measurement (CSM) Summary Report
        </h5>
        <span class="badge bg-white text-primary rounded-pill px-3 py-2">
            <?php echo date('F Y', strtotime($start_date)); ?> - <?php echo date('F Y', strtotime($end_date)); ?>
        </span>
    </div>
    <div class="dashboard-card-body">
        <!-- CC Questions Section -->
        <div class="mb-4">
            <div class="section-header d-flex align-items-center">
                <i class="fas fa-question-circle fs-4"></i>
                <h5 class="mb-0 fw-bold">Citizen's Charter (CC) Questions</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th colspan="2">Citizen's Charter (CC) Question</th>
                            <th style="width: 100px;" class="text-center">Responses</th>
                            <th style="width: 150px;" class="text-center">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CC1 Section -->
                        <tr style="background-color: rgba(78, 115, 223, 0.05);">
                            <td style="width: 50px; font-weight: 600;">CC1</td>
                            <td colspan="3" style="font-weight: 600;">Which of the following best describes your awareness of a CC?</td>
                        </tr>
                        <?php foreach($cc1_results as $result): ?>
                        <tr>
                            <td></td>
                            <td>
                                <i class="fas fa-angle-right text-primary me-2"></i>
                                <?php echo htmlspecialchars($result['cc_awareness'] ?? ''); ?>
                            </td>
                            <td class="text-center" style="font-weight: 500;"><?php echo $result['total']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" style="width: <?php echo $result['percentage']; ?>%;"></div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?php echo number_format($result['percentage'], 1); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- CC2 Section -->
                        <tr style="background-color: rgba(78, 115, 223, 0.05);">
                            <td style="font-weight: 600;">CC2</td>
                            <td colspan="3" style="font-weight: 600;">If aware of CC, would you say that the CC of this office was:</td>
                        </tr>
                        <?php foreach($cc2_results as $result): ?>
                        <tr>
                            <td></td>
                            <td>
                                <i class="fas fa-angle-right text-primary me-2"></i>
                                <?php echo htmlspecialchars($result['cc_visibility'] ?? ''); ?>
                            </td>
                            <td class="text-center" style="font-weight: 500;"><?php echo $result['total']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" style="width: <?php echo $result['percentage']; ?>%;"></div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?php echo number_format($result['percentage'], 1); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- CC3 Section -->
                        <tr style="background-color: rgba(78, 115, 223, 0.05);">
                            <td style="font-weight: 600;">CC3</td>
                            <td colspan="3" style="font-weight: 600;">If aware of CC, How much did the CC help you in your transaction?</td>
                        </tr>
                        <?php foreach($cc3_results as $result): ?>
                        <tr>
                            <td></td>
                            <td>
                                <i class="fas fa-angle-right text-primary me-2"></i>
                                <?php echo htmlspecialchars($result['cc_helpfulness'] ?? ''); ?>
                            </td>
                            <td class="text-center" style="font-weight: 500;"><?php echo $result['total']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" style="width: <?php echo $result['percentage']; ?>%;"></div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?php echo number_format($result['percentage'], 1); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Service Quality Dimensions (SQD) Section -->
        <div class="section-container">
            <div class="section-header d-flex align-items-center">
                <i class="fas fa-chart-pie text-success me-2 fs-4"></i>
                <h5 class="mb-0 fw-bold">Service Quality Dimensions (SQD)</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;" class="text-center">SQD</th>
                            <th>Service Quality Dimensions</th>
                            <th style="width: 80px;" class="text-center">
                                <span class="d-block">Strongly</span>
                                <span class="d-block">Disagree</span>
                            </th>
                            <th style="width: 80px;" class="text-center">Disagree</th>
                            <th style="width: 80px;" class="text-center">
                                <span class="d-block">Neutral</span>
                            </th>
                            <th style="width: 80px;" class="text-center">Agree</th>
                            <th style="width: 80px;" class="text-center">
                                <span class="d-block">Strongly</span>
                                <span class="d-block">Agree</span>
                            </th>
                            <th style="width: 60px;" class="text-center">N/A</th>
                            <th style="width: 90px;" class="text-center">
                                <span class="d-block">Total</span>
                                <span class="d-block">Responses</span>
                            </th>
                            <th style="width: 90px;" class="text-center">Overall</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($sqd_questions as $key => $question):
                            $num = substr($key, 3);
                            $prefix = strtolower($key) . '_';
                            
                            // Use the safe_divide function to prevent division by zero
                            $overall = safe_divide(
                                $sqd_stats[$prefix.'agree'] + $sqd_stats[$prefix.'strongly_agree'], 
                                $sqd_stats['total_responses'] - $sqd_stats[$prefix.'na']
                            );
                            
                            if ($overall >= 90) {
                                $badge_class = "bg-success";
                            } else if ($overall >= 80) {
                                $badge_class = "bg-info";
                            } else if ($overall >= 60) {
                                $badge_class = "bg-warning text-dark";
                            } else {
                                $badge_class = "bg-danger";
                            }
                        ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo $key; ?></td>
                            <td><?php echo $question; ?></td>
                            <td class="text-center">
                                <?php if ($sqd_stats[$prefix.'strongly_disagree'] > 0): ?>
                                <span class="badge bg-danger"><?php echo $sqd_stats[$prefix.'strongly_disagree']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($sqd_stats[$prefix.'disagree'] > 0): ?>
                                <span class="badge bg-danger"><?php echo $sqd_stats[$prefix.'disagree']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($sqd_stats[$prefix.'neutral'] > 0): ?>
                                <span class="badge bg-warning text-dark"><?php echo $sqd_stats[$prefix.'neutral']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($sqd_stats[$prefix.'agree'] > 0): ?>
                                <span class="badge bg-success"><?php echo $sqd_stats[$prefix.'agree']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($sqd_stats[$prefix.'strongly_agree'] > 0): ?>
                                <span class="badge bg-success"><?php echo $sqd_stats[$prefix.'strongly_agree']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($sqd_stats[$prefix.'na'] > 0): ?>
                                <span class="badge bg-secondary"><?php echo $sqd_stats[$prefix.'na']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center fw-bold"><?php echo $sqd_stats['total_responses']; ?></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="progress me-2" style="width: 40px; height: 8px;">
                                        <div class="progress-bar <?php echo $badge_class; ?>" role="progressbar" 
                                             style="width: <?php echo $overall; ?>%" 
                                             aria-valuenow="<?php echo $overall; ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo number_format($overall, 2); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php elseif (!$is_office_feedback && $_SESSION['atype'] == '0'): ?>
<!-- Organization Feedback Summary - Only visible to admin (atype=0) -->
<div class="dashboard-card mt-2 animate-slide-up" style="animation-delay: 0.5s;">
    <div class="dashboard-card-header" style="background: #a3939359;">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-file-alt me-2"></i>
            Organization Feedback Summary
        </h5>
        <span class="badge bg-white text-primary rounded-pill px-3 py-2">
            <?php echo date('F Y', strtotime($start_date)); ?> - <?php echo date('F Y', strtotime($end_date)); ?>
        </span>
    </div>
    <div class="dashboard-card-body">
        <div class="section-container">
            <div class="section-header d-flex align-items-center">
                <i class="fas fa-chart-bar text-success me-2 fs-4"></i>
                <h5 class="mb-0 fw-bold">Category Ratings</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th style="width: 80px;" class="text-center">Rating 1</th>
                            <th style="width: 80px;" class="text-center">Rating 2</th>
                            <th style="width: 80px;" class="text-center">Rating 3</th>
                            <th style="width: 80px;" class="text-center">Rating 4</th>
                            <th style="width: 80px;" class="text-center">Rating 5</th>
                            <th style="width: 90px;" class="text-center">Average</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($org_categories as $key => $category):
                            $prefix = str_replace('_rating', '', $key);
                            $avg_prefix = 'avg_' . $prefix;
                            
                            // Determine rating classes
                            $avg_rating = $org_stats[$avg_prefix];
                            if ($avg_rating >= 4.5) {
                                $rating_class = "bg-success";
                            } else if ($avg_rating >= 4.0) {
                                $rating_class = "bg-info";
                            } else if ($avg_rating >= 3.0) {
                                $rating_class = "bg-warning text-dark";
                            } else {
                                $rating_class = "bg-danger";
                            }
                        ?>
                        <tr>
                            <td class="fw-bold"><?php echo $category; ?></td>
                            <td class="text-center">
                                <?php $count = $org_stats[$prefix.'_1']; ?>
                                <?php if ($count > 0): ?>
                                <span class="badge bg-danger"><?php echo $count; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php $count = $org_stats[$prefix.'_2']; ?>
                                <?php if ($count > 0): ?>
                                <span class="badge bg-warning"><?php echo $count; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php $count = $org_stats[$prefix.'_3']; ?>
                                <?php if ($count > 0): ?>
                                <span class="badge bg-secondary"><?php echo $count; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php $count = $org_stats[$prefix.'_4']; ?>
                                <?php if ($count > 0): ?>
                                <span class="badge bg-info"><?php echo $count; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php $count = $org_stats[$prefix.'_5']; ?>
                                <?php if ($count > 0): ?>
                                <span class="badge bg-success"><?php echo $count; ?></span>
                                <?php else: ?>
                                <span class="text-muted">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge <?php echo $rating_class; ?> p-2">
                                    <?php echo number_format($avg_rating, 1); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
            </div>
        </div>
        
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright text-center">
                            &copy; <?php echo date('Y'); ?> Campus Kiosk Admin | All Rights Reserved
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Core JS Files -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            
            // Rating Distribution Chart - Different based on feedback type
            const ratingDistribution = document.getElementById('ratingDistributionChart');
            if (ratingDistribution) {
                <?php if ($is_office_feedback): ?>
                // Office Feedback Chart
                new Chart(ratingDistribution, {
                    type: 'doughnut',
                    data: {
                        labels: ['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'],
                        datasets: [{
                            data: [
                                <?php echo $sqd_totals['strongly_disagree']; ?>,
                                <?php echo $sqd_totals['disagree']; ?>,
                                <?php echo $sqd_totals['neutral']; ?>,
                                <?php echo $sqd_totals['agree']; ?>,
                                <?php echo $sqd_totals['strongly_agree']; ?>
                            ],
                            backgroundColor: [
                                '#e74a3b', // Strongly Disagree
                                '#f6c23e', // Disagree
                                '#858796', // Neutral
                                '#4e73df', // Agree
                                '#1cc88a', // Strongly Agree
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 2000
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 12,
                                        family: "'Poppins', sans-serif"
                                    }
                                }
                            },tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.raw;
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${context.label}: ${value} (${percentage}%)`;
                                    }
                                },
                                padding: 12,
                                boxWidth: 10,
                                boxHeight: 10,
                                boxPadding: 3,
                                usePointStyle: true,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold',
                                    family: "'Poppins', sans-serif"
                                },
                                bodyFont: {
                                    size: 13,
                                    family: "'Poppins', sans-serif"
                                }
                            }
                        }
                    }
                });
                <?php else: ?>
                // Organization Feedback Chart
                new Chart(ratingDistribution, {
                    type: 'doughnut',
                    data: {
                        labels: ['Rating 1', 'Rating 2', 'Rating 3', 'Rating 4', 'Rating 5'],
                        datasets: [{
                            data: [
                                <?php echo $org_totals['rating_1']; ?>,
                                <?php echo $org_totals['rating_2']; ?>,
                                <?php echo $org_totals['rating_3']; ?>,
                                <?php echo $org_totals['rating_4']; ?>,
                                <?php echo $org_totals['rating_5']; ?>
                            ],
                            backgroundColor: [
                                '#e74a3b', // Rating 1
                                '#f6c23e', // Rating 2
                                '#858796', // Rating 3
                                '#4e73df', // Rating 4
                                '#1cc88a', // Rating 5
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 2000
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 12,
                                        family: "'Poppins', sans-serif"
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.raw;
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${context.label}: ${value} (${percentage}%)`;
                                    }
                                },
                                padding: 12,
                                boxWidth: 10,
                                boxHeight: 10,
                                boxPadding: 3,
                                usePointStyle: true,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold',
                                    family: "'Poppins', sans-serif"
                                },
                                bodyFont: {
                                    size: 13,
                                    family: "'Poppins', sans-serif"
                                }
                            }
                        }
                    }
                });
                <?php endif; ?>
            }
            
            <?php if ($is_office_feedback): ?>
            // Citizen's Charter Awareness Chart for Office Feedback
            const ccAwareness = document.getElementById('ccAwarenessChart');
            if (ccAwareness) {
                const labels = [];
                const data = [];
                const backgroundColors = [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)'
                ];
                
                <?php foreach($cc1_results as $index => $result): ?>
                labels.push("<?php echo addslashes($result['cc_awareness'] ?? 'Unknown'); ?>");
                data.push(<?php echo $result['total']; ?>);
                <?php endforeach; ?>
                
                new Chart(ccAwareness, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of Responses',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderWidth: 0,
                            borderRadius: 6,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 2000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                padding: 12,
                                boxWidth: 10,
                                boxHeight: 10,
                                boxPadding: 3,
                                usePointStyle: true,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold',
                                    family: "'Poppins', sans-serif"
                                },
                                bodyFont: {
                                    size: 13,
                                    family: "'Poppins', sans-serif"
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        family: "'Poppins', sans-serif"
                                    }
                                },
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        family: "'Poppins', sans-serif"
                                    },
                                    color: '#5a5c69'
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        }
                    }
                });
            }
            <?php else: ?>
            // Category Ratings Chart for Organization Feedback
            const categoryRatings = document.getElementById('categoryRatingsChart');
            if (categoryRatings) {
                new Chart(categoryRatings, {
                    type: 'radar',
                    data: {
                        labels: [
                            <?php foreach($org_categories as $category): ?>
                            '<?php echo $category; ?>',
                            <?php endforeach; ?>
                        ],
                        datasets: [{
                            label: 'Average Rating',
                            data: [
                                <?php 
                                foreach($org_categories as $key => $category): 
                                    $prefix = str_replace('_rating', '', $key);
                                    $avg_prefix = 'avg_' . $prefix;
                                ?>
                                <?php echo number_format($org_stats[$avg_prefix], 1); ?>,
                                <?php endforeach; ?>
                            ],
                            backgroundColor: 'rgba(78, 115, 223, 0.2)',
                            borderColor: 'rgba(78, 115, 223, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                angleLines: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                suggestedMin: 0,
                                suggestedMax: 5,
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        family: "'Poppins', sans-serif"
                                    }
                                },
                                pointLabels: {
                                    font: {
                                        family: "'Poppins', sans-serif",
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        family: "'Poppins', sans-serif"
                                    }
                                }
                            },
                            tooltip: {
                                padding: 12,
                                boxWidth: 10,
                                boxHeight: 10,
                                boxPadding: 3,
                                usePointStyle: true,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold',
                                    family: "'Poppins', sans-serif"
                                },
                                bodyFont: {
                                    size: 13,
                                    family: "'Poppins', sans-serif"
                                }
                            }
                        }
                    }
                });
            }
            <?php endif; ?>
            
            // Table pagination
            const tableRows = document.querySelectorAll('#feedbackTable tbody tr');
            const rowsPerPage = 10;
            let currentPage = 1;
            const totalPages = Math.ceil(tableRows.length / rowsPerPage);
            
            function showPage(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                
                tableRows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? '' : 'none';
                });
                
                // Update pagination info
                document.getElementById('showing-start').textContent = tableRows.length > 0 ? start + 1 : 0;
                document.getElementById('showing-end').textContent = Math.min(end, tableRows.length);
                document.getElementById('total-entries').textContent = tableRows.length;
                
                // Update pagination buttons
                document.getElementById('prev-page').disabled = page === 1;
                document.getElementById('next-page').disabled = page === totalPages || totalPages === 0;
                
                currentPage = page;
            }
            
            // Initial page load
            showPage(1);
            
            // Pagination button event listeners
            document.getElementById('prev-page').addEventListener('click', function() {
                if (currentPage > 1) {
                    showPage(currentPage - 1);
                }
            });
            
            document.getElementById('next-page').addEventListener('click', function() {
                if (currentPage < totalPages) {
                    showPage(currentPage + 1);
                }
            });
            
            // Search functionality
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                let matchCount = 0;
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const isMatch = text.includes(searchTerm);
                    
                    if (isMatch) matchCount++;
                    row.style.display = isMatch ? '' : 'none';
                });
                
                // Update pagination info for search results
                document.getElementById('showing-start').textContent = matchCount > 0 ? '1' : '0';
                document.getElementById('showing-end').textContent = matchCount;
                document.getElementById('total-entries').textContent = matchCount;
                
                // Hide pagination if searching
                document.querySelector('.pagination-buttons').style.display = searchTerm ? 'none' : 'flex';
            });
            
            // Date filter
            document.getElementById('dateFilter').addEventListener('change', function() {
                const value = this.value;
                let matchCount = 0;
                
                tableRows.forEach(row => {
                    const dateCell = row.querySelector('td:nth-child(2)');
                    
                    if (dateCell) {
                        const dateText = dateCell.textContent.trim();
                        const date = new Date(dateText);
                        const now = new Date();
                        let isMatch = true;
                        
                        if (value === 'today') {
                            isMatch = date.toDateString() === now.toDateString();
                        } else if (value === 'week') {
                            const weekStart = new Date(now);
                            weekStart.setDate(now.getDate() - now.getDay());
                            const weekEnd = new Date(weekStart);
                            weekEnd.setDate(weekStart.getDate() + 6);
                            
                            isMatch = date >= weekStart && date <= weekEnd;
                        } else if (value === 'month') {
                            isMatch = date.getMonth() === now.getMonth() && 
                                      date.getFullYear() === now.getFullYear();
                        }
                        
                        if (isMatch) matchCount++;
                        row.style.display = isMatch ? '' : 'none';
                    }
                });
                
                // Update pagination info for filtered results
                document.getElementById('showing-start').textContent = matchCount > 0 ? '1' : '0';
                document.getElementById('showing-end').textContent = matchCount;
                document.getElementById('total-entries').textContent = matchCount;
                
                // Hide pagination if filtering
                document.querySelector('.pagination-buttons').style.display = value !== 'all' ? 'none' : 'flex';
            });
            
            // Reset filter button
            document.getElementById('resetFilter').addEventListener('click', function() {
                document.getElementById('start_date').value = '<?php echo date('Y-m-d', strtotime('-6 months')); ?>';
                document.getElementById('end_date').value = '<?php echo date('Y-m-d'); ?>';
                document.getElementById('dateFilterForm').submit();
            });
            
            // Print report button
            document.getElementById('printReport').addEventListener('click', function() {
                window.print();
            });
            
            // Form validation
            document.getElementById('dateFilterForm').addEventListener('submit', function(e) {
                const startDate = new Date(document.getElementById('start_date').value);
                const endDate = new Date(document.getElementById('end_date').value);
                
                if (startDate > endDate) {
                    e.preventDefault();
                    alert('Start date cannot be after end date!');
                }
            });
            
            // Animation for rating progress bar
            setTimeout(function() {
                const progressBar = document.querySelector('.rating-progress-bar');
                if (progressBar) {
                    progressBar.style.width = progressBar.getAttribute('style').split(';')[0];
                }
            }, 500);
            
            // Delete functionality with SweetAlert2
            const deleteButton = document.getElementById('deleteFilteredData');
            if (deleteButton) {
                deleteButton.addEventListener('click', function() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const feedbackTable = '<?php echo $feedback_table; ?>';
                    
                    // Format dates for display
                    const startDateObj = new Date(startDate);
                    const endDateObj = new Date(endDate);
                    const startDateFormatted = startDateObj.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
                    const endDateFormatted = endDateObj.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
                    
                    Swal.fire({
                        title: 'Confirm Deletion',
                        icon: 'warning',
                        html: `
                            <div class="text-start">
                                <p>You are about to <b>permanently delete</b> all <?php echo ($is_office_feedback) ? 'office' : 'organization'; ?> feedback records for the period:</p>
                                <div class="alert alert-warning text-center p-3 my-3">
                                    <b>${startDateFormatted}</b> to <b>${endDateFormatted}</b>
                                </div>
                                <p>This action <b>cannot be undone</b>. Are you sure you want to proceed?</p>
                                <p class="text-danger"><small>Please type <b>DELETE</b> to confirm.</small></p>
                            </div>
                        `,
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off',
                            autocorrect: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete Data',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#e74a3b',
                        cancelButtonColor: '#6c757d',
                        footer: '<span class="text-muted">This will permanently remove all feedback data for the selected period.</span>',
                        allowOutsideClick: false,
                        preConfirm: (inputValue) => {
                            if (inputValue !== 'DELETE') {
                                Swal.showValidationMessage('Please type DELETE to confirm');
                                return false;
                            }
                            return true;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Deleting...',
                                html: 'Please wait while your data is being deleted.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    
                                    // Create form data
                                    const formData = new FormData();
                                    formData.append('start_date', startDate);
                                    formData.append('end_date', endDate);
                                    formData.append('table', feedbackTable);
                                    formData.append('token', '<?php echo $_SESSION['csrf_token']; ?>');
                                    
                                    // Make AJAX request
                                    fetch('ajax/delete_feedback.php', {
                                        method: 'POST',
                                        body: formData,
                                        credentials: 'same-origin'
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                title: 'Deleted!',
                                                text: data.message,
                                                icon: 'success',
                                                confirmButtonColor: '#4e73df'
                                            }).then(() => {
                                                // Force hard refresh
                                                window.location.href = window.location.pathname + '?refresh=' + new Date().getTime();
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: data.message,
                                                icon: 'error',
                                                confirmButtonColor: '#4e73df'
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'An unexpected error occurred while deleting the data.',
                                            icon: 'error',
                                            confirmButtonColor: '#4e73df'
                                        });
                                    });
                                }
                            });
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>