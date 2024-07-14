<?php
include 'config.inc.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    $deleteSql = "DELETE FROM products WHERE product_id = '$id'";
    $result = mysqli_query($conn, $deleteSql);
    if($result) {
        // check product muliple image and delete.
        $checkProductImages = mysqli_query($conn,"SELECT * FROM product_multiple_images WHERE product_main_id = '$id'");
        if(mysqli_num_rows($checkProductImages)>0){
            mysqli_query($conn,"DELETE FROM `product_multiple_images` WHERE product_main_id = '$id'");
        }

        // check product attributes and delete.
        $checkProductAttributes = mysqli_query($conn,"SELECT * FROM product_attribute_data WHERE product_attribute_main_id = '$id'");
        if(mysqli_num_rows($checkProductAttributes)>0){
            mysqli_query($conn,"DELETE FROM `product_attribute_data` WHERE product_attribute_main_id = '$id'");
        }

        $jsonArray = array('status' => 'true', 'msg' => 'Your data has been deleted.');
    } else {

        $jsonArray = array('status' => 'false', 'msg' => 'Your data has not been deleted.');
    }
} else {
    $jsonArray = array('status' => 'false', 'msg' => 'Invalid request.');

}
    echo json_encode($jsonArray);

?>
