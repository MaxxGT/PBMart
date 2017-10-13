<?php
include('header.php');
require_once("connection/pbmartconnection.php");
get_UsrInfo();
GLOBAL $member_commercial_status;
$order_qty = '0';
$same_prd = '0';

if(isset($_GET['product_id']))
{
	$product_id = $_GET['product_id'];
}else
{
	$product_id = "";
}

if(isset($_GET['product_name']))
{
	$product_name = $_GET['product_name'];
}else
{
	$product_name = "";
}

if(isset($_GET['hyperlink']))
{
	$hyperlink = $_GET['hyperlink'];
}else
{
	$hyperlink = "Product";
}

if(!empty($_SESSION['order_qty']))
{
	$order_qty = $_SESSION['order_qty'];
	for($x='0'; $x < $order_qty; $x++)
	{
		$prd_id = $_SESSION['product_id'][$x].'<BR/>';
		$prd_id = (int)$prd_id;
		$product_id = (int)$product_id;
		if($prd_id == $product_id)
		{
			
			$same_prd++;
		}else
		{
			$sql_prd = "SELECT product_id, product_name, product_model FROM pbmart_product WHERE product_name='$product_name'";
			$rs_prd = @mysql_query($sql_prd);
			while($rw_prd = @mysql_fetch_array($rs_prd))
			{
				$prds_id = $rw_prd['product_id'];
				if($prds_id == $prd_id)
				{
					$same_prd++;
				}
			}
			
		}
	}
}else
{
	$order_qty = '0';
}

echo $product_id;

$disabled = "";
$readonly = "";
if($same_prd > 0 )
{
	$dsb= "Disabled";
	$rdy = "readonly";
}else
{
	$dsb = "";
	$rdy = "";
}

$sql_pbmart_product = "SELECT * FROM pbmart_product WHERE product_id='$product_id'";
$rs = mysql_query($sql_pbmart_product, $link);
$rw = mysql_fetch_array($rs);

$prt_category_id = $rw['product_category_id'];
$prt_category = $rw['product_category'];
$product_name = $rw['product_name'];
$product_model = $rw['product_model'];
$product_description = $rw['product_description'];
$product_price = $rw['product_price'];

$product_commercial_price = $rw['product_commercial_price'];
$product_commercial_price2 = $rw['product_commercial_price2'];

$product_handling = $rw['product_handling'];

$product_commercial_handling = $rw['product_commercial_handling'];
$product_commercial_handling2 = $rw['product_commercial_handling2'];

$product_handling_show = $rw['product_handling_show'];
$product_commercial_handling_show = $rw['product_commercial_handling_show'];
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

$product_stock = $rw['product_stock'];

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

$product_path = $rw['product_image'];
$product_alt = $rw['product_alt'];

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
?>

