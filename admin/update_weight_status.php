<?php
	include "config.inc.php"; 
	if(isset($_POST)){
		$id = $_POST['id'];
		$checkCurrentStatus = mysqli_query($conn,"SELECT weight_status FROM weight_master WHERE weight_master_id = '$id'");
		$getStatus = mysqli_fetch_assoc($checkCurrentStatus);
		if($getStatus['weight_status'] == 1){
			$updateSql = mysqli_query($conn,"UPDATE `weight_master` SET `weight_status`='0' WHERE weight_master.weight_master_id  = '$id'");
		}else{
			$updateSql = mysqli_query($conn,"UPDATE `weight_master` SET `weight_status`='1' WHERE weight_master.weight_master_id  = '$id'");
		}

		if($updateSql){
			$jsonArr = array('status' => 'true', 'msg' => 'Status Update Successfully.');
		}else{
			$jsonArr = array('status' => 'false', 'msg' => 'Something Went Wrong.');
		}
		echo json_encode($jsonArr);
	}
?>