<?php
include "../../class/connection.php";

$facultyID = 0;
if (!empty($_REQUEST['facultyID'])) {
    $facultyID = $_REQUEST['facultyID'];
}

// Fetch all departments
$query = "SELECT * FROM department_tbl";
$statement = $connect->prepare($query);
$statement->execute();
$allDepartment = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch faculty details along with the specialization and consultation_time
$sql = '
    SELECT 
        f.*, 
        d.department_id, 
        d.department_name
    FROM 
        faculty_tbl f
    LEFT JOIN 
        faculty_departments_tbl fd ON f.faculty_id = fd.faculty_id
    LEFT JOIN 
        department_tbl d ON fd.department_id = d.department_id
    WHERE
        f.faculty_id = :facultyID
';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':facultyID', $facultyID);
$stmt->execute();
$faculty = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single faculty record

$response = ''; // Initialize response variable
$departments = []; // Array to store department ids for the selected faculty

// Check if faculty data is retrieved
if ($faculty) {
    // Collect all departments the faculty member is part of
    $queryDepartments = "SELECT department_id FROM faculty_departments_tbl WHERE faculty_id = :facultyID";
    $statementDepartments = $connect->prepare($queryDepartments);
    $statementDepartments->bindValue(':facultyID', $facultyID);
    $statementDepartments->execute();
    $facultyDepartments = $statementDepartments->fetchAll(PDO::FETCH_ASSOC);

    // Store department ids that the faculty member is associated with
    foreach ($facultyDepartments as $dept) {
        $departments[] = $dept['department_id'];
    }

    // Set up the form (only once)
    $req = $faculty['faculty_image'] == "" ? "required" : "";
    $response .= '<div class="faculty-form-container p-4 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
                    <input type="hidden" value="' . $faculty['faculty_id'] . '" name="fid">
                   <input type="hidden" name="removedDepartments" id="removedDepartments" />
                   <input type="hidden" name="addedDepartments" id="addedDepartments" />

                    <!-- Faculty Image Section -->
                    <div class="mb-6 text-center">
                        <h3 class="text-xl font-semibold mb-2">Current Photo</h3>
                        <img src="../uploaded/facultyUploaded/' . $faculty['faculty_image'] . '" height="120" width="150" id="faculty_image_p" class="img-thumbnail rounded-full"/>
                        <input type="hidden" name="previous" value="' . $faculty['faculty_image'] . '" />
                    </div>
                    <!-- Upload New Faculty Image -->
                    <div class="mb-6">
                        <label for="faculty_image" class="block text-lg font-medium">Upload New Photo</label>
                        <input type="file" id="faculty_image" class="form-control mt-2 p-2 border border-gray-300 rounded-lg" name="faculty_image" ' . $req . '>
                    </div>
                    
                    <!-- Faculty Name Section -->
                    <div class="mb-6">
                        <label for="faculty_name" class="block text-lg font-medium">Faculty Name</label>
                        <input type="text" id="faculty_name" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" value="' . $faculty['faculty_name'] . '" name="faculty_name" required>
                    </div>' ;

    // Now, create a dropdown for each department the faculty is associated with
    $response .= '<div class="department-dropdowns mb-4 overflow-auto" style="max-height: 300px;">';

    $response .= '<label for="departments"" class="w-1/4 text-lg font-medium"> DEPARTMENTS </label>';
    // Loop through the departments the faculty member is assigned to
    foreach ($departments as $index => $departmentId) {
        // Fetch the department name for the specific department
        $departmentName = '';
        foreach ($allDepartment as $dept) {
            if ($dept['department_id'] == $departmentId) {
                $departmentName = $dept['department_name'];
                break;
            }
        }

        // Add a dropdown for each department (using different ids for each)
        $response .= '<div class="mb-3 department-entry " data-department-id="' . $departmentId . '">
       <select name="department_' . $index . '" id="department_' . $departmentId . '" class="form-control p-2 border border-gray-300 rounded-lg flex-1 mb-4">
    <option value="" disabled selected>Select Department</option>

';

// Loop through all departments and show the ones that are linked to the faculty
foreach ($allDepartment as $row) {
// Check if the department is already selected and disable it for other dropdowns
$selected = ($row['department_id'] == $departmentId) ? 'selected' : '';
$response .= '<option value="' . $row['department_id'] . '" ' . $selected . '>' . htmlspecialchars($row['department_name']) . '</option>';
}

$response .= '</select>
<button type="button" class="btn-sm remove-department-btn w-100 text-white hover:bg-red-800" style="background-color:rgba(220,38,38,var(--tw-bg-opacity))">Remove</button>


    </div>';

    }

    $response .= '</div>';
    $response .= '<button type="button" id="add-department-btn" class="btn btn-success p-2 bg-green-500 text-white rounded-lg mt-4 w-full font-sans" style="background-color: rgba(37, 99, 235, var(--tw-bg-opacity));">Add Department</button>';

    // Specialization Section
    $response .= '<div class="mb-6">
                    <label for="specialization" class="block text-lg font-medium">Specialization</label>
                    <input type="text" id="specialization" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" value="' . $faculty['specialization'] . '" name="specialization">
                </div>
                
                <!-- Consultation Time Section -->
                <div class="mb-6">
                    <label for="consultation_time" class="block text-lg font-medium">Consultation Time</label>
                    <input type="text" id="consultation_time" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" value="' . $faculty['consultation_time'] . '" name="consultation_time">
                </div>
            </div>';
}

