<?php
	include('header.php');
	require_once("connection/pbmartconnection.php");
	get_UsrInfo();
	
if(!isset($_SESSION['usr_name']))
{
	$message = "Please signin to to view your order! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}else
{
	$usr_name = $_SESSION['usr_name'];
	$name = explode(" ", $usr_name);
	$sql_pbmart_member = "Select member_id FROM pbmart_member WHERE member_first_name ='$name[0]' AND member_last_name LIKE '%$name[1]%'";
	$rs = mysqli_query($dbconnect,$sql_pbmart_member);
	$rw = mysqli_fetch_array($rs);
	$member_id = $rw['member_id'];
}
	$sql = "SELECT * FROM pbmart_order WHERE order_customer_id='$member_id' AND ePaymentStatus='0' OR ePaymentStatus='2'";
	$cart_order = mysqli_query($dbconnect, $sql);
	$cart_count = mysqli_num_rows($cart_order);
	
	if($cart_count == '0')
	{
		$message = "Your currently has no any order yet! Please made an order to view or manage your orders! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='myaccount.php?hyperlink=myaccount';</script>";
		exit;
	}
	
	$total_order_points = 0;
	$i=0;
?>

	<table border="0" width='100%'>
		<tr>
			<td>
				<BR />
					<h1>My Order History</h1>
				<BR />
			</td>
		</tr>
	
		<tr>
			<td valign='top'>
				<table border="1" width='100%' frame='box' cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<?php	if($cart_count == "0"){
									$bor_style = "border-bottom-style:hidden;";
								}else{
									$bor_style = "";
								}
						?>
											<th>No.</th>
											<th>Order No.</th>
											<th>Order Date</th>
											<th>Delivery Date</th>
											<th>Delivery Time</th>

											<th align='right'>Amount (RM)</th>
											<th align='right'>Point Rewards</th>
											<th>Status</th>
										</tr>

										<?php while($cart_order_display = mysqli_fetch_array($cart_order)){	
										$order_number = $cart_order_display['order_number'];
										$order_mygaz_amount = $cart_order_display['order_mygaz_amount'];
										$order_petronas_amount = $cart_order_display['order_petronas_amount'];
										
										$sql2 = "SELECT * FROM pbmart_order_list WHERE order_number='$order_number'";
										$cart_order2 = mysqli_query($dbconnect, $sql2);
										$cart_order_display2 = mysqli_fetch_assoc($cart_order2);
										$order_product_id = $cart_order_display2['order_product_id'];
										$order_product_point = $cart_order_display2['order_product_point'];
										$order_product_amount = $cart_order_display2['order_product_amount'];
										
									
									if($order_product_point =='50')
									{
										if($order_mygaz_amount=='0' || $order_petronas_amount=='0')
										{
											$order_total_point = $order_product_point * $order_product_amount;
										}else
										{
											$order_total_point = (($order_product_point * $order_mygaz_amount) + ($order_petronas_amount * ($order_product_point/2)));
										}
									}else
									{
										if($order_product_id !='3')//self pick up
										{
											if($cart_order_display2['order_product_point'] > 50)
												$order_total_point = $cart_order_display2['order_product_point'];
											else
												$order_total_point = $cart_order_display2['order_product_point'] * $order_product_amount;
										}else
										{
											$order_total_point = $order_product_point * $order_product_amount;
										}
									}				
										$i++;
									
										?>

											<tr>
												<td align='center'><?php echo $i;?>.</td>
												<td>
													<center>
													<font color='red'>
														<a class="link" style="text-decoration:none;" href="order_list.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=product" title="Click to view detail orders"><strong><?=$cart_order_display['order_number']?></strong></a></font>
													</center>
												</td>
												
												

												<td>
													<center>
														<?php
															echo date("d-m-Y", strtotime($cart_order_display['order_date']));
														?>
													</center>
												</td>

												<td>
													<center>
														<?php
															echo date("d-m-Y", strtotime($cart_order_display['order_delivery']));
														?>
													</center>
												</td>

												
												<td>
													<center>
													<?php
														if($cart_order_display['order_time']=='1')
														{
															echo ('Afternoon (12:00pm to 4:00pm)');
														}else if($cart_order_display['order_time']=='2')
														{
															echo ('Morning (8:00am to 12:00pm)');
														}else if($cart_order_display['order_time']=='3')
														{
															echo ('Immediatly');
														}
													?>
													</center>
												</td>
												<td  align="right"><?= number_format($cart_order_display['order_amount'],2); ?></td>
												
												<td align='right'><?php echo $order_total_point; ?></td>
												<td align="center">
													<?php
														if($cart_order_display['order_status'] == "0")
														{
															echo ('Pending');
														}else if($cart_order_display['order_status'] == "2")
														{
															echo ('<B><font color=red><strike>Cancel</strike><font/></B>');
														}else if($cart_order_display['order_status'] == "1")
														{
															echo ('Complete');
															$total_order_points = $total_order_points + $order_total_point;
														}else if($cart_order_display['order_status'] == "3")
														{
															echo ('Refund');
														}
													?>

												</td>	
										</tr>
										<?php	}	?>		
										<tr height='25px'>
											<td colspan='6' align='right'><B><font color='black' size='4'>Total: <font/></B>&nbsp;</td>
											<td align='right'><B><font color='black' size='4'><?php echo number_format($total_order_points,0); ?><font/></B></td>
											<td align='center'> - </td>
										</tr>
										<tr>
											<th colspan="8" align="center">&nbsp;</th>
										</tr>
						</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp; <BR/><BR/></td>
			</tr>
			<tr>
				<td colspan='8'><h1>Redemption History</h1></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
				<?php include('redemption_history.php'); ?>
				</td>
			</tr>
				
		</table>

		<script>

			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});

			function deleteOrder(){

				var order_list = document.getElementsByName('orderList[]');

				var order_num = [];

				for(var i = 0; i < order_list.length; i++){

					if(order_list[i].checked){

						order_num++;

					}

				}

				

				if(order_num > 0){

					var confirmDelete = confirm("Do you wish to delete " +order_num +" product(s)?");

				}else{

					alert("Please select 1 or more product to delete!");

				}

				

				if(confirmDelete){

					return true;

				}else{

					return false;

				}

			}

			function order_checkDeleteAll(){

				var confirmDelAll = confirm("Do you wish to delete all products?");

				

				if(confirmDelAll){

					return true;

				}else{

					return false;

				}

			}
		</script>
<?php
	//include('footer.php');
?>