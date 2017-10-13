<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['clear_cart'])){
		$cart = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin_cart");
		$cart_row = mysqli_num_rows($cart);
		$mem_class = mysqli_real_escape_string($dbconnect, $_GET['class']);
		
		if(!$cart_row){
			header("location:make_order.php?clear=empty&hyperlink=orders&class=$mem_class");
		}else{
			while($cart_display = mysqli_fetch_array($cart)){
				$pro_id = $cart_display['cart_product_id'];
				$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$pro_id'");
				$product_display = mysqli_fetch_assoc($product);
				$amount = $product_display['product_stock'] + $cart_display['cart_product_amount'];
				$add_back = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$amount' WHERE product_id='$pro_id'");
			}
			
			$clear_cart = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_admin_cart");
			
			if($add_back && $clear_cart){
				header("location:make_order.php?clear=true&hyperlink=orders&class=$mem_class");
			}else{
				header("location:make_order.php?clear=false&hyperlink=orders&class=$mem_class");
			}
		}
	}
?>