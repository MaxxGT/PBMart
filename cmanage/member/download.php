<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$commercial_id = mysqli_real_escape_string($dbconnect, $_GET['com']);
	$form = "commercial_form".mysqli_real_escape_string($dbconnect, $_GET['form']);
	
	$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_id='$commercial_id'");
	$commercial_display = mysqli_fetch_assoc($commercial);
	$form = $commercial_display[$form];
	$form1 = explode('/', $form);
	
	$dir_name = "../commercial/commercial_form/".$form;
	$content = file_get_contents($dir_name);
	
	header('Content-Type:application/pdf');
	header('Content-length:'.filesize($dir_name));
	header('Content-Disposition:attachment;filename="'.$form1[1].'"');
	readfile($dir_name);
	
?>