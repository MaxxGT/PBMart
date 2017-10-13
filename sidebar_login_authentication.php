<?php
// Author: VOONG TZE HOWE
// Date Writen: 10-10-2014
// Description : sidebar login authenticate
// Last Modification: 11-10-2014

require_once("connection/pbmartconnection.php");
include('session_config.php');
include('encrypt_decrypt.php');

$sign = $_POST['sign'];

if($_POST['current_url']!="")
{
	$current_url = $_POST['current_url'];
}

if($sign == "Log In")
{
	//if current session is not empty, then
	if(isset($_SESSION["usr_name"]) && !empty($_SESSION["usr_name"]))
	{
		if(isset($_GET['hyperlink']))
		{
			if($_GET['hyperlink']=='home')
			{
				$message = "Please Log Out before another user is log in!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
				exit;
			}
			
			if($_REQUEST['hyperlink']=='promotion')
			{	
				$message = "Please login to make order! Thanks!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='promotions_index.php?hyperlink=promotion';</script>";
			}
			
			if($_GET['hyperlink']=='product')
			{
				$message = "Please Log Out before another user is log in!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
				exit;
			}
			
			if($_GET['hyperlink']=='account')
			{
				$message = "Please Log Out before another user is log in!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=maccount';</script>";
				exit;
			}
					
			if($_GET['hyperlink']=='myaccount')
			{
				$message = "Please Log Out before another user is log in!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='myaccount.php?hyperlink=maccount';</script>";
				exit;
			}
			
			if($_GET['hyperlink']=='contact')
			{
				$message = "Please Log Out before another user is log in!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='contact.php?hyperlink=contact';</script>";
				exit;
			}
		}
	}

	$email = mysql_real_escape_string(strip_tags(trim($_POST['email'])));
	$password = mysql_real_escape_string(strip_tags(trim($_POST['password'])));
	
	if($email == "" || $password == "")
	{
			if($email == "" && $password == "")
			{
				$message="Error! Please enter email and password!";
				echo "<script type='text/javascript'>alert('$message');</script>";
		
				if(isset($_GET['hyperlink']))
				{
					if($_GET['hyperlink']=='home')
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
					}else if($_GET['hyperlink']=='promotion')
					{
						echo "<script language='JavaScript'>window.top.location ='promotions_index.php?hyperlink=promotion';</script>";
					}else if($_GET['hyperlink']=='product')
					{
						echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
					}else if($_GET['hyperlink']=='redemption')
					{
						echo "<script language='JavaScript'>window.top.location ='redemption.php?hyperlink=redemption';</script>";
					}else if($_GET['hyperlink']=='myaccount')
					{
						echo "<script language='JavaScript'>window.top.location ='myaccount.php?hyperlink=myaccount';</script>";
					}else if($_GET['hyperlink']=='account')
					{
						echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
					}else if($_GET['hyperlink']=='contact')
					{
						echo "<script language='JavaScript'>window.top.location ='contact.php?hyperlink=contact';</script>";
					}else
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
					}
				}
				
			}else if($email == "")
			{
				$message="Error! Please enter email!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				
				if(isset($_GET['hyperlink']))
				{
					if($_GET['hyperlink']=='home')
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
					}else if($_GET['hyperlink']=='promotion')
					{
						echo "<script language='JavaScript'>window.top.location ='promotions_index.php?hyperlink=promotion';</script>";
					}else if($_GET['hyperlink']=='product')
					{
						echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
					}else if($_GET['hyperlink']=='redemption')
					{
						echo "<script language='JavaScript'>window.top.location ='redemption.php?hyperlink=redemption';</script>";
					}else if($_GET['hyperlink']=='myaccount')
					{
						echo "<script language='JavaScript'>window.top.location ='myaccount.php?hyperlink=myaccount';</script>";
					}else if($_GET['hyperlink']=='account')
					{
						echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
					}else if($_GET['hyperlink']=='contact')
					{
						echo "<script language='JavaScript'>window.top.location ='contact.php?hyperlink=contact';</script>";
					}else
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
					}
				}
				
			}else if($password == "")
			{
				$message="Please enter password!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				
				if(isset($_GET['hyperlink']))
				{
					if($_GET['hyperlink']=='home')
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
					}else if($_GET['hyperlink']=='promotion')
					{
						echo "<script language='JavaScript'>window.top.location ='promotions_index.php?hyperlink=promotion';</script>";
					}else if($_GET['hyperlink']=='product')
					{
						echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
					}else if($_GET['hyperlink']=='redemption')
					{
						echo "<script language='JavaScript'>window.top.location ='redemption.php?hyperlink=redemption';</script>";
					}else if($_GET['hyperlink']=='myaccount')
					{
						echo "<script language='JavaScript'>window.top.location ='myaccount.php?hyperlink=myaccount';</script>";
					}else if($_GET['hyperlink']=='account')
					{
						echo "<script language='JavaScript'>window.top.location ='account.php?hyperlink=account';</script>";
					}else if($_GET['hyperlink']=='contact')
					{
						echo "<script language='JavaScript'>window.top.location ='contact.php?hyperlink=contact';</script>";
					}else
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
					}
				}
			}
	}else{
			$member_password = encrypt($password); 
		
			$sql = "Select * FROM pbmart_member WHERE member_email='$email' AND member_password = '$member_password' AND member_status='1'";
			$rw = @mysql_query($sql, $link);
			$rs = @mysql_fetch_array($rw);
			$first_name = $rs['member_first_name'];
			$last_name = $rs['member_last_name'];
			$member_id = $rs['member_id'];
			
			$usr_name = $first_name.' '.$last_name;
			//$usr_name = $last_name.' '.$first_name;
			
			$count = @mysql_num_rows($rw);
			
			//if user is validate, then...
			if($count != 0)
			{
				$_SESSION['usr_name'] = $usr_name;
				$_SESSION['usr_id'] = $member_id;
				
					if(isset($_GET['hyperlink']))
					{
						if($_GET['hyperlink']=='home')
						{
							header("location:index.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=home");
						}else if($_GET['hyperlink']=='promotion')
						{
							header("location:promotions_index.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=promotion");
						}
						else if($_GET['hyperlink']=='product')
						{
							header("location:products.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=product");
						}else if($_GET['hyperlink']=='redemption')
						{
							header("location:redemption.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=redemption");
						}else if($_GET['hyperlink']=='account')
						{
							header("location:myaccount.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=myaccount");
						}else if($_GET['hyperlink']=='contact')
						{
							header("location:contact.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=contact");
						}else
						{
							header("location:index.php?authenticate_value=1&usr_name=$usr_name&current_url=$current_url&hyperlink=home");
						}
					}
			}else
			{
					if(isset($_GET['hyperlink']))
					{
						if($_GET['hyperlink']=='home')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='index.php?authenticate_value=0&current_url=$current_url&hyperlink=home';</script>";
						}else if($_GET['hyperlink']=='promotion')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='promotions_index.php?authenticate_value=0&current_url=$current_url&hyperlink=promotion';</script>";
						}else if($_GET['hyperlink']=='product')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='products.php?authenticate_value=0&current_url=$current_url&hyperlink=product';</script>";
						}else if($_GET['hyperlink']=='redemption')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='redemption.php?authenticate_value=0&current_url=$current_url&hyperlink=redemption';</script>";
						}else if($_GET['hyperlink']=='account')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='account.php?authenticate_value=0&current_url=$current_url&hyperlink=account';</script>";
						}else if($_GET['hyperlink']=='myaccount')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='myaccount.php?authenticate_value=0&current_url=$current_url&hyperlink=myaccount';</script>";
						}else if($_GET['hyperlink']=='contact')
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='contact.php?authenticate_value=0&current_url=$current_url&hyperlink=contact';</script>";
						}else
						{
							$message="Error! Invalid email or password! Please try again!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='index.php?authenticate_value=0&current_url=$current_url&hyperlink=home';</script>";
						}
					}
			}
		}
}

