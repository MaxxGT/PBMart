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
		<title>Notifications</title>
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
        session_start();

        $device_Value =  $_SESSION['device_counter'];
        $dvp = $_SESSION['dcp'];
        
	?>
	<div class="grid_16">
		<!-- TABS START -->
		<div id="tabs">
			 <div class="container">
				<ul>
						  <li><a href="../point/point.php?hyperlink=reward"><span>Member Points</span></a></li> 
						  <li><a href="../mobile/notification.php?hyperlink=reward" class="current"><span>Mobile Notifications</span></a></li> 
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
                             <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../point/point.php?hyperlink=reward">Member Points</a> >> <a href="../mobile/notification.php?hyperlink=reward">Mobile Notifications</a></p>
			</div>
            <br />
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
	
	
	
		<form action="general_notifications.php" method="POST">
			<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th align="center"> General Mobile Notifications</th>
                                        <th align="center"> Devices Notified</th>
				</tr>
				<tr>
					<td>
						<textarea rows="3" name="ge_message" cols="50" placeholder="Type message here"></textarea>
					</td>
                                        <td>Devices:  <?php echo $device_Value ?></td>
				</tr>
				<tr>
					<th align="center">
						<input type="submit" value="Send" name="ge_send"/>
					</th>
                                        <th></th>
				</tr>
			</table>
		</form>
		</br>
                <form action="point_notification_new.php" method="POST">
			<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th align="center">Mobile Notifications Based on Points</th>
                                        <th align="center"> Devices Processed</th>
				</tr>
				<tr>
					<td>
						<p>Members with more than <input type="text" name="point" value="0"> points</p>
						<textarea rows="3" name="message" cols="50" placeholder="Type message here"></textarea>
					</td>
                                        <td>Devices:  <?php echo $dvp ?></td>
				</tr>
				<tr>
					<th align="center">
						
						<input type="submit" value="Send" name="send"/>
					</th>
                                        <th></th>
				</tr>
			</table>
		</form>
		<form action="predictLNR.php" method="POST">
			<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th align="center">Prediction Notification Based on Linear Regression </th>
				</tr>
				<tr>
					<th align="center">
						<input type="submit" value="Send" name="pre_send"/>
					</th>
				</tr>
			</table>
		</form>
		<form action="predictAVG.php" method="POST">
			<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th align="center">Prediction Notification Based on Average </th>
				</tr>
				<tr>
					<th align="center">
						<input type="submit" value="Send" name="pre_avg_send"/>
					</th>
				</tr>
			</table>
		</form>
		<br />
		<br />
		
	<?php
		include('../footer.php');
	?>

	</div>
	</body>
</html>