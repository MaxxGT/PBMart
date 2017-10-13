<?php
// Author: VOONG TZE HOWE
// Date Writen: 06-11-2014
// Description : myaccount
// Last Modification: 07-11-2014

// Last Modification: 16-12-2014
// Description: Remove billing address field

include('header.php');
include('encrypt_decrypt.php');
get_UsrInfo();

if(!isset($_SESSION['usr_name']))
{
	$message = "Please login your account! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}

if(isset($_GET['act']) && $_GET['act']=="edit")
{
	include("connection/pbmartconnection.php");
}

if($member_flat_status == '0')
{
	$flr_num_disabled = "disabled";
	$flt_dlvy_chked = "";
}else
{
	$flr_num_disabled = "";
	$flt_dlvy_chked = "checked";
}
?>
<script type="text/javascript" src="jscss/lib.js"></script>
<script type="text/javascript" src="jscss/facebox.js"></script>
<script type="text/javascript" src="jscss/val.js"></script>
<script type="text/javascript" src="jscss/dtp.js"></script>
<link rel="stylesheet" type="text/css" href="css/button.css">
<link rel="stylesheet" type="text/css" href="jscss/slimbox_ex.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscss/data.css" media="screen" />

<html>
	<body>

  <!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
    <!-- Content -->
    <div id="content">
	
<script language=JavaScript>
function submitForm() 
{	
	var result = confirm("Save profile information?");
	var formObject = document.forms['myaccountform'];
	if(result == true)
	{
		formObject.submit();
	}
}
</script>
<script type="application/javascript">
//http://stackoverflow.com/questions/18032220/css-change-image-src-on-imghover
function hover(element) {
    element.setAttribute('src', 'css/images/icon_idea_light.png');
}
function unhover(element) {
    element.setAttribute('src', 'css/images/icon_idea.png');
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
function myFunction() {
	if(document.getElementById("flt_dlvy_chk").checked)
	{	
		document.getElementById("flr_num").value="";
		document.getElementById("flr_num").disabled = false;
	}else
	{
		document.getElementById("flr_num").value="";
		document.getElementById("flr_num").disabled = true;
	}
}
</script>

<table border='0'>
				<tr>
					<td>
					
						<strong>
							<font size="5">Orders</font>
						</strong>
					<BR/>
					<BR/>
					</td>
				</tr>
				
				<tr>
					<td>
						<!-- <a href="order.php?hyperlink=product" target="_new" style="text-decoration: none;">View my orders history?</a> -->
						<input type="button" class="blue_button" value="View My Orders History" onclick="window.location.href='order.php?hyperlink=product'"></input>
					</td>
				</tr>
				
				<tr>
					<td>
						<BR><strong><font size="5">Commercial Application</font></strong><BR><BR>
					</td>
				</tr>
				
				<tr>
					<td>
				<?php
					$query_commercial = @mysql_query("SELECT COUNT(*) AS total FROM pbmart_commercial WHERE commercial_member_id = '$member_id'");
					$row_commercial = @mysql_fetch_assoc($query_commercial);
					$total = $row_commercial['total'];
					if($total > 0 && $total == '1')
					{
						//echo "<a href='mycommercial.php?hyperlink=myaccount' style='text-decoration: none;' target='_new'><font size='2'> <font size='1'>>></font> View my Commercial Information</font></a>";
					?>	
						<input type="button" class="blue_button" value="View My Commercial Information" onclick="window.location.href='mycommercial.php?hyperlink=myaccount'"></input>
					<?php
					}else
					{
						//echo "<a href='commercial.php?hyperlink=myaccount' style='text-decoration: none;' target='_new'><font size='2'> <font size='1'>>></font> Click to apply Commercial</font></a>";
						?> 
							<input type="button" class="blue_button" value="Click to apply Commercial" onclick="window.location.href='commercial.php?hyperlink=myaccount'"></input>
						<?php 
					}
				?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
				</tr>
</table>

		<!-- Member Sign in -->
			<h1><strong>Personal Account</strong></h1><br />
		<!-- Member Sign in End-->
		
<!-- Member Sign up -->
<form name="myaccountform" action="myaccount_action.php" method="post">
<table border="0" name="mbr_sign_up">

				

				<tr>
					<td colspan="4">----------------------------------------------------------------------------------------------------------------</td>
				</tr>
				<tr>
					
					<td><strong><font size="4">Profile Information</font></strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				
				<?php
				if(isset($_GET['act']))
				{
					$act = $_GET['act'];
				}else
				{
					$act = "";
				}
				
					if($act == "" OR $act == "update")
					{ ?>
						<td align="right"><a href="myaccount.php?act=edit&hyperlink=myaccount" title="edit profile infomation"><img src="icon/red_editinfo.png" width="80px" height="25px"></img></a></td>
			  <?php }else if($act == "edit")
					{ ?>
						<td align="right"><a href="#" title="save profile infomation" onclick='submitForm();'><img src="icon/red_saveinfo.png" width="80px" height="25px"></img></a></td>
			  <?php } ?>
					
				</tr>
				
				<tr>
					<td>&nbsp;</td>
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
					<td><span style = "color:red">*</span><B> Introducer : </B></td>
					<td><font color='black'>
						<?php 
						if($member_introducer !="")
						{
							echo $member_introducer;
						}else
						{
							echo "-";
						}
						?>
						<input type="hidden" id="introducer" name="introducer" value="<?php echo $member_introducer; ?>" />
						</font>
					</td>
					<!--<td>
					<?php
						$introducer = explode("PB",$member_introducer);
						$itr = explode("/", $introducer[1]);
					?>
					PB
					<input type="text" id="introducer" name="introducer" size="5" maxlength='4' placeholder="0001" value="<?php echo $itr[0]; ?>" autofocus/> /
						<select id="alp" name="alp">
								<?php
									foreach(range('A','Z') as $i)
									{ ?>
										<option value="<?php echo $i; ?>" <?php if(isset($itr[1]) && $itr[1] == $i){echo 'selected';} ?>><?php echo $i; ?></option>
								<?php } ?>
									
								
						</select>
					</td> -->
					<td></td>
					<td><span id="introducers" style="color:red"></span></td>
				</tr>
			
					<tr>
						<td><span style = "color:red">*</span><strong> Username :  </strong></td>
						<td><input type="text" id="username" name="username" value="<?php if(isset($member_username)){echo $member_username;}?>" size="35" maxlength="50"></input></td>
					</tr>
					
					<tr>
						<td><span style = "color:red">*</span><strong> First Name :  </strong></td>
						<td><input type="text" id="first_name" name="first_name" value="<?php if(isset($member_first_name)){echo $member_first_name;}?>" size="35" maxlength="50"></input></td>
					</tr>
					<tr>				
						<td><span style = "color:red">*</span><strong> Last Name : </strong></td>
						<td><input type="text" id="last_name" name="last_name" value="<?php echo $member_last_name;?>" size="35" maxlength="50"></input></td>
					</tr>
					
					<tr>
							<td><span style = "color:red">*</span><strong> Nationality : </strong></td>
							<td><input type="text" id="nationality" name="nationality" value="<?php echo $member_nationality;?>" size="35" maxlength="50"></input></td>
					</tr>
					
				<?php
					if($member_ic != "" && $member_ic != "-")
					{ ?>
						<tr>
							<td><span style = "color:red">*</span><strong> IC Number : </strong></td>
							<td><font color='black'>
								<?php echo $member_ic; ?>
								</font>
								<input type="hidden" id="ic_number" name="ic_number" value="<?php echo $member_ic; ?>" />
							</td>
						</tr>
				<?php }else if($member_passport_number !="" && $member_passport_number != "-")
				{ ?>
						<tr>
							<td><span style = "color:red">*</span><strong> Passport Number : </strong></td>
							<td>
								<font color='black'>
									<?php echo $member_passport_number; ?>
									<input type="hidden" id="passport_number" name="passport_number" value="<?php echo $member_passport_number; ?>" />
								</font>
							</td>
						</tr>
					
			<?php } ?>

					<tr>				
						<td><span style = "color:red">*</span><strong> Email : </strong></td>
						<td><input type="email" id="user_email" name="user_email" value="<?php echo $member_email; ?>" size="35" maxlength="50"></input></td>
					</tr>
					
					<tr>				
						<td><span style = "color:red">*</span><strong> Contact Number : </strong></td>
						<td><input type="text" id="mobile" name="mobile" value="<?php echo $member_contact; ?>" size="35" maxlength='11' onKeyPress="return isNumberKey(event)"></input></td>
						<td>
						<img id="my-img" src="css/images/icon_idea.png" title="*Note: Please provide the correct contact number so that our salesman can contact you for delivery." onmouseover="hover(this);" onmouseout="unhover(this);" />
					</td>
					</tr>
		  <?php }else
				{?>
					<tr>
						<td><strong>Introducer : </strong></td>
						<td><?php 
							if($member_introducer !="")
							{
								echo $member_introducer;
							}else
							{
								echo "-";
							}
							?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					
					<tr>
						<td><strong>Username : </strong></td>
						<td><?php echo $member_username;?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					
					<tr>
						<td><strong>First Name : </strong></td>
						<td><?php echo $member_first_name;?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>				
						<td><strong>Last Name : </strong></td>
						<td><?php echo $member_last_name;?></td>
					</tr>
					
					<tr>
						<td><strong>Nationality : </strong></td>
						<td><?php echo $member_nationality; ?></td>
					</tr>
					
					<tr><?php
							if($member_ic != "" && $member_ic !="-")
							{ ?>
								<td><strong>IC Number : </strong></td>
								<td><?php echo $member_ic; ?></td>
					  <?php }else
							{ ?>
							
							<tr>
								<td><strong>Passport Number : </strong></td>
								<td><?php echo $member_passport_number; ?></td>
							</tr>
					  <?php } ?>
						
					
					<tr>				
						<td><strong>Email : </strong></td>
						<td><?php echo $member_email; ?></td>
					</tr>
					
					<tr>				
						<td><strong>Contact Number : </strong></td>
						<td><?php echo $member_contact; ?></input></td>
					</tr>
		  <?php } ?>

			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
							
			<tr align="left">
			<td colspan="2"><strong><font size="4"> Home Address </font></strong></td>
			
			</tr>
							
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>			
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<?php
			if($act == "edit")
			{ ?>
								
			<tr>				
				<td><span style = "color:red">*</span><strong> Address :</strong></td>
				<td><textarea id="street_name" name="street_name" rows="4" cols="35" maxlength="255" onkeypress="TriggeredKey(event);"><?php echo $member_street_name; ?></textarea></td>
			</tr>

					<tr>
						<td><span style = "color:red">**</span><strong> Floor :</strong></td>

						<td>
							<select id="flr_num" name="flr_num" <?php echo $flr_num_disabled; ?>>
								<option value="">- Select Floor -</option>
								<?php
									for($i='1'; $i<101; $i++)
									{
										?>
										<option value="<?php echo $i; ?>" <?php if(isset($member_flat_floor) && $member_flat_floor == $i){echo 'selected';} ?>><?php echo $i; ?></option>
							  <?php }
								?>
							</select>
						</td>
						<td>
							Flat <input type='checkbox' id="flt_dlvy_chk" name="flt_dlvy_chk" <?php echo $flt_dlvy_chked; ?> onclick='myFunction();'></input>
						</td>
					</tr>
					<tr>
						<td colspan='2'> 
							<font color="FF0000" size='2'>
								<B>**FOR FLAT DELIVERY, RM1.00 WILL BE CHARGED PER FLOOR</B>
							</font>
						</td>
					</tr>
			<tr>				
				<td><span style = "color:red">*</span><strong> City : </strong></td>
				<td>
					<select id="city" name="city" style="font-family: verdana; font-size: 12px;">
						<option value="">--Select--</option>
							
							<?php
								$sql_pbmart_city = "Select * FROM pbmart_service_city";
								$rs_city = mysql_query($sql_pbmart_city, $link);
								while($rw_city = mysql_fetch_array($rs_city))
								{
									$service_city = $rw_city['service_city'];
									if($service_city == $member_city)
									{
										$svr_city = "selected";
									}
									?>
									
									<option value="<?php echo $service_city; ?>" <?php if(isset($svr_city)){echo $svr_city; } ?>><?php echo $service_city; ?></option>
							<?php $svr_city= ""; } ?>
					</select>				
				</td>
								
				
			</tr>
			
			<tr>				
				<td><span style = "color:red">*</span><strong> State : </strong></td>
				<td>
					<select id="region_state" name="region_state" style="font-family: verdana; font-size: 12px;">
						<option value="">--Select--</option>
							<?php
								$sql_pbmart_state = "Select * FROM pbmart_service_state";
								$rs_state = mysql_query($sql_pbmart_state, $link);
								while($rw_state = mysql_fetch_array($rs_state))
								{
									$service_state = $rw_state['service_state'];
									if($service_state == $member_state)
									{
										$srv_state = "selected";
									}
									?>
									
									<option value="<?php echo $service_state; ?>"<?php if(isset($srv_state)){echo $srv_state; } ?>><?php echo $service_state; ?></option>
							<?php $srv_state=""; } ?>	
					</select>
				</td>
			</tr>
							
			<tr>				
				<td><span style = "color:red">*</span><strong> Country :</strong></td>
				<td>
					<select name="country">
					<option value="">--Select--</option>
						<?php
								$sql_pbmart_country = "Select * FROM pbmart_service_country";
								$rs_country = mysql_query($sql_pbmart_country, $link);
								while($rw_country = mysql_fetch_array($rs_country))
								{
									$service_country = $rw_country['service_country'];
									if($rw_country['service_country'] == $member_country)
									{
										$srv_country = "selected";
									}
									?>
									
									<option value="<?php echo $service_country; ?>" <?php if(isset($srv_country)){echo $srv_country;} ?>><?php echo $service_country; ?></option>
							<?php 
										$srv_country="";
								  } ?>
					</select>
				</td>
								
				
			</tr>
			
			<tr>				
				<td><span style = "color:red">*</span> <strong>Postal/Zip Code :</strong></td>
				<td>
					<!-- <select id="pst_code" name="pst_code">
						<option value="">--Select--</option>
						<?php
								$sql_pbmart_pst_code = "Select * FROM pbmart_service_postcode";
								$rs_pst_code = mysql_query($sql_pbmart_pst_code, $link);
								while($rw_pst_code = mysql_fetch_array($rs_pst_code))
								{
									$service_pst_code = $rw_pst_code['post_code'];
									if($service_pst_code == $member_postcode)
									{
										$srv_pst_code = "selected";
									}
									?>
									
									<option value="<?php echo $service_pst_code; ?>" <?php if(isset($srv_pst_code)){echo $srv_pst_code; }?>><?php echo $service_pst_code; ?></option>
							<?php } ?>
					</select> -->
					<input type="text" id="pst_code" name="pst_code" size='10' maxlength='5' value="<?php echo $member_postcode; ?>" onKeyPress="return isNumberKey(event)"></input>
				</td>
								
				
			</tr>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan="4">-----------------------------------------------------------------------------------------------------------------</td>
			</tr>
			
		<input type="hidden" name="act" value="update"></input>
</form>
	  <?php }else
			{ ?>
				<tr>				
					<td><strong>Address : </strong></td>
					<td><?php echo $member_street_name; ?></td>
				</tr>

				<?php
					if($member_flat_floor !='0')
					{ ?>
						<tr>				
							<td><strong>Floor : </strong></td>
							<td><?php echo $member_flat_floor; ?></td>
						</tr>
				<?php } ?>
				
				<tr>				
					<td><strong>City : </strong></td>
					<td>
						<?php echo $member_city; ?>			
					</td>
				</tr>
						
				<tr>				
					<td><strong>State : </strong></td>
					<td>
						<?php echo $member_state; ?>
					</td>
				</tr>
								
				<tr>				
					<td><strong>Country : </strong></td>
					<td>
						<?php echo $member_country; ?>
					</td>
				</tr>
				
				<tr>				
					<td><strong>Postal/Zip Code : </strong></td>
					<td><?php echo $member_postcode; ?></td>
				</tr>
				
				<tr>
					<td colspan="4">-----------------------------------------------------------------------------------------------------------------</td>
				</tr>
	  <?php } ?>
	  
				<tr>
				<td colspan="4" align="right">
					&nbsp;
				</td>
			</tr>
			
			<tr>
				<td colspan="4"><strong><font size="4">Member Points/Tokens</font></strong></td>
			</tr>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			
			<tr>
				<td><font size="3">Accumulated Member Points: </font></td>
				<td><b><?php echo $member_point; ?></b></td>
				<td></td>
				<td></td>
			</tr>
			
			<BR/><BR/>
			
			<tr>
				<td><font size="3">Accumulated Member Tokens: </font></td>
				<td><b><?php echo $member_token; ?></b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="cnvrt_point_upd.php" rel="lightbox" style="text-decoration: none" alt="Convert PB Tokens to PB Points" >Convert To PB Points</a>
				</td>
				<td></td>
				<td></td>
			</tr>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan="4">-----------------------------------------------------------------------------------------------------------------</td>
			</tr>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			
			<tr>
				<td><strong><font size="4">Password</font></strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right"><a href="myaccount_password_upd.php" rel="lightbox" alt="change password"><img src="icon/red_editpassword.png" width="130px" height="28px" title="Change password"></img></a></td>
			</tr>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>

			<?php
				$hidden_password = preg_replace("|.|","*",decrypt($member_password));
			?>
			<tr>
				<td>Password: </td>
				<td> <?php echo $hidden_password; ?> </td>
							
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">-----------------------------------------------------------------------------------------------------------------</td>
			</tr>
		</tr>
		
		<!--	
			<tr>				
				<td>Current Password: </td>
				<td><input type="password" id="user_psd" name="user_psd"></input></td>
							
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td>New Password: </td>
				<td><input type="password" id="new_psd" name="new_psd"></input></td>
				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td>Confirm Password: </td>
				<td><input type="password" id="psd" name="psd"></input></td>
				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
							
			
	
			<tr align="center">
				<td align="right" colspan="4">
					<input type="submit" Value="Submit">
					<input type="reset" value="Reset">
				</td>
				
				<input type="hidden" name="act" value="add"></input>
			</tr> -->
			
			</table>
		<!-- Member Sign up End -->

    </div>
    <!-- End Content -->
	
<?php
	include('sidebar.php');
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