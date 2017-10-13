<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$duration = mysqli_real_escape_string($dbconnect, $_POST['package_duration']);
	$category = mysqli_real_escape_string($dbconnect, $_POST['package_category']);
	$name = mysqli_real_escape_string($dbconnect, $_POST['package_name']);
	$model = mysqli_real_escape_string($dbconnect, $_POST['package_model']);
	$quantity = mysqli_real_escape_string($dbconnect, $_POST['package_quantity']);
	$price = mysqli_real_escape_string($dbconnect, $_POST['package_price']);
	$pack_type = mysqli_real_escape_string($dbconnect, $_POST['package_type']);
	$unit = mysqli_real_escape_string($dbconnect, $_POST['package_unit']);
	$image_save = 0;
	
	if($duration == "" || $category == "" || $name == "" || $quantity == "" || $price == "" || $pack_type == "" || ($pack_type == "Restockable" && $unit == "")){
		header("location:add_duration_promotion.php?save=empty&hyperlink=products");
	}else{
		$file_name = $_FILES['package_photo']['name'];
		$tmp_name = $_FILES['package_photo']['tmp_name'];
		$type = $_FILES['package_photo']['type'];
		$ext = substr(strrchr($file_name, "."), 1);

		switch($ext){ 
			case 'pjpeg':
				$package_img = 'duration_photo/'.uniqid('').'.jpg';
				break;
			case 'jpg':
				$package_img = 'duration_photo/'.uniqid('').'.jpg';
				break;
			case 'jpeg': 
				$package_img = 'duration_photo/'.uniqid('').'.jpg';
				break;
			case 'gif':
				$package_img = 'duration_photo/'.uniqid('').'.gif';
				break;
			case 'png':
				$package_img = 'duration_photo/'.uniqid('').'.png';
				break;
		}

		if($package_img != ''){ 
			if(move_uploaded_file($tmp_name, $package_img)){
				$image_save = $image_save + 1;
			}else{
			}
		}
		
		if($image_save == 1){
			$save_du_promo = mysqli_query($dbconnect, "INSERT INTO pbmart_duration_promotion(duration_promo_duration, duration_promo_category_id, duration_promo_name, duration_promo_model, duration_promo_bundle, duration_promo_price, duration_promo_type, duration_promo_quantity, duration_promo_photo) VALUES('$duration', '$category', '$name', '$model', '$quantity', '$price', '$pack_type', '$unit', '$package_img')");
			
			if($save_du_promo){
				header("location:add_duration_promotion.php?save=true&hyperlink=products");
			}else{
				header("location:add_duration_promotion.php?save=false&hyperlink=products");
			}
		}else{
			header("location:add_duration_promotion.php?save=iFalse&hyperlink=products");
		}
	}
?>