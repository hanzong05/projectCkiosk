<?php
include "../../class/connection.php";

$accountID = $_REQUEST['accountID'] ?? 0;
$response = '';

// Debug: Log accountID
error_log("Requested accountID: " . $accountID);

// Prepare the SQL query
$sql = 'SELECT * FROM orgmembers_tbl WHERE id = :accountID';
$stmt = $connect->prepare($sql);
$stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
$stmt->execute();

// Fetch the result
$array = $stmt->fetch(PDO::FETCH_ASSOC);
error_log("SQL query results: " . print_r($array, true));

if ($array) {
    // Access the values directly without a foreach loop
    $response .= '<input type="hidden" value="' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" name="uid">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" id="name" class="form-control" name="name" value="' . htmlspecialchars($array['name'], ENT_QUOTES, 'UTF-8') . '" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" id="username" class="form-control" name="username" value="' . htmlspecialchars($array['username'], ENT_QUOTES, 'UTF-8') . '" required autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <input type="password" id="password-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" class="form-control password-field" name="password" autocomplete="new-password" aria-label="Password">
                        <span class="input-group-text password-toggle" id="togglePassword-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    <small class="form-text text-muted">Leave blank to keep the current password.</small>
                </div>
                <div class="password-requirements">
                    <p>Password must meet the following criteria:</p>
                    <ul class="requirement-list">
                        <li>
                            <input type="radio" id="length-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" name="length-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" disabled>
                            <label for="length-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '">At least 8 characters</label>
                        </li>
                        <li>
                            <input type="radio" id="uppercase-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" name="uppercase-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" disabled>
                            <label for="uppercase-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '">At least one uppercase letter</label>
                        </li>
                        <li>
                            <input type="radio" id="number-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" name="number-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" disabled>
                            <label for="number-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '">At least one number</label>
                        </li>
                        <li>
                            <input type="radio" id="special-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" name="special-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" disabled>
                            <label for="special-check-' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '">At least one special character (!@#$%^&*(),.?":{}|<>_)</label>
                        </li>
                    </ul>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label fw-bold">Position</label>
                    <select name="position" id="position" class="form-control" required>
                        <option value="" selected>Select a position</option>
                        <option value="Member"' . ($array['position'] === 'Member' ? ' selected' : '') . '>Member</option>
                        <option value="President"' . ($array['position'] === 'President' ? ' selected' : '') . '>President</option>
                        <option value="VicePresident"' . ($array['position'] === 'VicePresident' ? ' selected' : '') . '>Vice President</option>
                        <option value="Auditor"' . ($array['position'] === 'Auditor' ? ' selected' : '') . '>Auditor</option>
                        <option value="Secretary"' . ($array['position'] === 'Secretary' ? ' selected' : '') . '>Secretary</option>
                        <option value="Treasurer"' . ($array['position'] === 'Treasurer' ? ' selected' : '') . '>Treasurer</option>
                    </select>
                </div>';
} else {
    $response = '<p>No data found for the selected account.</p>';
}

// Output the response
echo $response;
?>

<!-- jQuery Library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery to handle password visibility toggle -->
<script>
$(document).ready(function() {
    // Event delegation for password toggle visibility
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

    // Check password requirements
    $(document).on('input', "[id^='password-']", function () {
        const password = $(this).val();
        const userID = $(this).attr('id').split('-').pop(); // Extract user ID from password field ID

        // Find the corresponding radio buttons for this password field
        const lengthCheck = $("#length-check-" + userID);
        const uppercaseCheck = $("#uppercase-check-" + userID);
        const numberCheck = $("#number-check-" + userID);
        const specialCheck = $("#special-check-" + userID);

        // Reset all radio buttons to unchecked
        lengthCheck.prop('checked', false);
        uppercaseCheck.prop('checked', false);
        numberCheck.prop('checked', false);
        specialCheck.prop('checked', false);

        // Check password requirements and set radio buttons accordingly
        if (password.length >= 8) {
            lengthCheck.prop('checked', true); // Check the length radio button
        }
        if (/[A-Z]/.test(password)) {
            uppercaseCheck.prop('checked', true); // Check the uppercase radio button
        }
        if (/\d/.test(password)) {
            numberCheck.prop('checked', true); // Check the number radio button
        }
        if(/[!@#$%^&*(),.?":{}|<>_]/.test(password)) { // Updated special character regex
            specialCheck.prop('checked', true); // Check the special character radio button
        }
    });
});
</script>
