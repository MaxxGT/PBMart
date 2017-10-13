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
	
	$sql_receipt = mysql_query("SELECT * FROM pbmart_order WHERE order_number = '$order_num'");
	$rw_receipt = @mysql_fetch_assoc($sql_receipt);
	
	$order_amount = $rw_receipt['order_amount'];
	$flat_handling = $rw_receipt['flat_handling'];
	$order_handling = $rw_receipt['order_handling'];
	$order_date = $rw_receipt['order_date'];
	$shp_date = $rw_receipt['order_delivery'];
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
								<td width='250px'>&nbsp;$order_customer_name</td>
								<th width='105px'>Phone No</th>
								<th width='5px'>:</th>
								<td width='150px'>&nbsp;$order_customer_contact</td>
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
			
			$sql_order_list = mysql_query("SELECT * FROM pbmart_order_list WHERE order_number = '$order_number'");
			$rw_order_list = @mysql_fetch_assoc($sql_order_list);
			$order_product_id = $rw_order_list['order_product_id'];
			$order_product_class = $rw_order_list['order_product_class'];
			$order_product_name = $rw_order_list['order_product_name'];
			$order_product_model = $rw_order_list['order_product_model'];
			$order_product_price = $rw_order_list['order_product_price'];
			$order_product_handling = $rw_order_list['order_product_handling'];
			$order_product_amount = $rw_order_list['order_product_amount'];
				
				$html.="
				<tr>
					<td align='center'></td>
					<td></td>
					<td></td>
					<td align='right'></td>
				</tr>";
			
				
				$html.="
				<tr>
					<td align='center'></td>
					<td></td>
					<td><td>
					<td align='right'></td>
				</tr>";
			
		
	
		
		$card_subtotal = number_format($card_subtotal + $member_flat_floor, 2);
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
			$html.="
					<tr>
						<td colspan='4'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Sub Amount (RM) :</B></td>
						<td width='70px' align='right'><B></B></td>
					</tr>
					<tr>
						<td colspan='3' align='right' bgcolor='#BDBDBD'><B>Flat Handling (RM) :</B></td>
						<td width='70px' align='right'><B></B></td>
					</tr>
			
					<tr>
						<th colspan='3' align='right' bgcolor='#BDBDBD'>Total Amount (RM) :</th>
						<td width='70px' align='right'>
							<B></B>
						</td>
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