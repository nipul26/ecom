<?php include "header.php"; ?>
<?php 
if(isset($_POST['submit'])){

    $categories_name = mysqli_real_escape_string($conn, $_POST['categories_name']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_keyword = mysqli_real_escape_string($conn, $_POST['meta_keyword']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');
    $isDisplayHome = isset($_POST['banner_status']) ? 1 : 0;
    $target_dir = "../media/";

    $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["category_image"]["tmp_name"]);
    if($check === false) { ?>
        <script>swal('Error', 'File is not an image.', 'error');</script>
        <?php
        $uploadOk = 0;
    }

    if ($_FILES["category_image"]["size"] > 5000000) {
        ?>
        <script>swal('Error', 'File is too large.', 'error');</script>
        <?php
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        ?>
        <script>swal('Error', 'Only JPG, JPEG, PNG & GIF files are allowed.', 'error');</script>
        <?php
        $uploadOk = 0;
    }

    $checkSql = mysqli_query($conn,"SELECT * FROM categories WHERE categories_name = '$categories_name'");
    if(mysqli_num_rows($checkSql) > 0){
        ?>
        <script>swal('Error', 'Data Already Exist.', 'error');</script>
        <?php
    } else {
        if ($uploadOk == 0) {
            ?>
            <script>swal('Error', 'Your file was not uploaded.', 'error');</script>
            <?php
        } else {
            if (is_uploaded_file($_FILES["category_image"]["tmp_name"])) {
                if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                    // Store only the image name in the database
                    $image_name = basename($_FILES["category_image"]["name"]);
                    $insertSql = mysqli_query($conn,"INSERT INTO `categories`(`categories_name`, `categories_status`, `images`, `isdisplayhome`, `meta_title`, `meta_keyword`, `meta_description`, `added_on`, `update_on`) VALUES ('$categories_name', '1', '$image_name', '$isDisplayHome', '$meta_title', '$meta_keyword', '$meta_description', '$added_on', '$updated_on')");
                    if($insertSql){
                        ?>
                        <script>swal('Success', 'Data Added Successfully.', 'success').then(function() { window.location = 'categories.php'; });</script>
                        <?php
                    } else {
                       ?>
                        <script>swal('Error', 'Something went wrong with the database.', 'error');</script>
                        <?php
                    }
                } else {
                    ?>
                    <script>swal('Error', 'There was an error uploading your file.', 'error');</script>
                    <?php
                }
            } else {
                ?>
                <script>swal('Error', 'Temporary file not found.', 'error');</script>
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
                            <h4 class="card-title">Add Category</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Category Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Category Name" name="categories_name" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom04">Category Image</label>
                                            <input type="file" class="form-control" id="validationCustom04" name="category_image" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="bannerStatus">Is Display Home </label>
                                            <input type="checkbox" id="bannerStatus" name="banner_status" value="active"> 
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_keyword">Meta Keyword</label>
                                            <input type="text" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" name="meta_keyword" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_description">Meta Description</label>
                                            <input type="text" class="form-control" id="meta_description" placeholder="Enter Meta Description" name="meta_description" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
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
