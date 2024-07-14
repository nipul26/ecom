<?php 
	include "config.inc.php";
	$main_category_id = mysqli_real_escape_string($conn, $_POST["main_category_id"]);
	$res = mysqli_query($conn,"SELECT * FROM subcategories WHERE categories_id = '$main_category_id' AND status='1'");
	if(mysqli_num_rows($res)>0){
		$html = '<option value="">Select Sub Category</option>';
		while($row=mysqli_fetch_assoc($res)){
			$html.="<option value=".$row['sub_categories_id'].">".$row['sub_categories_name']."</option>";
		}
		echo $html;
	}else{
		echo "<option value=''>Sub Category Not Found</option>";
	}
?>