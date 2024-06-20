<?php
include "header.php";
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maxFileSize = 10 * 1024 * 1024;

    $aboutUsLogo = $_FILES['about_us_logo'];
    $aboutUsLogoName = $aboutUsLogo['name'];
    $aboutUsLogoTmpName = $aboutUsLogo['tmp_name'];

    $aboutMainImages = $_FILES['about_main_images'];
    $aboutMainImagesName = $aboutMainImages['name'];
    $aboutMainImagesTmpName = $aboutMainImages['tmp_name'];

    $aboutUsVideoImages = $_FILES['about_us_video_images'];
    $aboutUsVideoImagesName = $aboutUsVideoImages['name'];
    $aboutUsVideoImagesTmpName = $aboutUsVideoImages['tmp_name'];

    $aboutUsVideo = $_FILES['about_us_video'];
    $aboutUsVideoName = $aboutUsVideo['name'];
    $aboutUsVideoTmpName = $aboutUsVideo['tmp_name'];
    $aboutUsVideoSize = $aboutUsVideo['size'];

    if ($aboutUsVideoSize > $maxFileSize) {
        ?>
        <script>
            swal('Error', 'The video file exceeds the maximum allowed size of 10 MB.', 'error');
        </script>
        <?php
        exit;
    }

    $targetVideoDirectory = "../media/Aboutus/videos/";
    $targetDirectory = "../media/Aboutus/";

    if (!file_exists($targetVideoDirectory)) {
        mkdir($targetVideoDirectory, 0777, true);
    }
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    function uploadFile($tmpName, $targetDir, $fileName) {
        if (move_uploaded_file($tmpName, $targetDir . $fileName)) {
            echo $fileName . " uploaded successfully.<br>";
        } else {
            echo "Error moving " . $fileName . ".<br>";
            echo "Error details: ";
            var_dump(error_get_last());
        }
    }

    uploadFile($aboutUsVideoTmpName, $targetVideoDirectory, $aboutUsVideoName);
    uploadFile($aboutMainImagesTmpName, $targetDirectory, $aboutMainImagesName);
    uploadFile($aboutUsVideoImagesTmpName, $targetDirectory, $aboutUsVideoImagesName);
    uploadFile($aboutUsLogoTmpName, $targetDirectory, $aboutUsLogoName);

    $aboutShortDesc = mysqli_real_escape_string($conn, $_POST['about_short_desc']);
    $aboutLongDesc = mysqli_real_escape_string($conn, $_POST['about_long_desc']);
    $aboutVideoDesc = mysqli_real_escape_string($conn, $_POST['about_video_desc']);

    $sqlCheck = mysqli_query($conn, "SELECT * FROM aboutus WHERE about_us_id = 1");
    if (mysqli_num_rows($sqlCheck) > 0) {
        // Update existing record
        $sqlUpdate = "UPDATE aboutus SET 
            about_us_logo = '$aboutUsLogoName',
            about_us_short_description = '$aboutShortDesc',
            about_us_long_description = '$aboutLongDesc',
            about_us_main_img = '$aboutMainImagesName',
            about_us_video_images = '$aboutUsVideoImagesName',
            about_us_video = '$aboutUsVideoName',
            about_us_video_description = '$aboutVideoDesc'
            WHERE about_us_id = 1";

        if (mysqli_query($conn, $sqlUpdate)) {
            ?>
            <script>
                swal('Success', 'About Us settings updated successfully!', 'success').then(function() {
                    window.location = 'index.php';
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                swal('Error', 'Error updating About Us settings: <?php echo mysqli_error($conn); ?>', 'error');
            </script>
            <?php
        }
    } else {
        // Insert new record
        $sqlInsert = "INSERT INTO aboutus 
            (about_us_id, about_us_logo, about_us_short_description, about_us_long_description, about_us_main_img, about_us_video_images, about_us_video, about_us_video_description) 
            VALUES 
            (1, '$aboutUsLogoName', '$aboutShortDesc', '$aboutLongDesc', '$aboutMainImagesName', '$aboutUsVideoImagesName', '$aboutUsVideoName', '$aboutVideoDesc')";

        if (mysqli_query($conn, $sqlInsert)) {
            ?>
            <script>
                swal('Success', 'About Us settings inserted successfully!', 'success').then(function() {
                    window.location = 'index.php';
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                swal('Error', 'Error inserting About Us settings: <?php echo mysqli_error($conn); ?>', 'error');
            </script>
            <?php
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
                            <h4 class="card-title">About Us</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <?php
                                            $query = "SELECT * FROM `aboutus`";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <label class="form-label" for="about_us_logo">About Us Logo</label>
                                            <input type="file" class="form-control" id="about_us_logo" name="about_us_logo">
                                            <div>
                                                <img src="../media/Aboutus/<?php echo isset($row['about_us_logo']) ? $row['about_us_logo'] : ''; ?>" alt="About Us Logo" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                            <div class="invalid-feedback">Please choose a file for About Us Logo.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="about_short_desc">About Short Description</label>
                                            <input type="text" class="form-control" id="about_short_desc" name="about_short_desc" value="<?php echo isset($row['about_us_short_description']) ? $row['about_us_short_description'] : ''; ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="about_long_desc">About Long Description</label>
                                            <input type="text" class="form-control" id="about_long_desc" name="about_long_desc" value="<?php echo isset($row['about_us_long_description']) ? $row['about_us_long_description'] : ''; ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="about_main_images">About Main Images</label>
                                            <input type="file" class="form-control" id="about_main_images" name="about_main_images">
                                            <div>
                                                <?php if(isset($row['about_us_main_img']) && !empty($row['about_us_main_img'])): ?>
                                                    <img src="../media/Aboutus/videos/<?php echo $row['about_us_main_img']; ?>" alt="About Main Images" style="max-width: 100px; max-height: 100px;">
                                                <?php endif; ?>
                                            </div>
                                            <div class="invalid-feedback">Please choose a file for About Main Images.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="about_us_video_images">About Us Video Images</label>
                                            <input type="file" class="form-control" id="about_us_video_images" name="about_us_video_images">
                                            <div>
                                                <?php if(isset($row['about_us_video_images']) && !empty($row['about_us_video_images'])): ?>
                                                    <img src="../media/Aboutus/<?php echo $row['about_us_video_images']; ?>" alt="About Us Video Images" style="max-width: 100px; max-height: 100px;">
                                                <?php endif; ?>
                                            </div>
                                            <div class="invalid-feedback">Please choose a file for About Us Video Images.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="about_us_video">About Us Video</label>
                                            <input type="file" class="form-control" id="about_us_video" name="about_us_video">
                                            <div class="invalid-feedback">Please choose a file for About Us Video.</div>
                                            <div class="text-muted">Maximum file size: 10 MB</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="about_video_desc">About Us Video Description</label>
                                            <textarea class="form-control" id="about_video_desc" name="about_video_desc" required><?php echo isset($row['about_us_video_description']) ? $row['about_us_video_description'] : ''; ?></textarea>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);

        document.getElementById('about_us_video').addEventListener('change', function() {
            var fileInput = this;
            var file = fileInput.files[0];
            if (file.size > 10 * 1024 * 1024) { // 10 MB in bytes
                alert('The video file exceeds the maximum allowed size of 10 MB.');
                fileInput.value = ''; // Clear the file input
            }
        });
    })();
</script>

<?php
include "footer.php";
?>
