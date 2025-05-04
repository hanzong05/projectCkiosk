<?php
include_once('../../class/connection.php');

if (isset($_POST['officeID'])) {
    $officeID = $_POST['officeID'];
    
    // Query to fetch office data
    $sql = "SELECT * FROM offices WHERE office_id = :office_id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':office_id', $officeID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        ?>
        <input type="hidden" name="office_id" value="<?php echo $result['office_id']; ?>">
        <div class="mb-3">
            <label for="edit_office_name" class="form-label fw-bold">Office Name</label>
            <input type="text" id="edit_office_name" class="form-control" name="office_name" value="<?php echo htmlspecialchars($result['office_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_office_description" class="form-label fw-bold">Description</label>
            <textarea id="edit_office_description" class="form-control" name="office_description" rows="5"><?php echo htmlspecialchars($result['office_description']); ?></textarea>
        </div>
        <?php
    } else {
        echo '<div class="alert alert-danger">Office not found!</div>';
    }
} else {
    echo '<div class="alert alert-danger">Office ID not provided!</div>';
}
?>