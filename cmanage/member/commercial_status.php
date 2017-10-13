<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['approve'])){
		$com_id = mysqli_real_escape_string($dbconnect,$_POST['com_id']);
		$mem_id = mysqli_real_escape_string($dbconnect,$_POST['mem_id']);
		$limit = mysqli_real_escape_string($dbconnect, $_POST['prod_limit']);
		$point = mysqli_real_escape_string($dbconnect, $_POST['addi_point']);
		$comclass = mysqli_real_escape_string($dbconnect, $_POST['commercial_class']);
		
		$commercial = mysqli_query($dbconnect, "UPDATE pbmart_commercial SET commercial_prd_limit='$limit', commercial_additional_point='$point' WHERE commercial_id='$com_id'");
		$change_status = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_commercial_status='1', member_commercial_class='$comclass' WHERE member_id='$mem_id'");
		$change_com_status = mysqli_query($dbconnect, "UPDATE pbmart_commercial SET commercial_status='1' WHERE commercial_id='$com_id'");
		
		if($change_status && $change_com_status){
			header("location:view_commercial.php?app=true&hyperlink=members");
		}else{
			header("location:view_commercial.php?app=false&hyperlink=members");
		}
	}else if(isset($_POST['disapprove'])){
		$com_id = mysqli_real_escape_string($dbconnect,$_POST['com_id']);
		$mem_id = mysqli_real_escape_string($dbconnect,$_POST['mem_id']);
		
		$commercial = mysqli_query($dbconnect, "UPDATE pbmart_commercial SET commercial_prd_limit='0', commercial_additional_point='0' WHERE commercial_id='$com_id'");
		$change_status = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_commercial_status='3' WHERE member_id='$mem_id'");
		$change_com_status = mysqli_query($dbconnect, "UPDATE pbmart_commercial SET commercial_status='3' WHERE commercial_id='$com_id'");
		
		if($change_status && $change_com_status){
			header("location:view_commercial.php?app=distrue&hyperlink=members");
		}else{
			header("location:view_commercial.php?app=disfalse&hyperlink=members");
		}
	}
?>