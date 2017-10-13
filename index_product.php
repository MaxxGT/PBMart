<?php
//http://forums.asmallorange.com/topic/6493-php-2nd-largest-number-of-an-array/
require_once("connection/pbmartconnection.php");
get_UsrInfo();
GLOBAL $member_commercial_status;
$count = 0;

	$sql_mix_product = "SELECT product_id, product_sale, product_stock FROM pbmart_product WHERE product_stock !='0' AND product_stock > 0";
	$rs_mix_product = @mysql_query($sql_mix_product, $link);
	$arry = array();
	$x_value = 1;
	while($rw_mix_product = @mysql_fetch_array($rs_mix_product))
	{
		$arry[$x_value] = $rw_mix_product['product_id'].'-prd';
		//echo $arry[$x_value].'<br/>';
		$x_value++;
	}
	
	$sql_mix_promotion = "SELECT promotion_id, promotion_package_sale, promotion_package_stock FROM pbmart_promotion WHERE promotion_package_stock != '0' AND promotion_package_stock > 0";
	$rs_mix_promotion = @mysql_query($sql_mix_promotion, $link);
	while($rw_mix_promotion = @mysql_fetch_array($rs_mix_promotion))
	{
		$arry[$x_value] = $rw_mix_promotion['promotion_id'].'-prm';
		//echo $arry[$x_value].'<br/>';
		$x_value++;
	}

	$filter_product = "WHERE product_stock !='0' AND product_stock > 0 AND product_sale !='0'";
	$sql_max = "SELECT product_id, product_sale FROM pbmart_product $filter_product GROUP BY product_sale";
	$rs_max = @mysql_query($sql_max, $link);
	$arr = array();
	$product_id_arr = array();
	$x=1;
	while($rw_max = @mysql_fetch_array($rs_max))
	{
		$product_id_arr[$x] = $rw_max['product_id'];
		$arr[$x] = $rw_max['product_sale'].'-prd';
		//echo $product_id_arr[$x].' '.$arr[$x].'<br>';
		$x++;
	}
	
	$ary_promotion = array();
	$ary_promotion_id = array();
	$promotion_id = array();
	
	$filter_product_promotion ="WHERE promotion_package_stock != '0' AND promotion_package_stock > 0 AND promotion_package_sale !='0'";
	$sql_promotion = "SELECT promotion_id, promotion_package_sale FROM pbmart_promotion $filter_product_promotion GROUP BY promotion_package_sale";
	$rs_promotion = @mysql_query($sql_promotion, $link);
	
	while($rw_promotion = @mysql_fetch_assoc($rs_promotion))
	{
		$promotion_id[$x] = $rw_promotion['promotion_id'];
		$arr[$x] = $rw_promotion['promotion_package_sale'].'-prm';
		//echo $promotion_id[$x].'. '.$arr[$x].'<br>';
		$x++;
	}
	
	$prd_sale = array();
	$prd_sale_id = array();
	$prd_id = array();
	
	for($i=1; $i<7; $i++)
	{
		if(!isset($arr[count($arr) - $i]))
		{	//echo 'Random: ';
			$prd_sale[$i] = $arry[array_rand($arry)];
			//echo $prd_sale[$i].'<br/>';
			
			$prd_sale_list = explode("-",$prd_sale[$i]);
			//echo $prd_sales = $prd_sale_list[0].' '.$prd_sales = $prd_sale_list[1].'<br/>';
			if($prd_sale_list[1] == 'prd')
			{
				$sql_prd_id = "Select product_id, product_sale FROM pbmart_product WHERE product_stock !='0' AND product_stock > 0 AND product_id='$prd_sale_list[0]' GROUP BY product_sale";
				$rs_prd_id = @mysql_query($sql_prd_id, $link);
				$rw_prd_id = @mysql_fetch_array($rs_prd_id);
				$prd_id[$i] = $rw_prd_id['product_id'];
				$prd_sale[$i] = $rw_prd_id['product_sale'].'-prd';
			}else if($prd_sale_list[1] == 'prm')
			{
				$sql_prm_id = "SELECT promotion_id, promotion_package_sale FROM pbmart_promotion WHERE promotion_package_stock != '0' AND promotion_package_stock > 0 AND promotion_id='$prd_sale_list[0]' GROUP BY promotion_package_sale";
				$rs_prm_id = @mysql_query($sql_prm_id, $link);
				$rw_prm_id = @mysql_fetch_array($rs_prm_id);
				$prd_id[$i] = $rw_prm_id['promotion_id'];
				$prd_sale[$i] = $rw_prm_id['promotion_package_sale'].'-prm';
			}
		}else
		{
			//echo 'Specify: ';
			sort($arr, SORT_NUMERIC);
			$prd_sale[$i] = ($arr[count($arr) - $i]);
			//echo ($prd_sale[$i].'<br/>');
			
			$prd_sale_list = explode("-",$prd_sale[$i]);
			//echo $prd_sales = $prd_sale_list[0].' '.$prd_sales = $prd_sale_list[1].'<br/>';
			if($prd_sale_list[1] == 'prd')
			{
				$sql_prd_id = "Select product_id, product_sale FROM pbmart_product $filter_product AND product_sale='$prd_sale[$i]' GROUP BY product_sale";
				$rs_prd_id = @mysql_query($sql_prd_id, $link);
				$rw_prd_id = @mysql_fetch_array($rs_prd_id);
				$prd_id[$i] = $rw_prd_id['product_id'];
			}else if($prd_sale_list[1] == 'prm')
			{
				$sql_prm_id = "SELECT promotion_id, promotion_package_sale FROM pbmart_promotion $filter_product_promotion AND promotion_package_sale='$prd_sale[$i]' GROUP BY promotion_package_sale";
				$rs_prm_id = @mysql_query($sql_prm_id, $link);
				$rw_prm_id = @mysql_fetch_array($rs_prm_id);
				$prd_id[$i] = $rw_prm_id['promotion_id'];
			}
		}
		//echo $prd_id[$i].'. '.$prd_sale[$i].'<br/>';
	}
	//$db_points = "<B><font color='#8B0000' size='2'>X2 MEMBER POINTS</font></p></B>";
	//$db_points = "<img src=\"css/images/double_points2.jpg\" width=\"50px\" height=\"35px\"></img>";
	$db_points = "";
	//exit;
