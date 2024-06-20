<?php include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
if(isset($_POST['submit'])){
    $categories_name = mysqli_real_escape_string($conn, $_POST['categories_name']);
    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');

    // Assuming this script is in the 'admin' folder and media folder is in the project root
    $target_dir = "../media/";
    $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["category_image"]["tmp_name"]);
    if($check === false) {
        echo "<script>swal('Error', 'File is not an image.', 'error');</script>";
        $uploadOk = 0;
    }

    // Check file size (5MB max)
    if ($_FILES["category_image"]["size"] > 5000000) {
        echo "<script>swal('Error', 'File is too large.', 'error');</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>swal('Error', 'Only JPG, JPEG, PNG & GIF files are allowed.', 'error');</script>";
        $uploadOk = 0;
    }

    // Check if category name is valid
    if(!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $categories_name)){
        echo "<script>swal('Error', 'Category name must start with alphabets and cannot contain spaces or special characters at the beginning.', 'error');</script>";
    } else {
        $checkSql = mysqli_query($conn,"SELECT * FROM categories WHERE categories_name = '$categories_name'");
        if(mysqli_num_rows($checkSql) > 0){
            echo "<script>swal('Error', 'Data Already Exist.', 'error');</script>";
        } else {
            if ($uploadOk == 0) {
                echo "<script>swal('Error', 'Your file was not uploaded.', 'error');</script>";
            } else {
                // Try to upload file
                if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                    $insertSql = mysqli_query($conn,"INSERT INTO `categories`(`categories_name`, `categories_status`, `images`, `added_on`, `update_on`) VALUES ('$categories_name', '1', '$target_file', '$added_on', '$updated_on')");
                    if($insertSql){
                        echo "<script>swal('Success', 'Data Added Successfully.', 'success').then(function() { window.location = 'categories.php'; });</script>";
                    } else {
                        echo "<script>swal('Error', 'Something went wrong with the database.', 'error');</script>";
                    }
                } else {
                    echo "<script>swal('Error', 'There was an error uploading your file.', 'error');</script>";
                }
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
