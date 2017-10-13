<div id="cart">
	<form action="clear_cart.php?class=<?=$mem_class?>" method="POST">
		<table border="1" id="cart_table" width="350px" height="370px" cellpadding="0" cellspacing="0">
			<tr>
				<td rowspan="5" width="50px" style="border-left-style:hidden;border-top-style:hidden;border-bottom-style:hidden;">
					<input type="button" name="expand_hide" id="expand_hide" style="width:100px;height:50px;font-size:15px;" onClick="hiddenShow();" value="Hide Cart"/>
				</td>
			</tr>
			<tr id="hide_show">
				<th height="30px" align="center" bgcolor="yellow">CART</th>
			</tr>
			<tr id="hide_show1">
				<td height="250px">
					<table  border="0" width="260px" height="290px" id="item_cart" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="top" height="240px">
								<table class="cart_content" border="0" width="300px" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<td width="180px" style="padding-left:5;">Product</td>
											<td width="60px" style="padding-left:5;">Price (RM)</td>
											<td width="60px" style="padding-left:5;">Unit(s)</td>
										</tr>
									</thead>
									<tbody>
										<tr>
										<?php	
												$total_discount = 0;
												$total_handling = 0;
												$total_amount = 0;
												$total_mygaz = 0;
												$total_petronas = 0;
												if(!$cart_row){
													echo "<tr>";
													echo "<td colspan='3' style='padding-left:5;padding-top:5;'>";
													echo "<label id='empty'>There is no item in the cart.</label>";
													echo "</td>";
													echo "</tr>";
												}else{
													echo "<label id='empty'></label>";
												}
												
												while($cart_display = mysqli_fetch_array($cart)){
													echo "<tr>";
													echo "<td width='180px' style='padding-left:5;padding-top:5;'>";
													echo $cart_no.". ".$cart_display['cart_product_name'];
													echo "</td>";
													echo "<td width='60px' style='padding-left:5;'>";
													echo $cart_display['cart_product_price'];
													echo "</td>";
													echo "<td style='padding-left:5;'>";
													echo $cart_display['cart_product_amount'];
													echo "</td>";
													echo "</tr>";
													$cart_no++;
													$discount = ($cart_display['cart_product_price'] * $cart_display['cart_product_amount']) - (($cart_display['cart_product_price'] * $cart_display['cart_product_amount']) * $cart_display['cart_product_sale'])/100;
													$total_discount = $total_discount + $discount;
													$total_handling = $total_handling + ($cart_display['cart_handling'] * $cart_display['cart_product_amount']);
													
													$total_amount = $total_amount + $discount + $total_handling;
													
													$total_handling = sprintf('%0.2f', $total_handling);
													$total_amount = sprintf('%0.2f', $total_amount);
													$total_mygaz = $total_mygaz + $cart_display['cart_mygaz_amount'];
													$total_petronas = $total_petronas + $cart_display['cart_petronas_amount'];
												}
												$total_amount2 = $total_discount + $total_handling;
										?>
									</tbody>
								</table>
							</td>
						</tr>
						</tr>
							<td height="20px">
								<table border="0" valign="bottom" width="300px" height="30px" id="pricing" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<td width="180px" style="padding-left:5;border-bottom-style:solid;">Return Cylinder:</td>
											<td colspan="2" style="padding-left:5;border-bottom-style:solid;">MYGAZ = <?=$total_mygaz?> Petronas = <?=$total_petronas?></td>
										</tr>
										<tr>
											<td width="180px" style="padding-left:5;border-bottom-style:solid;">Handling Charge (RM) : </td>
											<td colspan="2" style="padding-left:5;border-bottom-style:solid;"><?=$total_handling?></td>
										</tr>
										<tr>
											<td width="180px" style="padding-left:5;border-bottom-style:solid;">Total Amount (RM) : </td>
											<td colspan="2" style="padding-left:5;border-bottom-style:solid;"><?=$total_amount2?></td>
										</tr>
										<tr>
											<td colspan="3" width="300px" height="40px" align="center" valign="middle" id="cart_bottom">
												<input type="submit" name="clear_cart" id="clear_cart" onClick="return confirmClear();" value="Clear cart"/>
												<input type="button" name="proceed" id="proceed" onClick="proceedCheckout();" value="Proceed to checkout"/>
											</td>
										</tr>
									</thead>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>