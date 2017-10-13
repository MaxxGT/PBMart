<?php
include('header.php');
require_once("connection/pbmartconnection.php");
?>
<link rel="stylesheet" type="text/css" href="css/button.css">

<script type="text/javascript">
    function username_validation(str)
    {
        if (str=="")
          {
          document.getElementById("q").innerHTML="";
          return;
          } 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
				document.getElementById("usernames").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","account_ajax.php?q="+str,true);
        xmlhttp.send();
    }
</script>	
	
<script type="application/javascript">
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
</script>

<script language=JavaScript>
	function autoSubmit() {
	var formObject = document.forms['mbr_sign_upfrm'];
		formObject.submit();
	}
</script>

<script>
function myFunction() {
	if(document.getElementById("International_chk").checked)
	{
		
		document.getElementById("nationality").disabled = false;
		document.getElementById("passport_number").disabled = false;
		
		document.getElementById("ic_number").value="";
		document.getElementById("ic_number").disabled = true;
	}else
	{
		
		document.getElementById("nationality").disabled = true;
		document.getElementById("passport_number").disabled = true;
		
		document.getElementById("ic_number").disabled = false;
	}



	if(document.getElementById("flt_dlvy_chk").checked)
	{	
		document.getElementById("flr_num").value="1";
		document.getElementById("flr_num").disabled = false;
	}else
	{
		document.getElementById("flr_num").value="1";
		document.getElementById("flr_num").disabled = true;
	}
}
</script>

<script language=JavaScript>
	function disable_inputField()
	{
		if(document.getElementById("bil_add_chk").checked)
		{
			document.getElementById("house_no2").disabled = false;
			document.getElementById("street_name2").disabled = false;
			document.getElementById("city2").disabled = false;
			document.getElementById("region_state2").disabled = false;
			document.getElementById("country2").disabled = false;
			document.getElementById("pst_code2").disabled = false;
			
		}else
		{
			document.getElementById("house_no2").disabled = true;
			document.getElementById("house_no2").value ="";
			document.getElementById("street_name2").disabled = true;
			document.getElementById("street_name2").value = "";
			document.getElementById("city2").disabled = true;
			document.getElementById("region_state2").disabled = true;
			document.getElementById("country2").disabled = true;
			document.getElementById("pst_code2").disabled = true;
		}
	}
</script>

