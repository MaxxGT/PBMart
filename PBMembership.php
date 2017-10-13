<?php 
include("connection/pbmartconnection.php");
echo get_PB();

function get_PB()
{
	date_default_timezone_set('Asia/Kuching'); // CDT
	$i = "01";
	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$month = $info['mon'];
	$year = $info['year'];
	$hour = $info['hours'];
	$min = $info['minutes'];
	$sec = $info['seconds'];

	$crt_date->setDate($year, $month, $date);
	
	$sql_member = @mysql_query("SELECT member_number FROM pbmart_member WHERE member_number='$Membership_num'");
	$iCount = mysql_num_rows($sql_member);
	
	if($iCount > 0)
	{
		$Membership_num = "PB".$crt_date->format('dm')."01".$i;
	}else
	{
		
	}
	
	return $Membership_num;
}
?>