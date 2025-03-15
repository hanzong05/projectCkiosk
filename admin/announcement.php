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
if (isset($_POST['add_announcement'])) {
  $log_msg = $obj->add_announcement($_POST);
}

if (isset($_POST['save_announcement'])) {
  $log_msg = $obj->save_announcement($_POST);
}
if (isset($_REQUEST['archive_id'])) {
  $log_msg = $obj->archive_announcement($_REQUEST['archive_id']);
}
if (isset($_REQUEST['restore_id'])) {
    $log_msg = $obj->restore_announcement($_REQUEST['restore_id']);
  }

  if (isset($_REQUEST['delete_id'])) {
    $log_msg = $obj->delete_announcement($_REQUEST['delete_id']);
  }
$allAnnouncement = $obj->show_announcement();

$archived = $obj->show_archived_announcements();


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

    <!-- Other head elements -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
  <style>
    .existing-images {
        display: flex;
        gap: 10px;
        align-items: center;
        overflow-x: auto;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        flex-wrap: wrap;  /* Allow wrapping on smaller screens */
        justify-content: flex-start;  /* Ensure images are aligned at the start */
    }

    .image-preview-container-edit {
        width: 120px;
        text-align: center;
        flex-shrink: 0;
        margin-bottom: 10px;
        flex-basis: 120px; /* Ensures consistent size */
    }

    .image-preview-container-edit img {
        width: 100%;  /* Makes the image responsive */
        height: auto;  /* Maintain aspect ratio */
        max-width: 150px; /* Limits the size */
        max-height: 150px; /* Limits the size */
    }

    /* Make adjustments for small screens */
    @media (max-width: 768px) {
        .existing-images {
            justify-content: center;  /* Center images on smaller screens */
        }

        .image-preview-container-edit {
            width: 100px; /* Slightly smaller width for small screens */
        }

        .image-preview-container-edit img {
            max-width: 120px; /* Smaller image size on small screens */
            max-height: 120px;
        }
    }

    @media (max-width: 480px) {
        .image-preview-container-edit {
            width: 80px; /* Even smaller width for very small screens */
        }

        .image-preview-container-edit img {
            max-width: 100px; /* Smaller image size */
            max-height: 100px;
        }
    }
</style>
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
    <?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="p-6">
    
<div class="p-6">
<div class="bg-white rounded-lg shadow-lg">
    <div class="p-6">
        <ul class="nav nav-tabs" id="announcementTabs">
            <li class="nav-item">
                <a class="nav-link active" id="active-tab" data-toggle="tab" href="#activeAnnouncements" role="tab">Active Announcements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="archived-tab" data-toggle="tab" href="#archivedAnnouncements" role="tab">Archived Announcements</a>
            </li>
        </ul>

        <!-- Active Announcements Section -->
        <div class="tab-content" style="padding-top:3%;"> 
            <div class="tab-pane fade show active" id="activeAnnouncements" role="tabpanel">

                <!-- Search and Create Announcement -->
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                            <input type="text" id="searchAnnouncementInput" placeholder="Search announcements..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchAnnouncements()">
                        </div>

                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#announcementModal">
                            <i class="fas fa-plus"></i>
                            Create Announcement
                        </button>
                    </div>
                </div>

                <!-- Active Announcements Table -->
              <!-- Active Announcements Table -->
