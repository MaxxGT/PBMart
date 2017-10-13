<?php
include('header.php');
get_UsrInfo();

if(!isset($_SESSION['usr_name']))
{
	$message = "Please login to apply commercial! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}

$query_commercial = @mysql_query("SELECT COUNT(*) AS total FROM pbmart_commercial WHERE commercial_member_id = '$member_id'");
$row_commercial = @mysql_fetch_assoc($query_commercial);
$total = $row_commercial['total'];
if($total > 0 && $total == '1')
{
	$message = "You had been apply commercial before!.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='mycommercial.php?hyperlink=myaccount';</script>";
}
?>
<script>
	var _validFileExtensions = [".pdf"];    
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
		var regularE2 = /^[0-9]{6}-[0-9]{2}-[0-9]{4}|[0-9]{12}/;
		var regularE_ContactNum = /^[0-9]{3}-[0-9]{6}|[0-9]{9}|[0-9]{3}-[0-9]{8}|[0-9]{8}/;
		var mobValidation = /^[0-9]{10}|[0-9]{10}/;
		
		
		
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
		}else if(!cpy_number.match(com_numValidation))
		{
			document.getElementById("cpy_numbers").innerHTML="*Example: 123456-A";
			document.getElementById("cpy_number").focus();
			document.getElementById("cpy_number").scrollIntoView();
		}
		
		
		
		
		else if(cpy_contact_number == "")
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
			document.getElementById("cpy_ctys").innerHTML="*Please fill in city";
			document.getElementById("cpy_cty").focus();
			document.getElementById("cpy_cty").scrollIntoView();
		}else if(cpy_state == "")
		{
			document.getElementById("cpy_states").innerHTML="*Please fill in state";
			document.getElementById("cpy_state").focus();
			document.getElementById("cpy_state").scrollIntoView();
		}else if(cpy_country == "")
		{
			document.getElementById("cpy_countrys").innerHTML="*Please fill in country";
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
			document.getElementById("PrsIC_ic_numbers").innerHTML="*Please fill in ic number";
			document.getElementById("PrsIC_ic_number").focus();
			document.getElementById("PrsIC_ic_number").scrollIntoView();
		}
		
		else if (! PrsIC_ic_number.match(regularE2)){
           document.getElementById('PrsIC_ic_numbers').innerHTML =" *Invalid ic number";
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
		}else if(fileToUpload == "")
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
		}
		else
		{
			document.getElementById("commercial_form").submit();
		}
	}
	
	//http://stackoverflow.com/questions/6017350/i-need-javascript-function-to-disable-enter-key
	function noenter(e) 
	{
		e = e || window.event;
		var key = e.keyCode || e.charCode;
		return key !== 13; 
	}
	
	function isNumberKey(evt)
	{
         var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
	}

</script>

