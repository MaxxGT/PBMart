<?php

//Last Upadate: 02-02-2016

//a function use to validate user for buying certain product
$special_promotion_id = '72';
$special_promotion_id2 = '78';
$special_promotion_id3 = '79';
function validate_mygazDep($spc_prm_id1, $spc_prm_id2)
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
			
			WHERE (pbmart_order_list.order_product_id = '$spc_prm_id1' || pbmart_order_list.order_product_id = '$spc_prm_id2')
			AND pbmart_order.order_customer_id = '$member_id' 
			AND pbmart_order_list.order_product_class= 'Product'
			AND pbmart_order.order_status!='2'";
	
		$iCount = mysql_query($sql);
		return $Count = @mysql_num_rows($iCount);		
}

if(validate_mygazDep($special_promotion_id, $special_promotion_id2) >0)
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

if($member_commercial_status == '1')
{
	$disabled = "disabled";
}
?>

<HTML>
	<TITLE>PBMART SPECIAL PROMOTION</TITLE>
	<BODY>
	<form action="product_validate.php?act=add&product_qty=1&hyperlink=index2&product_category=Home Delivery" method="post">
		<table width='865px'>
			<tr>
				<td colspan='2'>
					&nbsp;
				</td>
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
					<input type="radio" name="product_id" value='<?php echo $special_promotion_id; ?>' <?php echo $disabled; ?> <?php echo $checked1; ?>></input>
					<font color='black'>
						<b> 1 MYGAZ LPG 14KG CYLINDER TANK RM160.00 + FREE REFILL GAS 14KG
							<BR/>
							&nbsp;&nbsp;&nbsp;&nbsp; + MYGAZ LPG REFILL 14KG RM30.00 VOUCHER
							<font size='5' COLOR='red'><i>
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;RM190.00 ONLY</i></font>
						</b>
					</font>
					&nbsp;&nbsp;
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
					<input type="radio" name="product_id" value='<?php echo $special_promotion_id2; ?>' <?php echo $disabled; ?> ></input>
					<font color='black'>
						<b>  1 MYGAZ LPG 14KG CYLINDER TANK RM160.00 + REFILL GAS 14KG RM30.00
							<BR/>
							&nbsp;&nbsp;&nbsp;  + MYGAZ LPG REFILL 14KG RM30.00 VOUCHER<BR/>
							&nbsp;&nbsp;&nbsp;  <FONT COLOR=RED SIZE='4'>(FREE Eco Bottle Flip Top 1.0L X2)</FONT><i> -Tupperware Color are not able to choose</i>
							<font size='5' COLOR='red'><i>
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							
							RM220.00 ONLY</i></font>
						</b>
					</font>
					&nbsp;&nbsp;
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
					<input type="radio" name="product_id" value='<?php echo $special_promotion_id3; ?>' <?php echo $disabled; ?>></input>
					<font color='black'>
						<b> Bona Spray Mop + FREE MYGAZ 14KG REFILL GAS VOUCHER
							<font size='5' COLOR='red'>
								<i> 
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;RM199.00 ONLY</i>
							</font>
						</b>
					</font>
				</td>
			</tr>
			
			<tr>
				<td colspan='2'>
					&nbsp;
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
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ONLY ELIGIBLE FOR PBMART SERVICES AREA (DOMESTIC MEMBER ONLY)
					</B></font>
					<BR>
				</td>
				<td align='right'>
					<input type="submit" value="NEXT" <?php echo $disabled; ?>></input>
				</td>
			</tr>
		</table>
	</form>
	</BODY>
</HTML>