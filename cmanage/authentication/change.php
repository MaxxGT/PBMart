<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$admin = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin WHERE id='1'");
	$admin_display = mysqli_fetch_assoc($admin);
	
	include('../../encrypt_decrypt.php');
?>

<html>
	<head>
		<title>Change Password</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">	
		<link rel="stylesheet" type="text/css" href="../css/red.css">	
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
						  <li><a href="../main.php?hyperlink=main"><span>Dashboard</span></a></li>
						  <li><a href="change.php?hyperlink=main" class="current"><span>Change Password</span></a></li>
                                                  <li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
                                                  <li><a href="logout.php"><span>Logout Dashboard</span></a></li>
                                                  
						 
			   </ul>
			</div>
		</div>
	<!-- TABS END -->    
	</div>
		
	<div class="grid_16" id="content">	
		<br />
		<div class="breadcrumb">
                   <p><a href="../main.php">Dashboard</a> >> <a href="../authentication/change.php?hyperlink=main">Change Password</a></p> 
		</div>
                <br />
<table>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
		<form action="change_pass.php" method="POST">
			<table border="0" width="500px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="2" align="center">Change Password</th>
				</tr>
				<tr>
					<th width="150px">Status : </th>
					<td>
						<?php	if(!isset($_GET['cha'])){
						
								}else{
									$status = $_GET['cha'];
									
									if($status == "true"){
										echo "Username and password successfully changed";
									}else if($status == "false"){
										echo "Unable to make changes! Please try again later.";
									}
								}
						?>
					</td>
				</tr>
				<tr>
					<th width="150px">
						<label for="username">Username : </label>
					</th>
					<td>
						<input type="text" name="username" id="username" value="<?=$admin_display['username']?>"/>
					</td>
				</tr>
				<tr>
					<th width="150px">
						<label for="old_pass">Old Password : </label>
					</th>
					<td>
						<?php	$pass = decrypt($admin_display['password']);	?>
						<input type="password" name="old_pass" id="old_pass" value="<?=$pass?>"/>
					</td>
				</tr>
				<tr>
					<th width="150px">
						<label for="new_username">New Username : </label>
					</th>
					<td>
						<input type="text" name="new_username" id="new_username"/>
					</td>
				</tr>
				<tr>
					<th width="150px">
						<label for="new_pass">New Password : </label>
					</th>
					<td>
						<input type="password" name="new_pass" id="new_pass"/>
					</td>
				</tr>
				<tr>
					<th width="150px">
						<label for="con_pass">Confirm Password : </label>
					</th>
					<td>
						<input type="password" name="con_pass" id="con_pass"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" name="change" value="Change" onClick="return checkPass();"/>
					</td>
				</tr>
			</table>
		</form>
			<?php
		include('../footer.php');
		?>
	</div>
		
		<script>
			function checkPass(){
				var username = document.getElementById('new_username').value;
				var new_pass = document.getElementById('new_pass').value;
				var con_pass = document.getElementById('con_pass').value;
				
				if(username == "" || new_pass == "" || con_pass == ""){
					var message = "Please fill in the following :";
					if(username == ""){
						message = message +"\n -Username";
					}
					if(new_pass == ""){
						message = message +"\n -New Password";
					}
					if(con_pass == ""){
						message = message +"\n -Confirm Password";
					}
					alert(message);
					return false;
				}else{
					if(new_pass != con_pass){
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