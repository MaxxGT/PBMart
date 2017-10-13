<?php
include("connection/pbmartconnection.php");

$url = "SELECT pbmart_order.order_number, pbmart_order.order_customer_id, pbmart_order_list.order_product_amount, pbmart_order.order_total_point, pbmart_order.order_status FROM pbmart_order 
INNER JOIN pbmart_order_list ON
pbmart_order.order_number = pbmart_order_list.order_number
WHERE pbmart_order.order_customer_id='438' AND pbmart_order.order_status='1'";

$result = @mysql_query($url);
while($row = @mysql_fetch_array($result)) {
	$order_number = $row['order_number'];
	$url2 = "SELECT order_number FROM pbmart_order_list WHERE order_number='$order_number'";
	$result2 = @mysql_query($url2);
	if(@mysql_num_rows($result2)>1)
	{
		echo "Error";
	}
}

