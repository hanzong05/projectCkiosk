<?php
// Include your connection file
include '../class/connection.php';

// Create an instance of your main class with the connection
$mainClass = new MainClass($connect);

// Fetch all FAQs
$faqs = $mainClass->show_allFAQs();

// Check if data was fetched successfully
if (is_array($faqs)) {
    foreach ($faqs as $faq) {
        echo "Question: " . $faq['faqs_question'] . "<br>";
        echo "Answer: " . $faq['faqs_answer'] . "<br><br>";
    }
} else {
    echo $faqs; // Output "No Data" if the query fails
}
?>