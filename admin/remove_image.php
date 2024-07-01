<?php
include "config.inc.php";

if (isset($_POST['image_id']) && !empty($_POST['image_id'])) {
    $imageId = mysqli_real_escape_string($conn, $_POST['image_id']);

    // Query to delete the image from database
    $deleteSql = mysqli_query($conn, "DELETE FROM product_multiple_images WHERE product_images_id = '$imageId'");

    if ($deleteSql) {
        echo 'success'; // Return success message if deletion was successful
    } else {
        echo 'error'; // Return error message if deletion failed
    }
} else {
    echo 'error'; // Return error if image_id is not provided
}
?>
