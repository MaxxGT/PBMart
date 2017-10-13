<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$item_id = mysqli_real_escape_string($dbconnect, $_GET['it']);
	$cat = mysqli_real_escape_string($dbconnect, $_POST['redeem_category']);
	$item_class = mysqli_real_escape_string($dbconnect, $_POST['redeem_class']);
	$name = mysqli_real_escape_string($dbconnect, $_POST['item_name']);
	$model = mysqli_real_escape_string($dbconnect, $_POST['item_model']);
	$point = mysqli_real_escape_string($dbconnect, $_POST['item_point']);
	$token = mysqli_real_escape_string($dbconnect, $_POST['item_token']);
	
	$description = mysqli_real_escape_string($dbconnect, $_POST['item_description']);
	
	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='$item_id'");
	$item_img_path = mysqli_fetch_assoc($item);
	
	if(isset($_POST['save_edit_item'])){
		if($name == "" || $cat == "" || $item_class == "" || $point == "" || $token ==""){
			header("location:edit_item.php?it=$item_id&save=empty&hyperlink=redemption");
		}else{
			if(($_FILES['item_image']['size'] <= 0)){
				$item_img = $item_img_path['redeem_image'];
			}else{
				$file_name = $_FILES['item_image']['name'];
				$tmp_name = $_FILES['item_image']['tmp_name']; 
				$type = $_FILES['item_image']['type'];
				$ext = substr(strrchr($file_name, "."), 1);
				unlink($item_img_path['redeem_image']);
				
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
					}else{
						header("location:edit_item.php?it=$item_id&save=iFalse&hyperlink=redemption");
					}
				}
			}
			
			$redeem_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category WHERE redemption_category_id='$cat'");
			$redeem_dis = mysqli_fetch_assoc($redeem_cat);
			
			$save_edit_item = mysqli_query($dbconnect, "UPDATE pbmart_redeem SET redeem_category_id='$cat', redeem_category='".$redeem_dis['redemption_category_name']."', redeem_class='$item_class', redeem_name='$name', redeem_model='$model', redeem_point='$point', redeem_token='$token', redeem_image='$item_img', redeem_description='$description' WHERE redeem_id='$item_id'");
			
			if($save_edit_item){
				header("location:edit_item.php?it=$item_id&save=true&hyperlink=redemption");
			}else{
				header("location:edit_item.php?it=$item_id&save=false&hyperlink=redemption");
			}
		}
	}
?>