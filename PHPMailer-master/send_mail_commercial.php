<?php
require 'class.phpmailer.php';
require("../connection/pbmartconnection.php");
include('../session_config.php');
include('../class/commercial.php');
get_UsrInfo();

$commercial = getCommercialbyId();
$commercial_id = getCommercial_ID();

$current_date = date("d-M-Y");
$cpy_name = $commercial[$commercial_id]->_commercial_company;
$cpy_number = $commercial[$commercial_id]->_commercial_company_number;
$cpy_contact_number = $commercial[$commercial_id]->_commercial_phone;
$cpy_addr = $commercial[$commercial_id]->_commercial_address;
$cpy_cty = $commercial[$commercial_id]->_commercial_city;
$cpy_state = $commercial[$commercial_id]->_commercial_state;
$cpy_country = $commercial[$commercial_id]->_commercial_country;
$cpy_pst_code = $commercial[$commercial_id]->_commercial_postcode;
$PrsIC_full_name = $commercial[$commercial_id]->_commercial_person_incharge;
$PrsIC_ic_number = $commercial[$commercial_id]->_commercial_person_ic;
$PrsIC_position = $commercial[$commercial_id]->_commercial_person_position;
$PrsIC_mobile = $commercial[$commercial_id]->_commercial_person_phone;

$commercial_upload_types = $commercial[$commercial_id]->_commercial_upload_types;

$commercial_form_authorization = $commercial[$commercial_id]->_commercial_form_authorization;
$commercial_form_registration = $commercial[$commercial_id]->_commercial_form_registration;
$commercial_form_borang1 = $commercial[$commercial_id]->_commercial_form_borang1;
$commercial_form_lesen_runcit = $commercial[$commercial_id]->_commercial_form_lesen_runcit;
$commercial_form_mpp = $commercial[$commercial_id]->_commercial_form_mpp;

$cpy_frm_authorization = explode("/", $commercial_form_authorization);
$cpy_frm_registration = explode("/", $commercial_form_registration);
$cpy_frm_borang1 = explode("/", $commercial_form_borang1);
$cpy_frm_lesen_runcit = explode("/", $commercial_form_lesen_runcit);
$cpy_frm_lesen_mpp = explode("/", $commercial_form_mpp);

if($commercial_upload_types == '1')
{
	$commercial_upload_types = "Upload company form through PBMart website";
}else if($commercial_upload_types =='2')
{
	$commercial_upload_types = "Send through email Commercial_acc@pbmart.com.my";
}else if($commercial_upload_types =='3')
{
	$commercial_upload_types = "Fax to 082-688653";
}else
{
	$commercial_upload_types = "-";
}


if($cpy_frm_authorization[1] !="" && isset($cpy_frm_authorization[1]))
{
	$cpy_frm_authorization = $cpy_frm_authorization[1];
}else
{
	$cpy_frm_authorization = "-";
}

if($cpy_frm_registration[1] !="" && isset($cpy_frm_registration[1]))
{
	$cpy_frm_registration = $cpy_frm_registration[1];
}else
{
	$cpy_frm_registration = "-";
}

if($cpy_frm_borang1[1] !="" && isset($cpy_frm_borang1[1]))
{
	$cpy_frm_borang1 = $cpy_frm_borang1[1];
}else
{
	$cpy_frm_borang1 = "-";
}

if($cpy_frm_lesen_runcit[1] !="" && isset($cpy_frm_lesen_runcit[1]))
{
	$cpy_frm_lesen_runcit = $cpy_frm_lesen_runcit[1];
}else
{
	$cpy_frm_lesen_runcit = "-";
}

if($cpy_frm_lesen_mpp[1] !="" && isset($cpy_frm_lesen_mpp[1]))
{
	$cpy_frm_lesen_mpp = $cpy_frm_lesen_mpp[1];
}else
{
	$cpy_frm_lesen_mpp = "-";
}

