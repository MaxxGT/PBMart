<?php 
// Author: VOONG TZE HOWE
// Date Writen: ...
// Description : myaccount.php

// Last Modification: 16-12-2014
// Description: Remove billing address feature
// Description: add new password validation(input password must more than 5 characters)

require_once("connection/pbmartconnection.php");
include('serverDateTime.php');
include('encrypt_decrypt.php');

$act = $_REQUEST['act'];
$table_name = "pbmart_member";
$table_name2 = "pbmart_billing_address";

if($act == 'add')
{	
	if(isset($_POST['introducer']) && $_POST['introducer'] !="")
	{
		$introducer = mysql_real_escape_string(strip_tags(trim($_POST['introducer'])));
	}else
	{
		$introducer = "";
	}
	$introducer_status = '0';
	$username =  mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['username'])));
	$first_name = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['first_name'])));
	$first_name = ucwords($first_name);
	$last_name = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['last_name'])));
	$last_name = ucwords($last_name);
	
	if(isset($_POST['nationality']) && $_POST['nationality'] !="")
	{
		$nationality = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['nationality'])));
	}else
	{
		$nationality = "Malaysian";
	}
	
	
	if(isset($_POST['International_chk']))
	{
		$International_chk = $_POST['International_chk'];
	}else
	{
		$International_chk = "";
	}

	if($International_chk == 'on')
	{
		$ic_number = "";
		$passport_number = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['passport_number'])));
	}else
	{
		$ic_number = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['ic_number'])));
		$passport_number = "";
	}
	
	if(isset($_POST['flt_dlvy_chk']))
	{
		$flt_dlvy_chk = $_POST['flt_dlvy_chk'];
		
		if($flt_dlvy_chk == 'on')
		{
			$flr_status = "1";
			$flr_num = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['flr_num'])));
		}else
		{
			$flr_status = "0";
			$flr_num ="0";
		}
	}else
	{
		$flr_status = "0";
		$flr_num ="0";
		$flt_dlvy_chk = "";
	}
	
	$user_email = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['user_email'])));
	//$tel = mysql_real_escape_string(strip_tags(trim($_POST['tel'])));
	$mobile = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['mobile'])));
	$addr2 = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['addr2'])));
	$addr2 = ucwords($addr2);
	$city = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['city'])));
	$region_state = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['region_state'])));
	$pst_code = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['pst_code'])));
	$country = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['country'])));
	$user_psd = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['user_psd'])));
	$user_psd2 = mysqli_real_escape_string($dbconnect,strip_tags(trim($_POST['user_psd2'])));
	$member_password = encrypt($user_psd);
	
	$cst_point = "0";
	$usr_regDate = get_currentDate();
	$usr_regTime = get_currentTime();
	$status	= "0";
	$usr_vcode = gnrt_validateCode();
	
    form_validate($username, $first_name, $last_name, $user_email, $mobile, $addr2, $city, $region_state, $pst_code, $country, $user_psd, $user_psd2);
	
	if($International_chk !='on')
	{
		$checkforIC = @mysqli_query($dbconnect,"Select member_ic From pbmart_member WHERE member_ic ='$ic_number'", $link);
	}
	
	$checkforEmail = @mysqli_query($dbconnect,"Select * From pbmart_member WHERE member_email ='$user_email'", $link);
	$checkforUsername = @mysqli_query($dbconnect,"SELECT * FROM pbmart_member WHERE member_username = '$username'", $link);
	
	if(@mysqli_num_rows($checkforUsername) != 0)
    {
		$message = "ERROR: Registered username is invalid! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
		exit;
    }
	
	if($International_chk !='on')
	{
		if(@mysqli_num_rows($checkforIC) != 0)
		{
			$message = "ERROR: Registered IC number is invalid! Please try again!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
			exit;
		}
	}
	
	if(@mysqli_num_rows($checkforEmail) != 0)
    {
		$message = "ERROR: Registered email is invalid! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
		exit;
    }else
	{
		$year = "".date("Y");
		$mem_num = substr($year,2,4);
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
				$member_number_do = gnrt_domestic_number();

    	$sql = "INSERT INTO $table_name (member_number, member_introducer, member_introducer_status, member_username, member_first_name, member_last_name, member_nationality, member_ic, member_passport_number, member_email, member_contact, member_street_name, member_flat_status, member_flat_floor, member_city, member_state, member_postcode, member_country, member_password, member_point, member_regis_date, member_regis_time, member_status, member_vcode)
                VALUES ('$member_number_do', '$introducer', '$introducer_status', '$username', '$first_name', '$last_name', '$nationality', '$ic_number', '$passport_number', '$user_email','$mobile','$addr2','$flr_status','$flr_num','$city','$region_state','$pst_code','$country','$member_password','$cst_point','$usr_regDate','$usr_regTime','$status','$usr_vcode')";

    	$result = @mysqli_query($dbconnect,$sql);    

    	if($result)
		{
			//check usr_id
			$sql_usr_id = "Select * FROM pbmart_member WHERE member_first_name='$first_name' AND member_last_name='$last_name' AND member_email='$user_email'";
			$rw = @mysqli_query($dbconnect,$sql_usr_id);
			$rs = @mysqli_fetch_array($rw);
			$usr_id = $rs['member_id'];
			echo "<script type='text/javascript'>alert('Thank you for registering! An email has been send to your mail with details on how to activate your account. Please check your email!');</script>";
			echo "<script>window.top.location ='PHPMailer-master/send_mail.php?usr_id=$usr_id&first_name=$first_name&last_name=$last_name&user_email=$user_email&usr_regDate=$usr_regDate&usr_vcode=$usr_vcode';</script>";
    	}else{
            echo $sql;
            echo ("Failed to create $table_name record");
    	}
    }

}else if($act == "update2")
{
	$usr_id = mysqli_real_escape_string($dbconnect,strip_tags(trim($_GET['usr_id'])));
	$first_name = mysqli_real_escape_string($dbconnect,strip_tags(trim($_GET['first_name'])));
	$last_name = mysqli_real_escape_string($dbconnect,strip_tags(trim($_GET['last_name'])));
	
    $query="UPDATE $table_name
            SET
     	       member_status = '1'
			   WHERE member_id = '$usr_id'";

		   $result = @mysqli_query($dbconnect,$query);

		   if($result){
	   		    echo "<script>window.top.location ='confirm.php?act=activated&first_name=$first_name&last_name=$last_name';</script>";
            }
           else{
	    	       echo ("Failed to create $table_name. DEBUG: .$query");
           }
}

