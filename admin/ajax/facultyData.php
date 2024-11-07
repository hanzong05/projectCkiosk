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
    $response .= '<div class="faculty-form-container">
                    <input type="hidden" value="' . $faculty['faculty_id'] . '" name="fid">
                    
                    <!-- Faculty Image Section -->
                    <div class="mb-4 text-center">
                        <h3>Current Photo</h3>
                        <img src="../uploaded/facultyUploaded/' . $faculty['faculty_image'] . '" height="120" width="150" id="faculty_image_p" class="img-thumbnail"/>
                        <input type="hidden" name="previous" value="' . $faculty['faculty_image'] . '" />
                    </div>
                    <!-- Upload New Faculty Image -->
                    <div class="mb-3">
                        <label for="faculty_image" class="form-label fw-bold">Upload New Photo</label>
                        <input type="file" id="faculty_image" class="form-control" name="faculty_image" ' . $req . '>
                    </div>
                    
                    <!-- Faculty Name Section -->
                    <div class="mb-3">
                        <label for="faculty_name" class="form-label fw-bold">Faculty Name</label>
                        <input type="text" id="faculty_name" class="form-control" value="' . $faculty['faculty_name'] . '" name="faculty_name" required>
                    </div>' ;

    // Now, create a dropdown for each department the faculty is associated with
    $response .= '<div class="department-dropdowns">';

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
        $response .= '<div class="mb-3 department-entry" data-department-id="' . $departmentId . '">
                        <label for="department_' . $departmentId . '" class="form-label fw-bold">Edit Department for ' . $departmentName . '</label>
                        <select name="department_' . $index . '" id="department_' . $departmentId . '" class="form-control department-dropdown" data-department-id="' . $departmentId . '">
                            <option value="">Select Department</option>';

        // Loop through all departments and show the ones that are linked to the faculty
        foreach ($allDepartment as $row) {
            // Check if the department is already selected and disable it for other dropdowns
            $selected = ($row['department_id'] == $departmentId) ? 'selected' : '';
            $response .= '<option value="' . $row['department_id'] . '" ' . $selected . '>' . $row['department_name'] . '</option>';
        }

        $response .= '</select>
                      <button type="button" class="btn btn-danger btn-sm remove-department-btn">Remove</button>
                    </div>';
    }

    $response .= '</div>';

// Add the "Add Department" button after the department dropdowns
$response .= '<button type="button" id="add-department-btn" class="btn btn-success">Add Department</button>';
    // Specialization Section
    $response .= '<div class="mb-3">
                    <label for="specialization" class="form-label fw-bold">Specialization</label>
                    <input type="text" id="specialization" class="form-control" value="' . $faculty['specialization'] . '" name="specialization">
                </div>
                
                <!-- Consultation Time Section -->
                <div class="mb-3">
                    <label for="consultation_time" class="form-label fw-bold">Consultation Time</label>
                    <input type="text" id="consultation_time" class="form-control" value="' . $faculty['consultation_time'] . '" name="consultation_time">
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

<script>
   $(document).ready(function() {
    var removedDepartments = []; // Array to store removed department ids

    // When the department dropdown changes
    $('.department-dropdown').on('change', function() {
        var selectedDepartments = [];
        
        // Collect all selected department ids
        $('.department-dropdown').each(function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                selectedDepartments.push(selectedValue);
            }
        });

        // Disable the options that have been selected in other dropdowns
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
    });

    // Trigger change event to initialize disabled options on page load
    $('.department-dropdown').trigger('change');

    // Handle the remove department button click
    $(document).on('click', '.remove-department-btn', function() {
        var departmentEntry = $(this).closest('.department-entry');
        var departmentId = departmentEntry.data('department-id');
        
        // Hide the department entry
        departmentEntry.hide();

        // Store the removed department id in the array
        if (!removedDepartments.includes(departmentId)) {
            removedDepartments.push(departmentId);
        }

        console.log('Removed Departments:', removedDepartments);
    });

    // Add a new department dropdown when the "Add Department" button is clicked
    $('#add-department-btn').on('click', function() {
        var newDepartmentIndex = $('.department-entry').length; // Get the number of existing department entries
        var departmentDropdownHTML = `
            <div class="mb-3 department-entry" data-department-id="new_${newDepartmentIndex}">
                <label for="department_new_${newDepartmentIndex}" class="form-label fw-bold">New Department</label>
                <select name="department_${newDepartmentIndex}" id="department_new_${newDepartmentIndex}" class="form-control department-dropdown" data-department-id="new_${newDepartmentIndex}">
                    <option value="">Select Department</option>
                    ${generateDepartmentOptions()}
                </select>
                <button type="button" class="btn btn-danger btn-sm remove-department-btn">Remove</button>
            </div>
        `;
        
        // Append the new department dropdown
        $('.department-dropdowns').append(departmentDropdownHTML);

        // Re-initialize the event listener for the new dropdown
        $('#department_new_' + newDepartmentIndex).on('change', function() {
            var selectedDepartments = [];
            
            // Collect all selected department ids
            $('.department-dropdown').each(function() {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    selectedDepartments.push(selectedValue);
                }
            });

            // Disable the options that have been selected in other dropdowns
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
        });

        // Trigger change event to initialize disabled options on the new dropdown
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
});

</script>