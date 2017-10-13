<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	
	$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id = '$pro_id'");
	$pro_get = mysqli_fetch_assoc($pro_result);	
	
	$pro_add_stock = mysqli_real_escape_string($dbconnect, $_POST['product_add_stock']);
	
	if(isset($_POST['add_product_stock'])){
		if($pro_add_stock == ""){
			header("location:add_product_stock.php?pro=$pro_id&add=empty&hyperlink=products");
		}else{
			if($pro_add_stock <= 0){
				header("location:add_product_stock.php?pro=$pro_id&add=less");
			}else{
				
				$pro_stock = $pro_get['product_stock'] + $pro_add_stock;
				
				$add_pro_stock = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$pro_stock' WHERE product_id='$pro_id'");
				
				if($add_pro_stock){
					header("location:add_product_stock.php?pro=$pro_id&add=true&hyperlink=products");
				}else{
					header("location:add_product_stock.php?pro=$pro_id&add=false&hyperlink=products");
				}
			}
		}	
	}
?>