<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['cat_save'])){
		if($_POST['category'] == ""){
			header("location:category.php?save=empty&hyperlink=redemption");
		}else{
			$cat_name = mysqli_real_escape_string($dbconnect, $_POST['category']);
			$cat_description = mysqli_real_escape_string($dbconnect, $_POST['cat_description']);
			
			$save_cat = mysqli_query($dbconnect, "INSERT INTO pbmart_redemption_category(redemption_category_name, redemption_category_description) VALUES ('$cat_name', '$cat_description')");
			
			if($save_cat){
				header("location:redemption_category.php?save=true&hyperlink=redemption");
			}else{
				header("location:redemption_category.php?save=false&hyperlink=redemption");
			}
		}
	}
?>