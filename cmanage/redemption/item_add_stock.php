<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$item_id = mysqli_real_escape_string($dbconnect, $_GET['it']);
	
	$item_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id = '$item_id'");
	$item_get = mysqli_fetch_assoc($item_result);	
	
	$item_add_stock = mysqli_real_escape_string($dbconnect, $_POST['item_add_stock']);
	
	if(isset($_POST['add_item_stock'])){
		if($item_add_stock == ""){
			header("location:add_item_stock.php?it=$item_id&add=empty&hyperlink=redemption");
		}else{
			if($item_add_stock <= 0){
				header("location:add_item_stock.php?it=$item_id&add=less");
			}else{
				
				$item_stock = $item_get['redeem_stock'] + $item_add_stock;
				
				$add_item_stock = mysqli_query($dbconnect, "UPDATE pbmart_redeem SET redeem_stock='$item_stock' WHERE redeem_id='$item_id'");
				
				if($add_item_stock){
					header("location:add_item_stock.php?it=$item_id&add=true&hyperlink=redemption");
				}else{
					header("location:add_item_stock.php?it=$item_id&add=false&hyperlink=redemption");
				}
			}
		}	
	}
?>