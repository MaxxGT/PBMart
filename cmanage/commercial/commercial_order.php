<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}

	$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial");
	
	$non_order = array();
	$ordered = array();
	$non_order_loop_count = 0;
	$ordered_loop_count = 0;
	$commercial_num = 1;

	while($commercial_display = mysqli_fetch_array($commercial)){	
		$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_customer_id='".$commercial_display['commercial_member_id']."' AND order_delivery='".date("Y-m-d")."'");
		$order_exist = mysqli_num_rows($order);
		
		if($order_exist){
			$ordered[$ordered_loop_count] = $commercial_display['commercial_company'];
			$ordered_loop_count++;
		}else{
			$non_order[$non_order_loop_count] = $commercial_display['commercial_company'];
			$non_order_loop_count++;
		}
	}
?>

<html>
	<head>
		<title>Commercial Order</title>
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
		
		<style>
			#date_style{
				display:block;
				width:500px;
				height:50px;
				margin-left:auto;
				margin-right:auto;
				line-height:50px;
				background-color:Lavender;
			}
		</style>
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
						<li><a href="../commercial/commercial_order.php?hyperlink=commercial" ><span>Commercial Order</span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				 <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../commercial/commercial_order.php?hyperlink=commercial">Commercial Order</a></p>
			</div>
			<br />		
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
			
			<table border="2" align="center" width="700px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="2" align="center">Commercial Order List</th>
				</tr>
				<tr height="20px;">
					<td colspan="2" style="border-style:hidden;"></td>
				</tr>
				<tr>
					<td colspan="2" style="border-style:hidden;font-size:20pt;font-weight:bold;text-align:center;"><span id="date_style"><span style="padding-right:10px;">>></span><?php	echo date("Y-m-d");	?><span style=";padding-left:10px;"><<</span></span></td>
				</tr>
				<tr height="20px;">
					<td colspan="2" style="border-style:hidden;"></td>
				</tr>
				<?php	for($i = 0; $i < $non_order_loop_count; $i++){
							echo "<tr>";
							echo "<td width='20px' style='border:3px solid Gainsboro;background-color:Gainsboro;'>".$commercial_num++."</td>";
							echo "<td style='border:3px solid Crimson;background-color:Pink;'>".$non_order[$i]."</td>";
							echo "</tr>";
							echo "<tr height='40px;'><td style='border-style:hidden;'></td></tr>";
						}
						
						for($i = 0; $i < $ordered_loop_count; $i++){
							echo "<tr>";
							echo "<td width='20px' style='border:3px solid Gainsboro;background-color:Gainsboro;'>".$commercial_num++."</td>";
							echo "<td style='border:3px solid Lime;background-color:Aquamarine;'>".$ordered[$i]."</td>";
							echo "</tr>";
							echo "<tr height='40px;'><td style='border-style:hidden;'></td></tr>";
						}
				?>
			</table>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
				<?php
					include('../footer.php');
				?>
		</div>
	</body>
</html>