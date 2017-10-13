<?php


echo date("H:i:s", strtotime("04:25 PM"));
function get_currentTime()
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

	$Time = $hour.':'.$min.':'.$sec;
	$newTime = date('H:i:s', strtotime($Time));
	return $newTime;
}
?>
