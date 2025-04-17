<?php
include_once('assets/header.php');
include_once('../class/connection.php');

if (!isset($_SESSION['atype'])) {
    // If the session is not set, redirect to the login page
    header("Location: index.php");
    exit;
}

$account_type = $_SESSION['atype'];
if ($account_type != '0' && $account_type != '1' && $account_type != '2' && $account_type != '3' && $account_type != '4') {
    // Destroy the session if the account type is invalid
    session_destroy();
    // Redirect to the login page
    header("Location: index.php");
    exit;
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Query for organization count
    $sql_organization = "SELECT COUNT(*) as count FROM organization_tbl";
    $stmt_organization = $connect->prepare($sql_organization);
    $stmt_organization->execute();
    $result_organization = $stmt_organization->fetch(PDO::FETCH_ASSOC);
    $organization_count = $result_organization['count'];

    // Query for members count - modified to count from orgmembers_tbl
    if ($account_type == '2' || $account_type == '3') {
        // For type 2 and 3, count members from their specific organization
        $sql_members = "SELECT COUNT(*) as count FROM orgmembers_tbl 
                       WHERE org_type = (
                           CASE 
                               WHEN :account_type = '2' THEN (
                                   SELECT users_org FROM users_tbl WHERE users_id = :user_id
                               )
                               WHEN :account_type = '3' THEN (
                                   SELECT org_type FROM orgmembers_tbl WHERE id = :user_id
                               )
                           END
                       )";
        $stmt_members = $connect->prepare($sql_members);
        $stmt_members->execute([
            ':account_type' => $account_type,
            ':user_id' => $_SESSION['id']
        ]);
    } else {
        // For other types (0, 1, 4), count all members from orgmembers_tbl
        $sql_members = "SELECT COUNT(*) as count FROM orgmembers_tbl";
        $stmt_members = $connect->prepare($sql_members);
        $stmt_members->execute();
    }
    $result_members = $stmt_members->fetch(PDO::FETCH_ASSOC);
    $members_count = $result_members['count'] ?? 0; // Added null coalescing operator

   
  // Query for announcements count based on account type
  
try {
    if ($account_type == '2' || $account_type == '3') {
        // First get the user's organization (using aid instead of id to match session variable)
        $org_query = "SELECT users_org FROM users_tbl WHERE users_id = :user_id";
        $org_stmt = $connect->prepare($org_query);
        $org_stmt->execute([':user_id' => $_SESSION['aid'] ?? $_SESSION['id']]); // Using 'aid' with fallback to 'id'
        $org_row = $org_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($org_row) {
            // Count announcements for the user's organization
            $sql_announcements = "
                SELECT COUNT(*) as count 
                FROM announcement_tbl a
                LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id
                LEFT JOIN organization_tbl o ON u.users_org = o.org_id
                WHERE u.users_org = :org_id 
                AND a.is_archived = 0";
            
            $stmt_announcements = $connect->prepare($sql_announcements);
            $stmt_announcements->execute([':org_id' => $org_row['users_org']]);
        } else {
            // If no organization found, set count to 0
            $stmt_announcements = null;
            $announcements_count = 0;
        }
    } else {
        // For other types (0, 1, 4), count all non-archived announcements
        $sql_announcements = "SELECT COUNT(*) as count FROM announcement_tbl WHERE is_archived = 0";
        $stmt_announcements = $connect->prepare($sql_announcements);
        $stmt_announcements->execute();
    }

    if ($stmt_announcements) {
        $result_announcements = $stmt_announcements->fetch(PDO::FETCH_ASSOC);
        $announcements_count = $result_announcements['count'] ?? 0;
    }
} catch (PDOException $e) {
    error_log('Error counting announcements: ' . $e->getMessage());
    $announcements_count = 0;
}

    // Query for events count
    $sql_events = "SELECT COUNT(*) as count FROM calendar_tbl";
    $stmt_events = $connect->prepare($sql_events);
    $stmt_events->execute();
    $result_events = $stmt_events->fetch(PDO::FETCH_ASSOC);
    $events_count = $result_events['count'];

    // Query for feedback count based on account type
    if ($account_type == '0') {
        // For admin (type 0), count office feedback
        $sql_feedback = "SELECT COUNT(*) as count FROM office_feedback";
    } else if ($account_type == '2' || $account_type == '3') {
        // For type 2 and 3, count org feedback for their specific organization
        $sql_feedback = "SELECT COUNT(*) as count FROM org_feedback 
                        WHERE org_id = (
                            CASE 
                                WHEN :account_type = '2' THEN (
                                    SELECT users_org FROM users_tbl WHERE users_id = :user_id
                                )
                                WHEN :account_type = '3' THEN (
                                    SELECT org_type FROM orgmembers_tbl WHERE id = :user_id
                                )
                            END
                        )";
        $stmt_feedback = $connect->prepare($sql_feedback);
        $stmt_feedback->execute([
            ':account_type' => $account_type,
            ':user_id' => $_SESSION['id']
        ]);
    } else if ($account_type == '4') {
        // For type 4, count all org feedback
        $sql_feedback = "SELECT COUNT(*) as count FROM org_feedback";
        $stmt_feedback = $connect->prepare($sql_feedback);
        $stmt_feedback->execute();
    } else {
        // Default to 0 if account type is not recognized
        $feedback_count = 0;
    }

    if (isset($sql_feedback) && !isset($stmt_feedback)) {
        $stmt_feedback = $connect->prepare($sql_feedback);
        $stmt_feedback->execute();
    }

    if (isset($stmt_feedback)) {
        $result_feedback = $stmt_feedback->fetch(PDO::FETCH_ASSOC);
        $feedback_count = $result_feedback['count'] ?? 0; // Added null coalescing operator
    } else {
        $feedback_count = 0;
    }
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
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
  <title>
    Campus Kiosk Admin
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link href="assets/css/css.css" rel="stylesheet" />
  <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -15px;
        }
        
        .col-lg-6, .col-lg-12, .col-md-12 {
            padding: 15px;
            box-sizing: border-box;
        }
        
        @media (min-width: 992px) {
            .col-lg-6 { width: 50%; }
            .col-lg-12 { width: 100%; }
        }
        
        @media (max-width: 991px) {
            .col-md-12 { width: 100%; }
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: slideIn 0.5s ease-out;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
        
        .card-header {
            padding: 20px;
            border-radius: 12px 12px 0 0;
            background: linear-gradient(45deg, #83435d, #573131);
            position: relative;
            overflow: hidden;
        }
        
        .card-header:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 3s infinite;
        }
        
        .card-title {
            color: gray ;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 500;
        }
        
      


        .chart-card .card-body {
    padding: 20px;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background: rgba(234, 182, 118, 0.7);  /* Base golden color */
    animation: pulseBG 3s ease-in-out infinite;
    backdrop-filter: blur(8px);
    color: #2d2d2d;  /* Dark text for contrast */
    border: 1px solid rgba(234, 182, 118, 0.3);  /* Subtle border */
    box-shadow: 0 4px 20px rgba(234, 182, 118, 0.2);  /* Warm shadow */
}

@keyframes pulseBG {
    0% { 
        background: rgba(234, 182, 118, 0.7);
        box-shadow: 0 4px 20px rgba(234, 182, 118, 0.2);
    }
    50% { 
        background: rgba(234, 182, 118, 0.9);
        box-shadow: 0 4px 25px rgba(234, 182, 118, 0.3);
    }
    100% { 
        background: rgba(234, 182, 118, 0.7);
        box-shadow: 0 4px 20px rgba(234, 182, 118, 0.2);
    }
}

        canvas {
            max-width: 100%;
            height: auto !important;
            transition: opacity 0.3s ease;
        }
        
        .footer {
            padding: 20px 0;
            text-align: center;
            background: #f8f9fa;
            margin-top: 30px;
        }
        
        .heart {
            color: #ff4d4d;
            display: inline-block;
            animation: pulse 1.5s ease infinite;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes shine {
            0% { left: -100%; }
            20% { left: 100%; }
            100% { left: 100%; }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
    
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom legend styling */
        #pieChartLegend {
            right: 20px;
        }
        
        #pieChartLegend li {
            margin: 10px 0;
            display: flex;
            align-items: center;
            animation: fadeIn 0.5s ease-out;
        }
        
        #pieChartLegend li::before {
            content: '';
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 8px;
            border-radius: 2px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .dashboard-tab {
            display: none;
        }
        .dashboard-tab.active {
            display: block;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            margin-bottom: 20px;
        }
        .metric-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .metric-value {
            font-size: 24px;
            font-weight: bold;
            color: #4A90E2;
        }
        
        .metric-update {
            animation: pulse 0.5s ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .loading-indicator {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
    </style>
</head>

<body class=""><div class="wrapper ">
    <!-- sweetalert start-->
    <?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
      <div class="content">
      <div class="row">
      <?php if (!in_array($account_type, ['2', '3', '4'])) { ?>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Organization</p>
              <p class="card-title"><?php echo htmlspecialchars($organization_count); ?></p>
              <p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
      </div>
    </div>
  </div>
 
 
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-favourite-28 text-primary"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Events</p>
              <p class="card-title"><?php echo htmlspecialchars($events_count); ?></p>
              <p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
      </div>
    </div>
  </div>
<?php } ?>
<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-money-coins text-success"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Members</p>
              <p class="card-title"><?php echo htmlspecialchars($members_count); ?></p>
              <p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-vector text-danger"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Announcement</p>
              <p class="card-title"><?php echo htmlspecialchars($announcements_count); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
      </div>
    </div>
  </div>
  <?php
// Only show feedback section for account types 0, 2, 3, and 4
if ($account_type == '0' || $account_type == '2' || $account_type == '3' || $account_type == '4') { ?>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="nc-icon nc-chat-33 text-info"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">
                            <?php 
                            if ($account_type == '0') {
                                echo 'Office Feedback';
                            } else {
                                echo 'Organization Feedback';
                            }
                            ?>
                            </p>
                            <p class="card-title"><?php echo htmlspecialchars($feedback_count); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <hr>
            </div>
        </div>
    </div>
<?php } ?>
        </div>

        <?php if ($account_type == '0' || $account_type == '2' || $account_type == '3' || $account_type == '4') { ?>
    <input type="hidden" id="account-type-data" value="<?php echo htmlspecialchars($account_type); ?>">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
        <?php if ($account_type == '0') { ?>
    <!-- Admin only sees Office Feedback -->
    <div id="office-dashboard" class="dashboard-tab active">
        <!-- Time Filter -->
        <div class="mb-6">
            <select id="timeFilter" onchange="refreshData()" class="border rounded-lg px-4 py-2">
                <option value="all">All Time</option>
                <option value="month">Last Month</option>
                <option value="week">Last Week</option>
            </select>
        </div>

        <!-- SQD Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="metric-card bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-center">Overall Satisfaction</h3>
                <div id="sqd0_satisfaction" class="metric-value text-2xl text-center mt-2">0.0</div>
            </div>
            <div class="metric-card bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-center">Processing Time</h3>
                <div id="sqd1_time" class="metric-value text-2xl text-center mt-2">0.0</div>
            </div>
            <div class="metric-card bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-center">Requirements</h3>
                <div id="sqd2_requirements" class="metric-value text-2xl text-center mt-2">0.0</div>
            </div>
            <div class="metric-card bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-center">Process Steps</h3>
                <div id="sqd3_steps" class="metric-value text-2xl text-center mt-2">0.0</div>
            </div>
            <div class="metric-card bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold text-center">Information</h3>
                <div id="sqd4_information" class="metric-value text-2xl text-center mt-2">0.0</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="metric-card bg-white rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-center">CC Awareness</h3>
            <div id="cc_awareness" class="metric-value text-2xl text-center mt-2">0.0</div>
        </div>
        <div class="metric-card bg-white rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-center">CC Visibility</h3>
            <div id="cc_visibility" class="metric-value text-2xl text-center mt-2">0.0</div>
        </div>
        <div class="metric-card bg-white rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-center">CC Helpfulness</h3>
            <div id="cc_helpfulness" class="metric-value text-2xl text-center mt-2">0.0</div>
        </div>
    </div>
    
    <!-- CC Distribution Chart -->
   
        <!-- Charts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Rating Distribution</h3>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="office-distribution-chart"></canvas>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Rating Trends</h3>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="office-trend-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- CC Metrics Chart -->
        <div class="bg-white p-4 rounded-lg shadow mt-6">
        <h3 class="text-lg font-semibold mb-4">Campus Kiosk Feedback Distribution</h3>
        <div class="chart-container">
    <canvas id="cc-metrics-chart"></canvas>
</div>
    </div>
<?php } ?>

            <?php if ($account_type == '2' || $account_type == '3' || $account_type == '4') { ?>
                <!-- Organization Dashboard -->
                <div class="dashboard-container">
                    <!-- Tab Navigation -->
                    <div class="tab-navigation mb-4">
                        <button onclick="switchDashboardTab('org-dashboard')" class="tab-button active px-4 py-2 mr-2 rounded bg-blue-500 text-white" data-tab="org-dashboard">
                            Organization Feedback
                        </button>
                        <button onclick="switchDashboardTab('event-evaluations-dashboard')" class="tab-button px-4 py-2 rounded bg-gray-200 text-gray-700" data-tab="event-evaluations-dashboard">
                            Event Evaluations
                        </button>
                    </div>

                    <!-- Organization Dashboard Content -->
                    <div id="org-dashboard" class="dashboard-tab" style="display: block;">
                        <?php
                        $orgInfo = null;
                        try {
                            if ($account_type == '2') {
                                $userStmt = $connect->prepare("SELECT o.org_id, o.org_name 
                                                             FROM organization_tbl o 
                                                             INNER JOIN users_tbl u ON o.org_id = u.users_org 
                                                             WHERE u.users_id = :user_id");
                                $userStmt->execute([':user_id' => $_SESSION['id']]);
                                $orgInfo = $userStmt->fetch(PDO::FETCH_ASSOC);
                            } else if ($account_type == '3') {
                                $userStmt = $connect->prepare("SELECT DISTINCT o.org_id, o.org_name 
                                                             FROM organization_tbl o 
                                                             INNER JOIN orgmembers_tbl om ON o.org_id = om.org_type 
                                                             WHERE om.id = :user_id AND om.is_active = 1");
                                $userStmt->execute([':user_id' => $_SESSION['id']]);
                                $orgInfo = $userStmt->fetch(PDO::FETCH_ASSOC);
                            }
                        } catch (PDOException $e) {
                            error_log('Error fetching organization: ' . $e->getMessage());
                        }
                        ?>

                        <!-- Organization Filters -->
                        <div class="mb-6 flex gap-4">
                            <select id="timeFilter" onchange="refreshData()" class="border rounded-lg px-4 py-2">
                                <option value="all">All Time</option>
                                <option value="month">Last Month</option>
                                <option value="week">Last Week</option>
                            </select>

                            <?php if ($account_type == '4') { ?>
                                <select id="orgFilter" onchange="refreshData()" class="border rounded-lg px-4 py-2">
                                    <option value="all">All Organizations</option>
                                    <?php
                                    try {
                                        $sql = "SELECT org_id, org_name FROM organization_tbl ORDER BY org_name";
                                        $stmt = $connect->prepare($sql);
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . htmlspecialchars($row['org_id']) . '">' . 
                                                 htmlspecialchars($row['org_name']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log('Error fetching organizations: ' . $e->getMessage());
                                        echo '<div class="text-red-500 mb-4">Error loading organizations list.</div>';
                                    }
                                    ?>
                                </select>
                            <?php } else if ($orgInfo) { ?>
                                <div class="border rounded-lg px-4 py-2 bg-gray-100">
                                    <?php echo htmlspecialchars($orgInfo['org_name']); ?>
                                </div>
                                <input type="hidden" id="orgFilter" value="<?php echo htmlspecialchars($orgInfo['org_id']); ?>" />
                            <?php } ?>
                        </div>

                        <!-- Organization Metrics -->
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
                            <div class="metric-card bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold text-center">Event Quality</h3>
                                <div id="event-quality-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
                            </div>
                            <div class="metric-card bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold text-center">Communication</h3>
                                <div id="org-communication-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
                            </div>
                            <div class="metric-card bg-white rounded-lg p-4 shadow">
                               <h3 class="text-lg font-semibold text-center">Inclusivity</h3>
                                <div id="inclusivity-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
                            </div>
                            <div class="metric-card bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold text-center">Leadership</h3>
                                <div id="leadership-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
                            </div>
                            <div class="metric-card bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold text-center">Skill Development</h3>
                                <div id="skill-dev-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
                            </div>
                            <div class="metric-card bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold text-center">Impact</h3>
                                <div id="impact-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
                            </div>
                        </div>

                        <!-- Organization Charts -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Rating Distribution</h3>
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="org-distribution-chart"></canvas>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Rating Trends</h3>
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="org-trend-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Evaluations Dashboard -->
                    <div id="event-evaluations-dashboard" class="dashboard-tab" style="display: none;">
                        <!-- Event Evaluation Filters -->
                        <div class="mb-6 flex gap-4">
                            <select id="evalTimeFilter" onchange="refreshEventEvalData()" class="border rounded-lg px-4 py-2">
                                <option value="all">All Time</option>
                                <option value="month">Last Month</option>
                                <option value="week">Last Week</option>
                            </select>

                            <?php if ($account_type == '4') { ?>
                                <select id="evalOrgFilter" onchange="refreshEventEvalData()" class="border rounded-lg px-4 py-2">
                                    <option value="all">All Organizations</option>
                                    <?php
                                    try {
                                        $sql = "SELECT org_id, org_name FROM organization_tbl ORDER BY org_name";
                                        $stmt = $connect->prepare($sql);
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . htmlspecialchars($row['org_id']) . '">' . 
                                                 htmlspecialchars($row['org_name']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log('Error fetching organizations: ' . $e->getMessage());
                                    }
                                    ?>
                                </select>
                            <?php } else if ($orgInfo) { ?>
                                <div class="border rounded-lg px-4 py-2 bg-gray-100">
                                    <?php echo htmlspecialchars($orgInfo['org_name']); ?>
                                </div>
                                <input type="hidden" id="evalOrgFilter" value="<?php echo htmlspecialchars($orgInfo['org_id']); ?>" />
                            <?php } ?>
                        </div>

                        <!-- Loading Indicator -->
                        <div id="eval-loading-indicator" class="hidden">
                            <div class="flex justify-center items-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                            </div>
                        </div>
                        <!-- Event Evaluation Metrics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="metric-card bg-white rounded-lg p-4 shadow">
        <h3 class="text-lg font-semibold text-center">Participant Rating</h3>
        <div id="participant-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
    </div>
    <div class="metric-card bg-white rounded-lg p-4 shadow">
        <h3 class="text-lg font-semibold text-center">Video Quality</h3>
        <div id="video-quality-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
    </div>
    <div class="metric-card bg-white rounded-lg p-4 shadow">
        <h3 class="text-lg font-semibold text-center">Audio Quality</h3>
        <div id="audio-quality-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
    </div>
    <div class="metric-card bg-white rounded-lg p-4 shadow">
        <h3 class="text-lg font-semibold text-center">Overall Impact</h3>
        <div id="overall-impact-rating" class="metric-value text-2xl text-center mt-2">0.0</div>
    </div>
</div>

                        <!-- Performance Metrics -->
                        <div class="grid grid-cols-1 gap-6 mb-6">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Event Performance Metrics</h3>
                                <div class="chart-container" style="position: relative; height: 400px;">
                                    <canvas id="perf-metrics-chart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Methodology Analysis -->
                        <div class="mt-6 bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Event Methodology Analysis</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="methodology-chart"></canvas>
                                </div>
                                <div id="methodology-stats" class="p-4">
                                    <!-- Methodology statistics will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  <script src="assets/demo/demo.js"></script>
  <script>
    // Make sure we define aid with a fallback to null
    var aid = <?php echo isset($_SESSION['aid']) ? json_encode($_SESSION['aid']) : 'null'; ?>;
    console.log("The value of aid is:", aid);
  </script>
 
      
 <script>
    // Global chart instances and configurations
let officeDistChart, officeTrendChart, orgDistChart, orgTrendChart;
let perfMetricsChart, methodologyChart, ccMetricsChart;

const chartConfig = {
    colors: {
        office: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40', '#9966FF'],
        org: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40', '#9966FF'],
        ccColors: {
            positive: 'rgba(75, 192, 192, 0.7)',
            neutral: 'rgba(255, 206, 86, 0.7)',
            negative: 'rgba(255, 99, 132, 0.7)'
        }
    },
    chartDefaults: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
};

// Metric definitions
const sqdMetrics = {
    'avg_0_satisfaction': 'Overall Satisfaction',
    'avg_1_time': 'Processing Time',
    'avg_2_requirements': 'Requirements',
    'avg_3_steps': 'Process Steps',
    'avg_4_information': 'Information'
};

const orgMetrics = {
    'event_quality': 'Event Quality',
    'communication': 'Communication',
    'inclusivity': 'Inclusivity',
    'leadership': 'Leadership',
    'skill_dev': 'Skill Development',
    'impact': 'Impact'
};

// Main initialization
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing dashboard...');
    const accountTypeElement = document.getElementById('account-type-data');
    if (!accountTypeElement) {
        console.error('Account type element not found');
        return;
    }

    const accountType = accountTypeElement.value;
    console.log('Account Type:', accountType);
    
    setupDashboard(accountType);
    setupEventListeners(accountType);
    initializeTabSystem();
});

// Dashboard setup functions
function setupDashboard(accountType) {
    console.log('Setting up dashboard for account type:', accountType);
    if (accountType === '0') {
        initializeOfficeCharts();
        refreshData('office');
    } else if (['2', '3', '4'].includes(accountType)) {
        initializeOrgCharts();
        refreshData('org');
    }
}

function setupEventListeners(accountType) {
    const timeFilter = document.getElementById('timeFilter');
    const orgFilter = document.getElementById('orgFilter');
    const evalTimeFilter = document.getElementById('evalTimeFilter');
    const evalOrgFilter = document.getElementById('evalOrgFilter');

    if (timeFilter) {
        timeFilter.addEventListener('change', () => refreshData(accountType === '0' ? 'office' : 'org'));
    }

    if (orgFilter && accountType === '4') {
        orgFilter.addEventListener('change', () => refreshData('org'));
    }

    if (evalTimeFilter) {
        evalTimeFilter.addEventListener('change', refreshEventEvalData);
    }

    if (evalOrgFilter && accountType === '4') {
        evalOrgFilter.addEventListener('change', refreshEventEvalData);
    }
}

// Chart initialization functions
function initializeOfficeCharts() {
    console.log('Initializing office charts');
    initializeOfficeDistributionChart();
    initializeOfficeTrendChart();
    initializeCCMetricsChart();
}

function initializeOrgCharts() {
    console.log('Initializing organization charts');
    initializeOrgDistributionChart();
    initializeOrgTrendChart();
}
function initializeCCMetricsChart() {
    const ctx = document.getElementById('cc-metrics-chart');
    if (!ctx) {
        console.error('CC Metrics chart canvas not found');
        return;
    }

    ccMetricsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Awareness', 'Visibility', 'Helpfulness'],
            datasets: [
                {
                    label: 'Positive',
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    data: [0, 0, 0]
                },
                {
                    label: 'Neutral',
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    data: [0, 0, 0]
                },
                {
                    label: 'Negative',
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    data: [0, 0, 0]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw.toFixed(1) + '%';
                        }
                    }
                }
            }
        }
    });
}

function initializeOfficeDistributionChart() {
    const ctx = document.getElementById('office-distribution-chart');
    if (!ctx) return;

    officeDistChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['1', '2', '3', '4', '5'],
            datasets: Object.entries(sqdMetrics).map(([key, label], index) => ({
                label: label,
                data: [0, 0, 0, 0, 0],
                backgroundColor: chartConfig.colors.office[index],
                borderColor: chartConfig.colors.office[index],
                borderWidth: 1
            }))
        },
        options: {
            ...chartConfig.chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Ratings'
                    }
                }
            }
        }
    });
}

