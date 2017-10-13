<?php
get_UsrInfo();
GLOBAL $member_commercial_status;
GLOBAL $member_commercial_class;

?>
<script>
//http://stackoverflow.com/questions/18032220/css-change-image-src-on-imghover
function hover(element) {
    element.setAttribute('src', 'css/images/icon_idea_light.png');
}
function unhover(element) {
    element.setAttribute('src', 'css/images/icon_idea.png');
}
</script>


	<div id="main">
		<h1><strong>Products</strong></h1>
			<form action="product_validate.php?act=add&product_id=&product_category=&product_category_id=1&product_qty=1&hyperlink=index" method="post">	
				<table border='0' width='870px'>
					<BR/>
					<tr>
						<td>
							<CENTER>
								<B>Step 1</B>
							</CENTER>
						</td>
						<td>
							<CENTER>
								<B>Step 2</B>
							</CENTER>
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<hr />
						</td>
					</tr>
					<tr>
						<td>
							<CENTER>
								<img src="cmanage/product/photo/special.jpg"></img>
								<BR/>
								<font color='black'><B>MYGAZ LPG 14KG</B></font>
								<BR/>
							</CENTER>
						</td>
						<td valign='top'>
							<?php 
								$sql="SELECT * FROM pbmart_product WHERE product_id = '1'";
								$rs = @mysql_query($sql);
								$rw = @mysql_fetch_array($rs);
								$product_name = $rw['product_name'];
								$product_model = $rw['product_model'];
								
								if($member_commercial_status == '0')
								{
									$display_product_price = $rw['product_price'];
									$display_product_handling = $rw['product_handling'];
									$display_product_handling_show = $rw['product_handling_show'];
								}else if($member_commercial_status =='1')
								{
									if($member_commercial_class == '1')
									{
										$display_product_price = $rw['product_commercial_price'];
										$display_product_handling = $rw['product_commercial_handling'];
										$display_product_handling_show = $rw['product_commercial_handling_show'];
									}else if($member_commercial_class =='2')
									{
										$display_product_price = $rw['product_commercial_price2'];
										$display_product_handling = $rw['product_commercial_handling2'];
										$display_product_handling_show = $rw['product_commercial_handling_show2'];
									}else
									{
										$display_product_price = $rw['product_commercial_price'];
										$display_product_handling = $rw['product_commercial_handling'];
										$display_product_handling_show = $rw['product_commercial_handling_show'];
									}
								}else
								{
									$display_product_price = $rw['product_price'];
									$display_product_handling = $rw['product_handling'];
									$display_product_handling_show = $rw['product_handling_show'];
								}

								$sql2="SELECT * FROM pbmart_product WHERE product_id = '2'";
								$rs2 = @mysql_query($sql2);
								$rw2 = @mysql_fetch_array($rs2);
								$product_name2 = $rw2['product_name'];
								$product_model2 = $rw2['product_model'];

								if($member_commercial_status == '0')
								{
									$product_price2 = $rw2['product_price'];
									$product_handling2 = $rw2['product_handling'];
									$product_handling_show2 = $rw2['product_handling_show'];
								}else if($member_commercial_status=='1')
								{
									if($member_commercial_class=='1')
									{
										$product_price2 = $rw2['product_commercial_price'];
										$product_handling2 = $rw2['product_commercial_handling'];
										$product_handling_show2 = $rw2['product_commercial_handling_show'];
									}else if($member_commercial_class =='2')
									{
										$product_price2 = $rw2['product_commercial_price2'];
										$product_handling2 = $rw2['product_commercial_handling2'];
										$product_handling_show2 = $rw2['product_commercial_handling_show2'];
									}else
									{
										$product_price2 = $rw2['product_commercial_price'];
										$product_handling2 = $rw2['product_commercial_handling'];
										$product_handling_show2 = $rw2['product_commercial_handling_show'];
									}
								}else
								{
									$product_price2 = $rw2['product_price'];
									$product_handling2 = $rw2['product_handling'];
									$product_handling_show2 = $rw2['product_handling_show'];
								}
															
								
								
								$product_commercial_handling2 = $rw2['product_commercial_handling'];
								
								$sql3="SELECT * FROM pbmart_product WHERE product_id = '3'";
								$rs3 = @mysql_query($sql3);
								$rw3 = @mysql_fetch_array($rs3);
								$product_name3 = $rw3['product_name'];
								$product_model3 = $rw3['product_model'];
								
								
								$product_handling3 = $rw3['product_handling'];
								$product_commercial_handling3 = $rw3['product_commercial_handling'];
								
								if($member_commercial_status == '0')
								{
									$display_product_price3 = $rw3['product_price'];
									$product_commercial_handling3 = $rw3['product_handling'];
								}else if($member_commercial_status == '1')
								{
									if($member_commercial_class == '1')
									{
										$display_product_price3 = $rw3['product_commercial_price'];
										$product_commercial_handling3 = $rw3['product_commercial_handling'];
									}else if($member_commercial_class == '2')
									{
										$display_product_price3 = $rw3['product_commercial_price2'];
										$product_commercial_handling3 = $rw3['product_commercial_handling2'];
									}else
									{
										$display_product_price3 = $rw3['product_commercial_price'];
										$product_commercial_handling3 = $rw3['product_commercial_handling'];
									}
								}else
								{
									$display_product_price3 = $rw3['product_price'];
									$product_commercial_handling3 = $rw3['product_handling'];
								}
							?>
							
							
							<table border='0' width='100%'>
								
								<tr>
									<td>
										&nbsp;
									</td>
								</tr>
																
								<tr>
									<td>
										<input type="radio" name="product_id" value="1" checked><font color='black'><B>&nbsp;HOME DELIVERY REFILL GAS 14KG <font size='4'>RM<?php echo $display_product_price; ?> </font> 
										
										<?php if($display_product_handling_show=='1')
										{
										 ?>	
										
										+ (OTHERS <font size='4'> RM<?php echo $display_product_handling; ?></font>)
										<?php } ?>	
										
										</B></input>
									</td>
								</tr>
								<tr>
									<td>
										&nbsp;&nbsp;&nbsp;&nbsp;(FOR SELECTED AREA ONLY) &nbsp;
										<img style="position:absolute;" id="my-img" src="css/images/icon_idea.png" title="AREA PROVIDED INCLUDE
