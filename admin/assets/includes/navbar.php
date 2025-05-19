<?php
// Check if user is logged in
if (!isset($_SESSION['aid'])) {
    header('Location: login.php');
    exit();
}

// Get user type for conditional rendering
$userType = $_SESSION['atype'] ?? null;

// Get current page name for active tab
$current_page = basename($_SERVER['PHP_SELF']);
?>

<?= isset($log_msg) ? $log_msg : '' ?>
    <div class="sidebar" data-color="white" data-active-color="danger">
        <div class="logo">
            <a href="dashboard.php" class="simple-text logo-normal">
                <img src="../img/C.png" alt="" width="240">
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <!-- Dashboard shown to all users -->
                <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                    <a href="./dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Feedback Menu - Visible to account types 0, 2, 3, 4 -->
                <?php if (in_array($account_type, ['0', '2', '3', '4'])) { ?>
                    <li class="<?= ($current_page == 'feedback_details.php' || $current_page == 'feedback_details.php') ? 'active' : '' ?>">
                        <a href="feedback_details.php">
                            <i class="fas fa-comments"></i>
                            <p>Feedback</p>
                        </a>
                    </li>
                <?php } ?>
                
                <?php if ($account_type != '0' && $account_type != '4') { ?>
                    <li class="<?= ($current_page == 'announcement.php') ? 'active' : '' ?>">
                        <a href="./announcement.php">
                            <i class="fas fa-bullhorn"></i>
                            <p>Announcement</p>
                        </a>
                    </li>
                  
                    <?php if ($account_type == '2') { ?>
                        <li class="<?= ($current_page == 'membersmanagement.php') ? 'active' : '' ?>">
                            <a href="./membersmanagement.php">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>Organization Members</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($account_type == '1') { ?>
                        <li class="<?= ($current_page == 'facultymembers.php') ? 'active' : '' ?>">
                            <a href="./facultymembers.php">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>Faculty Members</p>
                            </a>
                        </li>
                        <li class="<?= ($current_page == 'schoolcalendar.php') ? 'active' : '' ?>">
                        <a href="./schoolcalendar.php">
                            <i class="fas fa-calendar-alt"></i>
                            <p>School Calendar</p>
                        </a>
                    </li>
                        <li class="<?= ($current_page == 'map.php') ? 'active' : '' ?>">
                            <a href="./map.php">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Campus Buildings</p>
                            </a>
                        </li>
                        <li class="<?= ($current_page == 'organization.php') ? 'active' : '' ?>">
                            <a href="./organization.php">
                                <i class="fas fa-users"></i>
                                <p>Student Organization</p>
                            </a>
                        </li>
                        <li class="<?= ($current_page == 'audit.php') ? 'active' : '' ?>">
                            <a href="./audit.php">
                                <i class="fas fa-file-alt"></i>
                                <p>Audit Trails</p>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="<?= ($current_page == 'faqs.php') ? 'active' : '' ?>">
                        <a href="./faqs.php">
                            <i class="fas fa-question-circle"></i>
                            <p>FAQS</p>
                        </a>
                    </li>
                <?php } ?>
                <!-- Office Nav - Visible ONLY to account type 0 -->
<?php if ($account_type == '0') { ?>
    <li class="<?= ($current_page == 'office.php') ? 'active' : '' ?>">
        <a href="./office.php">
            <i class="fas fa-building"></i>
            <p>Office</p>
        </a>
    </li>
<?php } ?>

            </ul>
        </div>
    </div>

    <!-- Rest of the navbar code remains unchanged -->
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
            <a class="navbar-brand" href="javascript:;">
    <?php
    $pageTitles = [
        'dashboard.php' => 'Dashboard',
        'feedback_details.php' => 'Feedback',
        'announcement.php' => 'Announcements',
        'membersmanagement.php' => 'Organization Members',
        'facultymembers.php' => 'Faculty Members',
        'schoolcalendar.php' => 'School Calendar',
        'map.php' => 'Campus Buildings',
        'organization.php' => 'Student Organization',
        'audit.php' => 'Audit Trails',
        'faqs.php' => 'FAQs'
    ];

    // Display the page title dynamically
    echo $pageTitles[$current_page] ?? 'Campus Announcement';
    ?>
</a>

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
                    <?php if ($account_type == '2' || $account_type == '1' || $account_type == '0'  ) { ?>
                        <a class="dropdown-item" href="./profile.php">Profile</a>
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
      <script>
document.addEventListener("DOMContentLoaded", function () {
    // Define a mapping of pages to titles
    const pageTitles = {
        "dashboard.php": "Dashboard",
        "feedback_details.php": "Feedback",
        "announcement.php": "Announcements",
        "membersmanagement.php": "Organization Members",
        "facultymembers.php": "Faculty Members",
        "schoolcalendar.php": "School Calendar",
        "map.php": "Campus Buildings",
        "organization.php": "Student Organization",
        "audit.php": "Audit Trails",
        "faqs.php": "FAQs"
    };

    // Get current page from the URL
    let currentPage = window.location.pathname.split("/").pop();

    // Find the navbar title element
    let navbarTitle = document.querySelector(".navbar-brand");

    // Update the title if found, else default to "Campus Announcement"
    if (navbarTitle) {
        navbarTitle.textContent = pageTitles[currentPage] || "Campus Announcement";
    }
});
</script>
