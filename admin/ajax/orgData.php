<?php
include "../../class/connection.php";

$orgID = 0;
if (!empty($_REQUEST['orgID'])) {
    $orgID = $_REQUEST['orgID'];
}

$sql = '
        SELECT 
            * 
        FROM 
            organization_tbl
        WHERE
            org_id = :orgID
        ';

$stmt = $connect->prepare($sql);
$stmt->bindValue(':orgID', $orgID);
$stmt->execute();
$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = ""; // Initialize response

if ($array) {
    foreach ($array as $key => $value) {
        $req = empty($value['org_image']) ? "required" : ""; // Adjusted for clarity
        $orgId = htmlspecialchars($value['org_id']);
        $orgImage = htmlspecialchars(html_entity_decode($value['org_image'])); // Decode HTML entities
        $orgName = htmlspecialchars(html_entity_decode($value['org_name'])); // Decode HTML entities

        $response .= '<input type="hidden" value="' . $orgId . '" name="oid">
                    <div class="mb-3">
                        <center>
                        <h3>Current Photo</h3>
                        <img src="../uploaded/orgUploaded/' . $orgImage . '" alt="Current Organization Image"/>
                        <input type="hidden" name="previous" value="' . $orgImage . '" />
                        </center>
                    </div>
                    <div class="mb-3">
                        <label for="org_image" class="form-label fw-bold">Photo</label>
                        <input type="file" id="org_image" class="form-control" name="org_image" ' . $req . '>
                    </div>
                    <div class="mb-3">
                        <label for="org_name" class="form-label fw-bold">Organization Name</label>
                        <input type="text" id="org_name" class="form-control" value="' . $orgName . '" name="org_name" required>
                    </div>
                    ';
    }
}

echo $response;

?>
