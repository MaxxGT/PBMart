<?php
//place to store all the function of checkout

//CHECKING DATE VALIDATION
function date_validate($shipping_date){
	if($shipping_date < get_currentDateTime()){
		echo ('ship_date: '.$shipping_date.' < '.get_currentDateTime()); exit;
		$message = "Warning! Shipping Date not match! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}else if($shipping_date =='2016-02-07'){
		$message = "Date 07-02-2016 is invalid, please try another Shipping Date. Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}else if($shipping_date =='2016-02-08'){
		$message = "Date 08-02-2016 is invalid, please try another Shipping Date. Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}else if($shipping_date =='2016-02-09'){
		$message = "Date 09-02-2016 is invalid, please try another Shipping Date. Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;}
}

//a function use to get current time and date base on the selected timezone set
function get_currentDateTime()
{
	date_default_timezone_set('Asia/Kuching'); // CDT

	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$month = $info['mon'];
	$year = $info['year'];
	$hour = $info['hours'];
	$min = $info['minutes'];
	$sec = $info['seconds'];

	$crt_date->setDate($year, $month, $date);
	
	$current_date = $crt_date->format('Y-m-d');
	return $current_date;
}

function get_currentTime()
{
	date_default_timezone_set('Asia/Kuching'); // CDT

	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$month = $info['mon'];
	$year = $info['year'];
	$hour = $info['hours'];
	$min = $info['minutes'];
	$sec = $info['seconds'];

	$Time = $hour.':'.$min.':'.$sec;
	$newTime = date('H:i:s', strtotime($Time));
	return $newTime;
}

//a function use to delete the orders for product or promotion order
function ord_del($odr_num, $order_cst_id)
{
	$sql_del_pbmartOrder = "DELETE FROM pbmart_order WHERE order_number='$odr_num' AND order_customer_id='$order_cst_id'";
	$del_result = @mysql_query($sql_del_pbmartOrder);
	if($del_result)
	{
		$sql_del_pbmartOrderList = "DELETE FROM pbmart_order_list WHERE order_number = '$odr_num'";
		$del_result2 = @mysql_query($sql_del_pbmartOrderList);
		if(!$del_result2)
		{
			echo $sql_del_pbmartOrderList;
			echo ("Failed to delete pbmart_order_list record");
		}
	}else
	{
		echo $sql_del_pbmartOrder;
		echo ("Failed to delete pbmart_order record");
	}
}

function rdm_ord_del($rdm_num, $rdm_odr_ref)
{
	$sql_del_pbmartRdmList = "DELETE FROM pbmart_redemption_list WHERE redemption_number='$rdm_num' AND redemption_order_ref = '$rdm_odr_ref'";
	$rdm_del_result = @mysql_query($sql_del_pbmartRdmList);
	if(!$rdm_del_result)
	{
		echo $sql_del_pbmartRdmList;
		echo ("Failed to delete pbmart_redemption_list record");
	}
}

function get_rdm_stock($rdm_id)
{
	$query_rdm_stock = "SELECT redeem_id, redeem_stock FROM pbmart_redeem WHERE redeem_id = '$rdm_id'";
	$rs_rdm_stock = @mysql_query($query_rdm_stock);
	$rw_rdm_stock = @mysql_fetch_array($rs_rdm_stock);
	return $rw_rdm_stock['redeem_stock'];
}

function pkg_validations($pkg_id)
{
	$query_pkg_stock = "SELECT promotion_id, promotion_package_stock FROM pbmart_promotion WHERE promotion_id = '$pkg_id'";
	$rs_pkg_stock = @mysql_query($query_pkg_stock);
	$rw_pkg_stock = @mysql_fetch_array($rs_pkg_stock);
	return $rw_pkg_stock['promotion_package_stock'];
}

function prd_validations($product_id)
{
	$query_stk_stock = "SELECT product_id, product_stock FROM pbmart_product WHERE product_id = '$product_id'";
	$rs_stk_stock = @mysql_query($query_stk_stock);
	$rw_stk_stock = @mysql_fetch_array($rs_stk_stock);
	return $rw_stk_stock['product_stock'];
}

function cal_prd_sales($prd_price, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
{
	if($prd_qty >= '1' && $prd_qty < $prd_sales1)
	{
		$prd_sales_percentage = '0';
	}else if($prd_qty >= $prd_sales1 && $prd_qty < $prd_sales2)
	{
		$prd_sales_percentage = $prd_sales_percentage1;
	}else if($prd_qty >= $prd_sales2 && $prd_qty < $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage2;
	}else if($prd_qty >= $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage3;
	}else
	{
		echo ('Internal Error! Please contact webmaster to fix the issue!');
		exit;
	}

	$tl_price = $prd_price * $prd_qty;
	$discount = ($tl_price * $prd_sales_percentage)/100;
	//return $tl_price - $discount;
	return $prd_sales_percentage;
}

function cvrt_paymentType($payment_type)
{
	if($payment_type == 0)
	{
		$PaymentType = "Cash";
	}
	
	if($payment_type == 2)
	{
		$PaymentType = "Credit Card";
	}
	return $PaymentType;
}

//a function use to delete invalid orders made by users
function order_validate($odr_customer_id)
{
	$sql_order = "Select * FROM pbmart_order WHERE order_customer_id='$odr_customer_id' AND ePaymentStatus='1'";
	$rs_order = @mysql_query($sql_order);
	while($rw_order = @mysql_fetch_array($rs_order))
	{
		$order_nums = $rw_order['order_number'];
		$query2 ="DELETE FROM pbmart_order WHERE order_number='$order_nums' AND order_customer_id='$odr_customer_id' AND ePaymentStatus='1'";
		$result_delete = @mysql_query($query2);

		if(!$result_delete)
		{
			echo ("Failed to delete table. DEBUG: .$query2");
		}
		
		$query3 = "DELETE FROM pbmart_order_list WHERE order_number='$order_nums'";
		$result_delete2 = @mysql_query($query3);
		
		if(!$result_delete2)
		{
			echo ("Failed to delete table. DEBUG: .$query3");
		}
	}
}

function valid_point($point)
{
	if($point < 0)
	{
		$message = "Error! Please try again later! Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
}

?>