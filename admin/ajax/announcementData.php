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
if (!empty($images)) {$imageCount = count($images);
    $response .= '<input type="hidden" id="image-count" value="' . $imageCount . '">';
    foreach ($images as $index => $image) {
        $response .= '<div class="image-preview-container-edit" style="width: 120px; text-align: center; flex-shrink: 0;">
            <div class="mb-6 text-center">
                <!-- Display the current image -->
                <img src="../uploaded/annUploaded/' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . '" 
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
<script>
$(document).ready(function () {
   // Set the initial index based on the number of existing images
let imageIndex = parseInt($('#image-count').val(), 10);

    let newImages = []; // Array to store newly uploaded images (previously addedImages)
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

    // Handle Edit Image Button Click (Show file input for new image)
   // Handle Edit Image Button Click (Show file input for new image)
$('.edit-image').on('click', function() {
    const index = $(this).data('index'); // Get the index of the clicked image
    const fileInput = $('input[type="file"][data-index="' + index + '"]'); // Get the corresponding file input
    fileInput.trigger('click'); // Directly trigger the file input click event to open the file dialog
});
// Handle file input change (update image preview when a new image is selected)
$('input[type="file"].file-input').on('change', function(event) {
    const index = $(this).data('index'); // Get the index of the selected image
    const file = event.target.files[0]; // Get the selected file
    const reader = new FileReader(); // Create a new FileReader to read the file

    // When the file is loaded, update the preview image
    reader.onload = function(e) {
        // Find the current image and hide it
        const currentImage = $('img[data-index="' + index + '"]');
        
        // If an image exists, hide it before inserting the new one
        currentImage.hide();

        // Create a new image element to show the selected image
        const newImage = $('<img>', {
            src: e.target.result, // Set the source to the newly selected image
            height: 120,
            width: 150,
            class: 'img-thumbnail rounded-full', 
            style: 'min-width: 100px; max-width: 150px; min-height: 100px; max-height: 150px;',
            'data-index': index // Ensure the new image has the same index
        });

        // Replace the old image with the new image
        currentImage.replaceWith(newImage);
    };

    // Read the file as a Data URL (to display the image in the preview)
    if (file) {
        reader.readAsDataURL(file);
    }
});


    // Handle Remove Image Button Click (Mark image for removal)
    $('.remove-image').on('click', function() {
        const index = $(this).data('index');
        const imagePath = $('input[name="previous_image[]"]').eq(index).val();

        // Get current removed images, filtering out any empty values
        let removedImages = $('#removed-images').val() ? $('#removed-images').val().split(',') : [];
        
        // Add the image path if it is not already in the list
        if (!removedImages.includes(imagePath)) {
            removedImages.push(imagePath);
        }

        // Update the hidden input with the removed images list
        $('#removed-images').val(removedImages.join(','));

        // Remove the image preview from the UI
        $(this).closest('.image-preview-container-edit').remove();
    });

$('#add-image-edit').on('click', function() {
    console.log("Add clicked - current imageIndex:", imageIndex);

    // Create a new file input with the updated index
    const fileInput = $('<input type="file" name="new_image[]" class="hidden file-input" data-index="' + imageIndex + '" accept="image/*" />');

    // Append the new file input to the form
    $('form').append(fileInput);

    // Trigger the file selection dialog
    fileInput.click();

    // Handle the file selection
    fileInput.on('change', function() {
        const files = this.files;

        if (files.length > 0) {
            // Create an image preview for each selected file
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = `
                    <div class="image-preview-container-edit" data-index="${imageIndex}" style="width: 120px; text-align: center; flex-shrink: 0;">
                        <div class="mb-6 text-center">
                            <img src="${e.target.result}" 
                                 class="img-thumbnail rounded-full" 
                                 style="min-height: 100px; max-height: 150px; min-width: 100px; max-width: 150px;" />
                            <input type="hidden" name="added_image[]" value="${files[i].name}" />
                            
                            <button type="button" class="inline-flex items-center justify-center p-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow-md edit-image-add" data-index="${imageIndex}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md remove-image" data-index="${imageIndex}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>`;
                    
                    // Append the preview to the form or container
                    $('.existing-images').append(preview);

                    // Add the image to the newImages array
                    newImages.push(files[i].name);  // Store the filename in the array

                    console.log("Image added with index:", imageIndex, "Filename:", files[i].name);
                };
                reader.readAsDataURL(files[i]);
                imageIndex++; // Increment imageIndex for the next image
            }
        }
    });
});

// Handle Remove Image Button Click (Remove from DOM, array, and file input)
$(document).on('click', '.remove-image', function() {
    const index = $(this).data('index');  // Get the image index

    // Remove the image preview from the DOM
    const previewContainer = $(this).closest('.image-preview-container-edit');
    previewContainer.remove();

    // Get the image name from the hidden input and remove it from the newImages array
    const removedImage = previewContainer.find('input[name="added_image[]"]').val();
    newImages = newImages.filter((image) => image !== removedImage);  // Remove the image name from the array

    // Also remove the corresponding file input from the DOM
    $('input[type="file"][data-index="' + index + '"]').remove();

    // Log the updated newImages array
    console.log('Updated newImages array after removal:', newImages);  // Log the updated array for debugging
});


// Handle Image Change (Update preview and array with new image)
$(document).on('change', 'input[type="file"].edit-image-input', function() {
    const fileInput = $(this);  // Get the file input element
    const index = fileInput.data('index');  // Get the index for the image
    const files = fileInput[0].files;  // Get the selected files
   // Log the current state of newImages when the edit button is clicked
   console.log("Current newImages object before editing image:", newImages);
    if (files.length > 0) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Find the image preview container
            const imagePreviewContainer = $('div[data-index="' + index + '"]').closest('.image-preview-container-edit');
            const currentImage = imagePreviewContainer.find('img');  // Find the image element
            
            // Get the filename of the new image
            const newFilename = files[0].name;

            // Find the current image's filename from the hidden input
            const currentImageInput = imagePreviewContainer.find('input[name="added_image[]"]');
            const currentImageName = currentImageInput.val();  // Get the old filename

            // If there was an old image, remove it from the `newImages` object
            if (currentImageName && newImages[index] === currentImageName) {
                // Remove the old image filename from the `newImages` object based on the index
                delete newImages[index]; 
                console.log("Old image removed for index:", index);
            }

            // Add the new filename to the `newImages` object for this index
            newImages[index] = newFilename;

            // Log the updated newImages object after editing
            console.log('Updated newImages array after editing:', newImages);  // Log the updated array for debugging

            // Update the image preview with the new source
            currentImage.attr('src', e.target.result);  // Update image preview with new source

            // Update the hidden input value with the new filename
            currentImageInput.val(newFilename);  // Update the hidden input with the new filename
        };

        reader.readAsDataURL(files[0]);  // Read the file as a DataURL for preview
    }
});

// Log the newImages object when editing the image (when edit button is clicked)
$(document).on('click', '.edit-image-add', function() {
    const fileInput = $(this).closest('.image-preview-container-edit').find('input[type="file"]');
    const index = fileInput.data('index');  // Get the index for the image

 
    
    // Trigger the click on the file input to open the file dialog
    fileInput.click();
});

});

</script>

