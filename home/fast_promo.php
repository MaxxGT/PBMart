<?php
	//include('header.php');
	require_once("connection/pbmartconnection.php");
	require_once('function/products_function.php');
	
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
	if(isset($_POST['product_id']))
	{
		$product_id = $_POST['product_id'];
	}else
	{
		$product_id = "";
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
		$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '1' AND promotion_show = '1' AND promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
	}else if($btnRd_product == '1')
	{
		$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '1' AND promotion_show = '0' AND promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
	}else
	{
		$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '1' AND promotion_show = '1' AND promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
	}
	$promotion_ids = '1';
?>
<html>
<!DOCTTYPE HTML>
<TITLE>PBMart Home Page</TITLE>
<BODY>
<div id="main">
<form name="promotionA_form" action="promoA_prcss.php" method="post">
	<h1></h1>
	<table border='0' width="700px">
		<tr>
			<td valign='top'>
				<table border='1' width="60%" valign='center' style="border-collapse: collapse;">
					<tr>
						<td align='center' width='40px'><b>Step 1</b></td>
						<td align='center'><b>Step 2</b></td>
					</tr>
					<tr>
						<td width='100px'>
							<img src="cmanage/product/photo/special.jpg"></img>
							<BR/>
								<center>
								<input type="radio" name="btnRd_product" value="0" <?php if($btnRd_product == '0'){echo "checked"; } ?> onclick="autoSubmit_A()">
								MYGAZ LPG 14KG (REFILL)<BR/>
								RM26.60 + <BR/>OTHERS RM3.40
								</center>
								</input>
								<BR/>
								&nbsp;&nbsp;
								<input type="hidden" name="btnRd_prev_product" value="<?php echo $btnRd_product; ?>"></input>
							<BR/>
							<center><font size='3' color='black'><strong></strong></font></center>
						</td>
						<BR>
						
						<td valign='top'>
							<table border='0' width='550px' valign='center'>
								<?php
									$prd_count = '1';
									$iCount = '0';
									$iRow = '0';
									$rs_promoA = @mysql_query($sql_promoA);
									$total_products = @mysql_num_rows($rs_promoA);
									while($rw_promoA = mysql_fetch_array($rs_promoA))
									{
										$promotion_id = $rw_promoA['promotion_id'];
										$promotion_item_name = $rw_promoA['promotion_item_name'];
										$promotion_item_photo = $rw_promoA['promotion_item_photo'];

										if($c_pages >= cal_pg($pg, $product_row, $product_col) && $c_pages <= $total_products)
										{
											if($count==0)
											{ //echo ('div class start'); ?>
												<tr>			
									  <?php }
													
													if($count >=0 && $count <=3)
													{ //echo $count;
															
														if($count >= 0 && $count <= 2)
														{ $count++; $count2++; ?>
																<td>
																	<table border='0' width='137px'>
																		<tr>
																			<td colspan='2'>
																				<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>" title='<?php echo $promotion_item_name; ?>'>
																					<center>
																						<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="75px" height="75px"/>
																					</center>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<input type="radio" name="product_id" value="<?php echo $prd_count; ?>" onclick="autoSubmit_A()" <?php if($promotion_id == $product_id){ echo "checked"; } ?>></input>
																			</td>
																			<td>
																				<?php echo $promotion_item_name; ?>
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
																				<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>" title='<?php echo $promotion_item_name; ?>' target="_blank	">
																					<center>
																						<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="75px" height="75px"/>
																					</center>
																				</a>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<input type="radio" name="product_id" value="<?php echo $prd_count; ?>" onclick="autoSubmit_A()" <?php if($promotion_id == $product_id){ echo "checked"; } ?>></input>
																			</td>
																			<td>
																				<?php echo $promotion_item_name; ?>
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
							
							<?php
								//a small function use to check either product is selected and show view chart on specify products
								if(isset($_SESSION['order_qty']) && $_SESSION['order_qty'] !='0')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							?>
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