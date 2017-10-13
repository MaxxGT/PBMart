<?php
// Author: VOONG TZE HOWE
// Date Writen: 28-02-2015
// Description : mycommercial
// Last Modification:

include('header.php');
include('encrypt_decrypt.php');
include("class/commercial.php");
include("redemption_function.php");

//header('Content-Type: text/html; charset=utf-8');
get_UsrInfo();
$commercial = getCommercialbyId();
$commercial_id = getCommercial_ID();

if(isset($_GET['act']) && $_GET['act']=="edit")
{
	include("connection/pbmartconnection.php");
}
echo $commercial[$commercial_id]->_commercial_upload_types;
if($commercial[$commercial_id]->_commercial_upload_types == '1')
{
	$btn_disabled = "";
}else if($commercial[$commercial_id]->_commercial_upload_types == '2')
{
	$btn_disabled = "disabled";
}else if($commercial[$commercial_id]->_commercial_upload_types == '3')
{
	$btn_disabled = "disabled";
}else
{
	$btn_disabled = "disabled";
}
?>

<script type="text/javascript" src="jscss/lib.js"></script>
<script type="text/javascript" src="jscss/facebox.js"></script>
<script type="text/javascript" src="jscss/val.js"></script>
<script type="text/javascript" src="jscss/dtp.js"></script>
<link rel="stylesheet" type="text/css" href="jscss/slimbox_ex.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscss/data.css" media="screen" />

<script>

