<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$promo_cat_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	
	$promo_name = mysqli_real_escape_string($dbconnect, $_POST['promotion_name']);
	$promo_desc = mysqli_real_escape_string($dbconnect, $_POST['promotion_description']);
	
	$promo = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='$promo_cat_id'");
	$promo_display = mysqli_fetch_assoc($promo);
	
	if($promo_name == ""){
		header("location:edit_promotion_category.php?pro=$promo_cat_id&save=empty&hyperlink=products");
	}else{
		if(($_FILES['promotion_image']['size'] <= 0)){
			$promo_img = $promo_display['promotion_category_photo'];
		}else{
			$file_name = $_FILES['promotion_image']['name'];
			$tmp_name = $_FILES['promotion_image']['tmp_name']; 
			$type = $_FILES['promotion_image']['type'];
			$ext = substr(strrchr($file_name, "."), 1);

			switch($ext){ 
				case 'pjpeg':
				$promo_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpg':
				$promo_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpeg': 
				$promo_img = 'photo/'.uniqid('').'.jpg';
				break; 

			case 'gif':
				$promo_img = 'photo/'.uniqid('').'.gif';
				break;
				
			case 'png':
				$promo_img = 'photo/'.uniqid('').'.png';
				break;
			}

			if($promo_img != ''){ 
				if(move_uploaded_file($tmp_name, $promo_img)){
				}else{
					header("location:edit_promotion_category.php?pro=$promo_cat_id&save=iFalse&hyperlink=products");
				}
			}
		}
		
		$edit_promo_cat = mysqli_query($dbconnect, "UPDATE pbmart_promotion_category SET promotion_category_name='$promo_name', promotion_category_description='$promo_desc', promotion_category_photo='$promo_img' WHERE promotion_category_id='$promo_cat_id'");
		
		if($edit_promo_cat){
			header("location:promotion_category.php?save=true&hyperlink=products");
		}else{
			header("location:edit_promotion_category.php?pro=$promo_cat_id&save=false&hyperlink=products");
		}
	}
?>