<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();

	include('../../encrypt_decrypt.php');
	
	$user = mysqli_real_escape_string($dbconnect, $_POST['username']);
	$pass = mysqli_real_escape_string($dbconnect, $_POST['password']);
	
	if($user == "" || $pass == ""){
		if($user == "" && $pass == ""){
			header("location:login.php?login=empty");
		}else if($user == ""){
			header("location:login.php?login=user_empty");
		}else if($pass == ""){
			header("location:login.php?login=pass_empty");
		}
	}else{
		if(isset($_POST['login'])){
			$encrypted_pass = encrypt($pass);
			$login = "SELECT * FROM pbmart_admin WHERE username = '".$user."' AND password = '".$encrypted_pass."'";
			$login_empty = "SELECT * FROM pbmart_admin WHERE username ='".$user."'";
			
			$result = mysqli_query($dbconnect, $login);
			$result_empty = mysqli_query($dbconnect, $login_empty);
			
			$count = mysqli_num_rows($result);
			$count1 = mysqli_num_rows($result_empty);
			
			if($count == 1){
				$_SESSION['validation'] = "true";
				header("location:../main.php");
			}else if($count1 == 0){
				header("location:login.php?login=0");
			}else{
				header("location:login.php?login=false");
			}
		}
	}
?>