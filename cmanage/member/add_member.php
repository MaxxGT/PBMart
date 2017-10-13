<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
?>

<html>
	<head>
		<title>Add Member</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
		
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
						<li><a href="view_member.php?hyperlink=members"><span>Members</span></a></li>   
						<li><a href="add_member.php?hyperlink=members" class="current"><span>Add New Member </span></a></li>
						<li><a href="add_salesman.php?hyperlink=members"><span>Add New Salesman </span></a></li>
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
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_member.php?hyperlink=members">Members</a> >> <a href="../member/add_member.php?hyperlink=members">Add New Member</a></p>
			</div>
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		
			<form action="create_member.php" method="POST">
				<table border="0" width="600px" height="400px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Add New Member</th>
					</tr>	
					<tr>
						<th>Add Member Status</th>
						<td align="center">
							<?php	if(!isset($_GET['create'])){
									}else{
										$create_mem = mysqli_real_escape_string($dbconnect, $_GET['create']);
													
										if($create_mem == "true"){
											echo "<span class='success'>Member successfully created.</span>";
										}else if($create_mem == "false"){
											echo "<span>Member could not save into database! Please try again later.</span>";
										}else if($create_mem == "empty"){
											echo "<span>Please fill in all compulsory field(s) before create!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="first_name"><span class="compulsory">*</span>First Name : </label>
						</th>
						<td>
							<input type="text" id="first_name" name="first_name"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="last_name"><span class="compulsory">*</span>Last Name : </label>
						</th>
						<td>
							<input type="text" id="last_name" name="last_name"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="nationality"><span class="compulsory">*</span>Nationality : </label>
						</th>
						<td>
							<input type="text" id="nationality" name="nationality"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="ic">IC number : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}|[0-9]{12}" id="ic" name="ic"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="passport">Passport Number : </label>
						</th>
						<td>
							<input type="text" id="passport" name="passport"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="email">Email : </label>
						</th>
						<td>
							<input type="email" id="email" name="email"/>
							<?php	if(!isset($_GET['create'])){
									}else{
										$create_mail = mysqli_real_escape_string($dbconnect, $_GET['create']);
																	
										if($create_mail == "mail"){
											echo "<span style='font-size:20px;'>Email address not available!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="contact">Contact Number : </label>
						</th>
						<td>
							<input type="tel" pattern="[0-9]{3}-[0-9]*|[0-9]*" id="contact" name="contact"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="introducer">Introducer : </label>
						</th>
						<td>
							<input type="text" id="introducer" name="introducer"/>
						</td>
					</tr>
					<!--<tr>
						<th style="padding-left:12;" width="150px">
							<label for="mobile">Mobile Phone : </label>
						</th>
						<td>
							<input type="tel" pattern="[0-9]{3}-[0-9]*|[0-9]*" id="mobile" name="mobile"/>
						</td>
					</tr>-->
					<tr>
						<th colspan="2" align="center">Delivery Address</th>
					</tr>
					<tr>
						<th width="150px" valign="top">
							<label for="street_name"><span class="compulsory">*</span>Street Name : </label>
						</th>
						<td style="padding-left:8;">
							<textarea id="street_name" name="street_name" rows="3" cols="50"></textarea>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="flat_floor">Flat Floor : </label>
						</th>
						<td>
							<select name="flat_floor" id="flat_floor" disabled>
								<option value="0">-Please select floor...-</option>
							<?php	for($i = 1; $i <= 20; $i++){
										echo "<option value=".$i.">".$i."</option>";
									}
							?>
							</select>
							<input type="checkbox" name="flat" id="flat" onChange="disEnable();"/> Flat
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="postcode"><span class="compulsory">*</span>Postcode : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*" id="postcode" name="postcode"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="city"><span class="compulsory">*</span>City : </label>
						</th>
						<td>
							<input type="text" id="city" name="city" value="Kuching"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="state"><span class="compulsory">*</span>State : </label>
						</th>
						<td>
							<input type="text" id="state" name="state" value="Sarawak"/>
						</td>
					</tr>
					<tr>
						<th width="150px">
							<label for="country"><span class="compulsory">*</span>Country : </label>
						</th>
						<td>
							<input type="text" id="country" name="country" value="Malaysia"/>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">User Account</th>
					</tr>
					<tr>
						<th width="150px" valign="top">
							<label for="username"><span class="compulsory">*</span>Username : </label>
							<?php	if(!isset($_GET['user'])){
									}else{
										$create_user = mysqli_real_escape_string($dbconnect, $_GET['user']);
																	
										if($create_user == "false"){
											echo "<span style='font-size:20px;'>Username not available!</span>";
										}
									}
							?>
						</th>
						<td>
							<input type="text" id="username" name="username";
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;" width="150px">
							<label for="password">Password : </label>
						</th>
						<td>
							<input type="password" id="password" name="password"/>
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
							<input type="password" id="confirm_password" name="confirm_password"/>
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
						<th colspan="2" align="center">
							<input type="submit" name="create_member" onClick="return checkEmpty();" value="Create Member"/>
						</th>
					</tr>
				</table>
							
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			</form>
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
				
				if(firstName == "" || lastName == "" || streetName == "" || postCode == "" || city == "" || state == "" || country == "" || user == ""){
				
					var message = "Please fill in the following field(s) before create!";
					
					if(firstName == "")
						message = message + "\n-First Name";
					if(lastName == "")
						message = message + "\n-Last Name";
					if(nation == "")
						message = message + "\n-Nationality";
					if(no == "" || streetName == "")
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
			
			function disEnable(){
				if(document.getElementById('flat').checked == false){
					document.getElementById('flat_floor').disabled = true;
					document.getElementById('flat_floor').value = "0";
				}else{
					document.getElementById('flat_floor').disabled = false;
				}
			}
		</script>
	</body>
</html>