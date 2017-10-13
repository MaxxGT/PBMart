<?php
include('header.php');
require_once("connection/pbmartconnection.php");
require_once('products_function.php');
get_UsrInfo();

$current_date = date("Y-m-d");
$str_date = "2015-08-24";
$end_date = "2015-09-31";

if($str_date >= $current_date && $end_date <= $current_date)
{
	$message = "This Webpage is not available, please try again later!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}

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

GLOBAL $member_commercial_status;
if(!isset($_SESSION['usr_name']))
{
	if(isset($_REQUEST['hyperlink']))
	{
		if($_REQUEST['hyperlink']=='pwp_tupperware_promotion')
		{	
			$message = "Please login to make order! Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
		}else
		{
			$message = "Please login to make order! Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
		}
	}
}else
{
	//validate member product id
	if($member_id >='61' && $member_id <='64')
	{
		
	}else
	{
		$message = "This Webpage is not available, please try again later!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	}
}

if(isset($_GET['product_id']))
{
	$product_id = $_GET['product_id'];
}else
{
	$product_id = "";
}

$sql_pbmart_product = "SELECT * FROM pbmart_promotion WHERE promotion_category_id='10'";
$rs = mysql_query($sql_pbmart_product, $link);
$rw = mysql_fetch_array($rs);

$promotion_product_name = $rw['promotion_product_name'];
$promotion_product_model = $rw['promotion_product_model'];
$promotion_product_description = $rw['promotion_product_description'];
$promotion_product_price = $rw['promotion_product_price'];
$promotion_product_sale = $rw['promotion_product_sale'];

$product_stock = $rw['promotion_package_stock'];
$product_path = $rw['promotion_product_photo'];

$category_id = (isset($_GET['category_id']) ? $_GET['category_id'] : '');

//step 2 product sql
$sql_refillGas_promotion = "SELECT * FROM pbmart_promotion WHERE promotion_category_id ='10' AND promotion_show!='1' AND promotion_package_stock > 0 AND promotion_start_date <='$current_date' AND promotion_end_date >= '$current_date'";
$rs_refillGas_promotion = mysql_query($sql_refillGas_promotion, $link);
?>

<!-- http://stackoverflow.com/questions/10909297/number-validate-in-text-box-in-php -->
<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	  
	  function validate(prd_qty)
	  {
		if(document.getElementById('product_qty').value > prd_qty || document.getElementById('product_qty').value <= 0)
		{
			alert('Error: Invalid input value! Please try again!');
			document.getElementById('product_qty').value = "1";
		}
	
		if(document.getElementById('product_qty').value == "")
		{
			alert('Error: Invalid input value! Please try again!');
			document.getElementById('product_qty').value = "1";
		}
	  }
</script>

<script type="application/javascript">
function addvalue()
{
	var value = document.getElementById('product_qty').value;
	
	//if(value < <?php echo $product_stock; ?>)
	//{
		document.getElementById('product_qty').value++;
	//}	
}
</script>

<script type="application/javascript">
function minus_value()
{
	var value = document.getElementById('product_qty').value;
	if(value > 1)
	{
		document.getElementById('product_qty').value--;
	}	
}
</script>

<style>
#picture {width:100px; height: 250px; background-color:#ffffff;}
#picture a.small, #picture a.small:visited { display:block; width:100px; height:100px; text-decoration:none; background:#ffffff; top:0; left:0; border:0;}
#picture a img {border:0;}
#picture a.small:hover {text-decoration:none; background-color:#000000; color:#000000;}
#picture a .large {display:block; position:absolute; width:0; height:0; border:0; top:0; left:0;}
#picture a.small:hover .large {display:block; position:absolute; top: 0px; left:150px; width:500px; height:500px;}
</style>

<!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
<form action="prm_rfGas_prcss.php?act=add&trigger=product" method='post'>    
	<table border="0">
		<tr>
			<td valign=top>
				<!-- Sidebar -->
					<?php include('sidebar.php'); ?>
				<!-- End Sidebar -->
			</td>
			
			<td valign=top>
				<table border="0">
					<tr>
						<td valign=top>
							<!-- Content -->
								<div id="content">
								  <table border="0" style="font-family: verdana; font-size: 12px;" cellpadding="0" width="730px">
									<tr>
										<td colspan='2'><h1>Purchase With Purchase Tupperware Promotions</h1></td>
									</tr>
									
									<tr>
										<td colspan='2'>&nbsp;</td>
									</tr>
									<tr>
										<td colspan='2'>&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan='2'><strong><font size='3' color='black'>Step 1</font></strong></td>
									</tr>
									<tr>
										<td width='600px'>
											
											<img src="cmanage/promotion/<?php echo $product_path; ?>" title="<?php echo $promotion_product_name; ?>" alt="<?php echo $product_alt; ?>" width="170px" height="170px"></img>
										</td>
										
										<td valign="top" width="30%">
											
												<BR><BR><h2><strong><font size="4"><?php //echo $product_name; ?></font></strong><BR><BR>
												<div class="product-desc">
												<?php //echo $product_model; ?>
												<!--<p><?php echo $product_description; ?><br />-->
												  </p></h2>
													<BR>
													<strong><font color='black'>Quantity</font></strong>
													
													<?php
														if($product_id == '7' || $product_id =='9')
														{
																
															$disabled = "disabled";
															$readonly = "readonly";
															?>
															<input type="text" id="product_qty" name="product_qty" size="3" maxlength="<?php echo $maxsize; ?>" value="1" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled';}?> <?php echo $readonly; ?>></input>
													<?php
														}else
														{
															?> 
															<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value()"></input>
															<input type="text" id="product_qty" name="product_qty" size="3" maxlength="<?php echo $maxsize; ?>" value="1" onkeypress="return isNumberKey(event)"></input>
															<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue()"></input>													
													<?php } ?>
													
													<h3>
														<strong class="price">
															<BR/>
																<?php
																	echo('RM'.number_format($promotion_product_price,2));
																?>
														</strong>
														<BR/>
														<input type="radio" name="btnRd" value="1" checked>Home Delivery RM3.40</input>
														<BR/>
														
														<BR/>
														<input type="submit" name="sbtButton" value="Add to Cart" title="add to cart"></input>
													</div></h3>
										</td>
									</tr>
									
									<tr>
										<td colspan="2"><h2><strong><font size="4"><?php echo $promotion_product_name; ?></font></strong><BR/><BR/><hr/></td>
									</tr>
									
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
												<strong><font size='3' color='black'>Step 2</font></strong>
												<BR/><BR/>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<table border='0'>
												<tr>
													<td>
														
													<?php
														$rs_tupperware_promotion = @mysql_query($sql_refillGas_promotion);
														$total_products = @mysql_num_rows($rs_tupperware_promotion);
														$checked_btnRd = "";
														$checked_iCount = "1";
														while($rw_refillGas_promotion = @mysql_fetch_array($rs_refillGas_promotion))
														{
															$promotion_id = $rw_refillGas_promotion['promotion_id'];
															$promotion_item_name = $rw_refillGas_promotion['promotion_item_name'];
															$promotion_item_sale = $rw_refillGas_promotion['promotion_item_sale'];
															$promotion_item_photo = $rw_refillGas_promotion['promotion_item_photo'];
															
															if($checked_iCount == "1")
															{
																$checked_btnRd = "checked";
															}else
															{
																$checked_btnRd = "";
															}
															
															
															if($c_pages >= cal_pg($pg, $product_row, $product_col) && $c_pages <= $total_products)
															{
																if($count==0)
																{ //echo ('div class start'); ?>
																	<tr>			
														  <?php }
																		if($count >=0 && $count <=4)
																		{ //echo $count;
																				
																			if($count >= 0 && $count <= 3)
																			{ $count++; $count2++; ?>
																					<td>
																						<table border='0' width='137px'>
																							<tr>
																								<td colspan='2'>
																									<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=refill_gas_promotion&id=<?php echo $promotion_id; ?>" title='<?php echo $promotion_item_name; ?>'>
																										<center>
																											
																													<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="100px" height="100px"/>
																													
																												
																										</center>
																									</a>
																								</td>
																							</tr>
																							<tr>
																								<td>
																									<input type="radio" name="product_id" value="<?php echo $promotion_id; ?>" onclick="autoSubmit_A()" <?php if($promotion_id == $product_id){ echo "checked"; } ?> <?php echo $checked_btnRd; ?>></input>
																								</td>
																								<td>
																									<?php echo $promotion_item_name.' RM'.$promotion_item_sale; ?>
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
																									<a href="promotion.php?prd_id=<?php echo $promotion_id; ?>&hyperlink=refill_gas_promotion&id=<?php echo $promotion_id; ?>" title='<?php echo $promotion_item_name; ?>' target="_blank">
																										<center>
																											<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="100px" height="100px"/>
																										</center>
																									</a>
																								</td>
																							</tr>
																							<tr>
																								<td>
																									<input type="radio" name="product_id" value="<?php echo $promotion_id; ?>" onclick="autoSubmit_A()" <?php if($promotion_id == $product_id){ echo "checked"; } ?> <?php echo $checked_btnRd; ?>></input>
																								</td>
																								<td>
																									<?php echo $promotion_item_name.' RM'.$promotion_item_sale; ?>
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
													<?php	}else { $c_pages; $c_pages++; } ?>	
												  <?php
															$checked_iCount++;
														} ?>
															</td>
																	</tr>
																	</table>
															</td>
														</tr>
								  
								</div>
							<!-- End Content -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
	</table>
</table>
</form>

<style>
td { height: 100%;}
.bg { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }

td { height: 100%;}
.bg2 { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }
</style>	

<?php
include('sidefull.php');
include('footer.php');
?>
</div>
</body>
</html>