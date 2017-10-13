<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$mem_id = mysqli_real_escape_string($dbconnect, $_POST['mem_id']);
	$item_qty = mysqli_real_escape_string($dbconnect, $_POST['quantity']);
	$choice = mysqli_real_escape_string($dbconnect, $_POST['choice']);
	$item_id = mysqli_real_escape_string($dbconnect, $_GET['it']);
	$delivery_date = mysqli_real_escape_string($dbconnect, $_POST['deliv_date']);
	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='$item_id'");
	$item_display = mysqli_fetch_assoc($item);
	$date = date('Y-m-d');
	$redeem_time = date("H:i A", time());	// A = am and pm
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
	$member_display = mysqli_fetch_assoc($member);
	
	if(($choice == "point" && $member_display['member_point'] < $item_display['redeem_point']) || ($choice == "token" && $member_display['member_token'] < $item_display['redeem_token'])){
		header("location:redemption.php?it=$item_id&mem=$mem_id&re=empty&hyperlink=redemption");
	}else{
		$name = $member_display['member_first_name']." ".$member_display['member_last_name'];
		$address = $member_display['member_street_name'].", ".$member_display['member_postcode']." ".$member_display['member_city'].", ".$member_display['member_state'].", ".$member_display['member_country'];
		
		$redemption = mysqli_query($dbconnect, "SELECT MAX(redemption_id) FROM pbmart_redemption_list");
		$redemption_count = mysqli_fetch_row($redemption);
		
		if($redemption_count){
			$redemption_count = $redemption_count[0];
			$redeem_no = "RE0000".$redemption_count;			
		}else{
			$redeem_no = "RE00001";
		}
		
		$amount = $item_display['redeem_stock'] - $item_qty;
		$total_points = $item_display['redeem_point'] * $item_qty;
		
		$redeem = mysqli_query($dbconnect, "UPDATE pbmart_redeem SET redeem_stock='$amount' WHERE redeem_id='$item_id'");
		
		if($choice == "point"){
			$total = $item_display['redeem_point'];
			$point = $member_display['member_point'] - $total;
			$token = $member_display['member_token'];
			$total_points = $total;
			$total_token = 0;
		}else if($choice == "token"){
			$total = $item_display['redeem_token'] * $item_qty;
			$token = $member_display['member_token'] - $total;
			$point = $member_display['member_point'];
			$total_points = 0;
			$total_token = $total;
		}
		
		$redeem_list = mysqli_query($dbconnect, "INSERT INTO pbmart_redemption_list(redemption_number, redemption_date, redemption_time, redemption_delivery_date, redemption_member_id, redemption_member_name, redemption_member_address, redemption_item_id, redemption_item, redemption_amount, redemption_points, redemption_token,  redemption_status) VALUES ('$redeem_no', '$date', '$redeem_time', '$delivery_date', '$mem_id', '$name', '$address', '$item_id', '".$item_display['redeem_name']."', '$item_qty', '$total_points', '$total_token', '0')");
		
		$deduct_point = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$point', member_token='$token' WHERE member_id='$mem_id'");
		
		if($redeem_list && $redeem && $deduct_point){
			header("location:redeem.php?redeem=true&hyperlink=redemption");
		}else{
			header("location:redeem.php?redeem=false&hyperlink=redemption");
		}
	}
?>