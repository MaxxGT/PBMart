<?php

//last Update: 27-01-2016

include('header.php');
include('class/product.php');
require_once("connection/pbmartconnection.php");
get_UsrInfo();
GLOBAL $member_commercial_status;

if(isset($_GET['product_id']))
{
	$product_id = $_GET['product_id'];
}else
{
	$product_id = "";
}

if(isset($_GET['hyperlink']))
{
	$hyperlink = $_GET['hyperlink'];
}else
{
	$hyperlink = "";
}

$product = get_product_by_id($product_id);
$prd_id = getProduct_ID($product_id);

$prt_category_id = $product[$prd_id]->_product_category_id;
$prt_category = $product[$prd_id]->_product_category;
$product_name = $product[$prd_id]->_product_name;
$product_model = $product[$prd_id]->_product_model;
$product_description = $product[$prd_id]->_product_description;
$product_price = $product[$prd_id]->_product_price;
$product_commercial_price = $product[$prd_id]->_product_commercial_price;
$product_commercial_price2 = $product[$prd_id]->_product_commercial_price2;
$product_handling = $product[$prd_id]->_product_handling;
$product_commercial_handling = $product[$prd_id]->_product_commercial_handling;
$product_commercial_handling2 = $product[$prd_id]->_product_commercial_handling2;
$product_handling_show = $product[$prd_id]->_product_handling_show;
$product_commercial_handling_show = $product[$prd_id]->_product_commercial_handling_show;
$product_commercial_handling_show2 = $product[$prd_id]->_product_commercial_handling_show2;
$product_qty_display = $product[$prd_id]->_qty_class;
$product_min = $product[$prd_id]->_product_min;

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

$product_stock = $product[$prd_id]->_product_stock;
$product_limit = $product[$prd_id]->_product_limit;

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

$product_path = $product[$prd_id]->_product_image;
$product_alt = $product[$prd_id]->_product_alt;

if(isset($_SESSION['order_qty']))
{
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{
		if($product_id == $_SESSION['product_id'][$i])
		{
			$product_stock = $product_stock - $_SESSION['product_qty'][$i];
		}
	}
}

if($member_commercial_status == '1')
{
	if($member_commercial_class == '1')
	{
		$display_product_price = $product_commercial_price;
		$display_product_handling = $product_commercial_handling;
	}else if($member_commercial_class == '2')
	{
		$display_product_price = $product_commercial_price2;
		$display_product_handling = $product_commercial_handling2;
	}else
	{
		$display_product_price = $product_commercial_price;
		$display_product_handling = $product_commercial_handling;
	}
}else
{
	$display_product_price = $product_price;
	$display_product_handling = $product_handling;
}
?>

<!DOCTYPE html>
<html>
<title>
PBMART TUPPERWARE
</title>
<head>
	<meta charset='utf-8'/>
	<title>jQuery Zoom Demo</title>
	<style>
		/* these styles are for the demo, but are not required for the plugin */
		.zoom {
			display:inline-block;
			position: relative;
		}
		
		/* magnifying glass icon */
		.zoom:after {
			content:'';
			display:block; 
			width:33px; 
			height:33px; 
			position:absolute; 
			top:0;
			right:0;
			background:url(icon.png);
		}

		.zoom img {
			display: block;
		}

		.zoom img::selection { background-color: transparent; }
	</style>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script src='js/jquery.zoom.js'></script>
	<script>
		$(document).ready(function(){
			$('#ex1').zoom();
		});
	</script>
</head>
<body>

<script type="text/javascript">
    
	window.onload = function()
	{
	<?php 
		if($product_min !='1' && $product_min !='0')
		{ ?>
			product(<?php echo $product_id; ?>, <?php echo $product_min; ?>, '');
  <?php }else
		{ ?>
			product(<?php echo $product_id; ?>, '1', '');
  <?php } ?>
	} 
	
	
	
	
	function product(prd_id, qty, state)
    {
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
				document.getElementById("price_ajax").innerHTML=xmlhttp.responseText;
            }
          }
		if(state == 'add')
		{
			qty++;
        }else if(state == 'minus')
		{
			qty--;
		}
		xmlhttp.open("GET","product_ajax.php?id=" +prd_id+ "&qty=" +qty,true);
        xmlhttp.send();
    }
