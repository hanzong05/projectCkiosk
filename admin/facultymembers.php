<?php

include_once ('assets/header.php');
$uid = $_SESSION['aid'] ?? null; // Ensure this is set to avoid undefined index warnings
$cid = $_SESSION['id'] ?? null; 
if (isset($_POST['add_faculty_member'])) {
  $log_msg = $obj->add_faculty_member($_POST);
}
if (isset($_POST['add_faculty_member_using_excel'])) {
  $log_msg = $obj->add_faculty_member_using_excel($_POST);
}
if (isset($_POST['save_faculty'])) {
  $log_msg = $obj->save_faculty($_POST);
}

if (isset($_REQUEST['did'])) {
  $log_msg = $obj->delete_faculty($_REQUEST['did']);
}

$allFacultyheads = $obj->show_facultyheads([5, 6, 7, 8, 9,10,11,12,13]);

$allDepartment = $obj->show_department();
$allFaculty = $obj->show_facultymembers([]);

$allDepartment = $obj->show_department();




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
      <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="assets/css/css.css" rel="stylesheet" />
</head>
<style>
    
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

    /* Style for the Department Wrapper */
    #department_inputs .department-input-wrapper {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    /* Style for the Select and Remove Button */
    #department_inputs .department-select {
        flex: 1;
        margin-right: 0.5rem;
    }
    #addDepartmentBtn {
        margin-bottom: 1rem;
    }
    /* Spacing for Remove button */
    .removeDepartmentBtn {
        min-width: 80px;
    }


