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
		<link rel="stylesheet" type="text/css" href="css/receipt_css.css">
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
		<img src="../images/blank2.png"/>
		<div id="outter">
			<div id="header">
				<img src="images/pbmart.png" alt="PBMart" width="80px" height="80px"/>
				<span id="title">PB MART SDN. BHD.</span>
				</br>
				<span id="address">
					NO. 15, LOT 628, JALAN KETITIR, BATU KAWA, 93250 KUCHING.
					</br>
					TELL: 082 688968<span class="tab"></span>FAX: 082 688653<span class="tab"></span>EMAIL:pbmartdelivery@gmail.com
				</span>
			</div>
			<div id="body">
				<table border="0" align="center" width="700px" height="100px" cellspacing="0" cellpadding="0">
					<tr>
						<th width="100px">Name</th>
						<th width="5px">:</th>
						<td width="300px"><?=$order_display['order_customer_name']?></td>
						<th width="75px">Phone No</th>
						<th width="5px">:</th>
						<td width="60px"><?=$order_display['order_customer_telephone']?></td>
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
						<?php	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
								$member_display = mysqli_fetch_assoc($member);
						?>
						<td width="300px"><?=$member_display['member_number']?></td>
						<th width="75px">Order Date</th>
						<th width="5px">:</th>
						<td width="60px"><?=$order_display['order_date']?></td>
					</tr>
					<tr>
						<th width="100px">Delivery Time</th>
						<th width="5px">:</th>
						<?php	if($order_display['order_time'] == 1){
									$deliver = "Morning (8-12)";
								}else if($order_display['order_time'] == 2){
									$deliver = "Afternoon (12-2)";
								}else if($order_display['order_time'] == 3){
									$deliver = "Immediately";
								}
						?>
						<td width="300px"><?=$deliver?></td>
						<th width="75px">Delivery Date</th>
						<th width="5px">:</th>
						<td width="60px"><?=$order_display['order_delivery']?></td>
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
					<tr>
					<?php	while($order_list_display = mysqli_fetch_array($order_list)){	?>
					<tr>
						<td width="30px" valign="top"><?=$order_list_display['order_product_amount']?></td>
						<td width="500px" valign="top"><?=$order_list_display['order_product_name']?></td>
						<td width="70px" valign="top" style="text-align:right;padding-right:12px;">
						<?php	$total	= 0;
								
								$total = $total + (($order_list_display['order_product_price'] + $order_list_display['order_product_handling']) * $order_list_display['order_product_amount']);
								$total_amount = $total_amount + $total;
								
								echo sprintf('%0.2f', $total);
								echo "</br>";
						?>
						</td>
					</tr>
					<?php	}	
							
							$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_list WHERE redemption_order_ref='$order_num'");
							
							while($redeem_display = mysqli_fetch_array($redeem)){
					?>
					<tr>
						<td width="30px" valign="top"><?=$redeem_display['redemption_amount']?></td>
						<td width="250px" valign="top"><?=$redeem_display['redemption_item']?></td>
						<?php	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='".$redeem_display['redemption_item_id']."'");
								$item_display = mysqli_fetch_assoc($item);
						?>
						<td width="250px" valign="top"><?=$item_display['redeem_model']?></td>
						<td width="70px" valign="top" style="text-align:right;padding-right:12px;">Redeem</td>
					</tr>
					<?php	}	?>
					<tr>
						<th colspan="2" style="text-align:right;">Total Amount (RM) : </th>
						<td width="70px" style="text-align:right;padding-right:12px;">
						<?php	echo sprintf('%0.2f', $total_amount);
						?>
						</td>
					</tr>
				</table>
			</div>
			<div id="signature">
				<table border="1px solid black" align="center" width="700px" cellpadding="0" cellpadding="0" style="border-style:hidden;">
					<tr>
						<td width="200px" style="border-style-bottom:solid;"></td>
						<td width="50px" style="border-style:hidden;"></td>
						<td width="200px" style="border-style-bottom:solid;"></td>
						<td width="50px" style="border-style:hidden;"></td>
						<td width="200px" style="border-style-bottom:solid;"></td>
					</tr>
					<tr>
						<td align="center" style="border-style:hidden;text-align:center;">Issued By</td>
						<td style="border-style:hidden;"></td>
						<td align="center" style="border-style:hidden;text-align:center;">Delivered By</td>
						<td style="border-style:hidden;"></td>
						<td align="center" style="border-style:hidden;text-align:center;">Received By</td>
					</tr>
					<tr>
						<td style="border-style:hidden;">Name:</td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Name:</td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Name:</td>
					</tr>
					<tr>
						<td style="border-style:hidden;">Date:</td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Date:</td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">IC:</td>
					</tr>
					<tr>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Date:</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>