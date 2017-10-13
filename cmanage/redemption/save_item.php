<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['save_item'])){
		
		$item_cat = mysqli_real_escape_string($dbconnect, $_POST['redeem_category']);
		$item_class = mysqli_real_escape_string($dbconnect, $_POST['redeem_class']);
		$item_name = mysqli_real_escape_string($dbconnect, $_POST['item_name']);
		$item_model = mysqli_real_escape_string($dbconnect, $_POST['item_model']);
		$item_point = mysqli_real_escape_string($dbconnect, $_POST['item_point']);
		$item_token = mysqli_real_escape_string($dbconnect, $_POST['item_token']);
		$item_stock = mysqli_real_escape_string($dbconnect, $_POST['item_stock']);
		$item_image = isset($_FILES['item_image']);
		$item_description = mysqli_real_escape_string($dbconnect, $_POST['item_description']);
	
		if($item_name == "" || $item_point == "" || $item_token == "" || $item_stock == ""|| $item_image == ""){
			header("location:add_redemption.php?add=empty&hyperlink=redemption");
		}else{
			$file_name = $_FILES['item_image']['name'];
			$tmp_name = $_FILES['item_image']['tmp_name']; 
			$type = $_FILES['item_image']['type'];
			$ext = substr(strrchr($file_name, "."), 1);
			
			switch($ext){ 
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
					$cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category WHERE redemption_category_id='$item_cat'");
					$cat_display = mysqli_fetch_assoc($cat);
					
					$save_item = mysqli_query($dbconnect, "INSERT INTO pbmart_redeem(redeem_category_id, redeem_category, redeem_class, redeem_name, redeem_model, redeem_point, redeem_token, redeem_stock, redeem_image, redeem_description) VALUES ('$item_cat', '".$cat_display['redemption_category_name']."', '$item_class', '$item_name', '$item_model', '$item_point', '$item_token', '$item_stock', '$item_img', '$item_description')");
					
					if($save_item){
						header("location:add_redemption.php?add=true&hyperlink=redemption");
					}else{
						header("location:add_redemption.php?add=false&hyperlink=redemption");
					}
				}else{
					header("location:add_redemption.php?add=iFalse&hyperlink=redemption");
				}
			}
		}
	}
?>