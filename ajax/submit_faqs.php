<?php
// Include your connection file
include '../class/connection.php'; // Ensure this path is correct

// Include your main class file
include '../class/mainClass.php';

// Create an instance of your main class with the connection
$mainClass = new MainClass($connect);

// Initialize response array
$response = array('success' => false);

// Check if form data is received
if (isset($_POST['new_faq_question'])) {
    $question = $_POST['new_faq_question'];

    // Insert FAQ into the database
    $faq_id = $mainClass->add_faq($question, 'No answer yet.'); // Assuming answer is empty initially
    if ($faq_id) {
        $response['success'] = true;
        $response['faq_id'] = $faq_id;
        $response['faq_question'] = htmlspecialchars($question);

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit(); // Ensure no further processing
    }
}

// If form data is not received or insertion failed
header('Content-Type: application/json');
echo json_encode($response);
?>