<script>
//http://stackoverflow.com/questions/18032220/css-change-image-src-on-imghover
function hover(element) {
    element.setAttribute('src', 'css/images/icon_idea_light.png');
}
function unhover(element) {
    element.setAttribute('src', 'css/images/icon_idea.png');
}
function validate_input()
{
	var usrnameValidation = /\s/g;
	var ICValidation = /^[0-9]{6}-[0-9]{2}-[0-9]{4}|[0-9]{12}/;
	var PassportValidation = /^[A-Z]{1}[0-9]{7}/;
	var emailValidation = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var telValidation = /^[0-9]{9}/;
	var mobValidation = /^[0-9]{10}|[0-9]{10}/;
	
	var username = document.getElementById("username").value;
	var first_name = document.getElementById("first_name").value;
	var last_name = document.getElementById("last_name").value;
	var ic_number = document.getElementById("ic_number").value;
	var nationality = document.getElementById("nationality").value;
	var passport_number = document.getElementById("passport_number").value;
	
	var user_email = document.getElementById("user_email").value;
	
	var mobile = document.getElementById("mobile").value;
	var addr2 = document.getElementById("addr2").value;
	var city = document.getElementById("city").value;
	var region_state = document.getElementById("region_state").value;
	var country = document.getElementById("country").value;
	var pst_code = document.getElementById("pst_code").value;
	var user_psd = document.getElementById("user_psd").value;
	var user_psd2 = document.getElementById("user_psd2").value;
	
	document.getElementById("usernames").innerHTML="";
	document.getElementById("first_names").innerHTML="";
	document.getElementById("last_names").innerHTML="";
	document.getElementById("ic_numbers").innerHTML="";
	document.getElementById("nationalitys").innerHTML="";
	document.getElementById("passport_numbers").innerHTML="";
	
	
	document.getElementById("user_emails").innerHTML="";
	
	document.getElementById("mobiles").innerHTML="";
	document.getElementById("addr2s").innerHTML="";
	document.getElementById("citys").innerHTML="";
	document.getElementById("region_states").innerHTML="";
	document.getElementById("countrys").innerHTML="";
	document.getElementById("pst_codes").innerHTML="";
	document.getElementById("user_psds").innerHTML="";
	document.getElementById("user_psd2s").innerHTML="";
	
	if(username == "")
	{
		document.getElementById("usernames").innerHTML="*Please fill in username";
		document.getElementById("username").focus();
	}else if(username.length < 6)
	{
		document.getElementById("usernames").innerHTML="*Username must be at least 6 characters.";
		document.getElementById("username").focus();
	}else if(username.match(usrnameValidation))
	{
		document.getElementById("usernames").innerHTML="*Username cannot contain space.";
		document.getElementById("username").focus();
	}
	else if(first_name == "")
	{
		document.getElementById("first_names").innerHTML="*Please fill in first name";
		document.getElementById("first_name").focus();
	}else if(last_name == "")
	{
		document.getElementById("last_names").innerHTML="*Please fill in last name";
		document.getElementById("last_name").focus();
	}
	else if(document.getElementById("International_chk").checked)
	{
		if(nationality == "")
		{
			document.getElementById("nationalitys").innerHTML="*Please fill in Nationality";
			document.getElementById("nationality").focus();
		}
		else if(passport_number == "")
		{
			document.getElementById("passport_numbers").innerHTML="*Please fill in Passport Number";
			document.getElementById("passport_number").focus();
		}else if(!passport_number.match(PassportValidation))
		{
			document.getElementById("passport_numbers").innerHTML="*Invalid Passport Number!";
			document.getElementById("passport_number").focus();
		}
		else if(user_email == "")
		{
			document.getElementById("user_emails").innerHTML="*Please fill in Email";
			document.getElementById("user_email").focus();
		}else if(!user_email.match(emailValidation))
		{
			document.getElementById("user_emails").innerHTML="*Please enter a valid email address.";
			document.getElementById("user_email").focus();
		}
		
		else if(mobile == "")
		{
			document.getElementById("mobiles").innerHTML="*Please fill in contact number";
			document.getElementById("mobile").focus();
		}
		
		else if(addr2 == "")
		{
			document.getElementById("addr2s").innerHTML="*Please fill in address";
			document.getElementById("addr2").focus();
		}else if(city == "")
		{
			document.getElementById("citys").innerHTML="*Please select city";
			document.getElementById("city").focus();
		}else if(region_state == "")
		{
			document.getElementById("region_states").innerHTML="*Please select state";
			document.getElementById("region_state").focus();
		}else if(country == "")
		{
			document.getElementById("countrys").innerHTML="*Please select country";
			document.getElementById("country").focus();
		}else if(pst_code == "")
		{
			document.getElementById("pst_codes").innerHTML="*Please fill in postal/zip code";
			document.getElementById("pst_code").focus();
		}else if(pst_code.length < 5)
		{
			document.getElementById("pst_codes").innerHTML="*Invalid postal/zip code! Please try again!";
			document.getElementById("pst_code").focus();
		}else if(user_psd == "")
		{
			document.getElementById("user_psds").innerHTML="*Please fill in password";
			document.getElementById("user_psd").focus();
		}else if(user_psd.length < '6')
		{
			document.getElementById("user_psds").innerHTML="*Password must contain at least 6 characters.";
			document.getElementById("user_psd").focus();
		}else if(user_psd2 == "")
		{
			document.getElementById("user_psd2s").innerHTML="*Please fill in password";
			document.getElementById("user_psd2").focus();
		}else if(user_psd2.length < '6')
		{
			document.getElementById("user_psd2s").innerHTML="*Password must contain at least 6 characters.";
			document.getElementById("user_psd2").focus();
		}
		else
		{
			document.getElementById("register_form").submit();
		}
	}else if(!document.getElementById("International_chk").checked)
	{
		if(ic_number == "")
		{
			document.getElementById("ic_numbers").innerHTML="*Please fill in IC number";
			document.getElementById("ic_number").focus();
		}
		else if (!ic_number.match(ICValidation)){
			   document.getElementById('ic_numbers').innerHTML ="*Invalid IC number! Example: 123456-12-1234";
			   document.getElementById("ic_number").focus();
		}else if (ic_number.length !='14'){
			   document.getElementById('ic_numbers').innerHTML ="*Invalid IC number! Example: 123456-12-1234";
			   document.getElementById("ic_number").focus();
		}else if(user_email == "")
		{
			document.getElementById("user_emails").innerHTML="*Please fill in Email";
			document.getElementById("user_email").focus();
		}else if(!user_email.match(emailValidation))
		{
			document.getElementById("user_emails").innerHTML="*Please enter a valid email address.";
			document.getElementById("user_email").focus();
		}
		
		else if(mobile == "")
		{
			document.getElementById("mobiles").innerHTML="*Please fill in contact number";
			document.getElementById("mobile").focus();
		}
		
		else if(addr2 == "")
		{
			document.getElementById("addr2s").innerHTML="*Please fill in address";
			document.getElementById("addr2").focus();
		}else if(city == "")
		{
			document.getElementById("citys").innerHTML="*Please select city";
			document.getElementById("city").focus();
		}else if(region_state == "")
		{
			document.getElementById("region_states").innerHTML="*Please select state";
			document.getElementById("region_state").focus();
		}else if(country == "")
		{
			document.getElementById("countrys").innerHTML="*Please select country";
			document.getElementById("country").focus();
		}else if(pst_code == "")
		{
			document.getElementById("pst_codes").innerHTML="*Please fill in postal/zip code";
			document.getElementById("pst_code").focus();
		}else if(pst_code.length < 5)
		{
			document.getElementById("pst_codes").innerHTML="*Invalid postal/zip code! Please try again!";
			document.getElementById("pst_code").focus();
		}else if(user_psd == "")
		{
			document.getElementById("user_psds").innerHTML="*Please fill in password";
			document.getElementById("user_psd").focus();
		}else if(user_psd.length < '6')
		{
			document.getElementById("user_psds").innerHTML="*Password must contain at least 6 characters.";
			document.getElementById("user_psd").focus();
		}else if(user_psd2 == "")
		{
			document.getElementById("user_psd2s").innerHTML="*Please fill in password";
			document.getElementById("user_psd2").focus();
		}else if(user_psd2.length < '6')
		{
			document.getElementById("user_psd2s").innerHTML="*Password must contain at least 6 characters.";
			document.getElementById("user_psd2").focus();
		}
		else
		{
			document.getElementById("register_form").submit();
		}
	}else
	{
		document.getElementById("register_form").submit();
	}
}