</style>
<body class="">
<div class="wrapper "><div class="wrapper ">
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
                    <li >
                        <a href="./schoolcalendar.php">
                            <i class="fas fa-calendar-alt"></i>
                            <p>School Calendar</p>
                        </a>
                    </li>
                    <?php if ($account_type == '1') { ?>
                        <li class="active">
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
            <a class="navbar-brand" href="javascript:;">Campus Faculty Members </a>
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
                    <div class="content">
                    <div class="flex flex-col w-full">
    <div class="w-full">
        <div class="bg-white shadow-md rounded-lg">
            <div class="p-5">
                <hr class="my-4">
                <!-- Search and Buttons -->
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                            <input type="text" id="searchFacultyInput" placeholder="Search faculty..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchFaculty()">
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full md:w-auto" data-toggle="modal" data-target="#facultyModal">
                                Add Faculty Member
                            </button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full md:w-auto" data-toggle="modal" data-target="#excelImportModal">
                                Update Via Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Nav tabs -->
                <ul class="flex border-b">
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 border-l border-t border-r rounded-t-lg active" 
                           id="faculty-tab" 
                           href="#faculty" 
                           role="tab" 
                           aria-controls="faculty" 
                           aria-selected="true" 
                           onclick="changeTab(event, 'faculty')">
                            Faculty Members
                        </a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-gray-500 hover:text-blue-500 rounded-t-lg" 
                           id="facultyheads-tab" 
                           href="#facultyheads" 
                           role="tab" 
                           aria-controls="facultyheads" 
                           aria-selected="false" 
                           onclick="changeTab(event, 'facultyheads')">
                            Faculty Heads
                        </a>
                    </li>
                </ul>

           <!-- Tab content -->
<div class="tab-content mt-4">
    <!-- Faculty Members Tab -->
    <div class="tab-pane fade show active" id="faculty" role="tabpanel" aria-labelledby="faculty-tab">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 text-left border-b">NO.</th>
                        <th class="py-2 text-left border-b">Faculty Departments</th> <!-- Changed header to plural -->
                        <th class="py-2 text-left border-b">Photo</th>
                        <th class="py-2 text-left border-b">Name</th>
                        <th class="py-2 text-left border-b">Specialization</th>
                        <th class="py-2 text-left border-b">Consultation Time</th>
                        <th class="py-2 text-left border-b">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    // Check if allFaculty contains valid data
                    if ($allFaculty) {
                        foreach ($allFaculty as $row) {
                            // Ensure the departments field is not empty or null
                            $departments = isset($row["departments"]) ? $row["departments"] : 'No departments assigned';
                    ?>
                    <tr class="table-row hover:bg-gray-100">
                        <td class="border-b px-4 py-2"><?php echo $count; ?></td>
                        <td class="border-b px-4 py-2"><?php echo $departments; ?></td> <!-- Display concatenated departments -->
                        <td class="border-b px-4 py-2">
                            <img src="../uploaded/facultyUploaded/<?php echo htmlspecialchars($row['faculty_image']); ?>" 
                                 height="80" 
                                 width="100"
                                 alt="Faculty photo" 
                                 class="object-cover" />
                        </td>
                        <td class="border-b px-4 py-2"><?php echo htmlspecialchars($row["faculty_name"]); ?></td>
                        <td class="border-b px-4 py-2"><?php echo !empty($row["specialization"]) ? htmlspecialchars($row["specialization"]) : 'NULL'; ?></td>
                        <td class="border-b px-4 py-2"><?php echo !empty($row["consultation_time"]) ? htmlspecialchars($row["consultation_time"]) : 'NULL'; ?></td>
                        <td class="border-b px-4 py-2 text-center">
                            <div class="flex space-x-2">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 facultyModalEdit" 
                                        data-toggle="modal" 
                                        data-target="#facultyModalEdit" 
                                        data-id="<?= $row['faculty_id']; ?>">
                                    <i class="fas fa-edit mr-1"></i>
                                </button>
                                <a class="bg-red-500 hover:bg-red-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 btn-delete" 
                                   href='facultymembers.php?did=<?= $row['faculty_id']; ?>'>
                                    <i class="fas fa-trash mr-1"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                            $count++;
                        }
                    } else {
                        // If no faculty data is available
                        echo '<tr><td colspan="7" class="text-center py-2">No faculty members available.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


                    <!-- Faculty Heads Tab -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>


<div class="modal fade" id="excelImportModal" tabindex="-1" role="dialog" aria-labelledby="importExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelLabel">Import Faculty Members via Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="ajax/createData.php" id="excelImportForm" method="post" enctype="multipart/form-data">
                    <!-- Hidden inputs for user ID and creator ID -->
                    <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid">
                    
                    <div class="mb-3">
                        <label for="faculty_excel" class="form-label fw-bold">Select Excel File</label>
                        <input type="file" id="faculty_excel" class="form-control" name="faculty_excel" accept=".xls,.xlsx,.csv" required>
                        <small class="form-text text-muted">Upload an Excel file containing faculty data.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" form="excelImportForm" value="Import" name="add_faculty_member_using_excel">
                <a href="ajax/excel.php" class="btn btn-secondary">Show Format</a>
            </div>
        </div>
    </div>
</div>

<form id="facultyModalForm" class="row" method="post" enctype="multipart/form-data">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="facultyModal" tabindex="-1" role="dialog" data-backdrop="static"
         data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Faculty Member Creation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="faculty_name" class="form-label fw-bold">Faculty Name</label>
                        <input type="text" id="faculty_name" class="form-control" name="faculty_name" required>
                    </div>
                    <div id="department_inputs">
                        <div class="mb-3 department-input-wrapper">
                            <div class="input-group">
                                <select name="department[]" class="form-control department-select" required>
                                    <option value="" selected>Select department</option>
                                    <?php
                                    foreach ($allDepartment as $row) {
                                        echo '<option value="' . $row['department_id'] . '">' . $row['department_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <button type="button" class="btn btn-danger removeDepartmentBtn ms-2">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addDepartmentBtn" class="btn btn-outline-primary mb-3">
                        Add Another Department
                    </button>
                    <div class="mb-3">
                        <label for="specialization" class="form-label fw-bold">Specialization</label>
                        <input type="text" id="specialization" class="form-control" name="specialization">
                    </div>
                    <div class="mb-3">
                        <label for="consultation_time" class="form-label fw-bold">Consultation Time</label>
                        <input type="text" id="consultation_time" class="form-control" name="consultation_time" placeholder="e.g., 'Monday - Thursday 8:00 AM to 4:00 PM'">
                    </div>
                    <div class="mb-3">
                        <label for="faculty_image" class="form-label fw-bold">Photo</label>
                        <input type="file" id="faculty_image" class="form-control" name="faculty_image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add" name="add_faculty_member">
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Modal -->
<form id="editFacultyForm" class="row" action="" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?= $_SESSION['id'] ?>" name="editor_id"> <!-- Make sure this field exists and has the correct session value -->

    <div class="modal fade bd-example-modal-lg" id="facultyModalEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Faculty Member Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="facultyData">
                    <!-- Content will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save" name="save_faculty">
                </div>
            </div>
        </div>
    </div>
</form>


  <!--   Core JS Files   -->
     
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  <script>function searchFaculty() {
    const input = document.getElementById('searchFacultyInput');
    const filter = input.value.toLowerCase();
    const table = document.querySelector('#faculty table tbody');
    const rows = table.getElementsByTagName('tr');

    // Loop through all table rows, and hide those that don't match the search query
    for (let i = 0; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByTagName('td')[3]; // Name column (4th column)
        const departmentCell = rows[i].getElementsByTagName('td')[1]; // Department column (2nd column)

        if (nameCell || departmentCell) {
            const nameText = nameCell.textContent || nameCell.innerText;
            const departmentText = departmentCell.textContent || departmentCell.innerText;

            if (nameText.toLowerCase().indexOf(filter) > -1 || 
                departmentText.toLowerCase().indexOf(filter) > -1) {
                rows[i].style.display = ''; // Show row
            } else {
                rows[i].style.display = 'none'; // Hide row
            }
        }
    }
}
</script>

<script>
    let selectedDepartments = [];
    const departments = <?php echo json_encode($allDepartment); ?>;

    // Function to update options based on selected departments
    function updateDepartmentOptions() {
        document.querySelectorAll('.department-select').forEach(select => {
            const currentSelection = select.value;
            select.innerHTML = '<option value="">Select department</option>'; // Reset options

            departments.forEach(department => {
                if (!selectedDepartments.includes(department.department_id.toString()) || department.department_id.toString() === currentSelection) {
                    const option = document.createElement('option');
                    option.value = department.department_id;
                    option.textContent = department.department_name;
                    option.selected = department.department_id.toString() === currentSelection;
                    select.appendChild(option);
                }
            });
        });
    }

    // Add Department button handler
    document.getElementById('addDepartmentBtn').addEventListener('click', function() {
        const departmentWrapper = document.createElement('div');
        departmentWrapper.classList.add('mb-3', 'department-input-wrapper');

        const selectContainer = document.createElement('div');
        selectContainer.classList.add('input-group');

        const newSelect = document.createElement('select');
        newSelect.classList.add('form-control', 'department-select');
        newSelect.name = 'department[]';
        newSelect.required = true;
        
        newSelect.addEventListener('change', function() {
            selectedDepartments = Array.from(document.querySelectorAll('.department-select')).map(select => select.value).filter(Boolean);
            updateDepartmentOptions();
        });

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-danger', 'removeDepartmentBtn');
        removeButton.textContent = 'Remove';

        removeButton.addEventListener('click', function() {
            selectedDepartments = selectedDepartments.filter(depId => depId !== newSelect.value);
            departmentWrapper.remove();
            updateDepartmentOptions();
        });

        selectContainer.appendChild(newSelect);
        selectContainer.appendChild(removeButton);
        departmentWrapper.appendChild(selectContainer);
        document.getElementById('department_inputs').appendChild(departmentWrapper);

        updateDepartmentOptions(); // Initialize options in new select
    });

    // Initial population for the first select box
    document.addEventListener('DOMContentLoaded', function() {
        updateDepartmentOptions();

        document.querySelectorAll('.department-select').forEach(select => {
            select.addEventListener('change', function() {
                selectedDepartments = Array.from(document.querySelectorAll('.department-select')).map(select => select.value).filter(Boolean);
                updateDepartmentOptions();
            });
        });
    });
</script><script type="text/javascript">
    // Function to handle tab changes
    function changeTab(event, tabName) {
        // Prevent default link behavior
        event.preventDefault();

        // Hide all tab content
        const tabContents = document.querySelectorAll('.tab-pane');
        tabContents.forEach(content => {
            content.classList.remove('show', 'active');
        });

        // Remove active class from all tabs
        const tabs = document.querySelectorAll('ul.flex a'); // Modify this selector to match your structure
        tabs.forEach(tab => {
            tab.classList.remove('text-blue-500', 'border-l', 'border-t', 'border-r', 'active');
            tab.classList.add('text-gray-500');
        });

        // Show the selected tab content
        const selectedTabContent = document.getElementById(tabName);
        if (selectedTabContent) {
            selectedTabContent.classList.add('show', 'active');
        }

        // Set the active tab with border styling
        event.currentTarget.classList.add('text-blue-500', 'border-l', 'border-t', 'border-r', 'rounded-t-lg', 'active');
        event.currentTarget.classList.remove('text-gray-500');
    }

    $(document).ready(function () {
        // Handle the Excel import form submission
        $('#excelImportForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Show confirmation dialog before proceeding
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to upload this Excel file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, upload it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading spinner
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while your file is being uploaded.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create FormData and append the type
                    var formData = new FormData(this);
                    formData.append('type', 'excel_import');

                    // Get content from Summernote
                    var specializationContent = $('#specialization').summernote('code');
                    formData.append('specialization', specializationContent);

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            // Hide loading spinner and show success message
                            Swal.fire({
                                title: "Success",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: 'Okay'
                            }).then(() => {
                                // Close modal and refresh the page
                                $('#excelImportModal').modal('hide');
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            // Hide loading spinner and show error message
                            Swal.fire("Error", "An error occurred during the upload. Please try again.", "error");
                            console.error(error);
                        }
                    });
                }
            });
        });

        // Image file validation for faculty image input
        $("#faculty_image").change(function () {
            var fileExtension = ['jpg', 'png', 'jpeg'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : " + fileExtension.join(', '));
                $("#faculty_image").val('');
            }
        });

        // Faculty Modal Edit
        $(document).on('click', '.facultyModalEdit', function () {
            var facultyID = $(this).data('id');
            $.ajax({
                url: 'ajax/facultyData.php',
                type: 'post',
                data: { facultyID: facultyID },
                success: function (response) {
                    $('#facultyData').html(response);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        // Delete Faculty Member
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('href');

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
                    window.location.href = deleteUrl;
                }
            });
        });

        // Faculty Modal Form Submission
        document.getElementById('facultyModalForm').addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to add this faculty member?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, add it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    formData.append('type', 'faculty'); // Ensure type parameter is included

                    fetch('../admin/ajax/createData.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        Swal.fire("Response", result.message, "info");
                        if (result.success) {
                            Swal.fire("Added!", "The faculty member has been added.", "success")
                                .then(() => {
                                    document.location = "facultymembers.php"; // Redirect to the faculty members page
                                });
                        } else {
                            Swal.fire("Error!", result.message, "error");
                        }
                    })
                    .catch(error => {
                        Swal.fire("Error!", "There was an error adding the faculty member.", "error");
                    });
                }
            });
        });

        // Handling department dropdowns and removing departments
        let removedDepartments = [];

        $('button.remove-department').on('click', function () {
            let departmentId = $(this).data('department-id');
            removedDepartments.push(departmentId);
        });

        $(document).on('click', '.remove-department-btn', function () {
            var departmentEntry = $(this).closest('.department-entry');
            var departmentId = departmentEntry.data('department-id');

            departmentEntry.hide();
            if (!removedDepartments.includes(departmentId)) {
                removedDepartments.push(departmentId);
            }
            console.log('Removed Departments:', removedDepartments);
        });

        // Add new department dropdown
        $('#add-department-btn').on('click', function () {
            var newDepartmentIndex = $('.department-entry').length;
            var departmentDropdownHTML = `
                <div class="mb-3 department-entry" data-department-id="new_${newDepartmentIndex}">
                    <label for="department_new_${newDepartmentIndex}" class="form-label fw-bold">New Department</label>
                    <select name="department_${newDepartmentIndex}" id="department_new_${newDepartmentIndex}" class="form-control department-dropdown" data-department-id="new_${newDepartmentIndex}">
                        <option value="">Select Department</option>
                        ${generateDepartmentOptions()}
                    </select>
                    <button type="button" class="btn btn-danger btn-sm remove-department-btn">Remove</button>
                </div>
            `;
            $('.department-dropdowns').append(departmentDropdownHTML);
            $('#department_new_' + newDepartmentIndex).trigger('change');
        });

        // Function to generate department options
        function generateDepartmentOptions() {
            var optionsHTML = '';
            <?php foreach ($allDepartment as $dept): ?>
                optionsHTML += '<option value="<?= $dept['department_id']; ?>"><?= $dept['department_name']; ?></option>';
            <?php endforeach; ?>
            return optionsHTML;
        }

        // Form submission handling for editing faculty member
        $('#editFacultyForm').on('submit', function (e) {
            e.preventDefault();

            var form = $(this);
            $('#removedDepartments').val(JSON.stringify(removedDepartments));

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to save this faculty member?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(form[0]);
                    formData.append('type', 'faculty');

                    fetch("../admin/ajax/editData.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(jsonData => {
                        if (jsonData.success) {
                            Swal.fire("Success", jsonData.message, "success");
                        } else {
                            Swal.fire("Error", jsonData.message, "error");
                        }
                    });
                }
            });
        });
    });
</script>

</body>

</html>