function submitForm() 
{	
	var result = confirm("Save profile information?");
	var formObject = document.forms['mycommercialform'];
	if(result == true)
	{
		formObject.submit();
	}
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
}
function isNumberKey2(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode == 45)
            return true;
		 
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}

	var _validFileExtensions = [".pdf",'.jpg','.png','.docx'];    
	function ValidateSingleInput(oInput, ids) {
		if (oInput.type == "file") {
			var sFileName = oInput.value;
			 if (sFileName.length > 0) {
				var blnValid = false;
				for (var j = 0; j < _validFileExtensions.length; j++) {
					var sCurExtension = _validFileExtensions[j];
					if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
						blnValid = true;
						break;
					}
				}
				 
				if (!blnValid) {
					//alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
					document.getElementById(ids).innerHTML="*Invalid FORM, only PDF are allow!";
					oInput.value = "";
					return false;
				}else
				{
					document.getElementById(ids).innerHTML="";
				}
			}
		}
		return true;
	}
	
	function validation_company_name()
	{	
		var com_numValidation = /^[0-9]{6}-[A-Z]{1}/;
		var regularE= /^[A-z ]+$/;
		var regularE2 = /^[0-9]{6}-[0-9]{2}-[0-9]{4}/;
		var regularE_ContactNum = /^[0-9]{3}-[0-9]{6}|[0-9]{9}|[0-9]{3}-[0-9]{8}|[0-9]{8}/;
		 
		var cpy_name = document.getElementById("cpy_name").value;
		var cpy_number = document.getElementById("cpy_number").value;
		var cpy_contact_number = document.getElementById("cpy_contact_number").value;
		var cpy_addr = document.getElementById("cpy_addr").value;
		var cpy_cty = document.getElementById("cpy_cty").value;
		
		var cpy_state = document.getElementById("cpy_state").value;
		var cpy_country = document.getElementById("cpy_country").value;
		var cpy_pst_code = document.getElementById("cpy_pst_code").value;
		
		var PrsIC_full_name = document.getElementById("PrsIC_full_name").value;
		var PrsIC_ic_number = document.getElementById("PrsIC_ic_number").value;
		var PrsIC_position = document.getElementById("PrsIC_position").value;
		var PrsIC_mobile = document.getElementById("PrsIC_mobile").value;
		
		var fToUpload = document.getElementById("fToUpload").value;
		
		var flToUpload = document.getElementById("flToUpload").value;
		var flToUpload2 = document.getElementById("flToUpload2").value;
		var flToUpload3 = document.getElementById("flToUpload3").value;
		
		
		var fileToUpload = document.getElementById("fileToUpload").value;
		var fileToUpload2 = document.getElementById("fileToUpload2").value;
		var fileToUpload3 = document.getElementById("fileToUpload3").value;
		
		document.getElementById("cpy_names").innerHTML="";
		document.getElementById("cpy_numbers").innerHTML="";
		document.getElementById("cpy_contact_numbers").innerHTML="";
		document.getElementById("cpy_addrs").innerHTML="";
		document.getElementById("cpy_ctys").innerHTML="";
		document.getElementById("cpy_states").innerHTML="";
		document.getElementById("cpy_countrys").innerHTML="";
		document.getElementById("cpy_pst_codes").innerHTML="";
		
		document.getElementById("PrsIC_full_names").innerHTML="";
		document.getElementById("PrsIC_ic_numbers").innerHTML="";
		document.getElementById("PrsIC_positions").innerHTML="";
		
		document.getElementById("PrsIC_mobiles").innerHTML="";
		document.getElementById("fileToUploads").innerHTML="";
		document.getElementById("fileToUpload2s").innerHTML="";
		document.getElementById("fileToUpload3s").innerHTML="";
		
		
		
		if(cpy_name == "")
		{
			//alert('*Please fill in company name');
			document.getElementById("cpy_names").innerHTML="*Please fill in company name";
			document.getElementById("cpy_name").focus();
			document.getElementById("cpy_name").scrollIntoView();
		}else if(cpy_number == "")
		{
			//alert('*Please fill in company number');
			document.getElementById("cpy_numbers").innerHTML="*Please fill in company number";
			document.getElementById("cpy_number").focus();
			document.getElementById("cpy_number").scrollIntoView();
		}else if(cpy_contact_number == "")
		{
			document.getElementById("cpy_contact_numbers").innerHTML="*Please fill in contact number";
			document.getElementById("cpy_contact_number").focus();
			document.getElementById("cpy_contact_number").scrollIntoView();
		}
		
		else if(cpy_addr == "")
		{
			document.getElementById("cpy_addrs").innerHTML="*Please fill in address";
			document.getElementById("cpy_addr").focus();
			document.getElementById("cpy_addr").scrollIntoView();
		}else if(cpy_cty == "")
		{
			document.getElementById("cpy_ctys").innerHTML="*Please select city";
			document.getElementById("cpy_cty").focus();
			document.getElementById("cpy_cty").scrollIntoView();
		}else if(cpy_state == "")
		{
			document.getElementById("cpy_states").innerHTML="*Please select state";
			document.getElementById("cpy_state").focus();
			document.getElementById("cpy_state").scrollIntoView();
		}else if(cpy_country == "")
		{
			document.getElementById("cpy_countrys").innerHTML="*Please select country";
			document.getElementById("cpy_country").focus();
			document.getElementById("cpy_country").scrollIntoView();
		}else if(cpy_pst_code == "")
		{
			document.getElementById("cpy_pst_codes").innerHTML="*Please fill in post code";
			document.getElementById("cpy_pst_code").focus();
			document.getElementById("cpy_pst_code").scrollIntoView();
		}
		
		else if(PrsIC_full_name == "")
		{
			document.getElementById("PrsIC_full_names").innerHTML="*Please fill in full name";
			document.getElementById("PrsIC_full_name").focus();
			document.getElementById("PrsIC_full_name").scrollIntoView();
		}else if(PrsIC_ic_number == "")
		{	
			document.getElementById("PrsIC_ic_numbers").innerHTML="*Please fill in IC number. Example: 123456-12-1234";
			document.getElementById("PrsIC_ic_number").focus();
			document.getElementById("PrsIC_ic_number").scrollIntoView();
		}
		
		else if (! PrsIC_ic_number.match(regularE2)){
           document.getElementById('PrsIC_ic_numbers').innerHTML =" *Invalid IC number. Example: 123456-12-1234";
		   document.getElementById("PrsIC_ic_number").focus();
			document.getElementById("PrsIC_ic_number").scrollIntoView();
		}
		
		else if(PrsIC_position == "")
		{
			document.getElementById("PrsIC_positions").innerHTML="*Please fill in position";
			document.getElementById("PrsIC_position").focus();
			document.getElementById("PrsIC_position").scrollIntoView();
		}else if(PrsIC_mobile == "")
		{
			document.getElementById("PrsIC_mobiles").innerHTML="*Please fill in mobile number";
			document.getElementById("PrsIC_mobile").focus();
			document.getElementById("PrsIC_mobile").scrollIntoView();
		}
		else if(PrsIC_mobile.length < 10)
		{
			document.getElementById("PrsIC_mobiles").innerHTML="*Invalid mobile number";
			document.getElementById("PrsIC_mobile").focus();
			document.getElementById("PrsIC_mobile").scrollIntoView();
		}
		
		else if(document.getElementById("upd_typ1").checked)
		{
			 alert('123');
			if(fToUpload !="" || flToUpload !="" || flToUpload2 !="")
			{
				
			
			 alert('1234');
				if(fToUpload == "")
				{
					document.getElementById("fToUploads").innerHTML="*Please upload authorization letter";
					document.getElementById("fToUpload").focus();
					document.getElementById("fToUpload").scrollIntoView();
				}
				else if(flToUpload == "")
				{
					document.getElementById("flToUploads").innerHTML="*Please upload company form";
					document.getElementById("flToUpload").focus();
					document.getElementById("flToUpload").scrollIntoView();
				}else if(flToUpload2 == "")
				{
					document.getElementById("flToUpload2s").innerHTML="*Please upload company form";
					document.getElementById("flToUpload").focus();
					document.getElementById("flToUpload").scrollIntoView();
				}else if(fileToUpload !="" || fileToUpload2 != "" || fileToUpload3 !="")
				{
					if(fileToUpload == "")
					{
						document.getElementById("fileToUploads").innerHTML="*Please upload FORM 49";
						document.getElementById("fileToUpload").focus();
						document.getElementById("fileToUpload").scrollIntoView();
					}else if(fileToUpload2 == "")
					{
						document.getElementById("fileToUpload2s").innerHTML="*Please upload FORM 24";
						document.getElementById("fileToUpload2").focus();
						document.getElementById("fileToUpload2").scrollIntoView();
					}else if(fileToUpload3 == "")
					{
						document.getElementById("fileToUpload3s").innerHTML="*Please upload FORM 9";
						document.getElementById("fileToUpload3").focus();
						document.getElementById("fileToUpload3").scrollIntoView();
					}else
					{
						document.getElementById("mycommercialform").submit();
					}
				}else
				{
					document.getElementById("mycommercialform").submit();
				}
			}else
			{
				 alert('12345');
				document.getElementById("mycommercialform").submit();
			}
		}
		else if(fileToUpload !="" || fileToUpload2 != "" || fileToUpload3 !="")
		{
			if(fileToUpload == "")
			{
				document.getElementById("fileToUploads").innerHTML="*Please upload FORM 49";
				document.getElementById("fileToUpload").focus();
				document.getElementById("fileToUpload").scrollIntoView();
			}else if(fileToUpload2 == "")
			{
				document.getElementById("fileToUpload2s").innerHTML="*Please upload FORM 24";
				document.getElementById("fileToUpload2").focus();
				document.getElementById("fileToUpload2").scrollIntoView();
			}else if(fileToUpload3 == "")
			{
				document.getElementById("fileToUpload3s").innerHTML="*Please upload FORM 9";
				document.getElementById("fileToUpload3").focus();
				document.getElementById("fileToUpload3").scrollIntoView();
			}else
			{
				document.getElementById("mycommercialform").submit();
			}
		}
		else
		{
			document.getElementById("mycommercialform").submit();
		}
	}
	
	//http://stackoverflow.com/questions/6017350/i-need-javascript-function-to-disable-enter-key
	function noenter(e){
    e = e || window.event;
    var key = e.keyCode || e.charCode;
    return key !== 13; 
}

