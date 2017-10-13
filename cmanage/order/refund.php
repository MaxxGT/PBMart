<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$order_num = mysqli_real_escape_string($dbconnect, $_GET['or']);
	
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_number='$order_num'");
	$order_display = mysqli_fetch_assoc($order);
	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_num'");
	
	while($order_list_display = mysqli_fetch_array($order_list)){
		$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_list_display['order_product_id']."'");
		$product_display = mysqli_fetch_assoc($product);
		
		$amount = $product_display['product_stock'] + $order_list_display['order_product_amount'];
		
		mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$amount' WHERE product_id='".$order_list_display['order_product_id']."'");
	}
	
	if($order_display['order_payment_status'] == 1){
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
		$member_display = mysqli_fetch_assoc($member);
		
		$points = mysqli_query($dbconnect, "SELECT * FROM pbmart_point");
		$point_display = mysqli_fetch_assoc($points);
						
		if($order_display['order_payment_status'] == 1){
			if($order_display['order_time'] == 1){
				$point_rate = $point_display['point_rate2'];
			}else if($order_display['order_time'] == 2){
				$point_rate = $point_display['point_rate1'];
			}else if($order_display['order_time'] == 3){
				$point_rate = $point_display['point_rate3'];
			}
						
			$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
			$member_display = mysqli_fetch_assoc($member);
						
			$point = $order_display['order_amount'] * $point_rate;
			$point = $member_display['member_point'] - $point;
						
			mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$point' WHERE member_id='".$order_display['order_customer_id']."'");
		}
	}
	
	$complete = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_status='3' WHERE order_number='$order_num'");
	
	header("location:view_order.php?hyperlink=orders");
?>