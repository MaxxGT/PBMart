<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$order_number = mysqli_real_escape_string($dbconnect, $_POST['order_numbering']);
	$complete_date = mysqli_real_escape_string($dbconnect, $_POST['complete_date']);
	$remark = mysqli_real_escape_string($dbconnect, $_POST['remarks']);
	
	$completion_date = mysqli_query($dbconnect, "UPDATE pbmart_order SET order_complete_date='$complete_date', order_remark='$remark' WHERE order_number='$order_number'");
	
	if($completion_date){
		header("location:view_orderList.php?or=".$order_number."&view=his&hyperlink=orders&comp=true");
	}else{
		header("location:view_orderList.php?or=".$order_number."&view=his&hyperlink=orders&comp=false");
	}
?>