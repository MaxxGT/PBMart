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

function search_promo($cat_id, $month_from, $month_to, $YEARS)
{
	require_once("../../connection/pbmartconnection.php");
	$iCount = '0';
	$sql_promo = "SELECT promotion_id, promotion_category_id FROM pbmart_promotion WHERE promotion_category_id='$cat_id'";
	$rs_promo = @mysql_query($sql_promo);
	while($rw_promo = @mysql_fetch_array($rs_promo))
	{
		$promotion_id = $rw_promo['promotion_id'];
		
		$sql_pbmart_order = "Select * FROM pbmart_order WHERE MONTH(order_complete_date) BETWEEN '$month_from' AND '$month_to' AND YEAR(order_complete_date) = '$YEARS' AND order_status='1'";
		$rs_pbmart_order = @mysql_query($sql_pbmart_order);
		while($rw_pbmart_order = @mysql_fetch_array($rs_pbmart_order))
		{
			$total_product_amount = '0';
			$order_number = $rw_pbmart_order['order_number'];
			$sql_pbmart_order_list = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number' AND order_product_id='$promotion_id' AND order_product_class='Promotion'";
			$rs_pbmart_order_list = @mysql_query($sql_pbmart_order_list);
			while($rw_pbmart_order_list = @mysql_fetch_array($rs_pbmart_order_list))
			{
				$iCount++;
			}
		}
	}
	return $iCount;
}


$headername="<table border=\"0\">
                           <tr><td  align=\"center\" width=\"175\"><font size='18'>PBMart Promotions Sales Report</font></td></tr>
                           <tr><td   width=\"175\">Monthly Order History</td></tr>
						   <tr><td   width=\"175\">Year :  $YEARS | Month : $month_from_txt - $month_to_txt  </td></tr>";
$tables2="";						   
$tables="<table border=\"1\" width=\"175\">
				";
	
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
						}else if($member == "ALL_SALE")
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
					
					foreach	($promotion as $member)
					{
						if (!empty($member)) 
						{
							if($member == 'ALL')
							{
								$tables.="
										<tr>
											<td colspan='4'></td>
										</tr>
										<tr>
											<td colspan='4'>$promotion_category_name</td>
										</tr>
										<tr>
											<td width='10px'>No</td>
											<td>Products</td>
											<td align='center'>Quantity</td>
											<td align='center'>Gross Sale (RM)</td>
										</tr>";
							}else
							{	
								if(search_promo($promotion_category_id, $month_from, $month_to, $YEARS) != '0')
								{
									$tables.="
										<tr>
											<td colspan='4'></td>
										</tr>
										<tr>
											<td colspan='4'>$promotion_category_name</td>
										</tr>
										<tr>
											<td width='10px'>No</td>
											<td>Products</td>
											<td align='center'>Quantity</td>
											<td align='center'>Gross Sale (RM)</td>
										</tr>";
								}
							}
						}
					}
						
					$sql = $sql_product." WHERE promotion_category_id='$promotion_category_id'";
					$rs_product = mysqli_query($dbconnect, $sql);
					while($rw_product = mysqli_fetch_array($rs_product))
					{
						
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
							$product_qty = round($product_qty, 0, PHP_ROUND_HALF_DOWN);
							
						}
						$product_gross = number_format($product_gross,2);
						$total_product_qty += $product_qty;
						
						
						foreach	($promotion as $member)
						{
							if (!empty($member)) 
							{
								if($member == 'ALL')
								{
									$count++;				
									$tables.="
										<tr>
										<td width='5px'>$count.</td>
										<td wodth='100px'>
												<font color='black'>
													$promotion_item_name - $promotion_product_model - RM$promotion_package_price
												</font>
											
										</td>
										<td width='5px' align='center'>$product_qty</td>
										<td width='30px' align='right'>$product_gross</td>
									</tr>";
								}else
								{
									if($product_qty !='0')
									{	$count++;				
										$tables.="
											<tr>
											<td width='5px'>$count.</td>
											<td wodth='100px'>
													<font color='black'>
														$promotion_item_name - $promotion_product_model - RM$promotion_package_price
													</font>
												
											</td>
											<td width='5px' align='center'>$product_qty</td>
											<td width='30px' align='right'>$product_gross</td>
										</tr>";
					
									}
								}
							}
						}
						$total_gross += $product_gross;
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