<script type="text/javascript">
    function btnChk(btnValue,hamper_name)
    {
        if (btnValue=="")
          {
          document.getElementById("q").innerHTML="";
          return;
          } 
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
        xmlhttp.open("GET","hamper_ajax.php?q="+btnValue+"&hamper_name="+hamper_name,true);
        xmlhttp.send();
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
	
	if(value < <?php echo $product_stock; ?>)
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
				<table border="0" >
					<tr>
						<td valign=top>
							<!-- Content -->
								<div id="content">
								  <table border="0" style="font-family: verdana; font-size: 12px;" cellpadding="0" width='870px'>
									<tr>
										<td>
											<img src="cmanage/product/<?php echo $product_path; ?>" title="<?php echo $product_alt; ?>" alt="<?php echo $product_alt; ?>" width="232px" height="295px"></img>
										</td>
										
									<form action="hamper_prcss.php?act=add&trigger=product" method="post">
										<td valign="top" width="40%">
											
											<BR><BR><BR><BR>
											<div class="product-desc">
												  </p></h2>
													<BR>
													<strong><font color='black'>Quantity</font></strong>
															<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value()" <?php echo $dsb; ?>></input>
															<input type="text" id="product_qty" name="product_qty" size="3" maxlength="<?php echo $maxsize; ?>" value="1" onblur="validate(<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php echo $rdy; ?>></input>
															<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue()" <?php echo $dsb; ?>></input>													
													<h3>
														<strong class="price">
															<BR/>
															<span id="price_ajax" style="color:red">
																<?php
																if($member_commercial_status == '0')
																{
																	if($product_handling_show == '1')
																	{
																		echo('RM'.number_format($display_product_price,2));
																		echo "<BR/><font size='2'>+ OTHERS RM";
																		echo number_format($display_product_handling,2);
																		echo "</font>";
																	}else
																	{
																		echo('RM'.number_format($total_product_price,2));
																	}
																}else if($member_commercial_status == '1')
																{
																	if($member_commercial_class == '1')
																	{
																			if($product_commercial_handling_show == '1')
																			{
																				echo('RM'.number_format($display_product_price,2));
																				echo "<BR/><font size='2'>+ OTHERS RM";
																				echo number_format($display_product_handling,2);
																				echo "</font>";
																			}else
																			{
																				echo('RM'.number_format($total_product_price,2));
																			}
																	}else if($member_commercial_class == '2')
																	{
																		if($product_commercial_handling_show2 == '1')
																		{
																			echo('RM'.number_format($display_product_price,2));
																			echo "<BR/><font size='2'>+ OTHERS RM";
																			echo number_format($display_product_handling,2);
																			echo "</font>";
																		}else
																		{
																			echo('RM'.number_format($total_product_price,2));
																		}
																	}else
																	{
																		if($product_commercial_handling_show == '1')
																		{
																			echo('RM'.number_format($display_product_price,2));
																			echo "<BR/><font size='2'>+ OTHERS RM";
																			echo number_format($display_product_handling,2);
																			echo "</font>";
																		}else
																		{
																			echo('RM'.number_format($total_product_price,2));
																		}
																	}
																}else
																{
																	if($product_handling_show == '1')
																	{
																		echo('RM'.number_format($display_product_price,2));
																		echo "<BR/><font size='2'>+ OTHERS RM";
																		echo number_format($display_product_handling,2);
																		echo "</font>";
																	}else
																	{
																		echo('RM'.number_format($total_product_price,2));
																	}
																}
																?>
														</strong>
														<BR/>
														<input type="radio" name="btnRd" value='0' onclick="btnChk('0','<?php echo $product_name; ?>');" checked <?php echo $dsb; ?>>Home Delivery</font></input>
														<BR/>
														<input type="radio" name="btnRd" value='1' onclick="btnChk('1','<?php echo $product_name; ?>');" <?php echo $dsb; ?>>Self Pick Up at SPB <B><font color=red size=3> SAVE RM10.00</font></B></input>
														<BR/>
											</div>
				
            </div>
         
														<BR/>
													<input type="submit" name="sbtButton" value="Add to Cart" title="add to cart" <?php echo $dsb; ?>></input>
													</div></h3>
										</td>
												
											<input type="hidden" name="product_name" value="<?php echo $product_name; ?>"></input>
											
											<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"></input>
											<input type="hidden" name="product_category_id" value="<?php echo $prt_category_id; ?>"></input>
											<input type="hidden" name="product_category" value="<?php echo $prt_category; ?>"></input>
											<input type="hidden" name="hyperlink" value="<?php echo $hyperlink; ?>"></input>
									</form>
									</tr>
									
									<tr>
										<td colspan="2"><h2><strong><font size="4"><?php echo $product_name; ?></font></strong><BR/><BR/><hr/></td>
										
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
?>
			<div style="height:51px; width:940px; background:#ebebeb; white-space:nowrap; line-height:50px; padding:0 15px; color:#7b7b7b; position:relative; float:bottom;">
				<?php include('footer.php'); ?>
			</div>
</div>
</body>
</html>