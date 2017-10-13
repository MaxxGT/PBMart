<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
		
	if(isset($_POST['order_cancel'])){
		if(!isset($_POST['orderList'])){
			header("location:view_order.php?del=empty&hyperlink=orders");
		}else{
			$del_order = $_POST['orderList'];
			$count = count($del_order);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_order[$i];
				
				if($id > 0){
					$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_id='$id'");
					$order_display = mysqli_fetch_assoc($order);
					
					$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."'");
					
					while($order_list_display = mysqli_fetch_array($order_list)){
						$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_list_display['order_product_id']."'");
						$product_amount = mysqli_fetch_assoc($product);
						$amount = $product_amount['product_stock'] + $order_list_display['order_product_amount'];

						$add_back = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$amount' WHERE product_id='".$order_list_display['order_product_id']."'");
					}
					
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
						
						$point =  floor($order_display['order_amount'] / $point_rate);
						$point = $member_display['member_point'] - $point;
						
						mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$point' WHERE member_id='".$order_display['order_customer_id']."'");
					}
					
					$delete_order = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_status='2' WHERE order_id='".$order_display['order_id']."'");
				}
			}
			
			if($delete_order){
				header("location:view_order.php?del=true&hyperlink=orders");
			}else{
				header("location:view_order.php?del=false&hyperlink=orders");
			}
		}
	}
	
	if(isset($_POST['order_deleteAll'])){
		$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_status='0'");

		if(($order_rows = mysqli_num_rows($order)) == 0){
			header("location:view_order.php?del=empty&hyperlink=orders");
		}else{
			while($order_display = mysqli_fetch_array($order)){
				$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."'");
				
				while($order_list_display = mysqli_fetch_array($order_list)){
					$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_list_display['order_product_id']."'");
					$product_display = mysqli_fetch_assoc($product);
					$amount = $product_display['product_stock'] + $order_list_display['order_product_amount'];
					
					mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$amount' WHERE product_id='".$order_list_display['order_product_id']."'");
				}
				
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
		
			$delete_order = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_status='2' WHERE order_status='0'");

			if($delete_order){
				header("location:view_order.php?del=true&hyperlink=orders");
			}else{
				header("location:view_order.php?del=false&hyperlink=orders");
			}
		}
	}
	
	if(isset($_POST['complete_orders'])){
		if(!isset($_POST['orderList'])){
			header("location:view_order.php?com=oempty");
		}else{
			$comp_order = $_POST['orderList'];
			$count = count($comp_order);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$comp_order[$i];
				
				if($id > 0){
					$points = 0;
					
					$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_id='$id'");
					$order_display = mysqli_fetch_assoc($order);
					
					$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."'");
					
					$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
					$member_display = mysqli_fetch_assoc($member);
					
					$points = $order_display['order_total_point'] + $member_display['member_point'];
					
					if($order_display['order_payment_status'] == 0){
						$add_point = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$points' WHERE member_id='".$order_display['order_customer_id']."'");
					}	
						
					$complete = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_payment_status='1', order_status='1' WHERE order_number='".$order_display['order_number']."'");
					
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
				}
			}
			
			if($complete){
				header("location:view_order.php?com=true");
			}else{
				header("location:view_order.php?com=false");
			}
		}
	}

	if(isset($_POST['order_delete'])){
		if(!isset($_POST['orderList'])){
			header("location:view_order.php?del=empty&hyperlink=orders");
		}else{
			$del_order = $_POST['orderList'];
			$count = count($del_order);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_order[$i];
				
				if($id > 0){
					$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_id='$id'");
					$order_display = mysqli_fetch_assoc($order);
					
					$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."'");
					
					while($order_list_display = mysqli_fetch_array($order_list)){
						$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_list_display['order_product_id']."'");
						$product_amount = mysqli_fetch_assoc($product);
						$amount = $product_amount['product_stock'] + $order_list_display['order_product_amount'];

						$add_back = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_stock='$amount' WHERE product_id='".$order_list_display['order_product_id']."'");
					}
					
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
						
						$point =  floor($order_display['order_amount'] / $point_rate);
						$point = $member_display['member_point'] - $point;
						
						mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point='$point' WHERE member_id='".$order_display['order_customer_id']."'");
					}
					
					$delete_order = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_status='2' WHERE order_id='".$order_display['order_id']."'");
				}
			}
			
			if($delete_order){
				header("location:view_order.php?del=true&hyperlink=orders");
			}else{
				header("location:view_order.php?del=false&hyperlink=orders");
			}
		}
	}
	
	?>