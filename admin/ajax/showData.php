<?php

include_once('../../class/mainClass.php'); // Adjust path if needed


if (!class_exists('mainClass')) {
    die('Class mainClass not found.');
}

$mainClassInstance = new mainClass();

$department_id = $_POST['department'] ?? null;
$response = '';

// Debug: Print $_POST data
error_log(print_r($_POST, true));

if ($department_id) {
    // Fetch department heads and faculty members
    $heads = $mainClassInstance->show_heads($department_id);
    $faculty = $mainClassInstance->show_faculty($department_id);

    // Debug: Print fetched faculty data
    error_log(print_r($faculty, true));

    // Start container
    $response .= '<div class="container flex-container">';

    // Department Heads
     if ($heads) {
        $response .= '
        <div class="center-block">
            <h3 class="center-content">Department Heads</h3>
            <div class="row">';
        foreach ($heads as $row) {
            $departmentName = htmlspecialchars($row['department_name']);
            $additionalText = ($departmentName !== 'Dean') ? ' - Chair Person' : '';

            $response .= '
            <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="faculty-card center-content">
                    <div class="faculty-image">
                        <img src="../uploaded/Heads/' . htmlspecialchars($row['img']) . '" alt="Head Image">
                    </div>
                 
                </div>
                <div class="more-info">
                    <h6>' . htmlspecialchars($row['name']) . '</h6> <!-- Add faculty name -->
                     <a>' .  $departmentName . $additionalText . '</a>
                </div>
                
            </div>';
        }
        $response .= '
            </div> <!-- Close row -->
        </div> <!-- Close center-block -->';
    } else {
        $response .= '<p class="center-content">No department heads found.</p>';
    }

    // Faculty Members
    if ($faculty) {
        $response .= '
        <div class="center-block">
            <h3 class="center-content">Faculty Members</h3>
            <div class="row">';
        foreach ($faculty as $row) {
            $response .= '
            <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="faculty-card center-content">
                    <div class="faculty-image">
                        <img src="../uploaded/facultyUploaded/' . htmlspecialchars($row['faculty_image']) . '" alt="Faculty Image">
                    </div>
                    <div class="faculty-info">
                        <h5 class="card-title">' . htmlspecialchars($row['faculty_name']) . '</h5>
                        <h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row['department_name']) . '</h6>
                        <a href="#" class="btn btn-primary facultyModalEdit" data-toggle="modal" data-target="#facultyModalEdit" data-id="' . htmlspecialchars($row['faculty_id']) . '"><i class="fas fa-edit"></i> Edit</a>
                        <a href="facultymembers.php?did=' . htmlspecialchars($row['faculty_id']) . '" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i> Delete</a>
                    </div>
                 </div>
                  <div class="more-info">
                    <h6>' . htmlspecialchars($row['faculty_name']) . '</h6> <!-- Add faculty name -->
                     <a>' . htmlspecialchars($row['department_name']) . '</a>
                </div>
            </div>';
        }
        $response .= '
            </div> <!-- Close row -->
        </div> <!-- Close center-block -->';
    } else {
        $response .= '<p class="center-content">No faculty members found.</p>';
    }

    $response .= '</div> <!-- Close container -->';
}

echo $response;
?>