?>

<div class="products">
        <div class="cl">&nbsp;</div>
			<ul>
			  <!-- Retrieve product info from db -->
			<?php
				
			for($num=1; $num<7; $num++)
			{
				if(!isset($arr[count($arr) - $num]))
				{
					//for random product
					$prd_sale_list = explode("-",$prd_sale[$num]);
					if($prd_sale_list[1] =='prd')
					{
						$sql = "SELECT * FROM pbmart_product WHERE product_stock !='0' AND product_stock > 0 AND product_id='$prd_id[$num]'";
						$rs = mysql_query($sql, $link);
						$rw = mysql_fetch_array($rs);
						$product_id = $rw['product_id'];
						$product_id_identify = $product_id;
						$product_category = "GAS";
						$product_name = $rw['product_name'];
						$product_model = $rw['product_model'];
						$product_price = $rw['product_price'];
						$product_commercial_price = $rw['product_commercial_price'];
						$product_handling = $rw['product_handling'];
						$product_commercial_handling = $rw['product_commercial_handling'];
						$product_handling_show = $rw['product_handling_show'];
						$product_commercial_handling_show = $rw['product_commercial_handling_show'];
						$product_double_point = $rw['product_double_point'];
						$product_sale_percentage1 = $rw['product_sale_percentage1'];
						$product_sale_percentage2 = $rw['product_sale_percentage2'];
						$product_sale_percentage3 = $rw['product_sale_percentage3'];	
						$product_image = 'cmanage/product/'.$rw['product_image'];
						$href="product.php?product_id=$product_id";
						$href_button="product_validate.php?act=add&product_id=$product_id&product_category=$product_category&product_qty=1&hyperlink=home";
						
						if($member_commercial_status == '1')
						{
							$display_product_price = $product_commercial_price;
							$total_product_price = $product_commercial_price + $product_commercial_handling;
						}else
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}
					}else
					{
						$sql_promotions = "SELECT * FROM pbmart_promotion WHERE promotion_package_stock != '0' AND promotion_package_stock > 0 AND promotion_id='$prd_id[$num]'";
						$rs_promotions = mysql_query($sql_promotions, $link);
						$rw_promotions = mysql_fetch_array($rs_promotions);
						$product_id = $rw_promotions['promotion_id'];
						$product_id_identify = "PKG_".$product_id;
						$product_category = $rw_promotions['promotion_category_name'];
						$promotion_category_name = $rw_promotions['promotion_category_name'];
						$prm_cty_nm = explode(" ", $promotion_category_name);
						$product_name = 'Promo '.$prm_cty_nm[1].' '.$rw_promotions['promotion_item_name'];
						$product_model = $rw_promotions['promotion_item_model'];
						$product_price = $rw_promotions['promotion_package_price'];
						$product_handling = '0';
						
						$product_handling_show = '0';
						$product_commercial_handling_show = '0';
						$product_double_point = $rw_promotions['promotion_package_point'];
						$product_sale_percentage1 = '0';
						$product_sale_percentage2 = '0';
						$product_sale_percentage3 = '0';	
						$product_image = 'cmanage/promotion/'.$rw_promotions['promotion_item_photo'];
						$href="promotion.php?prd_id=$product_id";
						$href_button="product_validate.php?act=add&id=1&product_id=PKG_$product_id&product_category=Promotion&product_qty=1&hyperlink=home";
						
						if($member_commercial_status == '1')
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}else
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}
						
					}
				}else
				{
					//for specify product
					$prd_sale_list = explode("-",$prd_sale[$num]);
					if($prd_sale_list[1] =='prd')
					{
						$sql = "SELECT * FROM pbmart_product $filter_product AND product_id='$prd_id[$num]'";
						$rs = mysql_query($sql, $link);
						$rw = mysql_fetch_array($rs);
						$product_id = $rw['product_id'];
						$product_id_identify = $product_id;
						$product_category = "GAS";
						$product_name = $rw['product_name'];
						$product_model = $rw['product_model'];
						$product_price = $rw['product_price'];
						$product_commercial_price = $rw['product_commercial_price'];
						$product_handling = $rw['product_handling'];
						$product_commercial_handling = $rw['product_commercial_handling'];
						$product_handling_show = $rw['product_handling_show'];
						$product_commercial_handling_show = $rw['product_commercial_handling_show'];
						$product_double_point = $rw['product_double_point'];
						$product_sale_percentage1 = $rw['product_sale_percentage1'];
						$product_sale_percentage2 = $rw['product_sale_percentage2'];
						$product_sale_percentage3 = $rw['product_sale_percentage3'];	
						$product_image = 'cmanage/product/'.$rw['product_image'];
						$href="product.php?product_id=$product_id";
						$href_button="product_validate.php?act=add&product_id=$product_id&product_category=$product_category&product_qty=1&hyperlink=home";
						
						if($member_commercial_status == '0')
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}else if($member_commercial_status =='1')
						{
							$display_product_price = $product_commercial_price;
							$total_product_price = $product_commercial_price + $product_commercial_handling;
						}else
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}
					}else
					{
						$sql_promotions = "SELECT * FROM pbmart_promotion $filter_product_promotion AND promotion_id='$prd_id[$num]'";
						$rs_promotions = mysql_query($sql_promotions, $link);
						$rw_promotions = mysql_fetch_array($rs_promotions);
						$product_id = $rw_promotions['promotion_id'];
						$product_id_identify = "PKG_".$product_id;
						$product_category = $rw_promotions['promotion_category_name'];
						$promotion_category_name = $rw_promotions['promotion_category_name'];
						$prm_cty_nm = explode(" ", $promotion_category_name);
						$product_name = 'Promo '.$prm_cty_nm[1].' '.$rw_promotions['promotion_item_name'];
						$product_model = $rw_promotions['promotion_item_model'];
						$product_price = $rw_promotions['promotion_package_price'];
						$product_handling = '0';
						
						$product_handling_show = '0';
						$product_commercial_handling_show = '0';
						$product_double_point = $rw_promotions['promotion_package_point'];
						$product_sale_percentage1 = '0';
						$product_sale_percentage2 = '0';
						$product_sale_percentage3 = '0';	
						$product_image = 'cmanage/promotion/'.$rw_promotions['promotion_item_photo'];
						$href="promotion.php?prd_id=$product_id";
						$href_button="product_validate.php?act=add&id=1&product_id=PKG_$product_id&product_category=Promotion&product_qty=1&hyperlink=home";
						
						if($member_commercial_status == '1')
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}else
						{
							$display_product_price = $product_price;
							$total_product_price = $product_price + $product_handling;
						}
					}
				}
						//echo $count;
						if($count >=0 && $count <=3)
						{ 
							if($count >= 0 && $count <= 1)
							{ $count++; ?>
						
								<li>
									<a href="<?php echo $href; ?>" style="text-decoration: none">
								<?php
									if($product_sale_percentage1 !='0' OR $product_sale_percentage2 != '0' OR $product_sale_percentage3 != '0')
									{?>
										<!--echo "<p style='width:50px;text-align:center; font-size:12px;background-color:#FFFF00;color:#000000;'>Sale</p>";-->
										<img src="css/images/sale.png" width="50px" height="35px"></img>
									<?php }else{
										echo "";
									}
									if($product_double_point =='1')
									{
										echo $db_points;
									}else{
										echo "<BR/>";
									} ?>
									<img src="<?php echo $product_image; ?>" width="232px" height="195px" alt="" /></a>
					  <?php }else{ ?>
					  
									<li class="last"><a href="<?php echo $href; ?>" style="text-decoration: none">
								
								<?php
									if($product_sale_percentage1 !='0' OR $product_sale_percentage2 != '0' OR $product_sale_percentage3 != '0')
									{?>
										<!--echo "<p style='width:50px;text-align:center; font-size:12px;background-color:#FFFF00;color:#000000;'>Sale</p>";-->
										<img src="css/images/sale.png" width="50px" height="35px"></img>
									<?php }else{
										echo "";
									}
									if($product_double_point =='1')
									{
										echo $db_points;
									}else{
										echo "<BR/>";
									}
								?>
								
								<img src="<?php echo $product_image; ?>" width="232px" height="195px" alt="" /></a>
						   <?php $count=0;} ?>
									<div class="product-info">
										<h3><?php echo $product_name; ?></h3>
										<div class="product-desc">
											<p><?php echo $product_model; ?></p>
											<strong class="price">
												<?php
												if($member_commercial_status == '0')
												{
													if($product_handling_show == '1')
													{
														echo('RM'.number_format($display_product_price,2));
														echo "<BR/><font size='2'>+ OTHERS RM";
														echo number_format($product_handling,2);
														echo "</font>";
													}else
													{
														echo('RM'.number_format($total_product_price,2));
														echo "<BR/><BR/>";
													}
												}else if($member_commercial_status == '1')
												{
													if($product_commercial_handling_show == '1')
													{
														echo('RM'.number_format($display_product_price,2));
														echo "<BR/><font size='2'>+ OTHERS RM";
														echo number_format($product_commercial_handling,2);
														echo "</font>";
													}else
													{
														echo('RM'.number_format($total_product_price,2));
														echo "<BR/><BR/>";
													}
												}else
												{
													if($product_handling_show == '1')
													{
														echo('RM'.number_format($display_product_price,2));
														echo "<BR/><font size='2'>+ OTHERS RM";
														echo number_format($product_handling,2);
														echo "</font>";
													}else
													{
														echo('RM'.number_format($total_product_price,2));
														echo "<BR/><BR/>";
													}
												}
												?>
											</strong>
											<a class='button' href="<?php echo $href_button; ?>"><span style='font-size:15px;color:#FFFFFF;'> ADD TO CART</span></a>
										</div>
										
											<?php
												//a small function use to check either product is selected and show view chart on specify products
												if(isset($_SESSION['order_qty']))
												{
													for($idx_value='0'; $idx_value<$_SESSION['order_qty']; $idx_value++)
													{
														//echo $product_id.' '.$_SESSION['product_id'][$idx_value];
														if(strpos($_SESSION['product_id'][$idx_value], 'PKG_') !== FALSE)
														{
															if($product_id_identify == $_SESSION['product_id'][$idx_value])
															{
																echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
															}
														}else
														{
															if($product_id_identify == $_SESSION['product_id'][$idx_value])
															{
																echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
															}
														}
													}
												}
											?>
									</div>
									<BR/>
								</li>	
				  <?php } ?>
			<?php } ?>
			</ul>		
	<div class="cl">&nbsp;</div>
</div>
<!-- make a small column between the row of product -->
<table border='0'>
	<tr>
		<td></td>
	</tr>
</table>