<?php
include("connection/pbmartconnection.php");

$rs = mysql_query("SELECT member_number, member_email, member_status FROM pbmart_member WHERE member_status='1' ORDER BY member_id");
$i = '1';
$iCount = '0';
while($rw = @mysql_fetch_array($rs))
{
	if($i >= 1 && $i <= 20 )
	{
		echo $rw['member_email'].', ';
		$i++;
	}else
	{
		echo "<BR/><BR/><BR/>";
		echo $rw['member_email'].', ';
		$i = '1';
		$i++;
	}
	$iCount++;
}

echo "<BR/><BR/>Total E-mail: ".$iCount;
?>