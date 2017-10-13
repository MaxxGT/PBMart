<?php
// Author:VOONG TZE HOWE
// Date Writen: 02-11-2014
// Description : redemption content
// Last Modification:

require_once("connection/pbmartconnection.php");
require_once('products_function.php');
require_once('redemption_function.php');

if(isset($_SESSION['usr_name']))
{
	get_UsrInfo();
}else
{
	$member_id = '0';
}
$count = 0;
$count2 = 0;
$count3 = 0;
$c_pages = 1;

$product_row = 2;
$product_col = 3;
if(isset($_GET['pg']))
{
	$pg = mysql_real_escape_string(strip_tags(trim($_GET['pg'])));
}else
{
	$pg = 1;
}

$product_categories = (isset($_POST['product_categories']) ? mysql_real_escape_string(strip_tags(trim($_POST['product_categories']))) : '');
$Keyword = (isset($_POST['Keyword']) ? mysql_real_escape_string(strip_tags(trim($_POST['Keyword']))) : '');


$class = (isset($_REQUEST['id']) ? mysql_real_escape_string(strip_tags(trim($_REQUEST['id']))) : '1');
//$redeem_class = (isset($_REQUEST['redeem_class']) ? $_REQUEST['redeem_class'] : 'normal');
if(isset($class) && isset($redeem_class))
{
	if($class == '1')
	{
		$redeem_class = 'normal';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else if($class == '2')
	{
		$redeem_class = 'royal';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else if($class == '3')
	{
		$redeem_class = 'Tupperware';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else if($class == '4')
	{
		if(commercial_user($member_id) == '1')
		{
			$redeem_class = 'Commercial';
			$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
		}else
		{
			$redeem_class = 'normal';
			$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
		}
	}else if($class =='5')
	{
		$redeem_class = 'Token';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else if($class =='6')
	{
		$redeem_class = 'Faber';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else
	{
		$redeem_class = 'normal';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}
}

//count for royal

$sql_royal_count = mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_class ='royal'");
$royal_count = @mysql_num_rows($sql_royal_count);

if(isset($_GET['id']) && $_GET['id'] == '1')
{
	$activate = "active_redemption";
}else
{
	$activate = "btns";
}

if(isset($_GET['id']) && $_GET['id'] == '3')
{
	$activate1 = "active_redemption";
}else
{
	$activate1 = "btns2";
}

if(isset($_GET['id']) && $_GET['id'] == '2')
{
	$activate2 = "active_redemption";
}else
{
	$activate2 = "btns";
}

if(isset($_GET['id']) && $_GET['id'] == '4')
{
	$activate3 = "active_redemption";
}else
{
	$activate3 = "btns2";
}

if(isset($_GET['id']) && $_GET['id'] == '5')
{
	$activate4 = "active_redemption";
}else
{
	$activate4 = "btns";
}

if(isset($_GET['id']) && $_GET['id'] == '6')
{
	$activate5 = "active_redemption";
}else
{
	$activate5 = "btns";
}

if(empty($_GET['id']))
{
	$activate = "active_redemption";
}
?>

<link rel="stylesheet" type="text/css" href="css/redemption/redemption.css">
<!-- <script type="text/javascript" src="jscss/lib.js"></script> -->
<script type="text/javascript" src="jscss/facebox.js"></script>
<script type="text/javascript" src="jscss/val.js"></script>
<script type="text/javascript" src="jscss/dtp.js"></script>
<link rel="stylesheet" type="text/css" href="jscss/slimbox_ex.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscss/data.css" media="screen" />

<!--Products Line  -->
	<h1> Redemption Product </h1> <br />
					<table border='0' width='200px'>
						<tr>
							<td width='50px'><strong><font size='3'>Class: </font></strong></td>
							<td>
								<input type="button" class="<?php echo $activate; ?>" value="Normal" onclick="location.href='redemption.php?id=1&hyperlink=redemption'"></input>
							</td>
							
							<?php
								
								if(commercial_user($member_id) == '1')
								{ ?>
									<td>
										<td>
											<input type="button" class="<?php echo $activate1; ?>" value="Tupperware" onclick="location.href='redemption.php?id=3&hyperlink=redemption'"></input>
										</td>
									</td>
								<?php }
							 ?>
							
							<td width='60px'>
								<?php
									if($royal_count !='0')
									{ ?>
										<input type="button" class="<?php echo $activate2; ?>" value="Royal" onclick="location.href='redemption.php?id=2&hyperlink=redemption'"></input>
							<?php	} ?>
							</td>
							
							
							<td width='60px'>	
								<input type="button" class="<?php echo $activate4; ?>" value="Token" onclick="location.href='redemption.php?id=5&hyperlink=redemption'"></input>
							</td>
							
							<td width='60px'>	
								<input type="button" class="<?php echo $activate5; ?>" value="Product" onclick="location.href='redemption.php?id=6&hyperlink=redemption'"></input>
							</td>
							
						<?php
						if(isset($_SESSION['usr_name']))
						{	
							if(commercial_user($member_id) == '1')
							{ ?>	
								<td>
									<td>
										<input type="button" class="<?php echo $activate3; ?>" value="Commercial" onclick="location.href='redemption.php?id=4&hyperlink=redemption'"></input>
									</td>
								</td>
					  <?php }
						}
					  ?>
					  
						</tr>
					</table>
					
						<?php
						
							if($product_categories != "" && $product_categories == "ALL" && $keyword == "")
							{
								$filter.="";
							}else if($product_categories != "" && $product_categories != "ALL" && $keyword == "")
							{
								$filter.= " AND redeem_category = '$product_categories'";
							}else if($product_categories != "" && $product_categories == "ALL" && $keyword != "")
							{
								$filter.= " AND redeem_name LIKE '%$keyword%'";
							}else if($product_categories != "" && $product_categories != "ALL" && $keyword != "")
							{
								$filter.= " AND redeem_category = '$product_categories' AND redeem_name LIKE '%$keyword%'";
							}else
							{
								$filter.="";
							}
							
						
						
						if($member_commercial_status == '0')
						{
							$sql_products = "SELECT * FROM pbmart_redeem $filter ORDER BY redeem_id DESC";	
						}else
						{
							$sql_products = "SELECT * FROM pbmart_redeem $filter AND redeem_category_id !='14' ORDER BY redeem_id DESC";	
						}
						
						$rs = mysql_query($sql_products, $link);
						$total_products = mysql_num_rows($rs);
						while($rw = mysql_fetch_array($rs))
						{
								$redeem_id = $rw['redeem_id'];
								$redeem_category = $rw['redeem_category'];
								$redeem_name = $rw['redeem_name'];
								$redeem_model = $rw['redeem_model'];
								$redeem_point = $rw['redeem_point'];
								$redeem_token = $rw['redeem_token'];
								$redeem_stock = $rw['redeem_stock'];
								$redeem_image = $rw['redeem_image'];
								$redeem_description = $rw['redeem_description'];
								
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
										<a href="redemption_product.php?hyperlink=redemption&redeem_id=<?php echo $redeem_id; ?>">
											<img src="cmanage/redemption/<?php echo $redeem_image; ?>" width="210px" height="200px" alt=""></img>
										</a>
											<div class="product-info">
												<h3><?php echo $redeem_name; ?></h3>

															<div class="product-desc">
																<p><?php echo $redeem_model; ?></p>
																<strong class="price"><?php echo ('Point: '.$redeem_point); ?></strong>
																
																<?php
																if($class == '2')
																{
																if(isset($member_point)&& $member_point !='0')
																{
																	if($member_point >= $redeem_point)
																	{?>
																		
																		<a class='button' href="redemption_validate.php?id=<?php echo $_GET['id']; ?>&act=add&redeem_id=<?php echo $redeem_id; ?>&redeem_category=<?php echo $redeem_category; ?>&redeem_qty=1&hyperlink=redemption"><span style='font-size:15px;color:#FFFFFF;'> Redeem</span></a>
															</div>
																		<?php
																			//a small function use to check either product is selected and show view chart on specify products
																			if(isset($_SESSION['redeem_order_qty']))
																			{
																				for($prds_value='0'; $prds_value < $_SESSION['redeem_order_qty']; $prds_value++)
																				{
																					if($redeem_id == $_SESSION['redeem_id'][$prds_value])
																					{
																						echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>
																						<font size='2'>View Cart</font><img src='icon/tick.png' width='12px' height='12px'></img></a>";
																					}
																				}
																			}
																		?>
																		
															  <?php }
																}else if(isset($member_point)&& $member_point !='0')
																{?>
																		<a class='button' href="#" onclick="return confirm('Please login to redeem the product!')"><span style='font-size:15px;color:#FFFFFF;'> Redeem</span></a>
																<?php } 
																} ?>
																
											</div>
									</li>
							  <?php }else
											{ //echo ('div end called');?>				
												<li class="last"><a href="redemption_product.php?hyperlink=redemption&redeem_id=<?php echo $redeem_id; ?>">
												<img src="cmanage/redemption/<?php echo $redeem_image; ?>" width="210px" height="200px" alt=""></img></a>
												<div class="product-info">
														<h3><?php echo $redeem_name; ?></h3>
														<div class="product-desc">
															<p><?php echo $redeem_model; ?></p>
															<strong class="price"><?php echo ('Point: '.$redeem_point); ?></strong> 
															<?php
															if($class =='2')
															{
																if(isset($member_point) && $member_point !='0')
																{
																	if($member_point >= $redeem_point)
																	{?>
																		<a class='button' href="redemption_validate.php?id=<?php echo $_GET['id']; ?>&act=add&redeem_id=<?php echo $redeem_id; ?>&redeem_category=<?php echo $redeem_category; ?>&redeem_qty=1&hyperlink=redemption"><span style='font-size:15px;color:#FFFFFF;'> Redeem</span></a>
															  <?php } 
																
																}else if(isset($member_point)&& $member_point !='0')
																{?>
																		<a class='button' href="#" onclick="return confirm('Please login to redeem the product!')"><span style='font-size:15px;color:#FFFFFF;'> Redeem</span></a>
														  <?php } 
															} ?>
														</div>
														<?php
															//a small function use to check either product is selected and show view chart on specify products
															if(isset($_SESSION['redeem_order_qty']))
															{
																for($prds_value2='0'; $prds_value2 < $_SESSION['redeem_order_qty']; $prds_value2++)
																{
																	if($redeem_id == $_SESSION['redeem_id'][$prds_value2])
																	{
																		echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>
																		<font size='2'>View Cart</font><img src='icon/tick.png' width='12px' height='12px'></img></a>";
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
								}
								  ?>
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