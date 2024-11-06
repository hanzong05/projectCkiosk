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