function myFunction(x)
{	
	if(x != '1')
	{
		document.getElementById("fToUpload").disabled = true;
		document.getElementById("flToUpload").disabled = true;
		document.getElementById("flToUpload2").disabled = true;
		document.getElementById("flToUpload3").disabled = true;
		document.getElementById("flToUpload4").disabled = true;
		document.getElementById("fileToUpload").disabled = true;
		document.getElementById("fileToUpload2").disabled = true;
		document.getElementById("fileToUpload3").disabled = true;
	}else
	{
		document.getElementById("fToUpload").disabled = false;
		document.getElementById("flToUpload").disabled = false;
		document.getElementById("flToUpload2").disabled = false;
		document.getElementById("flToUpload3").disabled = false;
		document.getElementById("flToUpload4").disabled = false;
		document.getElementById("fileToUpload").disabled = false;
		document.getElementById("fileToUpload2").disabled = false;
		document.getElementById("fileToUpload3").disabled = false;
	}
}
</script>
<html>
<TITLE>PBMART COMMERCIAL</TITLE>
<BODY>
	<!-- Main -->
	  <div id="main">
		<div class="cl">&nbsp;</div>
			<!-- Content -->
				<div id="content">
		<!-- Member Sign in -->
			<h1><strong>Commercial Account</strong></h1><br />
		<!-- Member Sign in End-->
