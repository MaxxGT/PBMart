<?php
if(isset($_GET['total_price']))
{
	$total_price = $_GET['total_price'];
}

if(isset($_GET['std_time']))
{
	$std_time = $_GET['std_time'];
}

	include("connection/pbmartconnection.php");
	$sql_point = "SELECT point_rate1, point_rate2, point_rate3 FROM pbmart_point";
	$rs_point = @mysql_query($sql_point, $link);
	$rw_point = @mysql_fetch_array($rs_point);
	
	$point_rate1 = $rw_point['point_rate1'];
	$point_rate2 = $rw_point['point_rate2'];
	$point_rate3 = $rw_point['point_rate3'];
	
	if($std_time == '2')
	{
		$usr_point = $total_price / $point_rate1;
	}else if($std_time == '1')
	{
		$usr_point = $total_price / $point_rate2;
	}else if($std_time == '3')
	{
		$usr_point = $total_price / $point_rate3;
	}
	echo (INT)$usr_point;

?>