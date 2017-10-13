<?php
// Author: VOONG TZE HOWE
// Date Writen: ...
// Description : redemption_upd
// Last Modification: ...

// Last Modification: 16-12-2014
// Description: add quantity function


// Last Modification: 17-12-2014
// Description: add redeem_no

// Last Modification: 19-12-2014
// Description: add send mail feature
require_once("connection/pbmartconnection.php");
include('session_config.php');
get_UsrInfo();

if(isset($_REQUEST['act']))
{
	$act = $_REQUEST['act'];
}

if(isset($_REQUEST['redeem_name']))
{
	$redeem_name = $_REQUEST['redeem_name'];
}

if(isset($_REQUEST['redemption_image']))
{
	$redemption_image = $_REQUEST['redemption_image'];
}

if(isset($_REQUEST['product_point']))
{
	$product_point = $_REQUEST['product_point'];
	$available_qty = $member_point/$product_point;
}

if(isset($_REQUEST['redeem_id']))
{
	$redeem_id = $_REQUEST['redeem_id'];
}

if(isset($_REQUEST['redeem_stock']))
{
	$redeem_stock = $_REQUEST['redeem_stock'];
}

if(isset($_REQUEST['qty']))
{
	$qty = $_REQUEST['qty'];
	
	if($qty>=1)
	{
		if($qty > $redeem_stock)
		{
			$message = "Error! Redeemp product is out of stock! Please try again!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script>window.top.location ='redemption.php?hyperlink=redemption';</script>";
			exit;
		}
		
		if($qty > $available_qty)
		{
			$message = "Error! Your point is out of limit! Please try again!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script>window.top.location ='redemption.php?hyperlink=redemption';</script>";
			exit;
		}
	}else
	{
		$message = "Error! Quantity cannot be less than one! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.top.location ='redemption.php?hyperlink=redemption';</script>";
		exit;
	}
}

if($act == 'redeem')
{
	$table_name = "pbmart_redemption_list";
	$redemption_member_name = $_SESSION['usr_name'];
	$redemption_item = $redeem_name + '123';
	
	$redemption_member_address = $member_street_name.", ".$member_postcode.", ".$member_city.", ".$member_state.", ".$member_country;
	
		$redemption = @mysql_query("SELECT MAX(redemption_id) FROM pbmart_redemption_list", $link);
		$redemption_count = @mysql_fetch_row($redemption);
		
		if($redemption_count){
			$redemption_count = $redemption_count[0];
			$redeem_no = "RE0000".$redemption_count;			
		}else{
			$redeem_no = "RE00001";
		}
		
	$sql = "INSERT INTO $table_name(redemption_number, redemption_member_name, redemption_member_address, redemption_item, redemption_image, redemption_amount, redemption_status)
			VALUES ('$redeem_no','$redemption_member_name','$redemption_member_address','$redemption_item','$redemption_image', '$qty', '0')";

	$result = @mysql_query($sql);
	if($result)
	{
		$remain_point = $member_point - ($product_point * $qty);
		
		//update point for member
		$query="UPDATE pbmart_member
					SET
						member_point = '$remain_point'
						WHERE member_id = '$member_id'";
		$result2 = @mysql_query($query);
		
		if(!$result2)
		{
			echo ("Failed to update table. DEBUG: .$query");
		}
		
		$remain_stock = $redeem_stock - $qty;
		//update stock for redeem product
		$query2="UPDATE pbmart_redeem
					SET
						redeem_stock = '$remain_stock'
						WHERE redeem_id = '$redeem_id'";
		$result3 = @mysql_query($query2);
		if(!$result3)
		{
			echo ("Failed to update table. DEBUG: .$query2");
		}
		
		if($result2)
		{
			if($result3)
			{
				echo "<script type='text/javascript'>alert('Thank you for your redeems our product. Please check your email for redeem confirmation.');</script>";
				echo "<script>window.top.location ='PHPMailer-master/send_mail_redemptionConfirmation.php?redeem_no=$redeem_no&qty=$qty&redemption_item=$redemption_item&redemption_point=$product_point';</script>";
			}
		}	
	}else
	{
		echo $sql;
		echo ("Failed to create $table_name record");
	}
}
?>