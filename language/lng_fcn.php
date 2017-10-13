<?php
	//detect browser language
	$pc_lng = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	//$_GET['lng']
	switch($pc_lng)
	{
		case 'en':
		include('language/eng.php');
		break;
		
		case 'bm':
		include('language/bm.php');
		break;
		
		case 'ch':
		include('language/ch.php');
		break;
		
		default:
		include('language/eng.php');
	}
?>