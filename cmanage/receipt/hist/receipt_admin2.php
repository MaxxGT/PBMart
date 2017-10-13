<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$order_num = mysqli_real_escape_string($dbconnect, $_GET['or']);
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_number='$order_num'");
	$order_display = mysqli_fetch_assoc($order);
	
	$total_amount = 0;
?>
	
<html>
	<head>
		<title>Receipt</title>
		<link rel="stylesheet" type="text/css" href="css/receipt_css(boss).css">
		<style type="text/css" media="print">
			@page{
				size:auto;
				margin:-15mm;
			}
			
			#item th, #item td{
				border:1px solid black;
				border-style:dotted;
			}
		</style>		
	</head>
	<body>
		<!--<img src="../images/blank2.png"/>-->
		<div id="outter">
			<div id="header">
				<img src="images/pbmart.png" alt="PBMart" width="75px" height="75px"/>
				<span id="title">PB MART SDN. BHD. <span id="company">(CO.NO: 666387-H)</span></span>
				<span id="blank"></span>
				<span id="address">
					NO. 15, LOT 628, JALAN KETITIR, BATU KAWA, 93250 KUCHING.
					<span id="ref">
						Refer No. _________________
					</span>
					</br>
					TELL: 082 688968<span class="tab"></span>FAX: 082 688653<span class="tab"></span>EMAIL: sales@pbmart.com.my
				</span>
			</div>
			<div id="body">
				<table border="0" align="center" width="700px" cellspacing="0" cellpadding="0">
					<tr>
						<th width="100px">Name</th>
						<th width="5px">:</th>
						<?php	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
								$member_display = mysqli_fetch_assoc($member);
								
								if($member_display['member_commercial_status'] == 1){
									$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='".$member_display['member_id']."'");
									$commercial_display = mysqli_fetch_assoc($commercial);
									
									$customer_name = $commercial_display['commercial_company'];
									$member_num = $commercial_display['commercial_number'];
								}else{
									$customer_name = $order_display['order_customer_name'];
									$member_num = $member_display['member_number'];
								}
						?>
						<td width="300px"><?=$customer_name?></td>
						<th width="75px">Phone No</th>
						<th width="5px">:</th>
						<td width="60px"><?=$order_display['order_customer_contact']?></td>
					</tr>
					<tr>
						<th width="100px">Address</th>
						<th width="5px">:</th>
						<td width="515px" colspan="4"><?=$order_display['order_customer_address']?></td>
					</tr>
					<tr>
						<th width="100px">Order Number</th>
						<th width="5px">:</th>
						<td width="300px"><?=$order_num?></td>
						<th width="75px">Date</th>
						<th width="5px">:</th>
						<td width="60px"><?php	echo date("Y-m-d");	?></td>
					</tr>
					<tr>
						<th width="100px">Member Number</th>
						<th width="5px">:</th>
						<td width="300px"><?=$member_num?></td>
						<th width="75px">Order Date</th>
						<th width="5px">:</th>
						<td width="60px"><?=$order_display['order_date']?></td>
					</tr>
					<tr>
						<th width="100px">Delivery Time</th>
						<th width="5px">:</th>
						<?php	if($order_display['order_time'] == 2){
									$deliver = "Morning (8-12)";
								}else if($order_display['order_time'] == 1){
									$deliver = "Afternoon (12-4)";
								}else if($order_display['order_time'] == 3){
									$deliver = "Immediately";
								}
						?>
						<td width="300px"><?=$deliver?></td>
						<th width="75px">Delivery Date</th>
						<th width="5px">:</th>
						<td width="60px"><?=$order_display['order_delivery']?></td>
					</tr>
					<tr>
						<th width="100px" style="background-color:white;">Point Balance</th>
						<th width="5px" style="background-color:white;">:</th>
						<td width="300px" colspan="3"><?=$member_display['member_point']?></td>
					</tr>
				</table>
			</div>
			<div id="content">
				<?php	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_num'");
				?>
				<table border="1" align="center" width="680px" height="20px" cellspacing="0" cellpadding="0" id="item">
					<tr height="20px">
						<th width="30px">Qty</th>
						<th width="500px">Items</th>
						<th width="70px">Sub Total</th>
					</tr>
					<?php	while($order_list_display = mysqli_fetch_array($order_list)){	?>
					<tr>
						<td width="30px" valign="top"><?=$order_list_display['order_product_amount']?></td>
						<td width="500px" valign="top">
							<?php	$total	= 0;
									
									if((strpos($order_list_display['order_product_name'], 'MYGAZ LPG')) !== FALSE){
										if((strpos($order_list_display['order_product_model'], 'Home Delivery')) !== FALSE){
											echo $order_list_display['order_product_name']." (Delivery by SPB)";
										}else if((strpos($order_list_display['order_product_model'], 'Self Pick Up at SPB')) !== FALSE){
											echo $order_list_display['order_product_name']." (Self pick up at SPB)";
										}
										
										echo "</td>";
										
										$total = 0;
									}else{
										echo $order_list_display['order_product_name'];
										echo "</td>";
										
										$total = $total + (($order_list_display['order_product_price'] + $order_list_display['order_product_handling']) * $order_list_display['order_product_amount']);
									}
									
									$total_amount = $total_amount + $total;
									
									echo "<td width='70px' valign='top' style='text-align:right;padding-right:12px;'>";
									if($total == 0){
										echo "-";
									}else{
										echo sprintf('%0.2f', $total);
									}
									echo "</br>";
							?>
						</td>
					</tr>
					<?php	}	
							
							$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_list WHERE redemption_order_ref='$order_num'");
							$redeem_number = mysqli_fetch_assoc($redeem);
							$redeem_count = mysqli_num_rows($redeem);
							
							if($redeem_count){
								echo "<tr>";
								echo "<td colspan='2' width='30px' valign='top' style='padding-left:56px;'>Please refer to <strong>REDEMPTION NUMBER</strong> (".$redeem_number['redemption_number'].")</td>";
								echo "<td style='text-align:right;padding-right:12px;'>Redemption</td>";
								echo "</tr>";
							}
					?>
					<tr>
						<th colspan="2" style="text-align:right;">Return Cylinder: </th>
						<td width="70px" style="text-align:left;padding-right:12px;">
						MYGAZ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order_display['order_mygaz_amount']; ?>
						<BR/>
						PETRONAS: <?php echo $order_display['order_petronas_amount'];; ?>
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align:right;">Total Amount (RM) : </th>
						<td width="70px" style="text-align:right;padding-right:12px;">
						<?php	echo sprintf('%0.2f', $total_amount);
						?>
						</td>
					</tr>
					<tr>
						<th colspan="2" style="text-align:right;">Point Rewards : </th>
						<td width="70px" style="text-align:right;padding-right:12px;"><?=$order_display['order_total_point']?></td>
					</tr>
					<!--<tr>
						<th colspan="2" style="text-align:right;">Total Points : </th>
						<td width="70px" style="text-align:right;padding-right:12px;">
						<?php	//echo $member_display['member_point'] + $order_display['order_total_point'];
						?>
						</td>
					</tr>-->
				</table>
			</div>
			<div id="signature">
				<table border="1px solid black" align="center" width="700px" cellpadding="0" cellspacing="0" style="border-style:hidden;">
					<!--<tr>
						<td colspan="2" align="center" width="80px" style="border-style:hidden;">
							<table border="1" width="80px" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
								<tr>
									<td colspan="3" style="text-align:center;padding:0;">Date</td>
								</tr>
								<tr height="30px">
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td colspan="2" align="center" width="80px" style="border-style:hidden;">
							<table border="1" width="80px" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
								<tr>
									<td colspan="3" style="text-align:center;padding:0;">Date</td>
								</tr>
								<tr height="30px">
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td colspan="2" align="center" width="80px" style="border-style:hidden;">
							<table border="1" width="80px" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
								<tr>
									<td colspan="3" style="text-align:center;padding:0;">Date</td>
								</tr>
								<tr height="30px">
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
					</tr>-->
					<tr height="5px">
						<td style="border-style:hidden;"></td>
					</tr>
					<tr>
						<td width="200px" style="border-style-bottom:solid;"></td>
						<td width="50px" style="border-style:hidden;"></td>
						<td width="200px" style="border-style-bottom:solid;"></td>
						<td width="50px" style="border-style:hidden;"></td>
						<td colspan="3" width="200px" style="border-style-bottom:solid;"></td>
					</tr>
					<tr>
						<td align="center" style="border-style:hidden;text-align:center;">Issued By</td>
						<td style="border-style:hidden;"></td>
						<td align="center" style="border-style:hidden;text-align:center;">Delivered By</td>
						<td style="border-style:hidden;"></td>
						<td colspan="3" align="center" style="border-style:hidden;text-align:center;">Received By</td>
					</tr>
					<tr height="10px">
						<td colspan="7" style="border-style:hidden;"></td>
					</tr>
					<tr>
						<td style="border-style:hidden;"><!--Name:<span style="padding-left:4px;">__________________________--></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"><!--Name:<span style="padding-left:4px;">__________________________--></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Name</td>
						<td style="border-style:hidden;">:</td>
						<td style="border-style:hidden;"><u><?php echo $member_display['member_first_name'].' '.$member_display['member_last_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
					</tr>
					<tr height="10px">
						<td colspan="7" style="border-style:hidden;"></td>
					</tr>
					<tr>
						<!--<td style="border-style:hidden;">Date:<span class="space"></span><?php	//echo date("Y-m-d");	?></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Date:<span class="space"></span><?php	//echo date("Y-m-d");	?></td>
						<td style="border-style:hidden;"></td>-->
						<td colspan="4" rowspan="2" style="border-style:hidden;color:red;">PS: Please provide us all the details of delivery on the right column so that we can improve our services. Thank you.</td>
						<td style="border-style:hidden;">IC</td>
						<td style="border-style:hidden;">:</td>
						<td style="border-style:hidden;"><u><?php echo $member_display['member_ic']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
					</tr>
					<tr height="10px">
						<td colspan="7" style="border-style:hidden;"></td>
					</tr>
					<tr>
						<!--<td colspan="4" rowspan="2" style="border-style:hidden;color:red;">PS: Please provide us all the details of delivery on the right column so that we can improve our services. Thank you.</td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>-->
						<td colspan="4" style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Date&amp;Time</td>
						<td style="border-style:hidden;">:</td>
						<td style="border-style:hidden;">__________________________</td>
					</tr>
					<!--<tr height="10px">
						<td colspan="7" style="border-style:hidden;"></td>
					</tr>
					<tr>
						<td colspan="4" style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Time:<span style="padding-left:8px;">__________________________</td>
					</tr>-->
				</table>
			</div>
		</div>
	</body>
</html>