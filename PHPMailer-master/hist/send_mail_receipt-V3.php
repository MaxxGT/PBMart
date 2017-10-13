<?php
// Author: VOONG TZE HOWE
// Date Writen: 12 - 12- 2015
// Description : send receipt by mail
// Last Modification:

//Push Notification Implemented: Hamood Aslam
//Date Written: 3-12-2014

require 'class.phpmailer.php';
require("../connection/pbmartconnection.php");
include('../session_config.php');
get_UsrInfo();
GLOBAL $member_commercial_status;
error_reporting(E_ALL);
ini_set('display_errors', '1');

	//get delivery information	
	if(isset($_GET['order_num']) && $_GET['order_num']!='0')
	{
		$order_num = $_GET['order_num'];
	}
	
	if(isset($_GET['street_name']) && $_GET['street_name']!='0')
	{
		$street_name = $_GET['street_name'];
	}
	
	if(isset($_GET['city']) && $_GET['city']!='0')
	{
		$city = $_GET['city'];
	}
	
	if(isset($_GET['region_state']) && $_GET['region_state']!='0')
	{
		$region_state = $_GET['region_state'];
	}
	
	if(isset($_GET['country']) && $_GET['country']!='0')
	{
		$country = $_GET['country'];
	}
	
	if(isset($_GET['member_postcode']) && $_GET['member_postcode']!='0')
	{
		$member_postcode = $_GET['member_postcode'];
	}
	
	//get additonal information
	if(isset($_GET['shp_time']) && $_GET['shp_time']!='0')
	{
		$shp_time = $_GET['shp_time'];
		
		if($shp_time =='1')
		{
			$shp_time ='Afternoon (12:00pm to 4:00pm)';
		}else if($shp_time =='2')
		{
			$shp_time ='Morning (8:00am to 12:00pm)';
		}else if($shp_time =='3')
		{
			$shp_time ='Immediatly Delivery';
		}
	}
	
	if(isset($_GET['shp_date']) && $_GET['shp_date']!='0')
	{
		$shp_date = $_GET['shp_date'];
		$date = new DateTime($shp_date);
		$shipping_date = $date->format('d F Y');
	}
	
	if(isset($_GET['order_payment_type']))
	{
		$order_payment_type = $_GET['order_payment_type'];
	}
	$order_date = date("d F Y");
	
	
	$order_customer_address = $street_name.", ".$member_postcode." ".$city.", ".$region_state.", ".$country;
	$html = "
			<html>
				<head>
					<title>Receipt</title>
						<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.pbmart.com.my/cmanage/receipt/css/receipts_css.css\"></link>
				</head>
				<body>
					<img src=\"http://www.pbmart.com.my/cmanage/images/blank2.png\"></img>
					<div id='outter'>
					
					<div id='header'>
						<center><img src=\"http://www.pbmart.com.my/cmanage/receipt/images/pbmart_logo-Version2.jpg\"></img></center>
					</div>
					
					<div id='body' align='center'>
						<table border='0' align='center' width='700px' height='100px' cellspacing='0' cellpadding='0'>
							<tr>
								<th width='125px'>Name</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$member_first_name $member_last_name</td>
								<th width='105px'>Phone No</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$member_contact</td>
							</tr>
							<tr>
								<th width='125px'>Address</th>
								<th width='5px'>:</th>
								<td width='515px' colspan='4'>&nbsp;$order_customer_address</td>
							</tr>
							<tr>
								<th width='125px'>Order Number</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$order_num</td>
								<th width='105px'>Date</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$order_date</td>
							</tr>
							<tr>
								<th width='125px'>Member Number</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$member_number</td>
								<th width='105px'>Order Date</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$order_date</td>
							</tr>
							<tr>
								<th width='125px'>Delivery Time</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$shp_time</td>
								<th width='105px'>Delivery Date</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$shipping_date</td>
							</tr>
							<tr>
								<td colspan='6'><font size='2' color='red'><BR><B>
									*NOTE: ALL GAS ORDER WILL BE CLEAR WITHIN 3 WORKING DAYS.<BR>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ORDER MADE IN SUNDAY OR PUBLIC HOLIDAY WILL BE CARRIED TO NEXT WORKING DAY.</B>
								</td>
							</tr>
						</table>
					</div>";
				
				$html.="
					<table>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>";
				
				$html.="
				<div id='content' align='center'>
					<table border='1' align='center' width='700px' height='20px' cellspacing='0' cellpadding='0'>
						<tr height='30px'>
							<th width='80px' bgcolor='#BDBDBD'>Quantity</th>
							<th width='200px' bgcolor='#BDBDBD'>Items</th>
							<th width='300px' bgcolor='#BDBDBD'>Description</th>
							<th width='70px' bgcolor='#BDBDBD'>Sub Total</th>
						</tr>";
				$card_subtotal = '0';
		$shipping_handling = '0';
	if(!empty($_SESSION['order_qty']))
	{		
		for($i=0; $i<$_SESSION['order_qty']; $i++)
		{ 
			$product_id = $_SESSION['product_id'][$i];
			$product_qty = $_SESSION['product_qty'][$i];
			//if selected product is package, then...
			if(strpos($product_id, 'PKG_') !== false)
			{
				$product_ids = explode("PKG_", $product_id);
				$product_ids2 = $product_ids[1];
				
				$sql = "Select * FROM pbmart_promotion WHERE promotion_id='$product_ids2'";
				$rs = @mysql_query($sql, $link);
				$rw = @mysql_fetch_array($rs);
				
				$promotion_package_name = $rw['promotion_package_name'];
				$promotion_item_name = $rw['promotion_item_name'];
				$promotion_product_name = $rw['promotion_product_name'];
				
				$item = $promotion_package_name. '('.$promotion_product_name.' + '.$promotion_item_name.')';
				
				$promotion_package_description = $rw['promotion_package_description'];
				$promotion_product_price = $rw['promotion_product_price'];
				
				//$sub_total = number_format(($product_qty * $promotion_product_price),2);
				$sub_total = $rw['promotion_package_price'] * $product_qty;
				$card_subtotal = $card_subtotal + $sub_total;
				
				$html.="
				<tr>
					<td align='center'>$product_qty</td>
					<td>$item</td>
					<td>$promotion_package_description</td>
					<td align='right'>$sub_total</td>
				</tr>";
			}else
			{
				$total_handling_charge = '0';
				$sql = "Select * FROM pbmart_product WHERE product_id='$product_id'";
				$rs = @mysql_query($sql, $link);
				$rw = @mysql_fetch_array($rs);
				
				$product_name = $rw['product_name'];
				$product_model = $rw['product_model'];
				
				$product_qty = $_SESSION['product_qty'][$i];
				$product_price = $rw['product_price'];
				$product_commercial_price = $rw['product_commercial_price'];
				$product_handling = $rw['product_handling'];
				$product_handling_show = $rw['product_handling_show'];
				$product_commercial_handling_show = $rw['product_commercial_handling_show'];
				
				$product_commercial_handling = $rw['product_commercial_handling'];
				
				//access category of product_sale and product_sale_percentage
				$product_sale1 = $rw['product_sale1'];
				$product_sale_percentage1 = $rw['product_sale_percentage1'];	
				$product_sale2 = $rw['product_sale2'];
				$product_sale_percentage2 = $rw['product_sale_percentage2'];
				$product_sale3 = $rw['product_sale3'];
				$product_sale_percentage3 = $rw['product_sale_percentage3'];
				
				if($member_commercial_status == '0')
				{
					if($product_handling_show == '0')
					{
						$product_unit_price = $product_price + $product_handling;
						$total_handling_charge = '0';
					}else
					{
						$product_unit_price = $product_price;
						$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty);
					}
				}else if($member_commercial_status == '1')
				{
					if($product_commercial_handling_show == '0')
					{
						$product_unit_price = $product_commercial_price + $product_commercial_handling;
						$total_handling_charge = '0';
					}else
					{
						$product_unit_price = $product_commercial_price;
						$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $product_qty);
					}
				}else
				{
					if($product_handling_show == '0')
					{
						$product_unit_price = $product_price + $product_handling;
						$total_handling_charge = '0';
					}else
					{
						$product_unit_price = $product_price;
						$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty);
					}
				}
				
				//$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty);
				
				$cd_subtotal = cal_price($product_unit_price, $total_handling_charge, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
				$total_price = number_format($cd_subtotal,2);
				$card_subtotal = $card_subtotal + $cd_subtotal;
				
				$html.="
				<tr>
					<td align='center'>$product_qty</td>
					<td>$product_name</td>
					<td>$product_model</td>
					<td align='right'>$total_price</td>
				</tr>";
			}
		}
	}
		
		$card_subtotal = number_format($card_subtotal + $member_flat_floor, 2);
	
	if(!empty($_SESSION['redeem_order_qty']))
	{
		//manage the redemption order here...
		if($_SESSION['redeem_order_qty'] !='0')
		{
			$sql_redeem ="
							SELECT redemption_number,
							redemption_item,
							redemption_amount,
							r.redeem_model,
							r.redeem_description
							FROM pbmart_redemption_list
							INNER JOIN pbmart_redeem AS r
							ON r.redeem_id = redemption_item_id
							WHERE redemption_order_ref = '$order_num'";
							
			$sql_redemption_list = mysql_query($sql_redeem);
			while($rw = @mysql_fetch_array($sql_redemption_list))
			{	
				$redemption_number = $rw['redemption_number'];
				$redemption_item = $rw['redemption_item'];
				$redemption_amount = $rw['redemption_amount'];
				$redeem_model = $rw['redeem_model'];
				$redeem_description = $rw['redeem_description'];
				
				$html.="<tr>
							<td width='80px' valign='top' align='center'>$redemption_amount</td>
							<td width='200px' valign='top'>$redemption_item</td>
							<td width='300px' valign='top'>$redeem_model</td>
							<td width='70px' valign='top' style='text-align:right;padding-right:12px;'>Redeem</td>
						</tr>";
			}
		}
	}
			$html.="<tr>
						<th colspan='3' align='right' bgcolor='#BDBDBD'>Total Amount (RM) :</th>
						<td width='70px' align='right'>
							$card_subtotal
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>";

    $subject = "Order Confirmation";
    $mail = new PHPMailer();
    $mail->IsSMTP(true);
    //$mail->Host = "p3plcpnl0529.prod.phx3.secureserver.net"; // Your SMTP PArameter
	$mail->Host = "mail.pbmart.com.my"; // Your SMTP PArameter
    //$mail->Port = 465; // Your Outgoing Port
    $mail->Port = 25; // Your Outgoing Port
    $mail->SMTPAuth = true; // This Must Be True
    //$mail->Username = "administrator@pbmart.com.my"; // Your Email Address
    //$mail->Password = "Pbmartadmin2014"; // Your Password
	$mail->Username = "pbmartadmin@pbmart.com.my"; // Your Email Address
	$mail->Password = "PbMartAdmin2015*"; // Your Password
    $mail->SMTPSecure = ''; // Check Your Server's Connections for TLS or SSL

    $headers = "Reply-To: ".$member_email."\r\n"; 
	$headers.= "Return-Path: pbmartadmin@pbmart.com.my\r\n";
	$headers.= "From: administrator@pbmart.com.my\r\n"; 
	
	$headers.= "MIME-Version: 1.0\r\n"; 
	$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers.= "X-Priority: 3\r\n";
	$headers.= "X-Mailer: PHP". phpversion() ."\r\n";
	$headers.= "Organization: PBMart SDN.BHD\r\n";
 
	$mail->From = "pbmartadmin@pbmart.com.my";
    $mail->FromName = "PBMart SDN.BHD";
    $mail->AddAddress($member_email);
    $mail->AddAddress("sales@pbmart.com.my");
	
	
	$mail->SMTPDebug = 0;
    $mail->IsHTML(true);
	
	$mail->Header = $headers;
    $mail->Subject = $subject;
    $mail->Body = $html;

    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else
    {
		clear_session();
		header('Location: ../order.php');
	}
	
function cal_price($prd_price, $tl_handling_charge, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
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
	return ($tl_price - $discount) + $tl_handling_charge;
	//return $prd_sales_percentage;
}
?>