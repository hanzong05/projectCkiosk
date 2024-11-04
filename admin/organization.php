<?php
include_once ('assets/header.php');
$uid = $_SESSION['aid'] ?? null; // Ensure this is set to avoid undefined index warnings
$cid = $_SESSION['id'] ?? null; 
if (isset($_POST['add_org'])) {
  $log_msg = $obj->add_org($_POST);
}

if (isset($_POST['save_org'])) {
  $log_msg = $obj->save_org($_POST);
}

if (isset($_REQUEST['orgid'])) {
  $log_msg = $obj->delete_org($_REQUEST['orgid']);
}

if (isset($_POST['add_account'])) {
  $log_msg = $obj->add_account($_POST);
}

if (isset($_POST['save_account'])) {
  $log_msg = $obj->save_account($_POST);
}

if (isset($_REQUEST['aid'])) {
  $log_msg = $obj->delete_account($_REQUEST['aid']);
}

$allOrg = $obj->show_org();
$allAccount = $obj->show_account();
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
      <!-- CSS Files -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
      <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
      <link href="assets/css/css.css" rel="stylesheet" />
      <style>
          .input-group {
              position: relative;
          }

          .password-field {
              padding-right: 2.5rem; /* Space for the icon */
          }

          .password-toggle {
              position: absolute;
              right: 0;
              top: 0;
              height: 100%;
              display: flex;
              align-items: center;
              padding: 0 0.75rem;
              cursor: pointer;
              background: #fff; /* Match input background */
              border-left: 1px solid #ced4da; /* Match input border */
          }

          .password-toggle i {
              font-size: 1.2rem; /* Adjust icon size if needed */
          }  .hidden {
            display: none; /* Ensure hidden class properly hides content */
        }
        .active {
            font-weight: bold; /* Style for active tab */
            color: #3B82F6; /* Text color for active tab */
        }
        .tab-content {
            margin-top: 1rem; /* Space between tabs and content */
        }
    /* Responsive adjustments for smaller screens */