echo $response;
?>


<script>
    // Initialize Summernote for any rich text areas (if applicable)
    $('#summernote2').summernote({
        height: 220,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']]
        ]
    });
</script>
<script>$(document).ready(function() {
    var removedDepartments = []; // Array to store removed department IDs
    var addedDepartments = []; // Array to store new department IDs (replacements or additions)
    
    // Add new department dropdown
    $('#add-department-btn').on('click', function () {
        var newDepartmentIndex = $('.department-entry').length;
        var departmentDropdownHTML = `
            <div class="mb-3 department-entry" data-department-id="new_${newDepartmentIndex}">
                <select name="department_${newDepartmentIndex}" id="department_new_${newDepartmentIndex}" class="form-control department-dropdown" data-department-id="new_${newDepartmentIndex}">
                    <option value="">Select Department</option>
                    ${generateDepartmentOptions()}
                </select>
                <button type="button" class="btn btn-sm remove-department-btn w-100" style="background-color:rgba(220,38,38,var(--tw-bg-opacity))">Remove</button>
            </div>
        `;

        $('.department-dropdowns').append(departmentDropdownHTML);
        $('#department_new_' + newDepartmentIndex).on('change', handleDropdownChange);
        $('#department_new_' + newDepartmentIndex).trigger('change');
    });

    // Function to generate department options
    function generateDepartmentOptions() {
        var optionsHTML = '';
        <?php foreach ($allDepartment as $dept): ?>
            optionsHTML += '<option value="<?= $dept['department_id']; ?>"><?= $dept['department_name']; ?></option>';
        <?php endforeach; ?>
        return optionsHTML;
    }

    // Handle department dropdown changes
    function handleDropdownChange() {
        var selectedDepartments = [];

        // Collect all selected department IDs
        $('.department-dropdown').each(function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                selectedDepartments.push(selectedValue);
            }
        });

        // Disable options that are selected in other dropdowns
        $('.department-dropdown').each(function() {
            var $this = $(this);
            $this.find('option').each(function() {
                var optionValue = $(this).val();
                if (selectedDepartments.includes(optionValue) && optionValue !== $this.val()) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });

        // Store newly selected department IDs (if it's a new department)
        addedDepartments = selectedDepartments.filter(function(departmentId) {
            return !$(this).find('.department-dropdown').val();
        });
    }

    // Handle remove department button click
    $(document).on('click', '.remove-department-btn', function() {
        var departmentEntry = $(this).closest('.department-entry');
        var departmentId = departmentEntry.find('.department-dropdown').val();

        // Add to removedDepartments if it has a valid ID
        if (departmentId) {
            removedDepartments.push(departmentId);
        }

        departmentEntry.remove(); // Remove the department entry from the form
    });

    // You can log `addedDepartments` and `removedDepartments` to see what's being added and removed
    console.log('Added Departments: ', addedDepartments);
    console.log('Removed Departments: ', removedDepartments);
});

</script>
