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
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
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
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
		exit;
	}else{

	$month_from = $_POST['month_from'];
	$month_from_txt = convert_monthToText($month_from);
	}
}

if(isset($_POST['month_to']))
{
	if($_POST['month_to']=="")
	{
		$message = "Please select month to!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
		exit;
	}else{

	$month_to = $_POST['month_to'];
	$month_to_txt = convert_monthToText($month_to);
	}
}

if(isset($_POST['promotion']))
{
	if($_POST['promotion']=='')
	{
		$message = "Please select promotion!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
		exit;
	}else
	{
		$promotion = $_POST['promotion'];
	}
}else
{
	$message = "Please select promotion!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
	exit;
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
	
<script language="javascript"> 
	function printPage(printContent) { 
	var display_setting="toolbar=yes,menubar=yes,"; 
	display_setting+="scrollbars=yes,width=950, height=750, left=100, top=25";
	
	var printpage=window.open("","",display_setting); 
	printpage.document.open(); 
	printpage.document.write('<style type="text/css">table{border:1px #000; border-collapse: collapse;}table th, table tr, table td{border:1px solid#000;}</style><html><head><title>Print Page</title></head>'); 
	printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>'); 
	printpage.document.close(); 
	printpage.focus(); 
	} 
</script> 
	
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
			
			<div align='left'>	
				<a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)"><img src="images/Print.jpg" width='75px' height='75px' title='Print Report'></img></a> 
			</div>
			
			<div id="printsection">
			
			<table class="box-table-a" align="center"width="928px">
				<tr>
					<th colspan="6" align="center">
							<h1><B>PBMART Promotions Sales Report</B></h1>
					</th>
				</tr>
				<tr>
					<td colspan="6">
						<strong>Year : </strong><?php echo $YEARS; ?><strong> | Month : </strong><?php echo $month_from_txt.' - '.$month_to_txt; ?>
					</td>
				</tr>
				
				<?php
				$count = 0;
				$iCount = 0;
				$total_gross = 0;
				$sql_filter = "";
				$sql_filter2 = "";
				foreach	($promotion as $member)
				{
					if (!empty($member)) {
						if($member == 'ALL')
						{
							$sql_product = "SELECT * FROM pbmart_promotion";
							$sql_promotion_category = "SELECT * FROM pbmart_promotion_category";
						}else
						{
							$sql_product = "SELECT * FROM pbmart_promotion";
							$sql_promotion_category = "SELECT * FROM pbmart_promotion_category";
							if($iCount ==0)
							{
								$sql_filter.= " WHERE promotion_category_id='$member'";
								$sql_filter2.=" WHERE promotion_category_id='$member'";
								$iCount++;
							}else
							{
								$sql_filter.= " OR promotion_category_id='$member'";
								$sql_filter2.= " OR promotion_category_id='$member'";
							}
						}
					}
				}
				
				$sql_promotion = $sql_promotion_category.$sql_filter2;
				$rs_promotion_category = mysqli_query($dbconnect, $sql_promotion);
				while($rw_promotion_category = mysqli_fetch_array($rs_promotion_category))
				{
					$total_product_qty = '0';
					$promotion_category_id = $rw_promotion_category['promotion_category_id'];
					$promotion_category_name = $rw_promotion_category['promotion_category_name'];
					?>
						<tr>
							<td colspan='4'>&nbsp;</td>
						</tr>
						<tr>
							<th colspan='4'><h1><strong><?php echo $promotion_category_name; ?></strong></h1></td>
						</tr>
						<tr>
							<th width='20px' align='center'>No.</th>
							<th>Products</th>
							<th align='center'>Quantity</th>
							<th align='center'>Gross Sale (RM)</th>
						</tr>
				<?php
					$sql = $sql_product." WHERE promotion_category_id='$promotion_category_id'";
					$rs_product = mysqli_query($dbconnect, $sql);
					while($rw_product = mysqli_fetch_array($rs_product))
					{
						$count++;
						$product_qty = '0';
						$order_product_amount = '0';
						$product_gross = '0';
						$promotion_id = $rw_product['promotion_id'];
						$promotion_product_model = $rw_product['promotion_product_model'];
						
						$promotion_item_name = $rw_product['promotion_item_name'];
						$promotion_item_model = $rw_product['promotion_item_model'];
						$promotion_package_price = $rw_product['promotion_package_price'];
						
						$sql_pbmart_order = "Select * FROM pbmart_order WHERE MONTH(order_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_date) = '$YEARS' AND order_status='1'";
						$rs_pbmart_order = mysqli_query($dbconnect, $sql_pbmart_order);
						while($rw_pbmart_order = mysqli_fetch_array($rs_pbmart_order))
						{
							$total_product_amount = '0';
							$order_number = $rw_pbmart_order['order_number'];
							$sql_pbmart_order_list = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number' AND order_product_id='$promotion_id' AND order_product_class='Promotion'";
							$rs_pbmart_order_list = mysqli_query($dbconnect, $sql_pbmart_order_list);
							while($rw_pbmart_order_list = mysqli_fetch_array($rs_pbmart_order_list))
							{
								
								$order_product_price = $rw_pbmart_order_list['order_product_price'];
								$order_product_handling = $rw_pbmart_order_list['order_product_handling'];
								$order_product_amount = $rw_pbmart_order_list['order_product_amount'];
								$total_product_amount += $order_product_amount;
								$product_gross += ($order_product_price + $order_product_handling) * $order_product_amount;	
							}
							$product_qty += $total_product_amount/2;
							
						}
						$total_product_qty += $product_qty;
						?>
						<tr>
							<td align='center'><?php echo $count; ?>.</td>
							<td>
								<a href="report_order_promotion.php?id=<?php echo $promotion_id; ?>&year=<?php echo $YEARS; ?>&month_from=<?php echo $month_from; ?>&month_to=<?php echo $month_to; ?>&class=Promotion" style="text-decoration: none;">
									<font color='black'>
										<?php echo '<B>'.$promotion_item_name.'</B> - '.$promotion_product_model.' - RM'.$promotion_package_price; ?>
									</font>
								</a>
							</td>
							<td align='center'><?php echo $product_qty; ?></td>
							<td align='center'><?php echo number_format($product_gross,2); ?></td>
						</tr>
				<?php 
					$total_gross += $product_gross;
					}
				}
				?>
					<tr>
						<th colspan='2' align='right'><B>Total</B></th>
						<th align='center'><?php echo $total_product_qty; ?></th>
						<th align='center'><?php echo '<B>'.number_format($total_gross,2).'</B>'; ?></th>
					</tr>
			</table>
		</div>
		
		<?php include('../footer.php'); ?>
	</div>
	</body>
</html>