$cpy_form49 = $commercial[$commercial_id]->_commercial_form49;
$cpy_form24 = $commercial[$commercial_id]->_commercial_form24;
$cpy_form9 = $commercial[$commercial_id]->_commercial_form9;

$cpy_frm49 = explode("/", $cpy_form49);
$cpy_frm24 = explode("/", $cpy_form24);
$cpy_frm9 = explode("/", $cpy_form9);

if($cpy_frm49[1] !="" && isset($cpy_frm49[1]))
{
	$cpy_frm49 = $cpy_frm49[1];
}else
{
	$cpy_frm49 = "-";
}

if($cpy_frm24[1] !="")
{
	$cpy_frm24 = $cpy_frm24[1];
}else
{
	$cpy_frm24 = "-";
}

if($cpy_frm9[1] != "")
{
	$cpy_frm9 = $cpy_frm9[1];
}else
{
	$cpy_frm9 = "-";
}

    $body = "<html>"; 
    $body .= "<strong><h2>Commercial Application</h2></strong><BR>
			  Dear $member_first_name,<BR/ ><BR/ >
			  We have received an application for Commercial from you on $current_date and the commercial informations as shown below:<BR/><BR/>";
			  
	$body.="<table border='0' FRAME=BOX>
				<tr>
					<td colspan='4'>
						<center>
							<B>Company Informations</B>
						</center>
					</td>
				</tr>
				
				<tr>
					<td colspan='4'>&nbsp;</td>
				</tr>
				
				<tr>
					<td><b>Company Name: </b></td>
					<td>$cpy_name</td>
					
					<td><b>Company Number: </b></td>
					<td>$cpy_number</td>
				</tr>
				
				<tr>
					<td><b>Company Contact: </b></td>
					<td>$cpy_contact_number</td>
				</tr>
				
				<tr>
					<td colspan='4'>&nbsp;</td>
				</tr>
				
				<tr>
					<td><b>Company Address: </b></td>
					<td colspan='3'>$cpy_addr</td>
				</tr>
				
				<tr>
					<td><b>City: </b></td>
					<td>$cpy_cty</td>
					
					<td><b>State: </b></td>
					<td>$cpy_state</td>
				</tr>
				
				<tr>
					<td><b>Postcode: </b></td>
					<td>$cpy_pst_code</td>
					
					<td><b>Country: </b></td>
					<td>$cpy_country</td>
				</tr>
				
				<tr>
					<td><b>Application Date: </b></td>
					<td>$current_date</td>
				</tr>
				
				<tr>
					<td colspan='4'>
						&nbsp;
					</td>
				</tr>";
	$body.="<tr>
				<td colspan='4'>
					<strong><B><center>Person In Charge Information</center></B></strong>
				</td>
			</tr>
			
			<tr>
				<td colspan='4'>&nbsp;</td>
			</tr>
				
			<tr>
				<td><b>Full Name: </b></td>
				<td>$PrsIC_full_name</td>
				
				<td><b>IC Number: </b></td>
				<td>$PrsIC_ic_number</td>
			</tr>
				
			<tr>
				<td><b>Position: </b></td>
				<td>$PrsIC_position</td>
				
				<td><b>Phone Number: </b></td>
				<td>$PrsIC_mobile</td>
			</tr>";
		
		$body.="<tr>
					<td colspan='4'>
						&nbsp;
					</td>
				</tr>
				
				<tr>
					<td><strong><B>Company form upload methods : </B></strong></td>
					<td>$commercial_upload_types</td>
				</tr>
				
				<tr>
					<td colspan='4'>
						&nbsp;
					</td>
				</tr>
				
				<tr>
					<td><strong><B>Authorization Letter : </B></strong></td>
					<td>$cpy_frm_authorization</td>
				</tr>";
				
		$body.="<tr>
					<td colspan='4'>
						&nbsp;
					</td>
				</tr>
				
				<tr>
					<td colspan='4'>
						<strong><B><center>COMPANY TRADING FORM</center></B></strong>
					</td>
				</tr>
				
				<tr>
					<td colspan='4'>&nbsp;</td>
				</tr>
				
				<tr>
					<td><b>Registration/ Sijil Pendaftaran : </b></td>
					<td>$cpy_frm_registration</td>
				</tr>
				
				<tr>
					<td><b>Borang 1: </b></td>
					<td>$cpy_frm_borang1</td>
				</tr>
				
				<tr>
					<td><b>Lesen Runcit : </b></td>
					<td>$cpy_frm_lesen_runcit</td>
				</tr>
				
				<tr>
					<td><b>Lesen Simpanan Petroleum Dan LPG : </b></td>
					<td>$cpy_frm_lesen_mpp</td>
				</tr>";
		
		
		$body.="<tr>
					<td colspan='4'>
						&nbsp;
					</td>
				</tr>
				
				<tr>
					<td colspan='4'>
						<strong><B><center>COMPANY SDN.BHD FORM</center></B></strong>
					</td>
				</tr>
				
				<tr>
					<td colspan='4'>&nbsp;</td>
				</tr>
				
				<tr>
					<td><b>FORM49 : </b></td>
					<td>
						$cpy_frm49</td>
				</tr>
				
				<tr>
					<td><b>FORM24 : </b></td>
					<td>$cpy_frm24</td>
				</tr>
				
				<tr>
					<td><b>FORM9 : </b></td>
					<td>$cpy_frm9</td>
				</tr>
			</table>";
			
	$body.="<table>	
				<tr>
					<td>
						<BR/>
						www.pbmart.com.my
						<BR/>
						PBMart Sdn.Bhd
					</td>
				</tr>
			</table>";
			
			
    $body .= "</body>\n"; 
    $body .= "</html>\n";
	
	$message = $body;
	
	$subject = "Commercial Application";
    $mail = new PHPMailer();
    $mail->IsSMTP(true);
	$mail->Host = "mail.pbmart.com.my"; // Your SMTP PArameter
    $mail->Port = 25; // Your Outgoing Port
    $mail->SMTPAuth = true; // This Must Be True
    $mail->Username = "pbmartadmin@pbmart.com.my"; // Your Email Address
	$mail->Password = "PbMartAdmin2015*"; // Your Password
    $mail->SMTPSecure = ''; // Check Your Server's Connections for TLS or SSL

	$headers = "Reply-To: ".'hau_sky@yahoo.com'."\r\n"; 
	$headers.= "Return-Path: pbmartadmin@pbmart.com.my\r\n";
	$headers.= "From: administrator@pbmart.com.my\r\n"; 
	
	$headers.= "MIME-Version: 1.0\r\n"; 
	$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers.= "X-Priority: 3\r\n";
	$headers.= "X-Mailer: PHP". phpversion() ."\r\n";
	$headers.= "Organization: PBMart SDN.BHD\r\n";

    $mail->From = "pbmartadmin@pbmart.com.my";
    $mail->FromName = 'PBMart SDN.BHD';
	$mail->AddAddress($member_email);
	$mail->AddAddress('commercial_acc@pbmart.com.my');
	
	$mail->SMTPDebug = 0;
    $mail->IsHTML(true);
	
	$PB = 'PB'.str_pad($member_id, 5, 0, STR_PAD_LEFT);
	
	$mail->AddAttachment('../cmanage/commercial/commercial_form/'.$PB.'/'.$cpy_frm49);
	$mail->AddAttachment('../cmanage/commercial/commercial_form/'.$PB.'/'.$cpy_frm24);
	$mail->AddAttachment('../cmanage/commercial/commercial_form/'.$PB.'/'.$cpy_frm9);
	
	$mail->Header = $headers;
    $mail->Subject = $subject;
    $mail->Body = $body;
	
    if(!$mail->Send())
    {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else
    {
		header('Location: ../mycommercial.php?hyperlink=myaccount');	
	}
?>