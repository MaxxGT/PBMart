<?php
    require 'class.phpmailer.php';
	
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

	if(isset($_GET['member_email']))
	{
		$member_email = $_GET['member_email'];
	}
	
	if(isset($_GET['member_first_name']))
	{
		$member_first_name = $_GET['member_first_name'];
	}
	if(isset($_GET['member_vcode']))
	{
		$member_vcode = $_GET['member_vcode'];
	}
	$hyperlink = "http://www.pbmart.com.my/chg_psd.php?member_email=$member_email&member_first_name=$member_first_name&member_vcode=$member_vcode";
	//echo $hyperlink;
	
	$html = "<p><strong>Password Change Requested</strong><br /><br />
	
	Dear $member_first_name,<br/><br/>
	
	We've received a request to change your Account password. If you did not make this request yourself, ignore this email and contact your administractor.<br /><br />
	
	If you would like to reset your password follow the link below.<br/>
	<a href=\"$hyperlink\">$hyperlink</a></p><br /><br />
	
	Best regards,<br/>
	www.pbmart.com.my<br/>"; 

    $name = "PBMart SDN.BHD";
    $email = "administrator@pbmart.com.my";
    $subject = "Request Change Password";
	
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "p3plcpnl0529.prod.phx3.secureserver.net"; // Your SMTP PArameter
    $mail->Port = 465; // Your Outgoing Port
    $mail->SMTPAuth = true; // This Must Be True
    $mail->Username = "administrator@pbmart.com.my"; // Your Email Address
    $mail->Password = "Pbmartadmin2014"; // Your Password
    $mail->SMTPSecure = 'ssl'; // Check Your Server's Connections for TLS or SSL
	
    $mail->From = "administrator@pbmart.com.my";
    $mail->FromName = $name;
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
		header('Location: ../rst_psd.php?hyperlink=home&sts=esend');
    }
?>