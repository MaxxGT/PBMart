<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$banner = mysqli_query($dbconnect, "SELECT * FROM pbmart_banner");
	$banner_count = mysqli_num_rows($banner);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<title>Banner</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
		
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
	</head>
	<body>
		<?php
			include('../header/header.php');
		?>

		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="../banner/banner.php?hyperlink=reward" class="current"><span>Banner</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
					</ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">   
				 <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../banner/banner.php?hyperlink=reward">Banner</a></p>
			</div>
			<br />		
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
		
			<form enctype="multipart/form-data" action="add_banner.php" method="POST">
				<table border="0" align="center" width="700px" height="100%" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Add Banner</th>
					</tr>
					<tr>
						<th>Status</th>
						<td align="center">
							<?php	if(!isset($_GET['add'])){
									}else{
										$add_result = $_GET['add'];
												
										if($add_result == "true"){
											echo "<span class='success'>Banner successfully added.</span>";
										}else if($add_result == "false"){
											echo "<span>Banner could not save into database! Please try again later.</span>";
										}else if($add_result == "0"){
											echo "<span>Please choose a photo before save!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th width="150px">Select Image
						</th>
						<td align="left">
							<input type="file" name="banner" id="banner"/>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<?php	if($banner_count == 4){
										$disable = "disabled";
									}else{
										$disable = "";
									}
							?>
							<input type="submit" onClick="return checkEmpty();" value="Save" name="add_banner" <?=$disable?>/>
						</th>
					</tr>
				</table>
			</form>
						
			<form action="delete_banner.php" method="POST">
				<table border="1" align="center" width="850px" height="100%" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Banner Management</th>
					</tr>
					<tr>
						<th width="60px">Status : 
						</th>
						<td>
							<?php	if(!isset($_GET['del'])){
									}else{
										$del_result = $_GET['del'];
													
										if($del_result == "true"){
											echo "<span class='success'>Banner successfully deleted.</span>";
										}else if($del_result == "false"){
											echo "<span>Banner could not be deleted! Please try again later.</span>";
										}else if($del_result == "empty"){
											echo "<span>There is no photo to be delete!</span>";
										}
									}
							?>
						</td>
					</tr>
					<?php	while($banner_result = mysqli_fetch_array($banner)){	?>
								<tr>
									<td align="center" style="vertical-align:middle;">
										<input type="checkbox" name="bannerList[]" value="<?php	echo $banner_result['banner_id'];	?>"/>
									</td>
									<td align="center">
										<img src="<?=$banner_result['banner_path']?>" width="720px" height="252px"/>
									</td>
								</tr>
					<?php	}	?>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="delete" onClick="return deleteBanner();" value="Delete"/> | <input type="submit" name="deleteAll" onClick="return checkDeleteAll();" value="Delete All"/>
						</th>
					</tr>
				</table>
			</form>
		</div>	
		
		<script>
			function checkEmpty(){
				if(document.getElementById("banner").value.length === 0){
					alert("Please choose a photo before save!");
					return false;
				}else{
					return true;
				}
			}
			
			function deleteBanner(){
				var banner_list = document.getElementsByName('bannerList[]');
				var banner_num = [];
				for(var i = 0; i < banner_list.length; i++){
					if(banner_list[i].checked){
						banner_num++;
					}
				}
				
				if(banner_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +banner_num +" banner(s)?");
				}else{
					alert("Please select 1 or more banner to delete!");
				}
				
				if(confirmDelete){
					return true;
				}else{
					return false;
				}
			}
			
			function checkDeleteAll(){
				var confirmDelAll = confirm("Do you wish to delete all banners?");
				
				if(confirmDelAll){
					return true;
				}else{
					return false;
				}
			}
		</script>
	</body>
</html>