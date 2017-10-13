<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$admin = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin WHERE id='1'");
	$admin_display = mysqli_fetch_assoc($admin);
	
	include('../../encrypt_decrypt.php');
	
	$username = mysqli_real_escape_string($dbconnect, $_POST['new_username']);
	$pass = mysqli_real_escape_string($dbconnect, $_POST['new_pass']);
	
	$pass = encrypt($pass);
	
	$changepass = mysqli_query($dbconnect, "UPDATE pbmart_admin SET username='$username', password='$pass' WHERE id='1'");
	
	if($changepass){
		header("location:change.php?cha=true&hyperlink=main");
	}else{
		header("location:change.php?cha=false&hyperlink=main");
	}
?>