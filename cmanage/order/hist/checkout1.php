<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['checkout'])){
		$id = mysqli_real_escape_string($dbconnect, $_POST['member_id']);
		$firstName = mysqli_real_escape_string($dbconnect, $_POST['first_name']);
		$lastName = mysqli_real_escape_string($dbconnect, $_POST['last_name']);
		//$tele = mysqli_real_escape_string($dbconnect, $_POST['telephone']);
		$contact = mysqli_real_escape_string($dbconnect, $_POST['contact']);
		$streetName = mysqli_real_escape_string($dbconnect, $_POST['street_name']);
		$postcode = mysqli_real_escape_string($dbconnect, $_POST['postcode']);
		$city = mysqli_real_escape_string($dbconnect, $_POST['city']);
		$state = mysqli_real_escape_string($dbconnect, $_POST['state']);
		$country = mysqli_real_escape_string($dbconnect, $_POST['country']);
		$delivery = mysqli_real_escape_string($dbconnect, $_POST['delivery']);
		$pre_time = mysqli_real_escape_string($dbconnect, $_POST['preferance_time']);
		$total_handling = mysqli_real_escape_string($dbconnect, $_POST['total_handling']);
		$total_amount = mysqli_real_escape_string($dbconnect, $_POST['total_amount']);
		$total_point = 0;
		
		if($firstName == "" || $lastName == "" || $streetName == "" || $postcode == "" || $city == "" || $state == "" || $country == "" || $delivery == ""){
			header("location:proceed_checkout.php?order=empty&hyperlink=orders");
		}else{

			$order = mysqli_query($dbconnect, "SELECT MAX(order_id)AS ord_id FROM pbmart_order");
			$order_get = @mysqli_fetch_assoc($order);
			$ord_id = $order_get['ord_id'];
			
			$order2 = mysql_query("SELECT order_id, order_number FROM pbmart_order WHERE order_id = '$ord_id'");
			$order_get2 = @mysql_fetch_assoc($order2);
			$ord_num2 = $order_get2['order_number'];
			
			$order_num = "";
			
			if($ord_num2 == ""){
				$ord_num2 = "OR000000";
			}else{
				$orders_number = explode("OR", $ord_num2);
				$f_orders_num = $orders_number[1] + 1;
				$order_num = 'OR'.str_pad($f_orders_num, 6, '0', STR_PAD_LEFT);

				//check for order number existing
				$order3 = mysql_query("SELECT order_number FROM pbmart_order WHERE order_number = '$order_num'");
				$order_count = @mysql_num_rows($order3);
				if($order_count !='0'){
					exit;
				}
			}
			
			/*if($order_count){
				$order_count = $order_count[0];
				if($order_count < 10){
					$order_num = "OR00000".$order_count;
				}else if($order_count >= 10 && $order_count < 100){
					$order_num = "OR0000".$order_count;
				}else if($order_count >= 100 && $order_count < 1000){
					$order_num = "OR000".$order_count;
				}else if($order_count >= 1000 && $order_count < 10000){
					$order_num = "OR00".$order_count;
				}
				
			}else{
				$order_num = "OR000001";
			}
			
			if($tele == ""){
				$tele = "-";
			}else{
				$tele = $tele;
			}*/
				
			if($contact == ""){
				$contact = "-";
			}else{
				$contact = $contact;
			}
			
			$date = date("Y-m-d");

			date_default_timezone_set("Asia/Kuala_Lumpur");	// Malaysia timezone
			$order_time = date("H:i A", time());	// A = am and pm
			
			$name = $firstName." ".$lastName;
			$address = $streetName.", ".$postcode." ".$city.", ".$state.", ".$country;
			
			$create_order = mysqli_query($dbconnect, "INSERT INTO pbmart_order(order_number, order_amount, order_handling, order_date, order_delivery, order_time, order_time_date, order_customer_id, order_customer_name, order_customer_contact, order_customer_address, order_payment_type, order_payment_status, order_status) VALUES ('$order_num', '$total_amount', '$total_handling', '$date', '$delivery', '$pre_time', '$order_time', '$id', '$name', '$contact', '$address', 'Cash', '0', '0')");
			
			$cart = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin_cart");
			
			$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$id'");
			$member_display = mysqli_fetch_assoc($member);
			
			while($cart_display = mysqli_fetch_array($cart)){
				$pro_id = $cart_display['cart_product_id'];
				$pro_sale = $cart_display['cart_product_sale'];
				$pro_amount = $cart_display['cart_product_amount'];
				
				if($cart_display['cart_product_class'] == "Product"){
					$pro_name = $cart_display['cart_product_name'];
					$pro_price = $cart_display['cart_product_price'];
					$pro_handling = $cart_display['cart_handling'];
					
					$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$pro_id'");
					$pro_display = mysqli_fetch_assoc($product);
					
					$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='$id'");
					$commercial_display = mysqli_fetch_assoc($commercial);
					
					if($member_display['member_commercial_status'] == 1){
						if($member_display['member_commercial_class'] == 1){
							if($pro_display['product_commercial_double_point'] == 1){
								$pro_point = ($pro_display['product_commercial_point'] + $commercial_display['commercial_additional_point']) * 2;
							}else{
								$pro_point = $pro_display['product_commercial_point'] + $commercial_display['commercial_additional_point'];
							}
						}else if($member_display['member_commercial_class'] == 2){
							if($pro_display['product_commercial_double_point2'] == 1){
								$pro_point = ($pro_display['product_commercial_point2'] + $commercial_display['commercial_additional_point']) * 2;
							}else{
								$pro_point = $pro_display['product_commercial_point2'] + $commercial_display['commercial_additional_point'];
							}	
						}
					}else{
						if($pro_display['product_double_point'] == 1){
							$pro_point = $pro_display['product_point'] * 2;
						}else{
							$pro_point = $pro_display['product_point'];
						}
					}
				
					$create_order_list = mysqli_query($dbconnect, "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_class, order_product_name, order_product_model, order_product_price, order_product_handling, order_product_point, order_product_sale, order_product_amount) VALUES ('$order_num', '$pro_id', 'Product', '$pro_name', '".$pro_display['product_model']."', '$pro_price', '$pro_handling', '$pro_point', '$pro_sale', '$pro_amount')");
					$total_point = $total_point + ($pro_point * $pro_amount);
				
				}else if($cart_display['cart_product_class'] == "Promotion"){
					$promotion = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_id='$pro_id'");
					$promotion_display = mysqli_fetch_assoc($promotion);
					
					$pro_name = $promotion_display['promotion_product_name'];
					$pro_model = $promotion_display['promotion_product_model'];
					
					if($promotion_display['promotion_package_double_point'] == 1){
						$pro_point = $promotion_display['promotion_package_point'] * 2;
					}else{
						$pro_point = $promotion_display['promotion_package_point'];
					}
					
					if($pro_name == "MYGAZ LPG 14KG (REFILL)"){
						if($pro_model == "Home Delivery"){
							$pro_price = "26.60";
							$pro_handling = "3.40";
						}else{
							$pro_price = "26.60";
							$pro_handling = "0";
						}
					}else{
						$pro_price = $promotion_display['promotion_product_sale'];
						$pro_handling = "0";
					}
					
					$create_order_list = mysqli_query($dbconnect, "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_class, order_product_name, order_product_model, order_product_price, order_product_handling, order_product_point, order_product_sale, order_product_amount) VALUES ('$order_num', '$pro_id', 'Promotion', '$pro_name', '$pro_model', '$pro_price', '$pro_handling', '$pro_point', '$pro_sale', '$pro_amount')");
					
					$create_order_list = mysqli_query($dbconnect, "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_class, order_product_name, order_product_model, order_product_price, order_product_handling, order_product_point, order_product_sale, order_product_amount) VALUES ('$order_num', '$pro_id', 'Promotion', '".$promotion_display['promotion_item_name']."', '".$promotion_display['promotion_item_model']."', '".$promotion_display['promotion_item_sale']."', '0', '0', '0', '$pro_amount')");
					$total_point = $total_point + ($pro_point * $pro_amount);
				}
			}
			
			$update_point = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_total_point='$total_point' WHERE order_number='$order_num'");
			
			if($create_order && $create_order_list && $update_point){
				$clear_cart = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_admin_cart");
				header("location:make_order.php?order=true&hyperlink=orders");
			}else{
				header("location:proceed_checkout.php?order=false&hyperlink=orders");
			}
		}
	}
?>