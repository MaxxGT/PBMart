<?php
$current_date = date("Y-m-d");
$str_date = "2015-09-09";
$end_date = "2015-09-16";

if($str_date >= $current_date && $end_date <= $current_date)
{
	$message = "This Webpage is not available, please try again later!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}

$count = 0;
$count2 = 0;
$count3 = 0;
$c_pages = 1;

$product_row = 5;
$product_col = 4;
	
if(isset($_GET['pg']))
{
	$pg = $_GET['pg'];
}else
{
	$pg = 1;
}

$sql_pbmart_product = "SELECT * FROM pbmart_promotion WHERE promotion_category_id='11'";
$rs = mysql_query($sql_pbmart_product, $link);
$rw = mysql_fetch_array($rs);

$promotion_product_name = $rw['promotion_product_name'];
$promotion_product_model = $rw['promotion_product_model'];
$promotion_product_description = $rw['promotion_product_description'];
$promotion_product_price = $rw['promotion_product_price'];
$promotion_product_sale = $rw['promotion_product_sale'];

$product_stock = $rw['promotion_package_stock'];
$product_path = $rw['promotion_product_photo'];

$category_id = (isset($_GET['category_id']) ? $_GET['category_id'] : '');

//step 2 product sql
$sql_refillGas_promotion = "SELECT * FROM pbmart_promotion WHERE promotion_category_id ='11' AND promotion_show!='1' AND promotion_package_stock > 0 AND promotion_start_date <='$current_date' AND promotion_end_date >= '$current_date'";
$rs_refillGas_promotion = mysql_query($sql_refillGas_promotion, $link);
?>

<!DOTYPE HTML>
<HTML>
	<head>
		<title>PBMART WEEKLY PROMOTION</TITLE>
	</head>
	<body>

<link rel="stylesheet" type="text/css" href="css/promotion/promotion.css" />

<!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
		<form action="weekly_promotion_process.php?act=add&trigger=product" method='post'>    
			<table border="0" width='100%'>
				<tr>
					<td valign=top>
									<!-- Content -->
										<div id="content">	
															<?php
																$rs_tupperware_promotion = @mysql_query($sql_refillGas_promotion);
																$total_products = @mysql_num_rows($rs_tupperware_promotion);
																$checked_btnRd = "";
																$checked_iCount = "1";
																while($rw_refillGas_promotion = @mysql_fetch_array($rs_refillGas_promotion))
																{
																	$promotion_id = $rw_refillGas_promotion['promotion_id'];
																	$promotion_item_name = $rw_refillGas_promotion['promotion_item_name'];
																	$promotion_item_price = $rw_refillGas_promotion['promotion_item_price'];
																	$promotion_item_sale = $rw_refillGas_promotion['promotion_item_sale'];
																	$promotion_item_photo = $rw_refillGas_promotion['promotion_item_photo'];
																	
																	if($checked_iCount == "1")
																	{
																		$checked_btnRd = "checked";
																	}else
																	{
																		$checked_btnRd = "";
																	}
																	
																	
																	if($c_pages >= cal_pg($pg, $product_row, $product_col) && $c_pages <= $total_products)
																	{
																		if($count==0)
																		{ //echo ('div class start'); ?>
																			<tr>			
																  <?php }
																				if($count >=0 && $count <=4)
																				{ //echo $count;
																						
																					if($count >= 0 && $count <= 3)
																					{ $count++; $count2++; ?>
																							<td>
																								<table border='0' width='150px' class="hoverTable2">
																									<tr>
																										<td colspan='2'>
																											<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=promotion&id=<?php echo $promotion_id; ?>" title='<?php echo $promotion_item_name; ?>'>
																												<center>
																													<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="150px" height="150px"/>
																												</center>
																											</a>
																										</td>
																									</tr>
																									<tr>
																										<td>
																											<?php echo 
																											'<B><font size=3 color=black>'.$promotion_item_name.'<strike> RM'.$promotion_item_price.'</strike></font><font color=red size=4>&nbsp; RM'.$promotion_item_sale.'</font></B>'; ?>
																										</td>
																									</tr>
																								</table>
																							</td>
																			  <?php }else
																					{ //echo ('div end called');?>
																							<td>
																								<table border='0' width='137px'>
																									<tr>
																										<td colspan='2'>
																											<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=promotion&id=<?php echo $promotion_id; ?>" title='<?php echo $promotion_item_name; ?>' target="_blank">
																												<center>
																													<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="150" height="150px"/>
																												</center>
																											</a>
																										</td>
																									</tr>
																									<tr>
																										
																										<td>
																											<?php echo '<B><font size=3 color=black>'.$promotion_item_name.'</B><strike> RM'.$promotion_item_price.'</strike>&nbsp; RM'.$promotion_item_sale.'</font>'; ?>
																										</td>
																									</tr>
																								</table>
																							</td>
																	 <?php $count=0; } ?>			
																		  <?php }
																		$count3++;
																		if($count3 == ($product_row * $product_col))
																		{
																			echo "</tr>";
																			break;
																		} ?>
															<?php	}else { $c_pages; $c_pages++; } ?>	
														  <?php
																	$checked_iCount++;
																} ?>
					</td>
				</tr>
			</table> 
										</div>		
		</form>
	</div>
</body>
</html>