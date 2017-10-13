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
						<li><a href="add_member.php?hyperlink=members"><span>Add New Member </span></a></li>
						<li><a href="add_salesman.php?hyperlink=members" class="current"><span>Add New Salesman</span></a></li>
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
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_member.php?hyperlink=members">Members</a> >> <a href="../member/add_member.php?hyperlink=members">Add New Salesman</a></p>
			</div>
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		
			<form action="create_salesman.php" method="POST">
				<table border="0" width="600px" height="400px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Add New Salesman</th>
					</tr>	
					<tr>
						<th>Add Salesman Status</th>
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
							<label for="name"><span class="compulsory">*</span>Salesman Name : </label>
						</th>
						<td>
							<input type="text" id="name" name="name"/>
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
						<th colspan="2" align="center">
							<input type="submit" name="create_salesman" onClick="return checkEmpty();" value="Create Salesman"/>
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
				var Name = document.getElementById('name').value;
				
				if(Name == ""){
				
					var message = "Please fill in the following field(s) before create!";
					
					if(Name == "")
						message = message + "\n-First Name";
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
		</script>
	</body>
</html>