<div class="overflow-x-auto">
<table id="activeAnnouncementsTable" class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Organization</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated By</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200" id="announcementTableBody">
        <?php
        $count = 1;
        foreach ($allAnnouncement as $row) {
            echo '<tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.$count.'</td>
                <td class="px-6 py-4 text-sm text-gray-800 max-w-md"><div class="line-clamp-2">'.$row["announcement_title"].'</div></td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.($row["org_name"] ?? 'N/A').'</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.date('F d, Y H:i:s', strtotime($row["created_at"] ?? 'N/A')).'</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.($row["creator_name"] ?? 'N/A').'</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.($row["updated_by_name"] ?? 'Not yet updated').'</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">';
                
                // Check if updated_at is NULL or empty, then display "Not yet updated"
                if (isset($row["updated_at"]) && !empty($row["updated_at"])) {
                    echo date('F d, Y H:i:s', strtotime($row["updated_at"]));
                } else {
                    echo 'Not yet updated';
                }

            echo '</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                    <div class="flex justify-center gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition duration-200 announcementModalEdit"
                            data-toggle="modal" data-target="#announcementModalEdit" data-id="'.$row['announcement_id'].'">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition duration-200"
                            href="announcement.php?archive_id='.$row['announcement_id'].'">
                            <i class="fas fa-archive"></i>
                        </a>
                    </div>
                </td>
            </tr>';
            $count++;
        }
        ?>
    </tbody>
</table>
</div>

            </div>

            


