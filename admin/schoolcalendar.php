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

.selected-file-info {
    transition: all 0.3s ease;
}

.selected-file-info .fa-times {
    transition: color 0.2s ease;
}
</style>
<body class="">
<div class="wrapper">
   <?php include 'assets/includes/navbar.php'; ?>
      <div class="content">
      <div class="flex flex-col w-full">
    <div class="w-full">
        <div class="bg-white shadow-lg rounded-lg">
            <div class="p-5">
                <hr class="my-4">
                <div class="mb-6">
                  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                      <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                          <div class="flex space-x-2">
                              <input type="text" id="searchInput" placeholder="Search events..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchEvents()">
                              <select id="entriesFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-base" onchange="updateTableEntries()">
                                  <option value="10">10 entries</option>
                                  <option value="25">25 entries</option>
                                  <option value="50">50 entries</option>
                                  <option value="100">100 entries</option>
                                  <option value="all">Show all</option>
                              </select>
                          </div>
                      </div>
                      <div>
                          <div class="flex space-x-2">
                              <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#eventModal">
                                  Create Event
                              </button>
                              <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#excelUploadModal">
                                  <i class="fas fa-file-excel"></i> Upload Excel
                              </button>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="overflow-x-auto mt-4">
                    <div class="relative">
                        <!-- Fixed header -->
                        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                            <thead class="bg-gray-100 sticky top-0 z-10">
                                <tr>
                                    <th class="py-2 text-center border-b">NO.</th>
                                    <th class="py-2 text-center border-b">Start Date</th>
                                    <th class="py-2 text-center border-b">End Date</th>
                                    <th class="py-2 text-center border-b">Event Details</th>
                                    <th class="py-2 text-center border-b">Created By</th>
                                    <th class="py-2 text-center border-b">Updated By</th>
                                    <th class="py-2 text-center border-b">Updated At</th>
                                    <th class="py-2 text-center border-b">ACTION</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- Scrollable body -->
                        <div class="overflow-y-auto" style="height: 400px;"> <!-- Fixed height for 10 rows -->
                            <table class="min-w-full bg-white border border-gray-200">
                                <tbody id="eventTableBody">
                                    <?php
                                    $count = 1;
                                    function sanitize_html($html) {
                                        return strip_tags($html, '<b><i><u>');
                                    }
                                    foreach ($allEvents as $row) {
                                    ?>
                                    <tr class="table-row hover:bg-gray-50 transition duration-200">
                                        <td class="border-b text-center py-2"><?php echo $count; ?></td>
                                        <td class="border-b text-center py-2"><?php echo date('F d Y', strtotime($row["calendar_start_date"])); ?></td>
                                        <td class="border-b text-center py-2"><?php echo date('F d Y', strtotime($row["calendar_end_date"])); ?></td>
                                        <td class="border-b text-center py-2"><?php echo isset($row["calendar_details"]) ? sanitize_html($row["calendar_details"]) : 'No details available'; ?></td>
                                        <td class="border-b text-center py-2"><?php echo htmlspecialchars($row["creator_name"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-b text-center py-2"><?php echo !empty($row['updated_by_name']) ? htmlspecialchars($row['updated_by_name'], ENT_QUOTES, 'UTF-8') : 'Not yet updated'; ?></td>
                                        <td class="border-b text-center py-2"><?php echo !empty($row["updated_at"]) ? date('F d Y H:i A', strtotime($row["updated_at"])) : 'Not updated yet'; ?></td>
                                        <td class="border-b text-center py-2">
                                            <div class="flex space-x-2">
                                                <button class="bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 eventModalEdit" data-toggle="modal" data-target="#eventModalEdit" data-id="<?= $row['calendar_id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a class="bg-red-500 hover:bg-red-600 text-white flex items-center justify-center px-4 py-2 rounded transition duration-200 btn-delete" href='schoolcalendar.php?did=<?= $row['calendar_id'] ?>'>
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
</div>
    </div>
  </div>

  <div class="modal fade" id="excelUploadModal" tabindex="-1" role="dialog" aria-labelledby="excelUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excelUploadModalLabel">Upload Events from Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Template Download Section -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Download the template first to ensure correct format:</p>
                    <a href="ajax/excel_events.php?download_template" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-block">
                        <i class="fas fa-download mr-2"></i>Download Template
                    </a>
                </div>

                <!-- File Upload Section -->
                <form id="excelUploadForm">
                    <div class="form-group">
                        <label for="excelFile" class="block text-sm font-medium text-gray-700 mb-2">
                            Choose Excel File
                        </label>
                        <input type="file" 
                               class="form-control-file" 
                               id="excelFile" 
                               name="excelFile" 
                               accept=".xlsx,.xls" 
                               required>
                        <small class="text-gray-500 block mt-1">Only .xlsx and .xls files are allowed (max 5MB)</small>
                    </div>

                    <!-- Selected File Info -->
                    <div id="selectedFileName" class="selected-file-info mt-2 hidden">
                        <!-- File info will be inserted here by JavaScript -->
                    </div>

                    <!-- Upload Status -->
                    <div id="uploadStatus" class="mt-4 hidden">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700" id="uploadStatusText">Uploading...</span>
                            <span class="text-sm font-medium text-gray-700" id="uploadProgress">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%" id="uploadProgressBar"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="uploadExcelBtn" disabled>Upload</button>
            </div>
        </div>
    </div>
</div>
   
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
                        <label for="event_date_from" class="form-label fw-bold">Event Start Date</label>
                        <input type="date" id="event_date_from" class="form-control" name="event_date_from" required>
                    </div>
                    <div class="mb-3">
                        <label for="event_date_to" class="form-label fw-bold">Event End Date</label>
                        <input type="date" id="event_date_to" class="form-control" name="event_date_to" required>
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
    function updateTableEntries() {
    const entriesSelect = document.getElementById('entriesFilter');
    const tableBody = document.getElementById('eventTableBody');
    const rows = tableBody.getElementsByTagName('tr');
    const selectedValue = entriesSelect.value;
    
    // Show all rows first (in case of previous filtering)
    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = '';
    }
    
    // If not showing all, hide rows beyond the selected number
    if (selectedValue !== 'all') {
        const numEntries = parseInt(selectedValue);
        for (let i = numEntries; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const entriesSelect = document.getElementById('entriesFilter');
    entriesSelect.value = '10'; // Set default value to 10
    updateTableEntries(); // Apply filtering on load
});

function searchEvents() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const tableBody = document.getElementById('eventTableBody');
    const rows = tableBody.querySelectorAll('tr');
    
    let found = false;

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
            found = true;
        } else {
            row.style.display = 'none';
        }
    });

    // Remove existing "No events found" message if present
    const noResultsRow = document.getElementById('noResultsRow');
    if (noResultsRow) {
        noResultsRow.remove();
    }

    // If no matches are found, add a row with the message
    if (!found) {
        const noResultsRow = document.createElement('tr');
        noResultsRow.id = 'noResultsRow';
        noResultsRow.innerHTML = `<td colspan="100%" style="text-align: center; font-weight: bold;">No events found</td>`;
        tableBody.appendChild(noResultsRow);
    }
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
$(document).ready(function() {
    // File selection handling
    const fileInput = $('#excelFile');
    const uploadBtn = $('#uploadExcelBtn');
    const fileLabel = $('#selectedFileName');
    
    fileInput.on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const size = formatFileSize(file.size);
            fileLabel.html(`
                <div class="flex items-center p-2 bg-blue-50 rounded-lg">
                    <i class="fas fa-file-excel text-blue-500 mr-2"></i>
                    <span class="text-sm text-gray-700">${file.name}</span>
                    <span class="text-xs text-gray-500 ml-2">(${size})</span>
                    <button type="button" class="ml-auto text-gray-400 hover:text-gray-600" id="clearFile">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).removeClass('hidden');
            
            uploadBtn.prop('disabled', false)
                    .removeClass('opacity-50 cursor-not-allowed')
                    .addClass('hover:bg-blue-600');
        } else {
            clearFileSelection();
        }
    });

    // Clear file selection handler
    $(document).on('click', '#clearFile', function(e) {
        e.preventDefault();
        clearFileSelection();
    });

    // Upload button click handler
    uploadBtn.click(function() {
        const file = fileInput[0].files[0];
        if (!file) {
            Swal.fire({
                title: 'Error',
                text: 'Please select a file to upload',
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Create form data
        const formData = new FormData();
        formData.append('excelFile', file);

        // Show progress container
        $('#uploadStatus').removeClass('hidden');
        $('#uploadStatusText').text('Preparing upload...');
        $('#uploadProgress').text('0%');
        $('#uploadProgressBar').css('width', '0%');

        // AJAX upload
        $.ajax({
            url: 'ajax/excel_events.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        $('#uploadProgressBar').css('width', percent + '%');
                        $('#uploadProgress').text(percent + '%');
                        $('#uploadStatusText').text(`Uploading... ${percent}%`);
                    }
                });
                return xhr;
            },
            success: function(response) {
                try {
                    // If response is already an object, use it directly
                    const result = typeof response === 'string' ? JSON.parse(response) : response;

                    if (result.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        let errorMessage = result.message || 'Upload failed';
                        if (result.errors && result.errors.length > 0) {
                            errorMessage += '\n\n' + result.errors.join('\n');
                        }
                        
                        Swal.fire({
                            title: 'Upload Failed',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                } catch (e) {
                    console.error('Parse error:', e);
                    console.error('Response:', response);
                    
                    Swal.fire({
                        title: 'Error',
                        text: 'Invalid server response format',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Upload error:', error);
                
                Swal.fire({
                    title: 'Upload Failed',
                    text: 'Failed to upload file: ' + error,
                    icon: 'error',
                    confirmButtonColor: '#3085d6'
                });
            },
            complete: function() {
                resetUploadForm();
            }
        });
    });

    // Helper functions
    function clearFileSelection() {
        fileInput.val('');
        fileLabel.addClass('hidden').empty();
        uploadBtn.prop('disabled', true)
                .addClass('opacity-50 cursor-not-allowed')
                .removeClass('hover:bg-blue-600');
    }

    function resetUploadForm() {
        $('#uploadStatus').addClass('hidden');
        $('#uploadProgressBar').css('width', '0%');
        $('#uploadProgress').text('0%');
        $('#uploadStatusText').text('');
        clearFileSelection();
        $('#excelUploadModal').modal('hide');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
  </script>
</body>

</html>