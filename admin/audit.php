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
<body class="">
    <div class="wrapper ">
    <!-- sweetalert start-->
    <?php include 'assets/includes/navbar.php'; ?>

<div class="content"> <div class="flex flex-col w-full">

<!-- Modal for audit details -->
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
                <!-- Modal content will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Audit Table -->
<div class="flex flex-col w-full rounded-lg shadow-md overflow-hidden">
    <div class="p-8">
        <!-- Header Section with Gradient Background -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-xl p-6 shadow-lg text-center sm:text-left">
            <h2 class="text-3xl font-bold text-white mb-2">System Audit Trail</h2>
            <p class="text-blue-100 text-sm">Track and monitor system activities</p>
        </div>

        <!-- Controls Section -->
        <div class="bg-white rounded-b-xl shadow-lg p-6 space-y-6">
            <!-- Search and Filters Container -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Search Input -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" placeholder="Search" class="w-full px-4 py-2 border rounded-lg bg-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Action Filter -->
                <div>
                    <label for="actionSort" class="block text-sm font-medium text-gray-700 mb-2">Filter by Action</label>
                    <div class="relative">
                        <select id="actionSort" class="w-full appearance-none bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 focus:ring-2 focus:ring-blue-500">
                            <option value="all">All Actions</option>
                            <option value="add">Add</option>
                            <option value="update">Update</option>
                            <option value="delete">Delete</option>
                            <option value="archive">Archive</option>
                            <option value="restore">Restore</option>
                        </select>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Date</label>
                    <div class="relative">
                        <input type="date" id="dateFilter" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- No Records Message -->
            <div id="noRecordsMessage" class="hidden text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                <p>No records match the selected filter.</p>
            </div>

            <!-- Audit Table -->
            <div class="overflow-x-auto">
                <table id="auditTable" class="table-auto w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Icon</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Message</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Action</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($allaudit)) {
                            foreach ($allaudit as $index => $log) {
                                $icon = 'fas fa-info-circle';
                                $iconColor = 'text-blue-500';
                                
                                switch (strtolower($log['actions'])) {
                                    case 'add':
                                        $icon = 'fas fa-plus-circle';
                                        $iconColor = 'text-green-500';
                                        break;
                                    case 'update':
                                        $icon = 'fas fa-edit';
                                        $iconColor = 'text-yellow-500';
                                        break;
                                    case 'delete':
                                        $icon = 'fas fa-trash-alt';
                                        $iconColor = 'text-red-500';
                                        break;
                                    case 'archive':
                                        $icon = 'fas fa-archive';
                                        $iconColor = 'text-gray-500';
                                        break;
                                    case 'restore':
                                        $icon = 'fas fa-undo';
                                        $iconColor = 'text-purple-500';
                                        break;
                                }
                        ?>
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="<?php echo $icon . ' ' . $iconColor . ' fa-2x'; ?>"></i>
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <?php $date = new DateTime($log['created_at']); echo $date->format('F j, Y g:i A'); ?>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <?php $message = $log['message'];
                                    $parts = explode(':', $message, 2);
                                    if (count($parts) > 1) {
                                        echo '<span class="font-medium">' . htmlspecialchars($parts[0]) . ':</span>' . htmlspecialchars($parts[1]);
                                    } else {
                                        echo htmlspecialchars($message);
                                    } ?>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <?php echo ucfirst(strtolower($log['actions'])); ?>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="#" class="text-blue-500 underline" onclick="showAuditDetails(<?php echo htmlspecialchars(json_encode($log)); ?>, <?php echo $index + 1; ?>)">Details</a>
                                </td>
                            </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-history mb-3 text-2xl"></i>
                                    <p>No audit trail records found</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

    </div>
</div>
</div><script>
// Filter functionality for the Date Filter input
document.getElementById("dateFilter").addEventListener("input", function () {
    const filterDate = this.value;  // The selected date from the date input
    const rows = document.querySelectorAll("#auditTable tbody tr");  // Target the audit table rows

    rows.forEach(row => {
        const dateCell = row.cells[1];  // Assuming the date is in the 2nd column (index 1) of the table
        const rowDate = dateCell.textContent.trim();  // Get the date text from the cell

        // Convert the row date to the same format as the input date (YYYY-MM-DD)
        const formattedRowDate = new Date(rowDate).toISOString().split('T')[0]; 

        // If filterDate is provided, hide rows that don't match the selected date
        if (filterDate && formattedRowDate !== filterDate) {
            row.style.display = "none";  // Hide rows that don't match the filter
        } else {
            row.style.display = "";  // Show rows that match the filter
        }
    });
});function searchAuditTrail() {
    const input = document.getElementById('searchAuditInput').value.toLowerCase();
    const rows = document.querySelectorAll('#auditTableBody tr');

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

    // Show "No records match the selected filter" if no rows are found
    const noRecordsMessage = document.getElementById('noRecordsMessage');
    const hasVisibleRows = Array.from(rows).some(row => row.style.display !== "none");
    noRecordsMessage.style.display = hasVisibleRows ? "none" : "";
}


</script>

<script type="text/javascript">
document.getElementById('actionSort').addEventListener('change', function() {
    const selectedAction = this.value.toLowerCase();
    console.log('Selected Action:', selectedAction); // Debug log for selected action
    const tableRows = document.querySelectorAll('#auditTable tbody tr');
    const noRecordsMessage = document.getElementById('noRecordsMessage');
    let hasVisibleRows = false;

    tableRows.forEach(row => {
        const actionCell = row.cells[3];  // Assuming the "Actions" are in the 4th column (index 3)
        const actionText = actionCell.textContent.toLowerCase();
        console.log('Row Action:', actionText); // Debug log for action in each row

        if (selectedAction === 'all' || actionText.includes(selectedAction)) {
            row.style.display = '';  // Show row
            hasVisibleRows = true;
        } else {
            row.style.display = 'none';  // Hide row
        }
    });

    if (!hasVisibleRows) {
        noRecordsMessage.classList.remove('hidden');
    } else {
        noRecordsMessage.classList.add('hidden');
    }
});
</script>
</div>


  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script><!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
  <script>$(document).ready(function() {
    // Define a custom date sorting function for your date format
    $.fn.dataTable.ext.type.detect.unshift(function(data) {
        // Check if the data looks like a date in the format "Month Day, Year Time"
        if (data.match(/^[A-Z][a-z]{2,8} \d{1,2}, \d{4} \d{1,2}:\d{2} [AP]M$/)) {
            return 'date-mmm-dd-yyyy';
        }
        return null;
    });
    
    // Define how to sort this date format
    $.fn.dataTable.ext.type.order['date-mmm-dd-yyyy-pre'] = function(data) {
        return new Date(data).getTime();
    };
    
    $('#auditTable').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "lengthChange": true,
        "pageLength": 10,
        "responsive": true,
        "order": [[1, "desc"]], // Default order by Date (column index 1) in descending order
        "columnDefs": [
            { 
                "type": "date", 
                "targets": 1 // Explicitly define column 1 as date type
            },
            { 
                "orderable": true, 
                "targets": [1, 2, 3] 
            }
        ],
        "dom": '<"top"fl>rt<"bottom"ip>',
        "language": {
            "search": "Search records:",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

    $('.dataTables_filter').addClass('hidden');
    
    $('input[type="text"]').on('keyup', function() {
        $('#auditTable').DataTable().search($(this).val()).draw();
    });
});
document.getElementById('actionSort').addEventListener('change', function() {
    const selectedAction = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#auditTable tbody tr');

    tableRows.forEach(row => {
        const actionCell = row.cells[3];  // Assuming the "Actions" are in the 4th column (index 3)

        // Get the action text from the cell and compare with the selected action
        const actionText = actionCell.textContent.toLowerCase();
        
        if (selectedAction === 'all' || actionText.includes(selectedAction)) {
            row.style.display = '';  // Show row
        } else {
            row.style.display = 'none';  // Hide row
        }
    });
});

</script>
<script type="text/javascript">
function showAuditDetails(log, index) {
    const modal = document.getElementById('auditModal');
    const modalContent = document.getElementById('modalContent');
    
    // Determine the icon and color based on action type
    let iconClass = 'fas fa-info-circle'; // Default icon
    let iconColor = 'text-blue-500'; // Default color

    switch (log.actions.toLowerCase()) {
        case 'add':
            iconClass = 'fas fa-plus-circle';
            iconColor = 'text-green-500';
            break;
        case 'update':
            iconClass = 'fas fa-edit';
            iconColor = 'text-yellow-500';
            break;
        case 'delete':
            iconClass = 'fas fa-trash-alt';
            iconColor = 'text-red-500';
            break;
        case 'archive':
            iconClass = 'fas fa-archive';
            iconColor = 'text-gray-500';
            break;
        case 'restore':
            iconClass = 'fas fa-undo';
            iconColor = 'text-purple-500';
            break;
    }

    const formattedDate = new Date(log.created_at).toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });
    
    modalContent.innerHTML = `
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 ${iconColor} rounded-full flex items-center justify-center">
                    <i class="${iconClass} fa-2x"></i>
                </div>
                <div>
                    <div class="text-sm">
                        <span class="font-medium text-blue-600">Date:</span>
                        <span class="text-gray-500">${formattedDate}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                ${log.message}
            </div>
        </div>
    `;
    modal.classList.remove("hidden");
}

function closeModal() {
    document.getElementById("auditModal").classList.add("hidden");
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
    $('#auditTable').DataTable(); // Initialize DataTable
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

    // Fade-in animation for audit entries
    const entries = document.querySelectorAll('.audit-entry');
    entries.forEach((entry, index) => {
        entry.style.animation = `fadeIn 0.3s ease-in-out ${index * 0.1}s`;
    });
});
</script>

</body>

</html>