<?php
include "../../class/connection.php";

$accountID = $_REQUEST['accountID'] ?? 0;
$response = '';

// Debug: Log accountID
error_log("Requested accountID: " . $accountID);

// Fetch organizations
$query = "SELECT * FROM organization_tbl";
$statement = $connect->prepare($query);
$statement->execute();
$allOrganization = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch account details
$sql = '
    SELECT 
        u.*, 
        o.org_name
    FROM 
        users_tbl u
    LEFT JOIN
        organization_tbl o
    ON 
        u.users_org = o.org_id
    WHERE
        u.users_id = :accountID
';
$stmt = $connect->prepare($sql);
$stmt->bindValue(':accountID', $accountID);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug: Log SQL results
error_log("SQL query results: " . print_r($array, true));

if ($array) {
    foreach ($array as $value) {
        $response .= '<input type="hidden" value="' . htmlspecialchars($value['users_id'], ENT_QUOTES, 'UTF-8') . '" name="uid">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" id="username" class="form-control" name="username" value="' . htmlspecialchars($value['users_username'], ENT_QUOTES, 'UTF-8') . '" required autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" id="password-' . $value['users_id'] . '" class="form-control password-field" name="password" autocomplete="new-password" aria-label="Password">
                            <span class="input-group-text password-toggle" id="togglePassword-' . $value['users_id'] . '">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <small class="form-text text-muted">Leave blank to keep the current password.</small>
                    </div>
                    <div class="mb-3">
                        <label for="org" class="form-label fw-bold">Organization</label>
                        <select name="org" id="org" class="form-control" required>';
                        
        foreach ($allOrganization as $row) {
            $selected = ($value['users_org'] == $row['org_id']) ? 'selected' : '';
            $response .= '<option value="' . htmlspecialchars($row['org_id'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($row['org_name'], ENT_QUOTES, 'UTF-8') . '</option>';
        }
        $response .= '</select>
                    </div>';
    }
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
