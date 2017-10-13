<?php
include("connection/pbmartconnection.php");
$q = $_GET["q"];

$sql="SELECT member_username FROM pbmart_member WHERE member_username = '".$q."'";

$result = @mysql_query($sql, $link);

$row = mysql_fetch_array($result);

$name = $row['member_username'];

if($name == '' || empty($name))
{
}
else
{
	echo "Invalid Username! Please try again!";
	
}

mysql_close($link);
?>