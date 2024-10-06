<?php
session_start(); // Start the session
include "../../class/connection.php";

$eventID = 0;
$response = ''; // Initialize response variable

if (!empty($_REQUEST['eventID'])) {
    $eventID = $_REQUEST['eventID'];
}

$sql = '
        SELECT 
            * 
        FROM 
            calendar_tbl
        WHERE
            calendar_id = :eventID
        ';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':eventID', $eventID);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($array) {
    foreach ($array as $key => $value) {
        $response .= '<input type="hidden" value="' . $value['calendar_id'] . '" name="cid">
                    <div class="mb-3">
                        <label for="event_date" class="form-label fw-bold">Event Date</label>
                        <input type="date" id="event_date" class="form-control" name="event_date" value="'. $value['calendar_date'] .'" required>
                    </div>
                    <div class="mb-3">
                     <input type="hidden" value="' . htmlspecialchars($_SESSION['aid'], ENT_QUOTES, 'UTF-8') . '" name="event_creator">
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
