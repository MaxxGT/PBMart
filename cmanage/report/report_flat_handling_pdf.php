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

$headername="<table border=\"0\">
                           <tr><td  align=\"center\" width=\"175\"><font size='18'>PBMart Flat Handling Report</font></td></tr>
                           <tr><td   width=\"175\">Monthly Order History</td></tr>
						   <tr><td   width=\"175\">Year :  $YEARS | Month : $month_from_txt - $month_to_txt  </td></tr>";
						   
$tables="<table border=\"1\" width=\"175\">
				<tr bgcolor=\"#DEDEDE\">
					<td>No.</td>
					<td>Order No</td>
					<td align='center'>Customer Name</td>
					<td>Flat Handling (RM)</td>
				</tr>";
					
$count = 0;
				$iCount = 0;
				$total_prd_qty = 0;
				$total_gross = 0;
				$sql_filter = "";
				
				$total_gross = '0';
				$count = '0';
				$sql_flat_handling = "SELECT order_number, order_customer_name, flat_handling, order_complete_date FROM pbmart_order WHERE MONTH(order_complete_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_complete_date)='$YEARS' AND order_status='1' AND flat_handling!='0'";
				$rs_flat_handling = mysqli_query($dbconnect, $sql_flat_handling);
				while($rw_product = mysqli_fetch_array($rs_flat_handling))
				{
					$count++;
					$order_number = $rw_product['order_number'];
					$order_customer_name = $rw_product['order_customer_name'];
					$flat_handling = $rw_product['flat_handling'];
					$flat_handling = number_format($flat_handling, 2);
					
					$tables.= "	 <tr>
									<td align='center' width='10px'>$count.</td>
									<td width='25px' align='center'>$order_number</td>
									<td align='center'>$order_customer_name</td>
									<td align='right' width='35px'>$flat_handling</td>
								</tr>";
				
				$total_gross += $flat_handling;
				$total_gross = number_format($total_gross,2);
				}
	$tables.="<tr bgcolor=\"#DEDEDE\" border=\"1\">
				
				<td colspan=\"3\" align='right'>Total:</td>
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

$p->output('PBMart Flat Handling Report.pdf','I');
?>