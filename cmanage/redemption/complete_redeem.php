<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$redeem_id = mysqli_real_escape_string($dbconnect, $_GET['re']);
	
	$complete_redeem = mysqli_query($dbconnect, "UPDATE pbmart_redemption_list SET redemption_status='1' WHERE redemption_id='$redeem_id'");
	
	header("location:view_redemption_list.php?hyperlink=redemption");
?>