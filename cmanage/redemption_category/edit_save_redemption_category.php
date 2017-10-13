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
			header("location:edit_redemption_category.php?cat=$cat_id&edit=empty&hyperlink=redemption");
		}else{
			$cat_name = mysqli_real_escape_string($dbconnect, $_POST['category']);
			$cat_description = mysqli_real_escape_string($dbconnect, $_POST['cat_description']);
			
			$save_cat = mysqli_query($dbconnect, "UPDATE pbmart_redemption_category SET redemption_category_name='$cat_name', redemption_category_description='$cat_description' WHERE redemption_category_id='$cat_id'");
			
			if($save_cat){
				header("location:redemption_category.php?edit=true&hyperlink=redemption");
			}else{
				header("location:edit_redemption_category.php?cat=$cat_id&edit=false&hyperlink=redemption");
			}
		}
	}
?>