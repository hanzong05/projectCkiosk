<?php
include_once('assets/header.php');
include_once('ajax/remove.php');
include_once('../class/connection.php');


try {
    // Query for organization count
    $sql_organization = "SELECT COUNT(*) as count FROM organization_tbl";
    $stmt_organization = $connect->prepare($sql_organization);
    $stmt_organization->execute();
    $result_organization = $stmt_organization->fetch(PDO::FETCH_ASSOC);
    $organization_count = $result_organization['count'];

    // Query for members count
    $sql_members = "SELECT COUNT(*) as count FROM faculty_tbl";
    $stmt_members = $connect->prepare($sql_members);
    $stmt_members->execute();
    $result_members = $stmt_members->fetch(PDO::FETCH_ASSOC);
    $members_count = $result_members['count'];

    // Query for announcements count
    $sql_announcements = "SELECT COUNT(*) as count FROM announcement_tbl";
    $stmt_announcements = $connect->prepare($sql_announcements);
    $stmt_announcements->execute();
    $result_announcements = $stmt_announcements->fetch(PDO::FETCH_ASSOC);
    $announcements_count = $result_announcements['count'];

    // Query for events count
    $sql_events = "SELECT COUNT(*) as count FROM calendar_tbl";
    $stmt_events = $connect->prepare($sql_events);
    $stmt_events->execute();
    $result_events = $stmt_events->fetch(PDO::FETCH_ASSOC);
    $events_count = $result_events['count'];

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
            color: white;
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
    </style>
</head>

<body class=""><div class="wrapper ">
    <!-- sweetalert start-->
    <?= isset($log_msg) ? $log_msg : '' ?>
    <!-- sweetalert end -->
    <div class="sidebar" data-color="white" data-active-color="danger">
        <div class="logo">
            <a href="dashboard.php" class="simple-text logo-normal">
                <img src="../img/C.png" alt="" width="240">
            </a>
        </div>
        <div class="sidebar-wrapper ">
            <?php if ($account_type != '0') { ?>
                <ul class="nav">
                    <li class="active">
                        <a href="./dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="./announcement.php">
                            <i class="fas fa-bullhorn"></i>
                            <p>Announcement</p>
                        </a>
                    </li>
                    <li >
                        <a href="./schoolcalendar.php">
                            <i class="fas fa-calendar-alt"></i>
                            <p>School Calendar</p>
                        </a>
                    </li>
                    <?php if ($account_type == '1') { ?>
                        <li>
                            <a href="./facultymembers.php">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>Faculty Members</p>
                            </a>
                        </li>
                        <li>
                            <a href="./map.php">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Campus Map</p>
                            </a>
                        </li>
                        <li>
                            <a href="./organization.php">
                                <i class="fas fa-users"></i>
                                <p>Campus Organization</p>
                            </a>
                        </li>
                        <li>
                            <a href="./audit.php">
                                <i class="fas fa-file-alt"></i>
                                <p>Audit Trails</p>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="./faqs.php">
                            <i class="fas fa-question-circle"></i>
                            <p>FAQS</p>
                        </a>
                    </li>
                </ul>
            <?php } ?>
            <?php if ($account_type == '0') { ?>
                <ul class="nav">
                    <li>
                        <a href="./dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="./ratings.php">
                            <i class="fas fa-star"></i>
                            <p>Ratings</p>
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>

    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Campus Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block"></span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="logout.php">Logout</a>
                  <?php if ($account_type == '2') { ?>
                    <a class="dropdown-item" href="./membersmanagement.php">Profile</a>
                <?php } ?>
                <?php if ($account_type == '3') { ?>
                    <a class="dropdown-item" href="./memberprofile.php">Profile</a>
                <?php } ?>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
      <div class="row">
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
        </div>

        <?php if ($account_type == '0') { ?>
        
           
        
            <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card chart-card">
                <div class="card-header">
                    <h4 class="card-title">Pie Chart</h4>
                </div>
                <div class="card-body">
                    <div class="chart-loading"></div>
                    <canvas id="pieChart"></canvas>
                    <ul id="pieChartLegend"></ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-12">
            <div class="card chart-card">
                <div class="card-header">
                    <h4 class="card-title">Number Of Ratings</h4>
                </div>
                <div class="card-body">
                    <div class="chart-loading"></div>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card chart-card">
                <div class="card-header">
                    <h4 class="card-title">Total Number Of ratings per Month</h4>
                </div>
                <div class="card-body">
                    <div class="chart-loading"></div>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="credits chart-card">
                    <span class="copyright">
                        © <script>document.write(new Date().getFullYear())</script>, 
                        made with <i class="heart">❤</i>
                    </span>
                </div>
            </div>
        </div>
    </footer>
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
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>


  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  <script src="assets/demo/demo.js"></script>
  <script> var aid = <?php echo json_encode($aid); ?>; // Use json_encode to safely handle the value
    console.log("The value of aid is:", aid);</script>
  <script>
    $(document).ready(function () {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
    $(document).ready(function () {
    function fetchChartData() {
        fetch('ajax/line-chart.php')  // AJAX request to get the data
            .then(response => response.json())
            .then(result => {
                // Ensure we have data
                if (result.labels && result.data) {
                    // Parse the JSON strings into arrays
                    const labels = JSON.parse(result.labels);
                    const data = JSON.parse(result.data);
                    
                    // Call function to update chart
                    updateChart(labels, data);
                }
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
            });
    }

    // Function to update the chart with fetched data
    function updateChart(labels, data) {
        var ctx = document.getElementById('lineChart').getContext('2d');

        // Clear existing chart if it exists
        if (window.lineChart instanceof Chart) {
            window.lineChart.destroy();
        }

        // Create a new chart
        window.lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,  // Dynamic labels ['2024-10']
                datasets: [{
                    label: 'Total Ratings per Month',
                    data: data,    // Dynamic data [2]
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Ratings'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Fetch chart data on page load
    fetchChartData();
});

    $(document).ready(function () {
     
 // Fetch data from the backend
function fetchRatingData() {
    fetch('ajax/bar-graph.php')
        .then(response => response.json())
        .then(ratingsCount => {
            // Create the bar chart using the fetched data
            createBarChart(ratingsCount);
        })
        .catch(error => {
            console.error('Error fetching ratings data:', error);
        });
}

// Create Bar Chart
function createBarChart(ratingsCount) {
    var ctxBar = document.getElementById("barChart").getContext("2d");
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
          labels: ['😠', '😞', '😐', '😊', '😍'],
            datasets: [{
                label: 'Member Ratings',
                data: [
                    ratingsCount[1] || 0, 
                    ratingsCount[2] || 0, 
                    ratingsCount[3] || 0, 
                    ratingsCount[4] || 0, 
                    ratingsCount[5] || 0
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const starRating = tooltipItem.label; // e.g., '1 Star'
                            const emoji = getEmoji(parseInt(starRating)); // Get the emoji for that rating
                            return emoji + ' ' + tooltipItem.raw; // Show emoji with count
                        }
                    }
                }
            }
        }
    });
}

// Get the emoji for a rating
function getEmoji(rating) {
    switch (rating) {
        case 1: return '😠';
        case 2: return '😞';
        case 3: return '😐';
        case 4: return '😊';
        case 5: return '😍';
        default: return '';
    }
}

// Call the function to fetch data and create the chart
fetchRatingData();

// Fetch average ratings and create Pie Chart
function fetchAverageRatings() {
    fetch('ajax/pie-chart.php') // Adjust the path to your PHP file
        .then(response => response.json())
        .then(data => {
            const counts = data.counts;
            const averages = data.averages;

            // Labels for the pie chart
            const labels = ['😠 1 Star', '😞 2 Stars', '😐 3 Stars', '😊 4 Stars', '😍 5 Stars'];

            // Create the pie chart with average ratings
            createPieChart(labels, averages);
        })
        .catch(error => {
            console.error('Error fetching average ratings:', error);
        });
}
// Function to create the Pie Chart
function createPieChart(labels, averages) {
    var ctxPie = document.getElementById("pieChart").getContext("2d");
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labels, // Emoji labels for ratings
            datasets: [{
                data: Object.values(averages), // Average of each rating
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40']
            }]
        },
        options: {
            responsive: true,
           
            plugins: {
                legend: {
                    display: false // Completely disable the default legend
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const index = tooltipItem.dataIndex;
                            return labels[index]; // Use custom labels for tooltips
                        }
                    }
                }
            }
        }
    });

    // Custom Legend Creation
    
}

// Call the function to fetch data and create the chart
fetchAverageRatings();

});

  </script>
</body>

</html>