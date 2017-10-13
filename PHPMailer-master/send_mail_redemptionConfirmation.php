<?php
// Author: VOONG TZE HOWE
// Date Writen: 19-12-2014
// Description : send redemption order to customer
// Last Modification: 19-12-2014

require 'class.phpmailer.php';
require("../connection/pbmartconnection.php");
include('../session_config.php');
get_UsrInfo();

error_reporting(E_ALL);
ini_set('display_errors', '1');

	//get redemption info
	
	if(isset($_REQUEST['redeem_no']))
	{
		$redeem_no = $_REQUEST['redeem_no'];
	}else
	{
		$redeem_no = "";
	}
	
	if(isset($_REQUEST['qty']))
	{
		$qty = $_REQUEST['qty'];
	}else
	{
		$qty = "";
	}
	
	if(isset($_REQUEST['redemption_item']))
	{
		$redemption_name = $_REQUEST['redemption_item'];
	}else
	{
		$redemption_name = "";
	}
	
	if(isset($_REQUEST['redemption_point']))
	{
		$redemption_point = $_REQUEST['redemption_point'];
	}else
	{
		$redemption_point = "";
	}
	
	$order_date = date("j F Y");
	

	$html = "<h1>Your redemption confirmation</h1><BR>";
	
	$html.="Dear $member_first_name,<BR><BR>
	We have receive an redemption order from you on $order_date and the order information as shown below:<BR><BR>";
	
	$html.= "<table width='500px'>
				<tr>
					<td colspan='2' align='center'><strong><font size='3'>Redemption Information:</font></strong><BR><BR></td>
				</tr>
				</table>";
				
	$html.="<table width='500px'>
				<tr>
					<td><strong><u>No</u></strong></td>
					<td><strong><u>Product Name</u></strong></td>
					<td><strong><u>Quantity</u></strong></td>
					<td><strong><u>Point</u></strong></td>
				</tr>
				
				<tr>
					<td>$redeem_no</td>
					<td>$redemption_name</td>
					<td>$qty</td>
					<td>$redemption_point</td>
				</tr></table>";
				
	$html.="<table>
				<BR><BR>
				<tr>
					<td>Thank you,</td>
				</tr>
				<tr>
					<td><a href=\"http://www.pbmart.com.my\">www.PBMart.com.my</a></td>
				</tr>
			</table>";
				
    $subject = "Redemption Order Information";
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
		header('Location: ../redemption.php?hyperlink=redemption');
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

$mssg = "Thank You For You Redemption Order $member_first_name. We will be Processing Your Order Soon";
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
  
    
  
 


    

   
   
   
   
    
