<?php
//a function use to validate user for buying certain product
function validate_mygazDep()
{
	require_once("connection/pbmartconnection.php");
	get_UsrInfo();
	GLOBAL $member_id;
		$sql = "SELECT
				pbmart_order.order_number,
				pbmart_order.order_customer_id,
				pbmart_order_list.order_product_id,
				pbmart_order_list.order_product_name,
				pbmart_order_list.order_product_model
			FROM pbmart_order
			INNER JOIN pbmart_order_list
			ON pbmart_order.order_number = pbmart_order_list.order_number
			
			WHERE (pbmart_order_list.order_product_id = '7' OR pbmart_order_list.order_product_id = '9')
			AND pbmart_order.order_customer_id = '$member_id'";
	
		$iCount = mysql_query($sql);
		return $Count = @mysql_num_rows($iCount);		
}

if(validate_mygazDep() >0)
{
	$disabled = "disabled";
	$checked2 = "checked";
	$checked1 = "";
}else
{
	$disabled = "";
	$checked1 = "checked";
	$checked2 = "";
}
?>

<HTML>
	<TITLE>PBMART SPECIAL PROMOTION</TITLE>
	<BODY>
	<form action="product_validate.php?act=add&product_id=&product_category=&product_qty=1&hyperlink=index" method="post">		
		<table border='0' width='100%'>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<h1><strong>Special Promotion</strong></h1>
				</td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<input type="radio" name="product_id" value='7' <?php echo $disabled; ?> <?php echo $checked1; ?>></input>
					<font color='black'>
						<b> 1 MYGAZ LPG 14KG CYLINDER TANK + FREE REFILL GAS 14KG 
							<font size='5' COLOR='red'><i> &nbsp;&nbsp;&nbsp;RM150.00 ONLY</i></font>
						</b>
					</font>
					&nbsp;&nbsp;
					<?php
						//a small function use to check either product is selected and show view chart on specify products
						if(isset($_SESSION['order_qty']))
						{
							for($prds_value2='0'; $prds_value2 < $_SESSION['order_qty']; $prds_value2++)
							{
								if($_SESSION['product_id'][$prds_value2] == '7')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							}
						}
					?>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					&nbsp;&nbsp;&nbsp;&nbsp;(ONE PER HOUSEHOLD) - HOME DELIVERY
					&nbsp;
					<img style="position:absolute;" id="my-img" src="css/images/icon_idea.png" title="AREA PROVIDED INCLUDE
93200
93300
93350
93250" onmouseover="hover(this);" onmouseout="unhover(this);" />
				</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					&nbsp;
				</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<input type="radio" name="product_id" value='9' <?php echo $disabled; ?>></input>
					<font color='black'>
						<b> 1 MYGAZ LPG 14KG CYLINDER TANK + FREE REFILL GAS 14KG
							<font size='5' COLOR='red'>
								<i> &nbsp;&nbsp;&nbsp;RM146.60 ONLY</i>
							</font>
						</b>
					</font>
					&nbsp;&nbsp;
					<?php
						//a small function use to check either product is selected and show view chart on specify products
						if(isset($_SESSION['order_qty']))
						{
							for($prds_value2='0'; $prds_value2 < $_SESSION['order_qty']; $prds_value2++)
							{
								if($_SESSION['product_id'][$prds_value2] == '9')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							}
						}
					?>
				</td>
			</tr>

			<tr>
				<td colspan='2'>
					&nbsp;&nbsp;&nbsp;&nbsp;(ONE PER HOUSEHOLD) - SELF PICK UP AT SPB
	
				</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					&nbsp;
				</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<input type="radio" name="product_id" value='8' <?php echo $checked2; ?>></input>
					<font color='black'><b> BONA SPRAY MOP + FREE TWO REFILL GAS 14KG VOUCHER 
					
					<font size='5' COLOR='red'><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM200.00 ONLY</i></font></b></font>
					&nbsp;&nbsp;&nbsp;
					<?php
						//a small function use to check either product is selected and show view chart on specify products
						if(isset($_SESSION['order_qty']))
						{
							for($prds_value2='0'; $prds_value2 < $_SESSION['order_qty']; $prds_value2++)
							{
								if($_SESSION['product_id'][$prds_value2] == '8')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							}
						}
					?>
					
				</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<hr/>
				</td>
			</tr>
			
			<tr>
				<td align='left'>
					<font color='red'><B>NOTE: SPECIAL PROMOTION DOES NOT INCLUDE POINT REWARDS AND <BR/>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	   ONLY ELIGIBLE FOR PBMART SERVICES AREA
					</B></font>
					<BR>
				</td>
				<td align='right'>
					<input type="submit" value="ADD TO CART"></input>
				</td>
			</tr>
		</table>
	</form>
	</BODY>
</HTML>