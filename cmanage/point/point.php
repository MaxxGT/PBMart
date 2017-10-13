<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$point = mysqli_query($dbconnect, "SELECT * FROM pbmart_point WHERE point_id='1'");
	$point_rate = mysqli_fetch_assoc($point);
?>

<html>
	<head>
		<title>Point</title>
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
						<li><a href="../point/point.php?hyperlink=reward" class="current"><span>Member Points</span></a></li> 
						<li><a href="../mobile/notification.php?hyperlink=reward"><span>Mobile Notifications</span></a></li>
						<li><a href="../banner/banner.php?hyperlink=reward"><span>Promotion Banner Images</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
				<br />						
				<div class="breadcrumb">
								  <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../point/point.php?hyperlink=reward">Member Points</a></p>
				</div>
							<br />
							<table border="0">
						   <tr>
							<td>&nbsp;</td>
							   </tr>
							</table>
			
						<form action="edit_point.php" method="POST">
						
										<table border="0" align="center" width="600px" height="100px" cellpadding="0" cellspacing="0" class="box-table-a">
											<tr>
												<th colspan="2" align="center"> Member Point Rate</th>
											</tr>
											<tr>
												<th width="200px">Point Rate Change Status :</th>
												<td align="center">
													<?php	if(!isset($_GET['save'])){
															}else{
																$save_result = $_GET['save'];
																
																if($save_result == "true"){
																	echo "<span class='success'>Point Rate successfully saved.</span>";
																}else if($save_result == "false"){
																	echo "<span>Point Rate could not save into database! Please try again later.</span>";
																}else if($save_result == "empty"){
																	echo "<span>Please fill in Point Rate before save!</span>";
																}
															}
													?>
												</td>
											</tr>
												<th width="100px">
													<label for="point1"><span class="compulsory">*</span>Point Rate (morning 8-12) : </label>
												</th>
												<td>
													RM 1 = 
													<input type="number" name="point1" id="point1" value="<?=$point_rate['point_rate1']?>"/> Point(s)
												</td>
											</tr>
											</tr>
												<th width="100px">
													<label for="point2"><span class="compulsory">*</span>Point Rate (afternoon 12-4) : </label>
												</th>
												<td>
													RM 1 =  </label>
													<input type="number" name="point2" id="point2" value="<?=$point_rate['point_rate2']?>"/> Point(s)
												</td>
											</tr>
											</tr>
												<th width="100px">
													<label for="point3"><span class="compulsory">*</span>Point Rate (immediately) : </label>
												</th>
												<td>
													RM 1 = 
													<input type="number" name="point3" id="point3" value="<?=$point_rate['point_rate3']?>"/> Point(s)
												</td>
											</tr>
											<tr>
												<th colspan="2" align="center">
													<input type="submit" name="point_save" onClick="return point_checkEmpty();" Value="Save"/>
												</th>
											</tr>
										</table>
								
							<br>
							<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<span class="compulsory">*</span>Note
									</td>
								</tr>
								<tr>
									<td style="padding-left:22;">How point rate works :</td>
								</tr>
								<tr>
									<td style="padding-left:32;">If RM 1 = 10 point</td>
								</tr>
								<tr>
									<td style="padding-left:32;">then RM 10 = 100 points</td>
								</tr>
								<tr>
									<td style="padding-left:32;">RM 35 = 350 points</td>
								</tr>
							</table>
						</form>
							<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
					<?php
					include('../footer.php');
				?>
		</div>	
		<script>
			function point_checkEmpty(){
				var point1 = document.getElementById('point1').value;
				var point2 = document.getElementById('point2').value;
				var point3 = document.getElementById('point3').value;
				
				if(point1 == "" || point2 == "" || point3 == ""){
					alert("Please fill in Point Rate before save!");
					return false;
				}else{
					return true;
				}
			}
		</script>
	</body>
</html>