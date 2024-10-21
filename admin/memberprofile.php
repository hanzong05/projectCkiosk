<?php
include_once ('assets/header.php');

$memberInfo  = $obj->member_account();
 
if ($memberInfo) {
  // Now you can safely access array offsets
  $username = $memberInfo['username']; // Access username
  $name = $memberInfo['name']; // Access name
  // Add more fields as necessary
} else {
  // Handle the case when no record is found
  echo "No member account found. Please check your session ID.";
}
if (isset($_POST['save_profile'])) {
  $log_msg = $obj->save_profile($_POST);
}
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
          }

          /* Custom styles for radio buttons */
.requirement-list {
    list-style-type: none; /* Remove default list dots */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margin */
}

.requirement-list input[type="radio"] {
    display: none; /* Hide the default radio button */
}

.requirement-list label {
    position: relative;
    padding-left: 30px; /* Space for custom radio */
    cursor: pointer; /* Cursor changes to pointer on hover */
}

/* Custom radio button */
.requirement-list label:before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 20px; /* Adjust size */
    height: 20px; /* Adjust size */
    border: 2px solid #ddd; /* Border color when not checked */
    border-radius: 50%; /* Round shape */
    background-color: white; /* Background color */
    transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transition */
}

/* Styles for checked radio button */
.requirement-list input[type="radio"]:checked + label:before {
    background-color: green; /* Background color when checked */
    border-color: green; /* Border color when checked */
}

/* Styles for checked radio button's label text */
.requirement-list input[type="radio"]:checked + label {
    color: green; /* Change label color when checked */
    font-weight: bold; /* Make label bold when checked */
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
            <li class="active">
              <a href="./organization.php">
                <i class="nc-icon nc-caps-small"></i>
                <p>Campus Organization</p>
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
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="container-fluid p-0">
                  <hr>
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab"
                        aria-controls="account" aria-selected="true">User Profile</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    
                  <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                  <div class="d-flex justify-content-center align-items-center">
                  <div class="p-2 text-center">
                      <?php if (!empty($memberInfo['member_img'])): ?>
                          <img src="../uploaded/orgUploaded/<?=htmlspecialchars($memberInfo['member_img']); ?>" 
                              alt="Profile Image" 
                              class="img-fluid"
                              style="width: 100px; height: 100px; border-radius: 50%; margin-right: 10px;"> 
                      <?php else: ?>
                          <img src="../../path/to/default/image.png" 
                              alt="Default Profile Image" 
                              class="img-fluid"
                              style="width: 100px; height: 100px; border-radius: 50%; margin-right: 10px;"> 
                      <?php endif; ?>
                  </div>
              </div>


                </div>

                    </div>
                    <form id="editProfileForm" method="POST" action="update_profile.php">
                        <div class="form-group">
                          <label for="editUsername">Username</label>
                          <input type="text" class="form-control" id="editUsername" name="username" value="<?php echo htmlspecialchars($memberInfo['username']); ?>" required readonly>
                        </div>
                        <div class="form-group">
                          <label for="editName">Name</label>
                          <input type="text" class="form-control" id="editName" name="name" value="<?php echo htmlspecialchars($memberInfo['name']); ?>" required readonly>
                        </div>
                        <div class="form-group">
                          <label for="editPosition">Position</label>
                          <input type="text" class="form-control" id="editPosition" value="<?php echo htmlspecialchars($memberInfo['position']); ?>" name="position" required readonly>
                        </div>
                        <input type="hidden" id="editId" name="id" value="<?php echo htmlspecialchars($memberInfo['id']); ?>">
                        
                      </form>
                      <button class="btn accountModalEdit" data-toggle="modal" data-target="#accountModalEdit" data-id="<?= $memberInfo['id'] ?>">
            Edit Account
        </button>
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

  <form class="row" action="" method="post" enctype="multipart/form-data">
    <div class="modal fade bd-example-modal-lg" id="accountModalEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="profiledata">
                    <!-- Fetched data will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn" value="Save" name="save_profile">
                </div>
            </div>
        </div>
    </div>
</form>


  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1">
  </script><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
 


$('.accountModalEdit').on('click', function () {
        console.log("Edit Account button clicked."); // Log button click
        var accountID = $(this).data('id');
        
        // Check if accountID is present
        if (!accountID) {
            console.error("No account ID provided."); // Log error
            alert("No account ID provided."); // Optionally alert the user
            return; // Exit the function early
        }

        console.log("Fetching account ID: " + accountID); // Log account ID

        $.ajax({
            url: 'ajax/profiledata.php',
            type: 'post',
            data: { accountID: accountID },
            success: function (response) {
                console.log("Response: ", response); // Log the response
                $('#profiledata').html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + ": " + error);
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
            formData.append('type', 'membersaccount');

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
                            document.location = "membersmanagement.php"; // Redirect if successful
                        });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "There was an error adding the account.", "error");
            });
        }
    });


  // For the 'edit' account form
  $('#accountModalEdit form').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this);
    var isAdding = form.find('input[name="save_profile"]').length > 0;

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
</body>

</html>