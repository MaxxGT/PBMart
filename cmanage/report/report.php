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
		<title>Reports</title>
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
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../report/report.php?hyperlink=reports">Generate Report</a></p>
			</div>
			</br>
			</br>
			</br>
			<div id="report">
				<a href="sale_report.php?hyperlink=reports"><input type="image" src="images/sale.png" title="Sales Report" onmouseover="this.src='images/sale_show.png'" onmouseout="this.src='images/sale.png'" width="100px" height="100px"/></a>
				<a href="stock_report.php?hyperlink=reports" title="Stock Report"><input type="image" src="images/stock.png" title="Sales Report" onmouseover="this.src='images/stock_show.png'" onmouseout="this.src='images/stock.png'" id="stock_img" width="100px" height="100px"/></a>
				<a href="member_report.php?hyperlink=reports" title="Member Report"><input type="image" src="images/member.png" title="Member Report" onmouseover="this.src='images/member_show.png'" onmouseout="this.src='images/member.png'" id="member_img" width="100px;" height="100px"/></a>
				<a href="redemption_report.php?hyperlink=reports" title="Redemption Report"><input type="image" src="images/member.png" title="Redemption Report" onmouseover="this.src='images/member_show.png'" onmouseout="this.src='images/member.png'" id="member_img" width="100px;" height="100px"/></a>
			</div>
			</br>
			
			<?php
				include('../footer.php');
			?>
		</div>
	</body>
</html>