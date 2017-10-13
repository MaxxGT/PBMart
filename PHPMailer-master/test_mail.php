<?php
require 'class.phpmailer.php';
require("../connection/pbmartconnection.php");
include('../session_config.php');

    $body = "<html>\n"; 
    $body .= "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#666666;\">\n"; 
    $body .= "<img src=\"pbmart.png\">IMG Display Here...</img>";
    $body .= "</body>\n"; 
    $body .= "</html>\n"; 

	$headers = "Bcc: hausky2010@hotmail.com\r\n";
    $headers .= "From: PBMart<administrator@pbmart.com.my>\r\n"; 
    $headers .= "Reply-To: administrator@pbmart.com.my\r\n"; 
    $headers .= "Return-Path: administrator@pbmart.com.my\r\n"; 
    $headers .= "X-Mailer: PHP/" . phpversion();  
    $headers .= 'MIME-Version: 1.0' . "\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$message = $body;
	
	
	$subject = "Order Information";
    $mail = new PHPMailer();
    $mail->IsSMTP(true);
    $mail->Host = "p3plcpnl0529.prod.phx3.secureserver.net"; // Your SMTP PArameter
    $mail->Port = 465; // Your Outgoing Port
    $mail->SMTPAuth = true; // This Must Be True
    $mail->Username = "administrator@pbmart.com.my"; // Your Email Address
    $mail->Password = "Pbmartadmin2014"; // Your Password
    $mail->SMTPSecure = 'ssl'; // Check Your Server's Connections for TLS or SSL

    $mail->From = "administrator@pbmart.com.my";
    $mail->FromName = 'Pulau Burung SDN.BHD';
   // $mail->AddAddress($member_email);
	$mail->AddAddress('hausky2010@hotmail.com');
	$mail->AddAddress('maxVoongT@gmail.com');
	$mail->SMTPDebug = 0;
    $mail->IsHTML(true);
	
	$mail->Header = $headers;
    $mail->Subject = $subject;
    $mail->Body = $body;
	$mail->AddEmbeddedImage('../cmanage/receipt/images/pbmart.png', 'PBMart');
	
    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else
    {
		clear_session();
		header('Location: ../test_mail.phps');
	}
?>