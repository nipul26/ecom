<?php
include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteName = $_POST['site_name'];
    $siteTagName = $_POST['site_tag_name'];
    $mobileNumber = $_POST['mobile_number'];
    $whatsappNumber = $_POST['whatsapp_number'];
    $firstEmail = $_POST['first_email'];
    $secondEmail = $_POST['second_email'];
    $address = $_POST['address'];
    $metaTitle = $_POST['meta_title'];
    $metaKeyword = $_POST['meta_keyword'];
    $metaDescription = $_POST['meta_description'];
    $instagramLink = $_POST['instagram_link'];
    $facebookLink = $_POST['facebook_link'];
    $twitterLink = $_POST['twitter_link'];
    $googleLink = $_POST['google_link'];
    $googleMapLink = $_POST['google_map_link'];

    $headerSiteLogo = $_FILES['header_site_logo'];
    $headerSiteLogoName = $headerSiteLogo['name'];
    $headerSiteLogoTmpName = $headerSiteLogo['tmp_name'];

    $footerSiteLogo = $_FILES['footer_site_logo'];
    $footerSiteLogoName = $footerSiteLogo['name'];
    $footerSiteLogoTmpName = $footerSiteLogo['tmp_name'];

    $targetDirectory = "../media/sitesettings/";

    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

if (move_uploaded_file($headerSiteLogoTmpName, $targetDirectory . $headerSiteLogoName)) {
    echo "Header Site Logo uploaded successfully.";
} else {
    echo "Error moving Header Site Logo.";
}

