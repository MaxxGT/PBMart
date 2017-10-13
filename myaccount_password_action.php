<?php
// Author: VOONG TZE HOWE
// Date Writen: 07-11-2014
// Description : myaccount password action file
// Last Modification: 07-11-2014

include('session_config.php');
get_UsrInfo();
include('encrypt_decrypt.php');


if(isset($_POST['act']))
{
	$act = $_POST['act'];
}

if($act == "update")
{
	$crt_psd = $_POST['crt_psd'];
	$nw_psd = $_POST['nw_psd'];
	$cm_psd = $_POST['cm_psd'];
	$table_name = "pbmart_member";
	
	input_validate($crt_psd, $nw_psd, $cm_psd);
	
	if(psd_validate($crt_psd, $member_password))
	{
		if(psd_match($nw_psd, $cm_psd))
		{
			$ecpt_psd = encrypt($nw_psd);
			$query = "UPDATE $table_name
				  SET
					 member_password = '$ecpt_psd'
					 WHERE member_id = '$member_id'";
			$result = mysql_query($query);
			if($result)
			{
				$message="Password has been change!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script>window.top.location ='myaccount.php?act=update&hyperlink=myaccount';</script>";
			}else
			{
				
			}
		}else
		{
			$message="Error! Password did not match! Please try again!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script>window.top.location ='myaccount.php?act=update&hyperlink=myaccount';</script>";
		}
	}else
	{
		$message="Error! Invalid password! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.top.location ='myaccount.php?act=update&hyperlink=myaccount';</script>";
	}
}

function input_validate($current_psd, $new_psd, $confirm_psd)
{
	if(empty($current_psd) && empty($new_psd) && empty($current_psd)){
        echo "ERROR: Please fill in password!";
        exit;
    }
	
	if(empty($current_psd) || $current_psd=="" ){
        echo "ERROR: Please fill in current password!";
        exit;
    }
	
	if(empty($new_psd) || $new_psd=="" ){
        echo "ERROR: Please fill in new password!";
        exit;
    }
	
	if(empty($current_psd) || $current_psd=="" ){
        echo "ERROR: Please fill in confirm password!";
        exit;
    }
	
	if(strlen($new_psd) <= 5)
	{
        $message = "ERROR: Password must more than 5 characters.";
		echo "<script type='text/javascript'>alert('$message');</script>";
        exit;
    }
}

function psd_match($new_psd, $confirm_psd)
{
	if($new_psd == $confirm_psd)
	{
		return true;
	}else
	{
		return false;
	}
}

function psd_validate($psd, $mem_psd)
{	
	
	$encrypt_psd = encrypt($psd);
	if($encrypt_psd == $mem_psd)
	{
		return true;
	}else
	{
		return false;
	}
}

?>