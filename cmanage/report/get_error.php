<?php
require_once("../../connection/pbmartconnection.php");

$error_count = '0';
$total_flat = '0';
$total_amount = '0';
$product_qty = '0';
$sql_pbmart_order = "Select * FROM pbmart_order WHERE order_status='1'";
$rs_pbmart_order = mysqli_query($dbconnect, $sql_pbmart_order);
while($rw_pbmart_order = mysqli_fetch_array($rs_pbmart_order))
{
	$total_product_amount = '0';
	$product_gross = '0';
	$order_number = $rw_pbmart_order['order_number'];
	$order_amount = $rw_pbmart_order['order_amount'];
	$total_amount += $order_amount;
	$flat_handling = $rw_pbmart_order['flat_handling'];
	$total_flat += $flat_handling;
	$sql_pbmart_order_list = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number'";
	$rs_pbmart_order_list = mysqli_query($dbconnect, $sql_pbmart_order_list);
	while($rw_pbmart_order_list = mysqli_fetch_array($rs_pbmart_order_list))
	{							
		$order_product_price = $rw_pbmart_order_list['order_product_price'];
		$order_product_handling = $rw_pbmart_order_list['order_product_handling'];
		$order_product_amount = $rw_pbmart_order_list['order_product_amount'];
		$total_product_amount += $order_product_amount;
		$product_gross += (($order_product_price + $order_product_handling) * $order_product_amount);	
	}
		$product_qty += $total_product_amount/2;
		$product_gross += $flat_handling;
	
	if(number_format($product_gross,2) != number_format($order_amount,2))
	{
		echo $order_number.' '.$product_gross.' '.$order_amount;
		echo '<BR/>';
	}else
	{
		$error_count++;
	}
}

if($error_count !='0')
{
	echo "There are no error in your orders!";
}else
{
	echo "<BR/><BR/>Total Amount: RM <font size='25'><B><strong>".number_format($total_amount,2).'</strong></B></font>';
}
	?>