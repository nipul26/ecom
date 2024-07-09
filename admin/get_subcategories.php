<?php
include "config.inc.php";

if (isset($_POST['categories_id'])) {
    $categories_id = mysqli_real_escape_string($conn, $_POST['categories_id']);

    $query = "SELECT sub_categories_id, sub_categories_name FROM subcategories WHERE categories_id = '$categories_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select Subcategory</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['sub_categories_id'] . '">' . $row['sub_categories_name'] . '</option>';
        }
    } else {
        echo '<option value="">No Subcategories Found</option>';
    }
}
?>

