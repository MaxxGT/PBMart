<?php
// Author: VOONG TZE HOWE
// Date Writen: 11-10-2014
// Description : product content
// Last Modification: 18-10-2014

require_once("connection/pbmartconnection.php");
require_once('products_function.php');
get_UsrInfo();
GLOBAL $member_commercial_status;

$count = 0;
$count2 = 0;
$count3 = 0;
$c_pages = 1;

$product_row = 50;
$product_col = 3;

if(isset($_GET['pg']))
{
	$pg = $_GET['pg'];
}else
{
	$pg = 1;
}

//check for product categories and keyword
if(isset($_POST['product_categories']))
{
	$product_categories = mysql_real_escape_string(strip_tags(trim($_POST['product_categories'])));
}else
{
	$product_categories ="";
}

//check for keyword
if(isset($_POST['keyword']))
{
	$keyword = mysql_real_escape_string(strip_tags(trim($_POST['keyword'])));
}else
{
	$keyword = "";
}
//$db_points = "<B><font color='#8B0000' size='2'>DOUBLE POINTS</font></p></B>";
$db_points = "<BR/>";
?>
<!--Products Line  -->
	<h1> Our Products </h1> <br /> <br />
		<?php include('page_navigate.php'); ?>
		
						<?php
							$filter = "WHERE product_stock !='0' AND product_stock > 0 AND product_category_id !='16' AND product_category_id !='17'";
							if($product_categories != "" && $product_categories == "ALL" && $keyword == "")
							{
								$filter = $filter;
							}else if($product_categories != "" && $product_categories != "ALL" && $keyword == "")
							{
								$filter = $filter." AND product_category = '$product_categories'";
							}else if($product_categories != "" && $product_categories == "ALL" && $keyword != "")
							{
								$filter = $filter." AND product_name LIKE '%$keyword%'";
							}else if($product_categories != "" && $product_categories != "ALL" && $keyword != "")
							{
								$filter = $filter." AND product_category = '$product_categories' AND product_name LIKE '%$keyword%'";
							}else
							{
								$filter = $filter;
							}
							
						$sql_product = "SELECT * FROM pbmart_product $filter";
						$rs = mysql_query($sql_product, $link);
						$total_products = mysql_num_rows($rs);
						while($rw = mysql_fetch_array($rs))
						{
								$product_id = $rw['product_id'];
								$product_category_id = $rw['product_category_id'];
								$product_category = $rw['product_category'];
								$product_name = $rw['product_name'];
								$product_model = $rw['product_model'];
								$product_description = $rw['product_description'];
								$product_price = $rw['product_price'];
								$product_commercial_price = $rw['product_commercial_price'];
								$product_commercial_price2 = $rw['product_commercial_price2'];
								
								$product_handling = $rw['product_handling'];
								$product_handling_show = $rw['product_handling_show'];
								
								$product_commercial_handling = $rw['product_commercial_handling'];
								$product_commercial_handling_show = $rw['product_commercial_handling_show'];
								
								$product_commercial_handling2 = $rw['product_commercial_handling2'];
								$product_commercial_handling_show2 = $rw['product_commercial_handling_show2'];
								
								if($member_commercial_status =='0')
								{
									$total_product_price = $product_price + $product_handling;
								}else if($member_commercial_status =='1')	
								{
									if($member_commercial_class == '1')
									{
										$total_product_price = $product_commercial_price + $product_commercial_handling;
									}else if($member_commercial_class == '2')
									{
										$total_product_price = $product_commercial_price2 + $product_commercial_handling2;
									}else
									{
										$total_product_price = $product_commercial_price + $product_commercial_handling;
									}
								}else
								{
									$total_product_price = $product_price + $product_handling;
								}
								
								
								$product_point = $rw['product_point'];
								$product_double_point = $rw['product_double_point'];
								
								//$product_sale_percentage = $rw['product_sale_percentage'];
								$product_sale_percentage1 = $rw['product_sale_percentage1'];
								$product_sale_percentage2 = $rw['product_sale_percentage2'];
								$product_sale_percentage3 = $rw['product_sale_percentage3'];
								$product_path = $rw['product_image'];
								$product_alt = $rw['product_alt'];
								
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
											{ $count++; $count2++; ?>
												<li><a href="product.php?hyperlink=product&product_id=<?php echo $product_id; ?>" style="text-decoration: none">
													<img src="cmanage/product/<?php echo $product_path; ?>" border='1' alt="" title="<?php echo $product_alt; ?>" width="231px" height="193px"></img></a>
                                                                                                
													<div class="product-info">
                                                                                                                
														<h3><?php if(strlen($product_name) < 30)
																	{
																		echo $product_name.'<BR/><BR/>';
																	}else
																	{
																		echo $product_name;
																	} ?></h3>
														<div class="product-desc">
															
																<table border='0' width='230px' height='110px' style="margin-top:-10px; margin-left:-10px;">
																	<tr>
																		<td height='40px' valign='top'><font size='3' color='black'><B><?php echo $product_model; ?></B></font></td>
																	</tr>
																	<tr>
																		<td height='34px' valign='top'>
																			<div valign='top'>
																			<strong class="price">
																				<?php 
																				if($member_commercial_status=='0')
																				{
																					if($product_handling_show=='1')	
																					{
																						echo ('RM'.number_format($product_price,2));
																						echo "<BR/><font size='2'>+ OTHERS RM";
																						echo number_format($product_handling,2);
																						echo "</font>";
																					}else
																					{
																						echo('RM'.number_format($total_product_price,2));
																						//echo "<BR/><BR/>";
																					}
																				}else if($member_commercial_status=='1')
																				{
																					if($member_commercial_class == '1')
																					{
																						if($product_commercial_handling_show=='1')	
																						{
																							echo ('RM'.number_format($product_commercial_price,2));
																							echo "<BR/><font size='2'>+ OTHERS RM";
																							echo number_format($product_commercial_handling, 2);
																							echo "</font>";
																						}else
																						{
																							echo('RM'.number_format($total_product_price,2));
																							//echo "<BR/><BR/>";
																						}
																					}else if($member_commercial_class == '2')
																					{
																						if($product_commercial_handling_show2=='1')	
																						{
																							echo ('RM'.number_format($product_commercial_price2,2));
																							echo "<BR/><font size='2'>+ OTHERS RM";
																							echo number_format($product_commercial_handling2, 2);
																							echo "</font>";
																						}else
																						{
																							echo('RM'.number_format($total_product_price,2));
																							//echo "<BR/><BR/>";
																						}
																					}else
																					{
																						if($product_commercial_handling_show=='1')	
																						{
																							echo ('RM'.number_format($product_commercial_price,2));
																							echo "<BR/><font size='2'>+ OTHERS RM";
																							echo number_format($product_commercial_handling, 2);
																							echo "</font>";
																						}else
																						{
																							echo('RM'.number_format($total_product_price,2));
																							//echo "<BR/><BR/>";
																						}
																					}
																				}else
																				{
																					if($product_handling_show=='1')	
																					{
																						echo ('RM'.number_format($product_price,2));
																						echo "<BR/><font size='2'>+ OTHERS RM";
																						echo number_format($product_handling,2);
																						echo "</font>";
																					}else
																					{
																						echo('RM'.number_format($total_product_price,2));
																						//echo "<BR/><BR/>";
																					}
																				}	
																				?>
																			</strong>
																			</div>
																		</td>
																	</tr>
																	<tr>	
																		<td>
																			<a class='button' href="product_validate.php?act=add&product_id=<?php echo $product_id; ?>&product_category_id=<?php echo $product_category_id; ?>&product_category=<?php echo $product_category; ?>&product_qty=1&hyperlink=product"><span style='font-size:15px;color:#FFFFFF;'> ADD TO CART</span></a>
																		</td>
																	</tr>
																</table>
														</div>	
															<?php
																//a small function use to check either product is selected and show view chart on specify products
																if(isset($_SESSION['order_qty']))
																{
																	for($prds_value='0'; $prds_value < $_SESSION['order_qty']; $prds_value++)
																	{
																		if($product_id == $_SESSION['product_id'][$prds_value])
																		{
																			echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
																		}
																	}
																}
															?>
															
													</div>
												</li>
									  <?php }else
											{ //echo ('div end called');?>				
												<li class="last"><a href="product.php?hyperlink=product&product_id=<?php echo $product_id; ?>" style="text-decoration: none">
                                                    <img src="cmanage/product/<?php echo $product_path; ?>" alt="" title="<?php echo $product_alt; ?>" width="231px" height="193px"></img></a>
												<div class="product-info">
													
														<h3><?php 
																	if(strlen($product_name) < 30)
																	{
																		echo $product_name.'<BR/><BR/>';
																	}else
																	{
																		echo $product_name;
																	}
														 ?></h3>
														<div class="product-desc">
															
															<table border='0' width='230px' height='110px' style="margin-top:-10px; margin-left:-10px;">	
																<tr>
																	<td height='40px' valign='top'>
																		<p><?php echo $product_model;
																		?></p>
																	</td>
																</tr>
																<tr>
																	<td height='34px' valign='top'>
																		<strong class="price">
																		<?php 
																			
																			if($member_commercial_status=='0')
																			{
																				if($product_handling_show=='1')	
																				{
																					echo ('RM'.number_format($product_price,2));
																					echo "<BR/><font size='2'>+ OTHERS RM";
																					echo number_format($product_handling,2);
																					echo "</font>";
																				}else
																				{
																					echo('RM'.number_format($total_product_price,2));
																					//echo "<BR/><BR/>";
																				}
																			}else if($member_commercial_status=='1')
																			{
																				
																				if($member_commercial_class == '1')
																								{
																									if($product_commercial_handling_show=='1')	
																									{
																										echo ('RM'.number_format($product_commercial_price,2));
																										echo "<BR/><font size='2'>+ OTHERS RM";
																										echo number_format($product_commercial_handling, 2);
																										echo "</font>";
																									}else
																									{
																										echo('RM'.number_format($total_product_price,2));
																										//echo "<BR/><BR/>";
																									}
																								}else if($member_commercial_class == '2')
																								{
																									if($product_commercial_handling_show2=='1')	
																									{
																										echo ('RM'.number_format($product_commercial_price2,2));
																										echo "<BR/><font size='2'>+ OTHERS RM";
																										echo number_format($product_commercial_handling2, 2);
																										echo "</font>";
																									}else
																									{
																										echo('RM'.number_format($total_product_price,2));
																										//echo "<BR/><BR/>";
																									}
																								}else
																								{
																									if($product_commercial_handling_show=='1')	
																									{
																										echo ('RM'.number_format($product_commercial_price,2));
																										echo "<BR/><font size='2'>+ OTHERS RM";
																										echo number_format($product_commercial_handling, 2);
																										echo "</font>";
																									}else
																									{
																										echo('RM'.number_format($total_product_price,2));
																										//echo "<BR/><BR/>";
																									}
																								}
																			}else
																			{
																				if($product_handling_show=='1')	
																				{
																					echo ('RM'.number_format($product_price,2));
																					echo "<BR/><font size='2'>+ OTHERS RM";
																					echo number_format($product_handling,2);
																					echo "</font>";
																				}else
																				{
																					echo('RM'.number_format($total_product_price,2));
																					//echo "<BR/><BR/>";
																				}
																			}	
																			?>
																		</strong> 
																	</td>
																</tr>
																<tr>
																	<td>
																		
																			<a class='button' href="product_validate.php?act=add&product_id=<?php echo $product_id; ?>&product_category_id=<?php echo $product_category_id; ?>&product_category=<?php echo $product_category; ?>&product_qty=1&hyperlink=product"><span style='font-size:15px;color:#FFFFFF;'> ADD TO CART</span></a>
																		
																	</td>
																</tr>
															</table>
														</div>	
															<?php
																//a small function use to check either product is selected and show view chart on specify products
																if(isset($_SESSION['order_qty']))
																{
																	for($prds_value2='0'; $prds_value2 < $_SESSION['order_qty']; $prds_value2++)
																	{
																		if($product_id == $_SESSION['product_id'][$prds_value2])
																		{
																			echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
																		}
																	}
																}
															?>
															
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
							 <?php $count=0; } ?>			
								  <?php }
								$count3++;
								if($count3 == ($product_row * $product_col))
								{
									break;
								} ?>
					<?php	}else {$c_pages; $c_pages++; } ?>	
				  <?php
						}
						if(cal($count3) != 0)
						{ ?>
									</ul>
								<div class="cl">&nbsp;</div>
							</div>
					<?php } ?>
<!-- End Products Line -->