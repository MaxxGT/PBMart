<?php
$message = "ALL PBMART REDEMPTION POINTS WILL BE UPDATED ON 01 JANUARY 2017. THANK YOU FOR YOUR COOPERATION";
echo "<script type='text/javascript'>alert('$message');</script>";
// Author: VOONG TZE HOWE
// Date Writen: 07-02-2015
// Description : shopping cart redemption
// Last Modification:

include('header.php');
require_once('products_function.php');
require_once('redemption_function.php');

if(isset($_SESSION['usr_name']))
{
	get_UsrInfo();
}

if($member_point_freeze == 1)
{
	$button = "button_disabled";
}else
{
	$button = "button";
}

//initial checking for user validation point
$sql_pbmart_redeem = mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_point <='$member_point'");
$iCount = mysql_num_rows($sql_pbmart_redeem);

if($iCount == '0')
{
	$message = "Note: You do not have enough point to redeem the product. Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=product';</script>";
	exit;
}

$count = 0;
$count2 = 0;
$count3 = 0;
$c_pages = 1;

$product_row = 2;
$product_col = 4;
if(isset($_GET['pg']))
{
	$pg = $_GET['pg'];
}else
{
	$pg = 1;
}

$product_categories = (isset($_POST['product_categories']) ? $_POST['product_categories'] : '');
$Keyword = (isset($_POST['Keyword']) ? $_POST['Keyword'] : '');