function form_validate($username, $first_name, $last_name, $user_email, $mobile, $addr2, $city, $region_state, $pst_code, $country, $user_psd, $user_psd2)
{     
	if(empty($username) || $username=="" ){
        $message = "ERROR: Please enter username";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    }
	
	if(empty($first_name) || $first_name=="" ){
        $message = "ERROR: Please enter first name";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    }
	
	//if(preg_match("/^[A-Z][a-zA-Z -]+$/", $first_name) === 0)
	//{
	//	$message = 'ERROR: Name must be from letters, dashes, spaces and must not start with dash';
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
    //   exit;
	//}
	
	if(empty($last_name) || $last_name=="" ){
        $message = "ERROR: Please enter last name";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    }
	
	//if(preg_match("/^[A-Z][a-zA-Z -]+$/", $last_name) === 0)
	//{
	//	$message = 'ERROR: Name must be from letters, dashes, spaces and must not start with dash';
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
    //    exit;
	//}
	
	if(!empty($first_name) && !empty($last_name) && $first_name == $last_name){
        $message = "ERROR: First name and last name cannot be same";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    }
	
	
	//if(empty($ic_number) || $ic_number=="" ){
    //   $message = "ERROR: Please enter your ic number";
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
    //   exit;
    //}
	
	//if(preg_match("/^[0-9][0-9-]/", $ic_number) === 0)
	//{
	//	$message = 'ERROR: Invalid IC Number! Please try again!';
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
    //   exit;
	//}

	if(empty($user_email) || $user_email=="" ){
        $message = "ERROR: Please enter email.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 
	
	//if(empty($tel) || $tel=="" ){
    //    $message = "ERROR: Please enter telephone number.";
	//	echo "<script type='text/javascript'>alert('$message');</script>";
	//	echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
    //    exit;
    //} 

	if(empty($mobile) || $mobile=="" ){
       $message = "ERROR: Please enter contact number.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 
	
	if(empty($addr2) || $addr2=="" ){
        $message = "ERROR: Please enter your street name.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 

	if(empty($city) || $city=="" ){
        $message = "ERROR: Please enter city.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 

	if(empty($region_state) || $region_state=="" ){
        $message = "ERROR: Please enter region state.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 

	if(empty($pst_code) || $pst_code=="" ){
        $message = "ERROR: Please enter postal code";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 

	if(empty($country) || $country=="" ){
        $message = "ERROR: Please enter country.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 

	if(empty($user_psd) || $user_psd=="" ){
        $message = "ERROR: Please enter new password.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    } 

	if(empty($user_psd2) || $user_psd2=="" ){
        $message = "ERROR: Please re-enter password.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    }
	
	if(strlen($user_psd) <= 5)
	{
        $message = "ERROR: Password must more than 5 characters.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
        exit;
    }

	if($user_psd!=$user_psd2)
	{
		$message = "ERROR: Password did not match! Please try again!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='account.php?act=edit&hyperlink=account';</script>";
		exit;
	}
}

//http://php.net/manual/en/function.rand.php
// Generate a random character string
function gnrt_validateCode()
{
$length = 49;
$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};

    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }

    // Return the string
    return $string;
}

//generate and return unique commercial number 
function gnrt_domestic_number()
{
	date_default_timezone_set('Asia/Kuching'); // CDT
	$start_year = '2015';
	$i = "01";
	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$date = str_pad($date, 2, 0, STR_PAD_LEFT);
	$month = $info['mon'];
	$month = str_pad($month, 2, 0, STR_PAD_LEFT);
	$year = $info['year'];
	$crt_date->setDate($year, $month, $date);
	
	$current_year = $year;
	if($current_year == $start_year)
	{
		$D0 = "D0";
	}else
	{
		$remain_year = $current_year - $start_year;
		$D0 = "D".$remain_year;
	}
	
	$Membership = "PB".$date.$D0.$month;
	$Membership_num = "PB".$date.$D0.$month.$i;
	$sql_membership = @mysqli_query($dbconnect,"SELECT member_number FROM pbmart_member WHERE member_number LIKE '%$Membership%'");
	
	$iCount = @mysqli_num_rows($sql_membership);
	if($iCount == 0)
	{
		$Membership_num = "PB".$date.$D0.$month.$i;
	}else
	{
		$iCount = $iCount + 1;
		$iCount = str_pad($iCount, 2, 0, STR_PAD_LEFT);
		$Membership_num = "PB".$date.$D0.$month.$iCount;
	}
	
	return $Membership_num;
}
?>

