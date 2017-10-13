<?php

require_once("connection/pbmartconnection.php");
include('encrypt_decrypt.php');

$sign = $_POST['sign'];

if($_POST['current_url']!="")
{
	$current_url = $_POST['current_url'];
}

if($sign == "Sign In")
{

	if(!isset($_SESSION))
	{ 
		session_start(); 
	}
	
	//if current sessio is not empty, then
	if(isset($_SESSION["usr_name"]) && !empty($_SESSION["usr_name"]))
	{
		if($current_url == "index")
		{
			$message = "Please Sign Out before another user is log in!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='index.php';</script>";
			exit;
		}
		
		if($current_url == "myaccount")
		{
			$message = "Please Sign Out before another user is log in!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='myaccount.php';</script>";
			exit;
		}
	}

	$email = $_POST['email'];
	$password = $_POST['password'];

	if($email == "" || $password == ""){
			if($email == "" && $password == ""){
				$message="Please enter email and password!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='myaccount.php';</script>";
			}else if($email == ""){
				$message="Please enter email!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='myaccount.php';</script>";
			}else if($password == ""){
				$message="Please enter password!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='myaccount.php';</script>";
			}
		}else{
			$member_password = encrypt($password); 
		
			$sql = "Select * FROM pbmart_member WHERE member_email='$email' AND member_password = '$member_password' AND member_status='1'";
			$rw = @mysql_query($sql, $link);
			$rs = @mysql_fetch_array($rw);
			$first_name = $rs['member_first_name'];
			$last_name = $rs['member_last_name'];
			$usr_name = $first_name.' '.$last_name;
			
			$count = @mysql_num_rows($rw);
			
			//if user is validate
			if($count != 0)
			{
				$_SESSION['usr_name'] = $usr_name;
				
				if($current_url=="myaccount")
				{
					header("location:myaccount.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url");
				}
				if($current_url == "index")
				{
					header("location:index.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url");
				}
			}else
			{
				if($current_url=="myaccount")
				{
					$message="Error! Invalid email or password! Please try again!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='myaccount.php?authenticate_value=0&current_url=$current_url';</script>";
				}
				if($current_url=="index")
				{
					$message="Error! Invalid email or password! Please try again!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='index.php?authenticate_value=0&current_url=$current_url';</script>";
				}
			}
		}
}
if($sign == "Sign Out")
{
	if(!isset($_SESSION))
	{ 
		if($current_url == "myaccount")
		{
			session_start();
			session_destroy();
			header("location:myaccount.php");
		}
		if($current_url == "index")
		{
			session_start();
			session_destroy();
			header("location:index.php");
		}
	}
}
?>