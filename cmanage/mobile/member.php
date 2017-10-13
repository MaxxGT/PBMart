<?php
	require_once("pbmartconnection.php");
	session_start();
	
         //$username="hashan000@gmail.com";
	$username = $_POST['username']; 
	$sql = "SELECT * FROM pbmart_member WHERE member_email='$username'";
	$member = @mysqli_query($dbconnect, $sql);
	$rs = @mysqli_fetch_array($member);
	
	$member_id = $rs['member_id'];
	$member_first_name = $rs['member_first_name'];
	$member_last_name = $rs['member_last_name'];
	$member_email = $rs['member_email'];
	$member_telephone = $rs['member_telephone'];
	$member_mobile = $rs['member_mobile'];
	$member_house_no = $rs['member_house_no'];
	$member_street_name = $rs['member_street_name'];
	$member_postcode = $rs['member_postcode'];
	$member_city = $rs['member_city'];
	$member_state = $rs['member_state'];
	$member_country = $rs['member_country'];
	$member_point = $rs['member_point'];
	
	
	
	echo "Name".' : '. $member_first_name.' '.$member_last_name."\n";
	echo "Email".' : '.$member_email."\n";
	echo "Telephone Number".' : '.$member_telephone."\n";
	echo "Mobile Number".' : '.$member_mobile."\n";
	echo "Address".' : '.$member_house_no.' , '.$member_street_name.' , '.$member_city.' , '.$member_state.' , '.$member_country."\n";
	echo "Postcode".' : '.$member_postcode."\n";
	echo "Member Points".' : '.$member_point."\n";
	

	//echo $member_postcode.<'br/'>;

	//echo $member_point.<'br/'>;
	
?>