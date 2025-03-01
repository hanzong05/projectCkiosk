<?php
include "../../class/connection.php";

$accountID = $_REQUEST['accountID'] ?? 0;
$response = '';

// Debug: Log accountID
error_log("Requested accountID: " . $accountID);

// Prepare the SQL query
$sql = 'SELECT u.*, o.org_name 
        FROM users_tbl u
        LEFT JOIN organization_tbl o ON u.users_org = o.org_id
        WHERE u.users_id = :accountID';

$stmt = $connect->prepare($sql);
$stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
$stmt->execute();
// Fetch the result
$array = $stmt->fetch(PDO::FETCH_ASSOC);

if ($array) {
  $uid = htmlspecialchars($array['users_id'], ENT_QUOTES, 'UTF-8');
$response .= '<input type="hidden" value="' . $uid . '" name="uid">
<div class="mb-3">
    <label for="username" class="form-label fw-bold">Username</label>
    <input type="text" id="username" class="form-control" name="username" value="' . htmlspecialchars($array['users_username'], ENT_QUOTES, 'UTF-8') . '" required autocomplete="username">
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

<div class="mb-3">
    <label for="orgname" class="form-label fw-bold">Organization</label>';
    
// Check if the org_name is 'admin' and disable the input if true
if ($array['org_name'] === 'admin') {
    $response .= '<input type="text" id="orgname" class="form-control" name="orgname" value="' . htmlspecialchars($array['org_name'], ENT_QUOTES, 'UTF-8') . '" disabled>';
} else {
    $response .= '<input type="text" id="orgname" class="form-control" name="orgname" value="' . htmlspecialchars($array['org_name'], ENT_QUOTES, 'UTF-8') . '">';
}

$response .= '</div>

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
<script>
$(document).ready(function() {
    // Handle password visibility toggle
    $(document).on('click', '.password-toggle', function() {
        var id = $(this).attr('id').split('-').pop();
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
        const userID = $(this).attr('id').split('-').pop();

        const requirements = {
            length: { check: password.length >= 8, selector: '#length-check-' + userID },
            uppercase: { check: /[A-Z]/.test(password), selector: '#uppercase-check-' + userID },
            number: { check: /\d/.test(password), selector: '#number-check-' + userID },
            special: { check: /[!@#$%^&*(),.?":{}|<>_]/.test(password), selector: '#special-check-' + userID }
        };

        $.each(requirements, function(key, req) {
            const element = $(req.selector);
            element.prop('checked', req.check);
            element.parent().find('label').css('color', req.check ? 'green' : '');
        });
    });
});
</script>
