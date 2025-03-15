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
if (isset($_POST['add_org'])) {
  $log_msg = $obj->add_org($_POST);
}

if (isset($_POST['save_org'])) {
  $log_msg = $obj->save_org($_POST);
}


if (isset($_POST['add_account'])) {
  $log_msg = $obj->add_account($_POST);
}

if (isset($_POST['save_membersaccount'])) {
  $log_msg = $obj->save_membersaccount($_POST);
}

if (isset($_REQUEST['aid'])) {
  $log_msg = $obj->delete_membersaccount($_REQUEST['aid']);
}
$allAccount = $obj->show_membersaccount();
if (!is_array($allAccount)) {
  $allAccount = []; // Ensure it's an array
}


include_once ('../class/connection.php');
$query = "SELECT users_org FROM users_tbl WHERE users_id = :user_id";
$stmt = $connect->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['aid'], PDO::PARAM_INT);
$stmt->execute();

// Initialize a variable for users_org
$users_org = null;

if ($stmt->rowCount() == 1) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $users_org = htmlspecialchars($row['users_org']); // Escape for safety
} else {
    // Handle the case where no organization is found (optional)
    $users_org = '';
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
      <!--     Fonts and icons     -->  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

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
         .dot {
    height: 10px;
    width: 10px;
    background-color: green;
    border-radius: 50%;
    display: inline-block;
    margin-left: 5px; /* Space between name and dot */
  }
  .last-active {
    margin-left: 10px; /* Optional: Adds space between the dot and last active */
    font-size: 0.9em; /* Smaller font size for last active */
    color: #666; /* Gray color for last active */
  }
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
      </style>

    </head>

    <body class=""><div class="wrapper ">
    <?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
      <div class="content"><div class="p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6">
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                        <input type="text" id="searchAccountInput" placeholder="Search accounts..." 
                               class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchAccounts()">
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" 
                            data-toggle="modal" data-target="#accountModal">
                        <i class="fas fa-plus"></i>
                        Create Account
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden" id="myTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">No.</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Username</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Name</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Position</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $count = 1;
                        foreach ($allAccount as $row) {
                        ?>
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $count; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $row["username"]; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $row["name"]; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $row["position"]; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition duration-200 accountModalEdit" 
                                        data-toggle="modal" data-target="#accountModalEdit" 
                                        data-id="<?= $row['id'] ?>">
                                    Edit
                                </button>
                                <a class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition duration-200" 
                                   href='membersmanagement.php?aid=<?= $row['id'] ?>'>
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
  
  <form id="accountForm" class="row" action="your_upload_script.php" method="post" enctype="multipart/form-data">
    <!-- Modal --> <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
  <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid"> 
    <div class="modal fade bd-example-modal-lg" id="accountModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Creation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" id="name" class="form-control" name="name" required>
                    </div>
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
                        <label for="position" class="form-label fw-bold">Position</label>
                        <input type="text" name="position" id="position" class="form-control" placeholder="Enter a position" required>
                    </div>

                    <div class="mb-3">
                        <label for="org_image" class="form-label fw-bold">Profile Image</label>
                        <input type="file" id="org_image" class="form-control" name="org_image" accept="image/*" required>
                    </div>
                    <!-- Hidden input field for org_type -->
                    <input type="hidden" name="org" value="<?php echo htmlspecialchars($users_org); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add" name="add_account">
                </div>
            </div>
        </div>
    </div>
</form>



<!-- Edit Account Modal -->
<form class="row" action="" method="post">
    <div class="modal fade bd-example-modal-lg" id="accountModalEdit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="EditMembersData">
                    <!-- Fetched data will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn" value="Save" name="save_membersaccount">
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
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1">
  </script><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
<script>
  // Define the search function in the global scope
  function searchAccounts() {
    const input = document.getElementById('searchAccountInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('myTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header
      const cells = rows[i].getElementsByTagName('td');
      let match = false;

      // Check each cell for the search term
      for (let j = 0; j < cells.length; j++) {
        if (cells[j]) {
          const cellText = cells[j].textContent || cells[j].innerText;
          if (cellText.toLowerCase().indexOf(filter) > -1) {
            match = true;
            break; // Exit loop if a match is found
          }
        }
      }

      // Toggle row visibility based on match
      rows[i].style.display = match ? "" : "none";
    }
  }
</script>


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
            url: 'ajax/EditMembersData.php',
            type: 'post',
            data: { accountID: accountID },
            success: function (response) {
                console.log("Response: ", response); // Log the response
                $('#EditMembersData').html(response);
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
    var isAdding = form.find('input[name="save_membersaccount"]').length > 0;

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
});
</script>
</body>

</html>