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
    // Determine feedback type and fetch data
    if ($account_type == '0') {
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
        /* Scoped styles for the feedback table section */
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
        
        .feedback-content-wrapper .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #66615B;
            color: white !important;
            border-color: #66615B;
        }

        .feedback-content-wrapper table.dataTable thead th {
            padding: 12px 8px;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .feedback-content-wrapper table.dataTable tbody td {
            padding: 12px 8px;
            border-bottom: 1px solid #dee2e6;
        }

        .feedback-content-wrapper table.dataTable tbody tr:hover {
            background-color: #f8f9fa;
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
                <!-- Main Content -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <?php echo $feedback_type == 'office' ? 'Office Feedback Dashboard' : 'Organization Feedback Dashboard'; ?>
                        </h4>
                    </div>

                    <div class="card-body feedback-content-wrapper">
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

    // Custom date filtering function
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        const dateValue = $('#dateFilter').val();
        if (dateValue === 'all') return true;

        // Parse the date string (format: Month DD, YYYY HH:MM AM/PM)
        const dateStr = data[1]; // Date column index
        const feedbackDate = new Date(dateStr);
        const today = new Date();

        // Handle different filter options
        switch(dateValue) {
            case 'today': {
                const todayStart = new Date(today.setHours(0, 0, 0, 0));
                const todayEnd = new Date(today.setHours(23, 59, 59, 999));
                return feedbackDate >= todayStart && feedbackDate <= todayEnd;
            }
            
            case 'week': {
                // Get start of current week (Sunday)
                const curr = new Date();
                const first = curr.getDate() - curr.getDay();
                const weekStart = new Date(curr.setDate(first));
                weekStart.setHours(0, 0, 0, 0);
                
                // Get end of current week (Saturday)
                const last = first + 6;
                const weekEnd = new Date(curr.setDate(last));
                weekEnd.setHours(23, 59, 59, 999);

                // Debug logging
                console.log('Filtering date:', dateStr);
                console.log('Week start:', weekStart.toLocaleString());
                console.log('Week end:', weekEnd.toLocaleString());
                
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

    // Organization filter handler (if exists)
    $('#orgFilter').on('change', function() {
        const val = $(this).val();
        if (val === 'all') {
            table.column(0).search('').draw();
        } else {
            table.column(0).search($(this).val()).draw();
        }
    });
});
</script>
</body>
</html>