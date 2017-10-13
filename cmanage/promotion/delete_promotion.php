<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['pro_delete'])){
		if(!isset($_POST['promotionList'])){
			header("location:promotion.php?del=empty&hyperlink=products");
		}else{
			$del_pro = $_POST['promotionList'];
			$count = count($del_pro);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_pro[$i];
				
				if($id > 0){
					$file_del = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_id = '$id'");
					while($file_delete = mysqli_fetch_assoc($file_del)){
						$photo1 = $file_delete['promotion_product_photo'];
						$photo2 = $file_delete['promotion_item_photo'];
						
						$file_to_del = array($photo1, $photo2, $photo3);
						
						foreach($file_to_del as $file_to_del1){
							echo $file_to_del1;
							unlink($file_to_del1);
						}
					}
					$delete = "DELETE FROM pbmart_promotion WHERE promotion_id = '$id'";
					$delete_product = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_product){
				header("location:promotion.php?del=true&hyperlink=products");
			}else{
				header("location:promotion.php?del=false&hyperlink=products");
			}
		}
	}
	
	if(isset($_POST['pro_deleteAll'])){
		$pro_image = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion");

		if(($product_rows = mysqli_num_rows($pro_image)) == 0){
			header("location:p.php?del=empty&hyperlink=products");
		}else{
			while($file_delete = mysqli_fetch_array($pro_image)){
				$photo1 = $file_delete['promotion_product_photo'];
				$photo2 = $file_delete['promotion_item_photo'];
					
				$file_to_del = array($photo1, $photo2, $photo3);
						
				foreach($file_to_del as $file_to_del1){
					echo $file_to_del1;
					unlink($file_to_del1);
				}
			}
			
			$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_promotion");

			if($truncate){
				header("location:promotion.php?del=true&hyperlink=products");
			}else{
				header("location:promotion.php?del=false&hyperlink=products");
			}
		}
	}
?>