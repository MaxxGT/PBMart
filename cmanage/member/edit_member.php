<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$mem_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);
	$order_line_no = 1;
	$order_line_no2 = 1;
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
	$member_display = mysqli_fetch_assoc($member);

	$com = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='$mem_id'");
	$com_display = mysqli_fetch_assoc($com);
	
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_customer_id='$mem_id'");
	$order_count = mysqli_num_rows($order);

	$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_list WHERE redemption_member_id='$mem_id'");
	
	include('../../encrypt_decrypt.php');
?>

<html>
	<head>
		<title>Edit Member</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
	</head>
	<body>
		<?php
			include('../header/header.php');
		?>
		
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="view_member.php" class="current"><span>Members</span></a></li>   
						<li><a href="add_member.php"><span>Add New Member </span></a></li>
						<li><a href="view_commercial.php?hyperlink=members"><span>Commercial Application</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
                           <p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_member.php?hyperlink=members">Members</a> >> <a href="#">Edit Member</a></p>
			</div>
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form action="edit_save_member.php?mem=<?=$mem_id?>" method="POST">
				<table border="0" width="600px" height="400px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Edit Member</th>
					</tr>
					<tr>
						<th>Edit Member Status</th>
						<td  align="center">
						<?php	if(!isset($_GET['edit'])){
								}else{
									$edit_mem = mysqli_real_escape_string($dbconnect, $_GET['edit']);
															
									if($edit_mem == "true"){
										echo "<span class='success'>Member successfully edited.</span>";
									}else if($edit_mem == "false"){
										echo "<span>Member could not be edit! Please try again later.</span>";
									}else if($edit_mem == "empty"){
										echo "<span>Please fill in all compulsory field(s) before save!</span>";
									}
								}
						?>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="member_number">Member No. : </label>
						</th>
						<td>
							<input type="text" id="member_number" name="member_number" value="<?=$member_display['member_number']?>" disabled />
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="first_name"><span class="compulsory">*</span>First Name : </label>
						</th>
						<td>
							<input type="text" id="first_name" name="first_name" value="<?=$member_display['member_first_name']?>"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="last_name"><span class="compulsory">*</span>Last Name : </label>
						</th>
						<td>
							<input type="text" id="last_name" name="last_name" value="<?=$member_display['member_last_name']?>"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="nationality"><span class="compulsory">*</span>Nationality : </label>
						</th>
						<td>
							<input type="text" id="nationality" name="nationality" value="<?=$member_display['member_nationality']?>"/>
						</td>
					</tr>
					<?php	if($member_display['member_ic'] == "-"){
								$ic = "";
							}else{
								$ic = $member_display['member_ic'];
							}
					?>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="ic">IC number : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}|[0-9]{12}" id="ic" name="ic" value="<?=$ic?>"/>
						</td>
					</tr>
					<?php	if($member_display['member_passport_number'] == "-"){
								$passport = "";
							}else{
								$passport = $member_display['member_passport_number'];
							}
					?>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="passport">Passport Number : </label>
						</th>
						<td>
							<input type="text" id="passport" name="passport" value="<?=$passport?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="email">Email : </label>
						</th>
						<td>
						<?php	if($member_display['member_email'] == "-"){
									$mail = "";
								}else{
									$mail = $member_display['member_email'];
								}
						?>
							<input type="email" id="email" name="email" value="<?=$mail?>"/>
							<?php	if(!isset($_GET['edit'])){
									}else{
										$edit_mail = mysqli_real_escape_string($dbconnect, $_GET['edit']);
														
										if($edit_mail == "mail"){
											echo "<span style='font-size:20px;'>Email address not available!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="contact">Contact Number: </label>
						</th>
						<td>
							<?php	if($member_display['member_contact'] == "-"){
										$contact = "";
									}else{
										$contact = $member_display['member_contact'];
									}
							?>
							<input type="text" pattern="[0-9]{3}-[0-9]*|[0-9]*" id="contact" name="contact" value="<?=$contact?>"/>
						</td>
					</tr>
					<!--<tr>
						<th style="padding-left:12;" width="150px">
							<label for="mobile">Mobile Number : </label>
						</th>
						<td>
						<?php	/*if($member_display['member_mobile'] == "-"){
									$mobile = "";
								}else{
									$mobile = $member_display['member_mobile'];
								}*/
						?>
							<input type="text" pattern="[0-9]{3}-[0-9]*|[0-9]*" id="mobile" name="mobile" value="<?//=$mobile?>"/>
						</td>
					</tr>-->
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="point">Point : </label>
						</th>
						<td>
							<input type="text" id="point" name="point" value="<?=$member_display['member_point']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="introducer">Introducer : </label>
						</th>
						<td>
							<input type="text" id="introducer" name="introducer" value="<?=$member_display['member_introducer']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="token">Member Token : </label>
						</th>
						<td>
							<input type="number" id="token" name="token" value="<?=$member_display['member_token']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="date">Date Registered : </label>
						</th>
						<td>
							<input type="text" name="date" value="<?=$member_display['member_regis_date']?>" disabled >
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="time">Time Registered : </label>
						</th>
						<td>
							<input type="text" name="time" value="<?=$member_display['member_regis_time']?>" disabled >
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">Delivery Address</th>
					</tr>
					<tr>
						<th width="150px">
							<label for="street_name"><span class="compulsory">*</span>Street Name : </label>
						</th>
						<td style="padding-left:8;" valign="top">
							<textarea id="street_name" name="street_name" rows="3" cols="50"><?=$member_display['member_street_name']?></textarea>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="flat_floor">Flat Floor : </label>
						</th>
						<?php	if($member_display['member_flat_status'] == 1){
									$flat_check = "checked";
									$flat_flo = "enabled";
								}else{
									$flat_check = "";
									$flat_flo = "disabled";
								}
						?>
						<td>
							<select name="flat_floor" id="flat_floor" <?=$flat_flo?>>
								<option value="0">-Please select floor...-</option>
							<?php	for($i = 1; $i <= 20; $i++){
										if($i == $member_display['member_flat_floor']){
											echo "<option value=".$i." selected>".$i."</option>";
										}else{
											echo "<option value=".$i.">".$i."</option>";
										}
									}
							?>
							</select>
							<input type="checkbox" name="flat" id="flat" onChange="disEnable();"<?=$flat_check?> /> Flat
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="postcode"><span class="compulsory">*</span>Postcode : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*" id="postcode" name="postcode" value="<?=$member_display['member_postcode']?>"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="city"><span class="compulsory">*</span>City : </label>
						</th>
						<td>
							<input type="text" id="city" name="city" value="<?=$member_display['member_city']?>"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="state"><span class="compulsory">*</span>State : </label>
						</th>
						<td>
							<input type="text" id="state" name="state" value="<?=$member_display['member_state']?>"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="country"><span class="compulsory">*</span>Country : </label>
						</th>
						<td>
							<input type="text" id="country" name="country" value="<?=$member_display['member_country']?>"/>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">User Account</th>
					</tr>
					<tr>
						<th width="150px">
							<label for="username"><span class="compulsory">*</span>Username : </label>
						</th>
						<td>
						<?php	if($member_display['member_username'] == "-"){
									$user = "";
								}else{
									$user = $member_display['member_username'];
								}
						?>
							<input type="text" id="username" name="username" value="<?=$user?>"/>
							<?php	if(!isset($_GET['user'])){
								}else{
									$create_user = mysqli_real_escape_string($dbconnect, $_GET['user']);
																
									if($create_user == "false"){
										echo "<span style='font-size:20px;'>Username not available!</span>";
									}
								}
						?>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="password">Password : </label>
						</th>
						<td>
						<?php	if($member_display['member_password'] == "-"){
									$passw = "";
								}else{
									$passw = decrypt($member_display['member_password']);
								}
						?>
							<input type="text" id="password" name="password" value="<?=$passw?>"/>
							<?php	if(!isset($_GET['pass'])){
									}else{
										$pass = mysqli_real_escape_string($dbconnect, $_GET['pass']);
															
										if($pass == "false"){
											echo "<span style='font-size:20px;'>Password mismatch!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="confirm_password">Confirm Password : </label>
						</th>
						<td>
							<input type="text" id="confirm_password" name="confirm_password" value="<?=$passw?>"/>
							<?php	if(!isset($_GET['pass'])){
									}else{
										$pass = mysqli_real_escape_string($dbconnect, $_GET['pass']);
															
										if($pass == "false"){
											echo "<span style='font-size:20px;'>Password mismatch!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="save_member" onClick="return checkEmpty();" value="Save"/>
							<input type="reset" name="" onClick="return clearFields();" value="Restore"/>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;">
							<input type="button" name="back" onClick="backMember();" value="Back"/>
						</td>
					</tr>
				</table>
			</form>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<?php	if($member_display['member_commercial_status'] == 1){
						echo "<form action='save_commercial.php?com=".$com_display['commercial_id']."' method='POST'>";
						echo "<table border='0' align='center' width='600px' cellpadding='0' cellspacing='0' class='box-table-a'>";
						
						echo "<tr><th colspan='2' align='center'>Edit Commercial</th></tr>";
						
						echo "<tr>";
						echo "<th width='150px'>Edit Commercial Status : </th>";
						echo "<td>";
						if(!isset($_GET['com'])){
						}else{
							$save_com = mysqli_real_escape_string($dbconnect, $_GET['com']);
														
							if($save_com == "true"){
								echo "<span class='success'>Commercial details successfully saved.</span>";
							}else if($save_com == "false"){
								echo "<span>Commercial details could not be saved! Please try again later.</span>";
							}else if($save_com == "empty"){
								echo "<span>Please fill in all compulsory field(s) before save!</span>";
							}
						}
						echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
						echo "<th style='padding-left:12;' width='150px'><label for='com_number'>Commercial Number : </label></th>";
						echo "<td><input type='text' name='com_number' id='com_number' value='".$com_display['commercial_number']."' disabled/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_name'><span class='compulsory'>*</span>Company Name : </label></th>";
						echo "<td><input type='text' name='com_name' id='com_name' value='".$com_display['commercial_company']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_number'><span class='compulsory'>*</span>Company Number : </label></th>";
						echo "<td><input type='text' name='com_com_number' id='com_com_number' value='".$com_display['commercial_company_number']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_phone'><span class='compulsory'>*</span>Company Phone Number : </label></th>";
						echo "<td><input type='text' pattern='[0-9]{3}-[0-9]*|[0-9]*' name='com_com_phone' id='com_com_phone' value='".$com_display['commercial_phone']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_address'><span class='compulsory'>*</span>Company Address : </label></th>";
						echo "<td><textarea name='com_com_address' id='com_com_address' rows='3' cols='50'>".$com_display['commercial_address']."</textarea></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_postal'><span class='compulsory'>*</span>Postal Code : </label></th>";
						echo "<td><input type='text' name='com_com_postal' id='com_com_postal' value='".$com_display['commercial_postcode']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_city'><span class='compulsory'>*</span>City : </label></th>";
						echo "<td><input type='text' name='com_com_city' id='com_com_city' value='".$com_display['commercial_city']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_state'><span class='compulsory'>*</span>State : </label></th>";
						echo "<td><input type='text' name='com_com_state' id='com_com_state' value='".$com_display['commercial_state']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='com_com_country'><span class='compulsory'>*</span>Country : </label></th>";
						echo "<td><input type='text' name='com_com_country' id='com_com_country' value='".$com_display['commercial_country']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='prod_limit'><span class='compulsory'>*</span>Product Limitation : </label></th>";
						echo "<td><input type='text' name='prod_limit' id='prod_limit' value='".$com_display['commercial_prd_limit']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='addi_point'><span class='compulsory'>*</span>Additional Point : </label></th>";
						echo "<td><input type='text' name='addi_point' id='addi_point' value='".$com_display['commercial_additional_point']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th colspan='2' align='center'>Person in Charge</th></tr>";
						
						echo "<tr><th width='150px'><label for='person_name'><span class='compulsory'>*</span>Name : </label></th>";
						echo "<td><input type='text' name='person_name' id='person_name' value='".$com_display['commercial_person_incharge']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='person_ic'><span class='compulsory'>*</span>IC number : </label></th>";
						echo "<td><input type='text' name='person_ic' id='person_ic' value='".$com_display['commercial_person_ic']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='person_position'><span class='compulsory'>*</span>Position : </label></th>";
						echo "<td><input type='text' name='person_position' id='person_position' value='".$com_display['commercial_person_position']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th width='150px'><label for='person_phone'><span class='compulsory'>*</span>Phone Number : </label></th>";
						echo "<td><input type='text' name='person_phone' id='person_phone' value='".$com_display['commercial_person_phone']."'/></td>";
						echo "</tr>";
						
						echo "<tr><th colspan='2' align='center'>Company Trading Form</th></tr>";
						
						echo "<tr><th width='150px' style='padding-left:12;'><label>Trading Form :</label></th>";
						echo "<td>";
						if($com_display['commercial_form_registration'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=_registration' target='blank'>Registration</a></br>";
						if($com_display['commercial_form_borang1'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=_borang1' target='blank'>Borang1</a></br>";
						if($com_display['commercial_form_lesen_runcit'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=_lesen_runcit' target='blank'>Lesen Runcit</a></br>";
						if($com_display['commercial_form_mpp'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=_mpp' target='blank'>Lesen Simpanan Petroleum dan LPG</a></br>";
						echo "</td>";
						echo "</tr>";
						
						echo "<tr><th colspan='2' align='center'>Company Form</th></tr>";
						
						echo "<tr><th width='150px' style='padding-left:12;'><label>Commercial Form :</label></th>";
						echo "<td>";
						if($com_display['commercial_form49'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=49' target='blank'>Form49</a></br>";
						if($com_display['commercial_form24'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=24' target='blank'>Form24</a></br>";
						if($com_display['commercial_form9'] != "")
							echo "<a href='download.php?com=".$com_display['commercial_id']."&form=9' target='blank'>Form9</a>";
						echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
						echo "<th align='center' colspan='2'>";
						echo "<input type='submit' value='Save' name='edit_commercial' onClick='return checkEmptyFields();'/>";
						echo "  ";
						echo "<input type='reset' value='Restore' onClick='return clearCommercial();'/>";
						echo "</th>";
						echo "</tr>";
						
						echo "</table>";
						echo "</form>";
					}
			?>
			</br>
			</br>
				<?php	if($order_count == 0){
						echo "<table border='0' align='center' width='900px' cellpadding='0' cellspacing='0' class='box-table-a'>";
						echo "<tr><td>There is no order from this customer.</td></tr>";
						echo "</table>";
					}else{
						echo "<table border='1' align='center' width='900px' cellpadding='0' cellspacing='0' class='box-table-a'>";
						echo "<th colspan='9'><h1><B>Redemption History</B></h1></th>";
						echo "<tr>";
						echo "<th width='20px' style='padding-left:5;'>No.</th>";
						echo "<th width='70px' style='padding-left:5;'>Order No.</th>";
						echo "<th width='70px' style='padding-left:5;'>Ref No.</th>";
						echo "<th width='200px' style='padding-left:5;'>Redeem Item</th>";
						
						echo "<th width='100px' style='padding-left:5;'>Redeem Date</th>";
						echo "<th width='100px' style='padding-left:5;'>Delivery Date</th>";
						echo "<th width='90px' style='padding-left:5;'>Total Points</th>";
						echo "<th width='90px' style='padding-left:5;'>Status</th>";
						echo "</tr>";
						$total_point = '0';
						$total_amount = '0';
						while($cart_redeem_display = @mysqli_fetch_array($redeem)){
							//$order_number = $cart_redeem_display['order_number'];
							//$order_list = @mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_number'");
							//$cart_order_list_display = @mysqli_fetch_assoc($order_list);
						
							echo "<tr class='link' href='../receipt/redemption_receipt.php?re=".$cart_redeem_display['redemption_number']."&mem=".$mem_id."' style='text-decoration:none;'>";
							echo "<td width='20px' style='padding-left:5;'>".$order_line_no.".</td>";
							echo "<td width='70px' style='padding-left:5;'>".$cart_redeem_display['redemption_order_ref']."</td>";

							echo "<td width='70px' style='padding-left:5;'>".$cart_redeem_display['redemption_number']."</td>";
							echo "<td width='200px' style='padding-left:5;'>".$cart_redeem_display['redemption_item']."</td>";
							
							echo "<td width='100px' style='padding-left:5;'>".$cart_redeem_display['redemption_date']."</td>";
							echo "<td width='100px' style='padding-left:5;'>".$cart_redeem_display['redemption_delivery_date']."</td>";
							echo "<td width='90px' style='padding-left:5;' align='center'>".number_format($cart_redeem_display['redemption_points'],0)."</td>";
							
							
							
							
							if($cart_redeem_display['redemption_status'] == 1){
								$total_point = $total_point + $cart_redeem_display['redemption_points'];
								//$total_amount = $total_amount + $cart_order_list_display['order_product_amount'];
								$status = "Completed";
							}else if($cart_redeem_display['redemption_status'] == 2){
								$status = "Cancelled";
							}else if($cart_redeem_display['redemption_status'] == 3){
								$status = "Refunded";
							}else{
								$status = "Pending";
							}
									
							echo "<td width='90px' align='center'>".$status."</td>";
							echo "</tr>";
							$order_line_no++;
						}
						echo "<tr><td colspan='6' align='right'><B>Total Points</B></td><td align='center'>".number_format($total_point,0)."</td><td></td></tr>";
						echo "</table>";
					}
					?>
			</br>
			</br>
			<?php	if($order_count == 0){
						echo "<table border='0' align='center' width='900px' cellpadding='0' cellspacing='0' class='box-table-a'>";
						echo "<tr><td>There is no order from this customer.</td></tr>";
						echo "</table>";
					}else{
						echo "<table border='1' align='center' width='900px' cellpadding='0' cellspacing='0' class='box-table-a'>";
						echo "<th colspan='9'><h1><B>Order History</B></h1></th>";
						echo "<tr>";
						echo "<th width='20px' style='padding-left:5;'>No.</th>";
						echo "<th width='70px' style='padding-left:5;'>Order No.</th>";
						echo "<th width='100px' style='padding-left:5;'>Order Date</th>";
						echo "<th width='100px' style='padding-left:5;'>Complete Date</th>";
						echo "<th width='100px' style='padding-left:5;'>Delivery Date</th>";
						echo "<th width='60px' style='padding-left:5;'>Amount (RM)</th>";
						echo "<th width='90px' style='padding-left:5;'>Points</th>";
						echo "<th width='90px' style='padding-left:5;'>Amount(GAS)</th>";
						echo "<th width='90px' style='padding-left:5;'>Status</th>";
						echo "</tr>";
						$total_point = '0';
						$total_amount = '0';
						while($cart_order_display = @mysqli_fetch_array($order)){
							$order_number = $cart_order_display['order_number'];
							$order_list = @mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_number'");
							$cart_order_list_display = @mysqli_fetch_assoc($order_list);
							
							echo "<tr class='link' href='../order/view_orderList.php?or=".$cart_order_display['order_number']."&view=mem' style='text-decoration:none;'>";
							echo "<td width='20px' style='padding-left:5;'>".$order_line_no2.".</td>";
							echo "<td width='70px' style='padding-left:5;'>".$cart_order_display['order_number']."</td>";
							
							echo "<td width='100px' style='padding-left:5;'>".$cart_order_display['order_date']."</td>";
							echo "<td width='100px' style='padding-left:5;'>".$cart_order_display['order_delivery']."</td>";
							echo "<td width='100px' style='padding-left:5;'>".$cart_order_display['order_complete_date']."</td>";
							echo "<td width='60px' align='right' style='padding-right:5;'>".$cart_order_display['order_amount']."</td>";
							echo "<td width='90px' style='padding-left:5;'>".$cart_order_display['order_total_point']."</td>";
							echo "<td width='90px' style='padding-left:5;'>".$cart_order_list_display['order_product_amount']."</td>";
							
							
							
							if($cart_order_display['order_status'] == 1){
								$total_point = $total_point + $cart_order_display['order_total_point'];
								$total_amount = $total_amount + $cart_order_list_display['order_product_amount'];
								$status = "Completed";
							}else if($cart_order_display['order_status'] == 2){
								$status = "Cancelled";
							}else if($cart_order_display['order_status'] == 3){
								$status = "Refunded";
							}else{
								$status = "Pending";
							}
									
							echo "<td width='90px' align='center'>".$status."</td>";
							echo "</tr>";
							$order_line_no2++;
						}
						echo "<tr><td colspan='6' align='right'><B>Total Points</B></td><td>".$total_point."</td><td>".$total_amount."</td><td></td></tr>";
						echo "</table>";
					}
			?>
			</br>
			<?php
				include('../footer.php');
			?>
		</div>	
		
		<script>
			function checkEmpty(){
				var firstName = document.getElementById('first_name').value;
				var lastName = document.getElementById('last_name').value;
				var nation = document.getElementById('nationality').value;
				var streetName = document.getElementById('street_name').value;
				var postCode = document.getElementById('postcode').value;
				var city = document.getElementById('city').value;
				var state = document.getElementById('state').value;
				var country = document.getElementById('country').value;
				var user = document.getElementById('username').value;
				var pass = document.getElementById('password').value;
				var confirmPass = document.getElementById('confirm_password').value;
				
				if(firstName == "" || lastName == "" || nation == "" || streetName == "" || postCode == "" || city == "" || state == "" || country == "" || user == ""){
					var message = "Please fill in the following field(s) before save!";
					
					if(firstName == "")
						message = message + "\n-First Name";
					if(lastName == "")
						message = message + "\n-Last Name";
					if(nation == "")
						message = message + "\n-Nationality";
					if(streetName == "")
						message = message + "\n-Street Name";
					if(postCode == "")
						message = message + "\n-Postcode";
					if(city == "")
						message = message + "\n-City";
					if(state == "")
						message = message + "\n-State";
					if(country == "")
						message = message + "\n-Country";
					if(user == "")
						message = message + "\n-Username";
					
					alert(message);
					return false;
				}else{
					if(pass != confirmPass){
						alert("Mismatch passwords!");
						return false;
					}else{
						return true;
					}
				}
			}
			
			function checkEmptyFields(){
				var name = document.getElementById('com_name').value;
				var number = document.getElementById('com_com_number').value;
				var phone = document.getElementById('com_com_phone').value;
				var address = document.getElementById('com_com_address').value;
				var postal = document.getElementById('com_com_postal').value;
				var city = document.getElementById('com_com_city').value;
				var state = document.getElementById('com_com_state').value;
				var country = document.getElementById('com_com_country').value;
				var limit = document.getElementById('prod_limit').value;
				var point = document.getElementById('addi_point').value;
				var person_name = document.getElementById('person_name').value;
				var ic = document.getElementById('person_ic').value;
				var position = document.getElementById('person_position').value;
				var person_phone = document.getElementById('person_phone').value;
				
				if(name == "" || number == "" || phone == "" || address == "" || postal == "" || city == "" || state == "" || country == "" || limit == "" || point == "" || person_name == "" || ic == "" || position == "" || person_phone == ""){
					var message = "Please fill in the following field(s) before save!";
					
					if(name == "")
						message = message + "\n-Company Name";
					if(number == "")
						message = message + "\n-Company Number";
					if(phone == "")
						message = message + "\n-Company Phone Number";
					if(address == "")
						message = message + "\n-Company Address";
					if(postal == "")
						message = message + "\n-Postal Code";
					if(city == "")
						message = message + "\n-City";
					if(state == "")
						message = message + "\n-State";
					if(country == "")
						message = message + "\n-Country";
					if(limit == "")
						message = message + "\n-Product Limit";
					if(point == "")
						message = message + "\n-Additional Point";
					if(person_name == "")
						message = message + "\n-Person Name";
					if(ic == "")
						message = message + "\n-IC Number";
					if(position == "")
						message = message + "\n-Position";
					if(person_phone == "")
						message = message + "\n-Person Phone Number";
					
					alert(message);
					return false;
				}else{
					return true;
				}
			}
			
			function disEnable(){
				if(document.getElementById('flat').checked == false){
					document.getElementById('flat_floor').disabled = true;
					document.getElementById('flat_floor').value = "0";
				}else{
					document.getElementById('flat_floor').disabled = false;
				}
			}
			
			function clearFields(){
				var confirmClear = confirm("Do you wish to restore the form to previous data?");
				
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
			
			function backMember(){
				var backCheck = confirm("Do you wish to go back?");
				
				if(backCheck){
					window.location = "view_member.php?hyperlink=members";
				}else{
				}
			}
			
			function clearCommercial(){
				var confirmClear = confirm("Do you wish to restore the form to previous data?");
				
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
			
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		</script>
	</body>
</html>