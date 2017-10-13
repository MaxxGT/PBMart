<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$fileCheck = isset($_FILES['promo_image']);
	
	if(isset($_POST['save_promo'])){
		if($fileCheck == ""){
			header("location:promotion_category.php?add=0&hyperlink=products");
		}else{
			$name = mysqli_real_escape_string($dbconnect, $_POST['promo_name']);
			$desc = mysqli_real_escape_string($dbconnect, $_POST['promo_description']);
			
			$file_name = $_FILES['promo_image']['name'];
			$tmp_name = $_FILES['promo_image']['tmp_name']; 
			$type = $_FILES['promo_image']['type'];
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
					mysqli_query($dbconnect, "INSERT INTO pbmart_promotion_category(promotion_category_name, promotion_category_description, promotion_category_photo) VALUES ('$name', '$desc' ,'$promo_img')");
					header("location:promotion_category.php?add=true&hyperlink=products");
				}else{
					header("location:promotion_category.php?add=false&hyperlink=products");
				}
			}
		}
	}
?>