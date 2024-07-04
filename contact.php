<?php include 'header.php'; ?>

<!-- ...::: Strat Breadcrumb Section :::... -->
<div class="breadcrumb-section">
    <div class="box-wrapper">
        <div class="breadcrumb-wrapper breadcrumb-wrapper--style-1 pos-relative">
            <div class="breadcrumb-bg">
                <img src="assets/images/breadcrumb/breadcrumb-img-product-details-page.webp" alt="">
            </div>
            <div class="breadcrumb-content section-fluid-270">
                <div class="breadcrumb-wrapper">
                    <div class="content">
                        <span class="title-tag">BEST DEAL FOREVER</span>
                        <h2 class="title"><span class="text-mark">Contact</span> Page</h2>
                    </div>
                    <!-- <ul class="breadcrumb-nav">
                        <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                        <li>Contact</li>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...::: End Breadcrumb Section :::... -->

<?php
$sql = "SELECT * FROM `sitesetting` WHERE id = 1";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $siteSettings = mysqli_fetch_assoc($result);
}
?>

<!-- ...::::Start Map Section:::... -->
<div class="map-section section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe id="gmap_canvas" src="<?php echo $siteSettings['google_map_link'];?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...::::End  Map Section:::... -->

<!-- ...::::Start Contact Section:::... -->
<div class="contact-section section-fluid-270">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Start Contact Details -->
                <div class="contact-details-wrapper section-top-gap-120">
                    <div class="contact-details">
                        <!-- Start Contact Details Single Item -->
                        <div class="contact-details-single-item">
                            <div class="contact-details-icon">
                                <span class="material-icons">phone</span>
                            </div>
                            <div class="contact-details-content contact-phone">
                                <a href="tel:+012345678102"><?php echo $siteSettings['mobile_number'];?></a>
                                <a href="tel:+012345678102"><?php echo $siteSettings['whatsapp_number'];?></a>
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                        <!-- Start Contact Details Single Item -->
                        <div class="contact-details-single-item">
                            <div class="contact-details-icon">
                                <span class="material-icons">language</span>
                            </div>
                            <div class="contact-details-content contact-phone">
                                <a href="mailto:urname@email.com"><?php echo $siteSettings['frist_email'];?></a>
                                <!-- <a href="http://www.yourwebsite.com/">www.yourwebsite.com</a> -->
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                        <!-- Start Contact Details Single Item -->
                        <div class="contact-details-single-item">
                            <div class="contact-details-icon">
                                <span class="material-icons">location_on</span>
                            </div>
                            <div class="contact-details-content contact-phone">
                                <span><?php echo $siteSettings['address'];?></span>
                                <!-- <span>street, Crossroad 123.</span> -->
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                    </div>
                    <!-- Start Contact Social Link -->
                    <div class="contact-social">
                        <h4>Follow Us</h4>
                        <ul>
                            <li><a href="<?php echo $siteSettings['facebook_link']; ?>"><img class="icon-svg" src="assets/images/icons/icon-facebook-f-dark.svg" alt=""></a></li>
                            <li><a href="<?php echo $siteSettings['twitter_link']; ?>"><img class="icon-svg" src="assets/images/icons/icon-twitter-dark.svg" alt=""></a></li>
                            <li><a href="<?php echo $siteSettings['youtube_link']; ?>"><img class="icon-svg" src="assets/images/icons/icon-pinterest-p-dark.svg" alt=""></a></li>
                            <li><a href="<?php echo $siteSettings['instagram_link']; ?>"><img class="icon-svg" src="assets/images/icons/icon-dribbble-dark.svg" alt=""></a></li>
                        </ul>
                    </div> <!-- End Contact Social Link -->
                </div> <!-- End Contact Details -->
            </div>
            <div class="col-lg-8">
                <div class="contact-form section-top-gap-120">
                    <h3>Get In Touch</h3>
                    <form id="contact-form"  method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="default-form-box mb-20">
                                    <label for="contact-name">Name</label>
                                    <input name="name" type="text" id="contact-name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="default-form-box mb-20">
                                    <label for="contact-email">Email</label>
                                    <input name="email" type="email" id="contact-email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="default-form-box mb-20">
                                    <label for="contact-subject">Subject</label>
                                    <input name="subject" type="text" id="contact-subject">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="default-form-box mb-20">
                                    <label for="contact-message">Your Message</label>
                                    <textarea name="message" id="contact-message" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-sm btn-radius btn-default" type="submit">Submit</button>
                            </div>
                            <p class="form-messege"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...::::End Contact Section:::... -->

<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $sql = "INSERT INTO `get_in_touch` (`name`, `email`, `subject`, `message`) VALUES ('$name', '$email', '$subject', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        ?>
        <script>
            Swal.fire({
                title: 'Success',
                text: 'Message sent successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Error',
                text: '<?php echo "Error: " . mysqli_error($conn); ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <?php
    }
}
?>

<?php include 'footer.php'; ?>
