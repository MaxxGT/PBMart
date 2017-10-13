<?php
// Author: VOONG TZE HOWE
// Date Writen: 11-10-2014
// Description : account login authenticate
// Last Modification: 11-10-2014

require_once("connection/pbmartconnection.php");
include('session_config.php');

include('encrypt_decrypt.php');

$sign = $_POST['sign'];

if(isset($_POST['current_url']))
{
	$current_url = $_POST['current_url'];
}

//sign in
if($sign == "Log In")
{
	//if current session is not empty, then
	if(isset($_SESSION["usr_name"]) && !empty($_SESSION["usr_name"]))
	{
		if($current_url == "account")
		{
			$message = "Please Log Out before another user is log in!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
			exit;
		}
	}

	$email = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['email'])));
	$password = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['password'])));

	if($email == "" || $password == "")
	{
			if($email == "" && $password == "")
			{
				$message="Please enter email and password!";
				echo "<script type='text/javascript'>alert('$message');</script>";
		
				if(isset($_GET['hyperlink']))
				{
					if($_GET['hyperlink']=='account')
					{
						echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
					}
				}
				
			}else if($email == "")
			{
				$message="Please enter email!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				
				if($_GET['hyperlink']=='account')
				{
						echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
				}
				
			}else if($password == ""){
				$message="Please enter password!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				
				if($_GET['hyperlink']=='account')
				{
						echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
				}
			}
		}else
		{
			$member_password = encrypt($password); 
		
			$sql = "Select * FROM pbmart_member WHERE member_email='$email' AND member_password = '$member_password' AND member_status='1'";
			$rw = mysqli_query($dbconnect,$sql);
			$rs = mysqli_fetch_array($rw);
			$first_name = $rs['member_first_name'];
			$last_name = $rs['member_last_name'];
			$member_id = $rs['member_id'];
			
			$usr_name = $first_name.' '.$last_name;
			
			$count = @mysqli_num_rows($rw);
			
			//if user is validate
			if($count != 0)
			{
				$_SESSION['usr_name'] = $usr_name;
				$_SESSION['usr_id'] = $member_id;
			
				
				if($current_url=="account")
				{
					header("location:myaccount.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=myaccount");
				}
				
			}else
			{
				if($current_url=="account")
				{
					$message="Error! Invalid email or password! Please try again!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='account.php?authenticate_value=0&current_url=$current_url&hyperlink=account';</script>";
				}
			}
		}
}

//sign out
if($sign == "Log Out")
{
	//if current sessio is empty, then validate sign out
	if(!isset($_SESSION["usr_name"]))
	{
		if($current_url == "account")
		{
			$message = "Please Log In before another user is log out!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
			exit;
		}
	}else
	{
		if(isset($_SESSION))
		{ 
			if($current_url == "account")
			{
				session_start();
				session_destroy();
				header("location:account.php?hyperlink=account");
			}
		}
	}
}
?>