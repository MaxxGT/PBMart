<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['promo_delete'])){
		if(!isset($_POST['promotionCategoryList'])){
			header("location:promotion_category.php?del=empty&hyperlink=products");
		}else{
			$del_promo_cat = $_POST['promotionCategoryList'];
			$count = count($del_promo_cat);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_promo_cat[$i];
				
				if($id > 0){
					$file_del = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id = '$id'");
					while($file_delete = mysqli_fetch_assoc($file_del)){
						$file_to_del = $file_delete['promotion_category_photo'];
						unlink($file_to_del);
					}
					$delete = "DELETE FROM pbmart_promotion_category WHERE promotion_category_id = '$id'";
					$delete_banner = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_banner){
				header("location:promotion_category.php?del=true&hyperlink=products");
			}else{
				header("location:promotion_category.php?del=false&hyperlink=products");
			}
		}
	}
	
	if(isset($_POST['promo_deleteAll'])){
		$promo_cat_search = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category");
		
		if(($banner_rows = mysqli_num_rows($promo_cat_search)) == 0){
			header("location:promotion_category.php?del=empty&hyperlink=products");
		}else{
			while($promo_cat_file = mysqli_fetch_array($promo_cat_search)){
				$file_to_del = $promo_cat_file['promotion_category_photo'];
				unlink($file_to_del);
			}
			
			$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_promotion_category");

			if($truncate){
				header("location:promotion_category.php?del=true&hyperlink=products");
			}else{
				header("location:promotion_category.php?del=false&hyperlink=products");
			}
		}
	}
?>