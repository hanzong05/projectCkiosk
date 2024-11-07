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

$allAnnouncement = $obj->show_announcement();


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
                    <li class="active">
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
      <div class="content">
        <div class="p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6">
          
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



            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
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
                            error_log("Displaying announcement ID: " . $row['announcement_id'], 3, 'error_log.txt');
                        ?>
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $count; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800 max-w-md">
                                <div class="line-clamp-2"><?php echo $row["announcement_title"]; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $row["org_name"] ?? 'N/A'; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo date('F d, Y H:i:s', strtotime($row["created_at"] ?? 'N/A')); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $row["creator_name"] ?? 'N/A'; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $row["updated_by_name"] ?? 'Not yet updated'; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo date('F d, Y H:i:s', strtotime($row["updated_at"] ?? 'N/A')); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition duration-200 announcementModalEdit" 
                                            data-toggle="modal" data-target="#announcementModalEdit" 
                                            data-id="<?= $row['announcement_id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition duration-200" 
                                       href='announcement.php?archive_id=<?= $row['announcement_id'] ?>'>
                                        <i class="fas fa-archive"></i>
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
                        <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
                        <label for="announcement_title" class="form-label fw-bold">Announcement Title</label>
                        <input type="text" class="form-control" id="announcement_title" name="announcement_title" required>
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
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  <script>
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
});


        // Handle the removal of images
        $(document).on('click', '.remove-image', function () {
            $(this).closest('.image-container').remove();
        });

        let addedImages = [];
let removedImages = [];
let replacedImages = [];
// Handle image preview (upload new images)
window.handleImagePreview = function(event, input) {
    const container = $(input).closest('.image-preview-container-edit');
    const preview = container.find('.announcement-image');
    const oldImagePath = preview.attr('src').split('/').pop();
    const removeButton = container.find('.remove-image');
    const editButton = container.find('.edit-image');

    const file = input.files[0];
    if (file) {
        // Add the old image filename to the removed images input
        if (oldImagePath) {
            const removedImagesInput = $('#removed-images');
            let removedImagesVal = removedImagesInput.val();
            if (removedImagesVal) {
                removedImagesVal += ','; 
            }
            removedImagesVal += oldImagePath;
            removedImagesInput.val(removedImagesVal);
        }

        // Display the new image
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
            removeButton.show();
            editButton.show();
            $(input).hide();

            // Save the image filename to the addedImages array
            const fileName = file.name;
            addedImages.push(fileName);

            // Log the arrays for debugging
            console.log('Added images:', addedImages);
            console.log('Replaced images:', replacedImages);
            console.log('Removed images:', removedImages);
        };
        reader.readAsDataURL(file);
    }
};

// Handle image removal
$(document).on('click', '.remove-image', function () {
    const container = $(this).closest('.image-preview-container-edit');
    const imagePath = container.find('.announcement-image').attr('src').split('/').pop();
    container.remove();

    const removedImagesInput = $('#removed-images');
    let removedImagesVal = removedImagesInput.val();
    if (removedImagesVal) {
        removedImagesVal += ','; 
    }
    removedImagesVal += imagePath;
    removedImagesInput.val(removedImagesVal);
});


$('#editannouncementForm').on('submit', function (e) {
    e.preventDefault();
    const form = $(this);
    const submitButton = form.find('button[type="submit"]');
    submitButton.prop('disabled', true);

    const formData = new FormData(this);
    formData.append('type', 'announcement');
    
    // Append added and removed images as JSON strings
    if (addedImages.length > 0) {
        formData.append('added_images', JSON.stringify(addedImages));
    }
    if (removedImages.length > 0) {
        formData.append('removed_images', JSON.stringify(removedImages));
    }

    // Append actual image files (added and replaced) to FormData
    for (let i = 0; i < addedImages.length; i++) {
        const fileInput = form.find('input[type="file"]')[i]; // Assuming one file input per image
        if (fileInput && fileInput.files[0]) {
            formData.append('added_images_files[]', fileInput.files[0]); // Append each file
        }
    }

    // Append replaced images file data
    if (replacedImages.length > 0) {
        replacedImages.forEach(function(image) {
            // Assuming image object contains a 'file' key for the new file
            if (image.file) {
                formData.append('replaced_images_files[]', image.file); // Append the new file
            }
        });
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
            fetch("../admin/ajax/editData.php", {
                method: "POST",
                body: formData // Send FormData (which includes the file)
            })
            .then(response => response.json())
            .then(result => {
                submitButton.prop('disabled', false);
                if (result.success) {
                    Swal.fire("Saved!", result.message, "success").then(() => location.reload());
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                submitButton.prop('disabled', false);
                Swal.fire("Error!", "There was an error saving the announcement: " + error.message, "error");
            });
        } else {
            submitButton.prop('disabled', false);
        }
    });
});



const table = document.querySelector('#myTable');
table.parentElement.style.overflowX = 'auto';
    });
  </script>
</body>

</html>