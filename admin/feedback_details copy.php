<?php
// Start the session and include necessary files
session_start();
include_once('../class/connection.php');

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['atype']) || !in_array($_SESSION['atype'], ['0', '2', '3', '4'])) {
    header("Location: index.php");
    exit;
}

// Get date filter parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m', strtotime('-6 months'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m');

// Get office filter parameter - CHANGED from office_id to office_name
$office_name = isset($_GET['office_name']) ? $_GET['office_name'] : '';

// Ensure dates are in proper format (YYYY-MM)
$start_date_formatted = date('Y-m', strtotime($start_date));
$end_date_formatted = date('Y-m', strtotime($end_date));

// For database queries, we need to add the day component to create full dates
$start_date_full = $start_date_formatted . '-01';
$end_date_full = date('Y-m-t', strtotime($end_date_formatted));

// Define safe_divide function for percentage calculations
function safe_divide($numerator, $denominator, $default = 0) {
    return ($denominator > 0) ? (($numerator / $denominator) * 100) : $default;
}

// Add the weighted summary calculation function
function calculate_weighted_summary($data, $field_prefix) {
   // Define weight for each rating value
$weights = [
    'strongly_disagree' => 0,  // 0%
    'disagree' => 25,          // 25%
    'neutral' => 50,           // 50%
    'agree' => 75,             // 75%
    'strongly_agree' => 100    // 100%
];
    
    $total_responses = 0;
    $weighted_sum = 0;
    
    foreach ($weights as $rating => $weight) {
        $count = $data[$field_prefix . $rating];
        $weighted_sum += $count * $weight;
        $total_responses += $count;
    }
    
    // Avoid division by zero
    if ($total_responses > 0) {
        return $weighted_sum / $total_responses;
    } else {
        return 0;
    }
}

