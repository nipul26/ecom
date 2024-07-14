<?php include "header.php"; ?>
<?php 
if($_GET['type'] == 'edit' && $_GET['id'] != ''){
    $currentId = $_GET['id'];
    $getSql = mysqli_query($conn, "SELECT * FROM categories WHERE categories_id = '$currentId'");
    $getData = mysqli_fetch_assoc($getSql);
    $currentFirstCategoryName = $getData['categories_name'];
    $currentImage = $getData['images'];

    if(isset($_POST['submit'])) {
        $newCategoryName = mysqli_real_escape_string($conn, $_POST['category_name']);

        // Image upload handling
        if(!empty($_FILES["category_image"]["tmp_name"])) {
            $target_dir = "../media/";
            $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES["subcategory_image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["subcategory_image"]["size"] > 500000) {
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                // Handle file upload error
            } else {
                if (move_uploaded_file($_FILES["subcategory_image"]["tmp_name"], $target_file)) {
                    // File is uploaded successfully
                } else {
                    // Handle file upload error
                }
            }

            // Store only the image name in the database
            $newCategoryImage = mysqli_real_escape_string($conn, basename($_FILES["subcategory_image"]["name"]));
        } else {
            $newCategoryImage = $currentImage; // If no new image is uploaded, keep the current image
        }

        $checkRecordSql = mysqli_query($conn, "SELECT * FROM categories WHERE categories_name = '$newCategoryName' AND categories_id != '$currentId'");
    
        if(mysqli_num_rows($checkRecordSql) > 0) {
            ?>
            <script type="text/javascript">
                swal({
                    title: "Warning",
                    text: "Data already exists.",
                    icon: "error",
                    button: "Okay",
                });
            </script>
            <?php
        } else {
            $updated_on = date('Y-m-d H:i:s');
            $updateSql = mysqli_query($conn, "UPDATE categories SET categories_name = '$newCategoryName', images= '$newCategoryImage', update_on = '$updated_on' WHERE categories_id = '$currentId'");
        
            if($updateSql) {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Data updated successfully.",
                        icon: "success",
                        button: "Okay",
                    }).then(function() {
                        window.location = "categories.php";
                    });
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Error",
                        text: "Failed to update.",
                        icon: "error",
                        button: "Okay",
                    });
                </script>
                <?php
            }
        }
    }
} else {
    ?>
    <script type="text/javascript">
        window.location.href = 'categories.php';
    </script>
    <?php
}
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Category</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Category Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Category Name" name="category_name" value="<?php echo $currentFirstCategoryName; ?>" required>
                                            <div class="invalid-feedback">
                                                This is required field.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="image">Category Image</label>
                                                <input type="file" class="form-control" id="image" name="subcategory_image">
                                                <br>
                                                <?php if($currentImage): ?>
                                                    <div><img src="../media/<?php echo $currentImage; ?>" alt="Current Image" style="height: 70px; width: 70px;"></div>
                                                <?php endif; ?>
                                                <div class="invalid-feedback">
                                                    Please choose an image file.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary">
                                    <a href="categories.php" style="color:white;">Back</a>
                                </button>
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
