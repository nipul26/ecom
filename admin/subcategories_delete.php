<?php
include 'config.inc.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Get the main category ID of the subcategory
    $getSubcategorySql = "SELECT categories_id FROM subcategories WHERE sub_categories_id = '$id'";
    $subcategoryResult = mysqli_query($conn, $getSubcategorySql);

    if ($subcategoryResult && mysqli_num_rows($subcategoryResult) > 0) {
        $subcategoryData = mysqli_fetch_assoc($subcategoryResult);
        $categories_id = $subcategoryData['categories_id'];

        // Delete the subcategory
        $deleteSql = "DELETE FROM subcategories WHERE sub_categories_id = '$id'";
        $result = mysqli_query($conn, $deleteSql);

        if ($result) {
            // Check if there are any subcategories left for the main category
            $checkSubcategoriesSql = "SELECT COUNT(*) as subcategory_count FROM subcategories WHERE categories_id = '$categories_id'";
            $checkResult = mysqli_query($conn, $checkSubcategoriesSql);
            $checkData = mysqli_fetch_assoc($checkResult);

            if ($checkData['subcategory_count'] == 0) {
                // If no subcategories are left, delete the main category
                $deleteCategorySql = "DELETE FROM categories WHERE categories_id = '$categories_id'";
                mysqli_query($conn, $deleteCategorySql);
            }

            $jsonArray = array('status' => 'true', 'msg' => 'Your data has been deleted.');
        } else {
            $jsonArray = array('status' => 'false', 'msg' => 'Your data has not been deleted.');
        }
    } else {
        $jsonArray = array('status' => 'false', 'msg' => 'Invalid subcategory ID.');
    }
} else {
    $jsonArray = array('status' => 'false', 'msg' => 'Invalid request.');
}

echo json_encode($jsonArray);
?>
