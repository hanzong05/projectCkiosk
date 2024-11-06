<?php
session_start();
include "../../class/connection.php";

// Set error reporting for all errors and warnings
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', 'error_log.txt');

// Fetch the announcement ID from the request
$announcementID = isset($_REQUEST['announcementID']) ? intval($_REQUEST['announcementID']) : 0;

// SQL query to fetch announcement details with associated images
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
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

$response = '';
$images = [];

if (!empty($announcements)) {
    $firstAnnouncement = $announcements[0]; // Get the first announcement details
    $response .= '<input type="hidden" id="removed-images" name="removed_images" value="">';

    // Prepare announcement details
    $announcementTitle = htmlspecialchars($firstAnnouncement['announcement_title'] ?? '', ENT_QUOTES, 'UTF-8');
    $announcementDetails = htmlspecialchars($firstAnnouncement['announcement_details'] ?? '', ENT_QUOTES, 'UTF-8');
    $announcementId = htmlspecialchars($firstAnnouncement['announcement_id'] ?? '', ENT_QUOTES, 'UTF-8');

    $response .= '<div class="mb-3">    
        <input type="text" id="announcement_title" name="announcement_title" class="form-control" value="' . $announcementTitle . '" required>
        <input type="hidden" value="' . htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') . '" name="announcement_creator">
        <input type="hidden" value="' . $announcementId . '" name="aid">
    </div>';
    $response .= '<div class="mb-3">
        <textarea id="summernote2" name="announcement_details" required>' . $announcementDetails . '</textarea>
    </div>';

    // Collect images for display
    foreach ($announcements as $announcement) {
        if (!empty($announcement['image_path'])) {
            $images[] = htmlspecialchars($announcement['image_path'], ENT_QUOTES, 'UTF-8');
        }
    }

    if (!empty($images)) {
        $response .= '<div class="existing-images" style="overflow-x: auto; white-space: nowrap;">
            <div class="image-preview-container-edit" style="display: inline-block; width: 120px; margin-right: 10px; text-align: center;">';
        foreach ($images as $index => $image) {
            $response .= '<div class="image-preview-container-edit" style="display: inline-block; width: 120px; margin-right: 10px; text-align: center;">
                <img src="../uploaded/annUploaded/' . $image . '" alt="Announcement Image" class="announcement-image" data-index="' . $index . '">
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

    // Button to add new images
    $response .= '<button type="button" id="add-image-edit" class="inline-flex items-center justify-center p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-200 ease-in-out mt-2">
        <i class="fas fa-plus"></i>
    </button>';
}

echo $response;
?>

<script>
$(document).ready(function () {
    // Define addedImages and removedImages arrays at the beginning
    let addedImages = [];
    let removedImages = [];

    // Initialize summernote for rich text editing
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

    // Show the "Add Image" button
    $('#add-image-edit').show();

    window.handleImagePreview = function(event, input) {
        const container = $(input).closest('.image-preview-container-edit');
        const preview = container.find('.announcement-image');
        const oldImagePath = preview.attr('src').split('/').pop();
        const removeButton = container.find('.remove-image');
        const editButton = container.find('.edit-image');

        const file = input.files[0];
        if (file) {
            // Add the old image filename to the removed images input
            if (oldImagePath) {
                const removedImagesInput = $('#removed-images');
                let removedImagesVal = removedImagesInput.val();
                if (removedImagesVal) {
                    removedImagesVal += ','; 
                }
                removedImagesVal += oldImagePath;
                removedImagesInput.val(removedImagesVal);
            }

            // Display the new image
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
                removeButton.show();
                editButton.show();
                $(input).hide();

                // Save the image filename to the addedImages array
                const fileName = file.name;
                addedImages.push(fileName);
                
                // Log addedImages array for debugging
                console.log('Added images:', addedImages);
                
                // Send the added images array to the server via AJAX
                $.ajax({
                    url: 'ajax/error_log.php',
                    method: 'POST',
                    data: {
                        added_images: JSON.stringify(addedImages)
                    },
                    success: function(response) {
                        console.log('Images logged to server');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error logging images to server:', error);
                    }
                });

                // Re-show the "Add Image" button if needed
                if ($('.existing-images .image-preview-container-edit').length > 0) {
                    $('#add-image-edit').show();
                }
            };
            reader.readAsDataURL(file);
        }
    };

    // Handle image removal
    $(document).on('click', '.remove-image', function () {
        const container = $(this).closest('.image-preview-container-edit');
        const imagePath = container.find('.announcement-image').attr('src').split('/').pop();
        container.remove();

        const removedImagesInput = $('#removed-images');
        let removedImagesVal = removedImagesInput.val();
        if (removedImagesVal) {
            removedImagesVal += ','; 
        }
        removedImagesVal += imagePath;
        removedImagesInput.val(removedImagesVal);

        // Show "Add Image" button again if no images are left
        if ($('.existing-images .image-preview-container-edit').length === 0) {
            $('#add-image-edit').show();
        }
    });

    // Add new image input
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
        $(this).before(newImagePreview);
    });
});
</script>
