<?php
function get_currentDate()
{
	date_default_timezone_set('Asia/Kuching'); // CDT
	$crt_date = new DateTime();
	$info = getdate();
	
	$date = $info['mday'].'-';
	$month = $info['mon'].'-';
	$year = $info['year'];
	
	$crt_date->setDate($year, $month, $date);
	
	$current_date = $crt_date->format('Y-m-d');
	return $current_date;
}

function get_currentTime()
{
	date_default_timezone_set('Asia/Kuching'); // CDT

	$crt_date = new DateTime();
	
	$info = getdate();
	$hour = $info['hours'];
	$min = $info['minutes'];
	$sec = $info['seconds'];

	$crt_date->setTime($hour, $min, $sec);
	
	$current_time = $crt_date->format('H:i:s');
	return $current_time;
}
?>