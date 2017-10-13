<?php
echo get_currentDateTime();

function get_currentDateTime()
{
	date_default_timezone_set('Asia/Kuching'); // CDT

	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$month = $info['mon'];
	$year = $info['year'];
	$hour = $info['hours'];
	$min = $info['minutes'];
	$sec = $info['seconds'];

	$crt_date->setDate($year, $month, $date);
	
	$current_date = $crt_date->format('Y-m-d');
	return $current_date;
}
?>