<?php
// error_log.php

// Set error reporting for all errors and warnings
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', 'error_log.txt');

// Check if the POST request contains the 'addedImages' data
if (isset($_POST['addedImages'])) {
    $addedImages = $_POST['addedImages'];

    // Log the addedImages array to a file
    error_log("Added Images: " . print_r($addedImages, true), 3, "added_images_log.txt");
    echo 'Images logged successfully';
} else {
    echo 'No images to log';
}
?>[06-Nov-2024 07:15:21 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwa</p>
    [type] => announcement
)

[06-Nov-2024 07:15:21 Europe/Berlin] Received type: announcement
[06-Nov-2024 07:17:07 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfes</p>
    [type] => announcement
)

[06-Nov-2024 07:17:07 Europe/Berlin] Received type: announcement
[06-Nov-2024 07:18:44 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfes</p>
    [type] => announcement
)

[06-Nov-2024 07:18:44 Europe/Berlin] Received type: announcement
[06-Nov-2024 07:20:44 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfes</p>
    [type] => announcement
)

[06-Nov-2024 07:20:44 Europe/Berlin] Received type: announcement
[06-Nov-2024 07:30:51 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadw</p>
    [type] => announcement
)

[06-Nov-2024 07:30:51 Europe/Berlin] Received type: announcement
[06-Nov-2024 07:32:37 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadw</p>
    [type] => announcement
)

[06-Nov-2024 07:32:37 Europe/Berlin] Received type: announcement
[06-Nov-2024 08:53:04 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadw</p>
    [type] => announcement
)

[06-Nov-2024 08:53:04 Europe/Berlin] Received type: announcement
[06-Nov-2024 08:58:42 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadw</p>
    [type] => announcement
)

[06-Nov-2024 08:58:42 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:01:00 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadwdwadwad</p>
    [type] => announcement
)

[06-Nov-2024 09:01:00 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:01:32 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadwdwadwad</p>
    [type] => announcement
)

[06-Nov-2024 09:01:32 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:13:57 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwad
    [announcement_creator] => 1
    [aid] => 2
    [announcement_details] => <p>dwadwafesfesfesdwadadwdwadwad</p>
    [type] => announcement
)

[06-Nov-2024 09:13:57 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:16:40 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwa
    [announcement_creator] => 1
    [aid] => 1
    [announcement_details] => <p>dwadwadwadwa</p>
    [type] => announcement
)

[06-Nov-2024 09:16:40 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:16:51 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwa
    [announcement_creator] => 1
    [aid] => 1
    [announcement_details] => <p>dwadwadwadwa</p>
    [type] => announcement
)

