<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_commercial_status='1'");
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
						<li><a href="view_member.php?hyperlink=members" class="current"><span>Members</span></a></li>   
						<li><a href="add_member.php?hyperlink=members"><span>Add New Member</span></a></li><li><a href="view_commercial.php?hyperlink=members"><span>Commercial Application</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				 <p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_member.php?hyperlink=members">Members</a> >> <a href="../member/view_commercial_list.php"> Commercial List</a></p>
			</div>
			<br />		
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
			
			<table border="1"  width="800px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="9" align="center"><h1><B>Commercial Management</B></h1></th>
				</tr>
				<tr>
					<th width="130px" style="padding-left:5;">Commercial No.</th>
					<th width="450px" style="padding-left:5;">Company Name</th>
					<th width="50px" align='right'>Point</th>
					<th width="30px" style="padding-left:5;">Edit</th>
				</tr>
				<?php	while($member_display = mysqli_fetch_array($member)){
							$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='".$member_display['member_id']."'");
							
							while($commercial_display = mysqli_fetch_array($commercial)){
								echo "<tr>";
								echo "<td>".$commercial_display['commercial_number']."</td>";
								
								echo "<td>".$commercial_display['commercial_company']."</td>";
								echo "<td align='right'>".number_format($member_display['member_point'],0)."</td>";
								
								
								echo "<td><a href='edit_member.php?mem=".$member_display['member_id']."&hyperlink=members'><img src='../images/edit.png' width='20px' height='20px' alt='Edit member'/></a></td>";
								echo "</tr>";
							}
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