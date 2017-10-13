<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['add_package'])){
		$image_save = 0;
		
		$pro_cat = mysqli_real_escape_string($dbconnect, $_POST['promotion_cat']);
		$pro_name = mysqli_real_escape_string($dbconnect, $_POST['product_name']);
		$pro_model = mysqli_real_escape_string($dbconnect, $_POST['product_model']);
		$pro_ori = mysqli_real_escape_string($dbconnect, $_POST['product_ori']);
		$pro_new = mysqli_real_escape_string($dbconnect, $_POST['product_new']);
		$pro_image = isset($_FILES['product_image']);
		$pro_des = mysqli_real_escape_string($dbconnect, $_POST['product_description']);
		$item_name = mysqli_real_escape_string($dbconnect, $_POST['item_name']);
		$item_model = mysqli_real_escape_string($dbconnect, $_POST['item_model']);
		$item_ori = mysqli_real_escape_string($dbconnect, $_POST['item_ori']);
		$item_new = mysqli_real_escape_string($dbconnect, $_POST['item_new']);
		$item_image = isset($_FILES['item_image']);
		$item_des = mysqli_real_escape_string($dbconnect, $_POST['item_description']);
		$pack_name = mysqli_real_escape_string($dbconnect, $_POST['package_name']);
		$pack_price = mysqli_real_escape_string($dbconnect, $_POST['package_price']);
		$pack_point = mysqli_real_escape_string($dbconnect, $_POST['package_point']);
		$pack_stock = mysqli_real_escape_string($dbconnect, $_POST['package_stock']);
		
		$pack_limit = mysqli_real_escape_string($dbconnect, $_POST['package_limit']);
		$pack_lifetime_limit = mysqli_real_escape_string($dbconnect, $_POST['package_life_limit']);
		
		$pack_start = mysqli_real_escape_string($dbconnect, $_POST['new_date']);
		$pack_end = mysqli_real_escape_string($dbconnect, $_POST['end_date']);
		$pack_image = isset($_FILES['package_image']);
		$pack_des = mysqli_real_escape_string($dbconnect, $_POST['package_description']);
		
		if($pro_cat == "" || $pro_name == "" || $pro_ori == "" || $pro_new == "" || $item_name == "" || $item_ori == "" || $item_new =="" || $pack_name == "" || $pack_price == "" || $pack_point == "" || $pack_stock == "" || $pack_start == "" || $pack_end == ""){
			header("location:add_promotion.php?save=empty&hyperlink=products");
		}else{
			if(isset($_POST['promo_double_point'])){
				$double_point = 1;
			}else{
				$double_point = 0;
			}
			
			$file_name = $_FILES['product_image']['name'];
			$tmp_name = $_FILES['product_image']['tmp_name'];
			$type = $_FILES['product_image']['type'];
			$ext = substr(strrchr($file_name, "."), 1);

			switch($ext){ 
				case 'pjpeg':
				$pro_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpg':
				$pro_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpeg': 
				$pro_img = 'photo/'.uniqid('').'.jpg';
				break; 

			case 'gif':
				$pro_img = 'photo/'.uniqid('').'.gif';
				break;
			
			case 'png':
				$pro_img = 'photo/'.uniqid('').'.png';
				break;
			}

			if($pro_img != ''){ 
				if(move_uploaded_file($tmp_name, $pro_img)){
					$image_save = $image_save + 1;
				}else{
				}
			}
			
			$file_name1 = $_FILES['item_image']['name'];
			$tmp_name = $_FILES['item_image']['tmp_name']; 
			$type = $_FILES['item_image']['type'];
			$ext1 = substr(strrchr($file_name1, "."), 1);

			switch($ext1){ 
				case 'pjpeg':
				$item_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpg':
				$item_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpeg': 
				$item_img = 'photo/'.uniqid('').'.jpg';
				break; 

			case 'gif':
				$item_img = 'photo/'.uniqid('').'.gif';
				break;
			
			case 'png':
				$item_img = 'photo/'.uniqid('').'.png';
				break;
			}

			if($item_img != ''){ 
				if(move_uploaded_file($tmp_name, $item_img)){
					$image_save = $image_save + 1;
				}else{
				}
			}
		
			$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='$pro_cat'");
			$promo_display = mysqli_fetch_assoc($promo_cat);
		
			if($image_save == 2){
				$save_promotion = mysqli_query($dbconnect, "INSERT INTO pbmart_promotion(promotion_product_name, promotion_product_model, promotion_product_price, promotion_product_sale, promotion_product_photo, promotion_product_description, promotion_item_name, promotion_item_model, promotion_item_price, promotion_item_sale, promotion_item_photo, promotion_item_description, promotion_category_id, promotion_category_name, promotion_package_name, promotion_package_price, promotion_package_point, promotion_package_double_point, promotion_package_stock, promotion_package_limit, promotion_package_lifetime_limit,
				promotion_start_date, promotion_end_date, promotion_package_description) VALUES ('$pro_name', '$pro_model', '$pro_ori', '$pro_new', '$pro_img', '$pro_des',  '$item_name', '$item_model', '$item_ori', '$item_new', '$item_img', '$item_des', '".$promo_display['promotion_category_id']."', '".$promo_display['promotion_category_name']."','$pack_name', '$pack_price', '$pack_point', '$double_point', '$pack_stock', '$pack_limit', '$pack_lifetime_limit', '$pack_start', '$pack_end', '$pack_des')");
				
				if($save_promotion){
					header("location:add_promotion.php?save=true&hyperlink=products");
				}else{
					header("location:add_promotion.php?save=false&hyperlink=products");
				}
			}else{
				header("location:add_promotion.php?save=iFalse&hyperlink=products");
			}
		}
	}
?>