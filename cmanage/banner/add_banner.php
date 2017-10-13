<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$fileCheck = isset($_FILES['banner']);
	
	if(isset($_POST['add_banner'])){
		if($fileCheck == ""){
			header("location:banner.php?add=0&hyperlink=reward");
		}else{
			$file_name = $_FILES['banner']['name'];
			$tmp_name = $_FILES['banner']['tmp_name']; 
			$type = $_FILES['banner']['type'];
			$ext = substr(strrchr($file_name, "."), 1);

			switch($ext){ 
				case 'pjpeg':
				$banner_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpg':
				$banner_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpeg': 
				$banner_img = 'photo/'.uniqid('').'.jpg';
				break; 

			case 'gif':
				$banner_img = 'photo/'.uniqid('').'.gif';
				break;
			
			case 'png':
				$banner_img = 'photo/'.uniqid('').'.png';
				break;
			}

			if($banner_img != ''){ 
				if(move_uploaded_file($tmp_name, $banner_img)){
					mysqli_query($dbconnect, "INSERT INTO pbmart_banner(banner_path) VALUES ('$banner_img')");
					header("location:banner.php?add=true&hyperlink=reward");
				}else{
					header("location:banner.php?add=false&hyperlink=reward");
				}
			}
		}
	}
?>