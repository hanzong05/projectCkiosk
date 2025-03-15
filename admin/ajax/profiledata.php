<?php
include "../../class/connection.php";

$accountID = $_REQUEST['accountID'] ?? 0;
$response = '';


$sql = '
    SELECT 
        om.*, 
        o.org_name 
    FROM 
        orgmembers_tbl AS om
    LEFT JOIN 
        organization_tbl AS o 
    ON 
        om.org_type = o.org_id 
    WHERE 
        om.id = :accountID';

$stmt = $connect->prepare($sql);
$stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $uid = htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8');
    $orgName = htmlspecialchars($result['org_name'], ENT_QUOTES, 'UTF-8'); // Sanitize org_name
    
    $response .= '<input type="hidden" value="' . $uid . '" name="uid">

    <div class="mb-3">
        <label for="profile_image" class="form-label fw-bold">Profile Image</label>
        <div class="d-flex align-items-center">
            <div class="me-3">';
            
    if (!empty($result['member_img'])) {
        $response .= '<img src="../uploaded/orgUploaded/' . htmlspecialchars($result['member_img'], ENT_QUOTES, 'UTF-8') . '" alt="Profile Image" class="img-fluid" style="width: 100px; height: 100px; border-radius: 50%;">';
    } else {
        $response .= '<img src="../../path/to/default/image.png" alt="Default Profile Image" class="img-fluid" style="width: 100px; height: 100px; border-radius: 50%;">';
    }
    
    $response .= '        </div>
            <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label fw-bold">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="' . htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8') . '" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label fw-bold">Username</label>
        <input type="text" id="username" class="form-control" name="username" value="' . htmlspecialchars($result['username'], ENT_QUOTES, 'UTF-8') . '" required autocomplete="username">
    </div>

    <div class="mb-3">
        <label for="org_name" class="form-label fw-bold">Organization</label>
        <input type="text" id="org_name" class="form-control" name="org_name" value="' . $orgName . '" disabled>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-bold">Password</label>
        <div class="input-group">
            <input type="password" id="password-' . $uid . '" class="form-control password-field" name="password" autocomplete="new-password" aria-label="Password">
            <span class="input-group-text password-toggle" id="togglePassword-' . $uid . '">
                <i class="fa fa-eye"></i>
            </span>
        </div>
        <small class="form-text text-muted">Leave blank to keep the current password.</small>
    </div>

    <div class="password-requirements">
        <p>Password must meet the following criteria:</p>
        <ul class="requirement-list">
            <li>
                <input type="radio" id="length-check-' . $uid . '" disabled>
                <label for="length-check-' . $uid . '">At least 8 characters</label>
            </li>
            <li>
                <input type="radio" id="uppercase-check-' . $uid . '" disabled>
                <label for="uppercase-check-' . $uid . '">At least one uppercase letter</label>
            </li>
            <li>
                <input type="radio" id="number-check-' . $uid . '" disabled>
                <label for="number-check-' . $uid . '">At least one number</label>
            </li>
            <li>
                <input type="radio" id="special-check-' . $uid . '" disabled>
                <label for="special-check-' . $uid . '">At least one special character (!@#$%^&*(),.?":{}|<>_)</label>
            </li>
        </ul>
    </div>';
} else {
    $response = '<p>No data found for the selected account.</p>';
}

echo $response;
?>

<!-- jQuery Library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery to handle password visibility toggle -->
<script>$(document).ready(function() {
    // Handle password visibility toggle
    $(document).on('click', '.password-toggle', function() {
        var id = $(this).attr('id').split('-').pop(); // Extract the userID from the button ID
        var passwordField = $('#password-' + id);
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

    // Password requirement validation
    $(document).on('input', "[id^='password-']", function () {
        const password = $(this).val();
        const userID = $(this).attr('id').split('-').pop(); // Extract user ID from password field ID

        // Find the corresponding radio buttons for this password field
        const lengthCheck = $("#length-check-" + userID);
        const uppercaseCheck = $("#uppercase-check-" + userID);
        const numberCheck = $("#number-check-" + userID);
        const specialCheck = $("#special-check-" + userID);

        // Reset all radio buttons to unchecked and default color
        lengthCheck.prop('checked', false).parent().find('label').css('color', '');
        uppercaseCheck.prop('checked', false).parent().find('label').css('color', '');
        numberCheck.prop('checked', false).parent().find('label').css('color', '');
        specialCheck.prop('checked', false).parent().find('label').css('color', '');

        // Check password requirements and set radio buttons to green if met
        if (password.length >= 8) {
            lengthCheck.prop('checked', true);
            lengthCheck.parent().find('label').css('color', 'green');
        }
        if (/[A-Z]/.test(password)) {
            uppercaseCheck.prop('checked', true);
            uppercaseCheck.parent().find('label').css('color', 'green');
        }
        if (/\d/.test(password)) {
            numberCheck.prop('checked', true);
            numberCheck.parent().find('label').css('color', 'green');
        }
        if (/[!@#$%^&*(),.?":{}|<>_]/.test(password)) {
            specialCheck.prop('checked', true);
            specialCheck.parent().find('label').css('color', 'green');
        }
    });
});

</script>