<!-- Archived Announcements Section -->
<div class="tab-pane fade" id="archivedAnnouncements" role="tabpanel">
<div class="flex justify-between items-center mb-4">
        <!-- Left: Title -->
        <h5 class="mt-3">Archived Announcements</h5>

        <!-- Right: Date Filter -->
        <div class="flex items-center">
            <label for="dateFilter" class="text-sm text-gray-700 mr-3">Filter by Date:</label>
            <input type="date" id="dateFilter" class="px-3 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="YYYY-MM-DD">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="archivedAnnouncementsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Archived At</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php
                // Assuming $archivedAnnouncements is defined and contains data
                $archiveCount = 1;
                foreach ($archived as $archiveRow) {
                    echo '<tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.$archiveCount.'</td>
                        <td class="px-6 py-4 text-sm text-gray-800"><div class="line-clamp-2">'.$archiveRow["announcement_title"].'</div></td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">'.date('Y-m-d', strtotime($archiveRow["archived_at"] ?? 'N/A')).'</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <a class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition duration-200 btn-restore"
                            href="announcement.php?restore_id='.$archiveRow['announcement_id'].'">
                            <i class="fas fa-undo"></i>
                            </a>
                            <a class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition duration-200 btn-delete"
                            href="announcement.php?delete_id='.$archiveRow['announcement_id'].'">
                            <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>';
                    $archiveCount++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Script for Date Filter -->

        </div>
    </div>
</div>

      </div>
    </div>
  </div>
  <form id="addAnnouncementForm" class="row" action="" method="post" enctype="multipart/form-data">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="announcementModal" tabindex="-1" role="dialog"
         data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Announcement Creation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">'
                        <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid">'
                        <label for="announcement_title" class="form-label fw-bold">Announcement Title</label>
                        <input type="text" class="form-control" id="announcement_title" name="announcement_title" required>
                    </div>
                    <div class="form-group mb-3">
        <label for="editAnnouncementCategory">Category</label>
        <select class="form-control" id="editAnnouncementCategory" name="announcement_category" required>
            <option value="">Select Category</option>
            <option value="academic">Academic</option>
            <option value="event">Events</option>
            <option value="org">Organizations</option>
            <option value="general">General</option>
        </select>
    </div>
                    <div class="mb-3">
                        <label for="announcement_details" class="form-label fw-bold">Announcement Details</label>
                        <textarea id="summernote" name="announcement_details" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ann_img" class="form-label fw-bold">Photos</label>
                        <div id="image-upload-container" class="d-flex" style="max-height: 200px; overflow-x: auto; overflow-y: hidden; white-space: nowrap; border: 1px solid #ccc; padding: 5px;">
                            <!-- Dynamic Image Previews will be appended here -->
                        </div>
                        <button type="button" class="btn btn-primary mt-2" id="add-image" style="float: right;">Add Photo</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn" value="Create" name="add_announcement">
                </div>
            </div>
        </div>
    </div>
    </form>

    <form id="editannouncementForm" class="row" action="ajax/editData.php" method="post" enctype="multipart/form-data">
        <div class="modal fade bd-example-modal-lg" id="announcementModalEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Announcement Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="announcementData">
                        <input type="hidden" name="aid" id="announcementId" value="">
                        <input type="hidden" name="previous_images" id="previousImages" value="">
                        <div class="form-group">
                        <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
                        <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid">
                            <label for="announcementDetails">Details</label>
                            <textarea class="form-control" id="announcementDetails" name="announcement_details"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="annImg">Images</label>
                            <div id="currentImagesContainer"></div>
                            <input type="file" class="form-control-file" id="annImg" name="ann_imgs[]" multiple>
                            <button type="button" id="addImageBtn" class="btn btn-secondary mt-2">Add More Images</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  <script>
  
  $(document).ready(function() {
    var table = $('#archivedAnnouncementsTable').DataTable({
        paging: true,
        searching: false,  // Disable general search, since we're using a date filter
        ordering: true,
        responsive: true
    });

    // Date filter functionality
  
}); $(document).ready(function() {
        $('#activeAnnouncementsTable').DataTable({
            "paging": true,
            "searching": false,
            "ordering": true,
            "info": true
        });
    });

// Filter functionality for the Date Filter input
document.getElementById("dateFilter").addEventListener("input", function () {
    const filterDate = this.value;
    const rows = document.querySelectorAll("#archivedAnnouncementsTable tbody tr");

    rows.forEach(row => {
        const archivedDateCell = row.cells[2]; // Assuming the date is in the 3rd column (index 2)
        const archivedDate = archivedDateCell.textContent.trim();

        if (filterDate && archivedDate !== filterDate) {
            row.style.display = "none"; // Hide rows that don't match the filter
        } else {
            row.style.display = ""; // Show rows that match the filter
        }
    });
});

    function searchAnnouncements() {
        const input = document.getElementById('searchAnnouncementInput').value.toLowerCase();
        const rows = document.querySelectorAll('#announcementTableBody tr');

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

 // Handle adding new image previews
 $('#addImageBtn').click(function () {
        const newImagePreview = `
            <div class="image-preview-container">
                <input type="file" class="form-control" name="ann_imgs[]" accept=".jpg, .jpeg, .png, .gif" onchange="previewImage(event, this)" multiple>
                <img src="" alt="Image Preview" class="image-preview">
                <button type="button" class="btn btn-danger remove-input" style="margin-top: 5px;">Remove File Input</button>
            </div>`;
        $('#currentImagesContainer').append(newImagePreview);
    });

    // Preview the image
    window.previewImage = function(event, input) {
        const preview = $(input).siblings('.image-preview');
        const removeInputButton = $(input).siblings('.remove-input');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
                $(input).hide(); // Hide the file input after selection
                removeInputButton.show(); // Show the Remove File Input button
            };
            reader.readAsDataURL(file);
        }
    };

    // Remove the file input container
    $(document).on('click', '.remove-input', function() {
        $(this).closest('.image-preview-container').remove(); // Remove the input container
    });

    $(document).ready(function () {
    // Handle adding new image previews
    $('#add-image').click(function () {
        // Create a new image preview container with an input field
        const newImagePreview = `
            <div class="image-preview-container" style="position: relative; margin-right: 10px; margin-bottom: 10px; display: inline-block;">
                <input type="file" class="form-control" name="ann_img[]" accept=".jpg, .jpeg, .png, .gif" onchange="previewImage(event, this)">
                <img src="" alt="Image Preview" class="image-preview" style="display:none; width: 100px; height: 100px; object-fit: cover; margin-top: 5px;">
                <div class="button-container" style="margin-top: 5px; display: flex; gap: 5px;">
                    <button type="button" class="btn btn-secondary edit-image" style="display:none;">Edit</button>
                    <button type="button" class="btn btn-danger remove-image" style="display:none;">Remove</button>
                </div>
                <button type="button" class="btn btn-danger remove-input" style="margin-top: 5px;">Remove File Input</button>
            </div>`;
        $('#image-upload-container').append(newImagePreview);
    });

    // Preview the image and show the remove button
    window.previewImage = function(event, input) {
        const preview = $(input).siblings('.image-preview');
        const removeButton = $(input).siblings('.button-container').find('.remove-image');
        const editButton = $(input).siblings('.button-container').find('.edit-image');
        const removeInputButton = $(input).siblings('.remove-input');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
                removeButton.show(); // Show the Remove button
                editButton.show(); // Show the Edit button
                $(input).hide(); // Hide the file input after selection
                removeInputButton.hide(); // Hide the Remove File Input button
            };
            reader.readAsDataURL(file);
        }
    };

    // Remove image preview and associated elements
    $(document).on('click', '.remove-image', function() {
        const container = $(this).closest('.image-preview-container');
        container.remove(); // Remove the entire container
    });

    // Remove the file input container
    $(document).on('click', '.remove-input', function() {
        $(this).closest('.image-preview-container').remove();
    });
});