//log out
if($sign == "Log Out")
{
		//if current sessio is started, then validate sign out
		if(!isset($_SESSION['usr_name']))
		{
				if(isset($_GET['hyperlink']))
				{
					if($_GET['hyperlink']=='home')
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
						exit;
					}else if($_GET['hyperlink']=='promotion')
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='promotions_index.php?hyperlink=promotion';</script>";
						exit;
					}else if($_GET['hyperlink']=='product')
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
						exit;
					}else if($_GET['hyperlink']=='redemption')
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='redemption.php?hyperlink=redemption';</script>";
						exit;
					}else if($_GET['hyperlink']=='myaccount')
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='myaccount.php?hyperlink=myaccount';</script>";
						exit;
					}else if($_GET['hyperlink']=='contact')
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='contact.php?hyperlink=contact';</script>";
						exit;
					}else
					{
						$message = "Please Log In before another user is log out!";
						echo "<script type='text/javascript'>alert('$message');</script>";
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
						exit;
					}
				}	
		}else
		{
			if(isset($_GET['hyperlink']))
			{
				if($_GET['hyperlink']=='home')
				{
					session_start();
					session_destroy();
					header("location:index.php?hyperlink=home");
				}else if($_GET['hyperlink']=='promotion')
				{
					session_start();
					session_destroy();
					header("location:promotions_index.php?hyperlink=promotion");
				}else if($_GET['hyperlink']=='product')
				{
					session_start();
					session_destroy();
					header("location:products.php?hyperlink=product");
				}else if($_GET['hyperlink']=='redemption')
				{
					session_start();
					session_destroy();
					header("location:redemption.php?hyperlink=redemption");
				}else if($_GET['hyperlink']=='account')
				{
					session_start();
					session_destroy();
					header("location:account.php?hyperlink=account");
				}else if($_GET['hyperlink']=='myaccount')
				{
					session_start();
					session_destroy();
					header("location:account.php?hyperlink=account");
				}else if($_GET['hyperlink']=='contact')
				{
					session_start();
					session_destroy();
					header("location:contact.php?hyperlink=contact");
				}else
				{
					session_start();
					session_destroy();
					header("location:index.php?hyperlink=home");
				}
			}
		}
}
?>