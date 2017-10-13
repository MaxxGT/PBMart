<?php
require_once("connection/pbmartconnection.php");
include('class/product.php');
include('class/commercial.php');
include('session_config.php');

get_UsrInfo();
GLOBAL $member_commercial_status;

$prd_id = $_GET['id'];
$qty = $_GET['qty'];
$product = get_product_by_id($prd_id);
$product_id = getProduct_ID($prd_id);
$display_product_price = $product[$product_id]->_product_price;

$commercial = getCommercialbyId();
$commercial_id = getCommercial_ID();

if($member_commercial_status == '1')
{
	if($member_commercial_class == '1')
	{
		$display_product_price = $product[$product_id]->_product_commercial_price * $qty;;
		$display_product_handling = $product[$product_id]->_product_commercial_handling * $qty;;
	}else if($member_commercial_class == '2')
	{
		$display_product_price = $product[$product_id]->_product_commercial_price2 * $qty;;
		$display_product_handling = $product[$product_id]->_product_commercial_handling2 * $qty;;
	}else
	{
		$display_product_price = $product[$product_id]->_product_commercial_price * $qty;;
		$display_product_handling = $product[$product_id]->_product_commercial_handling * $qty;;
	}
}else
{
	$display_product_price = $product[$product_id]->_product_price * $qty;
	$display_product_handling = $product[$product_id]->_product_handling  * $qty;
}

if($member_commercial_status =='0')
{
	$total_product_price = ($product[$product_id]->_product_price + $product[$product_id]->_product_handling) * $qty;
}else if($member_commercial_status =='1')
{
	if($member_commercial_class == '1')
	{
		$total_product_price = ($product[$product_id]->_product_commercial_price + $product[$product_id]->_product_commercial_handling)* $qty;
	}else if($member_commercial_class == '2')
	{
		$total_product_price = ($product[$product_id]->_product_commercial_price2 + $product[$product_id]->_product_commercial_handling2) * $qty;
	}else
	{
		$total_product_price = ($product[$product_id]->_product_commercial_price + $product[$product_id]->_product_commercial_handling)* $qty;
	}
	
}else
{
	$total_product_price = ($product[$product_id]->_product_price + $product[$product_id]->_product_handling) * $qty;
}

																if($member_commercial_status == '0')
																{
																	if($product[$product_id]->_product_handling_show == '1')
																	{
																		echo('RM'.number_format($display_product_price,2));
																		echo "<BR/><font size='2'>+ OTHERS RM";
																		echo number_format($display_product_handling,2);
																		echo "</font>";
																	}else
																	{
																		echo('RM'.number_format($total_product_price,2));
																	}
																}else if($member_commercial_status == '1')
																{
																	if($member_commercial_class == '1')
																	{
																			if($product[$product_id]->_product_commercial_handling_show == '1')
																			{
																				echo('RM'.number_format($display_product_price,2));
																				echo "<BR/><font size='2'>+ OTHERS RM";
																				echo number_format($display_product_handling,2);
																				echo "</font>";
																			}else
																			{
																				echo('RM'.number_format($total_product_price,2));
																			}
																	}else if($member_commercial_class == '2')
																	{
																		if($product[$product_id]->_product_commercial_handling_show2 == '1')
																		{
																			echo('RM'.number_format($display_product_price,2));
																			echo "<BR/><font size='2'>+ OTHERS RM";
																			echo number_format($display_product_handling,2);
																			echo "</font>";
																		}else
																		{
																			echo('RM'.number_format($total_product_price,2));
																		}
																	}else
																	{
																		if($product[$product_id]->_product_commercial_handling_show == '1')
																		{
																			echo('RM'.number_format($display_product_price,2));
																			echo "<BR/><font size='2'>+ OTHERS RM";
																			echo number_format($display_product_handling,2);
																			echo "</font>";
																		}else
																		{
																			echo('RM'.number_format($total_product_price,2));
																		}
																	}	
																}else
																{
																	if($product[$product_id]->_product_handling_show == '1')
																	{
																		echo('RM'.number_format($display_product_price,2));
																		echo "<BR/><font size='2'>+ OTHERS RM";
																		echo number_format($display_product_handling,2);
																		echo "</font>";
																	}else
																	{
																		echo('RM'.number_format($total_product_price,2));
																	}
																}
?>