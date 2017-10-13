<?php
// Author: VOONG TZE HOWE
// Date Writen: 05-11-2014
// Description : order action page use to manage order
// Last Modification: 15-11-2014

require_once("connection/pbmartconnection.php");
if(isset($_POST['btnCancelOrder']))
{
	$act = $_POST['btnCancelOrder'];
}
if(isset($_POST['order_number']))
{
	$order_number = $_POST['order_number'];
}

if($act == "cancel_order")
{
	$query="UPDATE pbmart_order
				SET
     	            order_status = '2'
					WHERE order_number = '$order_number'";
	$result = @mysql_query($query);
	
	if(!$result)
	{
		echo ("Failed to update table. DEBUG: .$query");
	}
	
	$sql = "Select * FROM pbmart_order_list WHERE order_number='$order_number'";
	$rs = @mysql_query($sql, $link);
	while($rw = @mysql_fetch_array($rs))
	{
		$order_product_name = $rw['order_product_name'];
		$order_product_price = $rw['order_product_price'];
		$order_product_sale = $rw['order_product_sale'];
		$order_product_amount = $rw['order_product_amount'];
		//echo ('order_product_amount: '.$order_product_amount);
		
		$sql_product = "Select * FROM pbmart_product WHERE product_name='$order_product_name' AND 
									  product_price='$order_product_price' AND
									  product_sale_percentage='$order_product_sale'";
									  
		$rs_product = @mysql_query($sql_product, $link);
		$rw_product = @mysql_fetch_array($rs_product);
		$product_stock = $rw_product['product_stock'];
	//	echo ('product_stock: '.$product_stock);
		$updated_stock = $product_stock + $order_product_amount; 
		
		$query_update = "UPDATE pbmart_product
							SET
								product_stock='$updated_stock'
								WHERE product_name='$order_product_name' AND 
									  product_price='$order_product_price' AND
									  product_sale_percentage='$order_product_sale'";
									  
		$result2 = @mysql_query($query_update);
		if(!$result2)
		{
			echo ("Failed to update table. DEBUG: .$query_update");
		}
	}
	
	if($result)
	{
		if($result2)
		{
			echo "<script type='text/javascript'>alert('Thanks! Your orders has been successfully canceled! You are Welcome!');</script>";
			echo "<script>window.top.location ='order.php?hyperlink=product&del=true';</script>";
		}
	}
}
?>