<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	include('../../encrypt_decrypt.php');
	
	if(isset($_POST['create_member'])){
	
		$firstName = mysqli_real_escape_string($dbconnect, $_POST['first_name']);
		$lastName = mysqli_real_escape_string($dbconnect, $_POST['last_name']);
		$nation = mysqli_real_escape_string($dbconnect, $_POST['nationality']);
		$ic = mysqli_real_escape_string($dbconnect, $_POST['ic']);
		$passport = mysqli_real_escape_string($dbconnect, $_POST['passport']);
		$email = mysqli_real_escape_string($dbconnect, $_POST['email']);
		$contact = mysqli_real_escape_string($dbconnect, $_POST['contact']);
		//$mobile = mysqli_real_escape_string($dbconnect, $_POST['mobile']);
		$streetName = mysqli_real_escape_string($dbconnect, $_POST['street_name']);
		$floor = mysqli_real_escape_string($dbconnect, $_POST['flat_floor']);
		$postcode = mysqli_real_escape_string($dbconnect, $_POST['postcode']);
		$city = mysqli_real_escape_string($dbconnect, $_POST['city']);
		$state = mysqli_real_escape_string($dbconnect, $_POST['state']);
		$country = mysqli_real_escape_string($dbconnect, $_POST['country']);
		$user = mysqli_real_escape_string($dbconnect, $_POST['username']);
		$pass = mysqli_real_escape_string($dbconnect, $_POST['password']);
		$conPass = mysqli_real_escape_string($dbconnect, $_POST['confirm_password']);
		$intro = mysqli_real_escape_string($dbconnect, $_POST['introducer']);
		
		if($firstName == "" || $lastName == "" || $nation == "" || $streetName == "" || $postcode == "" || $city == "" || $state == "" || $country == "" || $user == ""){
			header("location:add_member.php?create=empty&hyperlink=members");
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
				if($email_exist){
					$mail = true;
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
				if($user_exist){
					$username = true;
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
					header("location:add_member.php?create=mail&hyperlink=members");
				}else if($pas){
					header("location:add_member.php?pass=false&hyperlink=members");
				}else if($username){
					header("location:add_member.php?user=false&hyperlink=members");
				}
			}else{
				$alpha = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
				
				$number = mysqli_query($dbconnect, "SELECT MAX(member_id) FROM pbmart_member");
				$num_row = mysqli_fetch_row($number);
				$num_rows = mysqli_num_rows($number);
				
				if($num_row){
					$member_check = mysqli_query($dbconnect, "SELECT * FROM pbmart_member ORDER BY member_id DESC LIMIT 1");
					$member_dis = mysqli_fetch_assoc($member_check);
					
					$checking = substr($member_dis['member_number'],7,1);
					$mem_no = substr($member_dis['member_number'],2,4);
					
					for($i=0; $i<26; $i++){
						if($alpha[$i] == $checking){
							if($mem_no >= 9999){
								$member_number = "PB0000/".$alpha[$i+1];
							}else{
								$mem_no = $mem_no +1;
								if($mem_no < 10){
									$member_number = "PB000".$mem_no."/".$alpha[$i];
								}else if($mem_no >= 10 && $mem_no < 100){
									$member_number = "PB00".$mem_no."/".$alpha[$i];
								}else if($mem_no >= 100 && $mem_no < 1000){
									$member_number = "PB0".$mem_no."/".$alpha[$i];
								}else if($mem_no >= 1000 && $mem_no < 10000){
									$member_number = "PB".$mem_no."/".$alpha[$i];
								}
							}
						}else if($checking == ""){
							$member_number = "PB0000/".$alpha[0];
						}
					}
				}else{
					$member_number = "PB0000/".$alpha[0];
				}
				
				if(isset($_POST['flat'])){
					$flat = 1;
				}else{
					$flat = 0;
				}
				
				$date = date("Y-m-d");
				$time = time();
				
				$create_member = mysqli_query($dbconnect, "INSERT INTO pbmart_member(member_number, member_first_name, member_last_name, member_nationality, member_ic, member_passport_number, member_email, member_contact, member_street_name, member_flat_status, member_flat_floor, member_postcode, member_city, member_state, member_country, member_username, member_password, member_point, member_point_freeze, member_regis_date, member_regis_time, member_status, member_introducer, member_introducer_status) VALUES ('$member_number', '$firstName', '$lastName', '$nation', '$ic', '$passport', '$email', '$contact', '$streetName', '$flat', '$floor', '$postcode', '$city', '$state', '$country', '$user', '$pass', '0', '0', '$date', '$time', '1', '$intro', '0')");
						
				if($create_member){
					header("location:add_member.php?create=true&hyperlink=members");
				}else{
					header("location:add_member.php?create=false&hyperlink=members");
				}
			}
		}
	}
?>