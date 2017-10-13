<?php
	$count = 0;
	$count2 = 0;
	$count3 = 0;
	$c_pages = 1;

	$product_row = 2;
	$product_col = 5;
	
	if(isset($_GET['pg']))
	{
		$pg = $_GET['pg'];
	}else
	{
		$pg = 1;
	}
	if(isset($_POST['product_id']))
	{
		$prd_id = $_POST['product_id'];
	}else
	{
		$prd_id = "";
	}
	
	if(isset($_POST['btnRd_product']))
	{
		$btnRd_product = $_POST['btnRd_product'];
	}else
	{
		$btnRd_product = "";
	}
	
	$current_date = date('Y-m-d');
	
	if($btnRd_product == '0')
	{
		$sql_promoA = "SELECT * FROM pbmart_product WHERE product_category_id = '19' AND product_stock !='0'";
	}else if($btnRd_product == '1')
	{
		$sql_promoA = "SELECT * FROM pbmart_product WHERE product_category_id = '19' AND product_stock !='0'";
	}else
	{
		$sql_promoA = "SELECT * FROM pbmart_product WHERE product_category_id = '19' AND product_stock !='0'"; 
	}
	$promotion_ids = '1';
?>
<html>
<!DOCTTYPE HTML>
<TITLE>Special Promotions Add On</TITLE>
<BODY>
<div id="main">
<form name="spc_pm_add_on_form" action="wlc_prm_prcss.php" method="post">
	<table border='0'>
		<tr>
			<td>
				<strong><font size=5 color='black'>Products</font></strong>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td valign='top'>
				<table border='0' valign='center' style="border-collapse: collapse;">
					<tr>
						<td valign='top' colspan='2'>
							<table border='0' valign='center'>
								<?php
									$prd_count = '1';
									$iCount = '0';
									$iRow = '0';
									$rs_promoA = @mysql_query($sql_promoA);
									$total_products = @mysql_num_rows($rs_promoA);
									while($rw_promoA = mysql_fetch_array($rs_promoA))
									{
										$product_id = $rw_promoA['product_id'];
										$product_name = $rw_promoA['product_name'];
										$product_price = $rw_promoA['product_price'];
										$product_image = $rw_promoA['product_image'];

										if($c_pages >= cal_pg($pg, $product_row, $product_col) && $c_pages <= $total_products)
										{
											if($count==0)
											{ //echo ('div class start'); ?>
												<tr>			
									  <?php }
													
													if($count >=0 && $count <=5)
													{ //echo $count;
															
														if($count >= 0 && $count <= 2)
														{ $count++; $count2++;?>
																<td>
																	<table border='0' frame='box' width='197px' height='210px'>
																		<tr>
																			<td colspan='2'>
																				<a href="product.php?hyperlink=product&product_id=<?php echo $product_id; ?>" title='<?php echo $product_name; ?>'>
																					<center>
																						<img src="cmanage/product/<?php echo $product_image; ?>" width="135px" height="145px"/>
																					</center>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<input type="radio" name="product_id" value="<?php echo $product_id; ?>" onclick="autoSubmit_A()" <?php if($product_id == $prd_id){ echo "checked"; } ?>></input>
																			</td>
																			<td>
																				<font color='black'>
																					<B>
																						<?php echo $product_name.' <B>RM<font size="5">'.$product_price.'</font></B>'; ?>
																					</B>
																				</font>
																			</td>
																		
																		</tr>
																	</table>
																</td>
												  <?php }else
														{ //echo ('div end called');?>
																<td>
																	<table border='1' frame='box' width='197px' height='210px'>
																		<tr>
																			<td colspan='2'>
																				<a href="product.php?hyperlink=product&product_id=<?php echo $product_id; ?>" title='<?php echo $product_name; ?>' target="_blank	">
																					<center>
																						<img src="cmanage/product/<?php echo $product_image; ?>" width="135px" height="145px"/>
																					</center>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<input type="radio" name="product_id" value="<?php echo $product_id; ?>" onclick="autoSubmit_A()" <?php if($product_id == $prd_id){ echo "checked"; } ?>></input>
																			</td>
																			<td>
																				<font color='black'>
																					<B>
																						<?php echo $product_name.' <B>RM<font size="5">'.$product_price.'</font></B>'; ?>
																					</B>
																				</font>
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
								<?php	}else {$c_pages; $c_pages++; } ?>	
							  <?php
									$prd_count++;
									} ?>
							</table>
						</td>
					</tr>
				
					<tr>
						<td colspan='2' align='right'>
						<BR/>
						<hr/>
							<input type="submit" value="ADD TO CART"></input>
						</td>
					</tr>
				</form>
				</table>
			</td>
		</tr>
	</table>
 </div> 
</body>
</html>