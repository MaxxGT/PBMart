<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	include('../../encrypt_decrypt.php');

	$mem_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);
	
	if(isset($_POST['save_member'])){
	
		$firstName = mysqli_real_escape_string($dbconnect, $_POST['first_name']);
		$lastName = mysqli_real_escape_string($dbconnect, $_POST['last_name']);
		$nation = mysqli_real_escape_string($dbconnect, $_POST['nationality']);
		$ic = mysqli_real_escape_string($dbconnect, $_POST['ic']);
		$passport = mysqli_real_escape_string($dbconnect, $_POST['passport']);
		$email = mysqli_real_escape_string($dbconnect, $_POST['email']);
		$contact = mysqli_real_escape_string($dbconnect, $_POST['contact']);
		$token = mysqli_real_escape_string($dbconnect, $_POST['token']);
		//$mobile = mysqli_real_escape_string($dbconnect, $_POST['mobile']);
		$point = mysqli_real_escape_string($dbconnect, $_POST['point']);
		$intro = mysqli_real_escape_string($dbconnect, $_POST['introducer']);
		$streetName = mysqli_real_escape_string($dbconnect, $_POST['street_name']);
		$floor = mysqli_real_escape_string($dbconnect, $_POST['flat_floor']);
		$postcode = mysqli_real_escape_string($dbconnect, $_POST['postcode']);
		$city = mysqli_real_escape_string($dbconnect, $_POST['city']);
		$state = mysqli_real_escape_string($dbconnect, $_POST['state']);
		$country = mysqli_real_escape_string($dbconnect, $_POST['country']);
		$user = mysqli_real_escape_string($dbconnect, $_POST['username']);
		$pass = mysqli_real_escape_string($dbconnect, $_POST['password']);
		$conPass = mysqli_real_escape_string($dbconnect, $_POST['confirm_password']);
		
		if($firstName == "" || $lastName == "" || $streetName == "" || $postcode == "" || $city == "" || $state == "" || $country == "" || $user == ""){
			header("location:edit_member.php?mem=$mem_id&edit=empty&hyperlink=members");
		}else{
			if($ic == ""){
				$ic = "-";
			}else{
				$ic = $ic;
			}
			
			if($passport == ""){
				$passport = "-";
			}else{
				$passport = $passport;
			}
			
			if($email == ""){
				$mail = false;
				$email = "-";
			}else{
				$mem_email = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_email='$email'");
				$email_exist = mysqli_num_rows($mem_email);
				$member_select = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
				$member_se = mysqli_fetch_assoc($member_select);
				if($email_exist){
					if($member_se['member_email'] == $email){
						$mail = false;
					}else{
						$mail = true;
					}
				}else{
					$mail = false;
					$email = $email;
				}
			}
			
			if($user == ""){
				$username = false;
				$user = "-";
			}else{
				$mem_user = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_username='$user'");
				$user_exist = mysqli_num_rows($mem_user);
				$member_selected = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
				$member_sel = mysqli_fetch_assoc($member_selected);
				if($user_exist){
					if($member_sel['member_username'] == $user){
						$username = false;
					}else{
						$username = true;
					}
				}else{
					$username = false;
					$user = $user;
				}
			}
			
			if($contact == ""){
				$contact = "-";
			}else{
				$contact = $contact;
			}
				
			/*if($mobile == ""){
				$mobile = "-";
			}else{
				$mobile = $mobile;
			}*/
			
			if(isset($_POST['flat'])){
				$flat = 1;
			}else{
				$flat = 0;
			}
			
			if($pass == "" && $conPass == ""){
				$pass = "-";
				$pas = false;
			}else{
				if($pass != $conPass){
					$pas = true;
				}else if($pass == $conPass){
					$pas = false;
					$pass = encrypt($pass);
				}
			}
			
			if($mail || $pas || $username){
				if($mail){
					header("location:edit_member.php?mem=$mem_id&edit=mail&hyperlink=members");
				}else if($pas){
					header("location:edit_member.php?mem=$mem_id&pass=false&hyperlink=members");
				}else if($username){
					header("location:edit_member.php?user=false&hyperlink=members");
				}
			}else{
				$edit_member = mysqli_query($dbconnect, "UPDATE pbmart_member SET member_first_name='$firstName', member_last_name='$lastName', member_nationality='$nation', member_ic='$ic', member_passport_number='$passport', member_email='$email', member_contact='$contact', member_street_name='$streetName', member_flat_status='$flat', member_flat_floor='$floor', member_postcode='$postcode', member_city='$city', member_state='$state', member_country='$country', member_password='$pass', member_username='$user', member_point='$point', member_introducer='$intro', member_token='$token' WHERE member_id='$mem_id'");
				
				if($edit_member){
					header("location:edit_member.php?mem=$mem_id&edit=true&hyperlink=members");
				}else{
					header("location:edit_member.php?mem=$mem_id&edit=false&hyperlink=members");
				}
			}
		}
	}
?>