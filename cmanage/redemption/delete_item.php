<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}

	if(isset($_POST['item_delete'])){
		if(!isset($_POST['itemList'])){
			header("location:view_redemption.php?del=empty&hyperlink=redemption");
		}else{
			$del_item = $_POST['itemList'];
			$count = count($del_item);

			for($i = 0; $i < $count; $i++){
				$id = (int)$del_item[$i];
				
				if($id > 0){
					$file_del = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='$id'");
					while($file_delete = mysqli_fetch_assoc($file_del)){
						$file_to_del = $file_delete['redeem_image'];
						unlink($file_to_del);
					}
					$delete = "DELETE FROM pbmart_redeem WHERE redeem_id = '$id'";
					$delete_item = mysqli_query($dbconnect, $delete);
				}
			}
			
			if($delete_item){
				header("location:view_redemption.php?del=true&hyperlink=redemption");
			}else{
				header("location:view_redemption.php?del=false&hyperlink=redemption");
			}
		}
	}
	
	if(isset($_POST['item_deleteAll'])){
		$item_image = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem");

		if(($item_rows = mysqli_num_rows($item_image)) == 0){
			header("location:view_redemption.php?del=empty&hyperlink=redemption");
		}else{
			while($image_file = mysqli_fetch_array($item_image)){
				$image_file_del = $image_file['redeem_image'];
				unlink($image_file_del);
			}
			
			$truncate = mysqli_query($dbconnect, "TRUNCATE TABLE pbmart_redeem");

			if($truncate){
				header("location:view_redemption.php?del=true&hyperlink=redemption");
			}else{
				header("location:view_redemption.php?del=false&hyperlink=redemption");
			}
		}
	}	
?>