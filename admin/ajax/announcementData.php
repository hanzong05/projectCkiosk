<?php
include "../../class/connection.php";

$announcementID = isset($_REQUEST['announcementID']) ? intval($_REQUEST['announcementID']) : 0;

$sql = '
    SELECT 
        * 
    FROM 
        announcement_tbl
    WHERE
        announcement_id = :announcementID
';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':announcementID', $announcementID, PDO::PARAM_INT);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = '';
if ($array) {
    foreach ($array as $value) {
        $response .= '<div class="mb-3">
            <input type="hidden" value="' . htmlspecialchars($value['announcement_id'], ENT_QUOTES, 'UTF-8') . '" name="aid">
            <label for="summernote2" class="form-label fw-bold">Announcement Details</label>
            <textarea id="summernote2" name="announcement_details" required>' . htmlspecialchars($value['announcement_details'], ENT_QUOTES, 'UTF-8') . '</textarea>
        </div>
        <div class="mb-3">
            <input type="hidden" name="previous" value="' . htmlspecialchars($value['announcement_image'], ENT_QUOTES, 'UTF-8') . '" />
            <label for="ann_img" class="form-label fw-bold">Photo</label>
            <input type="file" class="form-control" name="ann_img" id="ann_img">
        </div>';
    }
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
                    // Add a default paragraph if content is empty
                    var currentContent = $('#summernote2').summernote('code');
                    if (!currentContent.trim()) {
                        $('#summernote2').summernote('code', '<p style="color: yellow;">Start writing here...</p>');
                    }

                    // Apply default styling to the editor
                    $('.note-editor').css({
                        'border': '1px solid #ccc',
                        'border-radius': '4px',
                        'padding': '10px'
                    });

                    // Apply default text color to the editor content
                    $('.note-editable').css('color', 'yellow');
                }
            }
        });
    });
</script>
