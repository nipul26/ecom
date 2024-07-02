<?php include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>

<?php 
if(isset($_POST['submit'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $mrp_price = mysqli_real_escape_string($conn, $_POST['mrp_price']);
    $special_price = mysqli_real_escape_string($conn, $_POST['special_price']);
    $product_main_image = mysqli_real_escape_string($conn, $_FILES['product_main_image']['name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_availble_status = mysqli_real_escape_string($conn, $_POST['product_availble_status']);
    $related_products_id = mysqli_real_escape_string($conn, $_POST['related_products_id']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_keyword = mysqli_real_escape_string($conn, $_POST['meta_keyword']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $product_status = isset($_POST['product_status']) ? 1 : 0;
    $isdisplayhome = isset($_POST['isdisplayhome']) ? 1 : 0;
    $added_on = date('Y-m-d H:i:s');
    $updated_on = date('Y-m-d H:i:s');

    $target_dir = "../media/product/";
    $target_file = $target_dir . basename($_FILES["product_main_image"]["name"]);
    move_uploaded_file($_FILES["product_main_image"]["tmp_name"], $target_file);
    $product_main_image = basename($_FILES["product_main_image"]["name"]);

    $insertSql = "INSERT INTO `products`(`product_name`, `sku`, `mrp_price`, `special_price`, `product_main_image`, `product_description`, `product_availble_status`, `related_products_id`, `meta_title`, `meta_keyword`, `meta_description`, `product_status`, `isdisplayhome`, `added_on`, `updated_on`) VALUES ('$product_name', '$sku', '$mrp_price', '$special_price', '$product_main_image', '$product_description', '$product_availble_status', '$related_products_id', '$meta_title', '$meta_keyword', '$meta_description', '$product_status', '$isdisplayhome', '$added_on', '$updated_on')";

    if(mysqli_query($conn, $insertSql)){
        $product_main_id = mysqli_insert_id($conn);

        foreach($_FILES['room_image']['tmp_name'] as $key => $tmp_name) {
            $product_image_name = $_FILES['room_image']['name'][$key];
            $product_image_tmp = $_FILES['room_image']['tmp_name'][$key];
            $product_image_target = $target_dir . basename($product_image_name);
            move_uploaded_file($product_image_tmp, $product_image_target);
            $product_image_name = basename($product_image_name);

            $imageSql = "INSERT INTO `product_multiple_images`(`product_main_id`, `product_image`, `added_on`, `update_on`) VALUES ('$product_main_id', '$product_image_name', '$added_on', '$updated_on')";
            mysqli_query($conn, $imageSql);
        }
        ?>
        <script>swal('Success', 'Product added successfully.', 'success').then(function() { window.location = 'product_listing.php'; });</script>
        <?php
    } else {
        ?>
        <script>swal('Error', 'Something went wrong with the database.', 'error');</script>
        <?php
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
                            <h4 class="card-title">Add Product</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_name">Product Name</label>
                                            <input type="text" class="form-control" id="product_name" placeholder="Enter Product Name" name="product_name" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="sku">SKU</label>
                                            <input type="text" class="form-control" id="sku" placeholder="Enter SKU" name="sku" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12"> 
                                        <div class="mb-3">
                                            <label class="form-label" for="mrp_price">MRP Price</label>
                                            <input type="number" step="0.01" class="form-control" id="mrp_price" name="mrp_price" placeholder="00.00" required>
                                            <div class="invalid-feedback">
                                            Please enter a valid MRP price.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="special_price">Special Price</label>
                                            <input type="number" step="0.01" class="form-control" id="special_price" placeholder="00.00" name="special_price" pattern="^\d+(\.\d{1,2})?$" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid price (e.g., 22.22).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_main_image">Product Image</label>
                                            <input type="file" class="form-control" id="product_main_image" name="product_main_image" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_description">Product Description</label>
                                            <textarea class="form-control" id="product_description" placeholder="Enter Product Description" name="product_description" required></textarea>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="restaurant_images_add_div">
                                        <div class="mb-3">
                                            <label class="form-label">Product Multiple Images</label>
                                            <button type="button" class="btn btn-success" onclick="add_more_image()">Add More Images</button>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_availble_status">Product Available Status</label>
                                            <select class="form-control" id="product_availble_status" name="product_availble_status" required>
                                                <option value="In Stock">In Stock</option>
                                                <option value="Out Of Stock">Out Of Stock</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="related_products_id">Related Products ID</label>
                                            <input type="text" class="form-control" id="related_products_id" placeholder="Enter Related Products ID" name="related_products_id" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
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
                                            <textarea class="form-control" id="meta_description" placeholder="Enter Meta Description" name="meta_description" required></textarea>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_status">Product Status</label>
                                            <input type="checkbox" id="product_status" name="product_status">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="isdisplayhome">Display on Home</label>
                                            <input type="checkbox" id="isdisplayhome" name="isdisplayhome">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <a href="products.php" class="btn btn-primary" style="color:white;">Back</a>
                                        <button class="btn btn-success" name="submit" type="submit">Save</button>
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
    var total_image = 0;

    function add_more_image() {
        total_image++;
        var add_images_html = '<div class="item form-group" id="add_image_box_' + total_image + '">\
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Image No ' + total_image + '<span class="required">*</span></label>\
            <div class="col-md-3 col-sm-3 col-xs-6">\
                <input type="file" class="form-control col-md-7 col-xs-12" name="room_image[]" id="room_image_' + total_image + '" placeholder="Enter Image" required>\
            </div>\
            <div class="col-md-3 col-sm-3 col-xs-6">\
                <button type="button" class="btn btn-danger form-control col-md-7 col-xs-12" onclick="remove_image(' + total_image + ')">Remove Image ' + total_image + '</button>\
            </div>\
        </div>';
        jQuery('#restaurant_images_add_div').append(add_images_html);
    }

    function remove_image(id) {
        jQuery('#add_image_box_' + id).remove();
    }

    ClassicEditor
        .create(document.querySelector('#product_description'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#meta_description'))
        .catch(error => {
            console.error(error);
        });

    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php include "footer.php"; ?>
