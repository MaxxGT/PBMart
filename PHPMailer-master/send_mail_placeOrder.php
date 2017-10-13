<?php
// Author: VOONG TZE HOWE
// Date Writen: 30-10-2014
// Description : send feedback form to pbmartonline@gmail.com
// Last Modification: 30-10-2014

//Push Notification Implemented: Hamood Aslam
//Date Written: 3-12-2014

require 'class.phpmailer.php';
require("../connection/pbmartconnection.php");
include('../session_config.php');
get_UsrInfo();

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
	$order_date = date("j F Y");
	

	$html = "<h1>Your order confirmation</h1><BR>";
	
	$html.="Dear $member_first_name,<BR><BR>
	We have receive an order from you on $order_date and the order information as shown below:<BR><BR>";
	
	$html.= "<table border='0' width='600px'>
				<tr>
					<td colspan='2' align='center'><strong><font size='3'>Account Information!</font></strong><BR><BR></td>
					<td colspan='2' align='center'><strong><font size='3'>Delivery Address</font></strong><BR><BR></td>
				</tr>
				<tr>
					<td><strong>First Name:</strong></td>
					<td>$member_first_name</td>
					
					<td><strong>Address:</strong></td>
					<td>$street_name</td>
				</tr>
				<tr>
					<td><strong>Last Name:</strong></td>
					<td>$member_last_name</td>
					
					<td><strong>City:</strong></td>
					<td>$city</td>
				</tr>
				<tr>
					<td><strong>Email:</strong></td>
					<td>$member_email</td>
					
					<td><strong>State:</strong></td>
					<td>$region_state</td>
				</tr>
				<tr>
					<td><strong>Telephone:</strong></td>
					<td>$member_telephone</td>
					
					<td><strong>Country:</strong></td>
					<td>$country</td>
				</tr>
				<tr>
					<td><strong>Mobile Number:</strong></td>
					<td>$member_mobile</td>
					
					<td><strong>Postcode:</strong></td>
					<td>$member_postcode</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr><BR></table>";
				
	$html.="<table width='500px'>
				<tr>
					<td><strong><font size='3'>Additional Information</font></strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Preffered shipping time:</strong></td>
					<td>$shp_time</td>
				</tr>
				
				<tr>
					<td><strong>Preffered shipping Date:</strong></td>
					<td>$shipping_date</td>
				</tr>
				
				<tr>
					<td colspan='2'><span style = 'color:red'>*</span><font color='FF0000' size='2'><B>NOTE: ALL GAS ORDER WILL BE CLEAR WITHIN 3 DAYS</B></font></td>
				</tr>
			</table>";

	$html.="<table border='0' width='500px'>
				<tr>
					<td colspan='4'><BR><font size='3'><strong>Order Information</strong></font><BR><BR></td>
				</tr>
        </table>";		
	$html.="<table border='1px single' width='500px'>
				<tr>
					<td align='left'><strong><u>Order No</u></strong></td>
					<td align='left'><strong><u>Product Name</u></strong></td>
					<td align='center'><strong><u>Unit Price</u></strong></td>
					<td align='center'><strong><u>Quantity</u></strong></td>
					<td align='center'><strong><u>Total Price</u></strong></td>
				</tr>";

		$card_subtotal = '0';
		$shipping_handling = '0';
		for($i=0; $i<$_SESSION['order_qty']; $i++)
		{ 
			$product_id = $_SESSION['product_id'][$i];
			$sql = "Select * FROM pbmart_product WHERE product_id='$product_id'";
			$rs = @mysql_query($sql, $link);
			$rw = @mysql_fetch_array($rs);
			
			$product_name = $rw['product_name'];
			
			$product_qty = $_SESSION['product_qty'][$i];
			$product_price = $rw['product_price'];
			
			//access category of product_sale and product_sale_percentage
			$product_sale1 = $rw['product_sale1'];
			$product_sale_percentage1 = $rw['product_sale_percentage1'];
						
			$product_sale2 = $rw['product_sale2'];
			$product_sale_percentage2 = $rw['product_sale_percentage2'];
						
			$product_sale3 = $rw['product_sale3'];
			$product_sale_percentage3 = $rw['product_sale_percentage3'];
			
			$cd_subtotal = cal_price($product_price, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
			$total_price = number_format($cd_subtotal,2);
			$card_subtotal += $cd_subtotal;
			
		$html.="<tr>
				<td>$order_num</td>
				<td >$product_name</td>
				<td align='right'>RM $product_price</td>
				<td  align='center'>$product_qty</td>
				<td align='right' border='1'>RM $total_price</td>
				</tr>";
		}
		
		$total_amount = number_format($card_subtotal,2);
		
		$html.="<tr>
					
					<td colspan='4' align='right'><strong>Total</strong></td>
					<td align='right'>RM $total_amount</td>
				</tr></table>";
				
		$html.="<table>
					<tr>
						<td colspan='3'><BR><strong><font size='3'>Payment Selection</font></strong><BR><BR></td>
					</tr>
					
					<tr>
						<td>Payment type:</td>
						<td>$order_payment_type</td>
					</tr>
				</table>";
		
		
    $subject = "Order Information";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "p3plcpnl0529.prod.phx3.secureserver.net"; // Your SMTP PArameter
    $mail->Port = 465; // Your Outgoing Port
    $mail->SMTPAuth = true; // This Must Be True
    $mail->Username = "administrator@pbmart.com.my"; // Your Email Address
    $mail->Password = "Pbmartadmin2014"; // Your Password
    $mail->SMTPSecure = 'ssl'; // Check Your Server's Connections for TLS or SSL

    $mail->From = "administrator@pbmart.com.my";
    $mail->FromName = 'Pulau Burung SDN.BHD';
    $mail->AddAddress($member_email);
	$mail->AddAddress('pbmartdelivery@gmail.com');
	$mail->SMTPDebug = 0;
    $mail->IsHTML(true);
	
    $mail->Subject = $subject;
    $mail->Body = $html;

    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else
    {
		clear_session();
		header('Location: ../order.php?hyperlink=product');
	}

function cal_price($prd_price, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
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
	return $tl_price - $discount;
	//return $prd_sales_percentage;
}

//Mobile Devices Android and iOS Implementation Begins

$mssg = "Thank You For You Order $member_first_name. We will be Processing Your Order Soon";
    $idarray=array();
   		
$firstloop=mysql_query("Select device_id,type FROM mobile_devices WHERE email='$member_email'",$link);
$number_of_rows_initial=mysql_num_rows($firstloop);
while (($row = mysql_fetch_array($firstloop, MYSQL_ASSOC)) !== false){
  $idarray[] = $row; // add the row in to the results (data) array
 // print_r($idarray);
}
		

for($counter=0; $counter<$number_of_rows_initial; $counter++)   
		{
                $id=$idarray[$counter]['device_id'];
                if($idarray[$counter]['type']=='ios'){
              

// Put your private keys passphrase here:
$passphrase = 'pbmart911';


$message = $mssg;


$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = @stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
//	exit("Failed to connect: $err $errstr" . PHP_EOL);

// echo 'Connected to APNS',"<br />" . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $id) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result){
	//echo "<br />",'Message not delivered' . PHP_EOL;
}else{
	//echo "<br />",'Message successfully delivered' . PHP_EOL;
}
// Close the connection to the server
fclose($fp);
                }else{
                    $id=$idarray[$counter]['device_id'];
                 
                    $message=$mssg;
                    include_once 'GCM.php';
    
    $gcm = new GCM();
    $text=$message;
    $registatoin_ids = array($id);
    $message = array("price" => $text);

    $result = $gcm->send_notification($registatoin_ids, $message);
   

                }
                
                }
?>	
  
    
  
 


    

   
   
   
   
    
