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

   $editor_id = $_POST['editor_id'] ?? ''; // Get editor ID from POST data
    error_log("Editor ID: $editor_id"); // Log the editor ID

    ini_set('error_log', 'ajax/error_log.txt');

include_once ('assets/header.php');
if (isset($_POST['add_faqs'])) {
  $log_msg = $obj->add_faqs($_POST);
}

if (isset($_POST['save_faqs'])) {
  $log_msg = $obj->save_faqs($_POST);
}

if (isset($_REQUEST['did'])) {
  $log_msg = $obj->delete_faqs($_REQUEST['did']);
}


$allFaqs = $obj->show_faqs();
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

<body class=""><div class="wrapper ">
<?php include 'assets/includes/navbar.php'; ?>
      <div class="content">
      <div class="p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6">

            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex-grow mb-2 md:mb-0 md:mr-2">
                        <input type="text" id="searchFAQInput" placeholder="Search FAQs..." class="border border-gray-300 rounded-lg px-3 py-2 w-full text-base" onkeyup="searchFAQs()">
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#faqsModal">
    <i class="fas fa-plus"></i>
    Create FAQ
</button>

                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">No.</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Question</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Answer</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="faqTableBody">
                        <?php
                        $count = 1;
                        foreach ($allFaqs as $row) {
                        ?>
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600"><?php echo $count; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo $row["faqs_question"]; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-800"><?php echo $row["faqs_answer"]; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex justify-center gap-2">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition duration-200 faqModalEdit" 
        data-toggle="modal" data-target="#faqsModalEdit" 
        data-id="<?= $row['faqs_id'] ?>">
    <i class="fas fa-edit"></i>
</button>
                                    <a class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition duration-200 btn-delete" 
   href='faqs.php?did=<?= $row['faqs_id'] ?>'>
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

  <!-- add event pop up -->
  <form id="faqForm" class="row" action="" method="post">
  <input type="hidden" value="<?= $_SESSION['aid'] ?>" name="uid">
  <input type="hidden" value="<?= $_SESSION['id'] ?>" name="cid">



    <div class="modal fade bd-example-modal-lg" id="faqsModal" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Campus Faqs Creation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="faqs_question" class="form-label fw-bold">Question</label>
              <textarea type="text" id="faqs_question" class="form-control" name="faqs_question" required></textarea>
            </div>
            <div class="mb-3">
              <label for="faqs_answer" class="form-label fw-bold">Answer</label>
              <textarea type="text" id="faqs_answer" class="form-control" name="faqs_answer" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" class="btn" value="Add" name="add_faqs">
          </div>
        </div>
      </div>
    </div>
  </form>

<form id="editfaqsform" class="row" action="" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?= $_SESSION['id'] ?>" name="editor_id"> 
   <div class="modal fade bd-example-modal-lg" id="faqsModalEdit" tabindex="-1" role="dialog" data-backdrop="static"
      data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
      
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Campus Faqs Edit</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body" id="faqsData">
               <!-- Content here -->
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <input type="submit" class="btn" value="Save" name="save_faqs">
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
  <script>function searchFAQs() {
    const input = document.getElementById('searchFAQInput');
    const filter = input.value.toLowerCase();
    const tableBody = document.getElementById('faqTableBody');
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
</script>
  <script type="text/javascript">
    $(document).on('click', '.btn-delete', function (e) {
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


$(document).ready(function() {
    // Fix for edit button click event
    $('.faqModalEdit').on('click', function() {
        var faqsID = $(this).data('id');
        
        // Log for debugging
        console.log('Edit button clicked for FAQ ID:', faqsID);
        
        // Make sure we're targeting the correct modal ID
        $('#faqsModalEdit').modal('show');
        
        // Fetch the FAQ data
        $.ajax({
            url: 'ajax/faqsData.php',
            type: 'post',
            data: { faqsID: faqsID },
            success: function(response) {
                // Add response in Modal body
                $('#faqsData').html(response);
                
                // Initialize Summernote for the loaded content if needed
                $('#edit_faqs_question, #edit_faqs_answer').summernote({
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
                alert('Error loading FAQ data. Please try again.');
            }
        });
    });
});
    $(document).ready(function () {
      $('#myTable').DataTable();
      $('#faqs_question').summernote({
        height: 180,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']]
        ]
      });
      $('#faqs_answer').summernote({
        height: 180,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']]
        ]
      });
      $('.faqsModalEdit').on('click', function () {
        var faqsID = $(this).data('id');
        $.ajax({
          url: 'ajax/faqsData.php',
          type: 'post',
          data: { faqsID: faqsID },
          success: function (response) {
            // Add response in Modal body
            $('#faqsData').html(response);
          }
        });
      });
       $(document).on('click', '.btn-delete', function (e) {
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
// Handle form submission for FAQs
document.getElementById('faqForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this FAQ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, add it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(this);
            formData.append('type', 'faqs'); // Ensure type parameter is included

            fetch('../admin/ajax/createData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire("Added!", result.message, "success").then(() => {
                        window.location.href = "faqs.php"; // Redirect to the FAQs page
                    });
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire("Error!", "There was an error adding the FAQ.", "error");
            });
        }
    });
});
$('#editfaqsform').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this FAQ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(this); // Create FormData from the form element
            formData.append('type', 'faq');  // Add type to FormData

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
                Swal.fire("Error!", "There was an error saving the FAQ.", "error");
                console.error("Error:", error); // Keep error logging for debugging
            });
        }
    });
});
    });
  </script>
  
</body>

</html>