try {
    // Initialize data arrays
    $cc1_results = $cc2_results = $cc3_results = [];
    $sqd_stats = [];
    
    // Get total count of feedback for the date range with office filter - UPDATED to use office_name
    $total_sql = "SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date AND :end_date";
    if (!empty($office_name)) {
        $total_sql .= " AND office_name = :office_name";
    }
    $total_stmt = $connect->prepare($total_sql);
    $total_stmt->bindParam(':start_date', $start_date_full);
    $total_stmt->bindParam(':end_date', $end_date_full);
    if (!empty($office_name)) {
        $total_stmt->bindParam(':office_name', $office_name);
    }
    $total_stmt->execute();
    $total_count = $total_stmt->fetchColumn();
    
    // CC1 - Awareness Query with safe calculation and office filter - UPDATED to use office_name
    $cc1_sql = "SELECT 
        cc_awareness,
        COUNT(*) as total
    FROM office_feedback 
    WHERE feedback_date BETWEEN :start_date AND :end_date";
    if (!empty($office_name)) {
        $cc1_sql .= " AND office_name = :office_name";
    }
    $cc1_sql .= " GROUP BY cc_awareness";
    $cc1_stmt = $connect->prepare($cc1_sql);
    $cc1_stmt->bindParam(':start_date', $start_date_full);
    $cc1_stmt->bindParam(':end_date', $end_date_full);
    if (!empty($office_name)) {
        $cc1_stmt->bindParam(':office_name', $office_name);
    }
    $cc1_stmt->execute();
    $cc1_results = $cc1_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate percentages safely
    foreach ($cc1_results as &$result) {
        $result['percentage'] = safe_divide($result['total'], $total_count);
    }
    
    // CC2 - Visibility Query with safe calculation and office filter - UPDATED to use office_name
    $cc2_sql = "SELECT 
        cc_visibility,
        COUNT(*) as total
    FROM office_feedback 
    WHERE feedback_date BETWEEN :start_date AND :end_date";
    if (!empty($office_name)) {
        $cc2_sql .= " AND office_name = :office_name";
    }
    $cc2_sql .= " GROUP BY cc_visibility";
    $cc2_stmt = $connect->prepare($cc2_sql);
    $cc2_stmt->bindParam(':start_date', $start_date_full);
    $cc2_stmt->bindParam(':end_date', $end_date_full);
    if (!empty($office_name)) {
        $cc2_stmt->bindParam(':office_name', $office_name);
    }
    $cc2_stmt->execute();
    $cc2_results = $cc2_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate percentages safely
    foreach ($cc2_results as &$result) {
        $result['percentage'] = safe_divide($result['total'], $total_count);
    }
    
    // CC3 - Helpfulness Query with safe calculation and office filter - UPDATED to use office_name
    $cc3_sql = "SELECT 
        cc_helpfulness,
        COUNT(*) as total
    FROM office_feedback 
    WHERE feedback_date BETWEEN :start_date AND :end_date";
    if (!empty($office_name)) {
        $cc3_sql .= " AND office_name = :office_name";
    }
    $cc3_sql .= " GROUP BY cc_helpfulness";
    $cc3_stmt = $connect->prepare($cc3_sql);
    $cc3_stmt->bindParam(':start_date', $start_date_full);
    $cc3_stmt->bindParam(':end_date', $end_date_full);
    if (!empty($office_name)) {
        $cc3_stmt->bindParam(':office_name', $office_name);
    }
    $cc3_stmt->execute();
    $cc3_results = $cc3_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate percentages safely
    foreach ($cc3_results as &$result) {
        $result['percentage'] = safe_divide($result['total'], $total_count);
    }
    
    // SQD Query - Modified to remove sqd0_satisfaction and include office filter - UPDATED to use office_name
    $sqd_sql = "SELECT 
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
    FROM office_feedback 
    WHERE feedback_date BETWEEN :start_date AND :end_date";
    if (!empty($office_name)) {
        $sqd_sql .= " AND office_name = :office_name";
    }
    $sqd_stmt = $connect->prepare($sqd_sql);
    $sqd_stmt->bindParam(':start_date', $start_date_full);
    $sqd_stmt->bindParam(':end_date', $end_date_full);
    if (!empty($office_name)) {
        $sqd_stmt->bindParam(':office_name', $office_name);
    }
    $sqd_stmt->execute();
    $sqd_stats = $sqd_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Calculate overall statistics - Modified to remove SQD0
    $sqd_questions = [
        'SQD1' => 'I spent a reasonable amount of time for my transaction.',
        'SQD2' => 'The office followed the transaction\'s requirements and steps.',
        'SQD3' => 'The steps were easy and simple.',
        'SQD4' => 'I easily found information about my transaction.',
        'SQD5' => 'I paid the correct amount of fees.',
        'SQD6' => 'I feel the office was fair to everyone.',
        'SQD7' => 'I was treated courteously by the staff.',
        'SQD8' => 'I got what I needed from the office.'
    ];
    
    // Calculate SQD rating
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
    
// Calculate SQD rating with the updated formula
$total_respondents = $total_count * count($sqd_questions); // Total possible responses across all questions
$total_valid_responses = $total_respondents - $total_na; // Excluding N/A answers
$total_positive_responses = $total_agree + $total_strongly_agree; // Agree + Strongly Agree

// Apply the formula: (Strongly Agree + Agree) / (Total Respondents - N/A) * 100
$sqd_rating = $total_valid_responses > 0 ? 
    (($total_positive_responses / $total_valid_responses) * 100) : 
    0;

// Ensure sqd_rating is a number between 0 and 100
$sqd_rating = max(0, min(100, $sqd_rating));
    // Ensure sqd_rating is a number
    $sqd_rating = max(0, min(100, $sqd_rating));
    
    // Determine rating text
  
// Determine rating text based on the updated scale from the image
$rating_text = 'No Data';
if ($total_valid_responses > 0) {
    if ($sqd_rating >= 95.0) {
        $rating_text = "Outstanding";
        $rating_color = "#28a745"; // Green
    } elseif ($sqd_rating >= 90.0) {
        $rating_text = "Very Satisfactory";
        $rating_color = "#007bff"; // Blue
    } elseif ($sqd_rating >= 85.0) {
        $rating_text = "Satisfactory";
        $rating_color = "#17a2b8"; // Light blue/teal
    } elseif ($sqd_rating >= 80.0) {
        $rating_text = "Fair";
        $rating_color = "#ffc107"; // Yellow/amber
    } else {
        $rating_text = "Poor";
        $rating_color = "#dc3545"; // Red
    }
}
    // Fetch feedback data for the table with office filter
    $feedback_type = isset($_GET['feedback_type']) ? $_GET['feedback_type'] : 'office';
    $account_type = $_SESSION['atype']; 
    
    // Get selected office name - SIMPLIFIED since we're now using office_name directly
    $selected_office_name = '';
    if (!empty($office_name)) {
        $selected_office_name = $office_name;
    }
    
    // Query to fetch feedback data for the table - UPDATED to use office_name
    $feedback_query = "SELECT 
        f.id,
        f.name,
        f.feedback_date,
        f.sqd1_time,
        f.sqd2_requirements,
        f.sqd3_steps,
        f.sqd4_information,
        f.improvements,
        f.office_name
    FROM office_feedback f
    WHERE f.feedback_date BETWEEN :start_date AND :end_date";
    
    if (!empty($office_name)) {
        $feedback_query .= " AND f.office_name = :office_name";
    }
    
    $feedback_query .= " ORDER BY f.feedback_date DESC";
    
    $feedback_stmt = $connect->prepare($feedback_query);
    $feedback_stmt->bindParam(':start_date', $start_date_full);
    $feedback_stmt->bindParam(':end_date', $end_date_full);
    if (!empty($office_name)) {
        $feedback_stmt->bindParam(':office_name', $office_name);
    }
    $feedback_stmt->execute();
    $feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the date for display
    foreach ($feedbacks as &$feedback) {
        $feedback['formatted_date'] = date('M d, Y', strtotime($feedback['feedback_date']));
    }
    
    // Calculate most common rating value for visualization
    $sqd_categories = ['strongly_disagree', 'disagree', 'neutral', 'agree', 'strongly_agree', 'na'];
    $sqd_totals = [];
    
    foreach ($sqd_categories as $category) {
        $total = 0;
        // Start from index 1 to exclude SQD0
        for ($i = 1; $i <= 8; $i++) {
            $prefix = "sqd{$i}_";
            $total += $sqd_stats[$prefix . $category];
        }
        $sqd_totals[$category] = $total;
    }
    
    // Fetch all offices regardless of whether they have feedback
$offices_sql = "SELECT office_name FROM offices ORDER BY office_name";
$offices_stmt = $connect->prepare($offices_sql);
$offices_stmt->execute();
$offices = $offices_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get age and gender statistics for charts
    $age_stats_sql = "SELECT 
        age_group,
        COUNT(*) as count,
        (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date AND :end_date)) as percentage
    FROM office_feedback 
    WHERE feedback_date BETWEEN :start_date AND :end_date
    GROUP BY age_group
    ORDER BY CASE 
        WHEN age_group = '19 or lower' THEN 1
        WHEN age_group = '20 - 34' THEN 2
        WHEN age_group = '35 - 49' THEN 3
        WHEN age_group = '50 - 64' THEN 4
        WHEN age_group = '65 or higher' THEN 5
        ELSE 6
    END";
    
    $age_stats_stmt = $connect->prepare($age_stats_sql);
    $age_stats_stmt->bindParam(':start_date', $start_date_full);
    $age_stats_stmt->bindParam(':end_date', $end_date_full);
    $age_stats_stmt->execute();
    $age_stats = $age_stats_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $gender_stats_sql = "SELECT 
        gender,
        COUNT(*) as count,
        (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date AND :end_date)) as percentage
    FROM office_feedback 
    WHERE feedback_date BETWEEN :start_date AND :end_date
    GROUP BY gender";
    
    $gender_stats_stmt = $connect->prepare($gender_stats_sql);
    $gender_stats_stmt->bindParam(':start_date', $start_date_full);
    $gender_stats_stmt->bindParam(':end_date', $end_date_full);
    $gender_stats_stmt->execute();
    $gender_stats = $gender_stats_stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Log error
    error_log("Error in feedback report: " . $e->getMessage());
    // We'll show the error message in the page content
    $error_message = "Error generating report: " . $e->getMessage();
}

