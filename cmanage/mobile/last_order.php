<?php
	require_once("pbmartconnection.php");
	session_start();
	
	$username = $_POST['username'];
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_email='$username'");
	$member_id = mysqli_fetch_assoc($member);
	
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_customer_id='".$member_id['member_id']."' ORDER BY order_number DESC LIMIT 1");
	$last_order = mysqli_fetch_assoc($order);
	
	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$last_order['order_number']."'");
	//$rs = @mysqli_fetch_array($last_order);
	
	/*$order_id = $rs['order_id'];
	$order_number = $rs['order_number'];
	$order_amount = $rs['order_amount'];
	$order_date = $rs['order_date'];
	$order_delivery = $rs['order_delivery'];
	$order_customer_id = $rs['order_customer_id'];
	$order_customer_name = $rs['order_customer_name'];
	$order_customer_telephone = $rs['order_customer_telephone'];
	$order_customer_mobile = $rs['order_customer_mobile'];
	$order_customer_address = $rs['order_customer_address'];
	$order_payment_type = $rs['order_payment_type'];
	$order_payment_status = $rs['order_payment_status'];
	$order_status = $rs['order_status'];*/
	
	while($order_display = mysqli_fetch_array($order_list)){
		echo $order_display['order_product_name'];
		echo "\n";
	}
	
	echo "order_id".' : '. $last_order['order_id']."\n";
	
	if($last_order['order_status'] == 1){
		echo "Completed";
	}else if($last_order['order_status'] == 2){
		echo "Cancelled";
	}else if($last_order['order_status'] == 3){
		echo "Refunded";
	}else if($last_order['order_status'] == 0){
		$today = date('Y-m-d');
		$tomorrow = new DateTime('tomorrow');
		$tomorrow = $tomorrow->format('Y-m-d');
		$day2 = new DateTime('tomorrow');
		$day2 = $day2->modify('+1 day');
		$day2 = $day2->format('Y-m-d');
		$day3 = new DateTime('tomorrow');
		$day3 = $day3->modify('+2 day');
		$day3 = $day3->format('Y-m-d');
		$day4 = new DateTime('tomorrow');
		$day4 = $day4->modify('+3 day');
		$day4 = $day4->format('Y-m-d');
		$day5 = new DateTime('tomorrow');
		$day5 = $day5->modify('+4 day');
		$day5 = $day5->format('Y-m-d');
		$day6 = new DateTime('tomorrow');
		$day6 = $day6->modify('+5 day');
		$day6 = $day6->format('Y-m-d');
		$day7 = new DateTime('tomorrow');
		$day7 = $day7->modify('+6 day');
		$day7 = $day7->format('Y-m-d');
		
		$todaydev = strtotime(date('Y-m-d'));
		$dev = strtotime($last_order['order_delivery']);
		
		if($todaydev > $dev){
			echo "Overdue";
		}else if($last_order['order_delivery'] == $today){
			echo "Today";
		}else if($last_order['order_delivery'] == $tomorrow){
			echo "1 day left";
		}else if($last_order['order_delivery'] == $day2){
			echo "2 days left";
		}else if($last_order['order_delivery'] == $day3){
			echo "3 days left";
		}else if($last_order['order_delivery'] == $day4){
			echo "4 days left";
		}else if($last_order['order_delivery'] == $day5){
			echo "5 days left";
		}else if($last_order['order_delivery'] == $day6){
			echo "6 days left";
		}else if($last_order['order_delivery'] == $day7){
			echo "1 week left";
		}else{
			echo "More than 1 week";
		}
	}
	
?>