$class = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '1');
$redeem_class = (isset($_REQUEST['redeem_class']) ? $_REQUEST['redeem_class'] : 'normal');
if(isset($class) && isset($redeem_class))
{
	if($class == '1')
	{
		$redeem_class = 'normal';
		$filter= "WHERE redeem_point <= $member_point AND redeem_stock!='0' AND redeem_stock >'0' AND redeem_class='$redeem_class'";
	}else if($class == '2')
	{
		$redeem_class = 'royal';
		
		$sql_redeem_validation = @mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_point <= '$member_point' AND redeem_class='$redeem_class'");
		$sql_count = @mysql_num_rows($sql_redeem_validation);
		if($sql_count == '0')
		{
			$message = "Note: You do not have enough point to redeem the Royal product. Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='shopping_cart_redemption.php?hyperlink=product';</script>";
			exit;
		}
		$filter= "WHERE redeem_point <= $member_point AND redeem_stock!='0' AND redeem_stock >'0' AND redeem_class='$redeem_class'";
	}else if($class == '3')
	{
		if(isset($_SESSION['usr_name']))
		{	
			if(commercial_user($member_id) == '1')
			{
				$redeem_class = 'Commercial';
				
				$sql_redeem_normal_validation = @mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_point <= '$member_point' AND redeem_class='$redeem_class'");
				$sql_count = @mysql_num_rows($sql_redeem_normal_validation);
				if($sql_count == '0')
				{
					$message = "Note: You do not have enough point to redeem the Commercial product. Thanks!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='shopping_cart_redemption.php?hyperlink=product';</script>";
					exit;
				}
				
				$filter= "WHERE redeem_point <= $member_point AND redeem_stock!='0' AND redeem_stock >'0' AND redeem_class='$redeem_class'";
			}else
			{
				$redeem_class = 'normal';
		
				$sql_redeem_normal_validation = @mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_point <= '$member_point' AND redeem_class='$redeem_class'");
				$sql_count = @mysql_num_rows($sql_redeem_normal_validation);
				if($sql_count == '0')
				{
					$message = "Note: You do not have enough point to redeem the Normal product. Thanks!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='shopping_cart_redemption.php?hyperlink=product';</script>";
					exit;
				}
				
				$filter= "WHERE redeem_point <= $member_point AND redeem_stock!='0' AND redeem_stock >'0' AND redeem_class='$redeem_class'";
			}
		}
	}else if($class == '4')
	{
		$redeem_class = 'Tupperware';
		
		$sql_redeem_validation = @mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_point <= '$member_point' AND redeem_class='$redeem_class'");
		$sql_count = @mysql_num_rows($sql_redeem_validation);
		if($sql_count == '0')
		{
			$message = "Note: You do not have enough point to redeem the Tupperware product. Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='shopping_cart_redemption.php?hyperlink=product';</script>";
			exit;
		}
		$filter= "WHERE redeem_point <= $member_point AND redeem_stock!='0' AND redeem_stock >'0' AND redeem_class='$redeem_class'";
	}else
	{
		$redeem_class = 'normal';
		$filter= "WHERE redeem_point <= $member_point AND redeem_stock!='0' AND redeem_stock >'0' AND redeem_class='$redeem_class'";
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

if(isset($_GET['id']) && $_GET['id'] == '4')
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

if(isset($_GET['id']) && $_GET['id'] == '3')
{
	$activate3 = "active_redemption";
}else
{
	$activate3 = "btns2";
}

if(empty($_GET['id']))
{
	$activate = "active_redemption";
}
?>

<link rel="stylesheet" type="text/css" href="css/redemption/redemption.css">
<script type="text/javascript" src="jscss/lib.js"></script>
<script type="text/javascript" src="jscss/facebox.js"></script>
<script type="text/javascript" src="jscss/val.js"></script>
<script type="text/javascript" src="jscss/dtp.js"></script>
<link rel="stylesheet" type="text/css" href="jscss/slimbox_ex.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscss/data.css" media="screen" />

<script language=JavaScript>
	function autoSubmit() {
	var formObject = document.forms['redeem_form'];
		formObject.submit();
	}
</script>

<form name="redeem_form" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

<table width='980' border='0'>
<tr>
	<td align='left'>
		<table border='0' width='975px' height='660px'>
			<tr>
				<td height='5px'>&nbsp;</td>
			</tr>
			
			<tr>
				<td height='20px'>
					<font size='5'><strong>Select Redeem Product</strong></font>
				</td>
			</tr>
			<tr>
				<td height='20px'>&nbsp;</td>
			</tr>
					<tr>
							<td height='20px'>
							
								<table border='0'>
									<tr>
										<td>
											<strong>
												<font size='3'>Class:</font>
											</strong>
										</td>
										
										
											<td>
												<a href="shopping_cart_redemption.php?id=1&hyperlink=product" style="text-decoration: none">
													<input type="button" class="<?php echo $activate; ?>" value="Normal" ></input>
												</a>
											</td>
											
										<?php
											if(tppr_stk_validation()!="0" && tppr_stk_validation()> 0)
											{ ?>
												<td>
													<a href="shopping_cart_redemption.php?id=4&hyperlink=product" style="text-decoration: none">
														<input type="button" class="<?php echo $activate1; ?>" value="Tupperware" ></input>
													</a>
												</td>
									  <?php } ?>
									  
											<td width='60px'>
												<?php
													if($royal_count !='0')
													{ ?>
														<a href="shopping_cart_redemption.php?id=2&hyperlink=product" style="text-decoration: none">
															<input type="button" class="<?php echo $activate2; ?>" value="Royal"></input>
														</a>
												<?php	} ?>
											</td>
										
										
										<?php
									if(isset($_SESSION['usr_name']))
									{	
										if(commercial_user($member_id) == '1')
										{ ?>		
											<td>
												<a href="shopping_cart_redemption.php?id=3&hyperlink=product" style="text-decoration: none">
													<input type="button" class="<?php echo $activate3; ?>" value="Commercial" ></input>
												</a>
											</td>
										</td>
										<?php }
									} ?>
										
									</tr>
									
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>
							</form>
							</td>
					</tr>
			<tr>
				<td valign='top'>
					<?php
						echo $member_commercial_status;
								if($member_commercial_status == '0')
								{
									$sql_products = "SELECT * FROM pbmart_redeem $filter ORDER BY redeem_id DESC";				
								}else
								{
									$sql_products = "SELECT * FROM pbmart_redeem $filter AND redeem_category_id!='14' ORDER BY redeem_id DESC";		
								}
								$rs = @mysql_query($sql_products, $link);
								$total_products = @mysql_num_rows($rs);
								while($rw = @mysql_fetch_array($rs))
								{
										$redeem_id = $rw['redeem_id'];
										$redeem_category = $rw['redeem_category'];
										$redeem_name = $rw['redeem_name'];
										$redeem_point = $rw['redeem_point'];
										$redeem_stock = $rw['redeem_stock'];
										$redeem_image = $rw['redeem_image'];
										$redeem_description = $rw['redeem_description'];
										$redeem_model = $rw['redeem_model'];
										
									if($c_pages >= cal_pg($pg, $product_row, $product_col) && $c_pages <= $total_products)
									{
										if($count==0)
										{ //echo ('div class start'); ?>
											<div class="products">
												<div class="cl">&nbsp;</div>
													<ul>
								  <?php }
												if($count >=0 && $count <=3)
												{
													if($count >= 0 && $count <= 2)
													{ $count++; $count2++; ?>
													
														<li>
															<?php
																if($class== '2')
																{ ?>
																	<a href="redemption_product.php?hyperlink=redemption&redeem_id=<?php echo $redeem_id; ?>">
															<?php }
															
															?>
																<img src="cmanage/redemption/<?php echo $redeem_image; ?>" width="210px" height="200px" alt=""></img></a>

																<div class="product-info">

																	<h3><?php echo $redeem_name; ?></h3>

																	<div class="product-desc">
																		<p><?php echo $redeem_model; ?></br ></p>
																		<strong class="price"><?php echo ('Point: '.$redeem_point); ?></strong> 
																		<BR/>
																		<a class='<?php echo $button; ?>' href="redemption_validate.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>&act=add&redeem_id=<?php echo $redeem_id; ?>&redeem_category=<?php echo $redeem_category; ?>&redeem_qty=1&hyperlink=shp_redemption" onclick="return confirm('Are you sure to redeem the product?')">
																			<span style='font-size:15px;'> ADD TO CART</span>
																		</a>
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
																</div>
														</li>
											  <?php }else
													{ //echo ('div end called'); ?>				
														<li class="last">
														<?php
																if($class== '2')
																{ ?>
																	<a href="redemption_product.php?hyperlink=redemption&redeem_id=<?php echo $redeem_id; ?>">
															<?php } ?>
															
														<img src="cmanage/redemption/<?php echo $redeem_image; ?>" width="210px" height="200px" alt=""></img></a>
														<div class="product-info">
															<h3><?php echo $redeem_name; ?></h3>
															<div class="product-desc">
																<p><?php echo $redeem_model; ?></br ></p>
																<strong class="price"><?php echo ('Point: '.$redeem_point); ?></strong>
																<BR/>
																
																<a class='<?php echo $button; ?>' href="redemption_validate.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>&act=add&redeem_id=<?php echo $redeem_id; ?>&redeem_category=<?php echo $redeem_category; ?>&redeem_qty=1&hyperlink=shp_redemption" onclick="return confirm('Are you sure to redeem the product?')"><span style='font-size:15px;'> ADD TO CART</span></a>
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
											<table>
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
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align='right'><?php include('shopping_cart_redemption_navigate.php'); ?></td>
</tr>

<tr>
	<td>&nbsp;</td>
</tr>

<form action="checkout_page.php?hyperlink=product" method="post">
	<tr>
		<td align='right'>
		<span class="bg">
			<input type="submit" name="btnRedeem" value="Proceed to Checkout" onclick="return confirm('Do you wish to checkout?')" title="Click to proceed redeem page"></input>
		</span>
		</td>
	</tr>
</form>

<tr>
	<td>&nbsp;</td>
</tr>
</table>

<style>
.bg 
{ 
	background-color: #808080; 
	height:28px; 
	color:#fff; 
	width: 100%; 
	font-size:18px;  
	display: block;
	text-valign:right;
}
.disabled {
   pointer-events: none;
   cursor: default;
}
</style>

<?php include('footer.php'); ?>