<!-- Member Sign up -->
<form id="mycommercialform" name="mycommercialform" action="commercial/commercial_action.php" enctype="multipart/form-data" method="post">
<table border="0" name="mbr_sign_up" width='750px'>
				<tr>
					<td colspan="4">------------------------------------------------------------------------------------------------------------------------------</td>
				</tr>
				
				<tr>
					<td width='250px'><strong><font size="4">Commercial Status:</font></strong></td>
					<td>
						<strong>
						<?php 
							if($member_commercial_status == '0' && $commercial_status == '0')
							{
								echo "<font color='orange' size='4'>Pending</font>";
							}else if($member_commercial_status == '1' && $commercial_status == '1')
							{
								echo "<font color='green' size='4'>Approved</font>";
							}else if($member_commercial_status == '3' && $commercial_status == '3')
							{
								echo "<font color='red' size='4'>Disapproved</font>";
							}
						?>
						</strong>
					</td>
				</tr>
				
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				
				
				<tr>
					<td width='210px'><strong><font size="4">Commercial Information</font></strong></td>
				<?php
				if(isset($_GET['act']))
				{
					$act = $_GET['act'];
				}else
				{
					$act = "";
				}
				
					if($act == "" OR $act == "update")
					{ 
						if($member_commercial_status == '0')
						{ ?>
						<td align="right"><a href="mycommercial.php?act=edit&hyperlink=myaccount" title="edit profile infomation"><img src="icon/red_editinfo.png" width="80px" height="25px"></img></a></td>
						<?php } ?>
			  <?php }else if($act == "edit")
					{ ?>
						<td align="right"><a href="#" title="save commercial infomation" onclick='validation_company_name();'><img src="icon/red_saveinfo.png" width="80px" height="25px"></img></a></td>
			  <?php } ?>
					
				</tr>
				
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
			
			<?php
				if(isset($_GET['act']))
				{
					$act = $_GET['act'];
				}else
				{
					$act = "";
				}
			
				if($act=="edit")
				{ ?>
					<tr>
						<td><span style = "color:red">*</span><strong> Company Name :  </strong></td>
						<td><input type="text" id="cpy_name" name="cpy_name" value="<?php if(isset($commercial[$commercial_id]->_commercial_company)){echo $commercial[$commercial_id]->_commercial_company;}?>" size="30" maxlength='100'></input>
						<span id="cpy_names" style="color:red"></span></td>
					</tr>
					<tr>				
						<td><span style = "color:red">*</span><strong> Company Number : </strong></td>
						<td><input type="text" id="cpy_number" name="cpy_number" value="<?php echo $commercial[$commercial_id]->_commercial_company_number;?>" size="30" maxlength='8'> </input>
							<span id="cpy_numbers" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span><strong> Contact Number: </strong></td>
						<td><input type="text" id="cpy_contact_number" name="cpy_contact_number" value="<?php echo $commercial[$commercial_id]->_commercial_phone; ?>" size="30" maxlength='11' onKeyPress="return isNumberKey(event)"></input>
							<span id="cpy_contact_numbers" style="color:red" />
						</td>
					</tr>
					<tr>				
						<td valign='top'><span style = "color:red">*</span><strong> Address : </strong></td>
						<td>
							<textarea id="cpy_addr" name="cpy_addr" rows="3" cols="29"><?php echo $commercial[$commercial_id]->_commercial_address; ?></textarea>
							<span id="cpy_addrs" style="color:red; valign:top;"  />
						</td>
					</tr>
					<tr>
						<td><span style = "color:red">*</span><strong> City : </strong></td>
						<td>
							<select id="cpy_cty" name="cpy_cty" style="font-family: verdana; font-size: 12px;">
								<option value="">-- Select --</option>
									<?php
										$sql_pbmart_city = "Select * FROM pbmart_service_city";
										$rs_city = mysql_query($sql_pbmart_city, $link);
										while($rw_city = mysql_fetch_array($rs_city))
										{
											$service_city = $rw_city['service_city'];
											?>
											
											<option value="<?php echo $service_city; ?>" Selected ><?php echo $service_city; ?></option>
									<?php } ?>
							</select>
							<!-- <input type="text" id="cpy_cty" name="cpy_cty" value="<?php echo $commercial[$commercial_id]->_commercial_city; ?>" maxlength='10' size="30"></input> -->
							<span id="cpy_ctys" style="color:red" />
						</td>
					</tr>
					<tr>				
						<td><span style = "color:red">*</span><strong> State : </strong></td>
						<td>
							<select id="cpy_state" name="cpy_state" style="font-family: verdana; font-size: 12px;">
								<option value="">-- Select --</option>
									<?php
										$sql_pbmart_state = "Select * FROM pbmart_service_state";
										$rs_state = mysql_query($sql_pbmart_state, $link);
										while($rw_state = mysql_fetch_array($rs_state))
										{
											$service_state = $rw_state['service_state'];
											?>
											
											<option value="<?php echo $service_state; ?>" Selected ><?php echo $service_state; ?></option>
									<?php } ?>	
							</select>
							
							
							
							<!-- <input type="text" id="cpy_state" name="cpy_state" value="<?php echo $commercial[$commercial_id]->_commercial_state; ?>" maxlength='12' size="30"></input> -->
							<span id="cpy_states" style="color:red" />
						</td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span> <B>Country :</B></td>
						<td>
							<select id="cpy_country" name="cpy_country">
							<option value="">-- Select --</option>
								<?php
										$sql_pbmart_country = "Select * FROM pbmart_service_country";
										$rs_country = mysql_query($sql_pbmart_country, $link);
										while($rw_country = mysql_fetch_array($rs_country))
										{
											$service_country = $rw_country['service_country'];
											?>
												<option value="<?php echo $service_country; ?>" Selected ><?php echo $service_country; ?></option>
									<?php } ?>
							</select>
							<span id="cpy_countrys" style="color:red" />
						</td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span><B> Post Code :</B> </td>
						<td>
							<!--<select id="cpy_pst_code" name="cpy_pst_code">
								<option value="">-- Select --</option>
								<?php
										$sql_pbmart_pst_code = "Select * FROM pbmart_service_postcode";
										$rs_pst_code = mysql_query($sql_pbmart_pst_code, $link);
										while($rw_pst_code = mysql_fetch_array($rs_pst_code))
										{
											$service_pst_code = $rw_pst_code['post_code'];
											?>
											
											<option value="<?php echo $service_pst_code; ?>"><?php echo $service_pst_code; ?></option>
									<?php } ?>
								</select> -->
							<input type="text" id="cpy_pst_code" name="cpy_pst_code" size='12' maxlength='5' value="<?php echo $commercial[$commercial_id]->_commercial_postcode ; ?>" onkeypress="return isNumberKey(event)"></input>
							<span id="cpy_pst_codes" style="color:red" />
						</td>
					</tr>
		  <?php }else
				{?>
					<tr>
						<td><strong>Company Name : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_company;?></td>
					</tr>
					<tr>				
						<td><strong>Company Number : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_company_number;?></td>
					</tr>
					<tr>
						<td><strong>Contact Number : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_phone; ?></td>
					
					<tr>				
						<td><strong>Address : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_address; ?></td>
					</tr>
					<tr>				
						<td><strong>City : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_city; ?></input></td>
					</tr>
					<tr>				
						<td><strong>State : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_state; ?></input></td>
					</tr>
					
					<tr>				
						<td><strong>Country : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_country; ?></input></td>
					</tr>
					
					<tr>				
						<td><strong>Post Code : </strong></td>
						<td><?php echo $commercial[$commercial_id]->_commercial_postcode; ?></input></td>
					</tr>
		  <?php } ?>

			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
							
			<tr align="left">
			<td colspan="2"><strong><font size="4"> Person In Charge</font></strong></td>
			
			</tr>
							
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>			
				
			</tr>
			
			<?php
			if($act == "edit")
			{ ?>

			<tr>
				<td><span style = "color:red">*</span><strong> Full Name :</strong></td>
				<td>
					<input type="text" id="PrsIC_full_name" name="PrsIC_full_name" value="<?php echo $commercial[$commercial_id]->_commercial_person_incharge; ?>" size="30" maxlength="50"></input>
					<span id="PrsIC_full_names" style="color:red" />
				</td>
			</tr>
			
			<tr>
				<td><span style = "color:red">*</span><strong> IC Number :</strong></td>
				<td>
					<input type="text" id="PrsIC_ic_number" name="PrsIC_ic_number" value="<?php echo $commercial[$commercial_id]->_commercial_person_ic; ?>" placeholder='123456-12-1234' onKeyPress="return isNumberKey2(event)" size="30" maxlength='14'></input>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><span id="PrsIC_ic_numbers" style="color:red" /></td>
			</tr>
			
			<tr>
				<td><span style = "color:red">*</span><strong> Position :</strong></td>
				<td>
					<input type="text" id="PrsIC_position" name="PrsIC_position" value="<?php echo $commercial[$commercial_id]->_commercial_person_position; ?>" size="30" maxlength='50'></input>
					<span id="PrsIC_positions" style="color:red" />
				</td>
			</tr>
			
			<tr>
				<td><span style = "color:red">*</span><strong> Mobile Number :</strong></td>
				<td>
					<input type="text" id="PrsIC_mobile" name="PrsIC_mobile" value="<?php echo $commercial[$commercial_id]->_commercial_person_phone; ?>" onKeyPress="return isNumberKey(event)" size="30" maxlength='11'></input>
					<span id="PrsIC_mobiles" style="color:red" />
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					
					<tr>
						<td colspan='2'><font color='black'><B>Company form upload methods : </B></font> <span id="upd_typ1s" style="color:red" /></td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					
					<tr>
						<td colspan='2'>
						<input name="upd_typ" type="radio" value='1' onclick="myFunction(this.value);" id="upd_typ1" <?php if($commercial[$commercial_id]->_commercial_upload_types == '1'){echo "checked";} ?> />
						<font color='black'>Upload company form through PBMart website</font>
						
						</td>
					</tr>
					<tr>
						<td colspan='2'>
						<input name="upd_typ" type="radio" value='2' onclick="myFunction(this.value);" id="upd_typ2"  <?php if($commercial[$commercial_id]->_commercial_upload_types == '2'){echo "checked";} ?> />
						<font color='black'>Send through email commercial_acc@pbmart.com.my</font></td>
					</tr>
					<tr>
						<td colspan='2'>
						<input name="upd_typ" type="radio" value='3' onclick="myFunction(this.value);" id="upd_typ3" <?php if($commercial[$commercial_id]->_commercial_upload_types == '3'){echo "checked";} ?> />
						<font color='black'>Fax to 082-688653</font></td>
					</tr>

					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
			
					<tr>
						<td><span style = "color:red">*</span><strong><font size="3">Authorization Letter</font></strong></td>
						<td><input type="file" name="fToUpload" id="fToUpload" onchange="ValidateSingleInput(this, 'fToUpload');" <?php echo $btn_disabled; ?> />
							<span id="fToUploads" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
			
			<tr align="left">
				<td colspan="2"><strong><font size="4"> Company Trading FORM</font></strong></td>
			</tr>

					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span><strong> Registration / Sijil Pendaftaran : </strong></td>
						<td><input type="file" name="flToUpload" id="flToUpload" onchange="ValidateSingleInput(this, 'flToUpload');"  <?php echo $btn_disabled; ?> />
							<span id="flToUploads" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span><strong> Borang 1 : </strong></td>
						<td><input type="file" name="flToUpload2" id="flToUpload2" onchange="ValidateSingleInput(this, 'flToUpload2');"  <?php echo $btn_disabled; ?> />
							<span id="flToUpload2s" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><strong>&nbsp;Lesen Runcit : </strong></td>
						<td><input type="file" name="flToUpload3" id="flToUpload3" onchange="ValidateSingleInput(this, 'flToUpload3');" <?php echo $btn_disabled; ?>  />
							<span id="flToUpload3s" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><strong>&nbsp;Lesen Simpanan Petroleum Dan LPG : </strong></td>
						<td><input type="file" name="flToUpload4" id="flToUpload4" onchange="ValidateSingleInput(this, 'flToUpload4');" <?php echo $btn_disabled; ?>  />
							<span id="flToUpload4s" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td></td>
						<td><B>Supported file types: pdf, jpeg, png, docx.</B></td>
					</tr>
					
					<tr>
						<td colspan='2'>
							&nbsp;
						</td>
					</tr>
			
			<tr align="left">
				<td colspan="2"><strong><font size="4"> COMPANY FORM SDN.BHD</font></strong></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td>
					<strong>&nbsp;Form 49 :</strong>
				</td>
				
				<td>
					<input type="file" name="fileToUpload" id="fileToUpload" onchange="ValidateSingleInput(this, 'fileToUploads');" <?php echo $btn_disabled; ?>  />
					<span id="fileToUploads" style="color:red" />
				</td>
			</tr>
			
			<tr>
				<td>
					<strong>&nbsp;Form 24 :</strong>
				</td>
				
				<td>
					<input type="file" name="fileToUpload2" id="fileToUpload2" onchange="ValidateSingleInput(this, 'fileToUpload2s');" <?php echo $btn_disabled; ?>  />
					<span id="fileToUpload2s" style="color:red" />
				</td>
			</tr>
			
			<tr>
				<td><strong>&nbsp;Form 9 :</strong></td>
				<td>
					<input type="file" name="fileToUpload3" id="fileToUpload3" onchange="ValidateSingleInput(this, 'fileToUpload2s');" <?php echo $btn_disabled; ?>  />
					<span id="fileToUpload3s" style="color:red" />
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td><B>Supported file types: pdf, jpeg, png, docx.</B></td>
			</tr>
			
		<input type="hidden" name="act" value="update"></input>
</form>
	  <?php }else
			{ ?>
				<tr>
					<td><strong>Full Name : </strong></td>
					<td><?php echo $commercial[$commercial_id]->_commercial_person_incharge; ?></td>
				</tr>

				<tr>
					<td><strong>IC Number: </strong></td>
					<td>
						<?php echo $commercial[$commercial_id]->_commercial_person_ic; ?>			
					</td>
				</tr>

				<tr>
					<td><strong>Position : </strong></td>
					<td>
						<?php echo $commercial[$commercial_id]->_commercial_person_position; ?>
					</td>
				</tr>

				<tr>
					<td><strong>Mobile Number : </strong></td>
					<td>
						<?php echo $commercial[$commercial_id]->_commercial_person_phone; ?>
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td colspan='2'><font size='4'><B>Company form upload methods </B><span id="upd_typ1s" style="color:red" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td colspan='2'><?php 
							if($commercial[$commercial_id]->_commercial_upload_types == '1')
							{
								echo "- Upload company form through PBMart website";
							}else if($commercial[$commercial_id]->_commercial_upload_types == '2')
							{
								echo "- Send through email commercial_acc@pbmart.com.my";	
							}else if($commercial[$commercial_id]->_commercial_upload_types == '3')
							{
								echo "- Fax to 082-688653";	
							}							
					 ?></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td>
						<strong>Authorization Letter : </strong>
					</td>
					<td>
					<?php
						if($commercial[$commercial_id]->_commercial_form_authorization)
						{ ?>
							<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=_authorization"
							target="_blank" title="Click to download the company form.">
							<?php 
							$filename = $commercial[$commercial_id]->_commercial_form_authorization; 
							$fname = explode("/", $filename);
							echo $fname[1]; ?>
							</a>
				  <?php }else
						{
							echo "-";
						} ?>
						
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr align="left">
					<td colspan="2"><strong><font size="4"> Company Trading FORM</font></strong></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					
				</tr>
				
				<tr>
					<td><strong>Registration/ Sijil Pendaftaran : </strong></td>
					<td>
					<?php
						if($commercial[$commercial_id]->_commercial_form_registration)
						{ ?>
							
						
						<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=_registration"
						target="_blank" title="Click to download the company form.">
						<?php 
						$filename = $commercial[$commercial_id]->_commercial_form_registration; 
						$fname = explode("/", $filename);
						echo $fname[1]; ?>
						</a>
						<?php }else
						{
							echo "-";
						} ?>
						
					</td>
				</tr>
				
				<tr>
					<td><strong>Borang 1 : </strong></td>
					<td>
					<?php
						if($commercial[$commercial_id]->_commercial_form_borang1)
						{ ?>
								<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=_borang1" target="_blank" title="Click to download the company form.">
								<?php
								$filename = $commercial[$commercial_id]->_commercial_form_borang1; 
								$fname = explode("/", $filename);

								echo $fname[1]; ?>
								</a>
					<?php }else
					{
						echo "-";
					} ?>

					</td>
				</tr>
				
				<tr>
					<td><strong>Lesen Runcit : </strong></td>
					<td>
					<?php
						if($commercial[$commercial_id]->_commercial_form_lesen_runcit != "")
						{ ?>
							<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=_lesen_runcit" target="_blank" title="Click to download the company form.">
							
							<?php 
							$filename = $commercial[$commercial_id]->_commercial_form_lesen_runcit; 
							$fname = explode("/", $filename);
							echo $fname[1]; ?>
							</a>
				  <?php }else
						{
							echo "-";
						} ?>
						
					</td>
				</tr>
				
				<tr>
					<td><strong>
							Lesen Simpanan Petroleum Dan LPG : 
						</strong></td>
					<td>
						<?php
						if($commercial[$commercial_id]->_commercial_form_mpp != "")
						{ ?>
							<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=_mpp" target="_blank" title="Click to download the company form.">
							
							<?php 
							$filename = $commercial[$commercial_id]->_commercial_form_mpp; 
							$fname = explode("/", $filename);
							echo $fname[1]; ?>
							</a>
				  <?php }else
						{
							echo "-";
						} ?>
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					
				</tr>
				
				<tr align="left">
					<td colspan="2"><strong><font size="4"> COMPANY FORM SDN.BHD</font></strong></td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					
				</tr>
				
				<tr>
					<td><strong>FORM 49 : </strong></td>
					<td>
						<?php
						if($commercial[$commercial_id]->_commercial_form49 != "")
						{ ?>
								<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=49" target="_blank" title="Click to download the company form.">
								<?php 
									$filename = $commercial[$commercial_id]->_commercial_form49; 
									$fname = explode("/", $filename);
									echo $fname[1]; 
								?>
							</a>
				  <?php }else
						{
							echo "-";
						} ?>
					</td>
				</tr>
				
				<tr>
					<td><strong>FORM 24 : </strong></td>
					<td>
						<?php
						if($commercial[$commercial_id]->_commercial_form24 != "")
						{ ?>
							<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=24" target="_blank" title="Click to download the company form.">
								
								<?php 
									$filename = $commercial[$commercial_id]->_commercial_form24; 
									$fname = explode("/", $filename);
									echo $fname[1];
								?>
							</a>
				  <?php }else
						{
							echo "-";
						} ?>
					</td>
				</tr>
				
				<tr>
					<td><strong>FORM 9 : </strong></td>
					<td>
						<?php
						if($commercial[$commercial_id]->_commercial_form9 != "")
						{ ?>
							<a href="download.php?com=<?php echo $commercial[$commercial_id]->_commercial_id; ?>&form=24" target="_blank" title="Click to download the company form.">
								<?php 
									$filename = $commercial[$commercial_id]->_commercial_form9; 
									$fname = explode("/", $filename);
									echo $fname[1];
								?>
							</a>
						<?php }else
						{
							echo "-";
						} ?>
					</td>
				</tr>
				
				<tr>
					<td colspan="4">-----------------------------------------------------------------------------------------------------------------</td>
				</tr>
				
				<!-- <tr>
					<td><strong>Commercial Status:</strong></td>
					<td>
						<strong>
						<?php 
							if($member_commercial_status == '0')
							{
								echo "<font color='orange'>Pending</font>";
							}else
							{
								echo "<font color='green'>Approved</font>";
							}
						?>
						</strong>
					</td>
				</tr> -->
				
	  <?php } ?>
			</table>
		<!-- Member Sign up End -->

    </div>
    <!-- End Content -->

<?php
	include('sidebar.php');
	echo "<BR/><BR/><BR/>";
	include('sidefull.php');
	include('footer.php');
?>
						</div>
					<!-- End Content -->
				</div>
			<!-- End Main -->
		</div>
	</body>
</html>