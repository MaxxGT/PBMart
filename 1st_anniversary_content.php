<?php
	require_once("connection/pbmartconnection.php");
	require_once('products_function.php');
	
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
	
	if(isset($_POST['product_categories']))
	{
		$product_categories = $_POST['product_categories'];
	}else
	{
		$product_categories = "";
	}
	
	if(isset($_GET['id']))
	{
		$product_category_id = $_GET['id'];
	}else
	{
		$product_category_id = "";
	}
	
	$sql_promoA = "SELECT * FROM pbmart_product WHERE product_category_id = '$product_category_id' AND product_stock !='0'"; 
?>
<html>
<!DOCTTYPE HTML>
<TITLE>Tupperware Promotion Add On</TITLE>
<BODY>
<div id="main">
<form name="1st_anniversary_add_on_form" action="1st_anniversary_prcss.php" method="post">
	<table border='0' width='870px'>
		<tr>
			<td>
				<strong><font size=5 color='black'>PBMART 1st Anniversary Free Gift</font></strong>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td valign='top'>
				<table border='0' width='93%' valign='center' style="border-collapse: collapse;">
					<tr>
						<td valign='top' colspan='2'>
							<table border='0' valign='center'>
								<?php
									$prd_count = '1';
									$iCount = '0';
									$iRow = '0';
									$rs_promoA = @mysql_query($sql_promoA);
									$total_products = @mysql_num_rows($rs_promoA);
									while($rw_promoC = mysql_fetch_array($rs_promoA))
									{
										$product_id = $rw_promoC['product_id'];
										$product_name = $rw_promoC['product_name'];
										$product_price = $rw_promoC['product_price'];
										$product_image = $rw_promoC['product_image'];

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
																				
																					<center>
																						<img src="cmanage/product/<?php echo $product_image; ?>" width="135px" height="145px" title="<?php echo $product_name; ?>" />
																					</center>
																				
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<input type="radio" name="product_id" value="<?php echo $product_id; ?>" onclick="autoSubmit_A()" <?php if($product_id == $prd_id){ echo "checked"; } ?>></input>
																			</td>
																			<td>
																				<font color='black'>
																					<B>
																						<?php echo $product_name; ?>
																					</B>
																				</font>
																			</td>
																		
																		</tr>
																	</table>
																</td>
												  <?php }else
														{ //echo ('div end called');?>
																<td>
																	<table border='0' frame='box' width='197px' height='210px'>
																		<tr>
																			<td colspan='2'>
																				<center>
																					<img src="cmanage/product/<?php echo $product_image; ?>" width="135px" height="145px" title="<?php echo $product_name; ?>" />
																				</center>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<input type="radio" name="product_id" value="<?php echo $product_id; ?>" onclick="autoSubmit_A()" <?php if($product_id == $prd_id){ echo "checked"; } ?>></input>
																			</td>
																			<td>
																				<font color='black'>
																					<B>
																						<?php echo $product_name.' <B>WORTH RM<font size="5">'.$product_price.'</font></B>'; ?>
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