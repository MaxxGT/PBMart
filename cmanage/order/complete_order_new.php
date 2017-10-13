<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$points = 0;
	
	$order_num = mysqli_real_escape_string($dbconnect, $_GET['or']);
	
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_number='$order_num'");
	$order_display = mysqli_fetch_assoc($order);
	
	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_num'");
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
	$member_display = mysqli_fetch_assoc($member);
	
	$points = $order_display['order_total_point'] + $member_display['member_point'];
	
	if($order_display['order_payment_status'] == 0){
		$add_point = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$points' WHERE member_id='".$order_display['order_customer_id']."'");
	}	
		
	$complete = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_payment_status='1', order_status='1' WHERE order_number='$order_num'");
	
	if($complete){
		while($add_sale = mysqli_fetch_array($order_list)){
			$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$add_sale['order_product_id']."'");
			$product_sale = mysqli_fetch_assoc($product);
			$amount = $product_sale['product_sale'] + $add_sale['order_product_amount'];
			
			mysqli_query($dbconnect, "UPDATE pbmart_product SET product_sale='$amount' WHERE product_id='".$add_sale['order_product_id']."'");
		}
	}
	
	if($member_display['member_introducer_status'] == 0){
		if($member_display['member_introducer'] != ""){
			$token = $member_display['member_token'] + 1;
			
			mysqli_query($dbconnect, "UPDATE pbmart_member SET member_token='$token', member_introducer_status='1' WHERE member_id='".$member_display['member_id']."'");
		}
	}
	
	header("location:view_order.php?hyperlink=orders");
?>