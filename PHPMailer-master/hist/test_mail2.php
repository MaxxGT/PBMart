<?php
// Author: VOONG TZE HOWE
// Date Writen: 30-10-2014
// Description : send feedback form to pbmartonline@gmail.com
// Last Modification: 30-10-2014

require 'class.phpmailer.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

	$user_name = "Maxx Voong";
	$html = "<table border='0'>
				<tr>
					<td>
						<strong>PBMart Online Shopping</strong>
					</td>
				</tr>";
	$html.= "<tr><td>Welcome to PBMart Online Shopping Website!</td></tr>";
	$html.= "<tr><td><img src=\"http://localhost/pbmart/cmanage/receipt/images/pbmart.png\" width='150px' height='150px'></img></td></tr></table>";
	$html.= "</html>";
	
	$email = "hau_sky@yahoo.com";
	
    $subject = "Mail Testing";
    $mail = new PHPMailer();
    $mail->IsSMTP(true);
    $mail->Host = "p3plcpnl0529.prod.phx3.secureserver.net"; // Your SMTP PArameter
    $mail->Port = 465; // Your Outgoing Port
    $mail->SMTPAuth = true; // This Must Be True
    $mail->Username = "administrator@pbmart.com.my"; // Your Email Address
    $mail->Password = "Pbmartadmin2014"; // Your Password
    $mail->SMTPSecure = 'ssl'; // Check Your Server's Connections for TLS or SSL

    $headers = "Reply-To: hausky2010@hotmail.com\r\n"; 
	$headers.= "Return-Path: administrator@pbmart.com.my\r\n";
	$headers.= "From: administrator@pbmart.com.my\r\n"; 
	
	$headers.= "MIME-Version: 1.0\r\n"; 
	$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers.= "X-Priority: 3\r\n";
	$headers.= "X-Mailer: PHP". phpversion() ."\r\n";
	$headers.= "Organization: PBMart SDN.BHD\r\n";
 
	$mail->From = "administrator@pbmart.com.my";
    $mail->FromName = "Webmaster@Inc.";
	$mail->AddAddress($email, $user_name);
	
	$mail->SMTPDebug = 0;
    $mail->IsHTML(true);
	
	$mail->Header = $headers;
    $mail->Subject = $subject;
    $mail->Body = $html;
	$mail->AddAttachment('Attachment_Testing.txt', 'Attachment_Testing.txt');

    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else
    {
		header('Location: mail.phps');
	}
?>