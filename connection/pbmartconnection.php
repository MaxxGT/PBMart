<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "pbmart";

	$dbconnect = mysqli_connect($host, $username, $password, $database) or die ("Unable to connect to MySQL");
	
	//$link = mysql_connect($host, $username, $password);
	//if (!$dbconnect)
	//{
	//	die('Could not connect: ' . mysql_error());
	//}
	
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$db_selected = mysqli_select_db($dbconnect, $database);
?>