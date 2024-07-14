<?php include 'config.inc.php';
	if(isset($_POST)){
		$main_category_id = mysqli_real_escape_string($conn,$_POST['main_category_id']);
		$sub_category_id = mysqli_real_escape_string($conn,$_POST['sub_category_id']);
		$product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
		$sku = mysqli_real_escape_string($conn,$_POST['sku']);
		$is_configure_product = mysqli_real_escape_string($conn,$_POST['is_configure_product']);
		$mrp_price = mysqli_real_escape_string($conn,$_POST['mrp_price']);
		$special_price = mysqli_real_escape_string($conn,$_POST['special_price']);
		$qty = mysqli_real_escape_string($conn,$_POST['qty']);
		$product_available_status = mysqli_real_escape_string($conn,$_POST['product_available_status']);
		$related_product_ids = mysqli_real_escape_string($conn,$_POST['related_product_ids']);
		$is_home_display = mysqli_real_escape_string($conn,$_POST['is_home_display']);
		$meta_title = mysqli_real_escape_string($conn,$_POST['meta_title']);
		$meta_keyword = mysqli_real_escape_string($conn,$_POST['meta_keyword']);
		$meta_description = mysqli_real_escape_string($conn,$_POST['meta_description']);
		$product_description = mysqli_real_escape_string($conn,$_POST['editor1']);
		$added_on = date('y-m-d h:i:s');
		$updated_on = date('y-m-d h:i:s');

		// check product name and sku is already exist

		$checkProduct = mysqli_query($conn,"SELECT * FROM products WHERE product_name = '$product_name' AND sku = '$sku'");
		if(mysqli_num_rows($checkProduct)>0){
			$jsonArray = array('status' => 'false', 'msg' => 'Product Name or SKU is already exist.');
		}else{
			if(isset($_FILES['product_main_image'])){
	           	$product_main_image = rand(1111111, 9999999) ."_" .$_FILES["product_main_image"]["name"];
	           	$file_tmp = $_FILES["product_main_image"]["tmp_name"];
	           	move_uploaded_file(
	               $file_tmp,
	               "../media/product/" . $product_main_image
	           	);   
			}

			// product main table insert
			$mainProductSql = mysqli_query($conn,"INSERT INTO `products`(`main_category_id`, `sub_category_id`, `product_name`, `sku`, `is_configure_product`, `mrp_price`, `special_price`, `qty`, `product_main_image`, `product_description`, `product_availble_status`, `related_products_id`, `product_status`, `isdisplayhome`, `meta_title`, `meta_keyword`, `meta_description`, `added_on`, `updated_on`) VALUES ('$main_category_id','$sub_category_id','$product_name','$sku','$is_configure_product','$mrp_price','$special_price','$qty','$product_main_image','$product_description','$product_available_status','$related_product_ids','1','$is_home_display','$meta_title','$meta_keyword','$meta_description','$added_on','$updated_on')");

			// product main table last insert id
			$productSqlLastId = mysqli_insert_id($conn);

			if($mainProductSql){

				// product multiple images insert
				if(isset($_FILES['product_multiple_image'])){
					foreach ($_FILES["product_multiple_image"]["name"] as $key => $value) {
			           	$multi_file_names = rand(1111111, 9999999) ."_" .$_FILES["product_multiple_image"]["name"][$key];
			           	$file_tmp = $_FILES["product_multiple_image"]["tmp_name"][$key];
			           	move_uploaded_file(
			               $file_tmp,
			               "../media/product/" . $multi_file_names
			           	);
			           	mysqli_query($conn,"INSERT INTO `product_multiple_images`(`product_main_id`, `product_image`, `added_on`, `update_on`) VALUES ('$productSqlLastId','$multi_file_names','$added_on','$updated_on')");   
				    }
				}

				// check product configurable or not
				if(isset($_POST['is_configure_product']) && $_POST['is_configure_product']==1){
					if(isset($_POST['weight_values']) && !empty($_POST['weight_values'])){
						foreach ($_POST['weight_values'] as $key => $value) {
							$weight_values = mysqli_real_escape_string($conn, $_POST['weight_values'][$key]);
							$configure_mrp_price = mysqli_real_escape_string($conn, $_POST['configure_mrp_price'][$key]);
							$configure_special_price = mysqli_real_escape_string($conn, $_POST['configure_special_price'][$key]);
							$configure_qty = mysqli_real_escape_string($conn, $_POST['configure_qty'][$key]);

							mysqli_query($conn,"INSERT INTO `product_attribute_data`(`product_attribute_main_id`, `weight_main_id`, `configure_mrp`, `configure_special_price`, `configure_qty`) VALUES ('$productSqlLastId','$weight_values','$configure_mrp_price','$configure_special_price','$configure_qty')");

						}
					}	
				}

				$jsonArray = array('status'=>'true','msg'=>'Data Added Successfully.');
			}else{
				$jsonArray = array('status'=>'false','msg'=>'something went wrong.');
			}
		}
	}else{
		$jsonArray = array('status' => 'false', 'msg' => 'Something Went Wrong.');
	}

	echo json_encode($jsonArray);


?>