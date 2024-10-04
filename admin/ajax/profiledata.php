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

if ($array) {
    // Access the values directly without a foreach loop
    $response .= '<input type="hidden" value="' . htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8') . '" name="uid">

    <div class="mb-3">
        <label for="profile_image" class="form-label fw-bold">Profile Image</label>
        <div class="d-flex align-items-center">
            <div class="me-3">'; // Add some spacing between image and button
            
            // Display current or default profile image
            if (!empty($array['member_img'])) {
                $response .= '<img src="../uploaded/orgUploaded/' . htmlspecialchars($array['member_img'], ENT_QUOTES, 'UTF-8') . '" alt="Profile Image" class="img-fluid" style="width: 100px; height: 100px; border-radius: 50%;">';
            } else {
                $response .= '<img src="../../path/to/default/image.png" alt="Default Profile Image" class="img-fluid" style="width: 100px; height: 100px; border-radius: 50%;">';
            }
            
            $response .= '        </div>
            <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>
    </div>

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
            <input type="radio" id="length-check" name="length" disabled>
            <label for="length-check">At least 8 characters</label>
        </li>
        <li>
            <input type="radio" id="uppercase-check" name="uppercase" disabled>
            <label for="uppercase-check">At least one uppercase letter</label>
        </li>
        <li>
            <input type="radio" id="number-check" name="number" disabled>
            <label for="number-check">At least one number</label>
        </li>
        <li>
            <input type="radio" id="special-check" name="special" disabled>
            <label for="special-check">At least one special character (!@#$%^&*(),.?":{}|<>_)</label>
        </li>
    </ul>
</div>

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
});document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("password-<?php echo htmlspecialchars($array['id'], ENT_QUOTES, 'UTF-8'); ?>");
    const lengthCheck = document.getElementById("length-check");
    const uppercaseCheck = document.getElementById("uppercase-check");
    const numberCheck = document.getElementById("number-check");
    const specialCheck = document.getElementById("special-check");

    // Enable the radio buttons when the user starts typing in the password field
    passwordField.addEventListener("focus", function () {
        lengthCheck.disabled = false;
        uppercaseCheck.disabled = false;
        numberCheck.disabled = false;
        specialCheck.disabled = false;
    });

    passwordField.addEventListener("input", function () {
        const password = passwordField.value;

        // Reset all radio buttons to unchecked
        lengthCheck.checked = false;
        uppercaseCheck.checked = false;
        numberCheck.checked = false;
        specialCheck.checked = false;

        // Check password requirements and set radio buttons accordingly
        if (password.length >= 8) {
            lengthCheck.checked = true; // Check the length radio button
        }
        if (/[A-Z]/.test(password)) {
            uppercaseCheck.checked = true; // Check the uppercase radio button
        }
        if (/\d/.test(password)) {
            numberCheck.checked = true; // Check the number radio button
        }
        if(/[!@#$%^&*(),.?":{}|<>_]/.test(password)) { // Updated special character regex
            specialCheck.checked = true; // Check the special character radio button
        }
    });
});

</script>
