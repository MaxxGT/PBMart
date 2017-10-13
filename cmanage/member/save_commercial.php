<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['edit_commercial'])){
		$com = mysqli_real_escape_string($dbconnect, $_GET['com']);
		
		$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_id='$com'");
		$com_display = mysqli_fetch_assoc($commercial);
		
		$name = mysqli_real_escape_string($dbconnect, $_POST['com_name']);
		$number = mysqli_real_escape_string($dbconnect, $_POST['com_com_number']);
		$phone = mysqli_real_escape_string($dbconnect, $_POST['com_com_phone']);
		$address = mysqli_real_escape_string($dbconnect, $_POST['com_com_address']);
		$postal = mysqli_real_escape_string($dbconnect, $_POST['com_com_postal']);
		$city = mysqli_real_escape_string($dbconnect, $_POST['com_com_city']);
		$state = mysqli_real_escape_string($dbconnect, $_POST['com_com_state']);
		$country = mysqli_real_escape_string($dbconnect, $_POST['com_com_country']);
		$limit = mysqli_real_escape_string($dbconnect, $_POST['prod_limit']);
		$point = mysqli_real_escape_string($dbconnect, $_POST['addi_point']);
		
		$pe_name = mysqli_real_escape_string($dbconnect, $_POST['person_name']);
		$pe_ic = mysqli_real_escape_string($dbconnect, $_POST['person_ic']);
		$pe_position = mysqli_real_escape_string($dbconnect, $_POST['person_position']);
		$pe_phone = mysqli_real_escape_string($dbconnect, $_POST['person_phone']);
		
		if($com == "" || $name == "" || $number == "" || $phone == "" || $address == "" || $postal == "" || $state == "" || $country == "" || $limit == "" || $point == "" || $pe_name == "" || $pe_ic == "" || $pe_position == "" || $pe_phone == ""){
			header("location:edit_member.php?mem=".$com_display['commercial_member_id']."&com=empty&hyperlink=members");
		}else{
			$save_com = mysqli_query($dbconnect, "UPDATE pbmart_commercial SET commercial_company='$name', commercial_company_number='$number', commercial_phone='$phone', commercial_address='$address', commercial_postcode='$postal', commercial_city='$city', commercial_state='$state', commercial_country='$country', commercial_prd_limit='$limit', commercial_additional_point='$point', commercial_person_incharge='$pe_name', commercial_person_ic='$pe_ic', commercial_person_position='$pe_position', commercial_person_phone='$pe_phone' WHERE commercial_id='$com'");
		
			if($save_com){
				header("location:edit_member.php?mem=".$com_display['commercial_member_id']."&com=true&hyperlink=members");
			}else{
				header("location:edit_member.php?mem=".$com_display['commercial_member_id']."&com=false&hyperlink=members");
			}
		}
	}
?>