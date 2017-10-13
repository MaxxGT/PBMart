<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$cat_id = mysqli_real_escape_string($dbconnect, $_GET['id']);
	
	if(isset($_POST['cat_save'])){
		if($_POST['category'] == ""){
			header("location:edit_category.php?cat=$cat_id&edit=empty&hyperlink=products");
		}else{
			$cat_name = mysqli_real_escape_string($dbconnect, $_POST['category']);
			$cat_description = mysqli_real_escape_string($dbconnect, $_POST['cat_description']);
			
			$save_cat = mysqli_query($dbconnect, "UPDATE pbmart_category SET category_name='$cat_name', category_description='$cat_description' WHERE category_id='$cat_id'");
			
			if($save_cat){
				header("location:category.php?save=true&hyperlink=products");
			}else{
				header("location:edit_category.php?cat=$cat_id&edit=false&hyperlink=products");
			}
		}
	}
?>