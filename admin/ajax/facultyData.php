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
            * 
        FROM 
            faculty_tbl f
        LEFT JOIN
            department_tbl d
        ON 
            f.faculty_dept = d.department_id
        WHERE
            f.faculty_id = :facultyID
        ';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':facultyID', $facultyID);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = ''; // Initialize response variable

if ($array) {
    foreach ($array as $key => $value) {
        $req = $value['faculty_image'] == "" ? "required" : "";
        $response .= '<input type="hidden" value="' . $value['faculty_id'] . '" name="fid">
                    <div class="mb-3">
                        <center>
                        <h3>Current Photo</h3>
                        <img src="../uploaded/facultyUploaded/' . $value['faculty_image'] . '" height="120" width="150" id="faculty_image_p"/>
                        <input type="hidden" name="previous" value="' . $value['faculty_image'] . '" />
                        </center>
                    </div>
                    <div class="mb-3">
                        <label for="faculty_image" class="form-label fw-bold">Photo</label>
                        <input type="file" id="faculty_image" class="form-control" name="faculty_image" ' . $req . '>
                    </div>
                    <div class="mb-3">
                        <label for="faculty_name" class="form-label fw-bold">Faculty Name</label>
                        <input type="text" id="faculty_name" class="form-control" value="'.$value['faculty_name'].'" name="faculty_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label fw-bold">Department</label>
                        <select name="department" id="department" class="form-control" required>
                            ';
        foreach ($allDepartment as $row) {
            if($value['department_id'] == $row['department_id']){
                $response .= '<option value="' . $row['department_id'] . '" selected>' . $row['department_name'] . '</option>';
                continue;
            }
            $response .= '<option value="' . $row['department_id'] . '">' . $row['department_name'] . '</option>';
        }
        $response .= '
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="specialization" class="form-label fw-bold">Specialization</label>
                        <input type="text" id="specialization" class="form-control" value="'.$value['specialization'].'" name="specialization" required>
                    </div>
                    <div class="mb-3">
                        <label for="consultation_time" class="form-label fw-bold">Consultation Time</label>
                        <input type="text" id="consultation_time" class="form-control" value="'.$value['consultation_time'].'" name="consultation_time" required>
                    </div>';
    }
}

echo $response;
?>

<script>
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