<!-- http://stackoverflow.com/questions/10909297/number-validate-in-text-box-in-php -->
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

function addvalue(product_stock)
{
	var value = document.getElementById('product_qty').value;
	if(value < product_stock)
	{
		document.getElementById('product_qty').value++;
		product(<?php echo $product_id; ?>, value, 'add');
	}	
}


function minus_value(prd_min)
{
	var value = document.getElementById('product_qty').value;
	if(prd_min == 0 || prd_min < value)
	{
		if(value > 1)
		{
			document.getElementById('product_qty').value--;
			product(<?php echo $product_id; ?>, value, 'minus');
		}
	}
}
</script>

<?php
if($product_min !='1' && $product_min !='0')
{ ?>
		<script type="text/javascript">
		product(<?php echo $product_id; ?>, <?php echo $product_min; ?>, 'non')
		</script>
 <?php }else{
	 ?>
		<script type="text/javascript">
		product(<?php echo $product_id; ?>, '1', 'non')
		</script>
 <?php } ?>

 
<!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
    
	<table border="0" style="font-family: verdana; font-size: 12px;" width='1096px'>
		<tr>
			<td valign=top width='225px'>
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
								  <table border="0" cellpadding="0" width="860px">
									<tr>
										<td>
											<span class='zoom' id='ex1'>
												<img src="cmanage/product/<?php echo $product_path; ?>" title="<?php echo $product_alt; ?>" alt="<?php echo $product_alt; ?>" width="232px" height="195px"></img>
											</span>
										</td>
										
									<form action="product_validate.php?act=add&trigger=product" method="post">
										<td valign="top" width="30%">
											
												<BR><BR><h2><strong><font size="4"><?php //echo $product_name; ?></font></strong><BR><BR>
												<div class="product-desc">
												<?php //echo $product_model; ?>
												<!--<p><?php echo $product_description; ?><br />-->
												  </p></h2>
													<BR>
													<strong><font color='black'><?php echo $product_qty_display; ?></font></strong>
													
													<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value(<?php echo $product_min; ?>)"></input>
													
													<?php
														if($product_min !='1' && $product_min !='0')
														{ 
															$value= $product_min;
														}else
														{
															$value= '1';
														}
													?>
													
													<input type="text" style="text-align:center;" id="product_qty" name="product_qty" size="2" maxlength="<?php echo $maxsize; ?>" value="<?php echo $value; ?>" onblur="validate(<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled';}?> readonly></input>
															
													
													<?php
														if($product_limit != '0')
														{ ?>
															<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $product_limit; ?>)"></input>	
													<?php
														}else
														{ ?> 
															<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue(<?php echo $product_stock; ?>)"></input>													
												  <?php }
													
													
														if($product_stock == '0')
														{
															$disabled = 'disabled';
														}else
														{
															$disabled = "";
														}
													?>
													
													<h3>
														<strong class="price">
															<BR/>
																<span id="price_ajax" />
														</strong>
														<BR/>
													<input type="submit" name="sbtButton" value="Add to Cart" title="add to cart" <?php echo $disabled; ?>></input>
													</div></h3>
										</td>
											<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"></input>
											<input type="hidden" name="product_category_id" value="<?php echo $prt_category_id; ?>"></input>
											<input type="hidden" name="product_category" value="<?php echo $prt_category; ?>"></input>
											<input type="hidden" name="hyperlink" value="<?php echo $hyperlink; ?>"></input>
									</form>
									</tr>
									
									<tr>
										<td colspan="2"><h2><strong><font size="4"><?php echo $product_name.' - '.$product_model; ?></font></strong><BR/><BR/><hr/></td>
										
									</tr>
									
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
												<strong><font size='3' color='black'>Product Description:</font></strong>
												<BR/><BR/>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<?php echo $product_description; ?>
										</td>
									</tr>
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