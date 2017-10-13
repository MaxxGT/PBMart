<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	session_destroy();
?>

<html>
	<head>
		<title>PBMart</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
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
	<body onLoad="setTimeout('delayer()', 3000)">
		
		
					<table border="0" width="550px" height="300px" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td height="100px" align="center" style="border-bottom-style:hidden;">
								<p id="logout"><font style="font-size:25px; color:#ffffff; font-family:'trebuchet ms', geneva;">Thank you for using PBMart CMS</font></p>
							</td>
						</tr>
						<tr>
							<td align="center">
								<p><font style="font-size:20px; color:#ffffff; font-family:'trebuchet ms', geneva;">You have successfully logged out.</font></p>
								<p><font style="font-size:20px; color:#ffffff; font-family:'trebuchet ms', geneva;">You will be redirected to the <a href="login.php">Login Page</a> in a short while.</font></p>
							</td>
						</tr>
					</table>
			
		
		<script>
			function delayer(){
				window.location = "login.php";
			}
		</script>
	</body>
</html>