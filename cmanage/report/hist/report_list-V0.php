<?php
//Authour: Voong Tze Howe
//Date Written: 15/11/2014
//Description: Display list of sales report by month
//Last Modification:
require_once("../../connection/pbmartconnection.php");

if(isset($_POST['year']))
{
	if($_POST['year']=='')
	{
		$message = "Please select year!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
		exit;
	}else
	{
		$YEARS = $_POST['year'];
	}
}

if(isset($_POST['month_from']))
{
	if($_POST['month_from']=="")
	{
		$message = "Please select month!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
		exit;
	}else{

	$month_from = $_POST['month_from'];
	$month_from_txt = convert_monthToText($month_from);
	}
}

function convert_monthToText($month)
{
	if($month == '1')
	{
		$txt_month = "JANUARY";
	}if($month == '2')
	{
		$txt_month = "FEBRUARY";
	}if($month == '3')
	{
		$txt_month = "MARCH";
	}if($month == '4')
	{
		$txt_month = "APRIL";
	}if($month == '5')
	{
		$txt_month = "MAY";
	}if($month == '6')
	{
		$txt_month = "JUNE";
	}if($month == '7')
	{
		$txt_month = "JULY";
	}if($month == '8')
	{
		$txt_month = "AUGUST";
	}if($month == '9')
	{
		$txt_month = "SEPTEMBER";
	}if($month == '10')
	{
		$txt_month = "OCTOBER";
	}if($month == '11')
	{
		$txt_month = "NOVEMBER";
	}if($month == '12')
	{
		$txt_month = "DECEMBER";
	}
	return $txt_month;
}

if(isset($_POST['month_to']))
{
	if($_POST['month_to']=="")
	{
		$message = "Please select month to!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
		exit;
	}else{

	$month_to = $_POST['month_to'];
	$month_to_txt = convert_monthToText($month_to);
	}
}
?>

<html>
	<head>
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
		<script language=JavaScript>
			function autoSubmit() {
			var formObject = document.forms['report_form'];
				formObject.submit();
			}
		</script>

		<script type="text/javascript">
			document.getElementById("myButton").onclick = function () {
				location.href = "report_list.php";
			};
		</script>
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
						  <li><a href="../report/report.php" class="current"><span>Generate Report</span></a></li> 
			   </ul>
			</div>
		</div>
		<!-- TABS END -->    
	</div>	
	<div class="grid_16" id="content">	
			<br />						
			<br />
			<br />
			<table class="box-table-a" align="center"width="928px">
				<tr>
					<th colspan="4" align="center">
						<font size='1'>PBMart Montly Sales Report</font>
					</th>
				</tr>
				<tr>
					<td colspan="4">
						<strong>Year : </strong><?php echo $YEARS; ?><strong> | Month : </strong><?php echo $month_from_txt.' - '.$month_to_txt; ?>
					</td>
				</tr>
				<tr>
						<th>No.</th>
						<th>Order No.</th>
						<th align='center'>Complete Date</th>
						<th align='center'>Amount (RM)</th>
				</tr>
				
				<?php
				$count = 0;
				$total_amount = 0;
				$sql = "SELECT * FROM pbmart_order WHERE MONTH(order_complete_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_complete_date) = '$YEARS' AND order_status='1'";
				$rs = @mysql_query($sql, $link);
				$total_rows = @mysql_num_rows($rs);

				if($total_rows == '0')
				{
					$message = "Error: No Data to display!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
					exit;
				}


				while($rw = @mysql_fetch_array($rs))
				{
					
					$order_number = $rw['order_number'];
					$order_delivery = $rw['order_delivery'];
					
					$order_delivery = date("d-m-Y", strtotime($order_delivery));
					$order_complete_date = $rw['order_complete_date'];
					$order_complete_date = date("d-m-Y", strtotime($order_complete_date));
					
					$order_amount = $rw['order_amount'];
					$odr_amount = number_format($order_amount,2);
					$count++;
					$total_amount += $order_amount;
					$ttl_amount = number_format($total_amount,2);
				?>

				<tr>
					<td><?php echo $count; ?>.</td>
					<td><?php echo $order_number; ?></td>
					<td><center><?php echo $order_complete_date; ?><center></td>
					
					<td align='right'><?php echo $odr_amount; ?></td> 
				</tr>

		  <?php } ?>
				<tr>			
					<th colspan="3" align='right'>Total:</th>
					<th align='right'><?php echo $ttl_amount; ?></th>
				</tr>
			</table>
			<br />						
			<br />
			<br />
			
		<?php
				include('../footer.php');
			?>
	</div>	