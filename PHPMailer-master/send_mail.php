<?php
    require 'class.phpmailer.php';
	
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

	//receive the user information together with validation code from register_action page
	$usr_id = $_REQUEST['usr_id'];
	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$user_email = $_REQUEST['user_email'];
	$usr_regDate = $_REQUEST['usr_regDate'];
	$usr_vcode = $_REQUEST['usr_vcode'];
	

	$hyperlink = "http://www.pbmart.com.my/confirm.php?act=confirmation&usr_id=$usr_id&first_name=$first_name&last_name=$last_name&user_email=$user_email&usr_regDate=$usr_regDate&usr_vcode=$usr_vcode";
	//$hyperlink = "localhost:8080/pbmart/confirm.php?act=confirmation&usr_id=$usr_id&first_name=$first_name&last_name=$last_name&user_email=$user_email&usr_regDate=$usr_regDate&usr_vcode=$usr_vcode";
	//echo $hyperlink;
	
	$html = "<p>Welcome to <b>PBMart SDN.BHD</b> member registration page!<br /><br />
	
	To confirm your registration please click this link(if link is not clickable, copy and paste it to your browser)<br /> <a href=\"$hyperlink\">$hyperlink</a></p><br /><br />
	<br/><br/>
	Thank you,<br/>
	<a href=\"http://www.pbmart.com.my\">www.PBMart.com.my</a><br/>"; 

    $name = "PBMart SDN.BHD";
    $email = "administrator@pbmart.com.my";
    $subject = "Email Confirmation";
    

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
    $mail->AddAddress($user_email);
	$mail->SMTPDebug = 0;
	
    $mail->IsHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $html;
	
    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
	//else
    //{
		//header('Location: ../confirmation.php?usr_email='.$user_email.'&hyperlink=account');
		//echo "<script>top.location.href ='confirmation.php?usr_email=$user_email';</script>";
		//echo "<script>parent.location='localhost/pbmart/confirmation.php?usr_email=$user_email';</script>";
    //}
?>

<FORM method="post" id="send_mail" name="send_mail" action="../confirmation.php">
	<input type="hidden" name="usr_email" value="<?php echo $user_email; ?>"></input>
	<input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>"></input>
	<input type="hidden" name="first_name" value="<?php echo $first_name; ?>"></input>
	<input type="hidden" name="last_name" value="<?php echo $last_name; ?>"></input>
	<input type="hidden" name="usr_regDate" value="<?php echo $usr_regDate; ?>"></input>
	<input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>"></input>
	<input type="hidden" name="usr_vcode" value="<?php echo $usr_vcode; ?>"></input>
	<script language="JavaScript">document.send_mail.submit();</script>
</FORM>