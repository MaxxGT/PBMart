<?php
// Author: VOONG TZE HOWE
// Date Writen: 06-11-2014
// Description : myaccount action
// Last Modification: 07-11-2014

// Last Modification: 16-12-2014
// Description: Remove billing address feature

include('session_config.php');
get_UsrInfo();

if(isset($_POST['act']))
{
	$act = $_POST['act'];
}

$table_name = "pbmart_member";  
$table_name2 = "pbmart_billing_address";

if($act == 'update')
{
	if(isset($_POST['alp']) && $_POST['alp'] !='')
	{
		$alp = $_POST['alp'];
	}
	if(isset($_POST['introducer']) && $_POST['introducer'] != "")
	{
		$introducer = $_POST['introducer'];
	}else
	{
		$introducer = "";
	}
	
	
	$username = $_POST['username'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$nationality = $_POST['nationality'];

if($member_ic !="-")
{	
	if(isset($_POST['ic_number']))
	{
		$ic_number = $_POST['ic_number'];
	}
	$passport_number = "-";
}else
{
	$ic_number = "-";
	$passport_number = $_POST['passport_number'];
}	


	$user_email = $_POST['user_email'];
	//$tel = $_POST['tel'];
	$mobile = $_POST['mobile'];
	
	if(isset($_POST['flt_dlvy_chk']))
	{
		$flt_dlvy_chk = $_POST['flt_dlvy_chk'];
	}else
	{
		$flt_dlvy_chk = "";
	}
	
	if($flt_dlvy_chk =='on')
	{
		$member_flat_status = '1';
	}else
	{
		$member_flat_status = '0';
	}

	$street_name = $_POST['street_name'];	
	if(isset($_POST['flr_num']))
	{
		$flr_num = $_POST['flr_num'];
	}else
	{
		$flr_num = "";
	}

	$city = $_POST['city'];
	$region_state = $_POST['region_state'];
	$country = $_POST['country'];
	$pst_code = $_POST['pst_code'];
	
	
	//if billing address checkbox is checked, then...
	if(isset($_POST['bil_add_chk']))
	{
		$house_no2 = $_POST['house_no2'];
		$street_name2 = $_POST['street_name2'];
		$city2 = $_POST['city2'];
		$region_state2 = $_POST['region_state2'];
		$pst_code2 = $_POST['pst_code2'];
		$country2 = $_POST['country2'];
	}else
	{
		$house_no2 = "";
		$street_name2 = "";
		$city2 = "";
		$region_state2 = "";
		$pst_code2 = "";
		$country2 = "";
	}

	form_validate($username, $first_name, $last_name, $member_ic, $ic_number, $nationality, $passport_number, $user_email, $mobile, $street_name, $city, $region_state, $pst_code, $country);
	$checkforUsername = @mysql_query("SELECT * FROM pbmart_member WHERE member_username ='$username' AND member_id !='$member_id' AND member_number !='$member_number'");
	$checkforEmail = @mysql_query("Select * From pbmart_member WHERE member_email ='$user_email' AND member_id !='$member_id' AND member_number !='$member_number'");
	
	if(@mysql_num_rows($checkforUsername) != 0)
	{
		$message = "ERROR: Registered username is invalid! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
		exit;
	}else if(@mysql_num_rows($checkforEmail) != 0)
    {
		$message = "ERROR: Registered email is invalid! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
		exit;
    }else
	{
		$query="UPDATE $table_name 
				SET
					member_introducer = '$introducer',
					member_username = '$username',
					member_first_name = '$first_name',
					member_last_name = '$last_name',
					member_nationality = '$nationality',
					member_ic = '$ic_number',
					member_passport_number = '$passport_number',
					
					member_email = '$user_email',
					member_contact = '$mobile',
					
					member_street_name = '$street_name',
					member_flat_status = '$member_flat_status',
					member_flat_floor = '$flr_num',
					member_postcode = '$pst_code',
					member_city = '$city',
					member_state = '$region_state',
					member_country = '$country'

				WHERE member_id = '$member_id'";

			   $result = @mysql_query($query);
				if($result)
				{
					echo "<script>window.top.location ='myaccount.php?act=update&hyperlink=myaccount';</script>";
				
				}else{
					echo ("Failed to create $table_name. DEBUG: .$query");
				}
	}
}			

function form_validate($usernames, $first_names, $last_names, $ic_number, $nationality, $passport_number, $user_emails, $mobiles, $street_names, $citys, $region_states, $pst_codes, $countrys)
{     

	if(empty($usernames) || $usernames=="" )
	{
        $message = "ERROR: Please enter username.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
		exit;
    }
	
	if(empty($first_names) || $first_names=="" )
	{
        $message = "ERROR: Please enter first name.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
		exit;
    }
	if(empty($last_names) || $last_names=="" ){
        $message = "ERROR: Please enter last name.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }

	if($ic_number!="-")
	{
		if(empty($ic_number) || $ic_number=="" ){
        $message = "ERROR: Please enter your IC Number.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
		}
		
		if(strlen($ic_number) != '14'){
        $message = "ERROR: Invalid IC Number. Exapmple: 123456-12-1234";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
		}
	
		if(!preg_match('/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/', $ic_number))
		{
			$message = "ERROR: Invalid IC Number. Exapmple: 123456-12-1234";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
			exit;
		}
}else
{
	if(empty($nationality) || $nationality=="" ){
        $message = "ERROR: Please enter your Nationality.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	
	// if(empty($passport_number) || $passport_number=="" ){
        // $message = "1ERROR: Please enter your Passport Number.";
		// echo "<script type='text/javascript'>alert('$message');</script>";
		// echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        // exit;
    // }
}

	if(empty($user_emails) || $user_emails=="" ){
        $message = "ERROR: Please enter email.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	
	// if(!filter_var($user_emails, FILTER_VALIDATE_EMAIL))
	// {
        // $message = "ERROR: Invalid email format. Please try again!";
		// echo "<script type='text/javascript'>alert('$message');</script>";
		// echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        // exit;
    // }
	
	//if(empty($tels) || $tels=="" ){
    //   $message = "ERROR: Please enter telephone number.";
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
    //   exit;
    //}
	//if(strlen($tels) !=9) {
    //   $message = "ERROR: Invalid telephone number. Example: 082123456";
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
    //   exit;
    //}
	
	if(empty($mobiles) || $mobiles=="" ){
      $message = "ERROR: Please enter contact number.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
       exit;
    }
	
	if(strlen($mobiles) < 9 ) {
       $message = "ERROR: Invalid contact number. Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
       exit;
    }
	
	if(empty($street_names) || $street_names=="" ){
        $message = "ERROR: Please enter your street name.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($citys) || $citys=="" ){
        $message = "ERROR: Please select city.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($region_states) || $region_states=="" ){
        $message = "ERROR: Please select region state.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($pst_codes) || $pst_codes=="" ){
        $message = "ERROR: Please enter post code.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($countrys) || $countrys=="" ){
        $message = "ERROR: Please select country.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
}

function form_validate2($member_house_no2s, $member_street_name2s, $member_city2s, $member_region_state2s, $member_pst_code2s, $member_country2s)
{
	if(empty($member_house_no2s) || $member_house_no2s=="" ){
        $message = "ERROR: Please key in house number.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($member_street_name2s) || $member_street_name2s=="" ){
        $message = "ERROR: Please key in street name.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($member_city2s) || $member_city2s=="" ){
        $message = "ERROR: Please select city.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($member_region_state2s) || $member_region_state2s=="" ){
        $message = "ERROR: Please select state.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($member_pst_code2s) || $member_pst_code2s=="" ){
        $message = "ERROR: Please select post code.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
	if(empty($member_country2s) || $member_country2s=="" ){
        $message = "ERROR: Please select country.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?act=edit&hyperlink=myaccount';</script>";
        exit;
    }
}
?>