[06-Nov-2024 09:16:51 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:23:27 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwa
    [announcement_creator] => 1
    [aid] => 1
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 09:23:27 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:25:34 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwa
    [announcement_creator] => 1
    [aid] => 1
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 09:25:34 Europe/Berlin] Received type: announcement
[06-Nov-2024 09:26:52 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwadwa
    [announcement_creator] => 1
    [aid] => 1
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 09:26:52 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:19:10 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:19:10 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:19:22 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:19:22 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:19:38 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:19:38 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:26:28 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:26:28 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:44:23 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:44:23 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:45:27 Europe/Berlin] POST data: Array
(
    [removed_images] => annUploaded,annUploaded,annUploaded,annUploaded,annUploaded,annUploaded,annUploaded,annUploaded,annUploaded
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:45:27 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:46:39 Europe/Berlin] POST data: Array
(
    [removed_images] => 672b6cce5e873-pastries.jpg,672b6cda498b5-e3a95ea66a9ba30614d76dbf4d835a62.jpg
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:46:39 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:46:49 Europe/Berlin] POST data: Array
(
    [removed_images] => dwad_img1.jpg,dwad_img2.jpg,672b6cea8f105-e3a95ea66a9ba30614d76dbf4d835a62.jpg,672b6cea91049-good_bye_depression_by_klarem_dagk85u-pre.jpg,672b6e84a9290-e3a95ea66a9ba30614d76dbf4d835a62.jpg,672b6e84aa658-460420182_813571780676732_2248905488976422245_n.jpg,672b72b7b8593-FlavoredBread.jpg
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:46:49 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:52:28 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:52:28 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:54:21 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:54:21 Europe/Berlin] Received type: announcement
[06-Nov-2024 14:56:50 Europe/Berlin] POST data: Array
(
    [removed_images] => 672b749c13b62-S(1).jpg
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 14:56:50 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:19:40 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:19:40 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:23:14 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:23:14 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:27:55 Europe/Berlin] POST data: Array
(
    [removed_images] => 672bec52896bc-460536542_3148258328650716_8523106795125365583_n (1).jpg,672bec52889de-460536542_3148258328650716_8523106795125365583_n.jpg
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:27:55 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:28:06 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:28:06 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:28:15 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:28:15 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:31:04 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:31:04 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:31:13 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:31:13 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:41:32 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:41:32 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:43:26 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:43:26 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:49:07 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:49:07 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:49:26 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bf2635da91-459409450_1204033984034802_1712324931392426873_n.png","672bf10e60067-459409450_1204033984034802_1712324931392426873_n.png","672bf09c3dd78-459409450_1204033984034802_1712324931392426873_n.png"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:49:26 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:49:49 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:49:49 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:50:01 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:50:01 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:50:25 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:50:25 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:50:50 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bed7f5a662-good_bye_depression_by_klarem_dagk85u-pre.jpg","672bf09c3dd78-459409450_1204033984034802_1712324931392426873_n.png","672bf10e60067-459409450_1204033984034802_1712324931392426873_n.png","672bf2635da91-459409450_1204033984034802_1712324931392426873_n.png","672bf28dc6b00-FlavoredBread.jpg","672bf2997d4fd-e3a95ea66a9ba30614d76dbf4d835a62.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:50:50 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:51:05 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bed7f5a662-good_bye_depression_by_klarem_dagk85u-pre.jpg","672bf09c3dd78-459409450_1204033984034802_1712324931392426873_n.png","672bf10e60067-459409450_1204033984034802_1712324931392426873_n.png","672bf2635da91-459409450_1204033984034802_1712324931392426873_n.png","672bf28dc6b00-FlavoredBread.jpg","672bf2997d4fd-e3a95ea66a9ba30614d76dbf4d835a62.jpg","672bf2b1ae48a-FlavoredBread.jpg","672bf2cae67a0-458655329_1643189073206492_3274066267445684011_n.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:51:05 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:51:18 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bed7644872-460536542_3148258328650716_8523106795125365583_n (1).jpg","672bed7f5a662-good_bye_depression_by_klarem_dagk85u-pre.jpg","672bf09c3dd78-459409450_1204033984034802_1712324931392426873_n.png","672bf10e60067-459409450_1204033984034802_1712324931392426873_n.png","672bf2635da91-459409450_1204033984034802_1712324931392426873_n.png","672bf28dc6b00-FlavoredBread.jpg","672bf2997d4fd-e3a95ea66a9ba30614d76dbf4d835a62.jpg","672bf2b1ae48a-FlavoredBread.jpg","672bf2cae67a0-458655329_1643189073206492_3274066267445684011_n.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:51:18 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:52:05 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bed7f5a662-good_bye_depression_by_klarem_dagk85u-pre.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 4
    [announcement_details] => <p>dwad</p>
    [type] => announcement
)

[06-Nov-2024 23:52:05 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:53:48 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:53:48 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:53:48 Europe/Berlin] PHP Fatal error:  Uncaught TypeError: array_merge(): Argument #2 must be of type array, string given in C:\xampp\htdocs\ckiosk\admin\ajax\editData.php:76
Stack trace:
#0 C:\xampp\htdocs\ckiosk\admin\ajax\editData.php(76): array_merge(Array, '')
#1 {main}
  thrown in C:\xampp\htdocs\ckiosk\admin\ajax\editData.php on line 76
