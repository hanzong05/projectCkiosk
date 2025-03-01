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

$response = ''; // Initialize response string
$images = [];

// Check if there are any announcements
if (!empty($announcements)) {
    $firstAnnouncement = $announcements[0]; // Get the first announcement details
    $response .= '<input type="hidden" id="removed-images" name="removed_images" value="">';

    // Prepare announcement details
    $announcementTitle = htmlspecialchars($firstAnnouncement['announcement_title'] ?? '', ENT_QUOTES, 'UTF-8');
    $announcementDetails = htmlspecialchars($firstAnnouncement['announcement_details'] ?? '', ENT_QUOTES, 'UTF-8');
    $announcementId = htmlspecialchars($firstAnnouncement['announcement_id'] ?? '', ENT_QUOTES, 'UTF-8');

    // Start form and display announcement details
    $response .= '<div class="mb-3">    
        <input type="text" id="announcement_title" name="announcement_title" class="form-control" value="' . $announcementTitle . '" required>
        <input type="hidden" value="' . htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') . '" name="announcement_creator">
        <input type="hidden" value="' . $announcementId . '" name="aid">
    </div>';
    $response .= '<div class="mb-3">
        <textarea id="summernote2" name="announcement_details" required>' . $announcementDetails . '</textarea>
    </div>';

    // Collect unique images for display
    foreach ($announcements as $announcement) {
        if (!empty($announcement['image_path']) && !in_array($announcement['image_path'], $images)) {
            $images[] = htmlspecialchars($announcement['image_path'], ENT_QUOTES, 'UTF-8');
        }
    }
    
    // Start the existing-images container (it will always be displayed)
    $response .= '<div class="existing-images" style="display: flex; gap: 10px; align-items: center; overflow-x: auto; padding: 10px; border: 1px solid #ddd; border-radius: 5px; flex-wrap: wrap;">';
    
    // Check if there are any images
    if (!empty($images)) {
        $imageCount = count($images);
        $response .= '<input type="hidden" id="image-count" value="' . $imageCount . '">';
        foreach ($images as $index => $image) {
            $response .= '<div class="image-preview-container-edit" style="width: 120px; text-align: center; flex-shrink: 0;">
                <div class="mb-6 text-center">
                    <!-- Display the current image -->
                    <img src="../uploaded/annUploaded/' . $image . '" 
                         height="120" width="150" id="announcement_image_p" 
                         class="img-thumbnail rounded-full" 
                         style="min-width: 100px; max-width: 150px; min-height: 100px; max-height: 150px;" 
                         data-index="' . $index . '" />

                    <!-- Hidden field for the previous image (used for reference during form submission) -->
                    <input type="hidden" name="previous_image[]" value="' . $image . '" />
                    <input type="hidden" name="added_image[]" value="' . $image . '" />

                    <!-- Edit Image Button -->
                    <button type="button" class="inline-flex items-center justify-center p-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow-md edit-image" data-index="' . $index . '">
                        <i class="fas fa-edit"></i> Edit
                    </button>

                    <!-- Remove Image Button -->
                    <button type="button" class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md remove-image" data-index="' . $index . '">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <!-- Hidden file input for selecting a new image -->
                    <input type="file" name="new_image[]" class="hidden file-input" data-index="' . $index . '" accept="image/*" />
                </div>
            </div>';
        }
    } else {
        // If no images exist, still create the image count input with 0
        $response .= '<input type="hidden" id="image-count" value="0">';
    }

    // Close the existing-images container
    $response .= '</div>';

    // Add Image Button (always visible, even if there are no images)
    $response .= '<button type="button" id="add-image-edit" class="inline-flex items-center justify-center p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-200 ease-in-out" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <i class="fas fa-plus"></i> Add Image
    </button>';
}

echo $response;
?>
<script>$(document).ready(function () {
    let imageIndex = parseInt($('#image-count').val() || '0', 10);
    let newImages = [];

    // Summernote initialization remains the same
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
                const currentContent = $('#summernote2').summernote('code');
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

    // Function to handle file selection and preview
    function handleFileSelection(file, index, isEdit = false) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (isEdit) {
                // Update existing image preview
                const img = $('img[data-index="' + index + '"]');
                img.attr('src', e.target.result);
                img.show(); // Make sure the image is visible
            } else {
                // Create new image preview for added images
                const preview = `
                <div class="image-preview-container-edit" data-index="${index}" style="width: 120px; text-align: center; flex-shrink: 0;">
                    <div class="mb-6 text-center">
                        <img src="${e.target.result}" 
                             class="img-thumbnail rounded-full" 
                             style="min-height: 100px; max-height: 150px; min-width: 100px; max-width: 150px;" />
                        <input type="hidden" name="added_image[]" value="${file.name}" />
                        <input type="file" name="new_image[]" class="hidden file-input" data-index="${index}" accept="image/*" />
                        
                        <button type="button" class="inline-flex items-center justify-center p-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow-md edit-image-add" data-index="${index}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md remove-image-add" data-index="${index}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>`;
                
                $('.existing-images').append(preview);
                newImages.push(file.name);
            }
        };
        reader.readAsDataURL(file);
    }

    // Handle Edit Image Button Click (original images)
    $('.edit-image').on('click', function() {
        const index = $(this).data('index');
        const fileInput = $('input[type="file"][data-index="' + index + '"]');
        fileInput.trigger('click');
    });

    // Handle file input change for original images
    $('input[type="file"].file-input').on('change', function(event) {
        const index = $(this).data('index');
        const file = event.target.files[0];
        if (file) {
            handleFileSelection(file, index, true);
        }
    });

    // Handle Remove Image Button Click (original images)
    $('.remove-image').on('click', function() {
        const index = $(this).data('index');
        const imagePath = $('input[name="previous_image[]"]').eq(index).val();
        let removedImages = $('#removed-images').val() ? $('#removed-images').val().split(',') : [];
        
        if (!removedImages.includes(imagePath)) {
            removedImages.push(imagePath);
        }
        $('#removed-images').val(removedImages.join(','));
        $(this).closest('.image-preview-container-edit').remove();
    });

    // Add Image Button Click
    $('#add-image-edit').on('click', function() {
        const tempFileInput = $('<input type="file" accept="image/*" style="display: none;">');
        $('body').append(tempFileInput);
        
        tempFileInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                handleFileSelection(file, imageIndex, false);
                imageIndex++;
            }
            tempFileInput.remove();
        });
        
        tempFileInput.click();
    });

    // Edit Added Image
    $(document).on('click', '.edit-image-add', function() {
        const index = $(this).data('index');
        const container = $(`.image-preview-container-edit[data-index="${index}"]`);
        const fileInput = container.find('input[type="file"]');
        
        fileInput.off('change').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.find('img').attr('src', e.target.result);
                    container.find('input[name="added_image[]"]').val(file.name);
                };
                reader.readAsDataURL(file);
            }
        });
        
        fileInput.trigger('click');
    });

    // Remove Added Image
    $(document).on('click', '.remove-image-add', function() {
        const index = $(this).data('index');
        const container = $(`.image-preview-container-edit[data-index="${index}"]`);
        const filename = container.find('input[name="added_image[]"]').val();
        
        const imageIndex = newImages.indexOf(filename);
        if (imageIndex > -1) {
            newImages.splice(imageIndex, 1);
        }
        
        container.remove();
    });
});
</script>