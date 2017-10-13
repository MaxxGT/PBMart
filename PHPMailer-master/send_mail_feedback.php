<?php
// Author: VOONG TZE HOWE
// Date Writen: 30-10-2014
// Description : send feedback form to pbmartonline@gmail.com
// Last Modification: 30-10-2014
require 'class.phpmailer.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_POST['name']))
{
	$name = mysql_real_escape_string(strip_tags(trim($_POST['name'])));
}else{
	$name="";
}
if(isset($_POST['email']))
{
	$email = mysql_real_escape_string(strip_tags(trim($_POST['email'])));
}else{
	$email="";
}
if(isset($_POST['gender']))
{
	$gender = mysql_real_escape_string(strip_tags(trim($_POST['gender'])));
}else{
	$gender="";
}
if(isset($_POST['feedback_experience']))
{
	$feedback_experience = mysql_real_escape_string(strip_tags(trim($_POST['feedback_experience'])));
}else{
	$feedback_experience="";
}
if(isset($_POST['feedbackType']))
{
	$feedbackType = $_POST['feedbackType'];
}else{
	$feedbackType="";
}
if(isset($_POST['comment']))
{
	$comment = $_POST['comment'];
}else{
	$comment="";
}

	$html = "Feedback Form<BR><BR>
	$name<BR>
	$email<BR>
	Gender: $gender<BR>
	Feedback Experience: $feedback_experience<BR>
	Feedback Type: $feedbackType<BR><BR>
	Comment: $comment"; 

    $email = "pbmartdelivery@gmail.com";
    $subject = "Customer Feedback";
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
    $mail->AddAddress($email);
	$mail->SMTPDebug = 0;
    $mail->IsHTML(true);
	
    $mail->Subject = $subject;
    $mail->Body = $html;

    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else
    {
		header('Location: ../index.php?hyperlink=home');
	}
?>