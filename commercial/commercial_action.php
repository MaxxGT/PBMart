<?php 
// Author: VOONG TZE HOWE
// Date Writen: 25-02-2015
// Description : commercial_action.php
//a chinese input URL:http://stackoverflow.com/questions/14456313/cant-insert-chinese-character-into-mysql

//header('Content-Type: text/html; charset=utf-8');
require_once("../connection/pbmartconnection.php");
require_once("../session_config.php");
get_UsrInfo();
GLOBAL $member_id;
include('../encrypt_decrypt.php');

$act = $_REQUEST['act'];
$table_name = "pbmart_commercial";
$table_name2 = "pbmart_commercial";

	$cpy_name = (isset($_POST['cpy_name']) ? mysql_real_escape_string(strip_tags(trim($_POST['cpy_name']))) : '');
	$cpy_name = ucwords($cpy_name);
	$cpy_number = (isset($_POST['cpy_number']) ? mysql_real_escape_string(strip_tags(trim($_POST['cpy_number']))) : '');
	
	$cpy_contact_number = mysql_real_escape_string(strip_tags(trim($_POST['cpy_contact_number'])));
	$cpy_addr = mysql_real_escape_string(strip_tags(trim($_POST['cpy_addr'])));
	$cpy_cty = mysql_real_escape_string(strip_tags(trim($_POST['cpy_cty'])));
	$cpy_state = mysql_real_escape_string(strip_tags(trim($_POST['cpy_state'])));
	$cpy_country = mysql_real_escape_string(strip_tags(trim($_POST['cpy_country'])));
	$cpy_pst_code = mysql_real_escape_string(strip_tags(trim($_POST['cpy_pst_code'])));
	
	$PrsIC_full_name = mysql_real_escape_string(strip_tags(trim($_POST['PrsIC_full_name'])));
	$PrsIC_full_name = ucwords($PrsIC_full_name);
	$PrsIC_ic_number = mysql_real_escape_string(strip_tags(trim($_POST['PrsIC_ic_number'])));
	$PrsIC_position = mysql_real_escape_string(strip_tags(trim($_POST['PrsIC_position'])));
	$PrsIC_mobile = mysql_real_escape_string(strip_tags(trim($_POST['PrsIC_mobile'])));
	
	if(isset($_POST['upd_typ']))
	{
		$form_updType = $_POST['upd_typ'];
	}
	
	
	$commercial_member_id = $member_id;
	$commercial_member_number = $member_number;
	$commercial_number = gnrt_commercial_number();
	$commercial_company = $cpy_name;
	$commercial_company_number = $cpy_number;
	$commercial_phone = $cpy_contact_number;
	$commercial_address = $cpy_addr;
	$commercial_city = $cpy_cty;
	$commercial_postcode = $cpy_pst_code;
	$commercial_state = $cpy_state;
	$commercial_country = $cpy_country;
		
	$commercial_person_incharge = $PrsIC_full_name;
	$commercial_person_ic = $PrsIC_ic_number;
	$commercial_person_position = $PrsIC_position;
	$commercial_person_phone = $PrsIC_mobile;
	
