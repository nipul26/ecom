<?php include 'config.inc.php'; ?>
<?php 
	$weight_master_id=mysqli_real_escape_string($conn,$_POST['weight_master_id']);
    $delete_sql="DELETE FROM weight_master where weight_master_id ='$weight_master_id'";
    mysqli_query($conn,$delete_sql);
?>