</script>
  <script type="text/javascript">
    
    $(document).ready(function () {
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

      $('.btn-archive').on('click', function (e) {
    e.preventDefault(); // Prevent default link behavior
    var archiveUrl = $(this).attr('href'); // Get the href attribute of the clicked link

    Swal.fire({
        title: 'Are you sure?',
        text: "This announcement will be archived!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, archive it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = archiveUrl; // Redirect to the archive URL
        }
    });
});   
$('.btn-restore').on('click', function (e) {
    e.preventDefault(); // Prevents the default link action
    var restoreUrl = $(this).attr('href'); // Gets the restore URL

    Swal.fire({
        title: 'Are you sure?',
        text: "This announcement will be restored!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = restoreUrl; // Redirect to the restore URL
        }
    });
});
$('.btn-delete').on('click', function (e) {
    e.preventDefault(); // Prevent default link action
    var deleteUrl = $(this).attr('href'); // Get the href attribute for delete URL

    Swal.fire({
        title: 'Are you sure?',
        text: "This announcement will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = deleteUrl; // Redirect to delete URL if confirmed
        }
    });
});

$('.announcementModalEdit').on('click', function () {
        var announcementID = $(this).data('id');
        $.ajax({
          url: 'ajax/announcementData.php',
          type: 'post',
          data: { announcementID: announcementID },
          success: function (response) {
            // Add response in Modal body
            $('#announcementData').html(response);
          }
        });
      });

      $("#ann_img").change(function () {
        var fileExtension = ['jpg', 'png', 'jpeg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          alert("Only formats are allowed : " + fileExtension.join(', '));
          $("#ann_img").val('');
        }
      });
      
      document.getElementById('addAnnouncementForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Validate files before proceeding
    if (!$("#annImg, .image-upload-row input[type='file']").change()) {
        return; // Stop if validation fails
    }

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this announcement?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(this);
            formData.append('type', 'announcement');

            fetch("../admin/ajax/createData.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire("Saved!", result.message, "success").then(() => location.reload());
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire("Error!", "There was an error saving the announcement.", "error");
            });
        }
    });
});$('#editannouncementForm').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this announcement?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(this); // Create FormData from the form element
            formData.append('type', 'announcement');  // Add type to FormData

            // Debugging FormData to check contents
            for (var pair of formData.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }

            fetch("../admin/ajax/editData.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire("Saved!", result.message, "success").then(() => {
                        location.reload(); // Optionally reload the page after success
                    });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "There was an error saving the announcement.", "error");
            });
        }
    });
});

    
    $('#editannouncementForm').on('focusin', function() {
    $(this).removeAttr('aria-hidden');
});

$('#editannouncementForm').on('focusout', function() {
    // Optionally set it back to "true" when focus leaves
    $(this).attr('aria-hidden', 'true');
});

const table = document.querySelector('#myTable');
table.parentElement.style.overflowX = 'auto';
    });
  </script>
</body>

</html>