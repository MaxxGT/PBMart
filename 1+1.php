<?php
include("connection/pbmartconnection.php");
$product_id1="137";
$product_id2="138";
$product_id3="PKG_202";
$product_id4="PKG_203";

function validate_product($product_id1, $product_id2)
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
				
				WHERE (pbmart_order_list.order_product_id = '$product_id1' || pbmart_order_list.order_product_id = '$product_id2')
				AND pbmart_order.order_customer_id = '$member_id' 
				AND pbmart_order_list.order_product_class= 'Product'
				AND pbmart_order.order_status != '2'";
		
			$iCount = mysql_query($sql);
			return $Count = @mysql_num_rows($iCount);		
}

function validate_promotion($product_id3, $product_id4)
{
	require_once("connection/pbmartconnection.php");
	get_UsrInfo();
	GLOBAL $member_id;
	
	$promo1 = explode('PKG_', $product_id3);
	$promo_id1 = $promo1[1];
	
	$promo2 = explode('PKG_', $product_id4);
	$promo_id2 = $promo2[1];
	
	
	$sql = "SELECT
				pbmart_order.order_number,
				pbmart_order.order_customer_id,
				pbmart_order.order_status,
				pbmart_order_list.order_product_id,
				pbmart_order_list.order_product_class
				
				FROM pbmart_order
				INNER JOIN pbmart_order_list
				ON pbmart_order.order_number = pbmart_order_list.order_number
				
				WHERE (pbmart_order_list.order_product_id = '$promo_id1' || pbmart_order_list.order_product_id = '$promo_id2')
				AND pbmart_order.order_customer_id = '$member_id' 
				AND pbmart_order_list.order_product_class= 'Promotion'
				AND pbmart_order.order_status != '2'";
		
			$iCount = mysql_query($sql);
			
			return $Count = @mysql_num_rows($iCount)/2;		
}

if(validate_product($product_id1, $product_id2) > 0)
{
	$dsb_btn = '';
}else
{
	$dsb_btn = "";
}

if(validate_promotion($product_id3, $product_id4) > 0)
{
	$dsb_btn2 ='';
}else
{
	$dsb_btn2 = "";
}

?>
<!DOTYPE HTML>
<HTML>
	<HEAD>

