<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	include('../../encrypt_decrypt.php');
	
	if(isset($_POST['create_salesman'])){
	
		$name = mysqli_real_escape_string($dbconnect, $_POST['name']);
		$email = mysqli_real_escape_string($dbconnect, $_POST['email']);
		$contact = mysqli_real_escape_string($dbconnect, $_POST['contact']);
		
		if($name == ""){
			header("location:add_salesman.php?create=empty&hyperlink=members");
		}else{
			if($email == ""){
				$mail = false;
				$email = "-";
			}else{
				$mem_email = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_email='$email'");
				$email_exist = mysqli_num_rows($mem_email);
				if($email_exist){
					$mail = true;
				}else{
					$mail = false;
					$email = $email;
				}
			}
				
				
				$create_salesman = mysqli_query($dbconnect, "INSERT INTO pbmart_salesman(salesman_name) VALUES ('$name')");
						
				if($create_salesman){
					header("location:add_salesman.php?create=true&hyperlink=salesmans");
				}else{
					header("location:add_salesman.php?create=false&hyperlink=salesmans");
				}
			}
		}
?>