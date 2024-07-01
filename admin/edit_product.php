<?php
include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($_GET['type'] == 'edit' && !empty($_GET['id'])) {
    $currentId = $_GET['id'];
    $getProductSql = mysqli_query($conn, "SELECT * FROM products WHERE product_id = '$currentId'");
    $getData = mysqli_fetch_assoc($getProductSql);

    if (isset($_POST['submit'])) {
        $productName = mysqli_real_escape_string($conn, $_POST['product_name']);
        $sku = mysqli_real_escape_string($conn, $_POST['sku']);
        $mrpPrice = mysqli_real_escape_string($conn, $_POST['mrp_price']);
        $specialPrice = mysqli_real_escape_string($conn, $_POST['special_price']);
        $productDescription = mysqli_real_escape_string($conn, $_POST['product_description']);
        $productAvailableStatus = mysqli_real_escape_string($conn, $_POST['product_availble_status']);
        $relatedProductsId = mysqli_real_escape_string($conn, $_POST['related_products_id']);
        $metaTitle = mysqli_real_escape_string($conn, $_POST['meta_title']);
        $metaKeyword = mysqli_real_escape_string($conn, $_POST['meta_keyword']);
        $metaDescription = mysqli_real_escape_string($conn, $_POST['meta_description']);
        $productStatus = isset($_POST['product_status']) ? 1 : 0;
        $isDisplayHome = isset($_POST['isdisplayhome']) ? 1 : 0;
        $updatedOn = date('Y-m-d H:i:s');
        
        // Handle main product image update
        $targetDir = "../media/";
        $imageFileName = basename($_FILES["product_main_image"]["name"]);
        $targetFile = $targetDir . $imageFileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!empty($imageFileName)) {
            $check = getimagesize($_FILES["product_main_image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if (file_exists($targetFile)) {
                $uploadOk = 0;
            }

            if ($_FILES["product_main_image"]["size"] > 500000) {
                $uploadOk = 0;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["product_main_image"]["tmp_name"], $targetFile)) {
                    // File uploaded successfully
                } else {
                    // Handle file upload error
                }
            }
        } else {
            $imageFileName = $getData['product_main_image'];
        }

        // Update main product details in database
        $updateSql = mysqli_query($conn, 
            "UPDATE products SET 
                product_name = '$productName',
                sku = '$sku',
                mrp_price = '$mrpPrice',
                special_price = '$specialPrice',
                product_main_image = '$imageFileName',
                product_description = '$productDescription',
                product_availble_status = '$productAvailableStatus',
                related_products_id = '$relatedProductsId',
                product_status = '$productStatus',
                isdisplayhome = '$isDisplayHome',
                meta_title = '$metaTitle',
                meta_keyword = '$metaKeyword',
                meta_description = '$metaDescription',
                updated_on = '$updatedOn' 
            WHERE product_id = '$currentId'");

        // Handle multiple images update
        if (!empty($_FILES['room_image']['name'][0])) {
            $targetDirMultiple = "../media/product/";
            foreach ($_FILES['room_image']['tmp_name'] as $key => $tmp_name) {
                $productImageName = basename($_FILES['room_image']['name'][$key]);
                $productImageTarget = $targetDirMultiple . $productImageName;
                move_uploaded_file($_FILES['room_image']['tmp_name'][$key], $productImageTarget);

            
                $checkExistSql = mysqli_query($conn, "SELECT * FROM product_multiple_images WHERE product_images_id = '" . $getData['product_id'] . "'");
                if (mysqli_num_rows($checkExistSql) > 0) {
                    mysqli_query($conn, "UPDATE product_multiple_images SET product_image = '$productImageTarget', update_on = '$updatedOn' WHERE product_images_id = '" . $getData['product_id'] . "'");
                } else {
                    // Insert new image
                    mysqli_query($conn, "INSERT INTO product_multiple_images (product_main_id, product_image, added_on, update_on) VALUES ('$currentId', '$productImageTarget', '$updatedOn', '$updatedOn')");
                }
            }
        }

        // Redirect after successful update
        if ($updateSql) { ?>
             <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Product updated successfully.",
                        icon: "success",
                        button: "Okay",
                    }).then(function() {
                        window.location = "product_listing.php";
                    });
                </script>
       <?php } else { ?>
            <script type="text/javascript">
                    swal({
                        title: "Error",
                        text: "Failed to update product.",
                        icon: "error",
                        button: "Okay",
                    });
                </script>
        <?php }
    }
} else { ?>
    <script type="text/javascript">
        window.location.href = "categories.php";
    </script>
<?php } ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Product</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_name">Product Name</label>
                                            <input type="text" class="form-control" id="product_name" placeholder="Enter Product Name" name="product_name" value="<?php echo $getData['product_name']; ?>" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="sku">SKU</label>
                                            <input type="text" class="form-control" id="sku" placeholder="Enter SKU" name="sku" value="<?php echo $getData['sku']; ?>" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="mrp_price">MRP Price</label>
                                            <input type="number" step="0.01" class="form-control" id="mrp_price" placeholder="00.00" name="mrp_price" value="<?php echo $getData['mrp_price']; ?>" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid price (e.g., 22.22).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="special_price">Special Price</label>
                                            <input type="number" step="0.01" class="form-control" id="special_price" placeholder="00.00" name="special_price" value="<?php echo $getData['special_price']; ?>" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid price (e.g., 22.22).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_main_image">Product Image</label>
                                            <input type="file" class="form-control" id="product_main_image" name="product_main_image">
                                            <?php if (!empty($getData['product_main_image'])) : ?>
                                                <img src="../media/<?php echo $getData['product_main_image']; ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;">
                                            <?php endif; ?>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                      <div class="col-md-12" id="product_images_add_div">
                                    <div class="mb-3">
                                        <label class="form-label">Product Multiple Images</label>
                                        <button type="button" class="btn btn-success" onclick="add_more_image()">Add More Images</button>
                                        <?php
                                        $getImagesSql = mysqli_query($conn, "SELECT * FROM product_multiple_images WHERE product_main_id = '$currentId'");
                                        while ($getImagesData = mysqli_fetch_assoc($getImagesSql)) {
                                            echo '<div class="mb-3">
                                                    <img src="../media/product/' . $getImagesData['product_image'] . '" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                                                    <button type="button" class="btn btn-danger" onclick="remove_image(' . $getImagesData['product_images_id'] . ')">Remove Image</button>
                                                  </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_description">Product Description</label>
                                            <textarea class="form-control" id="product_description" name="product_description" rows="5"><?php echo $getData['product_description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_availble_status">Product Availability Status</label>
                                            <select class="form-select" id="product_availble_status" name="product_availble_status">
                                                <option value="1" <?php if ($getData['product_availble_status'] == 1) echo 'selected'; ?>>Available</option>
                                                <option value="0" <?php if ($getData['product_availble_status'] == 0) echo 'selected'; ?>>Not Available</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="related_products_id">Related Products ID</label>
                                            <input type="text" class="form-control" id="related_products_id" placeholder="Enter Related Products ID" name="related_products_id" value="<?php echo $getData['related_products_id']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title" value="<?php echo $getData['meta_title']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_keyword">Meta Keyword</label>
                                            <input type="text" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" name="meta_keyword" value="<?php echo $getData['meta_keyword']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_description">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo $getData['meta_description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product_status" name="product_status" <?php if ($getData['product_status'] == 1) echo 'checked'; ?>>
                                                <label class="form-check-label" for="product_status">
                                                    Product Status
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="isdisplayhome" name="isdisplayhome" <?php if ($getData['isdisplayhome'] == 1) echo 'checked'; ?>>
                                                <label class="form-check-label" for="isdisplayhome">
                                                    Display on Home Page
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="submit">Update Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var total_image = <?php echo mysqli_num_rows($getImagesSql); ?>;

    function add_more_image() {
        total_image++;
        var add_images_html = '<div class="mb-3">\
            <input type="file" class="form-control" name="room_image[]" id="room_image_' + total_image + '" required>\
            <button type="button" class="btn btn-danger" onclick="remove_image(' + total_image + ')">Remove Image</button>\
        </div>';
        $('#product_images_add_div').append(add_images_html);
    }

    function remove_image(id) {
        // Send AJAX request to remove the image from the database
        $.ajax({
            url: 'remove_image.php', // Replace with your actual URL
            type: 'POST',
            data: { image_id: id },
            success: function(response) {
                console.log(response); // Log the response to debug
                if (response == 'success') {
                    // Directly display SweetAlert for testing
                    swal({
                        title: "Success",
                        text: "Image removed successfully.",
                        icon: "success",
                        button: "Okay",
                    }).then(function() {
                        window.location = "product_listing.php"; // Redirect after user clicks Okay
                    });
                } else {
                    alert('Failed to remove image. Please try again.'); // Display standard alert for failure
                }
            },
            error: function() {
                alert('Error occurred. Please try again later.'); // Display alert for AJAX error
            }
        });
    }
</script>

<?php include "footer.php"; ?>