93200
93300
93350
93250" onmouseover="hover(this);" onmouseout="unhover(this);" />
									</td>
								</tr>
								
								<tr>
									<td>
										&nbsp;
									</td>
								</tr>
								
								<!-- <tr>
								
									<td>
										<input type="radio" name="product_id" value="2">
											<font color='black'><b>DEPOSIT CYLINDER <font size='4'>RM150.00 </font> + REFILL GAS 14KG <font size='4'>RM<?php echo number_format($product_price2-150,2); ?> </font> 
										
										<?php
											if($member_commercial_status == '0')
											{ ?>
												+ (OTHERS <font size='4'>&nbsp;&nbsp;&nbsp;RM<?php echo $product_handling2; ?></font>)
									  <?php }else if($member_commercial_status == '1')
											{
												if($member_commercial_class == '1')
												{ ?>
													+ (OTHERS <font size='4'>&nbsp;&nbsp;&nbsp;RM<?php echo $product_handling2; ?></font>)
										  <?php }else if($member_commercial_class =='2')
												{
												
												}else
												{ ?>
													+ (OTHERS <font size='4'>&nbsp;&nbsp;&nbsp;RM<?php echo $product_handling2; ?></font>)
										  <?php }		
											}else
											{ ?>
												+ (OTHERS <font size='4'>&nbsp;&nbsp;&nbsp;RM<?php echo $product_handling2; ?></font>)
									  <?php } ?>	
										</B></font>
										</input>
									</td>
								</tr> -->
								
								
								<tr>
									<td>
										<input type="radio" name="product_id" value="3">
											<font color='black'><B>SELF PICK UP REFILL GAS 14KG AT PULAU BURUNG SDN.BHD <font size='4'>RM<?php echo $display_product_price3; ?></font></B></font>
											&nbsp;
											<img style="position:absolute;" id="my-img" src="css/images/icon_idea.png" title="No 15, Lot 628, Jalan Ketitir, Batu Kawa, Kuching, Malaysia." onmouseover="hover(this);" onmouseout="unhover(this);" />
										</input>
										<BR/>
									</td>
								</tr>
								
								<tr>
									<td>
										&nbsp;
									</td>
								</tr>
								
								<tr>
									<td>
										<input type="radio" name="product_id" value="72">
											<font color='black'><B>1 MYGAZ LPG 14KG CYLINDER TANK <font size='4'>RM160.00</font> + REFILL GAS 14KG <font size='4'>RM30.00</font></B></font>
											<BR />
											&nbsp;&nbsp;&nbsp;&nbsp;(ONE PER HOUSEHOLD) - HOME DELIVERY
											<img style="position:absolute;" id="my-img" src="css/images/icon_idea.png" title="AREA PROVIDED INCLUDE
93200
93300
93350
93250" onmouseover="hover(this);" onmouseout="unhover(this);" />
										</input>
										<BR/>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2' align='right'>
							<HR/>
							<?php
								//a small function use to check either product is selected and show view chart on specify products
								if(isset($_SESSION['order_qty']) && $_SESSION['order_qty'] !='0')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							?>
							<input type="submit" value="ADD TO CART"></input>
						</td>
					</tr>
				</table>
			</form>
	</div>