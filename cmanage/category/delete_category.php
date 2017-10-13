<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['cat_delete'])){
		if(!isset($_POST['categoryList'])){
			header("location:category.php?del=empty&hyperlink=products");
		}else{
			$del_cat = $_POST['categoryList'];
			$count = count($del_cat);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_cat[$i];
				
				if($id > 0){
					$check = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_category_id='$id'");
					if(mysqli_num_rows($check)){
						$emp = false;
					}else{
						$cat_delete = "DELETE FROM pbmart_category WHERE category_id = '$id'";
						$delete_category = mysqli_query($dbconnect, $cat_delete);
					}
				}
			}
			
			if($delete_category){
				header("location:category.php?del=true&hyperlink=products");
			}else if(!$emp){
				header("location:category.php?del=nemp&hyperlink=products");
			}else{
				header("location:category.php?del=false&hyperlink=products");
			}
		}
	}
	
	if(isset($_POST['cat_deleteAll'])){
		$category_search = mysqli_query($dbconnect, "SELECT * FROM pbmart_category");
		
		if(($banner_rows = mysqli_num_rows($category_search)) == 0){
			header("location:category.php?del=empty&hyperlink=products");
		}else{
			
			$check = mysqli_query($dbconnect, "SELECT * FROM pbmart_category");
			$rows = 0;
			while($checking = mysqli_fetch_array($check)){
				$checks = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_category_id='".$checking['category_id']."'");
				
				if(mysqli_num_rows($checks)){
					$rows = $rows + 1;
				}else{
					$rows = $rows;
				}
			}
				if($rows != 0){
					$emp = false;
				}else{
					$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_category");
				}
				
				if($truncate){
					header("location:category.php?del=true&hyperlink=products");
				}else if(!$emp){
					header("location:category.php?del=nemp&hyperlink=products");
				}else{
					header("location:category.php?del=false&hyperlink=products");
				}
		}
	}
?>