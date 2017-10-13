<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$point1 = mysqli_real_escape_string($dbconnect, $_POST['point1']);
	$point2 = mysqli_real_escape_string($dbconnect, $_POST['point2']);
	$point3 = mysqli_real_escape_string($dbconnect, $_POST['point3']);

	if(isset($_POST['point_save'])){
		if($point1 == "" || $point2 == "" || $point3 == ""){
			header("location:point.php?save=empty&hyperlink=reward");
		}else{
			$edit_point = mysqli_query($dbconnect, "UPDATE pbmart_point SET point_rate1='$point1', point_rate2='$point2', point_rate3='$point3' WHERE point_id='1'");
			
			if($edit_point){
				header("location:point.php?save=true&hyperlink=reward");
			}else{
				header("location:point.php?save=false&hyperlink=reward");
			}
		}
	}
?>