// Get current month and year for dashboard title
$current_month = date('F');
$current_year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Campus Kiosk Admin | Feedback Dashboard</title>
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
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
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

        /* Office filter styling */
        .badge-office {
            background-color: rgba(78, 115, 223, 0.1);
            color: var(--primary-color);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            margin-left: 1rem;
        }
        
        .badge-office i {
            font-size: 1rem;
        }
        
        /* Office column in table */
        .office-badge {
            background-color: rgba(78, 115, 223, 0.1);
            color: var(--primary-color);
            border-radius: 2rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .office-badge i {
            font-size: 0.75rem;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'assets/includes/navbar.php'; ?>

        <div class="content">
            <!-- Welcome Banner -->
            <div class="dashboard-welcome animate-fade-in">
                <h1 class="welcome-title">Feedback Dashboard</h1>
                <p class="welcome-subtitle">
                    Monitor and analyze campus feedback metrics for <?php echo $current_month . ' ' . $current_year; ?>
                    <?php if (!empty($selected_office_name)): ?>
                    <span class="badge bg-primary rounded-pill px-3 py-2 ms-2">
                        <i class="fas fa-building me-1"></i> <?php echo htmlspecialchars($selected_office_name); ?>
                    </span>
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="container-fluid">
                <!-- Stats Cards -->
                <div class="row stats-row animate-slide-up">
                    <div class="col-xl-4 col-md-6 mb-4">
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
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="stat-card satisfaction-card" style="border-left-color: var(--success-color);">
                            <div class="stat-card-content">
                                <div class="stat-icon" style="color: var(--success-color); background-color: rgba(28, 200, 138, 0.1);">
                                    <i class="fas fa-smile"></i>
                                </div>
                                <div class="stat-value"><?php echo number_format($sqd_rating, 1); ?>%</div>
                                <div class="stat-title">SQD Rating</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="stat-card positive-card" style="border-left-color: var(--info-color);">
                            <div class="stat-card-content">
                                <div class="stat-icon" style="color: var(--info-color); background-color: rgba(54, 185, 204, 0.1);">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <div class="stat-value"><?php echo number_format($total_agree + $total_strongly_agree); ?></div>
                                <div class="stat-title">Positive Responses</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Date Filter Section -->
                <div class="dashboard-card mb-4 animate-slide-up" style="animation-delay: 0.1s;">
                    <div class="dashboard-card-header">
                        <h5 class="dashboard-card-title">
                            <i class="fas fa-filter"></i>
                            Filter Options
                        </h5>
                    </div>
                    <div class="dashboard-card-body">
                        <form id="dateFilterForm" class="row g-3" method="GET">
                            <div class="col-md-3">
                                <div class="custom-form-group">
                                    <label class="custom-form-label" for="start_date">Start Date</label>
                                    <input type="month" class="custom-form-control" id="start_date" name="start_date" 
                                        value="<?php echo $start_date_formatted; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-form-group">
                                    <label class="custom-form-label" for="end_date">End Date</label>
                                    <input type="month" class="custom-form-control" id="end_date" name="end_date" 
                                        value="<?php echo $end_date_formatted; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-form-group">
                                    <label class="custom-form-label" for="office_name">Office</label>
                                    <select class="custom-form-control" id="office_name" name="office_name">
                                        <option value="">All Offices</option>
                                        <?php foreach ($offices as $office): ?>
                                        <option value="<?php echo htmlspecialchars($office['office_name']); ?>" <?php echo ($office_name == $office['office_name']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($office['office_name']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-custom btn-custom-primary me-2">
                                    <i class="fas fa-filter"></i> Apply Filter
                                </button>
                                <button type="button" id="resetFilter" class="btn btn-custom btn-custom-outline me-2">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <?php if ($_SESSION['atype'] == '0'): ?>
                                <button type="button" id="deleteFilteredData" class="btn btn-custom btn-custom-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12 d-flex align-items-end justify-content-end mt-4">
                                <div class="download-dropdown">
                                    <button type="button" class="download-btn">
                                        <i class="fas fa-download"></i> Download Data
                                        <i class="fas fa-caret-down ms-1"></i>
                                    </button>
                                    <div class="download-dropdown-content">
                                        <a href="ajax/exprtfeedback.php?format=csv&start_date=<?php echo $start_date_formatted; ?>&end_date=<?php echo $end_date_formatted; ?><?php echo !empty($office_name) ? '&office_name='.urlencode($office_name) : ''; ?>">
                                            <i class="fas fa-file-csv"></i> CSV Format
                                        </a>
                                        <a href="ajax/exprtfeedback.php?format=excel&start_date=<?php echo $start_date_formatted; ?>&end_date=<?php echo $end_date_formatted; ?><?php echo !empty($office_name) ? '&office_name='.urlencode($office_name) : ''; ?>">
                                            <i class="fas fa-file-excel"></i> Excel Format
                                        </a>
                                        <a href="ajax/exprtfeedback.php?format=pdf&start_date=<?php echo $start_date_formatted; ?>&end_date=<?php echo $end_date_formatted; ?><?php echo !empty($office_name) ? '&office_name='.urlencode($office_name) : ''; ?>">
                                            <i class="fas fa-file-pdf"></i> PDF Format
                                        </a>
                                        <a href="javascript:void(0)" id="printReport">
                                            <i class="fas fa-print"></i> Print Report
                                        </a>
                                    </div>
                                </div>
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
                                    <div class="filter-select">
                                        <select id="dateFilter">
                                            <option value="all">All Time</option>
                                            <option value="today">Today</option>
                                            <option value="week">This Week</option>
                                            <option value="month">This Month</option>
                                        </select>
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

                                <!-- Feedback Table -->
                                <div class="table-responsive">
                                    <table id="feedbackTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>DATE</th>
                                                <th>OFFICE</th>
                                                <th>TIME</th>
                                                <th>REQUIREMENTS</th>
                                                <th>STEPS</th>
                                                <th>INFORMATION</th>
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
                                                    <td data-label="OFFICE">
                                                        <span class="office-badge">
                                                            <i class="fas fa-building"></i>
                                                            <?php echo htmlspecialchars($feedback['office_name'] ?? 'Unknown'); ?>
                                                        </span>
                                                    </td>
                                                    <?php 
                                                    $ratingKeys = ['sqd1_time', 'sqd2_requirements', 'sqd3_steps', 'sqd4_information'];
                                                    $ratingLabels = ['TIME', 'REQUIREMENTS', 'STEPS', 'INFORMATION'];
                                                    
                                                    foreach ($ratingKeys as $index => $key): ?>
                                                    <td data-label="<?php echo $ratingLabels[$index]; ?>">
                                                        <div class="star-rating">
                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                            <i class="<?php echo $i <= $feedback[$key] ? 'fas' : 'far'; ?> fa-star"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </td>
                                                    <?php endforeach; ?>
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