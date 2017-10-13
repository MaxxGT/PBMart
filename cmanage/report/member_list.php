<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$from = mysqli_real_escape_string($dbconnect, $_POST['from_num']);
	$to = mysqli_real_escape_string($dbconnect, $_POST['to_num']);
	
	if($from == "" || $to == "" || $to == "0"){
		if($from == "" && $to == ""){
			$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member");
		}else if($from == "" && $to != ""){
			$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member LIMIT 0, $to");
		}else if($from != "" && ($to == "" || $to == "0")){
			$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member LIMIT 0, $from");
		}
	}else{
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member LIMIT $from, $to");
	}
	
	$no = 1;
?>

<html>
	<head>
		<title>Member Reports</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
		
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
		<script src="../js/datepicker/datetimepicker_css.js"></script>
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
						<li><a href="../report/report.php?hyperlink=reports" class="current"><span>Generate Report</span></a></li> 
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->
		</div>
		<div class="grid_16" id="content">
			<div style="display:block;height:50px;">
			</div>
			<table border="1" width="800px" cellspacing="0" cellpadding="0" class="box-table-a">
				<tr>
					<th width="20px">No.</th>
					<th width="120px">Member No.</th>
					<th width="250px">Name</th>
					<th width="250px">Email</th>
					<th width="160px">Contact</th>
				</tr>
				<?php	while($member_display = mysqli_fetch_array($member)){
							echo "<tr>";
							echo "<td>".$no++.".</td>";
							echo "<td>".$member_display['member_number']."</td>";
							echo "<td>".$member_display['member_last_name']." ".$member_display['member_first_name']."</td>";
							echo "<td>".$member_display['member_email']."</td>";
							echo "<td>".$member_display['member_contact']."</td>";
							echo "</tr>";
						}
				?>				
			</table>
		
			<?php
				include('../footer.php');
			?>
		</div>
	</body>
</html>