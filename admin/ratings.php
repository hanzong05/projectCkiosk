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
                  feedback_id,
                  efficiency_rating,
                  communication_rating,
                  professionalism_rating,
                  accessibility_rating,
                  resolution_rating,
                  improvements,
                  email,
                  name,
                  created_at,
                  DATE_FORMAT(created_at, '%M %d, %Y %h:%i %p') as formatted_date
              FROM office_feedback 
              ORDER BY created_at DESC";
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
  <title>
    Campus Kiosk Admin
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- CSS Files -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
<link href="assets/css/css.css" rel="stylesheet" />

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

<!-- Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<!-- Meta Tags -->
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .ellipsis {
      position: relative;
      overflow-x: auto; /* Enables horizontal scrolling */
      white-space: nowrap; /* Prevents text from wrapping */
    }
    .ellipsis:before {
      content: " ";
      visibility: hidden;
    }

    .ellipsis span {
      position: absolute;
      left: 0;
      right: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #800020 0%, #4A0011 100%);
        }
        
        .custom-shadow {
            box-shadow: 0 4px 15px rgba(128, 0, 32, 0.15);
        }
        
        .rating-pill {
            background: rgba(128, 0, 32, 0.05);
            backdrop-filter: blur(10px);
        }
        
        .feedback-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(128, 0, 32, 0.1);
        }
        
        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(128, 0, 32, 0.2);
        }
        
        .star-rating {
            transition: all 0.2s ease;
        }
        
        .star-rating:hover {
            transform: scale(1.1);
        }
        
        .star-rating .fas.fa-star {
            color: #800020; /* Burgundy stars for filled */
        }
        
        .star-rating .far.fa-star {
            color: rgba(128, 0, 32, 0.3); /* Light burgundy for empty stars */
        }
        
        /* Filter section styling */
        #searchInput,
        #dateFilter,
        #orgFilter {
            border-color: rgba(128, 0, 32, 0.2);
        }
        
        #searchInput:focus,
        #dateFilter:focus,
        #orgFilter:focus {
            border-color: #800020;
            box-shadow: 0 0 0 3px rgba(128, 0, 32, 0.1);
        }
        
        /* Rating pills styling */
        .rating-pill {
            border-left: 3px solid #800020;
        }
        
        /* Improvements section styling */
        .bg-gray-50 {
            background-color: rgba(128, 0, 32, 0.03);
        }
        
        /* Text colors */
        .text-gray-700 {
            color: #4A0011;
        }
        
        .text-gray-600 {
            color: rgba(74, 0, 17, 0.8);
        }
        
        .text-gray-400 {
            color: rgba(74, 0, 17, 0.6);
        }
        
        /* Animation keyframes remain the same */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="">
   <div class="wrapper ">
     <?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
      <div class="content">
        <!-- Header Section -->
        <div class="gradient-bg rounded-xl p-6 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">
                <?php echo $feedback_type == 'office' ? 'Office Feedback Dashboard' : 'Organization Feedback Dashboard'; ?>
            </h1>
            <p class="text-gray-200">Review and analyze feedback from your <?php echo $feedback_type; ?></p>
        </div>

        <?php if ($account_type == '0'): ?>
            <div class="bg-white rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold mb-4">Client Satisfaction Measurement (CSM) Summary Report</h2>
                <h3 class="text-lg mb-2">From the period of <?php echo date('F Y', strtotime($start_date)); ?> 
                    to <?php echo date('F Y', strtotime($end_date)); ?></h3>

                <!-- CC Questions Table -->
                <table class="w-full mb-6 border-collapse border border-gray-300">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border p-2 text-left">Citizen's Charter (CC) Question</th>
                            <th class="border p-2">Responses</th>
                            <th class="border p-2">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CC Awareness -->
                        <tr class="bg-blue-50">
                            <td class="border p-2" colspan="3">
                                <strong>CC1.</strong> Which of the following best describes your awareness of a CC?
                            </td>
                        </tr>
                        <?php foreach($cc_awareness as $awareness): ?>
                        <tr>
                            <td class="border p-2 pl-8"><?php echo htmlspecialchars($awareness['cc_awareness']); ?></td>
                            <td class="border p-2 text-center"><?php echo $awareness['response_count']; ?></td>
                            <td class="border p-2 text-center"><?php echo number_format($awareness['percentage'], 2); ?>%</td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- CC Visibility -->
                        <tr class="bg-blue-50">
                            <td class="border p-2" colspan="3">
                                <strong>CC2.</strong> If aware of CC, would you say that the CC of this office was:
                            </td>
                        </tr>
                        <?php foreach($cc_visibility as $visibility): ?>
                        <tr>
                            <td class="border p-2 pl-8"><?php echo htmlspecialchars($visibility['cc_visibility']); ?></td>
                            <td class="border p-2 text-center"><?php echo $visibility['response_count']; ?></td>
                            <td class="border p-2 text-center"><?php echo number_format($visibility['percentage'], 2); ?>%</td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- CC Helpfulness -->
                        <tr class="bg-blue-50">
                            <td class="border p-2" colspan="3">
                                <strong>CC3.</strong> If aware of CC, How much did the CC help you in your transaction?
                            </td>
                        </tr>
                        <?php foreach($cc_helpfulness as $helpful): ?>
                        <tr>
                            <td class="border p-2 pl-8"><?php echo htmlspecialchars($helpful['cc_helpfulness']); ?></td>
                            <td class="border p-2 text-center"><?php echo $helpful['response_count']; ?></td>
                            <td class="border p-2 text-center"><?php echo number_format($helpful['percentage'], 2); ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- SQD Table -->
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border p-2" rowspan="2">Service Quality Dimensions (SQD)</th>
                            <th class="border p-2">Rating</th>
                            <th class="border p-2">Total Responses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-2">I am satisfied with the service that I availed.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['satisfaction'], 2); ?>%</td>
                            <td class="border p-2 text-center" rowspan="9"><?php echo $sqd_stats['total_responses']; ?></td>
                        </tr>
                        <tr>
                            <td class="border p-2">I spent a reasonable amount of time for my transaction.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['time_rating'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">The office followed the transaction's requirements and steps based on the information provided.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['requirements'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">The steps (including payment) I needed to do for my transaction were easy and simple.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['steps'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">I easily found information about my transaction from the office or its website.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['information'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">I paid a correct amount of fees for my transaction.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['value'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">I feel the office was fair to everyone.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['security'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">I was treated courteously by the staff.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['support'], 2); ?>%</td>
                        </tr>
                        <tr>
                            <td class="border p-2">I got what I needed from the government office.</td>
                            <td class="border p-2 text-center"><?php echo number_format($sqd_stats['outcome'], 2); ?>%</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Overall Rating -->
                <?php 
                $overall_rating = array_sum([
                    $sqd_stats['satisfaction'],
                    $sqd_stats['time_rating'],
                    $sqd_stats['requirements'],
                    $sqd_stats['steps'],
                    $sqd_stats['information'],
                    $sqd_stats['value'],
                    $sqd_stats['security'],
                    $sqd_stats['support'],
                    $sqd_stats['outcome']
                ]) / 9;
                ?>
                <div class="mt-4 p-4 bg-blue-100 text-center">
                    <h3 class="text-xl font-bold">Overall Rating: <?php echo number_format($overall_rating, 2); ?>%</h3>
                    <p class="text-lg">
                        <?php
                        if ($overall_rating >= 95) echo "Excellent";
                        else if ($overall_rating >= 90) echo "Very Satisfactory";
                        else if ($overall_rating >= 85) echo "Satisfactory";
                        else if ($overall_rating >= 80) echo "Fair";
                        else echo "Poor";
                        ?>
                    </p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Filters and Stats Section -->
            <div class="bg-white rounded-xl custom-shadow p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Search Box -->
                    <div class="relative">
                        <input type="text" id="searchInput" 
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all" 
                               placeholder="Search feedback...">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>

                    <!-- Date Filter -->
                    <div class="relative">
                        <select id="dateFilter" 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all appearance-none">
                            <option value="all">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                        <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>

                    <!-- Organization Filter (for account type 4) -->
                    <?php if ($feedback_type == 'organization' && $account_type == '4'): ?>
                    <div class="relative">
                        <select id="orgFilter" 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all appearance-none">
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
                        <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <?php endif; ?>
              
            </div>
        </div>

        <!-- Feedback Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($feedbacks as $index => $feedback): ?>
            <div class="feedback-card bg-white rounded-xl custom-shadow overflow-hidden animate-fade-in" 
                 style="animation-delay: <?php echo $index * 0.1; ?>s">
                <!-- Card Header -->
                <div class="gradient-bg p-4 text-white">
                    <?php if ($feedback_type == 'organization' && isset($feedback['org_name'])): ?>
                    <h3 class="font-semibold mb-2"><?php echo htmlspecialchars($feedback['org_name']); ?></h3>
                    <?php endif; ?>
                    <div class="flex justify-between items-center text-sm">
                        <span><?php echo htmlspecialchars($feedback['name'] ?? 'Anonymous'); ?></span>
                        <span><?php echo $feedback['formatted_date']; ?></span>
                    </div>
                </div>

                <!-- Ratings Section -->
                <div class="p-4">
                    <?php if ($feedback_type == 'office'): ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php
                        $ratings = [
                            'Efficiency' => 'efficiency_rating',
                            'Communication' => 'communication_rating',
                            'Professionalism' => 'professionalism_rating',
                            'Accessibility' => 'accessibility_rating',
                            'Resolution' => 'resolution_rating'
                        ];
                        foreach ($ratings as $label => $key):
                        ?>
                        <div class="rating-pill rounded-lg p-3 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700"><?php echo $label; ?></span>
                                <div class="flex star-rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?php echo $i <= $feedback[$key] ? 'fas' : 'far'; ?> fa-star text-yellow-400 mx-0.5"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php
                        $ratings = [
                            'Event Quality' => 'event_quality_rating',
                            'Communication' => 'communication_rating',
                            'Inclusivity' => 'inclusivity_rating',
                            'Leadership' => 'leadership_rating',
                            'Skill Development' => 'skill_dev_rating',
                            'Impact' => 'impact_rating'
                        ];
                        foreach ($ratings as $label => $key):
                        ?>
                        <div class="rating-pill rounded-lg p-3 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700"><?php echo $label; ?></span>
                                <div class="flex star-rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?php echo $i <= $feedback[$key] ? 'fas' : 'far'; ?> fa-star text-yellow-400 mx-0.5"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($feedback['improvements']) && !empty($feedback['improvements'])): ?>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Suggestions for Improvement</h4>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($feedback['improvements']); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
    
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const dateFilter = document.getElementById('dateFilter');
        const orgFilter = document.getElementById('orgFilter');
        const feedbackCards = document.querySelectorAll('.feedback-card');

        function filterFeedback() {
            const searchTerm = searchInput.value.toLowerCase();
            const dateValue = dateFilter.value;
            const orgValue = orgFilter ? orgFilter.value : 'all';

            feedbackCards.forEach(card => {
                let showCard = true;

                // Text search
                const cardText = card.textContent.toLowerCase();
                if (!cardText.includes(searchTerm)) {
                    showCard = false;
                }

                // Date filter
                const dateText = card.querySelector('.text-sm:last-child').textContent;
                const feedbackDate = new Date(dateText);
                const today = new Date();

                if (dateValue !== 'all') {
                    if (dateValue === 'today' && !isSameDay(feedbackDate, today)) {
                        showCard = false;
                    } else if (dateValue === 'week' && !isThisWeek(feedbackDate)) {
                        showCard = false;
                    } else if (dateValue === 'month' && !isThisMonth(feedbackDate)) {
                        showCard = false;
                    }
                }

                // Organization filter
                if (orgFilter && orgValue !== 'all') {
                    const orgName = card.querySelector('.font-semibold')?.textContent;
                    const orgOption = orgFilter.querySelector(`option[value="${orgValue}"]`);
                    if (!orgOption || orgName !== orgOption.textContent) {
                        showCard = false;
                    }
                }

                // Apply animation when showing cards
                if (showCard) {
                    card.style.display = 'block';
                    card.classList.add('animate-fade-in');
                } else {
                    card.style.display = 'none';
                    card.classList.remove('animate-fade-in');
                }
            });
        }

        // Helper functions for date filtering
        function isSameDay(date1, date2) {
            return date1.getDate() === date2.getDate() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getFullYear() === date2.getFullYear();
        }

        function isThisWeek(date) {
            const today = new Date();
            const weekStart = new Date(today);
            weekStart.setDate(today.getDate() - today.getDay());
            const weekEnd = new Date(weekStart);
            weekEnd.setDate(weekStart.getDate() + 6);
            return date >= weekStart && date <= weekEnd;
        }

        function isThisMonth(date) {
            const today = new Date();
            return date.getMonth() === today.getMonth() &&
                   date.getFullYear() === today.getFullYear();
        }

        // Add event listeners for real-time filtering
        searchInput.addEventListener('input', filterFeedback);
        dateFilter.addEventListener('change', filterFeedback);
        if (orgFilter) {
            orgFilter.addEventListener('change', filterFeedback);
        }

        // Initialize filtering
        filterFeedback();
    });
    </script>

    <!-- Core Scripts -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
</body>

</html>