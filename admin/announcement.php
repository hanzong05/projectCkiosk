<?php
include_once ('assets/header.php');

if (isset($_POST['add_announcement'])) {
  $log_msg = $obj->add_announcement($_POST);
}

if (isset($_POST['save_announcement'])) {
  $log_msg = $obj->save_announcement($_POST);
}
if (isset($_REQUEST['did'])) {
  $log_msg = $obj->delete_announcement($_REQUEST['did']);
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
  <!--     Fonts and icons     -->
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
    <ul class="nav">
      <li >
        <a href="./dashboard.php">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="active">
        <a href="./announcement.php">
          <i class="nc-icon nc-diamond"></i>
          <p>Announcement</p>
        </a>
      </li>
      <?php if ($account_type == '1') { ?>
        <li>
          <a href="./schoolcalendar.php">
            <i class="nc-icon nc-pin-3"></i>
            <p>School Calendar</p>
          </a>
        </li>
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
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="container-fluid p-0">
                  <!-- <h1 class="h3 mb-3"><strong>Announcement</strong></h1> -->
                  <hr>
                  <div class="d-flex justify-content-between">
                    <div class="p-2">
                      <button class="btn text-end" data-toggle="modal" data-target="#announcementModal">
                        Create Announcement
                      </button>
                    </div>
                  </div><table class="table table-light table-hover table-bordered" id="myTable">
    <thead>
        <th><center>NO.</center></th>
        <th><center>DETAILS</center></th>
        <th><center>AUTHOR</center></th> <!-- Represents the announcement creator -->
        <th><center>ORG NAME</center></th> <!-- Shows the organization name -->
        <th><center>UPDATED BY</center></th> <!-- Shows who updated the announcement -->
        <th><center>ACTION</center></th>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($allAnnouncement as $row) {
            ?>
            <tr class="table-row">
                <td><?php echo $count; ?></td>
                <td class="ellipsis" style="width:30%;">
                    <span><?php echo htmlspecialchars($row["announcement_details"], ENT_QUOTES, 'UTF-8'); ?></span>
                </td>
                <td><?php echo htmlspecialchars($row["author_name"], ENT_QUOTES, 'UTF-8'); ?></td> <!-- Creator (username) -->
                <td><?php echo htmlspecialchars($row["org_name"] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td> <!-- Organization Name -->
                <td><?php echo htmlspecialchars($row["updated_by_name"] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td> <!-- Updated By -->
                <td class="text-center">
                    <button class="btn announcementModalEdit" data-toggle="modal"
                            data-target="#announcementModalEdit" data-id="<?= htmlspecialchars($row['announcement_id'], ENT_QUOTES, 'UTF-8') ?>">
                        Edit
                    </button>
                    <a class="btn btn-danger btn-delete" href='announcement.php?did=<?= htmlspecialchars($row['announcement_id'], ENT_QUOTES, 'UTF-8') ?>'>
                        Delete
                    </a>
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

  <!-- add announcement pop up -->
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
              <label for="announcement_details" class="form-label fw-bold">Announcement Details</label>
              <textarea id="summernote" name="announcement_details" id="announcement_details" required></textarea>
            </div>
            <div class="mb-3">
              <label for="ann_img" class="form-label fw-bold">Photo</label>
              <input type="file" class="form-control" name="ann_img" id="ann_img">
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

  <!-- Edit Announcement Modal -->
<form id="editannouncementForm" class="row" action="" method="post" enctype="multipart/form-data">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="announcementModalEdit" tabindex="-1" role="dialog"
        data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Announcement Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="announcementData">
                    <!-- Example fields -->
                    <input type="hidden" name="aid" id="announcementId" value="">
                    <input type="hidden" name="previous_image" id="previousImage" value="">
                    <div class="form-group">
                        <label for="announcementDetails">Details</label>
                        <textarea class="form-control" id="announcementDetails" name="announcement_details"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="annImg">Image</label>
                        <input type="file" class="form-control-file" id="annImg" name="ann_img">
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

      $('.btn-delete').on('click', function (e) {
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
    e.preventDefault(); // Prevent the default form submission
    
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
            formData.append('type', 'announcement'); // Add type parameter to FormData

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
                    "There was an error saving the announcement.",
                    "error"
                );
            });
        }
    });
});

$('#editannouncementForm').on('submit', function (e) {
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

            // Debugging FormData
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ', '+ pair[1]); 
            }

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
                Swal.fire("Error!", "There was an error saving the announcement.", "error");
            });
        }
    });
});


    });
  </script>
</body>

</html>