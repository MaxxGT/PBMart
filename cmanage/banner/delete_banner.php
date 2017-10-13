<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(isset($_POST['delete'])){
		if(!isset($_POST['bannerList'])){
			header("location:banner.php?del=empty&hyperlink=reward");
		}else{
			$del_banner = $_POST['bannerList'];
			$count = count($del_banner);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_banner[$i];
				
				if($id > 0){
					$file_del = mysqli_query($dbconnect, "SELECT * FROM pbmart_banner WHERE banner_id = '$id'");
					while($file_delete = mysqli_fetch_assoc($file_del)){
						$file_to_del = $file_delete['banner_path'];
						unlink($file_to_del);
					}
					$delete = "DELETE FROM pbmart_banner WHERE banner_id = '$id'";
					$delete_banner = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_banner){
				header("location:banner.php?del=true&hyperlink=reward");
			}else{
				header("location:banner.php?del=false&hyperlink=reward");
			}
		}
	}
	
	if(isset($_POST['deleteAll'])){
		$banner_search = mysqli_query($dbconnect, "SELECT * FROM pbmart_banner");
		

		if(($banner_rows = mysqli_num_rows($banner_search)) == 0){
			header("location:banner.php?del=empty&hyperlink=reward");
		}else{
			while($banner_file = mysqli_fetch_array($banner_search)){
				$banner_file_del = $banner_file['banner_path'];
				unlink($banner_file_del);
			}
			
			$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_banner");

			if($truncate){
				header("location:banner.php?del=true&hyperlink=reward");
			}else{
				header("location:banner.php?del=false&hyperlink=reward");
			}
		}
	}
?>