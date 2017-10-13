<?php
	//include('header.php');
	require_once("connection/pbmartconnection.php");
	require_once('products_function.php');
	
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
	
	if(isset($_POST['btnRd_prev_product']))
	{
		$btnRd_prev_product = $_POST['btnRd_prev_product'];
	}else
	{
		$btnRd_prev_product = "";
	}
	
	if($product_id !="" && $btnRd_product =="")
	{
		$product_id = "";
	}
	
	if($btnRd_prev_product != $btnRd_product)
	{
		$product_id = "";
	}
	
	//echo "step 1:".$btnRd_product.'<BR/>';
	//echo "Prev_id: ".$btnRd_prev_product."<BR/>";
	//echo "step 2: ".$product_id.'<BR/>';
	
	if($btnRd_product == '0')
	{
		$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '1' AND promotion_show = '1' AND promotion_package_stock !='0'";
	}else
	{
		$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '1' AND promotion_show = '0' AND promotion_package_stock !='0'";
	}
	$promotion_ids = '1';
?>
<html>
<!DOCTTYPE HTML>
<script>
function autoSubmit_A() {
	var formObject_prmA = document.forms['promotionA_form'];
		formObject_prmA.submit();
	}
</script>
<TITLE>PBMart Home Page</TITLE>
<BODY>
<div id="main">
<form name="promotionA_form" action="index.php" method="post">
	<h1>Promotion A</h1>
	<table border='0' width="700px">
		<tr>
			<td valign='top'>
				<table border='1' style="border-color:black" width="60%" valign='center'>
					<tr>
						<td align='center' colspan='2'><b>PROMOTION A (DOMESTIC)</b></td>
					</tr>
					
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
								<input type="radio" name="btnRd_product" value="1" <?php if($btnRd_product == '1'){echo "checked"; } ?> onclick="autoSubmit_A()">
									SELF PICK UP 
									&nbsp;&nbsp;&nbsp;&nbsp;REFILL GAS 14KG
									&nbsp;&nbsp;&nbsp;&nbsp;AT SPB RM26.60
								</input>
								<input type="hidden" name="btnRd_prev_product" value="<?php echo $btnRd_product; ?>"></input>
							<BR/>
							<center><font size='3' color='black'><strong></strong></font></center>
						</td>
						<BR>
						
						<td valign='top'>
							<table border='0' width='550px' valign='center'>
								<?php 
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
																				<input type="radio" name="product_id" value="<?php echo $promotion_id; ?>" onclick="autoSubmit_A()" <?php if($promotion_id == $product_id){ echo "checked"; } ?>></input>
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
																				<input type="radio" name="product_id" value="<?php echo $promotion_id; ?>" onclick="autoSubmit_A()" <?php if($promotion_id == $product_id){ echo "checked"; } ?>></input>
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
									} ?>
							</table>
						</td>
					</tr>
</form>
				<form name="prmA" action="product_validate.php?act=add&id=1&product_category=Promotion&product_qty=1&hyperlink=index" method="post">
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
							<input type="hidden" name="btnRd_product" value="<?php echo $btnRd_product; ?>"></input>
							<input type="hidden" name="product_id" value="<?php echo "PKG_".$product_id; ?>"></input>
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