if($act == 'add')
{
	
	$checkforEmail = mysql_query("Select * From pbmart_commercial WHERE commercial_member_id ='$member_id'", $link);
	
	if(mysql_num_rows($checkforEmail) != 0)
    {
		$message = "ERROR: Commercial has been apply before!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='mycommercial.php?hyperlink=myaccount';</script>";
		exit;
    }else
	{
		$uploadOk = 1;
		$target_dir = "../cmanage/commercial/commercial_form";
		
		$PB = gnrt_commercial_number();
		//$PB = 'PB'.str_pad($commercial_numbers, 5, 0, STR_PAD_LEFT);
		
		if($form_updType == '1')
		{
		
		$fToUpload = $target_dir.'/'.$PB.'/'. basename($_FILES["fToUpload"]["name"]);
		
		$flToUpload = $target_dir.'/'.$PB.'/'. basename($_FILES["flToUpload"]["name"]);
		$flToUpload2 = $target_dir.'/'.$PB.'/'. basename($_FILES["flToUpload2"]["name"]);
		$flToUpload3 = $target_dir.'/'.$PB.'/'. basename($_FILES["flToUpload3"]["name"]);
		$flToUpload4 = $target_dir.'/'.$PB.'/'. basename($_FILES["flToUpload4"]["name"]);
		
		$target_file = $target_dir.'/'.$PB.'/'. basename($_FILES["fileToUpload"]["name"]);
		$target_file2 = $target_dir.'/'.$PB.'/'. basename($_FILES["fileToUpload2"]["name"]);
		$target_file3 = $target_dir.'/'.$PB.'/'. basename($_FILES["fileToUpload3"]["name"]);
		
		$iFileType = pathinfo($fToUpload,PATHINFO_EXTENSION);
		
		$imgFileType = pathinfo($flToUpload,PATHINFO_EXTENSION);
		$imgFileType2 = pathinfo($flToUpload2,PATHINFO_EXTENSION);
		$imgFileType3 = pathinfo($flToUpload3,PATHINFO_EXTENSION);
		$imgFileType4 = pathinfo($flToUpload4,PATHINFO_EXTENSION);
		
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
		$imageFileType3 = pathinfo($target_file3,PATHINFO_EXTENSION);
		
		$file_path = $target_dir.'/'.$member_id;
		
		// Check if file already exists
		//if(file_exists($file_path)) 
		//{
		//	$uploadOk = 0;
		//	$message = "Sorry, file already exists! Please try again!";
		//	echo "<script type='text/javascript'>alert('$message');</script>";
		//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
		//	exit;
		//}
		
		// Allow certain file formats
		if($imgFileType3 !="")
		{			
			//if($imgFileType3 != "pdf") {
			//	$uploadOk = 0;
			//	$message = "Sorry, only PDF file are allowed. Please try again!";
			///	echo "<script type='text/javascript'>alert('$message');</script>";
			//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
			//	exit;
			//}
			
			// Check file size LIMIT 10MB 10000000
			if($_FILES["flToUpload3"]["size"] > 5000000) {
				$uploadOk = 0;
				$message = "Sorry, your file is too large.";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
				exit;
			}
			
			$form_lesen_runcit = $PB."/".basename( $_FILES['flToUpload3']['name']);
		}else
		{
			$form_lesen_runcit = "";
		}
		
		
		// Allow certain file formats
		if($imgFileType4 !="")
		{			
			//if($imgFileType4 != "pdf") {
			//	$uploadOk = 0;
			//	$message = "Sorry, only PDF file are allowed. Please try again!";
			//	echo "<script type='text/javascript'>alert('$message');</script>";
			//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
			//	exit;
			//}
			
			// Check file size LIMIT 10MB 10000000
			if($_FILES["flToUpload4"]["size"] > 5000000) {
				$uploadOk = 0;
				$message = "Sorry, your file is too large.";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
				exit;
			}
			
			$form_mpp = $PB."/".basename( $_FILES['flToUpload4']['name']);
		}else
		{
			$form_mpp = "";
		}

		if($imageFileType !="")
		{			
			//if($imageFileType != "pdf") {
			//	$uploadOk = 0;
			//	$message = "1.Sorry, only PDF file are allowed. Please try again!";
			//	echo "<script type='text/javascript'>alert('$message');</script>";
			//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
			//	exit;
			//}
			
			// Check file size LIMIT 10MB 10000000
			if($_FILES["fileToUpload"]["size"] > 5000000) {
				$uploadOk = 0;
				$message = "Sorry, your file is too large.";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
				exit;
			}
			
			$form_paths = $PB."/".basename( $_FILES['fileToUpload']['name']);
		}else
		{
			$form_paths = "";
		}
		
		if($imageFileType2 !="")
		{
			//if($imageFileType2 != "pdf") {
			//	$uploadOk = 0;
			//	$message = "Sorry, only PDF file are allowed. Please try again!";
			//	echo "<script type='text/javascript'>alert('$message');</script>";
			//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
			//	exit;
			//}
			
			// Check file size LIMIT 10MB 10000000
			if($_FILES["fileToUpload2"]["size"] > 5000000) {
				$uploadOk = 0;
				$message = "Sorry, your file is too large.";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
				exit;
			}
			$form_paths2 = $PB."/".basename( $_FILES['fileToUpload2']['name']);
		}else
		{
			$form_paths2 = "";
		}
		
		if($imageFileType3 !="")
		{
			//if($imageFileType3 != "pdf") {
			//	$uploadOk = 0;
			//	$message = "Sorry, only PDF file are allowed. Please try again!";
			//	echo "<script type='text/javascript'>alert('$message');</script>";
			//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
			//	exit;
			//}
			
			// Check file size LIMIT 10MB 10000000
			if($_FILES["fileToUpload3"]["size"] > 5000000) {
				$uploadOk = 0;
				$message = "Sorry, your file is too large.";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
				exit;
			}
			$form_paths3 = $PB."/".basename( $_FILES['fileToUpload3']['name']);
		}else
		{
			$form_paths3 = "";
		}
			
		if($uploadOk != '0')
		{
			mkdir($target_dir.'/'.$PB,0777,true);
			
			if(!move_uploaded_file($_FILES['fToUpload']['tmp_name'], $fToUpload))
			{
				echo "There was an error uploading the file, please try again!";
			}
			
			if(!move_uploaded_file($_FILES['flToUpload']['tmp_name'], $flToUpload))
			{
				echo "There was an error uploading the file, please try again!";
			}
			if(!move_uploaded_file($_FILES['flToUpload2']['tmp_name'], $flToUpload2))
			{
				echo "There was an error uploading the file, please try again!";
			}
			
			if($imgFileType3 !="")
			{
				if(!move_uploaded_file($_FILES['flToUpload3']['tmp_name'], $flToUpload3))
				{
					echo "There was an error uploading the file, please try again!";
				}
			}
			
			if($imgFileType4 !="")
			{
				if(!move_uploaded_file($_FILES['flToUpload4']['tmp_name'], $flToUpload4))
				{
					echo "There was an error uploading the file, please try again!";
				}
			}
			
			
			if($imageFileType !="")
			{
				if(!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file))
				{
					echo "There was an error uploading the file, please try again!";
				}
			}

			if($imageFileType2 !="")
			{
				if(!move_uploaded_file($_FILES['fileToUpload2']['tmp_name'], $target_file2))
				{
					echo "There was an error uploading the file, please try again!";
				}
			}

			if($imageFileType3 !="")
			{
				if(!move_uploaded_file($_FILES['fileToUpload3']['tmp_name'], $target_file3))
				{
					echo "There was an error uploading the file, please try again!";
				}
			}
		}
		
			$form_authorization = $PB."/".basename( $_FILES['flToUpload']['name']);
			$form_registration = $PB."/".basename( $_FILES['flToUpload']['name']);
			$form_borang1 = $PB."/".basename( $_FILES['flToUpload2']['name']);
			
			$commercial_form49 = $form_paths;
			$commercial_form24 = $form_paths2;
			$commercial_form9 = $form_paths3;
		}else
		{
			$form_authorization = "";
			$form_registration = "";
			$form_borang1 = "";
			$form_lesen_runcit = "";
			$form_mpp = "";
			$commercial_form49 = "";
			$commercial_form24 = "";
			$commercial_form9 = "";
		}
		$commercial_status = "0";
		$commercial_application_date = date("Y-m-d");
		
		mysql_query("SET character_set_client=utf8", $link)or die(mysql_error());
        mysql_query("SET character_set_connection=utf8", $link)or die(mysql_error());
		
    	$sql = "INSERT INTO $table_name (commercial_member_id,
										 commercial_member_number, 
										 commercial_number, 
										 commercial_company, 
										 commercial_company_number, 
										 commercial_phone, 
										 commercial_address,
										 commercial_city,
										 commercial_postcode, 
										 commercial_state, 
										 commercial_country,
										 
										 commercial_person_incharge, 
										 commercial_person_ic, 
										 commercial_person_position, 
										 commercial_person_phone,
										 commercial_upload_types,
										 commercial_form_authorization,
										 commercial_form_registration,
										 commercial_form_borang1,
										 commercial_form_lesen_runcit,
										 commercial_form_mpp,
										 commercial_form49,
										 commercial_form24,
										 commercial_form9,
										 commercial_status, 
										 commercial_application_date)
                VALUES ('$commercial_member_id','$commercial_member_number','$commercial_number','$commercial_company','$commercial_company_number','$commercial_phone','$commercial_address','$commercial_city','$commercial_postcode','$commercial_state','$commercial_country','$commercial_person_incharge','$commercial_person_ic','$commercial_person_position','$commercial_person_phone','$form_updType','$form_authorization','$form_registration','$form_borang1','$form_lesen_runcit','$form_mpp','$commercial_form49','$commercial_form24','$commercial_form9','$commercial_status','$commercial_application_date')";
    	$result = @mysql_query($sql);    

    	if($result)
		{
			echo "<script type='text/javascript'>alert('Thank you apply for commercial! An Commercial Confirmation email has been send to your mail! Please check your mail thanks!');</script>";
			echo "<script>window.top.location ='../PHPMailer-master/send_mail_commercial.php?id=$member_id'</script>";
			echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=account';</script>";
    	}else{
            echo $sql;
            echo ("Failed to create $table_name record");
    	}
    }
}else if($act == 'update')
{
	mysql_query("SET character_set_client=utf8", $link)or die(mysql_error());
    mysql_query("SET character_set_connection=utf8", $link)or die(mysql_error());
	

					$uploadOk = 1;
					$target_dir = "../cmanage/commercial/commercial_form/";
					
					$form_query = "";
				if($form_updType == '1')
				{	
					$commercial_form_authorization = "";
					$commercial_form_registration = "";
					$commercial_form_borang1 = "";
					$commercial_form_lesen_runcit ="";
					$commercial_form_mpp ="";
					
					$commercial_form49 = "";
					$commercial_form24 = "";
					$commercial_form9 = "";
					
					$sql_commercial_id = mysql_query("SELECT commercial_number, commercial_member_number FROM pbmart_commercial WHERE commercial_member_number ='$member_number'", $link);
					$rw_commercial_id = @mysql_fetch_assoc($sql_commercial_id);
					$commercial_numbers = $rw_commercial_id['commercial_number'];
					$PB = $commercial_numbers;
					
					
					//$PB = 'PB'.str_pad($member_id, 5, 0, STR_PAD_LEFT);
					
					if(basename( $_FILES['fToUpload']['name']) != "")
					{
						$form_paths = $PB."/".basename( $_FILES['fToUpload']['name']);
						$commercial_form_authorization = $form_paths;
						$form_query.= ", commercial_form_authorization = '$commercial_form_authorization'";
						$t_file = $target_dir.$PB.'/'. basename($_FILES["fToUpload"]["name"]);
						$imgFileType = pathinfo($t_file,PATHINFO_EXTENSION);
						
						//if($imgFileType != "pdf") 
						//{
						//	$uploadOk = 0;
						//	$message = "Sorry, only PDF file are allowed. Please try again!";
						//	echo "<script type='text/javascript'>alert('$message');</script>";
						///	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//	exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
							if($_FILES["fToUpload"]["size"] > 5000000) {
								$uploadOk = 0;
								$message = "Sorry, your file is too large.";
								echo "<script type='text/javascript'>alert('$message');</script>";
								echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
								exit;
							}
					}else
					{
						$commercial_form_authorization = "";
						$form_query.=", commercial_form_authorization = '$commercial_form_authorization'";
					}
					
					if(basename( $_FILES['flToUpload']['name']) != "")
					{
						$form_paths = $PB."/".basename( $_FILES['flToUpload']['name']);
						$commercial_form_registration = $form_paths;
						$form_query.=", commercial_form_registration = '$commercial_form_registration'";
						$trg_file = $target_dir.$PB.'/'. basename($_FILES["flToUpload"]["name"]);
						$imgFileType = pathinfo($trg_file,PATHINFO_EXTENSION);
						
						//if($imgFileType != "pdf") 
						//{
						//	$uploadOk = 0;
						//	$message = "Sorry, only PDF file are allowed. Please try again!";
						//	echo "<script type='text/javascript'>alert('$message');</script>";
						///	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//	exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
							if($_FILES["flToUpload"]["size"] > 5000000) {
								$uploadOk = 0;
								$message = "Sorry, your file is too large.";
								echo "<script type='text/javascript'>alert('$message');</script>";
								echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
								exit;
							}
					}else
					{
						$commercial_form_registration = "";
						$form_query.=", commercial_form_registration = '$commercial_form_registration'";
					}
					
					if(basename( $_FILES['flToUpload2']['name']) != "")
					{
						$form_paths = $PB."/".basename( $_FILES['flToUpload2']['name']);
						$commercial_form_borang1 = $form_paths;
						$form_query.=", commercial_form_borang1 = '$commercial_form_borang1'";
						$trg_file2 = $target_dir.$PB.'/'. basename($_FILES["flToUpload2"]["name"]);
						$imgFileType2 = pathinfo($trg_file2,PATHINFO_EXTENSION);
						
						//if($imgFileType2 != "pdf") 
						//{
						//	$uploadOk = 0;
						//	$message = "Sorry, only PDF file are allowed. Please try again!";
						//	echo "<script type='text/javascript'>alert('$message');</script>";
						//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//	exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
						if($_FILES["flToUpload2"]["size"] > 5000000) {
							$uploadOk = 0;
							$message = "Sorry, your file is too large.";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
							exit;
						}
					}else
					{
						$commercial_form_borang1 = "";
						$form_query.=", commercial_form_borang1 = '$commercial_form_borang1'";
					}
					
					if(basename( $_FILES['flToUpload3']['name']) != "")
					{
						$form_paths = $PB."/".basename( $_FILES['flToUpload3']['name']);
						$commercial_form_lesen_runcit = $form_paths;
						$form_query.=", commercial_form_lesen_runcit = '$commercial_form_lesen_runcit'";
						$trg_file3 = $target_dir.$PB.'/'. basename($_FILES["flToUpload3"]["name"]);
						$imgFileType3 = pathinfo($trg_file3,PATHINFO_EXTENSION);
						
						//if($imgFileType3 != "pdf") 
						//{
						///	$uploadOk = 0;
						//	$message = "Sorry, only PDF file are allowed. Please try again!";
						//	echo "<script type='text/javascript'>alert('$message');</script>";
						//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//	exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
						if($_FILES["flToUpload3"]["size"] > 5000000) {
							$uploadOk = 0;
							$message = "Sorry, your file is too large.";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
							exit;
						}
					}else
					{
						$commercial_form_lesen_runcit = "";
						$form_query.=", commercial_form_lesen_runcit = '$commercial_form_lesen_runcit'";
					}
					
					if(basename( $_FILES['flToUpload4']['name']) != "")
					{
						$form_paths = $PB."/".basename( $_FILES['flToUpload4']['name']);
						$commercial_form_mpp = $form_paths;
						$form_query.=", commercial_form_mpp = '$commercial_form_mpp'";
						$trg_file4 = $target_dir.$PB.'/'. basename($_FILES["flToUpload4"]["name"]);
						$imgFileType4 = pathinfo($trg_file4,PATHINFO_EXTENSION);
						
						//if($imgFileType4 != "pdf") 
						//{
						//	$uploadOk = 0;
						//	$message = "Sorry, only PDF file are allowed. Please try again!";
						//	echo "<script type='text/javascript'>alert('$message');</script>";
						//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//	exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
						if($_FILES["flToUpload4"]["size"] > 5000000) {
							$uploadOk = 0;
							$message = "Sorry, your file is too large.";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
							exit;
						}
					}else
					{
						$commercial_form_mpp = "";
						$form_query.=", commercial_form_mpp = '$commercial_form_mpp'";
					}

					if(basename( $_FILES['fileToUpload']['name']) != "")
					{
						$form_paths = $PB."/".basename( $_FILES['fileToUpload']['name']);
						$commercial_form49 = $form_paths;
						$form_query.=", commercial_form49 = '$commercial_form49'";
						$target_file = $target_dir.$PB.'/'. basename($_FILES["fileToUpload"]["name"]);
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						
						//if($imageFileType != "pdf") 
						//{
						//	$uploadOk = 0;
						//	$message = "Sorry, only PDF file are allowed. Please try again!";
						//	echo "<script type='text/javascript'>alert('$message');</script>";
						//	echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//	exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
							if($_FILES["fileToUpload"]["size"] > 5000000) {
								$uploadOk = 0;
								$message = "Sorry, your file is too large.";
								echo "<script type='text/javascript'>alert('$message');</script>";
								echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
								exit;
							}
					}else
					{
						$commercial_form49 = "";
						$form_query.=", commercial_form49 = '$commercial_form49'";
					}
					
					if(basename( $_FILES['fileToUpload2']['name']) != "")
					{
						$form_paths2 = $PB."/".basename( $_FILES['fileToUpload2']['name']);
						$commercial_form24 = $form_paths2;
						$form_query.=", commercial_form24 = '$commercial_form24'";
						$target_file2 = $target_dir.$PB.'/'. basename($_FILES["fileToUpload2"]["name"]);
						$imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
						
						//if($imageFileType2 != "pdf")
						//{
						//		$uploadOk = 0;
						//		$message = "Sorry, only PDF file are allowed. Please try again!";
						//		echo "<script type='text/javascript'>alert('$message');</script>";
						//		echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//		exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
							if($_FILES["fileToUpload2"]["size"] > 5000000) {
								$uploadOk = 0;
								$message = "Sorry, your file is too large.";
								echo "<script type='text/javascript'>alert('$message');</script>";
								echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
								exit;
							}
					}else
					{
						$commercial_form24 = "";
						$form_query.=", commercial_form24 = '$commercial_form24'";
					}	
					
					if(basename( $_FILES['fileToUpload3']['name']) != "")
					{
						$form_paths3 = $PB."/".basename( $_FILES['fileToUpload3']['name']);
						$commercial_form9 = $form_paths3;
						$form_query.=", commercial_form9 = '$commercial_form9'";
						$target_file3 = $target_dir.$PB.'/'. basename($_FILES["fileToUpload3"]["name"]);
						$imageFileType3 = pathinfo($target_file3,PATHINFO_EXTENSION);
						
						//if($imageFileType3 != "pdf")
						//{
						//		$uploadOk = 0;
						//		$message = "Sorry, only PDF file are allowed. Please try again!";
						//		echo "<script type='text/javascript'>alert('$message');</script>";
						//		echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
						//		exit;
						//}
						
						// Check file size LIMIT 10MB 10000000
							if($_FILES["fileToUpload3"]["size"] > 5000000) {
								$uploadOk = 0;
								$message = "Sorry, your file is too large.";
								echo "<script type='text/javascript'>alert('$message');</script>";
								echo "<script language='JavaScript'>window.top.location ='../commercial.php?hyperlink=myaccount';</script>";
								exit;
							}
					}else
					{
						$commercial_form9 = "";
						$form_query.=", commercial_form9 = '$commercial_form9'";
					}
				}
		
		$query = "UPDATE pbmart_commercial
			  SET
			  
			  commercial_company = '$commercial_company',
			  commercial_company_number = '$commercial_company_number',
			  commercial_phone = '$commercial_phone',
			  commercial_address = '$commercial_address',
			  commercial_city = '$commercial_city',
			  commercial_postcode = '$commercial_postcode',
			  commercial_state = '$commercial_state',
			  commercial_country = '$commercial_country',
			  commercial_person_incharge = '$commercial_person_incharge',
			  commercial_person_ic = '$commercial_person_ic',
			  commercial_person_position = '$commercial_person_position',
			  commercial_person_phone = '$commercial_person_phone',
			  commercial_upload_types = '$form_updType'
			  $form_query
			  WHERE commercial_member_id = '$member_id'";
	
				$update_result = @mysql_query($query);
				if($update_result)
				{
					if($form_updType == '1')
					{
						if($uploadOk != '0')
						{
							$pth_del = $target_dir.$PB;
							
							if(basename( $_FILES['fileToUpload']['name']) != "" || basename( $_FILES['fileToUpload2']['name']) != "" || basename( $_FILES['fileToUpload3']['name']) != "")
							{
								if(file_exists($pth_del))
								{
									deleteDir($pth_del);
								}
							}
							
								if(!file_exists($pth_del))
								{
									mkdir($pth_del,0777,true);
								}
							
								if(basename( $_FILES['fToUpload']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['fToUpload']['tmp_name'], $t_file))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
							
								if(basename( $_FILES['flToUpload']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['flToUpload']['tmp_name'], $trg_file))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
								
								if(basename( $_FILES['flToUpload2']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['flToUpload2']['tmp_name'], $trg_file2))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
								
								if(basename( $_FILES['flToUpload3']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['flToUpload3']['tmp_name'], $trg_file3))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
								
								if(basename( $_FILES['flToUpload4']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['flToUpload4']['tmp_name'], $trg_file4))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
								
								
								if(basename( $_FILES['fileToUpload']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
								
								if(basename( $_FILES['fileToUpload2']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['fileToUpload2']['tmp_name'], $target_file2))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
								
								if(basename( $_FILES['fileToUpload3']['name']) != "")
								{
									if(!move_uploaded_file($_FILES['fileToUpload3']['tmp_name'], $target_file3))
									{
										echo "There was an error uploading the file, please try again!";
									}
								}
						}
					}
					echo "<script language='JavaScript'>window.top.location ='../mycommercial.php?hyperlink=myaccount';</script>";
				}else
				{
					echo 'Error: Please contact website administrator';
				}
}

//http://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it
function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

function messageBox($msg_variable, $message, $msg_path)
{
	if(empty($msg_variable) || $msg_variable=="" ){
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='$msg_path';</script>";
        exit;
    }
}

function form_validate($cpy_name, $cpy_number)
{   
	if(empty($cpy_name))
	{
		//messageBox($cpy_name, "Company Name cannot be empty! Please try again!", "../commercial.php?hyperlink=account");
	}
	
	if(empty($cpy_number))
	{
		messageBox($cpy_number, "Company Number cannot be empty! Please try again!", "../commercial.php?hyperlink=account");
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
function gnrt_commercial_number()
{
	date_default_timezone_set('Asia/Kuching'); // CDT
	$start_year = '2015';
	$i = "01";
	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$month = $info['mon'];
	$month = str_pad($month, 2, 0, STR_PAD_LEFT);
	$year = $info['year'];
	$crt_date->setDate($year, $month, $date);
	
	$current_year = $year;
	if($current_year == $start_year)
	{
		$C0 = "C0";
	}else
	{
		$remain_year = $current_year - $start_year;
		$C0 = "C".$remain_year;
	}

	$Membership = "PB".$date.$C0.$month;
	$Membership_num = "PB".$date.$C0.$month.$i;
	$sql_membership = @mysql_query("SELECT commercial_number FROM pbmart_commercial WHERE commercial_number LIKE '%$Membership%'");
	
	$iCount = @mysql_num_rows($sql_membership);
	if($iCount == 0)
	{
		$Membership_num = "PB".$date.$C0.$month.$i;
	}else
	{
		$iCount = $iCount + 1;
		$iCount = str_pad($iCount, 2, 0, STR_PAD_LEFT);
		$Membership_num = "PB".$date.$C0.$month.$iCount;
	}
	
	return $Membership_num;
}
?>