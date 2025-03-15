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
        name='viewport' />      <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

      <!--     Fonts and icons     -->
      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <!-- CSS Files --><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    <body class=""><div class="wrapper ">
    <?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
      <div class="content">
      <div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active text-blue-600 font-semibold" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">User Profile</a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                <div class="flex justify-center items-center my-6">
                    <div class="flex flex-col items-center">
                        <?php if (!empty($memberInfo['member_img'])): ?>
                            <img src="../uploaded/orgUploaded/<?= htmlspecialchars($memberInfo['member_img']); ?>" 
                                 alt="Profile Image" 
                                 class="w-24 h-24 rounded-full mb-4 border-2 border-gray-300"> 
                        <?php else: ?>
                            <img src="../../path/to/default/image.png" 
                                 alt="Default Profile Image" 
                                 class="w-24 h-24 rounded-full mb-4 border-2 border-gray-300"> 
                        <?php endif; ?>
                        <h2 class="text-lg font-semibold"><?= htmlspecialchars($memberInfo['name']); ?></h2>
                        <p class="text-gray-600"><?= htmlspecialchars($memberInfo['position']); ?></p>
                    </div>
                </div>

                <form id="editProfileForm" method="POST" action="update_profile.php" class="p-6">
                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="editor_id"> 
                    
                    <div class="mb-4">
                        <label for="editUsername" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="editUsername" name="username" value="<?php echo htmlspecialchars($memberInfo['username']); ?>" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="editName" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="editName" name="name" value="<?php echo htmlspecialchars($memberInfo['name']); ?>" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="editPosition" class="block text-sm font-medium text-gray-700">Position</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="editPosition" value="<?php echo htmlspecialchars($memberInfo['position']); ?>" name="position" required readonly>
                    </div>
                    <input type="hidden" id="editId" name="id" value="<?php echo htmlspecialchars($memberInfo['id']); ?>">
                    
                    <button type="button" class=" accountModalEdit mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200" data-toggle="modal" data-target="#accountModalEdit" data-id="<?= $memberInfo['id'] ?>">
                        Edit Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

      </div>
    </div>
  </div>
  <form class="row" action="" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="accountModalEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-lg shadow-lg overflow-hidden">
                <div class="modal-header bg-blue-600 text-white">
                    <h5 class="modal-title text-lg font-semibold" id="exampleModalLabel">Account Edit</h5>
                    <button type="button" class="close text-white hover:text-gray-300" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-6 bg-white">
                    <div id="profiledata">
                        <!-- Fetched data will be inserted here -->
                    </div>
                </div>
                <div class="modal-footer bg-gray-100">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition duration-200 px-4 py-2" value="Save" name="save_profile">
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