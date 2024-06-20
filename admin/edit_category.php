<?php include "header.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
	if($_GET['type'] == 'edit' && $_GET['id'] != ''){
		$currentId = $_GET['id'];
		$getSql = mysqli_query($conn,"SELECT * FROM categories WHERE categories_id = '$currentId'");
		$getData = mysqli_fetch_assoc($getSql);
		$currentFirstCategoryName = $getData['categories_name'];

		if(isset($_POST['submit'])) {
        $newCategoryName = mysqli_real_escape_string($conn, $_POST['category_name']);

        $checkRecordSql = mysqli_query($conn, "SELECT * FROM categories WHERE categories_name = '$newCategoryName' AND categories_id != '$currentId'");
        
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
            $updateSql = mysqli_query($conn, "UPDATE categories SET categories_name = '$newCategoryName', update_on = '$updated_on' WHERE categories_id = '$currentId'");
            
            if($updateSql) {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Category name updated successfully.",
                        icon: "success",
                        button: "Okay",
                    }).then(function() {
                        window.location = "categories.php";
                    });
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    swal({
                        title: "Error",
                        text: "Failed to update category name.",
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
        window.location.href = 'categories.php';
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
                            <h4 class="card-title">Update Category</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Category Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Category Name" name="category_name" value="<?php echo $currentFirstCategoryName; ?>" required>
                                            <div class="invalid-feedback">
                                                This is required field.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary">
                                <a href="categories.php" style="color:white;">Back</a>
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