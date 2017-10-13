<?php
function test()
{

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
if($error_count =='0')
{
	echo "There are no error in your orders!";
	echo "<BR/><BR/>Total Amount: RM <font size='25'><B><strong>".number_format($total_amount,2).'</strong></B></font>';
}
}


//check_order_number();

// a function use to check order numbering issues
function check_order_number()
{
	include("../../connection/pbmartconnection.php");
	
	echo "ORDER NUMBER SECTION<BR/>";
	echo "====================<BR/>";
	
	$error_count = '0';
	$sql_pbmart_order = "Select order_number FROM pbmart_order";
	$rs_pbmart_order = mysqli_query($dbconnect, $sql_pbmart_order);
	while($rw_pbmart_order = mysqli_fetch_array($rs_pbmart_order))
	{
		$order_number = $rw_pbmart_order['order_number'];
		$sql_pbmart_order_list = "SELECT order_number FROM pbmart_order_list WHERE order_number ='$order_number'";
		$rs_pbmart_order_list = @mysql_query($sql_pbmart_order_list);
		$i_order_number = @mysql_num_rows($rs_pbmart_order_list);
		if($i_order_number == '0')
		{
			echo '<B><font color=red>'.$order_number.' has error!</font></B><BR/>';
		}
	}
	
	$sql_pbmart_order_list = "SELECT order_number FROM pbmart_order_list";
	$rs_pbmart_order_list = @mysql_query($sql_pbmart_order_list);
	while($rw_pbmart_order_list = @mysql_fetch_array($rs_pbmart_order_list))
	{
		$order_number = $rw_pbmart_order_list['order_number'];
		$sql_pbmart_order = "Select order_number FROM pbmart_order WHERE order_number='$order_number'";
		$rs_pbmart_order = @mysql_query($sql_pbmart_order);
		$i_order_number = @mysql_num_rows($rs_pbmart_order);
		if($i_order_number == '0')
		{
			echo '<B><font color=red>'.$order_number.' has error!</font></B><BR/>';
		}
	}
}

