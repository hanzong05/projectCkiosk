<?php
session_start(); // Start the session
include "../../class/connection.php";

$eventID = 0;
$response = ''; // Initialize response variable

// Check if eventID is provided in the request
if (!empty($_REQUEST['eventID'])) {
    $eventID = $_REQUEST['eventID'];
}

// Update SQL query to match the new schema (column names)
$sql = '
        SELECT 
            * 
        FROM 
            calendar_tbl
        WHERE
            calendar_id = :eventID
        ';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':eventID', $eventID, PDO::PARAM_INT);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the query returned any data
if ($array) {
    foreach ($array as $key => $value) {
        // Updated form fields to match new column names (e.g., calendar_start_date, calendar_details)
        $response .= '<input type="hidden" value="' . $value['calendar_id'] . '" name="cid">
                    <div class="mb-3">
                        <label for="event_start_date" class="form-label fw-bold">Event Start Date</label>
                        <input type="date" id="event_start_date" class="form-control" name="event_start_date" value="' . $value['calendar_start_date'] . '" required>
                    </div>
                    <div class="mb-3">
                        <label for="event_end_date" class="form-label fw-bold">Event End Date (Optional)</label>
                        <input type="date" id="event_end_date" class="form-control" name="event_end_date" value="' . $value['calendar_end_date'] . '">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" value="' . htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') . '" name="event_editor">
                        <label for="summernote2" class="form-label fw-bold">Event Details</label>
                        <textarea id="summernote2" name="event_details" required>' . htmlspecialchars($value['calendar_details']) . '</textarea>
                    </div>';
    }
} else {
    // Handle case where no event data is found
    $response = '<p>No event found for the provided ID.</p>';
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
