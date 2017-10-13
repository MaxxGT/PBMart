<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['edit_save_promotion'])){
		$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
		$pro_cat = mysqli_real_escape_string($dbconnect, $_POST['promotion_cat']);
		$pro_name = mysqli_real_escape_string($dbconnect, $_POST['product_name']);
		$pro_model = mysqli_real_escape_string($dbconnect, $_POST['product_model']);
		$pro_ori = mysqli_real_escape_string($dbconnect, $_POST['product_ori']);
		$pro_new = mysqli_real_escape_string($dbconnect, $_POST['product_new']);
		$pro_des = mysqli_real_escape_string($dbconnect, $_POST['product_description']);
		$item_name = mysqli_real_escape_string($dbconnect, $_POST['item_name']);
		$item_model = mysqli_real_escape_string($dbconnect, $_POST['item_model']);
		$item_ori = mysqli_real_escape_string($dbconnect, $_POST['item_ori']);
		$item_new = mysqli_real_escape_string($dbconnect, $_POST['item_new']);
		$item_des = mysqli_real_escape_string($dbconnect, $_POST['item_description']);
		$pack_name = mysqli_real_escape_string($dbconnect, $_POST['package_name']);
		$pack_price = mysqli_real_escape_string($dbconnect, $_POST['package_price']);
		$pack_point = mysqli_real_escape_string($dbconnect, $_POST['package_point']);
		$pack_stock = mysqli_real_escape_string($dbconnect, $_POST['package_stock']);
		$pack_limit = mysqli_real_escape_string($dbconnect, $_POST['package_limit']);
		$pack_life_limit = mysqli_real_escape_string($dbconnect, $_POST['package_life_limit']);
		$pack_start = mysqli_real_escape_string($dbconnect, $_POST['new_date']);
		$pack_end = mysqli_real_escape_string($dbconnect, $_POST['end_date']);
		$pack_des = mysqli_real_escape_string($dbconnect, $_POST['package_description']);
		
		$promo = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_id='$pro_id'");
		$promo_img = mysqli_fetch_assoc($promo);
		
		if($pro_cat == "" || $pro_name == "" ||$pro_ori == "" || $pro_new == "" || $item_name == "" || $item_ori == "" || $item_new == "" || $pack_name == "" || $pack_price == "" || $pack_point == "" || $pack_stock == "" || $pack_limit == "" || $pack_life_limit == "" || $pack_start == "" || $pack_end == ""){
			header("location:edit_promotion.php?pro=$pro_id&save=empty&hyperlink=products");
		}else{
			if(isset($_POST['promo_double_point'])){
				$double_point = 1;
			}else{
				$double_point = 0;
			}
			
			if(($_FILES['product_image']['size'] <= 0)){
				$pro_img = $promo_img['promotion_product_photo'];
			}else{
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
					}else{
					}
				}
			}
			
			if(($_FILES['item_image']['size'] <= 0)){
				$item_img = $promo_img['promotion_item_photo'];
			}else{
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
					}else{
					}
				}
			}
			
			$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='$pro_cat'");
			$promo_display = mysqli_fetch_assoc($promo_cat);
			
			$save_promotion = mysqli_query($dbconnect, "UPDATE pbmart_promotion SET promotion_product_name='$pro_name', promotion_product_model='$pro_model', promotion_product_price='$pro_ori', promotion_product_sale='$pro_new', promotion_product_photo='$pro_img', promotion_product_description='$pro_des', promotion_item_name='$item_name', promotion_item_model='$item_model', promotion_item_price='$item_ori', promotion_item_sale='$item_new', promotion_item_photo='$item_img', promotion_item_description='$item_des', promotion_category_id='".$promo_display['promotion_category_id']."', promotion_category_name='".$promo_display['promotion_category_name']."', promotion_package_name='$pack_name', promotion_package_price='$pack_price', promotion_package_point='$pack_point', promotion_package_double_point='$double_point', promotion_package_stock='$pack_stock', promotion_package_limit='$pack_limit', promotion_package_lifetime_limit='$pack_life_limit', promotion_start_date='$pack_start', promotion_end_date='$pack_end', promotion_package_description='$pack_des' WHERE promotion_id='$pro_id'");
			
			if($save_promotion){
				header("location:edit_promotion.php?pro=$pro_id&save=true&hyperlink=products");
			}else{
				header("location:edit_promotion.php?pro=$pro_id&save=false&hyperlink=products");
			}
		}
	}
?>