//a function use to check error orders
function order_number($order_number)
{
	
	include("connection/pbmartconnection.php");	
	
	$error_count = '0';
	$total_flat = '0';
	$total_amount = '0';
	$product_qty = '0';
	
	$sql_pbmart_order = "Select * FROM pbmart_order WHERE order_number='$order_number'";
	$rs_pbmart_order = mysqli_query($dbconnect, $sql_pbmart_order);
	while($rw_pbmart_order = mysqli_fetch_array($rs_pbmart_order))
	{
		$total_product_amount = '0';
		$product_gross = '0';
		$pbmart_order_list_order_product_handling = '0';
		$pbmart_order_list_order_point = '0';
		
		$order_number = $rw_pbmart_order['order_number'];
		$order_amount = $rw_pbmart_order['order_amount'];
		$order_handling = $rw_pbmart_order['order_handling'];
		$order_total_point = $rw_pbmart_order['order_total_point'];
		$flat_handling = $rw_pbmart_order['flat_handling'];
		$order_customer_id = $rw_pbmart_order['order_customer_id'];
		
		
		
		$total_amount += $order_amount;
		$total_flat += $flat_handling;
		$sql_pbmart_order_list = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number'";
		$rs_pbmart_order_list = mysqli_query($dbconnect, $sql_pbmart_order_list);
		while($rw_pbmart_order_list = mysqli_fetch_array($rs_pbmart_order_list))
		{	$order_product_id = $rw_pbmart_order_list['order_product_id'];
			$order_product_class = $rw_pbmart_order_list['order_product_class'];

			$order_product_price = $rw_pbmart_order_list['order_product_price'];
			$order_product_handling = $rw_pbmart_order_list['order_product_handling'];
			$order_product_point = $rw_pbmart_order_list['order_product_point'];
			
			if($order_product_class == 'Product')
			{
				$prd_id = $order_product_id;
				$product = get_product_by_id($prd_id);
				$product_id = getProduct_ID($prd_id);
				
				if(get_customer_class($order_customer_id) == '0')
				{
					if($product[$product_id]->_product_double_point == '1')
					{
						$product_point = $product[$product_id]->_product_point * 2;
					}else
					{
						$product_point = $product[$product_id]->_product_point;
					}
					
					if(product_info_matching($product[$product_id]->_product_price, 
					$product[$product_id]->_product_handling, 
					$product_point, 
					$order_product_price, 
					$order_product_handling, 
					$order_product_point) == false)
					{
						$error_count++;
					}
					
					
				}else if(get_customer_class($order_customer_id) == '1')
				{
					if($product[$product_id]->_product_commercial_double_point == '1')
					{
						$product_point = $product[$product_id]->_product_commercial_point * 2;
					}else
					{
						$product_point = $product[$product_id]->_product_commercial_point;
					}
					
					if(product_info_matching($product[$product_id]->_product_commercial_price, 
					$product[$product_id]->_product_commercial_handling, 
					$product_point, 
					$order_product_price, 
					$order_product_handling, 
					$order_product_point) == false)
					{
						$error_count++;
					}
				}else if(get_customer_class($order_customer_id) == '2')
				{
					if($product[$product_id]->_product_commercial_double_point2 == '1')
					{
						$product_point = $product[$product_id]->_product_commercial_point2 * 2;
					}else
					{
						$product_point = $product[$product_id]->_product_commercial_point2;
					}
					
					if(product_info_matching($product[$product_id]->_product_commercial_price2, 
					   $product[$product_id]->_product_commercial_handling2, 
					   $product_point, 
					   $order_product_price, 
					   $order_product_handling, 
					   $order_product_point) == false)
					{
						$error_count++;
					}
				}
			}else if($order_product_class == 'Promotion')
			{
				
			}
			$order_product_amount = $rw_pbmart_order_list['order_product_amount'];
			$total_product_amount += $order_product_amount;
			$product_gross += (($order_product_price + $order_product_handling) * $order_product_amount);	
			$pbmart_order_list_order_product_handling += $order_product_handling * $order_product_amount;
			$pbmart_order_list_order_point += $order_product_amount * $order_product_point;
		}
		$product_qty += $total_product_amount/2;
		$product_gross += $flat_handling;
		
		//checking product amount
		if(number_format($product_gross,2) != number_format($order_amount,2))
		{
			$error_count++;
		}else if($pbmart_order_list_order_product_handling != $order_handling) //checking product order_handling
		{
			$error_count++;
		}else if($pbmart_order_list_order_point != $order_total_point) //checking product points
		{
			$error_count++;
		}
		if($error_count > 0 )
		{
			return true;
		}else
		{
			return false;
		}
	}
}

//a function use to get client class base on id given
function get_customer_class($customer_id)
{
	include("connection/pbmartconnection.php");
	$sql_member = "SELECT member_id, member_status, member_commercial_status, member_commercial_class FROM pbmart_member WHERE member_id='$customer_id'";
	$rs_member = mysqli_query($dbconnect, $sql_member);
	$rw_member = mysqli_fetch_assoc($rs_member);
	
	$member_status = $rw_member['member_status'];
	$member_commercial_status = $rw_member['member_commercial_status'];
	$member_commercial_class = $rw_member['member_commercial_class'];
	
	if($member_status == '1')
	{
		if($member_commercial_status == '0')
		{
			return 0;
		}else if($member_commercial_status == '1')
		{
			if($member_commercial_class == '1')
			{
				return 1;
			}else if($member_commercial_class == '2')
			{
				return 2;
			}
		}
	}
}	

function product_info_matching($product_price, $product_handling, $product_point, $order_produt_price, $order_product_handling, $order_product_point)
{
	if($product_price != $order_produt_price)
	{
		return false;
	}else if($product_handling != $order_product_handling)
	{
		return false;
	}else if($product_point != $order_product_point)
	{
		return false;
	}else
	{
		return true;
	}
}
?>