<?php

function error_msg()
{
	$message = "An error occured. Please try again later.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	exit;
}

function login_msg($file_name, $hyperlink)
{
	$message = "Please login to make order! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo '<script language="JavaScript">window.top.location ="' .$file_name. '.php?hyperlink=' .$hyperlink. '" </script>';
}

function limit_product_msg()
{
	$message = "Note: You already buy this product before! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	exit;
}
?>