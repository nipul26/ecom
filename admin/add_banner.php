<?php include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
if(isset($_POST['submit'])){
    $banner_name = mysqli_real_escape_string($conn, $_POST['banner_name']);
    $banner_type = mysqli_real_escape_string($conn, $_POST['banner_type']);
    $banner_status = ($_POST['banner_status'] == 'active') ? 1 : 0;
    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');

    if(!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $banner_name)){ ?>
        <script>
        Swal.fire('Error', 'Banner name must start with alphabets and cannot contain spaces or special characters at the beginning.', 'error');
        </script>
        <?php
    } else {
        $checkSql = mysqli_query($conn,"SELECT * FROM banner WHERE banner_name = '$banner_name' AND banner_type = '$banner_type'");
        if(mysqli_num_rows($checkSql) > 0){ ?>
            <script>
            Swal.fire('Error', 'Banner with the same name and type already exists.', 'error');
            </script>
            <?php
        } else {
            $allowed_types = ['jpg', 'jpeg', 'png'];
            $banner_image = $_FILES['banner_image']['name'];
            $banner_image_tmp = $_FILES['banner_image']['tmp_name'];
            $file_extension = pathinfo($banner_image, PATHINFO_EXTENSION);

            if(in_array($file_extension, $allowed_types)){
                $target_dir = "../media/banner/";
                
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $target_file = $target_dir . basename($banner_image);
                
                if (move_uploaded_file($banner_image_tmp, $target_file)) {
                    $insertSql = mysqli_query($conn,"INSERT INTO `banner`(`banner_name`, `banner_type`, `banner_images`, `banner_status`, `added_on`, `updated_on`) VALUES ('$banner_name', '$banner_type', '$banner_image', '$banner_status', '$added_on', '$updated_on')");
                    if($insertSql){
                        ?>
                        <script>
                        Swal.fire('Success', 'Banner Added Successfully.', 'success').then(function() { window.location = 'banner.php'; });
                        </script>
                        <?php
                    } else { 
                        ?>
                        <script>
                        Swal.fire('Error', 'Something went wrong with the database.', 'error');
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                    Swal.fire('Error', 'There was an error uploading the file.', 'error');
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                Swal.fire('Error', 'Only JPG, JPEG, and PNG files are allowed.', 'error');
                </script>
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
                            <h4 class="card-title">Add Banner</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="bannerType">Banner Type</label>
                                            <select class="form-control" id="bannerType" name="banner_type" required>
                                                <option value="">Select Type</option>
                                                <option value="type1">Type 1</option>
                                                <option value="type2">Type 2</option>
                                                <option value="type3">Type 3</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="bannerName">Banner Name</label>
                                            <input type="text" class="form-control" id="bannerName" placeholder="Enter Banner Name" name="banner_name" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom04">Banner Image</label>
                                            <input type="file" class="form-control" id="validationCustom04" name="banner_image" accept=".jpg,.jpeg,.png" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="bannerStatus">Banner Status</label><br>
                                            <input type="checkbox" id="bannerStatus" name="banner_status" value="active"> Active
                                        </div>
                                    </div>
                                </div>
                                <a href="banners.php" class="btn btn-primary" style="color:white;">Back</a>
                                <button class="btn btn-success" name="submit" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("form").on("submit", function(e) {
        var bannerName = $("#bannerName").val();
        var bannerType = $("#bannerType").val();
        var fileInput = $("#validationCustom04")[0];
        var regex = /^[A-Za-z]/;
        var validExtensions = ["jpg", "jpeg", "png"];
        var fileName = fileInput.value.split('.').pop().toLowerCase();
        
        if (!regex.test(bannerName)) {
            e.preventDefault();
            Swal.fire("Validation Error", "Banner Name must start with an alphabet.", "error");
        } else if (bannerType === "") {
            e.preventDefault();
            Swal.fire("Validation Error", "Banner Type is required.", "error");
        } else if ($.inArray(fileName, validExtensions) == -1) {
            e.preventDefault();
            Swal.fire("Validation Error", "Only JPG, JPEG, and PNG files are allowed.", "error");
        }
    });
});
</script>

<?php include "footer.php"; ?>
