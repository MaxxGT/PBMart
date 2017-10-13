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


$headername="<table border=\"0\">
                           <tr><td  align=\"center\" width=\"175\"><font size='18'>PBMart Promotions Sales Report</font></td></tr>
                           <tr><td   width=\"175\">Monthly Order History</td></tr>
						   <tr><td   width=\"175\">Year :  $YEARS | Month : $month_from_txt - $month_to_txt  </td></tr>";
$tables2="";						   
$tables="<table border=\"1\" width=\"175\">
				<tr bgcolor=\"#DEDEDE\">
					<td>No</td>
					<td>Products</td>
					<td align='center'>Quantity</td>
					<td>Gross Sale (RM)</td>
				</tr>";
	
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
					
					$tables.="
							<tr>
								<td colspan='4'>&nbsp;</td>
							</tr>
							<tr>
								<td colspan='4'>$promotion_category_name</td>
							</tr>
							<tr>
								<th width='5px'>No</th>
								<th>Products</th>
								<th align='center'>Quantity</th>
								<th align='center'>Gross Sale (RM)</th>
							</tr>";
						
						
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
						
						$sql_pbmart_order = "Select * FROM pbmart_order WHERE MONTH(order_complete_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_complete_date) = '$YEARS' AND order_status='1'";
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
						$product_gross = number_format($product_gross,2);
						$total_product_qty += $product_qty;
						
						$tables.="
							<tr>
							<td width='5px'>$count.</td>
							<td wodth='100px'>
									<font color='black'>
										$promotion_item_name - $promotion_product_model - RM$promotion_package_price
									</font>
								
							</td>
							<td width='5px' align='center'>$product_qty</td>
							<td width='20px' align='right'>$product_gross</td>
						</tr>";
	
	
						$total_gross += $product_gross;
					}
				}
				
				$tables2.="
					<tr>
						<td colspan='4'>&nbsp;</td>
					</tr>
					
					<tr>
						<td colspan='4'><h1><strong><B>ORDERS</B></strong></h1></td>
					</tr>
					<tr>
							<th align='center'>No.</th>
							<th colspan='2'>Orders Number</th>
							<th align='center'>Gross Sale (RM)</th>
					</tr>";
			
					$iCounts = '0';
							
							$filter = "";
							$sql_missing_promotion = "select promotion_id, promotion_category_id FROM pbmart_promotion";
							$rs_missing_promotion = @mysql_query($sql_missing_promotion);
							while($rw_missing_promotion = mysql_fetch_array($rs_missing_promotion))
							{
								$promotion_id = $rw_missing_promotion['promotion_id'];
								$filter.= "AND order_product_id !='$promotion_id' ";
							}
							$sql_missing_order_list = "SELECT order_number, order_product_id, order_product_class, order_product_price, order_product_handling, order_product_amount  FROM pbmart_order_list WHERE order_product_class='Promotion' $filter";
							$rs_missing_order_list = @mysql_query($sql_missing_order_list);
							$num ='';
							$total_order_product_price = '0';
							while($rw_missing_order_list = mysql_fetch_array($rs_missing_order_list))
							{ 
								
								$or_num = $rw_missing_order_list['order_number'];
								$order_product_price = ($rw_missing_order_list['order_product_price'] + $rw_missing_order_list['order_product_handling']) * $rw_missing_order_list['order_product_amount'].'<BR/>';
								$total_order_product_price = $total_order_product_price + $order_product_price;
								if($num != $or_num)
								{
									$count++;
									$num = $rw_missing_order_list['order_number'];
									$sql_order_missing = "SELECT order_number, order_amount FROM pbmart_order WHERE order_number = '$or_num'";
									$rs_order_missing = @mysql_query($sql_order_missing);
									$rw_order_missing = mysql_fetch_assoc($rs_order_missing);
									$order_amount = $rw_order_missing['order_amount'];
									$order_amount = number_format($order_amount,2);
										$order_product_price = $rw_missing_order_list['order_product_price'] * $rw_missing_order_list['order_product_amount'];
										$order_number = $rw_missing_order_list['order_number'];
									$tables2.="
										<tr>
											<td>
												$count.
											</td>
											<td colspan='2'>
												$order_number
											</td>
											<td align='right'>$order_amount</td>
										</tr>";
	
								 $total_gross += $order_amount;
								 }
							}
	$total_gross = number_format($total_gross, 2);	
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

$p->output('PBMart Products Sales Report.pdf','I');

?>