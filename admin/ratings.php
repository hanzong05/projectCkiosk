<?php
include_once ('assets/header.php');

if (isset($_POST['add_announcement'])) {
  $log_msg = $obj->add_announcement($_POST);
}

if (isset($_POST['save_announcement'])) {
  $log_msg = $obj->save_announcement($_POST);
}
if (isset($_REQUEST['archive_id'])) {
  $log_msg = $obj->archive_announcement($_REQUEST['archive_id']);
}

$allratings = $obj->show_ratings();


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
  <!-- CSS Files -->  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="assets/css/css.css" rel="stylesheet" />
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
</head>

<body class="">
  <div class="wrapper ">
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
      <li >
        <a href="./dashboard.php">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li >
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
        </li>'
        <li>
                                <a href="./audit.php" >
                                    <i class="nc-icon nc-caps-small"></i>
                                    <p>Audit Trails</p>
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
    <?php } ?>
    <?php if ($account_type == '0') { ?>
      <ul class="nav">
      <li>
        <a href="./dashboard.php">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
        
      <li class="active">
        <a href="./ratings.php">
          <i class="nc-icon nc-tile-56"></i>
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
            <a class="navbar-brand" href="javascript:;">Campus Announcement </a>
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
      <div class="content"><div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
                <div class="overflow-x-auto">
                    <!-- Wrapper for max height and responsive width -->
                    <div class="max-h-96 overflow-auto">
                        <table class="min-w-full max-w-full lg:max-w-screen-lg divide-y divide-gray-200"> <!-- Max width for larger screens -->
                            <!-- Table Header -->
                            <thead class="bg-gradient-to-r from-orange-100 to-amber-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        No.
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        Details
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        Name
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        Email
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        College
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        Year
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">
                                        Rating
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table Body -->
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $count = 1; foreach ($allratings as $row): ?>
                                <tr class="hover:bg-orange-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        <?php echo $count; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-800 max-w-md">
                                        <div class="truncate">
                                            <?php echo $row["feedback_text"]; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                                        <?php echo $row["name"] ?? '<span class="text-gray-500">Anonymous</span>'; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                                        <?php echo $row["email"] ?? '<span class="text-gray-500">N/A</span>'; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                                        <?php echo $row["college"] ?? '<span class="text-gray-500">N/A</span>'; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                                        <?php 
                                        if (isset($row["year"])) {
                                            $yearText = match ((int)$row["year"]) {
                                                1 => '<span class="px-2 py-1 text-green-700 bg-green-100 rounded-full">1st year</span>',
                                                2 => '<span class="px-2 py-1 text-blue-700 bg-blue-100 rounded-full">2nd year</span>',
                                                3 => '<span class="px-2 py-1 text-purple-700 bg-purple-100 rounded-full">3rd year</span>',
                                                4 => '<span class="px-2 py-1 text-red-700 bg-red-100 rounded-full">4th year</span>',
                                                default => '<span class="px-2 py-1 text-gray-700 bg-gray-100 rounded-full">' . $row["year"] . '</span>'
                                            };
                                            echo $yearText;
                                        } else {
                                            echo '<span class="text-gray-500">N/A</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <?php 
                                        $rating = $row["rating"] ?? 'No rating';
                                        $ratingClass = match(true) {
                                            $rating >= 4 => 'text-green-700 bg-green-100',
                                            $rating >= 3 => 'text-blue-700 bg-blue-100',
                                            $rating >= 2 => 'text-yellow-700 bg-yellow-100',
                                            $rating >= 1 => 'text-red-700 bg-red-100',
                                            default => 'text-gray-700 bg-gray-100'
                                        };
                                        ?>
                                        <span class="px-2 py-1 rounded-full text-sm font-medium <?php echo $ratingClass; ?>">
                                            <?php echo $rating; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php $count++; endforeach; ?>
                            </tbody>
                        </table>
                    </div> <!-- End of wrapper for max height and scrollbar -->
                </div>
            </div>
        </div>
    </div>
</div>

      </div>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  
</body>

</html>