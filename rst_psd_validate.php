<?php
// Author: VOONG TZE HOWE
// Date Writen: 16-11-2014
// Description : reset password
// Last Modification:

include("connection/pbmartconnection.php");
include('encrypt_decrypt.php');
if(isset($_POST['act']))
{
	$act = $_POST['act'];
}
$table_name = 'pbmart_member';

if($act=='validate_email')
{
	if(isset($_POST['usr_email']) && $_POST['usr_email'] !="")
	{
		$usr_email = mysql_real_escape_string(strip_tags(trim($_POST['usr_email'])));
		
		$sql = "Select * FROM pbmart_member WHERE member_email='$usr_email'";
		$rs = @mysql_query($sql,$link);
		$count = @mysql_num_rows($rs);
		$rw = @mysql_fetch_array($rs);
		
		$member_first_name = $rw['member_first_name'];
		$member_vcode = gnrt_validateCode();
			
		if($count == '0')
		{
			$message = "The input email is invalid or email has not been registed before! Please try again! Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='rst_psd.php?hyperlink=home';</script>";
			exit;
		}else
		{
			$query_update = "UPDATE $table_name
							SET
								member_vcode = '$member_vcode'
							WHERE member_email='$usr_email'";
			$query_result = mysql_query($query_update);
			if($query_result)
			{
				echo "<script language='JavaScript'>window.top.location='PHPMailer-master/send_mail_rst_psd.php?member_email=$usr_email&member_first_name=$member_first_name&member_vcode=$member_vcode'</script>";
			}else
			{
				echo ("Failed to create $table_name. DEBUG: .$query_result");
			}
		}
	}else
	{
		$message = "Error! Invalid email! Please try again! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='rst_psd.php?hyperlink=home';</script>";
		exit;
	}
}else if($act=='reset_password')
{
	if(isset($_POST['member_email']))
	{
		$member_email = $_POST['member_email'];
	}
	
	if(isset($_POST['member_first_name']))
	{
		$member_first_name = $_POST['member_first_name'];
	}
	
	if(isset($_POST['member_vcode']))
	{
		$member_vcode = $_POST['member_vcode'];
	}
	
	if(isset($_POST['usr_password']) && $_POST['usr_password']!="")
	{
		$usr_password = mysql_real_escape_string(strip_tags(trim($_POST['usr_password'])));
	}else
	{
		$message = "Please insert password! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='chg_psd.php?hyperlink=home';</script>";
		exit;
	}
	
	if(isset($_POST['cfr_password']) && $_POST['cfr_password']!="")
	{
		$cfr_password = mysql_real_escape_string(strip_tags(trim($_POST['cfr_password'])));
	}else
	{
		$message = "Please insert password! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='chg_psd.php?hyperlink=home';</script>";
		exit;
	}
	
	if(strlen($usr_password) <= 5)
	{
        $message = "ERROR: Password must more than 5 characters.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='chg_psd.php?member_email=$member_email&member_first_name=$member_first_name&member_vcode=$member_vcode';</script>";
        exit;
    }
	
	if($usr_password == $cfr_password)
	{
		$member_password = encrypt($usr_password);
		$query = "UPDATE $table_name
					SET
						member_password = '$member_password'
					WHERE member_email='$member_email' AND member_vcode='$member_vcode'";
		$result = mysql_query($query);
		if($result)
		{
			$message = "Password has been reset succesfully! Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script>window.top.location ='index.php?hyperlink=home';</script>";
		}else
		{
			echo ("Failed to create $table_name. DEBUG: .$query");
		}
	}else
	{
		$message = "Invalid password! Please try again! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='chg_psd.php?hyperlink=home';</script>";
		exit;
	}
}

//http://php.net/manual/en/function.rand.php
// Generate a random character string
function gnrt_validateCode()
{
$length = 49;
$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    // Length of character list
    $chars_length = (strlen($chars) - 1);
    // Start our string
    $string = $chars{rand(0, $chars_length)};
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }
    // Return the string
    return $string;
}
?>