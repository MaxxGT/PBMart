<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$order_num = mysqli_real_escape_string($dbconnect, $_POST['id']);
	$order_dev = mysqli_real_escape_string($dbconnect, $_POST['new_date']);
	$order_customer_address = $_POST['order_customer_address'];
	$order_remark = $_POST['order_remark'];
		
	
	if(isset($_POST['edit_order'])){
		$order_amount = $_POST['order_amount'];
		$order_product_id = $_POST['order_product_id'];
		$order_mygaz_amount = $_POST['order_mygaz_amount'];
		$order_petronas_amount = $_POST['order_petronas_amount'];
		$order_number = $_POST['order_id'];
		$count = count($order_number);
		$total_price = 0;
		$total_handling = 0;
		$total_point = 0;
		
		for($i = 0; $i < $count; $i++){
			$order_amount_pro = (int)$order_amount[$i];
			$order_product_id = (int)$order_product_id[$i];
			//$order_mygaz_amount_pro = (int)$order_mygaz_amount[$i];
			//$order_petronas_amount_pro = (int)$order_petronas_amount[$i];
			$order_id = (int)$order_number[$i];
			
			$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_number='$order_num'");
			$order_cust = mysqli_fetch_assoc($order);
			
			$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_cust['order_customer_id']."'");
			$member_com = mysqli_fetch_assoc($member);
			
			$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_id='$order_id' AND order_number='$order_num'");
			$order_item = mysqli_fetch_assoc($order_list);
			
			$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_item['order_product_id']."'");
			$product_info = mysqli_fetch_assoc($product);
			
			
			
			if($member_com['member_commercial_status'] == '1'){
				$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='".$order_cust['order_customer_id']."'");
				$commercial_ex_point = mysqli_fetch_assoc($commercial);
				
				if($member_com['member_commercial_class'] == '1'){
					if($product_info['product_commercial_double_point2'] == '1'){
						$point = (($product_info['product_commercial_point'] + $commercial_ex_point['commercial_additional_point']) * $order_amount_pro) * 3;
					}else{
						if($order_mygaz_amount =='0' && $order_petronas_amount =='0')
						{
							//$point = ($product_info['product_commercial_point'] + $commercial_ex_point['commercial_additional_point']) * $order_amount_pro;
							$point = '0';
						}else
						{
							$point = ($product_info['product_commercial_point'] * $order_mygaz_amount) + ($product_info['product_commercial_point_ptrs'] * $order_petronas_amount) + $commercial_ex_point['commercial_additional_point'];	
						}
						$product_point = $product_info['product_commercial_point'];
					}
					$total_price = $total_price + (($product_info['product_commercial_price'] + $product_info['product_commercial_handling']) * $order_amount_pro);
					$total_handling = $total_handling + ($product_info['product_commercial_handling'] * $order_amount_pro);
				}else if($member_com['member_commercial_class'] == '2'){
					if($product_info['product_commercial_double_point'] == '1'){
						$point = (($product_info['product_commercial_point2'] + $commercial_ex_point['commercial_additional_point']) * $order_amount_pro) * 3;
					}else{
						if($order_mygaz_amount =='0' && $order_petronas_amount =='0')
						{
							//$point = ($product_info['product_commercial_point2'] + $commercial_ex_point['commercial_additional_point']) * $order_amount_pro;
							$point = '0';
						}else
						{
							$point = ($product_info['product_commercial_point2'] * $order_mygaz_amount) + ($product_info['product_commercial_point2_ptrs'] * $order_petronas_amount) + $commercial_ex_point['commercial_additional_point'];
						}
						$product_point = $product_info['product_commercial_point2'];
					}
					
					$total_price = $total_price + (($product_info['product_commercial_price2'] + $product_info['product_commercial_handling2']) * $order_amount_pro);
					$total_handling = $total_handling + ($product_info['product_commercial_handling2'] * $order_amount_pro);
				}
			}else{
				if($product_info['product_double_point'] == '1'){
					$point = ($product_info['product_point'] * $order_amount_pro) * 3;
				}else{
					if($order_mygaz_amount =='0' && $order_petronas_amount == '0')
					{
						$point = $product_info['product_point'] * $order_amount_pro;
					}else
					{	
						if($order_product_id =='1')
						{
							$point = (($product_info['product_point'] * $order_mygaz_amount) + ($product_info['product_point_ptrs'] * $order_petronas_amount));
						}else
						{
							$point = $product_info['product_point'] * $order_amount_pro;
						}
					}
				}
				$product_point = $product_info['product_point'];
				$total_price = $total_price + (($product_info['product_price'] + $product_info['product_handling']) * $order_amount_pro);
				$total_handling = $total_handling + ($product_info['product_handling'] * $order_amount_pro);
			}
			
			$total_point = $total_point + $point;
			$update_list = mysqli_query($dbconnect, "UPDATE pbmart_order_list SET order_product_point='$product_point', order_product_amount='$order_amount_pro' WHERE order_id='".$order_item['order_id']."'");
		}
		
		//echo $order_petronas_amount_pro;
		//exit;
		$update = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_customer_address='$order_customer_address', order_remark='$order_remark', order_amount='$total_price', order_handling='$total_handling', order_delivery='$order_dev', order_total_point='$total_point', order_mygaz_amount='$order_mygaz_amount', order_petronas_amount='$order_petronas_amount' WHERE order_number='$order_num'");
	}else{
		$update = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_customer_address='$order_customer_address', order_remark='$order_remark', order_delivery='$order_dev' WHERE order_number='$order_num'");
	}
	
	if($update){
		header("location:view_order.php?hyperlink=orders");
	}else{
	
	}
?>