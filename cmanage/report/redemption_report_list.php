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

	$sql = "SELECT * FROM pbmart_redemption_list WHERE MONTH(redemption_delivery_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(redemption_delivery_date) = '$YEARS' AND redemption_status='1'";
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

		@this section must finish
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
		<form name='rprt_lst_form' action='report_list.php' method='post'>	
			<table class="box-table-a" align="center"width="928px">
				<tr>
					<th colspan="5" align="center">
						<font size='1'>PBMart Montly Redemption Report</font>
					</th>
				</tr>
				<tr>
					<td colspan="5">
						<strong>Year : </strong><?php echo $YEARS; ?><strong> | Month : </strong><?php echo $month_from_txt.' - '.$month_to_txt; ?>
					</td>
				</tr>
				
				<tr>
						<th align='center' width='20px'>No.</th>
						<th align='center'  width='150px'>Redemption No.</th>
						<th align='center'>Redemption Item</th>
						<th align='center'>Delivery Date</th>
						<th align='center'>Quantiy</th>
				</tr>
				
				<?php
				$count = 0;
				$iCount = 0;
				
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
					$count++;
					$redemption_number = $rw['redemption_number'];
					$redemption_delivery_date = $rw['redemption_delivery_date'];
					$redemption_item = $rw['redemption_item'];
					$redemption_amount = $rw['redemption_amount'];
					$iCount += $redemption_amount;
				?>
					<tr>
						<td><?php echo $count; ?>.</td>
						<td align='center'><?php echo $redemption_number; ?></td>
						<td align='center'><?php echo $redemption_item; ?></td>
						<td align='center'><?php echo $redemption_delivery_date; ?></td>
						<td align='center'><?php echo $redemption_amount; ?></td> 
					</tr>
				<?php }  ?>
				<tr>			
					<th colspan="4" align='right'>Total:</th>
					<th align='center'><?php echo $iCount; ?></th>
						<input type='hidden' name='month_from' value='<?php echo $month_from; ?>' />
						<input type='hidden' name='month_to' value='<?php echo $month_to ?>' />
						<input type='hidden' name='year' value='<?php echo $YEARS; ?>' />
				</tr>
			</table>
		</form>
			<br />						
			<br />
			<br />
		<?php
			include('../footer.php');
		?>
</div>