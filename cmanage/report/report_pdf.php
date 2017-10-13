<?php
//Authour: Voong Tze Howe
//Date Written: 13/11/2014
//Description: Monthly Sales Report
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

$headername="<table border=\"0\">
                           <tr><td  align=\"center\" width=\"175\"><font size='18'>PBMart Montly Sales Report</font></td></tr>
                           <tr><td   width=\"175\">Monthly Order History</td></tr>
						   <tr><td   width=\"175\">Year :  $YEARS | Month : $month_from_txt - $month_to_txt  </td></tr>";
						   
$tables="<table border=\"1\" width=\"175\">
				<tr bgcolor=\"#DEDEDE\">
					<td>No.</td>
					<td>Order No.</td>
					<td>Delivery Date</td>
					<td>Amount (RM)</td>";
					
$count = 0;
$total_amount = 0;
$sql = "Select * FROM pbmart_order WHERE MONTH(order_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_date) = '$YEARS' AND order_status='1'";
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
	$order_number = $rw['order_number'];
	$order_delivery = $rw['order_delivery'];
	$order_complete_date = $rw['order_complete_date'];
	
	$parts = split('-', $order_complete_date);
	if($parts[0] == $YEARS || $parts[0] == '0')
	{
		$order_amount = $rw['order_amount'];
		$odr_amount = number_format($order_amount,2);
		$total_amount += $order_amount;
		
		$ttl_amount = number_format($total_amount,2);
		
		$tables.="<tr>
							<td>$count</td>
							<td>$order_number</td>
							<td>$order_delivery</td>
							<td align='right'>$odr_amount</td> 
						
					 </tr>";
	} 
}

	$tables.="<tr bgcolor=\"#DEDEDE\" border=\"1\">
				
				<td colspan=\"3\" align='right'>Total:</td>
				<td align='right'>$ttl_amount</td>
			 </tr></table>";
			 
$tables.="</table>";

define('FPDF_FONTPATH','../../font/');
require('../../lib/pdftable.php');

$p = new PDFTable('P','mm','A4');
$p->setfont('Arial','',10);
$p->headerTable=$headername;  
$p->AddPage();
$p->htmltable($tables);
$p->output('PBMart Montly Report.pdf','I');
?>