function initializeOfficeTrendChart() {
    const ctx = document.getElementById('office-trend-chart');
    if (!ctx) return;

    officeTrendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Overall Rating',
                data: [],
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#2196F3',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value.toFixed(1);
                        }
                    },
                    title: {
                        display: true,
                        text: 'Average Rating'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Rating: ${context.raw.toFixed(2)}`;
                        }
                    }
                }
            }
        }
    });
}

function initializeOrgDistributionChart() {
    const ctx = document.getElementById('org-distribution-chart');
    if (!ctx) return;

    orgDistChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: Object.values(orgMetrics),
            datasets: [{
                label: 'Average Rating',
                data: [0, 0, 0, 0, 0, 0],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                pointBackgroundColor: 'rgb(54, 162, 235)',
                pointBorderColor: '#fff'
            }]
        },
        options: {
            ...chartConfig.chartDefaults,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function initializeOrgTrendChart() {
    const ctx = document.getElementById('org-trend-chart');
    if (!ctx) return;

    orgTrendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Average Rating',
                data: [],
                borderColor: '#4CAF50',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            ...chartConfig.chartDefaults,
            scales: {
                y: {
                    min: 0,
                    max: 5,
                    title: {
                        display: true,
                        text: 'Average Rating'
                    }
                }
            }
        }
    });
}

// Data refresh functions
function refreshData(type = 'office') {
    const timeFilter = document.getElementById('timeFilter')?.value || 'all';
    const orgFilter = document.getElementById('orgFilter')?.value || 'all';  
    
    // Add orgFilter parameter if it exists
    let url = `ajax/get_feedback_data.php?type=${type}&time=${timeFilter}`;
    if (type === 'org' && orgFilter) {
        url += `&org=${orgFilter}`;
    }
    url += `&_=${new Date().getTime()}`;  // Prevent caching
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (type === 'office') {
                // Update metrics
                updateOfficeData(data);
                
                // Update CC metrics with the correct data structure
                if (data.cc_metrics && data.cc_distribution) {
                    updateCCMetrics({
                        ...data.cc_metrics,
                        distribution: data.cc_distribution
                    });
                }
            } else {
                updateOrgData(data);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            showErrorMessage('Failed to load data. Please try again later.');
        });
}

// Function to refresh event evaluation data
function refreshEventEvalData() {
    const timeFilter = document.getElementById('evalTimeFilter')?.value || 'all';
    const orgFilter = document.getElementById('evalOrgFilter')?.value || 'all';
    
    updateLoadingState(true);
    
    fetch(`ajax/get_event_eval_data.php?time=${timeFilter}&org=${orgFilter}&_=${new Date().getTime()}`)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            console.log('Event evaluation data:', data);
            updateEventEvalMetrics(data);
            updateEventEvalCharts(data);
        })
        .catch(error => {
            console.error('Error fetching event evaluation data:', error);
            showErrorMessage('Failed to load event evaluation data');
        })
        .finally(() => {
            updateLoadingState(false);
        });
}

// Update functions
function updateOfficeData(data) {
    if (!data || !data.metrics) {
        console.error('Invalid office data format:', data);
        return;
    }

    console.log('Updating office metrics:', data.metrics);

    // Update SQD metrics
    Object.entries(sqdMetrics).forEach(([key, label]) => {
        const elementId = `sqd${key.split('_')[1]}_${key.split('_')[2]}`;
        const value = data.metrics[key];
        updateMetricValue(elementId, value);
    });

    // Update CC metrics
    if (data.cc_metrics) {
        updateCCMetrics(data.cc_metrics);
    }

    // Update charts
    if (data.distributions) {
        updateOfficeDistributionChart(data.distributions);
    }

    if (data.trend) {
        updateOfficeTrendChart(data.trend);
    }
}

function updateOfficeDistributionChart(distributions) {
    if (!officeDistChart) return;

    const metrics = [
        'sqd0_satisfaction',
        'sqd1_time',
        'sqd2_requirements',
        'sqd3_steps',
        'sqd4_information'
    ];

    officeDistChart.data.datasets = metrics.map((metric, index) => {
        const distribution = distributions[metric] || {};
        return {
            label: getMetricLabel(metric),
            data: [1, 2, 3, 4, 5].map(rating => distribution[rating] || 0),
            backgroundColor: chartConfig.colors.office[index],
            borderColor: chartConfig.colors.office[index],
            borderWidth: 1
        };
    });

    officeDistChart.update();
}

function updateOfficeTrendChart(trend) {
    if (!officeTrendChart) return;

    // Sort trend data by date in ascending order
    const sortedTrend = [...trend].sort((a, b) => new Date(a.date) - new Date(b.date));

    officeTrendChart.data.labels = sortedTrend.map(item => 
        new Date(item.date).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric'
        })
    );
    
    officeTrendChart.data.datasets[0].data = sortedTrend.map(item => 
        parseFloat(item.avg_rating) || 0
    );
    
    officeTrendChart.update();
}

function updateOrgData(data) {
    if (!data || !data.metrics) {
        console.error('Invalid organization data format:', data);
        return;
    }

    console.log('Updating organization data:', data);

    // Update metric cards
    const metricMappings = {
        'avg_event_quality': 'event-quality-rating',
        'avg_communication': 'org-communication-rating',
        'avg_inclusivity': 'inclusivity-rating',
        'avg_leadership': 'leadership-rating',
        'avg_skill_dev': 'skill-dev-rating',
        'avg_impact': 'impact-rating'
    };

    Object.entries(metricMappings).forEach(([dataKey, elementId]) => {
        const value = data.metrics[dataKey];
        if (typeof value !== 'undefined') {
            updateMetricValue(elementId, value);
        }
    });

    // Update distribution chart if data exists
    if (data.distributions) {
        updateOrgDistributionChart(data.distributions);
    } else {
        console.warn('No distribution data available for organization chart update');
    }
    
    // Update trend chart if data exists
    if (data.trend) {
        updateOrgTrendChart(data.trend);
    } else {
        console.warn('No trend data available for organization chart update');
    }
}

function updateOrgDistributionChart(distributions) {
    if (!orgDistChart) {
        console.warn('Organization distribution chart not initialized');
        return;
    }

    // Get all rating fields
    const ratingFields = [
        'event_quality_rating',
        'communication_rating',
        'inclusivity_rating',
        'leadership_rating',
        'skill_dev_rating',
        'impact_rating'
    ];

    // Calculate averages for each metric
    const averages = ratingFields.map(field => {
        const distribution = distributions[field] || {};
        let sum = 0;
        let count = 0;
        
        // Calculate weighted average
        Object.entries(distribution).forEach(([rating, frequency]) => {
            sum += parseFloat(rating) * frequency;
            count += frequency;
        });
        
        return count > 0 ? sum / count : 0;
    });

    // Update chart data
    orgDistChart.data.datasets[0].data = averages;
    orgDistChart.update();
}

function updateOrgTrendChart(trend) {
    if (!orgTrendChart) {
        console.warn('Organization trend chart not initialized');
        return;
    }

    // Sort trend data by date in ascending order
    const sortedTrend = [...trend].sort((a, b) => new Date(a.date) - new Date(b.date));

    // Format dates and extract ratings
    orgTrendChart.data.labels = sortedTrend.map(item => 
        new Date(item.date).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric'
        })
    );
    
    orgTrendChart.data.datasets[0].data = sortedTrend.map(item => 
        parseFloat(item.avg_rating) || 0
    );

    orgTrendChart.update();
}

function updateCCMetrics(metrics) {
    // Update the metric values in the cards
    ['cc_awareness', 'cc_visibility', 'cc_helpfulness'].forEach(key => {
        const element = document.getElementById(key);
        if (element) {
            element.textContent = (metrics[key] || 0).toFixed(1);
        }
    });

    // Update the chart if it exists and we have distribution data
    if (ccMetricsChart && metrics.distribution) {
        ccMetricsChart.data.datasets[0].data = [
            metrics.distribution.awareness.positive,
            metrics.distribution.visibility.positive,
            metrics.distribution.helpfulness.positive
        ];
        ccMetricsChart.data.datasets[1].data = [
            metrics.distribution.awareness.neutral,
            metrics.distribution.visibility.neutral,
            metrics.distribution.helpfulness.neutral
        ];
        ccMetricsChart.data.datasets[2].data = [
            metrics.distribution.awareness.negative,
            metrics.distribution.visibility.negative,
            metrics.distribution.helpfulness.negative
        ];
        
        ccMetricsChart.update();
    }
}

function updateEventEvalMetrics(data) {
    if (!data || !data.metrics) return;

    const metricsMapping = {
        'participant-rating': data.metrics.participant_rating,
        'video-quality-rating': data.metrics.video_quality,
        'audio-quality-rating': data.metrics.audio_quality,
        'overall-impact-rating': data.metrics.overall_impact
    };

    Object.entries(metricsMapping).forEach(([elementId, value]) => {
        updateMetricValue(elementId, value);
    });
}

function updateEventEvalCharts(data) {
    console.log('Updating charts with data:', data);
    
    // Performance metrics chart update
    if (perfMetricsChart && data.performance_metrics) {
        console.log('Updating performance metrics chart with:', data.performance_metrics);
        
        const perfData = [
            data.performance_metrics.content_quality || 0,
            data.performance_metrics.engagement || 0,
            data.performance_metrics.time_management || 0,
            data.performance_metrics.activity_relevance || 0
        ];
        
        console.log('Performance data array:', perfData);
        
        perfMetricsChart.data.datasets[0].data = perfData;
        perfMetricsChart.update();
    }
    
    if (methodologyChart && data.methodology_metrics) {
        methodologyChart.data.datasets[0].data = [
            data.methodology_metrics.clarity || 0,
            data.methodology_metrics.engagement || 0,
            data.methodology_metrics.interactivity || 0,
            data.methodology_metrics.resources || 0,
            data.methodology_metrics.time_management || 0
        ];
        methodologyChart.update();
    }
}

// Utility functions
function getMetricLabel(metric) {
    const labels = {
        'sqd0_satisfaction': 'Overall Satisfaction',
        'sqd1_time': 'Processing Time',
        'sqd2_requirements': 'Requirements',
        'sqd3_steps': 'Process Steps',
        'sqd4_information': 'Information'
    };
    return labels[metric] || metric;
}

function updateMetricValue(elementId, value) {
    const element = document.getElementById(elementId);
    if (!element) return;

    const numValue = parseFloat(value);
    element.textContent = isNaN(numValue) ? '0.0' : numValue.toFixed(1);
    
    // Add update animation
    element.classList.remove('metric-update');
    void element.offsetWidth; // Trigger reflow
    element.classList.add('metric-update');
}

function showErrorMessage(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4';
    errorDiv.textContent = message;
    
    const container = document.querySelector('.dashboard-container') || document.querySelector('.container');
    if (container) {
        const existingError = container.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        container.prepend(errorDiv);
        setTimeout(() => errorDiv.remove(), 5000);
    }
}

function updateLoadingState(isLoading) {
    const loadingIndicator = document.getElementById('eval-loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = isLoading ? 'flex' : 'none';
    }

    ['evalTimeFilter', 'evalOrgFilter'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.disabled = isLoading;
        }
    });
}

// Tab system
function initializeTabSystem() {
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.dataset.tab;
            switchDashboardTab(tabId);
        });
    });

    // Show default tab
    const defaultTab = document.querySelector('.tab-button[data-default="true"]');
    if (defaultTab) {
        switchDashboardTab(defaultTab.dataset.tab);
    } else if (tabButtons.length > 0) {
        switchDashboardTab(tabButtons[0].dataset.tab);
    }
}

function switchDashboardTab(tabId) {
    // Hide all tabs
    document.querySelectorAll('.dashboard-tab').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Show selected tab
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.style.display = 'block';
    }

    // Update button states
    document.querySelectorAll('.tab-button').forEach(button => {
        if (button.dataset.tab === tabId) {
            button.classList.add('active', 'bg-blue-500', 'text-white');
            button.classList.remove('bg-gray-200', 'text-gray-700');
        } else {
            button.classList.remove('active', 'bg-blue-500', 'text-white');
            button.classList.add('bg-gray-200', 'text-gray-700');
        }
    });

    // Initialize charts for event evaluations tab
    if (tabId === 'event-evaluations-dashboard') {
        setTimeout(() => {
            initializeEventEvalCharts();
            refreshEventEvalData();
        }, 100);
    }
}

// Event Evaluations
function initializeEventEvalCharts() {
    initializePerfMetricsChart();
    initializeMethodologyChart();
}

function initializePerfMetricsChart() {
    const ctx = document.getElementById('perf-metrics-chart');
    if (!ctx) return;

    perfMetricsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Content Quality', 'Engagement', 'Technical Quality', 'Overall Impact'],
            datasets: [{
                label: 'Rating',
                data: [0, 0, 0, 0],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        },
        options: {
            ...chartConfig.chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function initializeMethodologyChart() {
    const ctx = document.getElementById('methodology-chart');
    if (!ctx) return;

    methodologyChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Clarity', 'Engagement', 'Interactivity', 'Resources', 'Time Management'],
            datasets: [{
                label: 'Methodology Ratings',
                data: [0, 0, 0, 0, 0],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 0.8)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff'
            }]
        },
        options: {
            ...chartConfig.chartDefaults,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}
</script>
</body>

</html>
