<?php
	echo "<center>";
	include("content_slider_promotion.php");
	echo "</center>";
	$current_date = date('Y-m-d');
?>
	<!-- make a small column between the row of product -->
	<table border='0'>
		<tr>
			<td></td>
		</tr>
	</table>
<?php
								$filter=" WHERE promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
								if($promotion_ids !='')
								{
									$filter = $filter. " AND promotion_category_id ='$promotion_ids'";
								}else{
									$filter = $filter;
								}
								$sql_filter = "SELECT * FROM pbmart_promotion $filter AND promotion_show ='1' ORDER BY promotion_package_price";
								
								$sql_promotion = mysql_query($sql_filter);
								$total_products = mysql_num_rows($sql_promotion);
								while($r = mysql_fetch_array($sql_promotion))
								{
									$promotion_id = $r['promotion_id'];
									$promotion_product_name = $r['promotion_product_name'];
									$promotion_product_price = $r['promotion_product_price'];
									$promotion_product_sale = $r['promotion_product_sale'];
													
									$promotion_item_name = $r['promotion_item_name'];
									$promotion_item_photo = $r['promotion_item_photo'];
									$promotion_item_sale = $r['promotion_item_sale'];
									$promotion_package_price = $r['promotion_package_price'];
									$total_price = $promotion_package_price;
									$promotion_package_description = $r['promotion_package_description'];
									
									
									if($c_pages >= cal_pg($pg, $product_row, $product_col) && $c_pages <= $total_products)
									{
										if($count==0)
										{ //echo ('div class start'); ?>
											<div class="products">
												<div class="cl">&nbsp;</div>
													<ul>
								  <?php }
										
										if($count >=0 && $count <=2)
										{ //echo $count;
											if($count >= 0 && $count <= 1)
											{ $count++; $count2++; 
										?>
											<li>
												<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
												<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="200px" height="200px"></img></a>
													<div class="product-info">
														<h3><?php echo $promotion_item_name; ?></h3>
														<div class="product-desc">
															<p>
																<table border='0' width='220px'>
																	<tr>
																		<td><font color='black'><b><?php echo $promotion_product_name; ?> + <BR><?php echo $promotion_item_name; ?></b></font></td>
																	</tr>		
																	<tr>
																		<td>
																		<strong class="price">RM<?php echo $total_price; ?> ONLY</strong>
																		</td>
																	</tr>
																	
																	<tr>
																		<td>
																			<a class='button' href="product_validate.php?act=add&id=<?php echo $promotion_ids; ?>&product_id=PKG_<?php echo $promotion_id; ?>&product_category=Promotion&product_qty=1&hyperlink=promotion"><span style='font-size:15px;color:#FFFFFF;'> ADD TO CART</span></a>
																			
																			<BR/>
																			<?php
																				//a small function use to check either product is selected and show view chart on specify products
																				if(isset($_SESSION['order_qty']))
																				{
																					for($prds_value='0'; $prds_value < $_SESSION['order_qty']; $prds_value++)
																					{
																						if('PKG_'.$promotion_id == $_SESSION['product_id'][$prds_value])
																						{
																							echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
																						}
																					}
																				}
																			?>
																		</td>
																	</tr>
																</table>
															</p>
														
														
														</div>
														
														
													</div>
											</li>
									<?php }else{ ?>
											<li class="last"><a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="200px" height="200px"></img></a>
											<div class="product-info">
												<h3><?php echo $promotion_item_name; ?></h3>
													<div class="product-desc">
														<p>
															<table border='0' width='220px'>
																<tr>
																	<td>
																		<font color='black'><b><?php echo $promotion_product_name; ?> + <BR><?php echo $promotion_item_name; ?></b></font>
																	</td>
																</tr>
																<tr>
																	<td>
																		<strong class="price">RM<?php echo $total_price; ?> ONLY</strong>
																	</td>
																</tr>
																
																<tr>
																	<td>
																		<a class='button' href="product_validate.php?act=add&id=<?php echo $promotion_ids; ?>&product_id=PKG_<?php echo $promotion_id; ?>&product_category=Promotion&product_qty=1&hyperlink=promotion"><span style='font-size:15px;color:#FFFFFF;'> ADD TO CART</span></a>
																		<BR/>
																		<?php
																			//a small function use to check either product is selected and show view chart on specify products
																			if(isset($_SESSION['order_qty']))
																			{
																				for($prds_value2='0'; $prds_value2 < $_SESSION['order_qty']; $prds_value2++)
																				{
																					if('PKG_'.$promotion_id == $_SESSION['product_id'][$prds_value2])
																					{
																						echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
																					}
																				}
																			}
																		?>
																	</td>
																</tr>
															</table>
														</p>
													</div>
													
													
											</div>
											</li>
										</ul>
										<div class="cl">&nbsp;</div>
									</div>
									<!-- make a small column between the row of product -->
									<table border='0'>
										<tr>
											<td></td>
										</tr>
									</table>
									<?php $count=0;} ?>
									<?php }
										$count3++;
										if($count3 == ($product_row * $product_col))
										{
											break;
										}
									?>							
							<?php	}else {$c_pages; $c_pages++; } ?>
									<?php 
								}
											if(cal($count3) != 0)
											{ ?>
											<div class="cl">&nbsp;</div>
										<?php } ?>