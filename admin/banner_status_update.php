<?php
include 'config.inc.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $updateSql = "UPDATE banner SET banner_status = !banner_status WHERE banner_id = '$id'";
    $result = mysqli_query($conn, $updateSql);

    if($result) {
        echo json_encode(array("status" => "true"));
    } else {
        echo json_encode(array("status" => "false"));
    }
} else {
    echo json_encode(array("status" => "false", "message" => "Invalid request."));
}
?>