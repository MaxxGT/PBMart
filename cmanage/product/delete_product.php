<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['pro_delete'])){
		if(!isset($_POST['productList'])){
			header("location:view_product.php?del=empty");
		}else{
			$del_pro = $_POST['productList'];
			$count = count($del_pro);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_pro[$i];
				
				if($id > 0){
					$file_del = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id = '$id'");
					while($file_delete = mysqli_fetch_assoc($file_del)){
						$file_to_del = $file_delete['product_image'];
						unlink($file_to_del);
					}
					$delete = "DELETE FROM pbmart_product WHERE product_id = '$id'";
					$delete_product = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_product){
				header("location:view_product.php?del=true");
			}else{
				header("location:view_product.php?del=false");
			}
		}
	}
	
	if(isset($_POST['pro_deleteAll'])){
		$pro_image = mysqli_query($dbconnect, "SELECT * FROM pbmart_product");

		if(($product_rows = mysqli_num_rows($pro_image)) == 0){
			header("location:view_product.php?del=empty");
		}else{
			while($image_file = mysqli_fetch_array($pro_image)){
				$image_file_del = $image_file['product_image'];
				unlink($image_file_del);
			}
			
			$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_product");

			if($truncate){
				header("location:view_product.php?del=true");
			}else{
				header("location:view_product.php?del=false");
			}
		}
	}	
?>