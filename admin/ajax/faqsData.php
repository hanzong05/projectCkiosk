<?php
session_start(); // Ensure the session is started
include "../../class/connection.php"; // Include your database connection file

// Check if the session variable is set
if (!isset($_SESSION['aid'])) {
    error_log("Error: User not logged in. Session ID: " . session_id() . "\n", 3, "error_log.txt");
    echo "Error: User not logged in.";
    exit; // Stop execution if the user is not logged in
}

// Get FAQs ID
$faqsID = $_REQUEST['faqsID'] ?? 0; // Default to 0 if not set

$sql = '
        SELECT 
            * 
        FROM 
            faqs_tbl
        WHERE
            faqs_id = :faqsID
        ';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':faqsID', $faqsID);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize the response variable
$response = '';

if ($array) {
    foreach ($array as $value) {
        // Safely output values and include editor_id
        $response .= '<input type="hidden" value="' . htmlspecialchars($value['faqs_id']) . '" name="fid">
                      <input type="hidden" value="' . htmlspecialchars($_SESSION['aid']) . '" name="editor_id"> <!-- Add editor_id -->
                      <div class="mb-3">
                          <label for="faqs_questionEdit" class="form-label fw-bold">Question</label>
                          <textarea id="faqs_questionEdit" class="form-control" name="faqs_question" required>' . htmlspecialchars($value['faqs_question']) . '</textarea>
                      </div>
                      <div class="mb-3">
                          <label for="faqs_answerEdit" class="form-label fw-bold">Answer</label>
                          <textarea id="faqs_answerEdit" class="form-control" name="faqs_answer" required>' . htmlspecialchars($value['faqs_answer']) . '</textarea>
                      </div>';
    }
} else {
    $response = '<p>No FAQ found.</p>'; // Handle no results
}

// Log the FAQs ID and the updater ID for debugging purposes
$updater_id = $_SESSION['aid']; // Assuming 'aid' is the user ID in the session
error_log("FAQs ID requested: " . $faqsID . ", Updater ID: " . $updater_id . "\n", 3, "error_log.txt");

echo $response; // Output the response
?>


<script>
    $('#faqs_questionEdit').summernote({
        height: 180,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']]
        ]
    });
    $('#faqs_answerEdit').summernote({
        height: 180,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']]
        ]
    });
</script>