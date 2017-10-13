<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	$mem_class = mysqli_real_escape_string($dbconnect, $_GET['class']);
	$pro_class = mysqli_real_escape_string($dbconnect, $_GET['pro_class']);
	
	if($pro_class == "prod"){
		$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$pro_id'");
		$product_display = mysqli_fetch_assoc($product);
		$pro_stock = $product_display['product_stock'];
		$prod_class = "Product";
	}else{
		$promotion = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_id='$pro_id'");
		$promotion_display = mysqli_fetch_assoc($promotion);
		$pro_stock = $promotion_display['promotion_package_stock'];
		$prod_class = "Promotion";
	}
	
	if(isset($_POST['add_to_cart'])){
		$stock = mysqli_real_escape_string($dbconnect, $_POST['add_cart']);
		$stock_mygaz = mysqli_real_escape_string($dbconnect, $_POST['add_cart_mygaz']);
		$stock_petronas = mysqli_real_escape_string($dbconnect, $_POST['add_cart_petronas']);
		
		if($stock == 0 || $stock == "" || $stock < 0 || $stock > $product_display['product_stock']){
			if($stock == 0 || $stock == ""){
				header("location:view_product.php?pro=$pro_id&add=empty&hyperlink=orders");
			}else if($stock < 0){
				header("location:view_product.php?pro=$pro_id&add=less&hyperlink=orders");
			}else if($stock > $product_display['product_stock']){
				header("location:view_product.php?pro=$pro_id&add=more&hyperlink=orders");
			}
		}else{
			$cart = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin_cart WHERE cart_product_id='$pro_id'");
			$cart_display = mysqli_fetch_assoc($cart);
			$cart_row = mysqli_num_rows($cart);
			
			if($cart_row){
				$amount = $cart_display['cart_product_amount'] + $stock;
				$amount_mygaz = $cart_display['cart_mygaz_amount'] + $stock_mygaz;
				$amount_petronas = $cart_display['cart_petronas_amount'] + $stock_petronas;
				
				$add_cart = mysqli_query($dbconnect, "UPDATE pbmart_admin_cart SET cart_product_amount='$amount', cart_mygaz_amount='$amount_mygaz', cart_petronas_amount='$amount_petronas' WHERE cart_product_id='$pro_id' AND cart_product_class='$prod_class'");
				
				$stock_reduce = $product_display['product_stock'] - $stock;
				
				if($prod_class == "Product")
					$reduce_stock = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$stock_reduce' WHERE product_id='$pro_id'");
				else if($prod_class == "Promotion")
					$reduce_stock = mysqli_query($dbconnect, "UPDATE pbmart_promotion SET promotion_package_stock='$stock_reduce' WHERE promotion_id='$pro_id'");
				
				/*if($amount < $product_display['product_sale1']){
					$sale = 0;
				}else if($amount >= $product_display['product_sale1'] && $amount < $product_display['product_sale2']){
					$sale = $product_display['product_sale_percentage1'];
				}else if($amount >= $product_display['product_sale2'] && $amount < $product_display['product_sale3']){
					$sale = $product_display['product_sale_percentage2'];
				}else{
					$sale = $product_display['product_sale_percentage3'];
				}
				
				$add_sale = mysqli_query($dbconnect, "UPDATE pbmart_admin_cart SET cart_product_sale='$sale' WHERE cart_product_id='$pro_id'");*/
			}else{
				
				if($prod_class == "Product"){	
				$name = $product_display['product_name'];
				
				if($mem_class == "mem"){
					$price = $product_display['product_price'];
					$handling = $product_display['product_handling'];
				}else if($mem_class == "com"){
					$price = $product_display['product_commercial_price'];
					$handling = $product_display['product_commercial_handling'];
				}else if($mem_class == "com_k"){
					$price = $product_display['product_commercial_price2'];
					$handling = $product_display['product_commercial_handling2'];
				}
				
				/*if($stock < $product_display['product_sale1']){
					$sale = 0;
				}else if($stock >= $product_display['product_sale1'] && $stock < $product_display['product_sale2']){
					$sale = $product_display['product_sale_percentage1'];
				}else if($stock >= $product_display['product_sale2'] && $stock < $product_display['product_sale3']){
					$sale = $product_display['product_sale_percentage2'];
				}else{
					$sale = $product_display['product_sale_percentage3'];
				}*/
				
				$add_cart = mysqli_query($dbconnect, "INSERT INTO pbmart_admin_cart(cart_product_id, cart_product_name, cart_product_price, cart_handling, cart_product_sale, cart_product_amount, cart_mygaz_amount, cart_petronas_amount) VALUES ('$pro_id', '$name', '$price', '$handling', '$sale', '$stock', '$stock_mygaz', '$stock_petronas')");
				
				$stock_reduce = $product_display['product_stock'] - $stock;
				
				$reduce_stock = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$stock_reduce' WHERE product_id='$pro_id'");
			}
			
			if($add_cart && $reduce_stock){
				header("location:make_order.php?hyperlink=orders&class=$mem_class");
			}else{
				header("location:view_product.php?pro=$pro_id&add=false&hyperlink=orders&class=$mem_class");
			}
		}
	}
?>