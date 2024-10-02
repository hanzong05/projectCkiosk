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
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link href="assets/css/css.css" rel="stylesheet" />
</head>

<body class="">
    <div class="sidebar" data-color="white" data-active-color="danger">
  <div class="logo">
    <a href="dashboard.php" class="simple-text logo-normal">
      <img src="../img/C.png" alt="" width="240">
    </a>
  </div>
  <div class="sidebar-wrapper ">
    <ul class="nav">
      <li class="active">
        <a href="./dashboard.php">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li>
        <a href="./announcement.php">
          <i class="nc-icon nc-diamond"></i>
          <p>Announcement</p>
        </a>
      </li>
      <li>
          <a href="./schoolcalendar.php">
            <i class="nc-icon nc-pin-3"></i>
            <p>School Calendar</p>
          </a>
        </li>
      <?php if ($account_type == '1') { ?>
       
        <li >
          <a href="./facultymembers.php">
            <i class="nc-icon nc-bell-55"></i>
            <p>Faculty Members</p>
          </a>
        </li>
        <li>
          <a href="./map.php">
            <i class="nc-icon nc-single-02"></i>
            <p>Campus Map</p>
          </a>
        </li>
        <li>
          <a href="./organization.php">
            <i class="nc-icon nc-caps-small"></i>
            <p>Campus Organization</p>
          </a>
        </li>
      <?php } ?>
      <?php if ($account_type == '2') { ?>
        <li>
          <a href="./membersmanagement.php">
            <i class="nc-icon nc-pin-3"></i>
            <p>Member Management</p>
          </a>
        </li>
      <?php } ?>
      <?php if ($account_type == '3') { ?>
        <li>
        <a href="./memberprofile.php">
            <i class="nc-icon nc-pin-3"></i>
            <p>Acount Management</p>
          </a>
        </li>
      <?php } ?>
      <li>
        <a href="./faqs.php">
          <i class="nc-icon nc-tile-56"></i>
          <p>FAQS</p>
        </a>
      </li>
    </ul>
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
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i>
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
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
  <script>
    $(document).ready(function () {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
</body>

</html>