<?php
   	require_once("../../connection/pbmartconnection.php");
	session_start();
?>
<html>
	<body>
		<form action="send_noti.php" method="POST">
			<p>Members more than <input type="text" name="point" value="0"> points</p>
			<textarea rows="3" name="message" cols="25" placeholder="Type message here"></textarea>
			</br>
			<input type="submit" value="Send" name="send"/>
		</form>
	</body>
</html>