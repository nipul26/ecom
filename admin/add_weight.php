<?php include "header.php"; ?>

<!-- Submit Action  -->
<?php 
	if(isset($_POST['submit'])){
		$weight = mysqli_real_escape_string($conn,$_POST['weight']);
		$added_on = date('y-m-d h:i:s');
		$updated_on = date('y-m-d h:i:s');

		$checkSql = mysqli_query($conn,"SELECT * FROM weight_master WHERE weight = '$weight'");
		if(mysqli_num_rows($checkSql)>0){
		?>	
		<script type="text/javascript">
			swal({
            	title: "Warning",
              	text: "Data Already Exist.",
              	icon: "error",
              	button: "Okay",
            });
		</script>
		<?php
		}else{
			$insertSql = mysqli_query($conn,"INSERT INTO `weight_master`(`weight`, `weight_status`, `added_on`, `updated_on`) VALUES ('$weight','1','$added_on','$updated_on')");
			if($insertSql){ ?>
				<script type="text/javascript">
					swal({
		                title: "Success",
		                text: "Data Added Successfully.",
		                icon: "success",
		                button: "Okay", 
		            }).then(function() {
					   window.location = "weight.php";
					});
				</script>
			<?php }else{ ?>
				<script type="text/javascript">
					swal({
		              	title: "Warning",
		              	text: "Somthing Went Wrong.",
		              	icon: "error",
		              	button: "Okay",
		            });
				</script>
		<?php }
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
                            <h4 class="card-title">Add Weight</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Weight</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Weight" name="weight" required>
                                            <div class="invalid-feedback">
                                                This is required field.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary">
                                <a href="weight.php" style="color:white;">Back</a>
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