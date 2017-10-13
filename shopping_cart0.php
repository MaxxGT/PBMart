<?php
//UPDATE DATE: 23-04-2015
include('header.php');
require_once("connection/pbmartconnection.php");
get_UsrInfo();
$pkg_count = "0";
$prd_count = "0";
$nrm_class = "0";
$ryl_class = "0";
$cm_class = "0";
$tp_class = "0";
if(!empty($_SESSION['order_qty']))
{
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{
		if(isset($_SESSION['product_id'][$i]))
		{
			$prd_id = $_SESSION['product_id'][$i];
		}
		
		if(strpos($prd_id, 'PKG_') !== false)
		{
			$pkg_count++;
		}else
		{
			$prd_count++;
		}
	}
}
if(isset($_SESSION['redeem_order_qty']))
{
	for($i=0; $i<$_SESSION['redeem_order_qty']; $i++)
	{
		//redeem_id
		if(isset($_SESSION['redeem_id'][$i]))
		{
			$rdm_id = $_SESSION['redeem_id'][$i];
		}else
		{
			$rdm_id = "";
		}

		//if selected product is not package, then...
		$sql_redeem = "Select * FROM pbmart_redeem WHERE redeem_id = '$rdm_id'";
					
		$rs_redeem = mysql_query($sql_redeem, $link);
		$rw_redeem = mysql_fetch_array($rs_redeem);
		$rdm_class = $rw_redeem['redeem_class'];
		if($rdm_class == "Normal")
		{
			$nrm_class++;
		}
		if($rdm_class == "Royal")
		{
			$ryl_class++;
		}
		if($rdm_class == "Commercial")
		{
			$cm_class++;
		}if($rdm_class == "Tupperware")
		{
			$tp_class++;
		}
	}
}

// echo $pkg_count.'<BR/>';
// echo $prd_count.'<BR/>';
// echo $nrm_class.'<BR/>';
// echo $ryl_class.'<BR/>';
// echo $cm_class.'<BR/>';
// echo $tp_class.'<BR/>';

$message ="Note: You must order one LPG Gas Cylinder or redeem any royal products in other to proceed checkout. Thanks!";
$msg = "<script type='text/javascript'>alert('$message');</script>";
if($pkg_count == '0' && $prd_count=='0')
{
	if($ryl_class=='0')
	{	
		if($nrm_class > 0)
		{	
			echo $msg;
		}else if($cm_class >0)
		{
			echo $msg;
		}else if($tp_class >0)
		{
			echo $msg;
		}
	}
}

if(!isset($_SESSION['usr_name']))
{
	$message = "Please login to make order! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}else if(empty($_SESSION['order_qty']) && empty($_SESSION['redeem_order_qty']))
{
	$message = "Please make an order from product pages! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
}else
{
	$shipping_handling = '3.40';
}

$img_path_product = "cmanage/product/";
$img_path_promotion = "cmanage/promotion/";
$img_path_redeem ="cmanage/redemption/";
?>

<script language=JavaScript>
	function autoSubmit1(crt_prdQty, redeem_order_qty) {
	var formObject = document.forms['shopping_cart'];
	}
	
	function autoSubmit() {
	var formObject = document.forms['shopping_cart'];
		formObject.submit();
	}
	
	function autoSubmit2() {
	var formObject = document.forms['payment_form'];
		formObject.submit();
	}
</script>

<!-- http://stackoverflow.com/questions/10909297/number-validate-in-text-box-in-php -->
<script type="application/javascript">

function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}
	  
function addvalue(i, product_stock)
{
	var value = document.getElementById('quantity_'+i).value;
	
	if(value < product_stock)
	{
		document.getElementById('quantity_'+i).value++;
		autoSubmit();
	}	
}

function addvalue_redeem(i, product_stock, itmPoint, remainPoint)
{
	var one = 1;
	var value = document.getElementById('redeem_quantity_'+i).value;
	var remaining_point = document.getElementById('remaining_point').value;
	var value_int = parseInt(document.getElementById('redeem_quantity_'+i).value);
	var total_stock = one + value_int;
	var remain_prd = product_stock - total_stock;
	
	if(remain_prd > 0 || remain_prd == 0)
	{
		if(itmPoint > remaining_point)
		{
			alert("Note: You do not have enough point to redeem the product!");
			return;
		}else(value < product_stock)
		{
			document.getElementById('redeem_quantity_'+i).value++;
			autoSubmit();
		}
	}else
	{
		if(itmPoint > remaining_point)
		{
			alert("Note: You do not have enough point to redeem the product!");
			return;
		}
	}
}

function minus_value(i, prd_min)
{
	var value = document.getElementById('quantity_'+i).value;
	if(prd_min == 0 || prd_min < value)
	{
		if(value > 1)
		{
			document.getElementById('quantity_'+i).value--;
			autoSubmit();
		}	
	}
}

