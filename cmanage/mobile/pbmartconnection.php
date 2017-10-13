<?php
	$host = "localhost";
	$username = "pbmartdb";
	$password = "swin12345";
	$database = "pbmart";

	$dbconnect = mysqli_connect($host, $username, $password, $database) or die ("Unable to connect to MySQL");
	
	$link = mysql_connect($host, $username, $password);
	if (!$link)
	{
		die('Could not connect: ' . mysql_error());
	}
	$db_selected = mysql_select_db($database, $link);
?>