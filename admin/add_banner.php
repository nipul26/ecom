<?php include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
if(isset($_POST['submit'])){
    $banner_name = mysqli_real_escape_string($conn, $_POST['banner_name']);
    $banner_type = mysqli_real_escape_string($conn, $_POST['banner_type']);
    $banner_status = ($_POST['banner_status'] == 'active') ? 1 : 0;
    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');

    if(!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $banner_name)){ ?>
        <script>swal('Error', 'Banner name must start with alphabets and cannot contain spaces or special characters at the beginning.', 'error');</script>
        <?php
    } else {
       
        $checkSql = mysqli_query($conn,"SELECT * FROM banner WHERE banner_name = '$banner_name' AND banner_type = '$banner_type'");
        if(mysqli_num_rows($checkSql) > 0){ ?>
            <script>swal('Error', 'Banner with the same name and type already exists.', 'error');</script>
            <?php
        } else {
            $insertSql = mysqli_query($conn,"INSERT INTO `banner`(`banner_name`, `banner_type`, `banner_status`, `added_on`, `updated_on`) VALUES ('$banner_name', '$banner_type', '$banner_status', '$added_on', '$updated_on')");
            if($insertSql){
                ?>
                <script>swal('Success', 'Banner Added Successfully.', 'success').then(function() { window.location = 'banner.php'; });</script>
                <?php
            } else { 
                ?>
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
                            <h4 class="card-title">Add Banner</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
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
    // Validate that banner name starts with alphabets
    $("form").on("submit", function(e) {
        var bannerName = $("#bannerName").val();
        var regex = /^[A-Za-z]/;
        
        if (!regex.test(bannerName)) {
            e.preventDefault();
            swal("Validation Error", "Banner Name must start with an alphabet.", "error");
        }
    });
});
</script>

<?php include "footer.php"; ?>