//http://stackoverflow.com/questions/6714202/how-can-i-disable-the-enter-key-on-my-textarea
function TriggeredKey(e)
{
        var keycode;
        if (window.event)
		{			
			keycode = window.event.keyCode;
        }
		if (window.event.keyCode == 13 ) 
		{	
			event.preventDefault();
		}
}
</script>
		
	<table border='0' width='100%'>
		<tr>
			<td valign='top' width='200px'>
				<?php include('sidebar.php'); ?>
			</td>
			<td>
				<BR/>
				<!-- Member Sign in -->
			<?php include('account_login.php'); ?>
				<!-- Member Sign in End-->
				
				<!-- Member Sign up -->
				<table border="0" name="mbr_sign_up">
					<form id="register_form" name="register_form" action="register_action.php" method="post">
						<tr>
							<td colspan='4'>
								
								<h2> <strong>New Member Registration</strong></h2> <br />
							</td>
						</tr>
						
						<tr>
							<td colspan='4'>
								
								<tr>
									<td>&nbsp; Introducer : </td>
									<td><input type="text" id="introducer" name="introducer" size="35" autofocus/></td>
									<td></td>
									<td><span id="introducers" style="color:red"></span></td>
								</tr>
								
								<tr>
									<td><span style = "color:red">*</span> Username : </td>
									<td><input type="text" id="username" name="username" size="35" maxlength='50' onblur="username_validation(this.value);" autofocus></td>
									<td colspan='2'><span id="usernames" style="color:red"></span></td>
								</tr>
								<tr>
									<td><span style = "color:red">*</span> First Name : </td>
									<td><input type="text" id="first_name" name="first_name" size="35" maxlength='50' autofocus></td>
									<td></td>
									<td><span id="first_names" style="color:red"></span></td>
								</tr>
								<tr>				
									<td><span style = "color:red">*</span> Last Name : </td>
									<td><input type="text" id="last_name" name="last_name" size="35" maxlength='50'></input></td>
									<td></td>
									<td><span id="last_names" style="color:red"></span></td>
								</tr>
								
								<tr>
									<td><span style = "color:red">*</span> IC Number : </td>
									<td><input type="text" id="ic_number" name="ic_number" pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}|[0-9]{12}" size="35" maxlength='14' placeholder="123456-12-1234" onKeyPress="return isNumberKey2(event)"></input></td>
									<td></td>
									<td><span id="ic_numbers" style="color:red"></span></td>
								</tr>
								
								<tr>
									<td><span style = "color:red">*</span> Nationality : </td>
									<td><input type="text" id="nationality" name="nationality" size="35" maxlength='50' disabled></input></td>
									<td><span id="nationalitys" style="color:red"></span></td>
								</tr>
								
								<tr>
									<td><span style = "color:red">*</span> Passport Number : </td>
									<td><input type="text" id="passport_number" name="passport_number" size="35" maxlength='10' disabled></input></td>
									<td>International <input type='checkbox' id="International_chk" name="International_chk" onclick='myFunction();'></input>
									</td>
									<td><span id="passport_numbers" style="color:red"></span></td>
								</tr>
								
								
								<tr>				
									<td><span style = "color:red">*</span> Email : </td>
									<td><input type="email" id="user_email" name="user_email" size="35" maxlength='50'></td>
									<td></td>
									<td><span id="user_emails" style="color:red"></span></td>
								</tr>
								<!-- <tr>				
									<td> &nbsp;&nbsp;Telephone :  </td>
									<td><input type="text" id="tel" name="tel" pattern="[0-9]{3}-[0-9]*|[0-9]{6}" size="35" maxlength='9' onKeyPress="return isNumberKey(event)"></input></td>
									
									<td><span id="tels" style="color:red"></span></td>
								</tr>
								<tr>
									<td></td>
									<td>
									(number only, ex. 082123456)
									</td>
									<td></td>
									<td></td>
								</tr> -->
								<tr>				
									<td><span style = "color:red">*</span> Contact Number : </td>
									<td><input type="text" id="mobile" name="mobile" pattern="[0-9]{3}-[0-9]*|[0-9]{8}" size="35" maxlength='11' onKeyPress="return isNumberKey(event)"></input></td>
									<td>
										<img id="my-img" src="css/images/icon_idea.png" title="*Note: Please provide the correct contact number so that our salesman can contact you for delivery." onmouseover="hover(this);" onmouseout="unhover(this);" />
									</td>
									<td><span id="mobiles" style="color:red"></span></td>
								</tr>
								
							</td>
						</tr>
						
						<tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
											
							<tr align="center">
								<td colspan="2"><strong> Delivery Address </strong></td>
								<td></td>
								<td></td>
								
							</tr>
											
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>

							<tr>				
								<td><span style = "color:red">*</span> Address  : </td>
								<td><textarea id="addr2" name="addr2" rows="4" cols="35" maxlength='255' onkeypress="TriggeredKey(event);"></textarea></td>
								<td></td>
								<td><span id="addr2s" style="color:red"></span></td>
							</tr>
							
							<tr>				
								<td><span style = "color:red">**</span> Floor  : </td>
								<td><input type="number" name="flr_num" id="flr_num" value="1" maxlength="1" min="1" max="100" disabled></input></td>
								<td>Flat Delivery <input type='checkbox' id="flt_dlvy_chk" name="flt_dlvy_chk" onclick='myFunction();'></input></td>
								<td></td>
							</tr>

							<tr>
								<td colspan='4'><font color='red'><B>** FOR FLAT DELIVERY, RM1.00 WILL BE CHARGED PER FLOOR</B></font></td>
							</tr>
							<tr>				
								<td><span style = "color:red">*</span> City : </td>
								<td>
									<select id="city" name="city" style="font-family: verdana; font-size: 12px;">
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
								</td>
								<td></td>
								<td><span id="citys" style="color:red"></span></td>	
							</tr>
									
							<tr>				
								<td><span style = "color:red">*</span> State : </td>
								<td>
									<select id="region_state" name="region_state" style="font-family: verdana; font-size: 12px;">
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
								</td>
								<td></td>
								<td><span id="region_states" style="color:red"></span></td>
							</tr>
											
							<tr>				
								<td><span style = "color:red">*</span> Country : </td>
								<td>
									<select id="country" name="country">
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
								<td></td>
								<td><span id="countrys" style="color:red"></span></td>		
												
								
							</tr>
							
							<tr>				
								<td><span style = "color:red">*</span> Postal/Zip Code : </td>
								<td>
									<!--<select id="pst_code" name="pst_code">
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
									</select>-->
									<input type="text" id="pst_code" name="pst_code" size='12' maxlength='5' onKeyPress="return isNumberKey(event)"></input>
								</td>
								<td></td>
								<td><span id="pst_codes" style="color:red"></span></td>
							</tr>
							
							<tr>	
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td colspan="2"><strong><center> Password </center></strong></td>
								<td></td>
								<td></td>
							</tr>
							
							<tr>	
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							
							<tr>				
								<td><span style = "color:red">*</span> Account Password : </td>
								<td><input type="password" id="user_psd" name="user_psd" maxlength='50'></input></td>
								<td></td>
								<td><span id="user_psds" style="color:red"></span></td>
							</tr>
											
							<tr>
								<td><span style = "color:red">*</span> Confirm Password : </td>
								<td><input type="password" id="user_psd2" name="user_psd2" maxlength='50'></input></td>
								<td></td>
								<td><span id="user_psd2s" style="color:red"></span></td>
							</tr>
							
							<tr>			
								<td>
									&nbsp;
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
					
							<tr align="center">
								<td align="left" colspan="4">
									<strong>
										<font size="2">Note: All fields marked with "<span style = "color:red">*</span>" are mandatory</font>
									</strong>&nbsp;
									<input class="button_acc" type="button" Value="Create Account" title="Click to create account" onclick="validate_input();"></input>
								</td>
								
								<input type="hidden" name="act" value="add"></input>
							</tr>
						</tr>
					</form>
				</table>
		<!-- Member Sign up End -->
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<?php
					include('sidefull.php');
					
				?>
			</td>
		</tr>
	</table>
	
		<?php include('footer.php'); ?>	
	
	</body>
</html>