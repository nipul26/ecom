<?php
include 'config.inc.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $updateSql = "UPDATE products SET isdisplayhome = !isdisplayhome WHERE product_id = '$id'";
    $result = mysqli_query($conn, $updateSql);

    echo $updateSql;
    die();

    if($result) {
        echo json_encode(array("status" => "true"));
    } else {
        echo json_encode(array("status" => "false"));
    }
} else {
    echo json_encode(array("status" => "false", "message" => "Invalid request."));
}
?>
