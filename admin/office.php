<?php
include_once ('assets/header.php');

if (!isset($_SESSION['atype'])) {
    // If the session is not set, redirect to the login page
    header("Location: index.php");
    exit;
}

$account_type = $_SESSION['atype'];
if ($account_type != '0' && $account_type != '1' && $account_type != '2' && $account_type != '3') {
    // Destroy the session if the account type is invalid
    session_destroy();
    // Redirect to the login page
    header("Location: index.php");
    exit;
}
$uid = $_SESSION['aid'] ?? null; // Ensure this is set to avoid undefined index warnings
$cid = $_SESSION['id'] ?? null; 

ini_set('error_log', 'ajax/error_log.txt');

include_once ('assets/header.php');
if (isset($_POST['add_office'])) {
  $log_msg = $obj->add_office($_POST);
}

if (isset($_POST['save_office'])) {
  $log_msg = $obj->save_office($_POST);
}

if (isset($_REQUEST['did'])) {
  $log_msg = $obj->delete_office($_REQUEST['did']);
}

$allOffices = $obj->show_offices();
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="assets/css/css.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <?php include 'assets/includes/navbar.php'; ?>
    <div class="content">
      <div class="p-6">
        <div class="bg-white rounded-lg shadow-lg">
          <div class="p-6">

            <div class="mb-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                  <input type="text" id="searchOfficeInput" placeholder="Search Offices..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchOffices()">
                </div>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#officeModal">
                  <i class="fas fa-plus"></i>
                  Add New Office
                </button>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">No.</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Office Name</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Location</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Contact Number</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Email</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Services</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="officeTableBody">
                  <?php
                  $count = 1;
                  foreach ($allOffices as $row) {
                  ?>
                  <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $count; ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800 font-medium"><?php echo $row["office_name"]; ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo $row["office_location"]; ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo $row["office_contact"]; ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo $row["office_email"]; ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo $row["office_services"]; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                      <div class="flex justify-center gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition duration-200 officeModalEdit" 
                          data-toggle="modal" data-target="#officeModalEdit" 
                          data-id="<?= $row['office_id'] ?>">
                          <i class="fas fa-edit"></i>
                        </button>
                        <a class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition duration-200 btn-delete" 
                          href='offices.php?did=<?= $row['office_id'] ?>'>
                          <i class="fas fa-trash"></i>
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

  <!-- Add Office Modal -->
  <form id="officeForm" class="row" action="" method="post">
    <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid">

    <div class="modal fade bd-example-modal-lg" id="officeModal" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="officeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-green-600 text-white">
            <h5 class="modal-title" id="officeModalLabel">Add New Office</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="office_name" class="form-label fw-bold">Office Name</label>
              <input type="text" id="office_name" class="form-control" name="office_name" required>
            </div>
            <div class="mb-3">
              <label for="office_location" class="form-label fw-bold">Location</label>
              <input type="text" id="office_location" class="form-control" name="office_location" required>
            </div>
            <div class="mb-3">
              <label for="office_contact" class="form-label fw-bold">Contact Number</label>
              <input type="text" id="office_contact" class="form-control" name="office_contact" required>
            </div>
            <div class="mb-3">
              <label for="office_email" class="form-label fw-bold">Email Address</label>
              <input type="email" id="office_email" class="form-control" name="office_email" required>
            </div>
            <div class="mb-3">
              <label for="office_hours" class="form-label fw-bold">Office Hours</label>
              <input type="text" id="office_hours" class="form-control" name="office_hours" placeholder="e.g. Monday-Friday: 8:00 AM - 5:00 PM" required>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-success" value="Add Office" name="add_office">
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Edit Office Modal -->
  <form id="editOfficeForm" class="row" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="editor_id"> 
    <div class="modal fade bd-example-modal-lg" id="officeModalEdit" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="officeEditModalLabel" aria-hidden="true">
      
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue-600 text-white">
            <h5 class="modal-title" id="officeEditModalLabel">Edit Office Information</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="officeData">
            <!-- Content will be loaded here via AJAX -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Save Changes" name="save_office">
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
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  
  <script>
    function searchOffices() {
      const input = document.getElementById('searchOfficeInput');
      const filter = input.value.toLowerCase();
      const tableBody = document.getElementById('officeTableBody');
      const rows = tableBody.getElementsByTagName('tr');

      for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        for (let j = 1; j < cells.length - 1; j++) { // Exclude the No. and Actions columns
          if (cells[j]) {
            if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
              match = true;
              break;
            }
          }
        }
        rows[i].style.display = match ? '' : 'none'; // Show or hide based on match
      }
    }

    $(document).ready(function() {
      // Initialize rich text editors
      $('#office_services, #office_description').summernote({
        height: 180,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']]
        ]
      });

      // Handle edit button click
      $('.officeModalEdit').on('click', function() {
        var officeID = $(this).data('id');
        
        // Log for debugging
        console.log('Edit button clicked for Office ID:', officeID);
        
        // Make sure we're targeting the correct modal ID
        $('#officeModalEdit').modal('show');
        
        // Fetch the office data
        $.ajax({
          url: 'ajax/officeData.php',
          type: 'post',
          data: { officeID: officeID },
          success: function(response) {
            // Add response in Modal body
            $('#officeData').html(response);
            
            // Initialize Summernote for the loaded content
            $('#edit_office_services, #edit_office_description').summernote({
              height: 180,
              toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']]
              ]
            });
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('Error loading office data. Please try again.');
          }
        });
      });

      // Delete confirmation
      $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = href;
          }
        });
      });

      // Handle form submission for adding offices
      $('#officeForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        Swal.fire({
          title: "Are you sure?",
          text: "Do you want to add this office?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#28a745",
          cancelButtonColor: "#dc3545",
          confirmButtonText: "Yes, add it!",
          cancelButtonText: "Cancel"
        }).then((result) => {
          if (result.isConfirmed) {
            const formData = new FormData(this);
            formData.append('type', 'office'); // Ensure type parameter is included

            fetch('../admin/ajax/createData.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(result => {
              if (result.success) {
                Swal.fire({
                  title: "Success!",
                  text: result.message,
                  icon: "success",
                  timer: 2000,
                  showConfirmButton: false
                }).then(() => {
                  window.location.href = "offices.php"; // Redirect to the offices page
                });
              } else {
                Swal.fire("Error!", result.message, "error");
              }
            })
            .catch(error => {
              console.error('Error:', error);
              Swal.fire("Error!", "There was an error adding the office.", "error");
            });
          }
        });
      });

      // Handle form submission for editing offices
      $('#editOfficeForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        Swal.fire({
          title: "Are you sure?",
          text: "Do you want to save these changes?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#007bff",
          cancelButtonColor: "#dc3545",
          confirmButtonText: "Yes, save changes!",
          cancelButtonText: "Cancel"
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData(this); // Create FormData from the form element
            formData.append('type', 'office');  // Add type to FormData

            fetch("../admin/ajax/editData.php", {
              method: "POST",
              body: formData
            })
            .then(response => response.json())
            .then(result => {
              if (result.success) {
                Swal.fire({
                  title: "Success!",
                  text: result.message,
                  icon: "success",
                  timer: 2000,
                  showConfirmButton: false
                }).then(() => {
                  location.reload(); // Reload the page
                });
              } else {
                Swal.fire("Error!", result.message, "error");
              }
            })
            .catch(error => {
              Swal.fire("Error!", "There was an error saving the changes.", "error");
              console.error("Error:", error); // Keep error logging for debugging
            });
          }
        });
      });
    });
  </script>
</body>
</html>