<?php
include "../../class/connection.php";
$faqsID = 0;
if (!empty($_REQUEST['faqsID'])) {
    $faqsID = $_REQUEST['faqsID'];
}

$sql = '
        SELECT 
            * 
        FROM 
            faqs_tbl
        WHERE
            faqs_id = :faqsID
        ';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':faqsID', $faqsID);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($array) {
    foreach ($array as $key => $value) {
        $response = '<input type="hidden" value="' . $value['faqs_id'] . '" name="fid">
                    <div class="mb-3">
                        <label for="faqs_questionEdit" class="form-label fw-bold">Question</label>
                        <textarea type="text" id="faqs_questionEdit" class="form-control" name="faqs_question" required>' . $value['faqs_question'] . '</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="faqs_answerEdit" class="form-label fw-bold">Answer</label>
                        <textarea type="text" id="faqs_answerEdit" class="form-control" name="faqs_answer" required>' . $value['faqs_answer'] . '</textarea>
                    </div>
                    ';
    }
}

echo $response;

?>
<script>
    $('#faqs_questionEdit').summernote({
        height: 180,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']]
        ]
    });
    $('#faqs_answerEdit').summernote({
        height: 180,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']]
        ]
    });
</script>