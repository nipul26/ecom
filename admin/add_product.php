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
        
        $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);
        $subcategoryId = mysqli_real_escape_string($conn, $_POST['subcategory_id']);

        // Update product details in products table
        $updateSql = mysqli_query($conn, 
            "UPDATE products SET 
            product_name = '$productName',
            categories_id = '$categoryId',
            subCategories_id = '$subcategoryId',
            sku = '$sku',
            mrp_price = '$mrpPrice',
            special_price = '$specialPrice',
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

                // Upload new image if it doesn't exist in database
                if (!in_array($productImageName, $existingImages)) {
                    move_uploaded_file($_FILES['room_image']['tmp_name'][$key], $productImageTarget);
                    mysqli_query($conn, "INSERT INTO product_multiple_images (product_main_id, product_image, added_on, update_on) VALUES ('$currentId', '$productImageName', '$updatedOn', '$updatedOn')");
                }
            }
        }

        // Handle existing images update or deletion
        if (!empty($_POST['existing_images'])) {
            foreach ($_POST['existing_images'] as $imageId) {
                // Check if image should be deleted
                if (!in_array($imageId, $updatedImages)) {
                    $getImageSql = mysqli_query($conn, "SELECT product_image FROM product_multiple_images WHERE product_images_id = '$imageId'");
                    $imageData = mysqli_fetch_assoc($getImageSql);
                    $imageToDelete = $targetDirMultiple . $imageData['product_image'];

                    // Delete image file from server
                    if (file_exists($imageToDelete)) {
                        unlink($imageToDelete);
                    }

                    // Delete image record from database
                    mysqli_query($conn, "DELETE FROM product_multiple_images WHERE product_images_id = '$imageId'");
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
                                            <label class="form-label" for="category_id">Category</label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                                <?php
                                                $categorySql = mysqli_query($conn, "SELECT * FROM categories WHERE categories_status = 1");
                                                while ($category = mysqli_fetch_assoc($categorySql)) {
                                                    $selected = ($category['categories_id'] == $getData['categories_id']) ? 'selected' : '';
                                                    echo "<option value='" . $category['categories_id'] . "' $selected>" . $category['categories_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="subcategory_id">Subcategory</label>
                                            <select class="form-select" id="subcategory_id" name="subcategory_id" required>
                                                <option value="">Select Subcategory</option>
                                                <?php
                                                if (!empty($getData['categories_id'])) {
                                                    $subcategorySql = mysqli_query($conn, "SELECT * FROM subcategories WHERE categories_id = " . $getData['categories_id']);
                                                    while ($subcategory = mysqli_fetch_assoc($subcategorySql)) {
                                                        $selected = ($subcategory['sub_categories_id'] == $getData['subCategories_id']) ? 'selected' : '';
                                                        echo "<option value='" . $subcategory['sub_categories_id'] . "' $selected>" . $subcategory['sub_categories_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
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
                                            <label class="form-label" for="product_description">Product Description</label>
                                            <textarea class="form-control" id="product_description" name="product_description" rows="5" required><?php echo $getData['product_description']; ?></textarea>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_availble_status">Product Available Status</label>
                                            <select class="form-select" id="product_availble_status" name="product_availble_status" required>
                                                <option value="1" <?php if ($getData['product_availble_status'] == 1) echo 'selected'; ?>>In Stock</option>
                                                <option value="0" <?php if ($getData['product_availble_status'] == 0) echo 'selected'; ?>>Out of Stock</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="related_products_id">Related Products ID</label>
                                            <input type="text" class="form-control" id="related_products_id" placeholder="Enter Related Products ID" name="related_products_id" value="<?php echo $getData['related_products_id']; ?>">
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title" value="<?php echo $getData['meta_title']; ?>">
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_keyword">Meta Keyword</label>
                                            <input type="text" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" name="meta_keyword" value="<?php echo $getData['meta_keyword']; ?>">
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_description">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo $getData['meta_description']; ?></textarea>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Current Images</label>
                                            <div id="current_images">
                                                <?php
                                                $imageCounter = 0;
                                                $getMultipleImagesSql = mysqli_query($conn, "SELECT * FROM product_multiple_images WHERE product_main_id = '" . $getData['product_id'] . "'");
                                                if (mysqli_num_rows($getMultipleImagesSql) > 0) {
                                                    while ($multipleImage = mysqli_fetch_assoc($getMultipleImagesSql)) {
                                                        $imageCounter++;
                                                        $imagePath = '../media/product/' . $multipleImage['product_image'];
                                                        if (file_exists($imagePath)) {
                                                            echo "<div class='mb-3' id='image_field_$imageCounter'>";
                                                            echo "<label class='form-label'>Image $imageCounter</label>";
                                                            echo "<img src='$imagePath' width='100'>";
                                                            echo "<input type='hidden' name='existing_images[]' value='{$multipleImage['product_images_id']}'>";
                                                            echo "<input type='file' class='form-control' name='room_image[]' accept='.jpg, .jpeg, .png'>";
                                                            echo "<button type='button' class='btn btn-danger' onclick='removeImage($imageCounter)'>Remove Image $imageCounter</button>";
                                                            echo "</div>";
                                                        } else {
                                                            echo "<p>Image not found: $imagePath</p>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<p>No multiple images found for this product.</p>";
                                                }
                                                ?>
                                            </div>
                                            <button type="button" class="btn btn-success" onclick="addMoreImages()">Add Image +</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="product_status" name="product_status" <?php if ($getData['product_status'] == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="product_status">Product Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isdisplayhome" name="isdisplayhome" <?php if ($getData['isdisplayhome'] == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="isdisplayhome">Display on Home</label>
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
    let imageCounter = <?php echo $imageCounter; ?>;
    let existingImages = [];
    let updatedImages = [];

    <?php
    if (mysqli_num_rows($getMultipleImagesSql) > 0) {
        while ($multipleImage = mysqli_fetch_assoc($getMultipleImagesSql)) {
            echo "existingImages.push({$multipleImage['product_images_id']});";
        }
    }
    ?>

    function addMoreImages() {
        imageCounter++;
        const imageFieldHTML = `<div class="mb-3" id="image_field_${imageCounter}">
               <label class="form-label">Image ${imageCounter}</label>
               <input type="file" class="form-control" name="room_image[]" accept=".jpg, .jpeg, .png" required>
               <button type="button" class="btn btn-danger" onclick="removeImage(${imageCounter})">Remove Image ${imageCounter}</button>
           </div>`;
        $('#current_images').append(imageFieldHTML);
    }

    function removeImage(counter) {
        $(`#image_field_${counter}`).remove();
        // Track removed images
        updatedImages.push(counter);
    }
</script>

<?php include "footer.php"; ?>
