<?php
require 'vendor/autoload.php'; // Adjust path as necessary

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Comment;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

// Create an instance of PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the headers
$headers = ['Name', 'Department'];
$sheet->fromArray($headers, NULL, 'A1'); // Set headers starting at cell A1

// Add informative comments to the columns
$comments = [
    'A2', // Name
    'B2'
];

$commentsText = [
    "Enter the full name of the faculty member.",
    "Enter the department (e.g., 'IT DEPARTMENT', 'MIS DEPARTMENT').",
    "Specify the specialization (e.g., 'Software Engineering').",
    "Provide the consultation time (e.g., 'Monday - Thursday 8:00 AM to 4:00 PM').",
    "Enter the image filename (e.g., 'image.png')."
];

// Loop through each cell to add comments
foreach ($comments as $index => $cell) {
    $comment = new Comment();
    $richText = new RichText();
    $richText->createText($commentsText[$index]);
    $comment->setText($richText);
    $comment->setAuthor('Admin');
    $sheet->getComment($cell)->setText($comment->getText());
    $sheet->getComment($cell)->setAuthor($comment->getAuthor());
}

// Optionally, set some formatting (e.g., bold headers)
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
];
$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

// Set headers for the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="faculty_format.xlsx"');
header('Cache-Control: max-age=0');

// Save the spreadsheet to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
