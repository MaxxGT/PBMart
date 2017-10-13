<?php
require 'class.phpmailer.php';
require("../connection/pbmartconnection.php");
include('../session_config.php');
get_UsrInfo();
GLOBAL $member_commercial_status;
error_reporting(E_ALL);
ini_set('display_errors', '1');
$total_redeem_points = 0;

//get total redeem point
GLOBAL $member_point;

	//get delivery information	
	if(isset($_GET['order_num']) && $_GET['order_num']!='0')
	{
		$order_num = $_GET['order_num'];
	}
	
	$sql_receipt = mysql_query("SELECT * FROM pbmart_order WHERE order_number = '$order_num'");
	$rw_receipt = @mysql_fetch_assoc($sql_receipt);
	
	$order_amount = $rw_receipt['order_amount'];
	$flat_handling = $rw_receipt['flat_handling'];
	$flat_handling = number_format($flat_handling,2);
	$order_handling = $rw_receipt['order_handling'];
	$order_date = $rw_receipt['order_date'];
	$order_date = date("d F Y", strtotime($order_date));
	$shp_date = $rw_receipt['order_delivery'];
	$shp_date = date("d F Y", strtotime($shp_date));
	$shp_time = $rw_receipt['order_time'];
	
	if($shp_time == '1')
	{
		$shp_time = "Afternoon (12-4)";
	}else if($shp_time == '2')
	{
		$shp_time = "Morning (8-12)";
	}else
	{
		$shp_time = "";
	}
	
	$order_customer_id = $rw_receipt['order_customer_id'];
	$order_customer_name = $rw_receipt['order_customer_name'];
	$order_customer_telephone = $rw_receipt['order_customer_telephone'];
	$order_customer_contact = $rw_receipt['order_customer_contact'];
	$order_customer_address = $rw_receipt['order_customer_address'];
	$order_status = $rw_receipt['order_status'];
	
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
							</tr>";
							
							
							if($member_commercial_status != '1' && $commercial_status !='1')
							{ 
								$html.="
								<th width='125px'>Member Number</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$member_number</td>";
								
							}else if($member_commercial_status == '1' && $commercial_status =='1')
							{
								$html.="
								<th width='125px'>Member Number</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$commercial_number</td>";	
							}else
							{
								$html.="
								<th width='125px'>Member Number</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$member_number</td>";
							}
							$html.="<th width='105px'>Order Date</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$order_date</td>
							</tr>
							<tr>
								<th width='125px'>Delivery Time</th>
								<th width='5px'>:</th>
								<td width='250px'>&nbsp;$shp_time</td>
								<th width='105px'>Delivery Date</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$shp_date</td>
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
	$total_subtotal = '0';
	$total_point_reward = '0';
	
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
				$promotion_package_point = $rw['promotion_package_point'];
				$promotion_package_double_point = $rw['promotion_package_double_point'];
				
				if($promotion_package_double_point == '1')
				{
					$prm_unit_points = $promotion_package_point * 2;
				}else
				{
					$prm_unit_points = $promotion_package_point;
				}
				
				$total_point_reward = $total_point_reward + ($prm_unit_points * $product_qty);
				$item = $promotion_package_name. '('.$promotion_product_name.' + '.$promotion_item_name.')';
				
				$promotion_package_description = $rw['promotion_package_description'];
				$promotion_product_price = $rw['promotion_product_price'];
				
				//$sub_total = number_format(($product_qty * $promotion_product_price),2);
				$sub_total = $rw['promotion_package_price'] * $product_qty;
				$sub_total = number_format($sub_total,2);
				$total_subtotal = $total_subtotal + $sub_total;
				$total_subtotal = number_format($total_subtotal,2);
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
				$product_commercial_price2 = $rw['product_commercial_price2'];
				$product_handling = $rw['product_handling'];
				$product_handling_show = $rw['product_handling_show'];
				$product_commercial_handling_show = $rw['product_commercial_handling_show'];
				$product_commercial_handling_show2 = $rw['product_commercial_handling_show2'];
				
				$product_commercial_handling = $rw['product_commercial_handling'];
				$product_commercial_handling2 = $rw['product_commercial_handling2'];
				
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
					
					$product_point = $rw['product_point'];
					$product_double_point = $rw['product_double_point'];
					//point checking for double point
					if($product_double_point == '1')
					{
						$prd_points = $product_point * 2;
					//$prd_points = $product_point;
					}else
					{
						$prd_points = $product_point;
					}
					$total_point_reward = $total_point_reward + ($prd_points * $product_qty);
				}else if($member_commercial_status == '1')
				{
					if($member_commercial_class=='1')
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
						$product_commercial_point = $rw['product_commercial_point'];
						$product_commercial_double_point = $rw['product_commercial_double_point'];
						//point checking for double point
									if($product_commercial_double_point == '1')
									{
										$prd_points = $product_commercial_point * 2;
										//$prd_points = $product_commercial_point;
									}else
									{
										$prd_points = $product_commercial_point;
									}
						$total_point_reward = $total_point_reward + ($prd_points * $product_qty);
					}else if($member_commercial_class == '2')
					{
						if($product_commercial_handling_show2 == '0')
						{
							$product_unit_price = $product_commercial_price2 + $product_commercial_handling2;
							$total_handling_charge = '0';
						}else
						{
							$product_unit_price = $product_commercial_price2;
							$total_handling_charge = $total_handling_charge + ($product_commercial_handling2 * $product_qty);
						}
						$product_commercial_point2 = $rw['product_commercial_point2'];
						$product_commercial_double_point2 = $rw['product_commercial_double_point2'];
						//point checking for double point
						
						if($product_commercial_double_point2 == '1')
						{
							$prd_points = $product_commercial_point * 2;
							//$prd_points = $product_commercial_point2;
						}else
						{
							$prd_points = $product_commercial_point2;
						}
						
						$total_point_reward = $total_point_reward + ($prd_points * $product_qty);
					}else
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
						$product_commercial_point = $rw['product_commercial_point'];
						$product_commercial_double_point = $rw['product_commercial_double_point'];
						//point checking for double point
						if($product_commercial_double_point == '1')
						{
							$prd_points = $product_commercial_point * 2;
							//$prd_points = $product_commercial_point;
						}else
						{
							$prd_points = $product_commercial_point;
						}
						$total_point_reward = $total_point_reward + ($prd_points * $product_qty);
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
					$product_point = $rw['product_point'];
					$product_double_point = $rw['product_double_point'];
					//point checking for double point
					if($product_double_point == '1')
					{
						$prd_points = $product_point * 2;
					//$prd_points = $product_point;
					}else
					{
						$prd_points = $product_point;
					}
					$total_point_reward = $total_point_reward + ($prd_points * $product_qty);
				}
				
				//$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty);
				
				$cd_subtotal = cal_price($product_unit_price, $total_handling_charge, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
				$total_price = number_format($cd_subtotal,2);
				$total_subtotal = $total_subtotal + $total_price;
				$total_subtotal = number_format($total_subtotal,2);
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
		
	$handling_charge = number_format($member_flat_floor,2);
	if(!empty($_SESSION['redeem_order_qty']))
	{
		//manage the redemption order here...
		if($_SESSION['redeem_order_qty'] !='0')
		{
			$sql_redeem ="
							SELECT redemption_number,
							redemption_item,
							redemption_amount,
							redemption_points,
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
				$redemption_points = $rw['redemption_points'];
				$total_redeem_points = $total_redeem_points + $redemption_points;
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
			$html.="
					<tr>
						<td colspan='4'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Sub Amount (RM) :</B></td>
						<td width='70px' align='right'><B>$total_subtotal</B></td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Flat Handling (RM) :</B></td>
						<td width='70px' align='right'><B>$flat_handling</B></td>
					</tr>
					<tr>
						<th colspan='3' align='right' bgcolor='#BDBDBD'>Total Amount (RM) :</th>
						<td width='70px' align='right'>
							<B>$order_amount</B>
						</td>
					</tr>
					<tr>
						<td colspan='4'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Points Reward:</B></td>
						<td width='70px' align='right'><B>$total_point_reward</B></td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Points Redeem:</B></td>
						<td width='70px' align='right'><B>$total_redeem_points</B></td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Points Balance:</B></td>
						<td width='70px' align='right'><B>$member_point</B></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>";

echo $html;
exit;

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