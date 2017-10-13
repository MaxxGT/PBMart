<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
		
	if(isset($_POST['redemption_delete'])){
		if(!isset($_POST['redemptionList'])){
			header("location:view_redemption_list.php?del=empty&hyperlink=redemption");
		}else{
			$del_redemption = $_POST['redemptionList'];
			$count = count($del_redemption);
			
			for($i = 0; $i < $count; $i++){
				$id = (int)$del_redemption[$i];
				
				if($id > 0){	
					$delete = "DELETE FROM pbmart_redemption_list WHERE redemption_id = '$id'";
					$delete_order = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_order && $delete_order){
				header("location:view_redemption_list.php?del=true&hyperlink=redemption");
			}else{
				header("location:view_redemption_list.php?del=false&hyperlink=redemption");
			}
		}
	}
	
	if(isset($_POST['redemption_deleteAll'])){
		$redemption = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_list WHERE redemption_status='0'");

		if(($redemption_rows = mysqli_num_rows($redemption)) == 0){
			header("location:view_redemption_list.php?del=empty&hyperlink=redemption");
		}else{
			$delete_order = mysqli_query($dbconnect, "DELETE FROM pbmart_redemption_list WHERE redemption_status='0'");

			if($delete_order){
				header("location:view_redemption_list.php?del=true&hyperlink=redemption");
			}else{
				header("location:view_redemption_list.php?del=false&hyperlink=redemption");
			}
		}
	}
?>