@media (max-width: 576px) {
  /* Make the container take up full width */
  .container-fluid {
    padding: 0 15px;
  }

  /* Reduce font sizes */
  .navbar-brand, .card-body, .btn {
    font-size: 0.9rem;
  }

  /* Adjust table */
  #myTable {
    width: 100%;
    font-size: 0.8rem;
    overflow-x: auto;
  }

  /* Hide extra columns on mobile */
  #myTable th:nth-child(6),
  #myTable th:nth-child(7),
  #myTable th:nth-child(8),
  #myTable td:nth-child(6),
  #myTable td:nth-child(7),
  #myTable td:nth-child(8) {
    display: none;
  }

  /* Adjust button padding */
  .btn {
    padding: 5px 10px;
  }

  /* Adjust table cells for readability */
  .table-row td {
    padding: 8px 5px;
    text-align: center;
  }

  /* Adjust modal width */
  .modal-dialog {
    max-width: 90%;
  }
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
                    <li>
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
                    <li class="active">
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
            <a class="navbar-brand" href="javascript:;">Campus Organization </a>
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
      <div class="flex flex-col w-full">
    <div class="w-full">
        <div class="bg-white shadow-md rounded-lg">
            <div class="p-5">
                <hr class="my-4">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                            <input type="text" id="searchOrgInput" placeholder="Search organizations..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchOrg()">
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full md:w-auto" data-toggle="modal" data-target="#orgModal">
                                Add Campus Organization
                            </button>
                            
                    </div>
                </div>

                <!-- Nav tabs -->
                <div class="tabs">
    <ul class="flex border-b">
        <li class="mr-1">
            <a 
                class="bg-white inline-block py-2 px-4 text-blue-500 border-l border-t border-r rounded-t-lg active" 
                id="organization-tab" 
                href="#organization" 
                role="tab" 
                aria-controls="organization" 
                aria-selected="true" 
                onclick="changeTab(event, 'organization')">Organization
            </a>
        </li>
        <li class="mr-1">
            <a 
                class="bg-white inline-block py-2 px-4 text-gray-500 hover:text-blue-500 rounded-t-lg" 
                id="account-tab" 
                href="#account" 
                role="tab" 
                aria-controls="account" 
                aria-selected="false" 
                onclick="changeTab(event, 'account')">Accounts
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content mt-4">
        <!-- Organization Tab -->
        <div id="organization" role="tabpanel" aria-labelledby="organization-tab">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 text-left border-b">NO.</th>
                            <th class="py-2 text-left border-b">Photo</th>
                            <th class="py-2 text-left border-b">Name</th>
                            <th class="py-2 text-left border-b">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($allOrg as $row) {
                            ?>
                            <tr class="table-row hover:bg-gray-100">
                                <td class="border-b px-4 py-2"><?php echo $count; ?></td>
                                <td class="border-b px-4 py-2"><img src="../uploaded/orgUploaded/<?php echo $row['org_image'] ?>" height="80" width="100" /></td>
                                <td class="border-b px-4 py-2"><?php echo $row["org_name"]; ?></td>
                                <td class="border-b px-4 py-2 text-center">
                                <div class="flex space-x-2">
    <button class="bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 orgModalEdit" data-toggle="modal" data-target="#orgModalEdit" data-id="<?= $row['org_id'] ?>">
        <i class="fas fa-edit"></i> <!-- Edit Icon -->
    </button>
    <a class="bg-red-500 hover:bg-red-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 btn-delete-org" href='organization.php?orgid=<?= $row['org_id'] ?>'>
        <i class="fas fa-trash"></i> <!-- Delete Icon -->
    </a>
</div>

                                    </div>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Accounts Tab -->
        <div id="account" role="tabpanel" aria-labelledby="account-tab" class="hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 text-left border-b">NO.</th>
                            <th class="py-2 text-left border-b">Username</th>
                            <th class="py-2 text-left border-b">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($allAccount as $row) {
                            ?>
                            <tr class="table-row hover:bg-gray-100">
                                <td class="border-b px-4 py-2"><?php echo $count; ?></td>
                                <td class="border-b px-4 py-2"><?php echo $row["users_username"]; ?></td>
                                <td class="border-b px-4 py-2 text-center">
                                    <div class="flex space-x-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 accountModalEdit" data-toggle="modal" data-target="#accountModalEdit" data-id="<?= $row['users_id'] ?>">
    <i class="fas fa-edit"></i> <!-- Edit Icon -->
</button>
<a class="bg-red-500 hover:bg-red-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 btn-delete-account" href='organization.php?aid=<?= $row['users_id'] ?>'>
    <i class="fas fa-trash"></i> <!-- Delete Icon -->
</a>

                                    </div>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

      </div>
    </div>
  </div>

  <!-- add org pop up -->
  <form id="orgForm" class="row" action="" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
  <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid"> 
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="orgModal" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Campus Organization Creation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="org_name" class="form-label fw-bold">Organization Name</label>
              <input type="text" id="org_name" class="form-control" name="org_name" required>
            </div>
            <div class="mb-3">
              <label for="org_image" class="form-label fw-bold">Photo</label>
              <input type="file" id="org_image" class="form-control" name="org_image" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" class="btn" value="Add" name="add_org">
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- edit org pop up -->
  <form class="row" action="" method="post" enctype="multipart/form-data">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="orgModalEdit" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Campus Organization Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="orgData">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" class="btn" value="Save" name="save_org">
          </div>
        </div>
      </div>
    </div>
  </form>
  <form id="accountForm" class="row" action="" method="post">
  <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
  <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid"> 
    <!-- Modal for Account Creation -->
    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Account Creation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Input fields for creating a new account -->
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" id="username" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" class="form-control password-field" name="password" required>
                            <span class="input-group-text password-toggle" id="togglePassword">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="password-requirements">
                            <p>Password must meet the following criteria:</p>
                            <ul class="requirement-list">
                                <li>
                                    <input type="radio" id="length-check" name="length" disabled>
                                    <label for="length-check">At least 8 characters</label>
                                </li>
                                <li>
                                    <input type="radio" id="uppercase-check" name="uppercase" disabled>
                                    <label for="uppercase-check">At least one uppercase letter</label>
                                </li>
                                <li>
                                    <input type="radio" id="number-check" name="number" disabled>
                                    <label for="number-check">At least one number</label>
                                </li>
                                <li>
                                    <input type="radio" id="special-check" name="special" disabled>
                                    <label for="special-check">At least one special character (!@#$%^&*(),.?":{}|<>_)</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="org" class="form-label fw-bold">Organization</label>
                        <select name="org" id="org" class="form-control" required>
                            <option value="" selected>Select an organization</option>
                            <?php
                            foreach ($allOrg as $row) {
                                if ($row['org_id'] == 0) continue; // Skip org_id = 1
                                echo '<option value="' . htmlspecialchars($row['org_id'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row['org_name'], ENT_QUOTES, 'UTF-8') . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add" name="add_account">
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Edit Account Form -->
<form id="accountEditForm" class="row" action="" method="post">
    <!-- Modal for Account Edit -->
    <div class="modal fade" id="accountModalEdit" tabindex="-1" role="dialog" aria-labelledby="accountModalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalEditLabel">Account Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="accountData">
                    <!-- Dynamic content will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save" name="save_account">
                </div>
            </div>
        </div>
    </div>
</form>

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
  <script>function changeTab(event, tabName) {
    // Prevent default link behavior
    event.preventDefault();

    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content > div');
    contents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('[role="tab"]');
    tabs.forEach(tab => {
        tab.classList.remove('active', 'text-blue-500');
        tab.classList.add('text-gray-500');
        tab.classList.remove('border-l', 'border-t', 'border-r');
    });

    // Show the selected tab content
    const selectedContent = document.getElementById(tabName);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }

    // Set the clicked tab as active
    event.currentTarget.classList.add('active', 'text-blue-500');
    event.currentTarget.classList.remove('text-gray-500');
    event.currentTarget.classList.add('border-l', 'border-t', 'border-r');

    // Update buttons and search based on active tab
    updateButtonsAndSearch(tabName);
}

function updateButtonsAndSearch(tabName) {
    const buttonsContainer = document.querySelector('.flex.space-x-2');
    const searchInput = document.getElementById('searchOrgInput');

    if (tabName === 'organization') {
        // Update for Organizations tab
        searchInput.placeholder = 'Search organizations...';
        searchInput.setAttribute('onkeyup', 'searchOrg()');
        buttonsContainer.innerHTML = `
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full md:w-auto" 
                    data-toggle="modal" 
                    data-target="#orgModal">
                Add Campus Organization
            </button>
        `;
    } else if (tabName === 'account') {
        // Update for Accounts tab
        searchInput.placeholder = 'Search accounts...';
        searchInput.setAttribute('onkeyup', 'searchAccount()');
        buttonsContainer.innerHTML = `
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full md:w-auto" 
                    data-toggle="modal" 
                    data-target="#accountModal">
                Add Organization Account
            </button>
        `;
    }

    // Reattach modal event listeners
    attachModalListeners();
}

// Function for searching organizations
function searchOrg() {
    const input = document.getElementById('searchOrgInput');
    const filter = input.value.toUpperCase();
    const rows = document.querySelectorAll('#organization tbody tr');

    rows.forEach(row => {
        const nameCell = row.querySelector('td:nth-child(3)'); // Name is in the third column
        if (nameCell) {
            const txtValue = nameCell.textContent || nameCell.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

// Function for searching accounts
function searchAccount() {
    const input = document.getElementById('searchOrgInput');
    const filter = input.value.toUpperCase();
    const rows = document.querySelectorAll('#account tbody tr');

    rows.forEach(row => {
        const usernameCell = row.querySelector('td:nth-child(2)'); // Username is in the second column
        if (usernameCell) {
            const txtValue = usernameCell.textContent || usernameCell.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

// Function to attach modal event listeners
function attachModalListeners() {
    // Event listeners for add buttons
    const modalButtons = document.querySelectorAll('[data-toggle="modal"]');
    modalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetModal = this.getAttribute('data-target');
            const modal = document.querySelector(targetModal);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    });

    // Event listeners for edit buttons
    const editButtons = document.querySelectorAll('.orgModalEdit, .accountModalEdit');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetModal = this.getAttribute('data-target');
            const id = this.getAttribute('data-id');
            const modal = document.querySelector(targetModal);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    });
}

// Initialize the page with organization tab active
document.addEventListener('DOMContentLoaded', function() {
    const organizationTab = document.getElementById('organization-tab');
    const event = { 
        preventDefault: () => {}, 
        currentTarget: organizationTab 
    };
    changeTab(event, 'organization');
});

  </script>
  <script>
function searchOrg() {
    const searchInput = document.getElementById('searchOrgInput');
    if (!searchInput) {
        console.error('Search input not found'); // Log error if the input is not found
        return;
    }

    const filter = searchInput.value.toLowerCase();
    const tableRows = document.querySelectorAll('#organization table tbody tr'); // Adjust if necessary

    tableRows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        let rowContainsSearchTerm = false;

        for (let cell of cells) {
            if (cell.textContent.toLowerCase().includes(filter)) {
                rowContainsSearchTerm = true;
                break;
            }
        }

        if (rowContainsSearchTerm) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
}

</script>

  <script type="text/javascript">
    $(document).ready(function() {
   
    // Function to handle modal close
    $('#accountModalEdit').on('hidden.bs.modal', function () {
        localStorage.setItem('activeTab', 'account-tab'); // Store tab state only on close
    });

    // Check for stored tab state on page load
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        activateTab(activeTab);
        localStorage.removeItem('activeTab'); // Clear stored tab state after activation
    }
});
    $(document).ready(function() {
    // Function to programmatically click a tab
      
      $('#myTable').DataTable();

      $('.orgModalEdit').on('click', function () {
        var orgID = $(this).data('id');
        $.ajax({
          url: 'ajax/orgData.php',
          type: 'post',
          data: { orgID: orgID },
          success: function (response) {
            // Add response in Modal body
            $('#orgData').html(response);
          }
        });
      });
      $('.accountModalEdit').on('click', function () {
        var accountID  = $(this).data('id');
        $.ajax({
          url: 'ajax/accountData.php',
          type: 'post',
          data: { accountID: accountID },
          success: function (response) {
            // Add response in Modal body
            $('#accountData').html(response);
          }
        });
      });

      $("#org_image").change(function () {
        var fileExtension = ['jpg', 'png', 'jpeg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          alert("Only formats are allowed : " + fileExtension.join(', '));
          $("#org_image").val('');
        }
      });

      document.getElementById('orgForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Show confirmation dialog before proceeding
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this organization?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, add it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(this);
            formData.append('type', 'organization'); // Ensure type parameter is included

            fetch('../admin/ajax/createData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                Swal.fire("Response", result.message, "info");
                if (result.success) {
                    Swal.fire("Added!", "The organization has been added.", "success")
                        .then(() => {
                            document.location = "organization.php"; // Redirect to the organizations page
                        });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "There was an error adding the organization.", "error");
            });
        }
    });
});
document.getElementById('accountForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this account?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, add it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(this);
            formData.append('type', 'account');

            fetch('../admin/ajax/createData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                Swal.fire("Response", result.message, "info");
                if (result.success) {
                    Swal.fire("Added!", "The account has been added.", "success")
                        .then(() => {
                            document.location = "organization.php";
                        });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
              Swal.fire("Added!", "The organization has been added.", "success")
                        .then(() => {
                            document.location = "organization.php"; // Redirect to the organizations page
                        });
            });
        }
    });
});