<html>
<TITLE>PBMART COMMERCIAL APPLICATION SETUP</TITLE>
<link rel="stylesheet" type="text/css" href="css/commercial/commercial.css">
<BODY>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<div id="main">
<form id="commercial_form" name="commercial_form" action="commercial/commercial_action.php" method="post" enctype="multipart/form-data">
	<table border='0' width="985px">
		<tr>
			<td width="225px" valign='top'><?php include "sidebar.php"; ?></td>
			<td width="100%" valign='top'>
				<table border='0'>
					<tr>
						<td>
							<h1> Commercial Application Setup </h1>
						</td>
					</tr>
				
					<tr>
						<td>&nbsp;</td>
					</tr>
					
				</table>
				
			<table border='0'>				
					
					<tr>
						<td colspan='2'><h2><font size='3'>Company Informations</font></h2></td>
					</tr>
					
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					<tr>
						<td><span style = "color:red">*</span> Company Name :</td>
						<td>
							<input type="text" id="cpy_name" name="cpy_name" SIZE="40" autofocus maxlength='100' onkeypress="return noenter(event)"></input>
							<span id="cpy_names" style="color:red"></span>
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> Company Number :</td>
						<td><input type="text" id="cpy_number" name="cpy_number" pattern="[0-9]{6}-[A-Z]{1}" SIZE="40" onkeypress="return noenter(event)" maxlength='8' placeholder="123456-A"></input>
							<span id="cpy_numbers" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> Contact Number :</td>
						<td><input type="text" id="cpy_contact_number" name="cpy_contact_number" SIZE="40" maxlength='11' onkeypress="return isNumberKey(event)"></input>
							<span id="cpy_contact_numbers" style="color:red" />
						</td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span> Address : </td>
						<td>
							<textarea id="cpy_addr" name="cpy_addr" rows="3" cols="39" maxlength='255' onkeypress="return noenter(event)"></textarea>
							<span id="cpy_addrs" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> City :</td>
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
							<!-- <input type="text" id="cpy_cty" name="cpy_cty" SIZE="40" onkeypress="return noenter(event)"></input> -->
							<span id="cpy_ctys" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> State :</td>
						<td><input type="text" id="cpy_state" name="cpy_state" SIZE="40" onkeypress="return noenter(event)"></input>
						<span id="cpy_states" style="color:red" /></td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span> Country :</td>
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
						<td><span style = "color:red">*</span> Post Code : </td>
						<td>
							<!-- <select id="cpy_pst_code" name="cpy_pst_code">
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
							<input type='text' id="cpy_pst_code" name="cpy_pst_code" maxlength="5" size="12" onkeypress="return isNumberKey(event)"></input>
							<span id="cpy_pst_codes" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					
					<tr>
						<td colspan='2'>
							<h2><font size='3'>Person In Charge</font></h2>
						</td>
					</tr>
					
					<tr>
						<td colspan='2'>&nbsp;</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> Full Name : </td>
						<td><input type="text" id="PrsIC_full_name" name="PrsIC_full_name" size="40" onkeypress="return noenter(event)"></input>
							<span id="PrsIC_full_names" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> IC Number : </td>
						<td><input type="text" id="PrsIC_ic_number" name="PrsIC_ic_number" pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}|[0-9]{12}" size="40" onkeypress="return noenter(event)" placeholder='123456-12-1234'></input>
							<span id="PrsIC_ic_numbers" style="color:red" />
						</td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span> Position : </td>
						<td><input type="text" id="PrsIC_position" name="PrsIC_position" size="40" onkeypress="return noenter(event)">
							<span id="PrsIC_positions" style="color:red" />
						</td>
					</tr>
					
					<!--<tr>				
						<td><span style = "color:red">*</span> Email : </td>
						<td><input type="email" id="PrsIC_user_email" name="PrsIC_user_email" size="40"></td>
					</tr>
				<tr>				
					<td><span style = "color:red">*</span> Telephone :  </td>
					<td><input type="text" id="PrsIC_tel" name="PrsIC_tel" pattern="[0-9]{3}-[0-9]*|[0-9]{6}" size="40" maxlength='12' onKeyPress="return isNumberKey(event)"></input></td>
				</tr>-->
				
				<tr>				
					<td> Mobile Number : </td>
					<td><input type="text" id="PrsIC_mobile" name="PrsIC_mobile" pattern="[0-9]{3}-[0-9]*|[0-9]{8}" size="40" maxlength='12' onkeypress="return isNumberKey(event)"></input>
						<span id="PrsIC_mobiles" style="color:red" />
					</td>
				</tr>
				
					<!--<tr>				
						<td><span style = "color:red">*</span> Address : </td>
						<td><textarea id="PrsIC_addr" name="PrsIC_addr" rows="3" cols="39" ></textarea></td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> City :</td>
						<td><input type="text" id="PrsIC_cty" name="PrsIC_cty" SIZE="40"></input></td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> State :</td>
						<td><input type="text" id="PrsIC_state" name="PrsIC_state" SIZE="40"></input></td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span> Country : </td>
						<td>
							<select id="PrsIC_country" name="PrsIC_country">
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
						</td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span> Post Code : </td>
						<td>
							<select id="PrsIC_pst_code" name="PrsIC_pst_code">
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
							</select>
						</td>
					</tr> -->
					
					<tr>
						<td colspan='2'>
							&nbsp;
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> FORM 49 (PDF): </td>
						<td><input type="file" name="fileToUpload" id="fileToUpload" onchange="ValidateSingleInput(this, 'fileToUploads');" />
							<span id="fileToUploads" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> FORM 24 (PDF): </td>
						<td><input type="file" name="fileToUpload2" id="fileToUpload2" onchange="ValidateSingleInput(this, 'fileToUpload2s');" />
							<span id="fileToUpload2s" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span> FORM 9 (PDF): </td>
						<td><input type="file" name="fileToUpload3" id="fileToUpload3" onchange="ValidateSingleInput(this, 'fileToUpload3s');" />
							<span id="fileToUpload3s" style="color:red" />
						</td>
					</tr>
					
					<tr>
						<td colspan='2'>
							&nbsp;
						</td>
					</tr>
					
					<tr align="center">
						<td align="left" colspan="2">
							<strong><font size="2">Note: All fields marked with "<span style = "color:red">*</span>" are mandatory</font></strong>
							<input type="button" class="button_acc" Value="Apply Commercial" title="Click to apply Commercial" onclick="validation_company_name();"></input>
							<input type="hidden" name="act" value="add"></input>
						</td>
					</tr>
			</table>
			</td>
		</tr>
	</table>
</form>
	</div>
	<div style="
height:51px; width:940px; background:#ebebeb; white-space:nowrap; line-height:50px; padding:0 15px; color:#7b7b7b; position:absolute; bottom:0;
"
>
		<?php include "footer.php"; ?>
	</div>
</BODY>
</HTML>