<?php
include_once('assets/header.php');
include_once('../class/connection.php');

// Session and access control checks
if (!isset($_SESSION['atype'])) {
    header("Location: index.php");
    exit;
}

$account_type = $_SESSION['atype'];
if (!in_array($account_type, ['0', '1', '2', '3', '4'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

try {
    // Initialize variables
    $feedbacks = [];
    $feedback_type = '';
    $sqd_stats = [];
    $start_date = '';
    $end_date = '';

    // Determine feedback type and fetch data
    if ($account_type == '0') {
        // Get current period (last 6 months)
        $start_date = date('Y-m-d', strtotime('-6 months'));
        $end_date = date('Y-m-d');

        // CC1 - Awareness Query
        $cc1_sql = "SELECT 
            cc_awareness,
            COUNT(*) as total,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date1 AND :end_date1)) as percentage
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date2 AND :end_date2
        GROUP BY cc_awareness";

        $cc1_stmt = $connect->prepare($cc1_sql);
        $cc1_stmt->bindParam(':start_date1', $start_date);
        $cc1_stmt->bindParam(':end_date1', $end_date);
        $cc1_stmt->bindParam(':start_date2', $start_date);
        $cc1_stmt->bindParam(':end_date2', $end_date);
        $cc1_stmt->execute();
        $cc1_results = $cc1_stmt->fetchAll(PDO::FETCH_ASSOC);

        // CC2 - Visibility Query
        $cc2_sql = "SELECT 
            cc_visibility,
            COUNT(*) as total,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date1 AND :end_date1)) as percentage
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date2 AND :end_date2
        GROUP BY cc_visibility";

        $cc2_stmt = $connect->prepare($cc2_sql);
        $cc2_stmt->bindParam(':start_date1', $start_date);
        $cc2_stmt->bindParam(':end_date1', $end_date);
        $cc2_stmt->bindParam(':start_date2', $start_date);
        $cc2_stmt->bindParam(':end_date2', $end_date);
        $cc2_stmt->execute();
        $cc2_results = $cc2_stmt->fetchAll(PDO::FETCH_ASSOC);

        // CC3 - Helpfulness Query
        $cc3_sql = "SELECT 
            cc_helpfulness,
            COUNT(*) as total,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date1 AND :end_date1)) as percentage
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date2 AND :end_date2
        GROUP BY cc_helpfulness";

        $cc3_stmt = $connect->prepare($cc3_sql);
        $cc3_stmt->bindParam(':start_date1', $start_date);
        $cc3_stmt->bindParam(':end_date1', $end_date);
        $cc3_stmt->bindParam(':start_date2', $start_date);
        $cc3_stmt->bindParam(':end_date2', $end_date);
        $cc3_stmt->execute();
        $cc3_results = $cc3_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Modified SQD Query to include all fields
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
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date AND :end_date";

        $sqd_stmt = $connect->prepare($sqd_sql);
        $sqd_stmt->bindParam(':start_date', $start_date);
        $sqd_stmt->bindParam(':end_date', $end_date);
        $sqd_stmt->execute();
        $sqd_stats = $sqd_stmt->fetch(PDO::FETCH_ASSOC);

        // Regular feedback data
        $sql = "SELECT 
            id,
            sqd0_satisfaction,
            sqd1_time,
            sqd2_requirements,
            sqd3_steps,
            sqd4_information,
            sqd5_value,
            sqd6_security,
            sqd7_support,
            sqd8_outcome,
            improvements,
            email,
            name,
            feedback_date as created_at,
            DATE_FORMAT(feedback_date, '%M %d, %Y %h:%i %p') as formatted_date
        FROM office_feedback 
        ORDER BY feedback_date DESC";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $feedback_type = 'office';
    } else {
        // Handle organization user types
        if ($account_type == '2') {
            $orgSql = "SELECT users_org FROM users_tbl WHERE users_id = :user_id";
            $orgStmt = $connect->prepare($orgSql);
            $orgStmt->execute([':user_id' => $_SESSION['id']]);
            $org = $orgStmt->fetch(PDO::FETCH_ASSOC);
            $org_id = $org['users_org'];
        } else if ($account_type == '3') {
            $orgSql = "SELECT org_type FROM orgmembers_tbl WHERE id = :user_id AND is_active = 1";
            $orgStmt = $connect->prepare($orgSql);
            $orgStmt->execute([':user_id' => $_SESSION['id']]);
            $org = $orgStmt->fetch(PDO::FETCH_ASSOC);
            $org_id = $org['org_type'];
        }

        // Fetch organization feedback
        $sql = "SELECT of.*, o.org_name,
                DATE_FORMAT(of.created_at, '%M %d, %Y %h:%i %p') as formatted_date
                FROM org_feedback of
                LEFT JOIN organization_tbl o ON of.org_id = o.org_id";
        
        if ($account_type != '4') {
            $sql .= " WHERE of.org_id = :org_id";
        }
        
        $sql .= " ORDER BY of.created_at DESC";
        
        $stmt = $connect->prepare($sql);
        if ($account_type != '4') {
            $stmt->bindParam(':org_id', $org_id);
        }
        $stmt->execute();
        $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $feedback_type = 'organization';
    }
} catch (PDOException $e) {
    error_log("Error in feedback query: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Campus Kiosk Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- Original CSS First -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="assets/css/css.css" rel="stylesheet" />
    
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

    <style>
        /* CSM Report Styles */
        .csm-report {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }

        .csm-report .table th {
            background-color: #e6f3ff;
            border-color: #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }
        
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        /* Feedback Table Styles */
        .feedback-content-wrapper .dataTables_wrapper .dataTables_length select,
        .feedback-content-wrapper .dataTables_wrapper .dataTables_filter input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .feedback-content-wrapper .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }
        
        .feedback-content-wrapper table.dataTable thead th {
            padding: 12px 8px;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .feedback-filters select,
        .feedback-filters input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 8px;
        }

        .star-rating .fas.fa-star {
            color: #ffc107;
        }
        
        .star-rating .far.fa-star {
            color: #dee2e6;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'assets/includes/navbar.php'; ?>
        
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <?php echo $feedback_type == 'office' ? 'Office Feedback Dashboard' : 'Organization Feedback Dashboard'; ?>
                        </h4>
                    </div>
                 <!-- Filters -->
                        <div class="feedback-filters mb-4">
                            <input type="text" id="searchInput" placeholder="Search feedback...">
                            <select id="dateFilter">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>

                            <?php if ($feedback_type == 'organization' && $account_type == '4'): ?>
                            <select id="orgFilter">
                                <option value="all">All Organizations</option>
                                <?php
                                $orgQuery = "SELECT org_id, org_name FROM organization_tbl ORDER BY org_name";
                                $orgStmt = $connect->query($orgQuery);
                                while ($org = $orgStmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . htmlspecialchars($org['org_id']) . "'>" . 
                                         htmlspecialchars($org['org_name']) . "</option>";
                                }
                                ?>
                            </select>
                            <?php endif; ?>
                           
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="feedbackTable" class="table">
                                <thead>
                                    <tr>
                                        <?php if ($feedback_type == 'organization'): ?>
                                        <th>Organization</th>
                                        <?php endif; ?>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <?php 
                                        $ratingColumns = $feedback_type == 'office' ? 
                                            ['Satisfaction', 'Time', 'Requirements', 'Steps', 'Information'] :
                                            ['Event Quality', 'Communication', 'Inclusivity', 'Leadership'];
                                        
                                        foreach ($ratingColumns as $column): ?>
                                        <th><?php echo $column; ?></th>
                                        <?php endforeach; ?>
                                        <th>Improvements</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feedbacks as $feedback): ?>
                                    <tr>
                                        <?php if ($feedback_type == 'organization'): ?>
                                        <td>
                                            <?php echo htmlspecialchars($feedback['org_name']); ?>
                                        </td>
                                        <?php endif; ?>
                                        <td>
                                            <?php echo htmlspecialchars($feedback['name'] ?? 'Anonymous'); ?>
                                        </td>
                                        <td>
                                            <?php echo $feedback['formatted_date']; ?>
                                        </td>
                                        <?php 
                                        $ratingKeys = $feedback_type == 'office' ? 
                                            ['sqd0_satisfaction', 'sqd1_time', 'sqd2_requirements', 'sqd3_steps', 'sqd4_information'] :
                                            ['event_quality_rating', 'communication_rating', 'inclusivity_rating', 'leadership_rating'];
                                        
                                        foreach ($ratingKeys as $key): ?>
                                        <td>
                                            <div class="star-rating">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="<?php echo $i <= $feedback[$key] ? 'fas' : 'far'; ?> fa-star"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                        <?php endforeach; ?>
                                        <td>
                                            <?php echo htmlspecialchars($feedback['improvements'] ?? ''); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- CSM Summary Report with Enhanced Visual Design -->
<div class="csm-report card shadow-sm mb-4">
    <!-- Header with Logo -->
    <div class="card-header bg-primary text-white py-3">
        <div class="text-center">
            <img src="../img/tsulogo.jfif" alt="Tarlac State University Logo" style="width: 80px; border-radius: 50%; background: white; padding: 5px; margin-bottom: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 class="mb-0 fw-bold">Tarlac State University</h3>
            <p class="mb-0">Quality Management Unit</p>
        </div>
    </div>
    
    <div class="card-body">
        <div class="report-title text-center mb-4">
            <h4 class="text-primary fw-bold">Client Satisfaction Measurement (CSM) Summary Report</h4>
            <h5 class="text-secondary">Tarlac State University - San Isidro Extension Campus</h5>
            <p class="badge bg-info text-white px-3 py-2 mt-2">From the period of <?php echo date('F Y', strtotime($start_date)); ?> to <?php echo date('F Y', strtotime($end_date)); ?></p>
        </div>

        <button id="downloadExcel" class="btn btn-sm btn-success">
                                <i class="fas fa-file-excel"></i> Download as Excel
                            </button>

        <!-- CC Questions Section -->
        <div class="section-container mb-4">
            <div class="section-header d-flex align-items-center bg-light p-3 border-start border-5 border-primary rounded">
                <i class="fas fa-question-circle text-primary me-2 fs-4"></i>
                <h5 class="mb-0 fw-bold">Citizen's Charter (CC) Questions</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th colspan="2" class="text-primary">Citizen's Charter (CC) Question</th>
                            <th style="width: 100px;" class="text-center">Responses</th>
                            <th style="width: 100px;" class="text-center">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CC1 Section -->
                        <tr class="table-active">
                            <td style="width: 50px;" class="fw-bold">CC1</td>
                            <td colspan="3" class="fw-bold">Which of the following best describes your awareness of a CC?</td>
                        </tr>
                        <?php foreach($cc1_results as $result): ?>
                        <tr>
                            <td></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-angle-right text-muted me-2"></i>
                                    <?php echo htmlspecialchars($result['cc_awareness'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="text-center fw-bold"><?php echo $result['total']; ?></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $result['percentage']; ?>%" aria-valuenow="<?php echo $result['percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo number_format($result['percentage'], 2); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- CC2 Section -->
                        <tr class="table-active">
                            <td class="fw-bold">CC2</td>
                            <td colspan="3" class="fw-bold">If aware of CC, would you say that the CC of this office was:</td>
                        </tr>
                        <?php foreach($cc2_results as $result): ?>
                        <tr>
                            <td></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-angle-right text-muted me-2"></i>
                                    <?php echo htmlspecialchars($result['cc_visibility'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="text-center fw-bold"><?php echo $result['total']; ?></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $result['percentage']; ?>%" aria-valuenow="<?php echo $result['percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo number_format($result['percentage'], 2); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- CC3 Section -->
                        <tr class="table-active">
                            <td class="fw-bold">CC3</td>
                            <td colspan="3" class="fw-bold">If aware of CC, How much did the CC help you in your transaction?</td>
                        </tr>
                        <?php foreach($cc3_results as $result): ?>
                        <tr>
                            <td></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-angle-right text-muted me-2"></i>
                                    <?php echo htmlspecialchars($result['cc_helpfulness'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="text-center fw-bold"><?php echo $result['total']; ?></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $result['percentage']; ?>%" aria-valuenow="<?php echo $result['percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo number_format($result['percentage'], 2); ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SQD Table Section -->
        <div class="section-container">
            <div class="section-header d-flex align-items-center bg-light p-3 border-start border-5 border-success rounded">
                <i class="fas fa-chart-pie text-success me-2 fs-4"></i>
                <h5 class="mb-0 fw-bold">Service Quality Dimensions (SQD)</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
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
                                <span class="d-block">Neither Agree</span>
                                <span class="d-block">nor Disagree</span>
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

                        foreach($sqd_questions as $key => $question):
                            $num = substr($key, 3);
                            $prefix = strtolower($key) . '_';
                            
                            // Get color based on rating percentage
                            $overall = ($sqd_stats[$prefix.'agree'] + $sqd_stats[$prefix.'strongly_agree']) / 
                                     ($sqd_stats['total_responses'] - $sqd_stats[$prefix.'na']) * 100;
                            
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

                        <!-- Overall Rating Row -->
                        <tr class="table-active fw-bold">
                            <td colspan="2" class="text-end">Overall Rating</td>
                            <?php
                            $total_strongly_disagree = 0;
                            $total_disagree = 0;
                            $total_neutral = 0;
                            $total_agree = 0;
                            $total_strongly_agree = 0;
                            $total_na = 0;
                            $grand_total = 0;

                            foreach($sqd_questions as $key => $question) {
                                $prefix = strtolower($key) . '_';
                                $total_strongly_disagree += $sqd_stats[$prefix.'strongly_disagree'];
                                $total_disagree += $sqd_stats[$prefix.'disagree'];
                                $total_neutral += $sqd_stats[$prefix.'neutral'];
                                $total_agree += $sqd_stats[$prefix.'agree'];
                                $total_strongly_agree += $sqd_stats[$prefix.'strongly_agree'];
                                $total_na += $sqd_stats[$prefix.'na'];
                            }
                            $grand_total = $total_strongly_disagree + $total_disagree + $total_neutral + 
                                         $total_agree + $total_strongly_agree + $total_na;
                            $overall_rating = ($total_agree + $total_strongly_agree) / 
                                            ($grand_total - $total_na) * 100;
                                            
                            // Determine overall badge class
                            if ($overall_rating >= 90) {
                                $overall_badge_class = "bg-success";
                            } else if ($overall_rating >= 80) {
                                $overall_badge_class = "bg-info";
                            } else if ($overall_rating >= 60) {
                                $overall_badge_class = "bg-warning text-dark";
                            } else {
                                $overall_badge_class = "bg-danger";
                            }
                            ?>
                            <td class="text-center"><?php echo $total_strongly_disagree; ?></td>
                            <td class="text-center"><?php echo $total_disagree; ?></td>
                            <td class="text-center"><?php echo $total_neutral; ?></td>
                            <td class="text-center"><?php echo $total_agree; ?></td>
                            <td class="text-center"><?php echo $total_strongly_agree; ?></td>
                            <td class="text-center"><?php echo $total_na; ?></td>
                            <td class="text-center"><?php echo $grand_total; ?></td>
                            <td class="text-center">
                                <span class="badge <?php echo $overall_badge_class; ?> fs-6 px-2 py-1"><?php echo number_format($overall_rating, 2); ?>%</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Rating Result Card -->
            <div class="card mt-3 mb-3 border-0">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">Overall Rating Result</h5>
                    <?php
                    // Determine rating result with appropriate styling
                    if ($overall_rating >= 95) {
                        $rating_text = "Excellent";
                        $rating_class = "success";
                        $rating_icon = "star";
                    } else if ($overall_rating >= 90) {
                        $rating_text = "Very Satisfactory";
                        $rating_class = "primary";
                        $rating_icon = "thumbs-up";
                    } else if ($overall_rating >= 85) {
                        $rating_text = "Satisfactory";
                        $rating_class = "info";
                        $rating_icon = "check";
                    } else if ($overall_rating >= 80) {
                        $rating_text = "Fair";
                        $rating_class = "warning";
                        $rating_icon = "minus";
                    } else {
                        $rating_text = "Poor";
                        $rating_class = "danger";
                        $rating_icon = "thumbs-down";
                    }
                    ?>
                    <div class="alert alert-<?php echo $rating_class; ?> d-inline-flex align-items-center px-4 py-3" role="alert">
                        <i class="fas fa-<?php echo $rating_icon; ?> me-2 fs-5"></i>
                        <span class="fs-5 fw-bold"><?php echo $rating_text; ?></span>
                    </div>
                    
                    <!-- Rating Progress Bar -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold">Overall Satisfaction Score</span>
                            <span class="fw-bold"><?php echo number_format($overall_rating, 2); ?>%</span>
                        </div>
                        <div class="progress" style="height: 15px;">
                            <div class="progress-bar bg-<?php echo $rating_class; ?>" role="progressbar" 
                                 style="width: <?php echo $overall_rating; ?>%" 
                                 aria-valuenow="<?php echo $overall_rating; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="small text-muted">0%</span>
                            <span class="small text-muted">100%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Rating Legend -->
            <div class="row mt-3">
                <div class="col-md-12 col-lg-8 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Rating Scale Legend</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="badge bg-success me-2">≥ 95%</span>
                                            <span class="fw-bold">Excellent</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="badge bg-primary me-2">90-94.99%</span>
                                            <span class="fw-bold">Very Satisfactory</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="badge bg-info me-2">85-89.99%</span>
                                            <span class="fw-bold">Satisfactory</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="badge bg-warning text-dark me-2">80-84.99%</span>
                                            <span class="fw-bold">Fair</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="badge bg-danger me-2">< 80%</span>
                                            <span class="fw-bold">Poor</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer text-center py-3 bg-light">
        <small class="text-muted">Report generated on <?php echo date('F d, Y h:i A'); ?></small>
    </div>
</div>
              
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#feedbackTable').DataTable({
                pageLength: 10,
                responsive: true,
                // Remove the default search box
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>rtip',
                order: [[1, 'desc']] // Sort by date column by default
            });

            // Connect custom search input to DataTable
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Date filter function
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const dateValue = $('#dateFilter').val();
                if (dateValue === 'all') return true;

                const dateStr = data[1]; // Date column index
                const feedbackDate = new Date(dateStr);
                const today = new Date();

                switch(dateValue) {
                    case 'today': {
                        const todayStart = new Date(today.setHours(0, 0, 0, 0));
                        const todayEnd = new Date(today.setHours(23, 59, 59, 999));
                        return feedbackDate >= todayStart && feedbackDate <= todayEnd;
                    }
                    case 'week': {
                        const curr = new Date();
                        const first = curr.getDate() - curr.getDay();
                        const weekStart = new Date(curr.setDate(first));
                        weekStart.setHours(0, 0, 0, 0);
                        const last = first + 6;
                        const weekEnd = new Date(curr.setDate(last));
                        weekEnd.setHours(23, 59, 59, 999);
                        return feedbackDate >= weekStart && feedbackDate <= weekEnd;
                    }
                    case 'month': {
                        const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                        const monthEnd = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        monthEnd.setHours(23, 59, 59, 999);
                        return feedbackDate >= monthStart && feedbackDate <= monthEnd;
                    }
                    default:
                        return true;
                }
            });

            // Date filter change handler
            $('#dateFilter').on('change', function() {
                table.draw();
            });

            // Organization filter handler
            $('#orgFilter').on('change', function() {
                const val = $(this).val();
                if (val === 'all') {
                    table.column(0).search('').draw();
                } else {
                    table.column(0).search($(this).val()).draw();
                }
            });

              // Download Excel button handler
        $('#downloadExcel').on('click', function() {
            // Get current filter values
            const dateValue = $('#dateFilter').val();
            const searchValue = $('#searchInput').val();
            
            let orgValue = 'all';
            if ($('#orgFilter').length) {
                orgValue = $('#orgFilter').val();
            }
            
            // Build the export URL with filters
            let exportUrl = 'ajax/exprtfeedback.php?date=' + dateValue;
            
            if (searchValue) {
                exportUrl += '&search=' + encodeURIComponent(searchValue);
            }
            
            if (orgValue !== 'all') {
                exportUrl += '&org=' + encodeURIComponent(orgValue);
            }
            
            // Redirect to the export script
            window.location.href = exportUrl;
        });
        });
    </script>
</body>
</html>