$('#orgModalEditform').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this);
    var formData = new FormData(this); // Create FormData from the form element
    formData.append('type', 'organization'); // Add type to FormData

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save these changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("../admin/ajax/editData.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire("Saved!", result.message, "success").then(() => {
                        location.reload(); // Optionally reload the page
                    });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "There was an error saving the organization.", "error");
            });
        }
    });
});
  // For the 'edit' account form
  $('#accountModalEdit form').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this);
    var isAdding = form.find('input[name="save_account"]').length > 0;

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this account?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(form[0]); // Create FormData from the form element
            formData.append('type', 'account'); // Append a type for identifying the request

            fetch("../admin/ajax/editData.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire("Saved!", result.message, "success").then(() => {
                        $('#accountModalEdit').modal('hide'); // Hide the modal
                        location.reload(); // Reload the page
                    });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "There was an error saving the account.", "error");
            });
        } else if (result.isDismissed) {
            // This handles the "Cancel" button click
            Swal.fire("Cancelled", "Your data was not saved.", "info").then(() => {
                $('#accountModalEdit').modal('hide'); // Hide the modal
                location.reload(); // Reload the page
            });
        }
    });
});

$(document).on('click', '.btn-delete-account', function (e) {
        e.preventDefault(); // Prevent default link behavior
        var deleteUrl = $(this).attr('href'); // Get the href attribute of the clicked link

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl; // Redirect to the delete URL
            }
        });
    });


    $(document).on('click', '.btn-delete-org', function (e) {
        e.preventDefault(); // Prevent default link behavior
        var deleteUrl = $(this).attr('href'); // Get the href attribute of the clicked link

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl; // Redirect to the delete URL
            }
        });
    });

    });
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordField = $('#password');
            var icon = $(this).find('i');

            // Toggle the type of the password field
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
  </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("password");
    const lengthCheck = document.getElementById("length-check");
    const uppercaseCheck = document.getElementById("uppercase-check");
    const numberCheck = document.getElementById("number-check");
    const specialCheck = document.getElementById("special-check");

    passwordField.addEventListener("input", function () {
        const password = passwordField.value;

        // Reset all radio buttons to unchecked
        lengthCheck.checked = false;
        uppercaseCheck.checked = false;
        numberCheck.checked = false;
        specialCheck.checked = false;

        // Check password requirements and set radio buttons accordingly
        if (password.length >= 8) {
            lengthCheck.checked = true; // Check the length radio button
        }
        if (/[A-Z]/.test(password)) {
            uppercaseCheck.checked = true; // Check the uppercase radio button
        }
        if (/\d/.test(password)) {
            numberCheck.checked = true; // Check the number radio button
        }
        if(/[!@#$%^&*(),.?":{}|<>_]/.test(password)) { // Updated special character regex
            specialCheck.checked = true; // Check the special character radio button
        }
    });
    const table = document.querySelector('#myTable');
table.parentElement.style.overflowX = 'auto';
});
</script>
</body>

</html>