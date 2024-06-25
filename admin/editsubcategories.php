<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php include "header.php"; ?>

<?php
if($_GET['type'] == 'edit' && $_GET['id'] != ''){
    $currentId = $_GET['id'];
    $getSql = mysqli_query($conn, "SELECT s.sub_categories_id, s.categories_id, s.sub_categories_name, s.sub_categories_images, s.status, s.added_on, s.update_on, c.categories_name 
                                   FROM subcategories s 
                                   LEFT JOIN categories c ON s.categories_id = c.categories_id 
                                   WHERE s.sub_categories_id = '$currentId'");
    $getData = mysqli_fetch_assoc($getSql);
    $currentFirstCategoryName = $getData['sub_categories_name'];
    $currentCategoryId = $getData['categories_id'];
    $currentCategoryName = $getData['categories_name'];
    $currentImage = $getData['sub_categories_images'];

    if(isset($_POST['submit'])) {


        $newCategoryName = mysqli_real_escape_string($conn, $_POST['category_name']);
        $newCategoryId = mysqli_real_escape_string($conn, $_POST['category_id']);
        
        // Image handling
        $image = $currentImage; // Default to current image
        if ($_FILES['subcategory_image']['name'] != '') {
            $image = $_FILES['subcategory_image']['name'];
            $target =  basename($image); 
            move_uploaded_file($_FILES['subcategory_image']['tmp_name'], $target);
        }

        $checkRecordSql = mysqli_query($conn, "SELECT * FROM subcategories WHERE sub_categories_name = '$newCategoryName' AND sub_categories_id != '$currentId'");
        
        if(mysqli_num_rows($checkRecordSql) > 0) {
            ?>
            <script type="text/javascript">
                swal({
                    title: "Warning",
                    text: "Category name already exists.",
                    icon: "error",
                    button: "Okay",
                });
            </script>
            <?php
        } else {
            $updated_on = date('Y-m-d H:i:s');
            $updateSql = mysqli_query($conn, "UPDATE subcategories SET sub_categories_name = '$newCategoryName', categories_id = '$newCategoryId', sub_categories_images = '$image', update_on = '$updated_on' WHERE sub_categories_id = '$currentId'");
            
            if($updateSql) {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Category updated successfully.",
                        icon: "success",
                        button: "Okay",
                    }).then(function() {
                        window.location = "subcategories_listing.php";
                    });
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Error",
                        text: "Failed to update category.",
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
        window.location.href = 'subcategories_listing.php';
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
                            <h4 class="card-title">Update Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Sub Category Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Category Name" name="category_name" value="<?php echo $currentFirstCategoryName; ?>" required>
                                            <div class="invalid-feedback">
                                                This is a required field.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="category">Category</label>
                                            <select class="form-select" id="category" name="category_id" required>
                                                <option value="<?php echo $currentCategoryId; ?>" selected><?php echo $currentCategoryName; ?></option>
                                                <?php
                                                $categoriesSql = mysqli_query($conn, "SELECT categories_id, categories_name FROM categories");
                                                while ($category = mysqli_fetch_assoc($categoriesSql)) {
                                                    echo '<option value="' . $category['categories_id'] . '">' . $category['categories_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a category.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Sub Category Image</label>
                                            <input type="file" class="form-control" id="image" name="subcategory_image">
                                            <img src="../media/<?php echo $currentImage; ?>" style="height: 100px; width: 100px;"></img>
                                            <div class="invalid-feedback">
                                                Please choose an image file.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary">
                                            <a href="subcategories_listing.php" style="color:white;">Back</a>
                                        </button>
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

<?php include "footer.php"; ?>
