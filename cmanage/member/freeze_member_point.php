<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$mem_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);

	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
	$member_status = mysqli_fetch_assoc($member);
	
	if($member_status['member_point_freeze'] == 1){
		$change_status = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point_freeze='0' WHERE member_id='$mem_id'");
	}else{
		$change_status = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_point_freeze='1' WHERE member_id='$mem_id'");
	}
	
	if($change_status){
		header("location:view_member.php?stat=ftrue&hyperlink=members");
	}else{
		header("location:view_member.php?stat=ffalse&hyperlink=members");
	}
?>