[06-Nov-2024 23:54:48 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:54:48 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:54:55 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:54:55 Europe/Berlin] Received type: announcement
[06-Nov-2024 23:57:26 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:57:26 Europe/Berlin] Received type: announcement
New Uploaded Image: 672bf45617a6d-FlavoredBread.jpg
[06-Nov-2024 23:59:01 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:59:01 Europe/Berlin] Received type: announcement
Requested New Image Upload: 460536542_3148258328650716_8523106795125365583_n.jpg
Error: Failed to upload file: 460536542_3148258328650716_8523106795125365583_n.jpg
[06-Nov-2024 23:59:26 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:59:27 Europe/Berlin] Received type: announcement
Requested New Image Upload: 458655329_1643189073206492_3274066267445684011_n.jpg
Error: Failed to upload file: 458655329_1643189073206492_3274066267445684011_n.jpg
[06-Nov-2024 23:59:54 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg","672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg","672bf45617a6d-FlavoredBread.jpg","672bf45617a6d-FlavoredBread.jpg","672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png","672bf3b861a9a-460536542_3148258328650716_8523106795125365583_n (1).jpg",""]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[06-Nov-2024 23:59:54 Europe/Berlin] Received type: announcement
Requested Removal of Image: ["672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg"
Removed Image: ["672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg"
Requested Removal of Image: "672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg"
Removed Image: "672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg"
Requested Removal of Image: "672bf45617a6d-FlavoredBread.jpg"
Removed Image: "672bf45617a6d-FlavoredBread.jpg"
Requested Removal of Image: "672bf45617a6d-FlavoredBread.jpg"
Removed Image: "672bf45617a6d-FlavoredBread.jpg"
Requested Removal of Image: "672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png"
Removed Image: "672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png"
Requested Removal of Image: "672bf3b861a9a-460536542_3148258328650716_8523106795125365583_n (1).jpg"
Removed Image: "672bf3b861a9a-460536542_3148258328650716_8523106795125365583_n (1).jpg"
Requested Removal of Image: ""]
Removed Image: ""]
[07-Nov-2024 00:00:28 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png","672bf45617a6d-FlavoredBread.jpg","672bf45617a6d-FlavoredBread.jpg","672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg","672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[07-Nov-2024 00:00:28 Europe/Berlin] Received type: announcement
[07-Nov-2024 00:00:28 Europe/Berlin] PHP Fatal error:  Uncaught TypeError: array_merge(): Argument #2 must be of type array, string given in C:\xampp\htdocs\ckiosk\admin\ajax\editData.php:76
Stack trace:
#0 C:\xampp\htdocs\ckiosk\admin\ajax\editData.php(76): array_merge(Array, '')
#1 {main}
  thrown in C:\xampp\htdocs\ckiosk\admin\ajax\editData.php on line 76
[07-Nov-2024 00:00:40 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png","672bf45617a6d-FlavoredBread.jpg","672bf45617a6d-FlavoredBread.jpg","672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg","672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[07-Nov-2024 00:00:40 Europe/Berlin] Received type: announcement
[07-Nov-2024 00:01:36 Europe/Berlin] POST data: Array
(
    [removed_images] => ["672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png","672bf45617a6d-FlavoredBread.jpg","672bf45617a6d-FlavoredBread.jpg","672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg","672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg"]
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[07-Nov-2024 00:01:36 Europe/Berlin] Received type: announcement
[07-Nov-2024 00:02:06 Europe/Berlin] POST data: Array
(
    [removed_images] => Z,672bf45617a6d-FlavoredBread.jpg,672bf45617a6d-FlavoredBread.jpg,672bf4b5e0ed5-460536542_3148258328650716_8523106795125365583_n.jpg,672bf4cf01648-458655329_1643189073206492_3274066267445684011_n.jpg,672bf3b861a9a-460536542_3148258328650716_8523106795125365583_n (1).jpg
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[07-Nov-2024 00:02:07 Europe/Berlin] Received type: announcement
[07-Nov-2024 00:02:13 Europe/Berlin] POST data: Array
(
    [removed_images] => 672bf3bfdccd7-459409450_1204033984034802_1712324931392426873_n.png
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[07-Nov-2024 00:02:13 Europe/Berlin] Received type: announcement
[07-Nov-2024 00:02:27 Europe/Berlin] POST data: Array
(
    [removed_images] => 
    [announcement_title] => dwad
    [announcement_creator] => 34
    [aid] => 5
    [announcement_details] => <p>dwadwad</p>
    [type] => announcement
)

[07-Nov-2024 00:02:27 Europe/Berlin] Received type: announcement
