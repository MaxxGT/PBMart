<?php
//Last Upadate: 30-01-2016

//a function use to validate user for buying certain product
$special_promotion_id = '108';
$special_promotion_id2 = '121';
$special_promotion_id3 = '111';
$special_promotion_id4 = '';

if(isset($_SESSION['order_qty']))
{
	if(validate_special_promotion($special_promotion_id, $special_promotion_id2) >0)
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
}else
{
	if(validate_mygazDep($special_promotion_id, $special_promotion_id2) > 0)
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
}

function validate_special_promotion($special_promotion_id, $special_promotion_id2)
{	
	$iCount = '0';
	if(isset($_SESSION['order_qty']))
	{
		for($i=0; $i<$_SESSION['order_qty']; $i++)
		{
			if($_SESSION['product_id'][$i] == $special_promotion_id || $_SESSION['product_id'][$i] == $special_promotion_id2)
			{
				$iCount++;
			}
		}
	}
	return $iCount;
}

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

if($member_commercial_status == '1')
{
	$disabled = "disabled";
}
?>

<HTML>
	<TITLE>PBMART SPECIAL PROMOTION</TITLE>
	<BODY>
	<form action="product_validate.php" method="post">
		<table>
			<tr>
				<td>
					<tr>
						<td colspan='2'>
							<h1><strong>Special Promotion</strong></h1>
						</td>
					</tr>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		
		<table frame='box' width='870px'>
			<tr>
				<td colspan='2'>
					<table border='0' width='100%'>
						<tr>
							<td>
								<input type="radio" name="product_id" value='<?php echo $special_promotion_id2; ?>' <?php echo $disabled; ?> ></input>
							</td>
							<td>
								<font color='black' size='3'>
									<b>  1 MYGAZ LPG 14KG CYLINDER TANK RM160.00 + REFILL GAS 14KG RM30.00
										<BR/>
										+ MYGAZ LPG REFILL 14KG RM30.00 VOUCHER<BR/>
								</font>
										<FONT COLOR=RED SIZE='4'>(FREE Eco Bottle Flip Top 1.0L X2)</FONT><i> -Tupperware Color are not able to choose</i>
									</b>	
								
						<BR/>
						(ONE PER HOUSEHOLD) - HOME DELIVERY
					&nbsp;
					<img style="position:absolute;" id="my-img" src="css/images/icon_idea.png" title="AREA PROVIDED INCLUDE
93200
93300
93350
93250" onmouseover="hover(this);" onmouseout="unhover(this);" />
							</td>
							<td>
								<font size='5' COLOR='red'>
									<i>
										<center>
											<B>FREE &nbsp;
												<img src='cmanage/product/photo/Eco Bottle Flip Top.jpg'></img>
											</B>
										</center>
								</font>
										<BR/>
									<font size='6' color='red'>
										<B>RM220.00 ONLY</B>
									</i>
								</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td colspan='2'><hr /></td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<table border='0' width='100%'>
						<tr>
							<td>
								<input type="radio" name="product_id" value='<?php echo $special_promotion_id4; ?>' <?php echo $disabled; ?>></input>
							</td>
							<td width='590px'>
								<font color='black' size='3'>
									<b>&nbsp;1 MYGAZ LPG 14KG CYLINDER TANK RM160.00 + REFILL GAS 14KG RM30.00</b>
								</font>
								
								
							</td>
							<td>
								<i> 
									<center>
										<font size='5' COLOR='red'>
										<B>
										</font>&nbsp;
											<img src='cmanage/product/photo/RefillGas.png' width='100px' height='100px'></img>
										</B>
									</center>
								<BR/>
								<font size='6' color='red'>
									<B>RM190.00 ONLY
								</i>
								</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td colspan='2'><hr /></td>
			</tr>
			
			<tr>
				<td colspan='2'>
					<table border='0' width='100%'>
						<tr>
							<td>
								<input type="radio" name="product_id" value='<?php echo $special_promotion_id3; ?>' <?php echo $disabled; ?>></input>
							</td>
							<td width='590px'>
								<font color='black' size='4'>
									<b>&nbsp;Bona Spray Mop RM199.00
											<BR/>
											
									</b>
								</font>
								<font color='black' size='2'>
									&nbsp;<FONT COLOR=RED SIZE='4'><b>(FREE MYGAZ 14KG REFILL GAS VOUCHER) </b></font>
								</font>
								
							</td>
							<td>
								<i> 
									<center>
										<font size='5' COLOR='red'>
										<B>
										</font>&nbsp;
											<img src='cmanage/product/photo/5698a5c25f20d.jpg' width='100px' height='100px'></img>
										</B>
									</center>
								<BR/>
								<font size='6' color='red'>
									<B>RM199.00 ONLY
								</i>
								</font>
							</td>
						</tr>
					</table>
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
				
					<input type='hidden' name='act' value='add' />
					<input type='hidden' name='product_qty' value='1' />
					<input type='hidden' name='hyperlink' value='index2' />
					<input type='hidden' name='product_category' value='Home Delivery' />
					
					<input type="submit" value="NEXT" <?php echo $disabled; ?>></input>
				</td>
			</tr>
		</table>
	</form>
	</BODY>
</HTML>