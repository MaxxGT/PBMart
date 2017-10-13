<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
?>

<html>
	<head>
		<title>Stock Reports</title>
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
			<br />			
			<div class="breadcrumb">
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../report/report.php?hyperlink=reports">Generate Report</a> >> <a href="../report/member_report.php?hyperlink=reports">Member Report</a></p>
			</div>
			</br>
			</br>
			</br>
			<div id="mem_report">
				<form action="member_list.php?hyperlink=reports" method="POST">
					<table border="0" width="600px" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
						<tr>
							<td width="70px">
								<label for="from_num">From : </label>
							</td>
							<td width="230px">
								<select name="from_num">
								<?php	$from_to = array("0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100", "150", "200", "250", "300");
										echo "<option value=''>Select from...</option>";
									for($i=0; $i<count($from_to); $i++){
										echo "<option value='".$from_to[$i]."'>".$from_to[$i]."</option>";
									}
								?>
								</select>
							</td>
							<td width="70px">
								<label for="to_num">To : </label>
							</td>
							<td width="230px">
								<select name="to_num">
								<?php	$from_to = array("0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100", "150", "200", "250", "300");
										echo "<option value=''>Select to...</option>";
									for($i=0; $i<count($from_to); $i++){
										echo "<option value='".$from_to[$i]."'>".$from_to[$i]."</option>";
									}
								?>
								</select>
							</td>
						</tr>
						<tr id="mem_submit">
							<td colspan="4" align="center" style="padding:10 0 10 0;"><input type="submit" name="generate" value="Generate"/></td>
						</tr>
					</table>
				</form>
			</div>			
			</br>
			<?php
				include('../footer.php');
			?>
		</div>
	</body>
</html>