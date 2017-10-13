<?php

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
	$newTime = date('g:i:s A', strtotime($Time));
	echo $newTime;

?>