function minus_value_redeem(i)
{
	var value = document.getElementById('redeem_quantity_'+i).value;
	if(value > 1)
	{
		document.getElementById('redeem_quantity_'+i).value--;
		autoSubmit();
	}
}

function validate(i, prd_qty)
{
	if(document.getElementById('quantity_'+i).value > prd_qty || document.getElementById('quantity_'+i).value <= 0)
	{
		alert('Error: Invalid input value! Please try again!');
		document.getElementById('quantity_'+i).value = "1";
	}
	
	if(document.getElementById('quantity_'+i).value == "")
	{
		alert('Error: Invalid input value! Please try again!');
		document.getElementById('quantity_'+i).value = "1";
	}
}

function validate_redeem(i, product_stock, itmPoint, remainPoint)
{	
	if(document.getElementById('redeem_quantity_'+i).value > product_stock || document.getElementById('redeem_quantity_'+i).value <= 0)
	{
		alert('1Error: Invalid input value! Please try again!');
		document.getElementById('redeem_quantity_'+i).value = "1";
	}
	
	if(document.getElementById('redeem_quantity_'+i).value == "")
	{
		alert('2Error: Invalid input value! Please try again!');
		document.getElementById('redeem_quantity_'+i).value = "1";
	}
}
</script>
<!DOTYPE HTML>
<html>
<TITLE>PBMART</TITLE>
<BODY>
<!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
		<link rel="stylesheet" type="text/css" href="css/shopping_cart/shopping_cart.css" />
		<table border='0' height='700px' width='1090px'>
			<tr>
				<td height='500px' valign='top'>
					<form name="shopping_cart" action="shopping_cart.php?hyperlink=product" method="post">
					<?php
						if(isset($_SESSION['order_qty']) && $_SESSION['order_qty'] >0)
						{ ?>
							<table width="100%" height="55px" border="0">
								<tr>
									<td colspan="6">
										<strong>
											<font size="4" /><div style="align:center; color:black; font-size:18px; ">&nbsp;ITEMS IN YOUR CART</div>
											<BR/>
											<hr/>
										</strong>
									</td>
								</tr>
							</table>
							<?php
								//checking the limit product quantity and use the appropriate div
								if($_SESSION['order_qty'] >5)
								{
									echo "<div style='height:520px; width:100%; overflow-y:auto;'>";
								}else
								{
									echo "<div style='width:100%; style='overflow-y: auto;'>";
								}
							?>
							<table width='100%' border="0">
								<tr>
									<td colspan='5'>&nbsp;</td>
								</tr>
								<?php
									$sub_total='0';
									$total_handling_charge='0';
									$display_others='0';
									$total_point_reward='0';
									$total_flat_handling = '0';
									
									for($i=0; $i<$_SESSION['order_qty']; $i++)
									{
										//product_id
										if(isset($_SESSION['product_id'][$i]))
										{
											$product_id = $_SESSION['product_id'][$i];
										}
										
										//product_quantity
										if(isset($_REQUEST['quantity_'.$i]))
										{
											$quantity = $_REQUEST['quantity_'.$i];
											$_SESSION['product_qty'][$i] = $quantity;
										}else
										{
											if(isset($_SESSION['product_qty'][$i]))
											{
												$quantity = $_SESSION['product_qty'][$i];
											}
										}
									
										//if selected product is package product, then...
										if(strpos($product_id, 'PKG_') !== false)
										{
											$product_ids = explode("PKG_", $product_id);
											$product_ids2 = $product_ids[1];
											$sql_promotion =  "Select promotion_product_name AS product_name, 
															   promotion_item_name AS item_name, 
															   promotion_product_description AS product_description, 
															   promotion_package_price AS product_price,
															   '0' AS product_sale1,
															   '0' AS product_sale_percentage1,
															   '0' AS product_sale2,
															   '0' AS product_sale_percentage2,
															   '0' AS product_sale3,
															   '0' AS product_sale_percentage3,
															   promotion_package_point,
															   promotion_package_double_point,
															   promotion_package_stock AS product_stock,
															   promotion_package_limit AS product_limit,
															   promotion_package_lifetime_limit AS product_lifetime_limit,
															   promotion_product_photo AS product_image,
															   promotion_item_photo AS item_image,
															   '' AS product_alt,
															   promotion_product_price,
															   promotion_product_sale,
															   promotion_item_sale,
															   pbmart_promotion.promotion_category_id
															   FROM pbmart_promotion 
															   INNER JOIN pbmart_promotion_category AS pbmart_category
															   ON pbmart_category.promotion_category_id = pbmart_promotion.promotion_category_id
															   WHERE promotion_id = '$product_ids2'";
											
											$rs = mysql_query($sql_promotion, $link);
											$rw = mysql_fetch_array($rs);
											
											$product_name = $rw['product_name'];
											$item_name = $rw['item_name'];
											$product_description = $rw['product_description'];
											$product_price = $rw['product_price'];
											$promotion_product_sale = $rw['promotion_product_sale'];
											$promotion_product_price = $rw['promotion_product_price'];
											
											$promotion_item_sale = $rw['promotion_item_sale'];
											//$product_price = $product_price + $promotion_item_sale;
											
											//access category of product_sale and product_sale_percentage
											$product_sale1 = $rw['product_sale1'];
											$product_sale_percentage1 = $rw['product_sale_percentage1'];
											
											$product_sale2 = $rw['product_sale2'];
											$product_sale_percentage2 = $rw['product_sale_percentage2'];
											
											$product_sale3 = $rw['product_sale3'];
											$product_sale_percentage3 = $rw['product_sale_percentage3'];
											
											$product_stock = $rw['product_stock'];
											$product_limit = $rw['product_limit'];
											$product_lifetime_limit = $rw['product_lifetime_limit'];
											$product_image = $rw['product_image'];
											$item_image = $rw['item_image'];
											$product_alt = $rw['product_alt'];
											$promotion_category_id = $rw['promotion_category_id'];
											
											
											$promotion_unit_price = $promotion_product_price + $promotion_item_sale;
											$total_handling_charge = '0';
											$promotion_handling_charge = $promotion_product_sale - $promotion_product_price;
											$display_others = $display_others + ($promotion_handling_charge * $quantity);
											//determine the quantity maxlength based on the product_stock given
											if($product_stock < 10)
											{
												$maxsize = 1;
											}else if($product_stock > 9)
											{
												$maxsize = 2;
											}else if($product_stock > 99)
											{
												$maxsize = 3;
											}else
											{
												$maxsize = 1;
											}
											
											$promotion_package_point = $rw['promotion_package_point'];
											$promotion_package_double_point = $rw['promotion_package_double_point'];
											
											if($promotion_package_double_point == '1')
											{
												$prm_unit_point = $promotion_package_point * 2;
											}else
											{
												$prm_unit_point = $promotion_package_point;
											}
											
											$total_point_reward = $total_point_reward + ($prm_unit_point * $quantity);
											
											//flat handling
											if($promotion_category_id == '1' || $promotion_category_id == '3' || $promotion_category_id == '4' || $promotion_category_id == '5' || $promotion_category_id == '6' || $promotion_category_id == '7' || $promotion_category_id == '8')
											{
												$total_flat_handling = $total_flat_handling + ($quantity * $member_flat_floor);
											}else
											{
												$total_flat_handling = $total_flat_handling + 0;
											}
										?>
											<tr>
												<td>
													<table border="0" width='100%' height='100%'>
														<tr>
																<td>
																	<img src="<?php echo $img_path_promotion.$product_image; ?>" alt="<?php echo $product_alt; ?>" title="<?php echo $product_alt; ?>" width="115px" height="100px"></img>
																</td>
																<td>
																	<font size='5' color='red' style="text-align:top"><b>+</b></font>
																</td>
																<td>
																	<img src="<?php echo $img_path_promotion.$item_image; ?>" alt="<?php echo $product_alt; ?>" title="<?php echo $product_alt; ?>" width="115px" height="100px"></img>
																</td>
														</tr>
													</table>
												</td>
												<td>
												<table border='0' valign='top'>
													<tr>
														<td colspan='7'>
															<font color='black'>
																<strong>
																	<?php echo $product_name.' + '.$item_name; ?>
																</strong>
																
															</font>
														</td>
													</tr>
													<tr>
														<td colspan='7'><hr/></td>
													</tr>
													<tr>
														<td width='250px'><a href="product_validate.php?act=delete&hyperlink=product&delete_id=<?php echo $i; ?>">Remove</a></td>
														<td width='120px'>&nbsp;</td>
														<td width='100px'>
															<strong><center>RM <?php echo number_format($promotion_unit_price, 2); ?></center></strong>
														</td>
														<td width='50px'></td>
														<td width='90px'>
															<center>
																<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value(<?php echo $i; ?>,'1')"></input>	
																<input type="text" style="text-align:center;" id="quantity_<?php echo $i; ?>" name="quantity_<?php echo $i; ?>" size="2" maxlength="<?php echo $maxsize; ?>" value="<?php echo $quantity; ?>" onblur="validate(<?php echo $i; ?>,<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled'; }?> readonly="readonly"></input>
																<input type="hidden" name="product_stock" value="<?php echo $product_stock; ?>"></input>
																<?php if($product_limit !="0")
																{ ?>
																	
																	<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $i; ?>, <?php echo $product_limit; ?>)"></input>
																
														  <?php }else
																{ ?>
																	<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $i; ?>, <?php echo $product_stock; ?>)"></input>
														  <?php } ?>
															</center>
														</td>
														<td width='50px'></td>
														<td width='100px'>
														<font color='black'>
															<strong><center>
															RM
															<?php
																$total_price = cal_price($promotion_unit_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																if(isset($sub_total))
																{
																	$sub_total += $total_price;
																}
															echo number_format($total_price,2); ?>
															</center></strong>
														</font>
														</td>
													</tr>
												</table>
											</td>
											</tr>
											<tr>
											<td colspan='5'>
											<BR/>
												<hr class='hr_break'></hr>
											</td>
										</tr>
											
										<?php
										}else
										{
											//if selected product is not package, then...
											$total_handling_charge = '0';
											
											$sql_pbmart_product = "SELECT * FROM pbmart_product WHERE product_id = '$product_id'";
											$rs_pbmart_product = @mysql_query($sql_pbmart_product, $link);
											$rw_pbmart_product = @mysql_fetch_array($rs_pbmart_product);
											
											$product_category_id = $rw_pbmart_product['product_category_id'];
											$product_name = $rw_pbmart_product['product_name'];
											$product_model = $rw_pbmart_product['product_model'];
											$product_price = $rw_pbmart_product['product_price'];
											$product_commercial_price = $rw_pbmart_product['product_commercial_price'];
											$product_commercial_price2 = $rw_pbmart_product['product_commercial_price2'];

											$product_handling = $rw_pbmart_product['product_handling'];
											$product_commercial_handling = $rw_pbmart_product['product_commercial_handling'];
											$product_commercial_handling2 = $rw_pbmart_product['product_commercial_handling2'];
											$product_handling_show = $rw_pbmart_product['product_handling_show'];
											$product_commercial_handling_show = $rw_pbmart_product['product_commercial_handling_show'];
											$product_commercial_handling_show2 = $rw_pbmart_product['product_commercial_handling_show2'];
											
											$product_point = $rw_pbmart_product['product_point'];
											$product_commercial_point = $rw_pbmart_product['product_commercial_point'];
											$product_commercial_point2 = $rw_pbmart_product['product_commercial_point2'];
											$product_double_point = $rw_pbmart_product['product_double_point'];
											$product_commercial_double_point = $rw_pbmart_product['product_commercial_double_point'];
											$product_commercial_double_point2 = $rw_pbmart_product['product_commercial_double_point2'];
											
											//access category of product_sale and product_sale_percentage
											$product_sale1 = $rw_pbmart_product['product_sale1'];
											$product_sale_percentage1 = $rw_pbmart_product['product_sale_percentage1'];
											
											$product_sale2 = $rw_pbmart_product['product_sale2'];
											$product_sale_percentage2 = $rw_pbmart_product['product_sale_percentage2'];
											
											$product_sale3 = $rw_pbmart_product['product_sale3'];
											$product_sale_percentage3 = $rw_pbmart_product['product_sale_percentage3'];
											$product_limit = $rw_pbmart_product['product_limit'];
											$product_min = $rw_pbmart_product['product_stock_minimum'];
											
											if($product_id == '1' && $product_category_id == '1' && $commercial_prd_limit !='0')
											{
												if($member_commercial_status == '1')
												{
													if($member_commercial_class == '1')
													{
														$product_stock = $rw_pbmart_product['product_stock'];
														$product_stock_filter = $rw_pbmart_product['product_stock'];
													}else if($member_commercial_class =='2')
													{
														$product_stock = $commercial_prd_limit;
														$product_stock_filter = $commercial_prd_limit;
													}else
													{
														$product_stock = $rw_pbmart_product['product_stock'];
														$product_stock_filter = $rw_pbmart_product['product_stock'];
													}
												}else
												{
													$product_stock = $rw_pbmart_product['product_stock'];
													$product_stock_filter = $rw_pbmart_product['product_stock'];
												}
											}else
											{
												$product_stock = $rw_pbmart_product['product_stock'];
												$product_stock_filter = $rw_pbmart_product['product_stock'];
											}
											
											$product_image = $rw_pbmart_product['product_image'];
											$product_alt = $rw_pbmart_product['product_alt'];
											
											$product_description = $rw_pbmart_product['product_description'];

											//price checking here...
											if($member_commercial_status == '0')
											{
												if($product_handling_show == '0')
												{
													$product_unit_price = $product_price + $product_handling;
													$display_others = $display_others + 0;
												}else
												{
													$product_unit_price = $product_price;
													$display_others = $display_others + ($product_handling * $quantity);
												}
												$total_handling_charge = $total_handling_charge + ($product_handling * $quantity);
												
												//point system checking here...
												if($product_double_point == '1')
												{
													$prd_unit_points = $product_point * 2;
												}else
												{
													$prd_unit_points = $product_point;
												}
											}else if($member_commercial_status == '1')
											{
												if($member_commercial_class =='1')
												{
													if($product_commercial_handling_show == '0')
													{
														$product_unit_price = $product_commercial_price + $product_commercial_handling;
														$display_others = $display_others + 0;
													}else
													{
														$product_unit_price = $product_commercial_price;
														$display_others = $display_others + ($product_commercial_handling * $quantity);
													}
													$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $quantity);
													
													//point system checking here...
													if($product_commercial_double_point == '0')
													{
														$prd_unit_points = $product_commercial_point;
													}else
													{
														$prd_unit_points = $product_commercial_point + ($product_commercial_point * 2);
													}
												}else if($member_commercial_class == '2')
												{
													if($product_commercial_handling_show == '0')
													{
														$product_unit_price = $product_commercial_price2 + $product_commercial_handling2;
														$display_others = $display_others + 0;
													}else
													{
														$product_unit_price = $product_commercial_price2;
														$display_others = $display_others + ($product_commercial_handling2 * $quantity);
													}
													$total_handling_charge = $total_handling_charge + ($product_commercial_handling2 * $quantity);
													
													//point system checking here...
													if($product_commercial_double_point2 == '0')
													{
														$prd_unit_points = $product_commercial_point2;
													}else
													{
														$prd_unit_points = $product_commercial_point2 + ($product_commercial_point2 * 2);
													}
												}else
												{
													if($product_commercial_handling_show == '0')
													{
														$product_unit_price = $product_commercial_price + $product_commercial_handling;
														$display_others = $display_others + 0;
													}else
													{
														$product_unit_price = $product_commercial_price;
														$display_others = $display_others + ($product_commercial_handling * $quantity);
													}
													$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $quantity);
													
													//point system checking here...
													if($product_commercial_double_point == '0')
													{
														$prd_unit_points = $product_commercial_point;
													}else
													{
														$prd_unit_points = $product_commercial_point + ($product_commercial_point * 2);
													}
												}
											}else
											{
												if($product_handling_show == '0')
												{
													$product_unit_price = $product_price + $product_handling;
													$display_others = $display_others + 0;
												}else
												{
													$product_unit_price = $product_price;
													$display_others = $display_others + ($product_handling * $quantity);
												}
												$total_handling_charge = $total_handling_charge + ($product_handling * $quantity);
												
												//point system checking here...
												if($product_double_point == '1')
												{
													$prd_unit_points = $product_point * 2;
												}else
												{
													$prd_unit_points = $product_point;
												}
											}
											
											if($member_commercial_status == '1')
											{
												if($product_id=='1')
												{
													$total_point_reward = $total_point_reward + (($prd_unit_points + $commercial_additional_point) * $quantity); //calculate total award product point
												}else
												{
													$total_point_reward = $total_point_reward + ($prd_unit_points * $quantity); //calculate total award product point
												}
											}else
											{
												$total_point_reward = $total_point_reward + ($prd_unit_points * $quantity); //calculate total award product point
											}
											
											//determine the quantity maxlength based on the product_stock given
											if($product_stock < 10)
											{
												$maxsize = 1;
											}else if($product_stock > 9)
											{
												$maxsize = 2;
											}else if($product_stock > 99)
											{
												$maxsize = 3;
											}else
											{
												$maxsize = 1;
											}
											
											//flat handling
											if($product_category_id == '1' || $product_category_id== '3')
											{
												if($product_model == 'Home Delivery')
												{
													$total_flat_handling = $total_flat_handling + ($quantity * $member_flat_floor);
												}else
												{
													$total_flat_handling = $total_flat_handling;
												}
											}else
											{
												$total_flat_handling = $total_flat_handling + '0';
											}
									?>
										<tr>
											<td>
												<table border="0" width='300px'>
													<tr>
														<td width="150px">
															<center>
																<img src="<?php echo $img_path_product.$product_image; ?>" alt="<?php echo $product_alt; ?>" title="<?php echo $product_alt; ?>" width="115px" height="96px"></img>
															</center>
														</td>
													</tr>
												</table>
											</td>
											<td>
												<table border='0' valign='top' width='100%'>
													<tr>
														<td colspan='7'>
															<font color='black'><strong><?php echo $product_name.' - '.$product_model; ?></strong></font>
														</td>
													</tr>
													<tr>
														<td colspan='7'><hr/></td>
													</tr>
													<tr>
														<td width='250px'><a href="product_validate.php?act=delete&hyperlink=product&delete_id=<?php echo $i; ?>">Remove</a></td>
														<td width='120px'>&nbsp;</td>
														
														<td width='100px'>
															<strong><center>RM <?php echo number_format($product_unit_price, 2); ?></center></strong>
														</td>
														<td width='50px'></td>
														<td width='90px'>
															<center>
																<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value(<?php echo $i; ?>,<?php echo $product_min; ?>)" ></input>								
																<input type="text" style="text-align:center;" id="quantity_<?php echo $i; ?>" name="quantity_<?php echo $i; ?>" size="2" maxlength="<?php echo $maxsize; ?>" value="<?php echo $quantity; ?>" onblur="validate(<?php echo $i; ?>,<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled'; }?> readonly="readonly"></input>
																<input type="hidden" name="product_stock" value="<?php echo $product_stock; ?>"></input>
																	
															<?php
																if($product_limit != '0')
																{
																	?>
																	<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $i; ?>, <?php echo $product_limit; ?>)"></input>
															<?php		
																}else
																{
																	?>
																	<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $i; ?>, <?php echo $product_stock_filter; ?>)"></input>
															<?php } ?>
															</center>
														</td>
														<td width='50px'></td>
														<td width='100px'>
														<font color='black'>
															<strong><center>
															RM
															<?php
															if($member_commercial_status == '0')
															{
																if($product_handling_show == '0')
																{
																	$total_price = cal_price($product_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																}else
																{
																	$total_price = cal_price_handling_show($product_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																}
															}else
															{
																if($member_commercial_class == '1')
																{
																	if($product_commercial_handling_show == '0')
																	{
																		$total_price = cal_price($product_commercial_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																	}else
																	{
																		$total_price = cal_price_handling_show($product_commercial_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																	}
																}else if($member_commercial_class == '2')
																{
																	if($product_commercial_handling_show2 == '0')
																	{
																		$total_price = cal_price($product_commercial_price2, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																	}else
																	{
																		$total_price = cal_price_handling_show($product_commercial_price2, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																	}
																}else
																{
																	if($product_handling_show == '0')
																	{
																		$total_price = cal_price($product_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																	}else
																	{
																		$total_price = cal_price_handling_show($product_price, $total_handling_charge, $quantity, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
																	}
																}
															}
																if(isset($sub_total))
																{
																	$sub_total += $total_price;
																}
															echo number_format($total_price,2); ?>
															</center></strong>
														</font>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan='2'>
											<BR/>
												<hr class='hr_break'></hr>
											</td>
										</tr>
										<?php } ?>
								<?php	} ?>
							</table>
		</div>
		<?php } ?>	
	<?php
	if(isset($_SESSION['redeem_order_qty']) && $_SESSION['redeem_order_qty'] > 0)
	{ ?>	
		<table width="100%" border='0' height="55px">
			<tr>
				<td colspan="6">
					<div style="align:center; color:black; font-size:18px; height=100px;">
						<strong>&nbsp;YOUR REDEMPTION</strong>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<hr/>
				</td>
			</tr>
		</table>
		
		<?php
			if($_SESSION['redeem_order_qty'] > 5)
			{
				echo "<div style='height: 530px; width: 100%; overflow-y: auto'>";
			}else
			{
				echo "<div style='width: 100%; overflow-y: auto'>";
			}
		?>
		
		
			<table width="100%" border="0">
				<?php
				$sub_point = '0';
				if(isset($_SESSION['redeem_order_qty']))
				{
					for($i_values=0; $i_values<$_SESSION['redeem_order_qty']; $i_values++)
					{
						//redeem_id
						if(isset($_SESSION['redeem_id'][$i_values]))
						{
							$redeem_id = $_SESSION['redeem_id'][$i_values];
						}else
						{
							$redeem_id = "";
						}
						
						//product_quantity
						if(isset($_REQUEST['redeem_quantity_'.$i_values]))
						{
							$redeem_quantity[$i_values] = $_REQUEST['redeem_quantity_'.$i_values];
							$_SESSION['redeem_qty'][$i_values] = $redeem_quantity[$i_values];
						}else
						{
							if(isset($_SESSION['redeem_qty'][$i_values]))
							{
								$redeem_quantity[$i_values] = $_SESSION['redeem_qty'][$i_values];
							}else
							{
								$redeem_quantity[$i_values] = '0';
							}
						}

							//if selected product is not package, then...
							$sql_redeems = "Select * FROM pbmart_redeem WHERE redeem_id = '$redeem_id'";
							
							$rs = mysql_query($sql_redeems, $link);
							$rw = mysql_fetch_array($rs);
							
							$redeem_name = $rw['redeem_name'];
							$redeem_point = $rw['redeem_point'];
							
							$redeem_stock = $rw['redeem_stock'];
							$redeem_image = $rw['redeem_image'];
							
							$t_point = $redeem_point * $redeem_quantity[$i_values];
							$sub_point = $sub_point + $t_point;
							
							$total_point = '0';
							//determine the redeem_quantity maxlength based on the redeem_stock given
							if($redeem_stock < 10)
							{
								$maxsize_redeem = 1;
							}else if($redeem_stock > 9)
							{
								$maxsize_redeem = 2;
							}else if($redeem_stock > 99)
							{
								$maxsize_redeem = 3;
							}else
							{
								$maxsize_redeem = 1;
							}
					?>
						<tr>
							<td>
								<table width="300px" border="0">
									<tr>
										<td>
											<center>
												<img src="<?php echo $img_path_redeem.$redeem_image; ?>" alt="<?php echo $product_alt; ?>" title="<?php echo $redeem_name; ?>" width="100px" height="96px"></img>
											</center>
										</td>
									</tr>
								</table>
							</td>
							<td>
								<table border='0' valign='top'>
									<tr>
										<td colspan='7'>
											<font color='black'><strong><?php echo $redeem_name; ?></strong></font>
										</td>
									</tr>
									<tr>
										<td colspan='7'><hr/></td>
									</tr>
									<tr>
										<td width='250px'><a href="redemption_validate.php?act=delete&hyperlink=redemption&delete_id=<?php echo $i_values; ?>">Remove</a></td>
										<td width='120px'>&nbsp;</td>
										
										<td width='100px'>
											<strong><center><?php echo number_format($redeem_point); ?> Points</center></strong>
										</td>
										<td width='50px'></td>
										<td width='90px'>
											<center>
											<input type="button" name="btnMinus_redeem" value="-" style="height: 20px; width: 15px;" onclick="minus_value_redeem(<?php echo $i_values; ?>)"></input>	
											<input type="text" id="redeem_quantity_<?php echo $i_values; ?>" name="redeem_quantity_<?php echo $i_values; ?>" size="3" maxlength="<?php echo $maxsize_redeem; ?>" value="<?php echo $redeem_quantity[$i_values]; ?>" onblur="validate_redeem(<?php echo $i_values; ?>,<?php echo $redeem_stock; ?>,<?php echo $redeem_point; ?>,<?php echo $member_point - $sub_point; ?>)" onkeypress="return isNumberKey(event)" <?php if($redeem_stock==0){echo 'disabled';}?> readonly="readonly">
											</input>
											<input type="button" name="btnPlus_redeem" value="+" style="height: 20px; width: 15px;" onclick="addvalue_redeem(<?php echo $i_values; ?>,<?php echo $redeem_stock; ?>,<?php echo $redeem_point; ?>,<?php echo $member_point - $sub_point; ?>)"></input>
											<BR/>
											</center>
											<input type="hidden" name="redeem_stock" value="<?php echo $redeem_stock; ?>"></input>
										</td>
										<td width='50px'></td>
										<td width='100px'>
										<font color='black'>
											<strong>
												<center>
												<?php
												 echo number_format($t_point); 
												?> Points
												</center>
											</strong>
										</font>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='5'>
								<hr class='hr_break'/>
							</td>
						</tr>
			  <?php } ?>
		<?php } ?>
			</table>
		</div>
	<?php } ?>
	</form>
	
	<table width="100%" border='0' height="35px">
			<tr>
				<td colspan="2">
					<div style="align:center; color:black; font-size:18px; height=100px;">
						<center><strong>CART TOTAL</strong></center>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<hr class="hr_red"/>
				</td>
			</tr>
	</table>
	
		<table border="0" align="right" width="340px">
			    
			<?php
				if(isset($_SESSION['order_qty']) && $_SESSION['order_qty'] > 0)
				{ ?>
				<tr>
					<td colspan="2">
						<center><strong>Product Orders</strong></center>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Point Reward</strong>
					</td>
					<td>
						<?php echo $total_point_reward; ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Subtotal</strong>
					</td>
					<td>
						RM <?php echo number_format($sub_total,2); ?>
					</td>
				</tr>
				<tr>
					<td><strong>Others</strong></td>
					<td>RM <?php echo number_format($display_others,2); ?></td>
				</tr>
				
				<tr>
					<td><strong>Flat Handling</strong></td>
					<td>RM 
					<?php 
						echo number_format($total_flat_handling,2);
					?></td>
				</tr>
				
				<tr>
					<td><font size="3" color='black'><strong />Total</font></td>
					<td><font size="3" color='black'><strong>RM <?php
					$order_total = $sub_total + $display_others + $total_flat_handling;
					echo number_format($order_total,2);
					?></strong></font></td>
				</tr>
				
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>
				<?php } ?>
				<?php
				if(isset($_SESSION['redeem_order_qty']) && $_SESSION['redeem_order_qty'] >0)
				{
				?>
			    <tr>
					<td colspan="2">
						<center><strong>Redemption Orders</strong></center>
					</td>
				</tr>
				
				<tr>
					<td>
						<strong>Cart subpoint</strong>
					</td>
					<td><?php echo number_format($sub_point); ?></td>
				</tr>
				<tr>
					<td><strong>Accumulated Points</strong></td>
					<td><?php echo number_format($member_point); ?></td>
				</tr>
				
				<tr>
					<td><font size="3" color='black'><strong />Remaining Points</font></td>
					<td><font size="3" color='black'><strong>
					<?php
						$remaining_point = $member_point - $sub_point;
						echo number_format($remaining_point);
					?></strong></font></td>
					<input type="hidden" id="remaining_point" name="remaining_point" value="<?php echo $remaining_point; ?>"></input>
				</tr>
				
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>
				<?php } ?>
		</table>
		
		<table border="0" width="100%">
			<tr>
				<td>
						<a href="products.php?hyperlink=product">
							<input type="button" class="search-submit2" id="btnProducts" name="btnProducts" value="Continue Shopping" title="Click to continue shopping"></input>
						</a>
						
						
						<a href="shopping_cart_redemption.php?hyperlink=product">
							<input type="button" class="search-submit3" name="btnRedeem" value="Proceed to Redeem" onclick="return confirm('Proceed to redeem page?')" title="Click to proceed redeem page"></input>
						</a>
						
						<?php
						
							if($pkg_count == '0' && $prd_count=='0')
							{
								if($ryl_class=='0')
								{	
									if($nrm_class > 0)
									{	
										$class = "search-submit4";
										$btn_disabled = "disabled";
									}else if($cm_class >0)
									{
										$class = "search-submit4";
										$btn_disabled = "disabled";
									}else if($tp_class >0)
									{
										$class = "search-submit4";
										$btn_disabled = "disabled";
									}else
									{
										$class = "search-submit2";
										$btn_disabled = "";
									}
								}
								else
								{
									$class = "search-submit2";
									$btn_disabled = "";
								}
							}else
							{
								$class = "search-submit2";
								$btn_disabled = "";
							}
						?>
						
						<a href="checkout_page.php?hyperlink=product">
							<input type="button" class="<?php echo $class; ?>" name="btnCheckout" value="Proceed to Checkout" onclick="return confirm('Proceed to checkout?')" title="Click to proceed checkout page" <?php echo $btn_disabled; ?>></input>
						</a>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
		</table>
	</td>
</tr>

<?php
//calculate price for handling show
function cal_price_handling_show($prd_price, $tl_handling_charge, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
{
	if($prd_qty >= '1' && $prd_qty < $prd_sales1)
	{
		$prd_sales_percentage = '0';
	}else if($prd_qty >= $prd_sales1 && $prd_qty < $prd_sales2)
	{
		$prd_sales_percentage = $prd_sales_percentage1;
	}else if($prd_qty >= $prd_sales2 && $prd_qty < $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage2;
	}else if($prd_qty >= $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage3;
	}else
	{
		echo ('Internal Error! Please contact webmaster to fix the issue!');
		exit;
	}

	$tl_price = $prd_price * $prd_qty;
	$discount = ($tl_price * $prd_sales_percentage)/100;
	return ($tl_price - $discount);
	//return $prd_sales_percentage;
}

//calculate price for non handling show
function cal_price($prd_price, $tl_handling_charge, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
{
	if($prd_qty >= '1' && $prd_qty < $prd_sales1)
	{
		$prd_sales_percentage = '0';
	}else if($prd_qty >= $prd_sales1 && $prd_qty < $prd_sales2)
	{
		$prd_sales_percentage = $prd_sales_percentage1;
	}else if($prd_qty >= $prd_sales2 && $prd_qty < $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage2;
	}else if($prd_qty >= $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage3;
	}else
	{
		echo ('Internal Error! Please contact webmaster to fix the issue!');
		exit;
	}

	$tl_price = $prd_price * $prd_qty;
	$discount = ($tl_price * $prd_sales_percentage)/100;
	return ($tl_price - $discount) + $tl_handling_charge;
	//return $prd_sales_percentage;
}

function cal_discount($prd_price, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
{
	if($prd_qty >= '1' && $prd_qty < $prd_sales1)
	{
		$prd_sales_percentage = '0';
	}else if($prd_qty >= $prd_sales1 && $prd_qty < $prd_sales2)
	{
		$prd_sales_percentage = $prd_sales_percentage1;
	}else if($prd_qty >= $prd_sales2 && $prd_qty < $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage2;
	}else if($prd_qty >= $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage3;
	}else
	{
		echo ('Internal Error! Please contact webmaster to fix the issue!');
		exit;
	}

	$tl_price = $prd_price * $prd_qty;
	$discount = ($tl_price * $prd_sales_percentage)/100;
	//return $tl_price - $discount;
	return $prd_sales_percentage;
}
?>
</div>
<tr>
	<td>
	<?php include('footer.php'); ?>
	</td>
</tr>
</table>
</body>
</html>