<?php
include('session_config.php');
require_once("connection/pbmartconnection.php");

$merchantcode = $_REQUEST["MerchantCode"];
$paymentid = $_REQUEST["PaymentId"];
$refno = $_REQUEST["RefNo"];
$order_num = $refno;

$amount = $_REQUEST["Amount"];
$ecurrency = $_REQUEST["Currency"];
$remark = $_REQUEST["Remark"];
$transid = $_REQUEST["TransId"];
$authcode = $_REQUEST["AuthCode"];

$estatus = $_REQUEST["Status"];


//echo 'errdesc: '.$errdesc = $_REQUEST["ErrDesc"].'<br/>';
//echo 'signature: '.$signature = $_REQUEST["Signature"].'<br/>';
//echo ('test2');

if($estatus == "1")
{
	get_UsrInfo();
//COMPARE Return Signature with Generated Response Signature
// update order to PAID

	//gather payment information
	$sql_order = "Select * FROM pbmart_order WHERE order_number='$refno'";
	$rw_order = @mysql_query($sql_order);
	$rs_order = @mysql_fetch_array($rw_order);
	
	if($rs_order['order_time']=='1')
	{
		$shp_time = 'Afternoon (12:00pm to 4:00pm)';
	}else if($rs_order['order_time']=='2')
	{
		$shp_time = 'Morning (8:00am to 12:00pm)';
	}else if($rs_order['order_time']=='3')
	{
		$shp_time = 'Immediatly';
	}

	$shp_date = $rs_order['order_delivery'];
	$order_payment_type = $rs_order['order_payment_type'];									
	$street_name = $member_street_name;
	$city = $member_city;
	$region_state = $member_state;
	$country = $member_country;
	$pst_code = $member_postcode;

	//update pbmart_order
	$query_update = "UPDATE pbmart_order
	SET
		ePaymentStatus='2'
		WHERE order_number='$refno'";
	$update_result = @mysql_query($query_update);
	if($update_result)
	{
		//get all the product quantity and id
		$sql = "Select * FROM pbmart_order_list WHERE order_number ='$refno'";
		$rs = @mysql_query($sql);
		while($rw = @mysql_fetch_array($rs))
		{
			$order_product_id = $rw['order_product_id'];
			$order_product_amount = $rw['order_product_amount'];
			
			//get the product qty from pbmart_product
			$sql_product = "Select * FROM pbmart_product WHERE product_id = '$order_product_id'";
			$rs_product = @mysql_query($sql_product);
			$rw_product = @mysql_fetch_array($rs_product);
			$product_sale = $rw_product['product_sale'];
			$product_stock = $rw_product['product_stock'];
			
			//update product stock
			
			$prd_sale = $product_sale + $order_product_amount;
			$prd_stock = $product_stock - $order_product_amount;
			
			$query_upd = "UPDATE pbmart_product
			SET
				product_sale='$prd_sale',
				product_stock='$prd_stock'
				WHERE product_id='$order_product_id'";
				$upd_result = @mysql_query($query_upd);
				
				if(!$upd_result)
				{
					echo ("Failed to update table. DEBUG: .$query_upd");
				}
		}
		
		if($upd_result)
		{
			echo "<script type='text/javascript'>alert('Thanks for your orders! An Order Confirmation email has been send to your mail! Please check your mail thanks!');</script>";
			echo "<script>window.top.location ='PHPMailer-master/send_mail_placeOrder.php?order_num=$refno&shp_time=$shp_time&shp_date=$shp_date&order_payment_type=$order_payment_type&street_name=$street_name&city=$city&region_state=$region_state&country=$country&member_postcode=$pst_code';</script>";
		}
	}else
	{
		echo ("Failed to update table. DEBUG: .$query_update");
	}
}else
{	
	//$query_upds = "UPDATE pbmart_order
	//SET
	//	order_status = '2'
	//	WHERE order_number ='$refno'";
	//$upd_results = @mysql_query($query_upds);
	
	//if($upd_results)
	//{
	//	header('Location: checkout_page.php');
	//}else
	//{
	//	echo ("Failed to update table. DEBUG: .$query_upds");
	//}
	
	//delete pbmart_order
	$query2 ="DELETE FROM pbmart_order WHERE order_number='$refno'";
	$result2 = @mysql_query($query2);

	if($result2)
	{
		//delete pbmart_order_list
		$query3 = "DELETE FROM pbmart_order_list WHERE order_number='$refno'";
		$result3 = @mysql_query($query3);
		if($query3)
		{
			header('Location: checkout_page.php');
		}else
		{
			echo ("Failed to delete table. DEBUG: .$query3");
		}
	}else{
		echo ("Failed to delete table. DEBUG: .$query2");
	}
}
?>