if (move_uploaded_file($footerSiteLogoTmpName, $targetDirectory . $headerSiteLogoName)) {
    echo "Footer Site Logo uploaded successfully.";
} else {
    echo "Error moving Header Site Logo.";
}

    $sqlCheck = mysqli_query($conn, "SELECT * FROM sitesetting WHERE id = 1");
    if (mysqli_num_rows($sqlCheck) > 0) {
        $sqlUpdate = "UPDATE sitesetting SET 
            site_name = '$siteName',
            site_tag_name = '$siteTagName',
            mobile_number = '$mobileNumber',
            whatsapp_number = '$whatsappNumber',
            frist_email = '$firstEmail',
            second_email = '$secondEmail',
            address = '$address',
            header_site_logo = '$headerSiteLogoName',
            footer_site_logo = '$footerSiteLogoName',
            meta_title = '$metaTitle',
            meta_keyword = '$metaKeyword',
            meta_description = '$metaDescription',
            instagram_link = '$instagramLink',
            facebook_link = '$facebookLink',
            twitter_link = '$twitterLink',
            google_link = '$googleLink',
            google_map_link = '$googleMapLink',
            update_on = '$updated_on'
            WHERE id = 1";
        
        if (mysqli_query($conn, $sqlUpdate)) {
            ?>
           
            <script>swal('Success', 'Site settings updated successfully!', 'success').then(function() {
            window.location = 'index.php';
        });</script>
            <?php
          
        } else { ?>
            <script>swal('Error', 'Error updating site settings: " . mysqli_error($conn) . "', 'error');</script>;
            <?php
        }
    } else {
        $sqlInsert = "INSERT INTO sitesetting 
            (id, site_name, site_tag_name, mobile_number, whatsapp_number, frist_email, second_email, address, header_site_logo, footer_site_logo, meta_title, meta_keyword, meta_description, instagram_link, facebook_link, twitter_link, google_link, google_map_link, added_on, update_on) 
            VALUES 
            (1, '$siteName', '$siteTagName', '$mobileNumber', '$whatsappNumber', '$firstEmail', '$secondEmail', '$address', '$headerSiteLogoName', '$footerSiteLogoName', '$metaTitle', '$metaKeyword', '$metaDescription', '$instagramLink', '$facebookLink', '$twitterLink', '$googleLink', '$googleMapLink', '$added_on', '$updated_on')";
        
        if (mysqli_query($conn, $sqlInsert)) { ?>
           <script>swal('Success', 'Site settings updated successfully!', 'success').then(function() {
            window.location = 'index.php';
        });</script>
            <?php
             
        } else { ?>
            <script>swal('Error', 'Error inserting site settings: " . mysqli_error($conn) . "', 'error');</script>
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
                            <h4 class="card-title">Site Settings</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">

                                <?php
                               $query = "SELECT * FROM `sitesetting`";
                                $result = mysqli_query($conn, $query);

                                $row = mysqli_fetch_assoc($result);

                                // echo $row['site_name'];
                                // echo "<pre>";
                                // print_r($row);
                                // die();
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="siteName">Site Name</label>
                                            <input type="text" class="form-control" id="siteName" placeholder="Enter site name" name="site_name" value="<?php echo ($row['site_name']); ?>" required>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="siteTagName">Site Tag Name</label>
                                            <input type="text" class="form-control" id="siteTagName" placeholder="Enter site tag name" name="site_tag_name"  value="<?php echo ($row['site_tag_name']); ?>" required >
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="mobileNumber">Mobile Number</label>
                                            <input type="text" class="form-control" id="mobileNumber" placeholder="Enter mobile number" name="mobile_number" value="<?php echo ($row['mobile_number']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="whatsappNumber">WhatsApp Number</label>
                                            <input type="text" class="form-control" id="whatsappNumber" placeholder="Enter WhatsApp number" name="whatsapp_number" value="<?php echo ($row['whatsapp_number']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="firstEmail">First Email</label>
                                            <input type="email" class="form-control" id="firstEmail" placeholder="Enter first email" name="first_email" value="<?php echo ($row['frist_email']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="secondEmail">Second Email</label>
                                            <input type="email" class="form-control" id="secondEmail" placeholder="Enter second email" name="second_email" value="<?php echo ($row['second_email']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="<?php echo ($row['address']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="headerSiteLogo">Header Site Logo</label>
                                            <input type="file" class="form-control" id="headerSiteLogo" name="header_site_logo" value= "<?php $row['header_site_logo']; ?>" required>
                                            <div>
                                            <img src="../media/sitesettings/<?php echo htmlspecialchars($row['header_site_logo']); ?>" alt="Header Site Logo" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="footerSiteLogo">Footer Site Logo</label>
                                            <input type="file" class="form-control" id="footerSiteLogo" name="footer_site_logo"  value = "<?php  $row['footer_site_logo']; ?>"required>

                                              <div>
                                <img src="../media/sitesettings/<?php echo htmlspecialchars($row['footer_site_logo']); ?>" alt="Header Site Logo" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="metaTitle">Meta Title</label>
                                            <input type="text" class="form-control" id="metaTitle" placeholder="Enter meta title" name="meta_title" value="<?php echo ($row['meta_title']); ?>"  required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="metaKeyword">Meta Keyword</label>
                                            <input type="text" class="form-control" id="metaKeyword" placeholder="Enter meta keyword" name="meta_keyword" value="<?php echo ($row['meta_keyword']); ?>"  required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="metaDescription">Meta Description</label>
                                            <input type="text" class="form-control" id="metaDescription" placeholder="Enter meta description" name="meta_description"  value="<?php echo ($row['meta_description']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="instagramLink">Instagram Link</label>
                                            <input type="url" class="form-control" id="instagramLink" placeholder="Enter Instagram link" name="instagram_link" value="<?php echo ($row['instagram_link']); ?>"  required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="facebookLink">Facebook Link</label>
                                            <input type="url" class="form-control" id="facebookLink" placeholder="Enter Facebook link" name="facebook_link"  value="<?php echo ($row['facebook_link']); ?>"  required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="twitterLink">Twitter Link</label>
                                            <input type="url" class="form-control" id="twitterLink" placeholder="Enter Twitter link" name="twitter_link" value="<?php echo ($row['twitter_link']); ?>"  required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="googleLink">Google Link</label>
                                            <input type="url" class="form-control" id="googleLink" placeholder="Enter Google link" name="google_link"  value="<?php echo ($row['google_link']); ?>"  required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="googleMapLink">Google Map Link</label>
                                            <input type="url" class="form-control" id="googleMapLink" placeholder="Enter Google Map link" name="google_map_link" value="<?php echo ($row['google_map_link']); ?>" required>
                                            <div class="invalid-feedback">This is a required field.</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="index.php" class="btn btn-primary" style="color:white;">Back</a>
                                <button class="btn btn-success" name="submit" type="submit" id="submit">Save</button>
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
    $('#submit').click(function(e) {
        var form = $(this).closest('form');
        var isValid = form[0].checkValidity();

        if (!isValid) {
            e.preventDefault();
            e.stopPropagation();
            form.addClass('was-validated');
            return;
        }

        // Custom validation for file inputs (if needed)
        var fileInputs = form.find('input[type="file"]');
        fileInputs.each(function() {
            var fileInput = $(this);
            var fileName = fileInput.val();
            if (fileName === '') {
                e.preventDefault();
                e.stopPropagation();
                swal("Error", "Please select a file for " + fileInput.attr('id'), "error");
                return false;
            }
        });

        // If all fields are valid, submit the form
        // swal("Success", "Form submitted successfully!", "success");
    });
});
</script>


<?php include "footer.php"; ?>
