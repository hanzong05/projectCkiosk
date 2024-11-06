<?php
// Start session and include the database connection
session_start();
include "../../class/connection.php";

// Set error reporting to log all errors and warnings
error_reporting(E_ALL); // Report all errors
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error_log.txt'); // Specify the log file

$announcementID = isset($_REQUEST['announcementID']) ? intval($_REQUEST['announcementID']) : 0;

// Fetch the announcement details along with its associated images
$sql = '
    SELECT 
        a.*, 
        ai.image_path 
    FROM 
        announcement_tbl a
    LEFT JOIN 
        announcement_images ai ON a.announcement_id = ai.announcement_id
    WHERE
        a.announcement_id = :announcementID
';

try {
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':announcementID', $announcementID, PDO::PARAM_INT);
    $stmt->execute();
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

$response = '';
$images = [];

// Collect images for display and announcement details
if (!empty($array)) {
    $firstAnnouncement = $array[0]; // Get the first announcement for details

    // Display announcement detail
    $response .= '<input type="hidden" id="removed-images" name="removed_images" value="">'; // Add this line

    $announcementTitle = isset($firstAnnouncement['announcement_title']) ? htmlspecialchars($firstAnnouncement['announcement_title'], ENT_QUOTES, 'UTF-8') : '';
    $announcementDetails = isset($firstAnnouncement['announcement_details']) ? htmlspecialchars($firstAnnouncement['announcement_details'], ENT_QUOTES, 'UTF-8') : '';

    // Get the announcement ID safely
    $announcementId = isset($firstAnnouncement['announcement_id']) ? htmlspecialchars($firstAnnouncement['announcement_id'], ENT_QUOTES, 'UTF-8') : '';

    $response .= '<div class="mb-3">    
        <input type="text" id="announcement_title" name="announcement_title" class="form-control" value="' . $announcementTitle . '" required>
        <input type="hidden" value="' . htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') . '" name="announcement_creator">
        <input type="hidden" value="' . $announcementId . '" name="aid">
    </div>';
    $response .= '<div class="mb-3">
        <textarea id="summernote2" name="announcement_details" required>' . $announcementDetails . '</textarea>
    </div>';

    // Collect images for display
    $images = []; // Initialize images array
    foreach ($array as $value) {
        if (isset($value['image_path']) && !empty($value['image_path'])) {
            $images[] = htmlspecialchars($value['image_path'], ENT_QUOTES, 'UTF-8');
        }
    }

    if (!empty($images)) {
        $response .= '<div class="existing-images" style="overflow-x: auto; white-space: nowrap;">
            <div class="image-preview-container-edit" style="display: inline-block; width: 120px; margin-right: 10px; text-align: center;">';
        foreach ($images as $index => $image) {
            $response .= '<div class="image-preview-container-edit" style="display: inline-block; width: 120px; margin-right: 10px; text-align: center;">
                <img src="../uploaded/annUploaded/' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . '" alt="Announcement Image" class="announcement-image" data-index="' . $index . '">
                <input type="file" class="form-control" name="ann_imgs[]" accept=".jpg, .jpeg, .png, .gif" style="display: none;" onchange="handleImagePreview(event, this)">
                <div class="button-container" style="margin-top: 5px; display: flex; justify-content: center; gap: 10px;">
                    <button type="button" class="inline-flex items-center justify-center p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md edit-image">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md remove-image">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>';
        }
        $response .= '</div>';
    }

    // Add button to allow adding new images directly in the existing section
    $response .= '<button type="button" id="add-image-edit" class="inline-flex items-center justify-center p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-200 ease-in-out mt-2">
        <i class="fas fa-plus"></i>
    </button>';
}


echo $response;
?>

<script>
$(document).ready(function () {
    $('#summernote2').summernote({
        height: 220,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']]
        ],
        callbacks: {
            onInit: function() {
                var currentContent = $('#summernote2').summernote('code');
                if (!currentContent.trim()) {
                    $('#summernote2').summernote('code', '<p style="color: yellow;">Start writing here...</p>');
                }
                $('.note-editor').css({
                    'border': '1px solid #ccc',
                    'border-radius': '4px',
                    'padding': '10px'
                });
                $('.note-editable').css('color', 'yellow');
            }
        }
    });

    $('#add-image-edit').show();

    $(document).on('click', '.edit-image', function () {
        const imageContainer = $(this).closest('.image-preview-container-edit');
        const fileInput = imageContainer.find('input[type="file"]');
        fileInput.trigger('click');
    });

    window.handleImagePreview = function(event, input) {
        const preview = $(input).siblings('.announcement-image');
        const removeButton = $(input).siblings('.button-container').find('.remove-image');
        const editButton = $(input).siblings('.button-container').find('.edit-image');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
                removeButton.show();
                editButton.show();
                $(input).hide();
            };
            reader.readAsDataURL(file);
        }
    };

    $(document).on('click', '.remove-image', function () {
        const container = $(this).closest('.image-preview-container-edit');
        const imagePath = container.find('.announcement-image').attr('src').split('/').pop(); // Get the image filename
        container.remove();

        // Update the hidden input with the removed image
        const removedImagesInput = $('#removed-images');
        let removedImages = removedImagesInput.val();

        if (removedImages) {
            removedImages += ','; 
        }
        removedImages += imagePath; 
        removedImagesInput.val(removedImages); 

        if ($('.existing-images .image-preview-container-edit').length === 0) {
            $('#add-image-edit').hide();
        }
    });

    $('#add-image-edit').click(function () {
        $(this).hide();
        const newImagePreview = `
            <div class="image-preview-container-edit" style="display: inline-block; width: 120px; margin-right: 10px; text-align: center;">
                <input type="file" class="form-control" name="ann_imgs[]" accept=".jpg, .jpeg, .png, .gif" onchange="handleImagePreview(event, this)">
                <img src="" alt="Image Preview" class="announcement-image" style="display:none; width: 100px; height: 100px; object-fit: cover; margin-top: 5px;">
                <div class="button-container" style="margin-top: 5px; display: flex; justify-content: center; gap: 10px;">
                    <button type="button" class="inline-flex items-center justify-center p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md edit-image">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md remove-image">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `;
        $('.existing-images').append(newImagePreview);
    });
});
</script>