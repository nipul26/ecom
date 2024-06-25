<?php
include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
$categoryName = '';
$categories_id = '';

if (isset($_GET['categories_id'])) {
    $categories_id = $_GET['categories_id'];
    $categoryQuery = mysqli_query($conn, "SELECT categories_name FROM categories WHERE categories_id = '$categories_id'");
    $categoryData = mysqli_fetch_assoc($categoryQuery);
    if ($categoryData) {
        $categoryName = $categoryData['categories_name'];
    } else { ?>
        <script>swal('Error', 'Invalid category ID.', 'error').then(function() {
            window.location = 'SidemenuSubcategories.php';
        });</script>
        <?php
        exit;
    }
}

if (isset($_POST['submit'])) {
    $categories_id = $_POST['categories_id'];
    $categories_name = mysqli_real_escape_string($conn, $_POST['categories_name']);
    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');

    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $categories_name)) { ?>
        <script>swal('Error', 'Category name must start with alphabets and cannot contain spaces or special characters at the beginning.', 'error');</script>
        <?php
    } else {
        // Check if the subcategory already exists for the given category
        $checkSql = mysqli_query($conn, "SELECT * FROM subcategories WHERE sub_categories_name = '$categories_name' AND categories_id = '$categories_id'");
        if (mysqli_num_rows($checkSql) > 0) { ?>
            <script>swal('Error', 'Subcategory name already exists.', 'error');</script>
            <?php
        } else {
            $insertSql = mysqli_query($conn, "INSERT INTO `subcategories`(`categories_id`, `sub_categories_name`, `sub_categories_images`, `status`, `added_on`, `update_on`) VALUES ('$categories_id', '$categories_name', '', '1', '$added_on', '$updated_on')");
            if ($insertSql) {
                $sub_categories_id = mysqli_insert_id($conn);
                $uploadOk = 1;
                $target_dir = "../media/subcategories/";

                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                foreach ($_FILES['category_images']['name'] as $key => $val) {
                    $target_file = $target_dir . basename($_FILES['category_images']['name'][$key]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES['category_images']['tmp_name'][$key]);

                    if ($check === false) { ?>
                        <script>swal('Error', 'File "<?php echo basename($_FILES['category_images']['name'][$key]); ?>" is not an image.', 'error');</script>
                        <?php
                        $uploadOk = 0;
                        break;
                    }
                    if ($_FILES['category_images']['size'][$key] > 5000000) { ?>
                        <script>swal('Error', 'File "<?php echo basename($_FILES['category_images']['name'][$key]); ?>" is too large.', 'error');</script>
                        <?php
                        $uploadOk = 0;
                        break;
                    }
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { ?>
                        <script>swal('Error', 'Only JPG, JPEG, PNG & GIF files are allowed.', 'error');</script>
                        <?php
                        $uploadOk = 0;
                        break;
                    }
                    if ($uploadOk == 1) {
                        if (move_uploaded_file($_FILES['category_images']['tmp_name'][$key], $target_file)) {

                            $current_images = '';
                            $getImagesQuery = mysqli_query($conn, "SELECT sub_categories_images FROM subcategories WHERE sub_categories_id = '$sub_categories_id'");
                            $currentData = mysqli_fetch_assoc($getImagesQuery);
                            if ($currentData) {
                                $current_images = $currentData['sub_categories_images'];
                                if (!empty($current_images)) {
                                    $current_images .= ',';
                                }
                                $current_images .= $target_file;
                            } else {
                                $current_images = $target_file;
                            }

                            $updateImagesSql = mysqli_query($conn, "UPDATE subcategories SET sub_categories_images = '$current_images' WHERE sub_categories_id = '$sub_categories_id'");
                            if (!$updateImagesSql) { ?>
                                <script>swal('Error', 'Failed to update subcategory with image path.', 'error');</script>
                                <?php
                                $uploadOk = 0;
                                break;
                            }
                        } else {
                            $error = error_get_last();
                            $errorMessage = $error['message'];
                            ?>
                            <script>swal('Error', 'Failed to move file to destination folder. <?php echo $errorMessage; ?>', 'error');</script>
                            <?php
                            $uploadOk = 0;
                            break;
                        }
                    }
                }

                if ($uploadOk == 1) { ?>
                    <script>
                    swal('Success', 'Data Added Successfully.', 'success').then(function() { window.location = 'subcategories_listing.php'; });</script>
                    <?php
                }
            } else { ?>
                <script>swal('Error', 'Something went wrong with the database.', 'error');</script>
                <?php
            }
        }
    }
}
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="category_name">Category Name</label>
                                            <select class="form-control" id="category_name" name="categories_id" required>
                                                <option value="">Select Category</option>
                                                <?php
                                                $categoriesQuery = mysqli_query($conn, "SELECT categories_id, categories_name FROM categories");
                                                while ($row = mysqli_fetch_assoc($categoriesQuery)) { ?>
                                                    <option value="<?php echo $row['categories_id']; ?>" <?php echo ($row['categories_id'] == $categories_id) ? 'selected' : ''; ?>><?php echo $row['categories_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Sub Category Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Sub Category Name" name="categories_name" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom04">Sub Category Images</label>
                                            <input type="file" class="form-control" id="validationCustom04" name="category_images[]" multiple required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="categories.php" class="btn btn-primary" style="color:white;">Back</a>
                                <button class="btn btn-success" name="submit" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
