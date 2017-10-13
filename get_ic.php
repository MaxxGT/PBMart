<?php
include("connection/pbmartconnection.php");

$sql_ic = @mysql_query("SELECT member_number, member_first_name, member_last_name, member_ic, member_contact, member_status FROM pbmart_member WHERE member_ic LIKE '%05%' AND member_status='1'");
while($sql_row = mysql_fetch_array($sql_ic))
{
	
	//echo $sql_row['member_number'].' - ';
	//echo $sql_row['member_first_name'].' ';
	//echo $sql_row['member_last_name'].' - ';
	//echo $sql_row['member_ic'].' - ';
	//$ic = explode('-', $sql_row['member_ic']);
	//echo $ic[0].'<BR/>';
	//echo $sql_row['member_contact'].'<BR />';
}

$member_commercial = @mysql_query("SELECT pbmart_commercial.commercial_company, pbmart_member.member_point, pbmart_member.member_number, pbmart_member.member_commercial_status, pbmart_member.member_status FROM pbmart_member 
INNER JOIN pbmart_commercial on
pbmart_commercial.commercial_member_number = pbmart_member.member_number
WHERE pbmart_member.member_status='1' AND pbmart_member.member_commercial_status='1' ORDER BY pbmart_member.member_point DESC");
while($sql_row = mysql_fetch_array($member_commercial))
{
	echo $sql_row['member_number'].' ';
	echo $sql_row['commercial_company'].' ';
	echo $sql_row['member_point'].' ';
	echo '<BR />';
}
?>