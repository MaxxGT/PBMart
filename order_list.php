<?php
	include('header.php');
	require_once("connection/pbmartconnection.php");
	
if(!isset($_SESSION['usr_name']))
{
	$message = "Please signin to to view your order! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}

	$order_num = mysqli_real_escape_string($dbconnect, $_GET['or']);
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_number='$order_num'");
	$order_display = mysqli_fetch_assoc($order);
	
	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_num'");
	
	$sql_redemption_list = mysql_query("SELECT * FROM pbmart_redemption_list WHERE redemption_order_ref = '$order_num'");
	$iCount = mysql_num_rows($sql_redemption_list);
	
	
	$no = 1;
	$total_sub_amount = '0';
	if(isset($_GET['view'])){
		$view = $_GET['view'];
	}
?>
		
		<table border="0" align="center" width="985px" height="600px" cellpadding="0" cellspacing="0" >
			<BR/>
			<BR/>
			<tr align="center">
				<td valign="top">
					
					<table border="1" width="600px" height="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
						<tr>
							<th align="center">Order Receipt</th>
						</tr>
						<tr>
							<td valign="top" height="150px">
								<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<th colspan="2">Customer Details</th>
										<th colspan="2">Order Delivery Details</th>
									</tr>
									<tr>
										<?php	if($order_display['order_status'] == '1'){
													echo "<div id='complete'>";
													echo "<img src='cmanage/images/completed.png' width='600px' height='600px'/>";
													echo "</div>";
												}else if($order_display['order_status'] == '2'){
													echo "<div id='complete'>";
													echo "<img src='cmanage/images/cancelled.png' width='600px' height='600px'/>";
													echo "</div>";
												}else if($order_display['order_status'] == '3'){
													echo "<div id='complete'>";
													echo "<img src='cmanage/images/refunded.png' width='600px' height='600px'/>";
													echo "</div>";
												}
										?>
										<th width="100px" style="padding-left:5;padding-top:5;">Customer Name : </th>
										<td width="200px" style="padding-left:5;padding-top:5;"><?=$order_display['order_customer_name']?></td>
										<th width="110px" style="padding-left:5;padding-top:5;">Order Number : </th>
										<td width="100px" style="padding-left:5;padding-top:5;"><?=$order_display['order_number']?></td>
									</tr>
									<tr>
										<th width="100px" style="padding-left:5;padding-top:5;">Contact Number : </th>
										<td width="200px" style="padding-left:5;padding-top:5;"><?=$order_display['order_customer_telephone']?></td>
										<th width="110px" style="padding-left:5;padding-top:5;">Order Date : </th>
										<td width="100px" style="padding-left:5;padding-top:5;">
											<?php
												echo date("d-m-Y", strtotime($order_display['order_date']));
											?>
										</td>
									</tr>
									<tr>
										<th width="100px" style="padding-left:5;padding-top:5;">Payment Method : </th>
										<td width="200px" style="padding-left:5;padding-top:5;"><?=$order_display['order_payment_type']?></td>
										<th width="110px" style="padding-left:5;padding-top:5;">Delivery Date : </th>
										<td width="100px" style="padding-left:5;padding-top:5;">
											<?php
												echo date("d-m-Y", strtotime($order_display['order_delivery']));
											?>
										</td>
									</tr>
									<tr>
										<th valign="top" width="100px" style="padding-left:5;padding-top:5;">Address : 
										<BR/></th>
										<td width="210px" style="padding-left:5;padding-top:5;" colspan='3'><?=$order_display['order_customer_address']?></td>
										
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<?php
								if($iCount !='0')
								{
									$height = '210px';
								}else
								{
									$height = '420px';
								}
							?>
							<td valign="top" height="<?php echo $height; ?>">
								<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<th colspan="5">Ordered Items</th>
									</tr>
									<tr>
										<th width="20px" style="padding-left:5;">No.</th>
										<th width="300px" style="padding-left:5;">Product Name</th>
										<th width="50px" style="padding-left:5;">Price (RM)</th>
										<th width="50px" style="padding-left:5;">Unit(s)</th>
										<th width="60px" style="padding-left:5;">Sub Total (RM)</th>
									</tr>
									<?php	while($order_list_display = mysqli_fetch_array($order_list)){	?>
										<tr>
											<td width="20px" style="padding-left:5;"><?=$no?>. </td>
											<td width="300px" style="padding-left:5;"><?=$order_list_display['order_product_name']?></td>
											<td width="50px" style="padding-left:5;" align='right'>
												<?= number_format($order_list_display['order_product_price'],2); ?>
											</td>
											<td width="50px" align='center' style="padding-left:5;"><?=$order_list_display['order_product_amount']?></td>
											
											
											<?php	
													$total_handling_charge = $order_list_display['order_product_handling'] * $order_list_display['order_product_amount'];
													$total = $order_list_display['order_product_price'] * $order_list_display['order_product_amount'];
													$sub_total = $total - (($total * $order_list_display['order_product_sale']) / 100);	
													$total_sub_amount = $total_sub_amount + $sub_total;
													?>	
											<td width="60px" style="padding-left:5;" align='right'><?= number_format($sub_total,2); ?></td>
										</tr>
									<?php	$no++;
											}	?>
								</table>
							</td>
						</tr>
						
						<tr>
							<td height="30px">
								<table border="0" width="600px" cellpadding="0" cellspacing="0">
									
												<tr>
													<td>
														<th width="540px" style="padding-left:5;" align='right'><font color='black'><B>Sub Amount (RM) : </B></font></th>
													</td>
													<td align='right'>
														<font color='black'><b><?php echo number_format($total_sub_amount,2); ?></B></font>
													</td>
												</tr>
												
												<tr>
													<td colspan="3">
														<hr/>
													</td>
												</tr>
												
												<tr>
													<td>
														<th width="540px" style="padding-left:5;" align='right'><font color='black'><B>Others (RM) : </B></font></th>
													</td>
													<td align='right'>
														<font color='black'><b><?php echo $order_display['order_handling']; ?></B></font>
													</td>
												</tr>
										
												<tr>
													<td colspan="3">
														<hr/>
													</td>
												</tr>
												
												<tr>
													<td align='right'>
														<th width="540px" style="padding-left:5;" align='right'><font color='black'><B>Flat Handling (RM) : </B></font></th>
													</td>
													<td align='right'>
														<font color='black'><b><?php echo $order_display['flat_handling']; ?></B></font>
													</td>
													
												</tr>
												
												<tr>
													<td colspan="3">
														<hr/>
													</td>
												</tr>
												
												<tr>
													<td align='right'>
														<th width="540px" style="padding-left:5;" align='right'><font color='black'><B>Total Amount (RM) : </B></th>
														<td width="60px" style="padding-left:5;" align='right'><font color='black' size='3'><b><?= number_format($order_display['order_amount'],2); ?></B></font></td>
													</td>
												</tr>
											
								</table>
							</td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
						</tr>
					<?php
						if($iCount !='0')
						{ ?>							
							<tr>
								<td valign="top" height="210px">
									<table border="1" width="600px" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<th colspan="5">Redemption Items</th>
										</tr>
										<tr>
											<th width="80px" style="padding-left:5;">Re. Number</th>
											<th width="300px" style="padding-left:5;">Redemption Item</th>
											<th width="50px" style="padding-left:5;">Unit(s)</th>
										</tr>
										<?php	while($rw = @mysql_fetch_array($sql_redemption_list)){	
												$redemption_number = $rw['redemption_number'];
												$redemption_item = $rw['redemption_item'];
												$redemption_amount = $rw['redemption_amount'];
										?>
											<tr>
												<td width="20px" style="padding-left:5;"><?php echo $redemption_number; ?></td>
												<td width="300px" style="padding-left:5;"><?php echo $redemption_item; ?></td>
												<td width="50px" align='center' style="padding-left:5;"><?php echo $redemption_amount; ?></td>
											</tr>
										<?php	$no++;
												}	?>
									</table>
								</td>
							</tr>
			  <?php }else
			  {
				  echo "";
			  }?>
						<tr>
							<th style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;" align="left">
								</br>
								<input type="button" onClick="goBack();" value="Back"/><input type="hidden" id="view" value="<?php echo $view; ?>"/>
							</th>
						</tr>
					</table>
					</br>
				</td>
			</tr>
		</table>
		
		<?php include('footer.php'); ?>
		
<script>
	function goBack()
	{
		var confirmBack = confirm("Do you wish to go back?");
		
		if(confirmBack)
		{
				var view = document.getElementById('view').value;
			
				if(view == "or")
				{
					window.location = "order.php?hyperlink=product";
				}
			}
	}
</script>