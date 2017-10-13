<?php
// Author: VOONG TZE HOWE
// Date Writen: 14-10-2014
// Description : specify product page
// Last Modification: 18-10-2014

include('header.php');
require_once("connection/pbmartconnection.php");
get_UsrInfo();
$hyperlink = ((isset($_GET['hyperlink'])) ? $_GET['hyperlink'] : '');
$promotion_id = ((isset($_GET['prd_id'])) ? $_GET['prd_id'] : '');
$promotion_category_id = ((isset($_GET['id'])) ? $_GET['id'] : '');

$query = mysql_query("SELECT * FROM pbmart_promotion WHERE promotion_id='$promotion_id'");
$r = mysql_fetch_array($query);
$promotion_product_name = $r['promotion_product_name'];
$promotion_product_photo = $r['promotion_product_photo'];
$promotion_product_sale = $r['promotion_product_sale'];

$promotion_item_name = $r['promotion_item_name'];
$promotion_item_photo = $r['promotion_item_photo'];
$promotion_item_sale = $r['promotion_item_sale'];

$product_price = $r['promotion_package_price'];
$product_stock = $r['promotion_package_stock'];
$promotion_package_limit = $r['promotion_package_limit'];

$product_description = $promotion_product_name.' + '.$promotion_item_name;
$promotion_package_description = $r['promotion_package_description'];
$promotion_category_id = $r['promotion_category_id'];

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

$welcome_id1 = "194";
$welcome_id2 = "195";

if($promotion_id == $welcome_id1 || $promotion_id == $welcome_id2)
{
	function validate_welcome_2016($welcome_id1, $welcome_id2)
	{
		require_once("connection/pbmartconnection.php");
		get_UsrInfo();
		GLOBAL $member_id;
			$sql = "SELECT
					pbmart_order.order_number,
					pbmart_order.order_customer_id,
					pbmart_order.order_status,
					pbmart_order_list.order_product_id,
					pbmart_order_list.order_product_name,
					pbmart_order_list.order_product_model,
					pbmart_order_list.order_product_class
				FROM pbmart_order
				INNER JOIN pbmart_order_list
				ON pbmart_order.order_number = pbmart_order_list.order_number
				
				WHERE (pbmart_order_list.order_product_id = '$welcome_id1' || pbmart_order_list.order_product_id = '$welcome_id2')
				AND pbmart_order.order_customer_id = '$member_id' 
				AND pbmart_order_list.order_product_class= 'Promotion'
				AND pbmart_order.order_status != '2'";
		
			$iCount = mysql_query($sql);
			return $Count = @mysql_num_rows($iCount);		
	}
	
	if($member_commercial_status == '1')
	{
		$message = "Welcome 2016 promotion only for domestic member. Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	}	

	if(validate_welcome_2016($welcome_id1, $welcome_id2) >0)
	{
		$message = "Note: You already buy this product before! Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
		exit;
	}
}
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
function addvalue(product_stock)
{
	var value = document.getElementById('product_qty').value;
	
	if(value < product_stock)
	{
		document.getElementById('product_qty').value++;
	}	
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
#picture a.small:hover .large {display:block; position:absolute; top: 75px; left: 750px; width:350px; height:350px;}
</style>

<!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
    
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
								  <table border="0" style="font-family: verdana; font-size: 12px;" cellpadding="0" width="865px">
									<tr>
										<td>
											<table border='0'>
												<tr>
													<td><img src="cmanage/promotion/<?php echo $promotion_product_photo; ?>" width="232px" height="195px"></img></td>
													<td><font size='6' color=red>+</font></td>
													<td>
														<div id="picture">
															<a class="small" href="#nogo" title="<?php echo $promotion_item_name; ?>">
																<img src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="232px" height="195px"></img>
																<img class="large" src="cmanage/promotion/<?php echo $promotion_item_photo; ?>" width="232px" height="195px"></img>
															</a>
														</div>
													</td>
												</tr>
											</table>
										</td>
										
									<form action="product_validate.php?act=add&trigger=product" method="post">
										<td valign="top" width="30%">
											
												<BR><BR><h2><strong><font size="4"><?php //echo $promotion_product_name.' + '.$promotion_item_name; ?></font></strong><BR><BR>
												<div class="product-desc">
												<?php// echo $product_model; ?>
												<!--<p><?php echo $product_description; ?><br />-->
												  </p></h2>
													<BR>
													<strong><font color='black'>Quantity</font></strong>
													
													<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value()"></input>
													<input type="text" style="text-align:center;" id="product_qty" name="product_qty" size="2" maxlength="<?php echo $maxsize; ?>" value="1" onblur="validate(<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled';}?> readonly="readonly"></input> 
													
													<?php if($promotion_package_limit != "0")
													{ ?>
														<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $promotion_package_limit; ?>)"></input>
													<?php } else
													{ ?>
														<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $product_stock; ?>)"></input>
												<?php } ?>
													
													
													<?php
														if($product_stock == '0')
														{
															$disabled = 'disabled';
														}else
														{
															$disabled = "";
														}
													?>
													<BR/><BR/>
													<h3><strong class="price">RM<?php echo $product_price; ?></strong>
													
													
													<input type="submit" class="search-submit" name="sbtButton" value="Add to Cart" title="add to cart" <?php echo $disabled; ?>></input>
													</div></h3>
										</td>
											<input type="hidden" name="id" value="<?php echo $promotion_category_id; ?>"></input>
											<input type="hidden" name="product_id" value="PKG_<?php echo $promotion_id; ?>"></input>
											<input type="hidden" name="product_category" value="Promotion"></input>
											<input type="hidden" name="hyperlink" value="<?php echo $hyperlink; ?>"></input>
									</form>
									</tr>
									
									<tr>
										<td colspan="2">
											<h2><strong><font size="4"><?php echo $promotion_product_name.' + '.$promotion_item_name; ?></font></strong></h2>
											<BR/>
											<hr/>
										</td>
									</tr>
									
									
									
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
											
												<strong><font color='black' size='3'>Product Description:</font></strong>
												<BR/><BR/>
											
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<?php echo $promotion_package_description; ?>
										</td>
									</tr>
									
									<?php
									if($promotion_category_id =='6' || $promotion_category_id =='7' || $promotion_category_id =='8' || $promotion_category_id =='9' || $promotion_category_id =='10')
									{ ?>
										
										
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
									
										<tr>
											<td colspan="2">
													<strong><font color='black' size='3'>Terms and Conditions:</font></strong>
													<BR/><BR/>
											</td>
										</tr>
										
										<tr>
											<td colspan="2">
											
												1. Tupperware products colour are not choosable.<BR/>
												2. All Tupperware order will be fulfil within 3 to 5 working days.<BR/>
												3. All Tupperware offer only valid while stock last.<BR/>
												4. Order made in Sunday or Public Holiday will be carried to next working day.
											
											</td>
										</tr>
									<?php } ?>
								  </table>
								</div>
							<!-- End Content -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
	</table>

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