<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$com = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_status='0'");
?>

<html>
	<head>
		<title>Commercial Application</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
						<li><a href="view_member.php?hyperlink=members"><span>Members</span></a></li>   
						<li><a href="add_member.php?hyperlink=members"><span>Add New Member</span></a></li>
						<li><a href="view_commercial.php?hyperlink=members" class="current"><span>Commercial Application</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
			   <p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_commercial.php?hyperlink=members">Commercial Application</a></p>
			</div>
			<br />	
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<table border="0" width="800px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th align="center" colspan="5">Commercial Application Management</th>
				</tr>
				<tr>
					<th>Status :</th>
					<td colspan="4">
						<?php	if(!isset($_GET['app'])){
								}else{
									$change = mysqli_real_escape_string($dbconnect, $_GET['app']);
									
									if($change == "true"){
										echo "<span class='success'>Commercial successfully approved.</span>";
									}else if($change == "false"){
										echo "<span>Commercial failed to be approved! Please try again.</span>";
									}else if($change == "distrue"){
										echo "<span class='success'>Commercial successfully disapproved.</span>";
									}else if($change == "disfalse"){
										echo "<span>Commercial failed to be disapproved! Please try again.</span>";	
									}
								}
						?>
					</td>
				</tr>
				<tr>
					<th width="100px">Commercial Number</th>
					<th width="150px">Company Name</th>
					<th width="100px">Company Phone</th>
					<th width="250px">Company Address</th>
					<th width="150px">Person in Charge</th>
				</tr>
				<?php	while($com_display = mysqli_fetch_array($com)){	?>
				<tr class="link" href="view_commercial_detail.php?com=<?=$com_display['commercial_id']?>&hyperlink=members">
					<td><?=$com_display['commercial_number']?></td>
					<td><?=$com_display['commercial_company']?></td>
					<td><?=$com_display['commercial_phone']?></td>
					<td><?=$com_display['commercial_address']?></td>
					<td><?=$com_display['commercial_person_incharge']?></td>
				</tr>
				<?php	}	?>
			</table>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<?php
				include('../footer.php');
			?>
		</div>
		
		<script>
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		</script>
	</body>
</html>