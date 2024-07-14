<?php include "header.php"; ?>
<?php 
	if($_GET['type'] == 'edit' && $_GET['id'] != ''){
		$currentId = $_GET['id'];
		$getSql = mysqli_query($conn,"SELECT * FROM weight_master WHERE weight_master_id = '$currentId'");
		$getData = mysqli_fetch_assoc($getSql);
		$currentWeight = $getData['weight'];

		if(isset($_POST['submit'])){
			$weight = mysqli_real_escape_string($conn,$_POST['weight']);
			$updated_on = date('y-m-d h:i:s');

			$checkRecordSql = mysqli_query($conn,"SELECT * FROM weight_master WHERE weight = '$weight'");

			if(mysqli_num_rows($checkRecordSql)>0 && $currentWeight!=$weight){
			?>
				<script type="text/javascript">
					swal({
		              title: "Warning",
		              text: "Data Is Already Exist",
		              icon: "error",
		              button: "Okay",
		            });
				</script>
			<?php
			}else{
				$updateSql = mysqli_query($conn,"UPDATE `weight_master` SET `weight`='$weight',`updated_on`='$updated_on' WHERE weight_master.weight_master_id = '$currentId'");
				if($updateSql){ ?>
					<script type="text/javascript">
					swal({
	                    title: "Success",
	                    text: "Data Update Successfully",
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
					<?php 
				}
			}
		}	
	}else{
?>
	<script type="text/javascript">
		window.location.href = 'weight.php';
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
                            <h4 class="card-title">Update Weight Master</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Weight</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Weight Name" name="weight" value="<?php echo $currentWeight; ?>" required>
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