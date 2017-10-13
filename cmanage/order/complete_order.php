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
	
	while($ol_display = mysqli_fetch_array($order_list)){
		$pro = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$ol_display['order_product_id']."'");
		$pro_dis = mysqli_fetch_assoc($pro);
			
		/*if($member_display['member_commercial_status'] == 0){
			if($pro_dis['product_double_point'] == 1){
				$double = 3;
			}else{
				$double = 1;
			}
		}else if($member_display['member_commercial_status'] == 1){
			if($pro_dis['product_commercial_double_point'] == 1){
				$double = 3;
			}else{
				$double = 1;
			}
		}else if($member_display['member_commercial_status'] == 2){
			if($pro_dis['product_commercial_double_point'] == 1){
				$double = 3;
			}else{
				$double = 1;
			}
		}*/
		$points = $points + ($ol_display['order_product_point'] * $ol_display['order_product_amount']);// * $double);
	}
	
	/*$points = mysqli_query($dbconnect, "SELECT * FROM pbmart_point");
	$point_display = mysqli_fetch_assoc($points);
	
	if($order_display['order_time'] == 1){
		$point_rate = $point_display['point_rate2'];
	}else if($order_display['order_time'] == 2){
		$point_rate = $point_display['point_rate1'];
	}else if($order_display['order_time'] == 3){
		$point_rate = $point_display['point_rate3'];
	}
	
	$point =  $order_display['order_amount'] * $point_rate;*/
	$total_points = $points;
	$points = $points + $member_display['member_point'];
	
	if($order_display['order_payment_status'] == 0){
		$add_point = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$points' WHERE member_id='".$order_display['order_customer_id']."'");
	}	
		
	$complete = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_payment_status='1', order_status='1', order_total_point='$total_points' WHERE order_number='$order_num'");
	
	if($complete){
		$order_list1 = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."'");
		
		while($add_sale = mysqli_fetch_array($order_list1)){
			$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$add_sale['order_product_id']."'");
			$product_sale = mysqli_fetch_assoc($product);
			$amount = $product_sale['product_sale'] + $add_sale['order_product_amount'];
			
			mysqli_query($dbconnect, "UPDATE pbmart_product SET product_sale='$amount' WHERE product_id='".$add_sale['order_product_id']."'");
		}
	}
	
	if($member_display['member_introducer_status'] == 0){
		if($member_display['member_introducer'] != ""){
			$member_retrieve = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_number='".$member_display['member_introducer']."'");
			$mem_tok = mysqli_fetch_assoc($member_retrieve);
			
			$token = $mem_tok['member_token'] + 1;
			
			mysqli_query($dbconnect, "UPDATE pbmart_member SET member_token='$token' WHERE member_id='".$mem_tok['member_id']."'");
			mysqli_query($dbconnect, "UPDATE pbmart_member SET member_introducer_status='1' WHERE member_id='".$member_display['member_id']."'");
		}
	}
	
	header("location:view_order.php?hyperlink=orders");
?>