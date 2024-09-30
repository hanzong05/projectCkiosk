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

if ($array) {
    foreach ($array as $key => $value) {
        $req = $value['org_image'] == "" ? "required" : "";
        $response = '<input type="hidden" value="' . $value['org_id'] . '" name="oid">
                    <div class="mb-3">
                        <center>
                        <h3>Current Photo</h3>
                        <img src="../uploaded/orgUploaded/' . $value['org_image']'/>
                        <input type="hidden" name="previous"
                            value="' . $value['org_image'] . '" />
                        </center>
                    </div>
                    <div class="mb-3">
                        <label for="org_image" class="form-label fw-bold">Photo</label>
                        <input type="file" id="org_image" class="form-control" name="org_image" ' . $req . '>
                    </div>
                    <div class="mb-3">
                        <label for="org_name" class="form-label fw-bold">Organization Name</label>
                        <input type="text" id="org_name" class="form-control" value="' . $value['org_name'] . '" name="org_name" required>
                    </div>
                    ';
    }
}

echo $response;

?>