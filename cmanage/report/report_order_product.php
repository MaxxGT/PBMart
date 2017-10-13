<?php
require_once("../../connection/pbmartconnection.php");
	$id = $_GET['id'];
	$order_product_class = $_GET['class'];

	
if(isset($_GET['class']))
{
	if($_GET['class']=='')
	{
		$message = "Please select year!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
		exit;
	}else
	{
		$class = $_GET['class'];
	}
}	
	
	
	
if(isset($_GET['year']))
{
	if($_GET['year']=='')
	{
		$message = "Please select year!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
		exit;
	}else
	{
		$YEARS = $_GET['year'];
	}
}

if(isset($_GET['month_from']))
{
	if($_GET['month_from']=="")
	{
		$message = "Please select month!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
		exit;
	}else{

	$month_from = $_GET['month_from'];
	$month_from_txt = convert_monthToText($month_from);
	}
}

if(isset($_GET['month_to']))
{
	if($_GET['month_to']=="")
	{
		$message = "Please select month to!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
		exit;
	}else{

	$month_to = $_GET['month_to'];
	$month_to_txt = convert_monthToText($month_to);
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
					<li><a href="../report/report.php" class="current"><span>Orders Report</span></a></li> 
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
					<th colspan="6" align="center">
						<h1><B>PBMART Orders Report</B></h1>
					</th>
				</tr>
				
				<tr>
					<td colspan="6">
						<strong>Year : </strong><?php echo $YEARS; ?><strong> | Month : </strong><?php echo $month_from_txt.' - '.$month_to_txt; ?>
					</td>
				</tr>
				
				
				<?php
					$sql_product = "SELECT * FROM pbmart_product WHERE product_id='$id'";
					$rs_product = mysqli_query($dbconnect, $sql_product);
					$rw_product = mysqli_fetch_array($rs_product);
					$product_name = $rw_product['product_name'];
					$product_model = $rw_product['product_model'];
					$product_image = $rw_product['product_image']; 
					?>
						<tr>
							<td colspan='5'>
								&nbsp;&nbsp;&nbsp;
								<img src='../product/<?php echo $product_image; ?>' width='150px' height='125px' />
									<h2><B><?php echo $product_name.' - '.$product_model; ?></B><BR/></h2>
							</td>
						</tr>
					<?php
				?>
				<tr>
					<th width='20px'>No.</th>
					<th width='105px' align='center'>Order Number</th>
					<th align='center'>Customer Name</th>
					<th align='center' width='50px'>Quantity</th>
					<th align='center' width='150px'>Order Amount (RM)</th>
				</tr>
				
				<?php
					$total_order_product_amount = '0';
					$total_order_amount = '0';
					$iCount = '1';
					$sql_pbmart_order = "Select * FROM pbmart_order WHERE MONTH(order_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_date) = '$YEARS' AND order_status='1'";
					$rs_pbmart_order = mysqli_query($dbconnect, $sql_pbmart_order);
					while($rw_pbmart_order = mysqli_fetch_array($rs_pbmart_order))
					{
						$product_gross = '0';
						$order_product_id = '';
						$order_number = $rw_pbmart_order['order_number'];
						$order_customer_id = $rw_pbmart_order['order_customer_id'];
						
						$sql_pbmart_commercial = "SELECT commercial_member_id, commercial_company FROM pbmart_commercial WHERE commercial_member_id='$order_customer_id'";
						$rs_pbmart_commercial = mysqli_query($dbconnect, $sql_pbmart_commercial);
						$rw_pbmart_commercial = mysqli_fetch_array($rs_pbmart_commercial);
						$commercial_company = $rw_pbmart_commercial['commercial_company'];
						
						
						
						$order_customer_name = $rw_pbmart_order['order_customer_name'];			
						$sql_pbmart_order_list = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number' AND order_product_id='$id' AND order_product_class='$class'";
						$rs_pbmart_order_list = mysqli_query($dbconnect, $sql_pbmart_order_list);
						while($rw_pbmart_order_list = mysqli_fetch_array($rs_pbmart_order_list))
						{
							$order_product_id = $rw_pbmart_order_list['order_product_id'];
							$order_product_price = $rw_pbmart_order_list['order_product_price'];
							$order_product_handling = $rw_pbmart_order_list['order_product_handling'];
							$order_product_amount = $rw_pbmart_order_list['order_product_amount'];
							$order_amount = $rw_pbmart_order['order_amount'];
							$product_gross += ($order_product_price + $order_product_handling) * $order_product_amount;
							$total_order_product_amount += $order_product_amount;
							$total_order_amount += $product_gross;
						}	
						
						if($order_product_id == $id)
						{
						?>
							<tr>
								<td width='20px' align='center'><?php echo $iCount; ?>.</td>
								<td align='center'><a href="../order/view_orderList.php?or=<?php echo $order_number; ?>&view=or&hyperlink=orders"><?php echo $order_number; ?></a></td>
								<td>
									<?php 
										if($commercial_company !="")
											echo $order_customer_name.' ('.$commercial_company.')';
										else
											echo $order_customer_name;
										?>
								</td>
								<td align='center'><?php echo $order_product_amount; ?></td>
								<td align='right'><?php echo number_format($product_gross,2); ?></td>
							</tr>
					  
					  <?php $iCount++;
						}
					}
					
				?>
				<tr>
					<td colspan='3' align='right'><B>Total(RM)</B></td>
					<td align='center'><?php echo $total_order_product_amount; ?></td>
					<td align='right'><B><?php echo number_format($total_order_amount,2); ?></B></td>
				</tr>
			</table>
		<?php include('../footer.php'); ?>
	</div>
</body>
</html>