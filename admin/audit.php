<?php
 include_once ('assets/header.php');
$allaudit = $obj->show_audit_trail();
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- CSS Files -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="assets/css/css.css" rel="stylesheet" />
  <style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }/* Custom scrollbar styles */
.scrollbar-thin {
    scrollbar-width: thin; /* For Firefox */
}

.scrollbar-thin::-webkit-scrollbar {
    width: 8px; /* For Chrome, Safari and Opera */
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background-color: #3b82f6; /* Tailwind blue-400 */
    border-radius: 10px; /* Rounded corners */
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: #e5e7eb; /* Tailwind gray-200 */
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
                    <li>
                        <a href="./announcement.php">
                            <i class="fas fa-bullhorn"></i>
                            <p>Announcement</p>
                        </a>
                    </li>
                    <li>
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
                        <li  class="active">
                            <a  href="./audit.php">
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
                        <a class="navbar-brand" href="javascript:;">Audit Trails</a>
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
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
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
    <div class="container mx-auto px-4 py-8">
        <!-- Modal -->
        <div id="auditModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-full max-w-2xl mx-4 transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Audit Details</h3>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="modalContent" class="space-y-4">
                        <!-- Modal content will be inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-4xl mx-auto bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">System Audit Trail</h2>
                <div class="overflow-y-auto h-72 scrollbar-thin scrollbar-thumb-blue-400 scrollbar-thumb-rounded-lg scrollbar-track-gray-200">
                    <!-- Fixed height with scroll -->
                    <div class="space-y-4">
                        <?php
                        if (!empty($allaudit)) {
                            foreach ($allaudit as $index => $log) {
                                // Determine the icon and color based on the message
                                $icon = '';
                                $iconColor = 'text-blue-500'; // Default color
                                if (strpos($log['message'], 'add') !== false) {
                                    $icon = 'fas fa-plus-circle'; // Add icon
                                    $iconColor = 'text-green-500'; // Green color for add
                                } elseif (strpos($log['message'], 'edit') !== false) {
                                    $icon = 'fas fa-edit'; // Edit icon
                                    $iconColor = 'text-yellow-500'; // Yellow color for edit
                                } elseif (strpos($log['message'], 'delete') !== false) {
                                    $icon = 'fas fa-trash-alt'; // Delete icon
                                    $iconColor = 'text-red-500'; // Red color for delete
                                } else {
                                    $icon = 'fas fa-info-circle'; // Default icon
                                }
                        ?>
                                <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150 cursor-pointer"
                                    onclick="showAuditDetails(<?php echo htmlspecialchars(json_encode($log)); ?>, <?php echo $index + 1; ?>)">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center"> <!-- Adjusted circle size -->
                                            <i class="<?php echo $icon . ' ' . $iconColor . ' fa-2x'; ?>"></i> <!-- Large icon size -->
                                        </div>
                                    </div>

                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <span class="text-sm text-gray-500">
                                                    <?php 
                                                    $date = new DateTime($log['created_at']);
                                                    echo $date->format('F j, Y g:i A'); 
                                                    ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <?php
                                            $message = $log['message'];
                                            // Split the message at the first colon
                                            $parts = explode(':', $message, 2);
                                            if (count($parts) > 1) {
                                                echo '<p class="text-gray-700">';
                                                echo '<span class="font-medium text-blue-600">' . htmlspecialchars($parts[0]) . ':</span>';
                                                echo htmlspecialchars($parts[1]);
                                                echo '</p>';
                                            } else {
                                                echo '<p class="text-gray-700">' . htmlspecialchars($message) . '</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-history mb-3 text-2xl"></i>
                                <p>No audit trail records found</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-lg flex justify-between items-center">
                <p class="text-sm text-gray-600">
                    Total Records: <?php echo count($allaudit ?? []); ?>
                </p>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i> 
                    Last Updated: <?php echo date('Y-m-d H:i:s'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</body>


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
function showAuditDetails(log, index) {
    const modal = document.getElementById('auditModal');
    const modalContent = document.getElementById('modalContent');
    
    const date = new Date(log.created_at);
    const formattedDate = date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });

    // Process the message to style text before colon
    let messageContent = '';
    const messageParts = log.message.split('\n');
    messageParts.forEach(part => {
        const colonIndex = part.indexOf(':');
        if (colonIndex !== -1) {
            const label = part.substring(0, colonIndex + 1);
            const value = part.substring(colonIndex + 1);
            messageContent += `
                <div class="mb-2">
                    <span class="font-medium text-blue-600">${label}</span>
                    <span class="text-gray-700">${value}</span>
                </div>`;
        } else {
            messageContent += `<div class="mb-2"><span class="text-gray-700">${part}</span></div>`;
        }
    });

    modalContent.innerHTML = `
        <div class="space-y-4">
        
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                     <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="<?php echo $icon . ' ' . $iconColor; ?> fa-2x"></i> <!-- Adjust font size -->
                                    </div>
                </div>
                <div>
                    <div class="text-sm">
                        <span class="font-medium text-blue-600">Date:</span>
                        <span class="text-gray-500">${formattedDate}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                ${messageContent}
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('auditModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('auditModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
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
   
      document.addEventListener('DOMContentLoaded', function() {
        // Add smooth fade-in animation for audit entries
        const entries = document.querySelectorAll('.audit-entry');
        entries.forEach((entry, index) => {
            entry.style.animation = `fadeIn 0.3s ease-in-out ${index * 0.1}s`;
        });
    });
  });
    </script>

  
</body>

</html>