<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if(isset($_SESSION['validation']) == false){
		
	}else{
		header("location:../main.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<title>PBMart</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<style>
		body{
			background-image:url("../images/loginbackground.jpg");
		}
                
                 table{
                        padding-left:auto;
                        padding-right:auto;
                        padding-top:20%;
                        padding-bottom:auto;
		}
		
		
		</style>
	</head>
	<body>
        <div class="logincontent">
		
		
					
					<table border="0" width="550px" height="300px"  align="center" cellpadding="0" cellspacing="0">
						<form action="authenticate.php" method="POST">
							<tr>
								<td colspan="3" align="center"><font style="font-size:35px; color:#ffffff;font-family:'trebuchet ms', geneva;">Welcome to PBMart</br> Content Management System.</font></br></br></td>
							</tr>
                            
							<tr>
								<td colspan="3" align="center"><font style="font-size:30px; color:#ffffff;font-family:'trebuchet ms', geneva;">Login</font></td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<?php	if(!isset($_GET['login'])){
											}else{
												$check = $_GET['login'];
												
												if($check == "false"){
													echo "<span>Incorrect password!</span>";
													echo "<br>";
													echo "Please try again.";
												}else if($check == "0"){
													echo "<span>Username does not exist!</span>";
													echo "<br>";
													echo "Please try again.";
												}else if($check == "user_empty"){
													echo "<span>Please enter your username!</span>";
												}else if($check == "pass_empty"){
													echo "<span>Please enter your password!</span>";
												}else if($check == "empty"){
													echo "<span>Please enter your username and password!</span>";
												}else{
												}
											}
									?>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td><font style="font-size:25px; color:#ffffff; font-family:'trebuchet ms', geneva;">Username : </font></td>
								<td><input type="text" name="username"></td>
							</tr>
							<tr>
							    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td><font style="font-size:25px; color:#ffffff;font-family:'trebuchet ms', geneva;">Password : </font></td>
								<td><input type="password" name="password"></td>
							</tr>
							<tr>
								<td colspan="3" align="center"><input type="submit" name="login" value="Login"></td>
							</tr>	
						</form>
					</table>
		
        </div>
	</body>
</html>	