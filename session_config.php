<?php
// Author: VOONG TZE HOWE
// Date Writen: 21-10-2014
// Description : session configuration
// Last Modification:
if(!isset($_SESSION)) 
{ 
	session_start();
}else
{
	
}

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

function get_UsrInfo()
{
	include("connection/pbmartconnection.php");
	
	if(isset($_SESSION['usr_id']))
	{
		$usr_id = $_SESSION['usr_id'];
	}else
	{
		$usr_id = '';
	}
	
	$sql = "SELECT * FROM pbmart_member WHERE member_id ='$usr_id'";
	$rs = mysqli_query($dbconnect, $sql);
	$rw = mysqli_fetch_array($rs);
	
	$GLOBALS['member_number'] = $rw['member_number'];
	$GLOBALS['member_id'] = $rw['member_id'];
	$GLOBALS['member_introducer'] = $rw['member_introducer'];
	$GLOBALS['member_username'] = $rw['member_username'];
	$GLOBALS['member_first_name'] = $rw['member_first_name'];
	$GLOBALS['member_last_name'] = $rw['member_last_name'];
	$GLOBALS['member_nationality'] = $rw['member_nationality'];
	$GLOBALS['member_ic'] = $rw['member_ic'];
	$GLOBALS['member_passport_number'] = $rw['member_passport_number'];
	$GLOBALS['member_email'] = $rw['member_email'];
	$GLOBALS['member_telephone'] = $rw['member_telephone'];
	$GLOBALS['member_contact'] = $rw['member_contact'];
	$GLOBALS['member_street_name'] = $rw['member_street_name'];
	$GLOBALS['member_flat_status'] = $rw['member_flat_status'];
	$GLOBALS['member_flat_floor'] = $rw['member_flat_floor'];
	
	$GLOBALS['member_postcode'] = $rw['member_postcode'];
	$GLOBALS['member_city'] = $rw['member_city'];
	$GLOBALS['member_state'] = $rw['member_state'];
	$GLOBALS['member_country'] = $rw['member_country'];
	$GLOBALS['member_password'] = $rw['member_password'];
	
	
	$GLOBALS['member_point'] = $rw['member_point'];
	$GLOBALS['member_point_freeze'] = $rw['member_point_freeze'];
	$GLOBALS['member_token'] = $rw['member_token'];
	$GLOBALS['member_regis_date'] = $rw['member_regis_date'];
	$GLOBALS['member_status'] = $rw['member_status'];
	$GLOBALS['member_commercial_status'] = $rw['member_commercial_status'];
	$GLOBALS['member_commercial_class'] = $rw['member_commercial_class'];
	
	$sql_commercial = "SELECT * FROM pbmart_commercial WHERE commercial_member_id ='$usr_id'";
	$rs_bil = @mysql_query($sql_commercial, $link);
	$rw_bil = @mysql_fetch_array($rs_bil);
	
	$GLOBALS['commercial_number'] = $rw_bil['commercial_number'];
	$GLOBALS['commercial_status'] = $rw_bil['commercial_status'];
	$GLOBALS['commercial_prd_limit'] = $rw_bil['commercial_prd_limit'];
	$GLOBALS['commercial_additional_point'] = $rw_bil['commercial_additional_point'];
	
	if(!isset($member_first_name))
	{
		$member_first_name = "";
	}
}

function isLogged()
{
		if(isset($_SESSION)) 
		{ 
			if(isset($_SESSION['usr_name']))
			{
				return true;
			}else
			{
				return false;
			}
		}
}

function sessionX()
{
		if(isset($_SESSION) && isset($_SESSION['usr_name'])) 
		{ 
			$logLength = 900; # time in seconds :: 1800 = 30 minutes 
			$ctime = strtotime("now"); # Create a time from a string 
			# If no session time is created, create one 
			if(!isset($_SESSION['sessionX'])){  
				# create session time 
				$_SESSION['sessionX'] = $ctime;
				
			}else{
				
				# Check if they have exceded the time limit of inactivity 
				if(((strtotime("now") - $_SESSION['sessionX']) > $logLength && isLogged())){				
					# If exceded the time, log the user out 
					# Redirect to login page to log back in 
					//header("Location:index.php"); 
					
					session_unset();
					session_destroy();
					
					$message = "Warning: User Account has been logout due to in-active! Please login again! Thanks!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
				}else{ 
					# If they have not exceded the time limit of inactivity, keep them logged in 
					$_SESSION['sessionX'] = $ctime;
				} 
			} 
		}
}

function clear_session()
{
	unset($_SESSION['order_qty']);
	unset($_SESSION['product_id']);
	unset($_SESSION['product_qty']);
	
	unset($_SESSION['redeem_order_qty']);
	unset($_SESSION['redeem_id']);
	unset($_SESSION['redeem_qty']);
}
//echo ('Login User:'.$_SESSION['usr_name'].'<BR>');
//echo ('Product id:'.$_SESSION['product_id'].'<BR>');
//echo ('Product qty:'.$_SESSION['product_qty'].'<BR>');
//echo ('Product count:'.$_SESSION['product_count'].'<BR>');
?>