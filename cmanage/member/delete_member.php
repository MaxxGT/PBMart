<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
		
	if(isset($_POST['member_delete'])){
		if(!isset($_POST['memberList'])){
			header("location:view_member.php?del=empty&hyperlink=members");
		}else{
			$del_mem = $_POST['memberList'];
			$count = count($del_mem);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_mem[$i];
				
				if($id > 0){
					$delete = "DELETE FROM pbmart_member WHERE member_id = '$id'";
					$delete_member = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_member){
				header("location:view_member.php?del=true&hyperlink=members");
			}else{
				header("location:view_member.php?del=false&hyperlink=members");
			}
		}
	}
	
	if(isset($_POST['mem_deleteAll'])){
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member");

		if(($member_rows = mysqli_num_rows($member)) == 0){
			header("location:view_member.php?del=empty&hyperlink=members");
		}else{
			$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_member");

			if($truncate){
				header("location:view_member.php?del=true&hyperlink=members");
			}else{
				header("location:view_member.php?del=false&hyperlink=members");
			}
		}
	}	
?>