<?php
include 'config.inc.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    $deleteSql = "DELETE FROM categories WHERE categories_id = '$id'";
    $result = mysqli_query($conn, $deleteSql);
    if($result) {

        $jsonArray = array('status' => 'true', 'msg' => 'Your data has been deleted.');
        // echo json_encode(array("status" => "success"));
    } else {

        $jsonArray = array('status' => 'false', 'msg' => 'Your data has not been deleted.');
        // echo json_encode(array("status" => "error"));
    }
} else {
    $jsonArray = array('status' => 'false', 'msg' => 'Invalid request.');
    // echo json_encode(array("status" => "error", "message" => "Invalid request."));
}
    echo json_encode($jsonArray);

?>
