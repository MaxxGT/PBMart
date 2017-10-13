<?php
include("connection/pbmartconnection.php");
$q = $_GET["q"];

$sql = "SELECT member_ic FROM pbmart_member WHERE member_ic = '".$q."'";
$result = @mysql_query($sql, $link);
$iCount = mysql_num_rows($result);

if($iCount > 0)
{
	echo "Invalid IC number! Please try again!";
}

mysql_close($link);
?>