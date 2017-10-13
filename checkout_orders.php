<?php
// Author: VOONG TZE HOWE
// Date Writen: 16-11-2014
// Description : display client orders in table format
// Last Modification:

if(!isset($_SESSION['usr_name']))
{
	$message = "Please signin to make payment thanks2!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	exit;
}else if(isset($_SESSION['usr_name']) && !isset($_SESSION['order_qty']))
{
	$message = "Please make an order from product pages! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
	exit;
}

if(isset($_POST['cash_on_delivery_rd']))
{
	$cash_on_delivery_rd = $_POST['cash_on_delivery_rd'];
}
?>

<script language=JavaScript>
	function autoSubmit() {
	var formObject = document.forms['checkout_orders_form'];
		formObject.submit();
	}
</script>

<table border="0" width="960px">
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="6" align="center">
			<strong>
				<font size="4">
				<span class="bg">
					Your Orders
					<BR><BR>
				</span>	
				</font>
			</strong>
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><u><h2>Products</u></td>
		<td colspan="2" align="center"><u><h2>Price</u></td>
		<td align="center"><u><h2>Quantity</u></td>
		<td><center><u><h2>Total Price</u></center></td>
	</tr>
	
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	
	<?php
		$card_subtotal = '0';
		$shipping_handling = '0';
		for($i=0; $i<$_SESSION['order_qty']; $i++)
		{ 
			$product_id = $_SESSION['product_id'][$i];
			$sql = "Select * FROM pbmart_product WHERE product_id='$product_id'";
			$rs = @mysql_query($sql, $link);
			$rw = @mysql_fetch_array($rs);
			
			$product_name = $rw['product_name'];
			
			//access category of product_sale and product_sale_percentage
			$product_sale1 = $rw['product_sale1'];
			$product_sale_percentage1 = $rw['product_sale_percentage1'];
						
			$product_sale2 = $rw['product_sale2'];
			$product_sale_percentage2 = $rw['product_sale_percentage2'];
						
			$product_sale3 = $rw['product_sale3'];
			$product_sale_percentage3 = $rw['product_sale_percentage3'];
						
			
			$product_qty = $_SESSION['product_qty'][$i];
			$product_price = $rw['product_price'];
			
			
			$cd_subtotal = cal_price($product_price, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
			$card_subtotal += $cd_subtotal;
		?>
			<tr>
				<td colspan="2"><?php echo $product_name; ?></td>
				<td colspan="2" align="right"> RM <?php echo $product_price; ?></td>
				<td align="center"><?php echo $product_qty; ?></td>
				<td align="right">RM <?php echo number_format($cd_subtotal,2); ?></td>
			</tr>
	<?php } ?>
	
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="5">
			<span class="bg">
				<h2>Card Subtotal</h2>
			</span>
		</td>
		<td align="right">RM <?php echo number_format($card_subtotal,2); ?></td>
	</tr>
	
	<tr>
		<td colspan="5">
			<span class="bg">
				<h2>Shipping and Handling</h2>
			</span>
		</td>
		
		<td align="right">RM <?php echo number_format($shipping_handling, 2); ?></td>
	</tr>
	
	<tr>
		<td colspan="5">
			<span class="bg">
				<h2>Order Totals</h2>
			</span>
		</td>
		
		<td align="right">
			RM 
			<?php
				$order_totals = $card_subtotal + $shipping_handling; 
				echo number_format($order_totals,2); ?></td>
	</tr>
	
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="6">
			<strong>
				<font size="4">
					Select Payment	
				</font>
			</strong>
		</td>
	</tr>
	
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>

	<tr>
		<td valign="top">
			<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Cash On Delivery</u></font><BR><BR>
			&nbsp;&nbsp;
			<input type="radio" name="cash_on_delivery_rd" value="Cash" checked> <img src="icon/cash_on.jpg" width="120px" height="60px"></img></input>
		</td>
		
		<td valign="top">
			 <font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Credit/Debit Card</u></font><BR><BR>
			&nbsp;&nbsp;
			<input type="radio" name="cash_on_delivery_rd" value="2"><img src="icon/VisaMasterCard.jpg" width="160px" height="60px"></img></input>
		</td>
		
		<td>
			<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Online Bank Transfer</u></font><BR><BR>
			&nbsp;&nbsp;
			<input type="radio" name="cash_on_delivery_rd" value="6"> <img src="icon/maybank2u.jpg" width="160px" height="60px"></img></input>
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="8"> <img src="icon/alliance-bank-logo.png" width="160px" height="60px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="10"> <img src="icon/AmBank-Group-logo.gif" width="160px" height="60px"></img></input>
			
			<BR><BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="14"> <img src="icon/RHB.png" width="160px" height="45px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="15"> <img src="icon/HongLeongConnect.png" width="160px" height="60px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="16"> <img src="icon/FPX.png" width="160px" height="40px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="20"> <img src="icon/cimb-clicks.jpg" width="150px" height="50px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="103"> <img src="icon/affin-bank-logo.jpg" width="150px" height="50px"></img></input>
		</td>
	</tr>
	
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="6" align="right"><span class="bg">
			<input type="submit" value="Place your order" onclick="return confirm('Are you sure to place order?')" title="Place your order"></input>
			<input type="hidden" name="act" value="add"></input>
			<input type="hidden" name="sub_total" value="<?php echo $order_totals; ?>"></input>
		</span></td>
	</tr>
	
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
</table>
</form>

<?php
function cal_price($prd_price, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
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
	return $tl_price - $discount;
	//return $prd_sales_percentage;
}
?>
<style>
td { height: 100%;}
.bg { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }

td { height: 100%;}
.bg2 { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }
</style>