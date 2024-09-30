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
});
</script>
