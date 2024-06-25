<?php include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
if ($_GET['type'] == 'edit' && $_GET['id'] != '') {
    $currentId = $_GET['id'];
    $getSql = mysqli_query($conn, "SELECT * FROM banner WHERE banner_id = '$currentId'");
    $getData = mysqli_fetch_assoc($getSql);
    $currentBannerName = $getData['banner_name'];
    $currentBannerType = $getData['banner_type'];
    $currentBannerStatus = $getData['banner_status'] == 1 ? 'checked' : '';

    if (isset($_POST['submit'])) {
        $newBannerName = mysqli_real_escape_string($conn, $_POST['banner_name']);
        $newBannerType = mysqli_real_escape_string($conn, $_POST['banner_type']);
        $newBannerStatus = isset($_POST['banner_status']) ? 1 : 0;

        $checkRecordSql = mysqli_query($conn, "SELECT * FROM banner WHERE banner_name = '$newBannerName' AND banner_id != '$currentId'");

        if (mysqli_num_rows($checkRecordSql) > 0) {
            ?>
            <script type="text/javascript">
                swal({
                    title: "Warning",
                    text: "Banner name already exists.",
                    icon: "error",
                    button: "Okay",
                });
            </script>
            <?php
        } else {
            $updated_on = date('Y-m-d H:i:s');
            $updateSql = mysqli_query($conn, "UPDATE banner SET banner_name = '$newBannerName', banner_type = '$newBannerType', banner_status = '$newBannerStatus', updated_on = '$updated_on' WHERE banner_id = '$currentId'");

            if ($updateSql) {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Banner updated successfully.",
                        icon: "success",
                        button: "Okay",
                    }).then(function() {
                        window.location = "banner.php";
                    });
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Error",
                        text: "Failed to update banner.",
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
        window.location.href = 'banner.php';
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
                            <h4 class="card-title">Update Banner</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Banner Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Banner Name" name="banner_name" value="<?php echo $currentBannerName; ?>" required>
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
                                                <option value="type1" <?php echo $currentBannerType == 'type1' ? 'selected' : ''; ?>>Type 1</option>
                                                <option value="type2" <?php echo $currentBannerType == 'type2' ? 'selected' : ''; ?>>Type 2</option>
                                                <option value="type3" <?php echo $currentBannerType == 'type3' ? 'selected' : ''; ?>>Type 3</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="bannerStatus">Banner Status</label><br>
                                            <input type="checkbox" id="bannerStatus" name="banner_status" <?php echo $currentBannerStatus; ?>> Active
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary">
                                    <a href="banner.php" style="color:white;">Back</a>
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
