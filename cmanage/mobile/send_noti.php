<?php
   	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	$point = mysqli_real_escape_string($dbconnect, $_POST['point']);
	$message = mysqli_real_escape_string($dbconnect, $_POST['message']);
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_point>=".$point."");
?>	

<html>
	<head>
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		<form id="get_email" action="get_email.php" method="POST">
		<?php	while($member_display = mysqli_fetch_array($member)){
					$gcm = mysqli_query($dbconnect, "SELECT * FROM mobile_devices WHERE email='".$member_display['member_email']."'");
						while($gcm_display = mysqli_fetch_array($gcm)){
		?>
						<input type='checkbox' name='member[]' value='<?=$gcm_display['device_id']?>' checked/><?=$gcm_display['device_id']?>
						</br>
		<?php			}
				}
				
		?>
			<textarea rows="3" name="msg" cols="25"><?=$message?></textarea>
			<input type="submit">
		</form>
	</body>
</html>
			
<script>
	$(document).ready(function(){
			$("#get_email").submit();
		});
</script>