<style>
	sup { 
    vertical-align: super;
    font-size: smaller;
}
</style>

	</HEAD>
	<BODY>
		<table border='0' frame='box' width='870px' height='265px' >
			<tr>
				<td colspan='2' height='45px'>
					<h1>
						&nbsp;<B>PBMART 1<sup>st</sup> ANNIVERSARY</B>
					</h1>
				</td>
				<td align='right'>
					<font size='4' color='red'>
						<i><B>1<sup>st</sup> - 30<sup>st</sup> May 2016</B></i>
					</font>
				</td>
			</tr>
			<tr>
				<td colspan="4" height='5px'>
				<hr />
				</td>
			</tr>
			
			<tr>
				<td width='270px' align='center'>
					<img src="cmanage/product/photo/1st_ani.jpg" width='255px' height='160px' title="MYGAZ 14KG REFILL GAS X2"></img>		
				</td>
				<td valign='top'>
				<BR />
				<form action="product_validate.php" method="post">	
					<h2><font size='4' color='black'>&nbsp;Home Delivery</font></h2>
					<BR />
					<font color='black'>
					&nbsp;- 1 MYGAZ LPG 14KG REFILL GAS RM30.00<BR />
					&nbsp;- <font size='4'><B>FREE Gift</B></font>
					</font> 
					<BR /><BR />
					&nbsp;<i>RM <font size='6' color='red'><strong>30.00 ONLY</strong></i></font> 
					<BR /><BR />
						<input type='hidden' name='act' value='add' />
						<input type='hidden' name='product_category' value='Product' />
						<input type='hidden' name='product_category_id' value='23' />
						<input type='hidden' name='product_qty' value='1' />
						<input type='hidden' name='product_id' value='<?=$product_id1;?>' />					
						<input type='hidden' name='hyperlink' value='1st_anniversary' />

					&nbsp;&nbsp;<input type='submit' name='btn' <?php echo $dsb_btn; ?> value='Add to Cart'/>
				</form>
				</td>
				
				<td valign='top'>
					<BR />
				<form action="product_validate.php" method="post">	
					<h2><font size='4' color='black'>&nbsp;Self Pick Up</font></h2>
					<BR />
					<font color='black'>
					&nbsp;- 1 MYGAZ LPG 14KG REFILL GAS RM26.60<BR />
					&nbsp;- <font size='4'><B>FREE Gift</B></font>
					</font>
					<BR /><BR />
					&nbsp;<i>RM <font size='6' color='red'><strong>26.60 ONLY</strong></i></font> 
					<BR /><BR />
						<input type='hidden' name='act' value='add' />
						<input type='hidden' name='product_category' value='Product' />
						<input type='hidden' name='product_category_id' value='23' />
						<input type='hidden' name='product_qty' value='1' />
						<input type='hidden' name='product_id' value='<?=$product_id2;?>' />					
						<input type='hidden' name='hyperlink' value='1st_anniversary' />
						
					&nbsp;&nbsp;<input type='submit' name='btn' <?php echo $dsb_btn; ?> value='Add to Cart'/>
				</i></form>
				</td>
			</tr>
			
			
			<tr>
				<td colspan="4" height='5px'>
				<hr />
				</td>
			</tr>
			
			<tr>
				<td width='270px'>					
					<img src="cmanage/promotion/photo/1+1.jpg" width='255px' height='145px' title="MYGAZ 14KG REFILL GAS X2"></img>		
				</td>
				<td valign='top'>
				<BR />
				<form action="product_validate.php?" method="post">	
					<h2><font size='4' color='black'>&nbsp;Home Delivery</font></h2>
					<BR />
					<font color='black'>
					&nbsp;- 1 MYGAZ LPG 14KG REFILL GAS RM30.00<BR />
					&nbsp;- 1 MYGAZ LPG 14KG REFILL GAS VOUCHER &nbsp;&nbsp;&nbsp;RM30.00<BR />
					&nbsp;- <font size='4'><B>FREE Gift</B></font>
					</font> 
					<BR /><BR />
					&nbsp;<i>RM <font size='6' color='red'><strong>60.00 ONLY</strong></i></font> 
					<BR /><BR />
					
						<input type='hidden' name='act' value='add' />
						<input type='hidden' name='product_category' value='Product' />
						<input type='hidden' name='product_category_id' value='26' />
						<input type='hidden' name='product_qty' value='1' />
						<input type='hidden' name='product_id' value='<?=$product_id3;?>' />					
						<input type='hidden' name='hyperlink' value='1st_anniversary' />
					
					
					&nbsp;&nbsp;<input type='submit' name='btn' <?php echo $dsb_btn2; ?> value='Add to Cart'/>
				</i></form>
				</td>
				
				<td valign='top'>
					<BR />
						<form action="product_validate.php" method="post">	
							<h2><font size='4' color='black'>&nbsp;Self Pick Up</font></h2>
							<BR />
							<font color='black'>
							&nbsp;- 1 MYGAZ LPG 14KG REFILL GAS RM26.60<BR />
							&nbsp;- 1 MYGAZ LPG 14KG REFILL GAS VOUCHER &nbsp;&nbsp;&nbsp;RM26.60<BR />
							&nbsp;- <font size='4'><B>FREE Gift</B></font>
							</font>
							<BR /><BR />
							&nbsp;<i>RM <font size='6' color='red'><strong>53.20 ONLY</strong></i></font> 
							<BR /><BR />
							
							
							<input type='hidden' name='act' value='add' />
							<input type='hidden' name='product_category' value='Product' />
							<input type='hidden' name='product_category_id' value='26' />
							<input type='hidden' name='product_qty' value='1' />
							<input type='hidden' name='product_id' value='<?=$product_id4;?>' />					
							<input type='hidden' name='hyperlink' value='1st_anniversary' />
							
							&nbsp;&nbsp;<input type='submit' name='btn' <?php echo $dsb_btn2; ?> value='Add to Cart'/>
						</i></form>
				</td>
			</tr>
		</table>
	</BODY>
</HTML>