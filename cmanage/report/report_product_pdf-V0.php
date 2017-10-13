<?php
require_once("../../connection/pbmartconnection.php");
ini_set("max_execution_time",300);

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
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
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
		echo "<script language='JavaScript'>window.top.location ='report.php';</script>";
		exit;
	}else{

	$month_to = $_POST['month_to'];
	$month_to_txt = convert_monthToText($month_to);
	}
}

if(isset($_POST['product']))
{
	if($_POST['product']=='')
	{
		$message = "Please select product!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='sale_report.php';</script>";
		exit;
	}else
	{
		$products = $_POST['product'];
	}
}else
{
		$message = "Please select product!";
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

//get flat handing
$total_flat_handling = '0';
$sql_get_flat_order = "SELECT * FROM pbmart_order WHERE flat_handling !='0' AND order_status='1'";
$rs_get_flat_order = mysql_query($sql_get_flat_order);
while($rw_get_flat_order = mysql_fetch_array($rs_get_flat_order))
{
	$total_flat_handling = $total_flat_handling + $rw_get_flat_order['flat_handling'];
}


$headername="<table border=\"0\">
                           <tr><td  align=\"center\" width=\"175\"><font size='18'>PBMart Products Sales Report</font></td></tr>
                           <tr><td   width=\"175\">Monthly Order History</td></tr>
						   <tr><td   width=\"175\">Year :  $YEARS | Month : $month_from_txt - $month_to_txt  </td></tr>";
						   
$tables="<table border=\"1\" width=\"175\">
				<tr bgcolor=\"#DEDEDE\">
					<td>No</td>
					<td>Products</td>
					<td align='center'>Quantity</td>
					<td>Gross Sale (RM)</td>
				</tr>";
					
$count = 0;
				$iCount = 0;
				$total_prd_qty = 0;
				$total_gross = 0;
				$sql_filter = "";
				
				foreach	($products as $member)
				{
					if (!empty($member)) {
						if($member == 'ALL')
						{
							$sql_product = "SELECT * FROM pbmart_product";
						}else if($member == 'ALL_SALE')
						{
							$sql_product = "SELECT * FROM pbmart_product";
						}else
						{
							$sql_product = "SELECT * FROM pbmart_product";
							if($iCount ==0)
							{
								$sql_filter.= " WHERE product_id='$member'";
								$iCount++;
							}else
							{
								$sql_filter.= " OR product_id='$member'";
							}
						}
					}
				}
			
				$sql = $sql_product.$sql_filter;
				$rs_product = mysqli_query($dbconnect, $sql);
				while($rw_product = mysqli_fetch_array($rs_product))
				{
				
					$product_qty = '0';
					$product_gross = '0';
					$product_id = $rw_product['product_id'];
					$product_name = $rw_product['product_name'];
					$product_model = $rw_product['product_model'];
					
					$sql_pbmart_order = "Select * FROM pbmart_order WHERE MONTH(order_complete_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_complete_date) = '$YEARS' AND order_status='1'";
					$rs_pbmart_order = mysqli_query($dbconnect, $sql_pbmart_order);
					while($rw_pbmart_order = mysqli_fetch_array($rs_pbmart_order))
					{
						$order_number = $rw_pbmart_order['order_number'];
						$sql_pbmart_order_list = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number' AND order_product_id='$product_id' AND order_product_class='Product'";
						$rs_pbmart_order_list = mysqli_query($dbconnect, $sql_pbmart_order_list);
						$rw_pbmart_order_list = mysqli_fetch_array($rs_pbmart_order_list);
						$order_product_price = $rw_pbmart_order_list['order_product_price'];
						$order_product_handling = $rw_pbmart_order_list['order_product_handling'];
						$order_product_amount = $rw_pbmart_order_list['order_product_amount'];
						$product_qty += $order_product_amount;
						$product_gross += ($order_product_price + $order_product_handling) * $order_product_amount;
					}
					$total_prd_qty += $product_qty;
					$total_gross += $product_gross;
					$product_gross = number_format($product_gross,2);
					
					
					foreach	($products as $member)
					{
						if (!empty($member)) {
							if($member == 'ALL')
							{
								$count++;
								$tables.= "	 <tr>
												<td align='center' width='5px'>$count.</td>
												<td width='125px'>$product_name - $product_model</td>
												<td align='center'>$product_qty</td>
												<td align='right' width='25px'>$product_gross</td>
											</tr>";
							}else if($member == "ALL_SALE")
							{
								if($product_qty !='0')
								{	
									$count++;
									$tables.= "	 <tr>
													<td align='center' width='5px'>$count.</td>
													<td width='125px'>$product_name - $product_model</td>
													<td align='center'>$product_qty</td>
													<td align='right' width='25px'>$product_gross</td>
												</tr>";
								}
							}else
							{
								$count++;
								$tables.= "	 <tr>
												<td align='center' width='5px'>$count.</td>
												<td width='125px'>$product_name - $product_model</td>
												<td align='center'>$product_qty</td>
												<td align='right' width='25px'>$product_gross</td>
											</tr>";
							}
						}
					}	
					
					
						
							
				}
				$total_gross = number_format($total_gross, 2);
				
	$tables.="<tr bgcolor=\"#DEDEDE\" border=\"1\">
				
				<td colspan=\"2\" align='right'>Total:</td>
				<td align='center'>$total_prd_qty</td>
				<td align='right'>$total_gross</td>
			 </tr></table>";
$tables.="</table>";

define('FPDF_FONTPATH','../../font/');
require('../../lib/pdftable.php');

$p = new PDFTable('P','mm','A4');
$p->setfont('Arial','',10);
$p->headerTable=$headername;  
$p->AddPage();

	$p->htmltable($tables);

$p->output('PBMart Products Sales Report.pdf','I');
?>