<?php
include_once ('assets/header.php');
if (isset($_POST['add_calendar_event'])) {
  $log_msg = $obj->add_calendar_event($_POST);
}

if (isset($_POST['save_event'])) {
  $log_msg = $obj->save_event($_POST);
}

if (isset($_REQUEST['did'])) {
  $log_msg = $obj->delete_event($_REQUEST['did']);
}

$allEvents = $obj->show_events();


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
</style>
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
            <a class="navbar-brand" href="javascript:;">Campus School Calendar </a>
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
        <div class="bg-white shadow-lg rounded-lg">
            <div class="p-5">
                <hr class="my-4">
                <div class="mb-6">
                  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                      <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                          <input type="text" id="searchInput" placeholder="Search events..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchEvents()">
                      </div>
                      <div>
                      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#eventModal">
                              Create Event
                          </button>
                      </div>
                  </div>
              </div>


                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 text-center border-b">NO.</th>
                                <th class="py-2 text-center border-b">Event Date</th>
                                <th class="py-2 text-center border-b">Event Details</th>
                                <th class="py-2 text-center border-b">Created By</th>
                                <th class="py-2 text-center border-b">Updated By</th>
                                <th class="py-2 text-center border-b">Updated At</th>
                                <th class="py-2 text-center border-b">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="eventTableBody">
                            <?php
                            $count = 1;
                            function sanitize_html($html) {
                                return strip_tags($html, '<b><i><u>'); // Allow specific HTML tags
                            }
                            foreach ($allEvents as $row) {
                            ?>
                            <tr class="table-row hover:bg-gray-50 transition duration-200">
                                <td class="border-b text-center py-2"><?php echo $count; ?></td>
                                <td class="border-b text-center py-2"><?php echo date('F d Y', strtotime($row["calendar_date"])); ?></td>
                                <td class="border-b text-center py-2"><?php echo isset($row["calendar_details"]) ? sanitize_html($row["calendar_details"]) : 'No details available'; ?></td>
                                <td class="border-b text-center py-2"><?php echo htmlspecialchars($row["creator_name"], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="border-b text-center py-2"><?php echo !empty($row['updated_by_name']) ? htmlspecialchars($row['updated_by_name'], ENT_QUOTES, 'UTF-8') : 'Not yet updated'; ?></td>
                                <td class="border-b text-center py-2"><?php echo !empty($row["updated_at"]) ? date('F d Y H:i A', strtotime($row["updated_at"])) : 'Not updated yet'; ?></td>
                                <td class="border-b text-center py-2">
                                    <div class="flex space-x-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 eventModalEdit" data-toggle="modal" data-target="#eventModalEdit" data-id="<?= $row['calendar_id'] ?>">
                                        <i class="fas fa-edit"></i> <!-- Edit Icon -->
                                    </button>
                                    <a class="bg-red-500 hover:bg-red-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 btn-delete" href='schoolcalendar.php?did=<?= $row['calendar_id'] ?>'>
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

  <!-- add event pop up -->
  <form id="addForm" class="row" action="" method="post">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="eventModal" tabindex="-1" role="dialog" data-backdrop="static"
         data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Calendar Event Creation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
                        <input type="hidden" value="<?= $_SESSION['id'] ?>" name="aid">
                        <label for="event_date" class="form-label fw-bold">Event Date</label>
                        <input type="date" id="event_date" class="form-control" name="event_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-bold">Event Details</label>
                        <textarea id="summernote" name="event_details" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn" value="Create" name="add_calendar_event">
                </div>
            </div>
        </div>
    </div>
</form>


  <!-- edit course pop up -->
  <form id="editForm"class="row" action="" method="post">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="eventModalEdit" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Event Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="eventData">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" class="btn" value="Save" name="save_event">
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
  <script>
    function searchEvents() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#eventTableBody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let match = false;

            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(input)) {
                    match = true;
                }
            });

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get today's date in the format YYYY-MM-DD
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        const yyyy = today.getFullYear();

        // Format today's date as YYYY-MM-DD
        const formattedDate = `${yyyy}-${mm}-${dd}`;

        // Set the min attribute of the event date input to today's date
        const dateInput = document.getElementById("event_date");
        dateInput.setAttribute("min", formattedDate);
    });
</script>
  <script type="text/javascript">
   $(document).ready(function () {
    document.addEventListener("DOMContentLoaded", function() {
        // Get today's date in the format YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];
        // Set the min attribute of the event date input
        document.getElementById("event_date").setAttribute("min", today);
    });
  $('#myTable').DataTable();
  $('#summernote').summernote({
    height: 220,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']]
    ]
  });

  // Handle event edit modal data loading
  $('.eventModalEdit').on('click', function () {
    var eventID = $(this).data('id');
    $.ajax({
      url: 'ajax/eventData.php',
      type: 'post',
      data: { eventID: eventID },
      success: function (response) {
        // Add response in Modal body
        $('#eventData').html(response);
      }
    });
  });

  // Handle delete confirmation
  $('.btn-delete').on('click', function (e) {
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

  // Handle add event form submission with confirmation
 // For the 'add' form
$('#addForm').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    const form = $(this);
    const isAdding = form.find('input[name="add_calendar_event"]').length > 0;
    const requestType = isAdding ? 'add' : 'save';

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this event?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(this);
            formData.append('type', 'event'); // Add request type parameter

            fetch("../admin/ajax/createData.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                console.log(result); // Log the JSON response
                if (result.success) {
                    Swal.fire(
                        "Saved!",
                        result.message,
                        "success"
                    ).then(() => {
                        location.reload(); // Optionally reload the page
                    });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    "Error!",
                    "There was an error saving the event.",
                    "error"
                );
            });
        }
    });
});


// For the 'edit' form
$('#editForm').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this);
    var isAdding = form.find('input[name="save_event"]').length > 0;

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this event?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
          var formData = new FormData(this); // Create FormData from the form element
          formData.append('type', 'event');  // Create FormData from the form element

            // Adjust the URL if necessary to point to the correct PHP handler
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
                Swal.fire("Error!", "There was an error saving the event.", "error");
            });
        }
    });
});

const table = document.querySelector('#myTable');
table.parentElement.style.overflowX = 'auto';

});
  </script>
</body>

</html>