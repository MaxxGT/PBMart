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
	</head>
	<body>
		<img src="../images/blank2.png"/>
		<div id="outter">
			<div id="header">
				<img src="images/pbmart.png" alt="PBMart" width="150px" height="150px"/>
				<span id="title">PB MART Sdn. Bhd.</span>
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
						<th width="125px">Name</th>
						<th width="5px">:</th>
						<td width="250px"><?=$order_display['order_customer_name']?></td>
						<th width="105px">Phone No</th>
						<th width="5px">:</th>
						<td width="150px"><?=$order_display['order_customer_telephone']?></td>
					</tr>
					<tr>
						<th width="125px">Address</th>
						<th width="5px">:</th>
						<td width="515px" colspan="4"><?=$order_display['order_customer_address']?></td>
					</tr>
					<tr>
						<th width="125px">Order Number</th>
						<th width="5px">:</th>
						<td width="250px"><?=$order_num?></td>
						<th width="105px">Date</th>
						<th width="5px">:</th>
						<td width="150px"><?php	echo date("Y-m-d");	?></td>
					</tr>
					<tr>
						<th width="125px">Member Number</th>
						<th width="5px">:</th>
						<?php	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$order_display['order_customer_id']."'");
								$member_display = mysqli_fetch_assoc($member);
						?>
						<td width="250px"><?=$member_display['member_number']?></td>
						<th width="105px">Order Date</th>
						<th width="5px">:</th>
						<td width="150px"><?=$order_display['order_date']?></td>
					</tr>
					<tr>
						<th width="125px">Delivery Time</th>
						<th width="5px">:</th>
						<?php	if($order_display['order_time'] == 2){
									$deliver = "Morning (8-12)";
								}else if($order_display['order_time'] == 1){
									$deliver = "Afternoon (12-2)";
								}else if($order_display['order_time'] == 3){
									$deliver = "Immediately";
								}
						?>
						<td width="250px"><?=$deliver?></td>
						<th width="105px">Delivery Date</th>
						<th width="5px">:</th>
						<td width="150px"><?=$order_display['order_delivery']?></td>
					</tr>
				</table>
			</div>
			<div id="content">
				<?php	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_num'");
				?>
				<table border="1" align="center" width="700px" height="20px" cellspacing="0" cellpadding="0">
					<tr height="30px">
						<th width="80px">Quantity</th>
						<th width="200px">Items</th>
						<th width="300px">Description</th>
						<th width="70px">Sub Total</th>
					<tr>
					<?php	while($order_list_display = mysqli_fetch_array($order_list)){	?>
					<tr>
						<td width="80px" valign="top"><?=$order_list_display['order_product_amount']?></td>
						<td width="200px" valign="top"><?=$order_list_display['order_product_name']?></td>
						<td width="300px" valign="top">
						<?php	$desc = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_list_display['order_product_id']."'");
								$desc_display = mysqli_fetch_assoc($desc);
								echo $desc_display['product_description'];
						?>
						</td>
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
						<td width="80px" valign="top"><?=$redeem_display['redemption_amount']?></td>
						<td width="200px" valign="top"><?=$redeem_display['redemption_item']?></td>
						<?php	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='".$redeem_display['redemption_item_id']."'");
								$item_display = mysqli_fetch_assoc($item);
						?>
						<td width="300px" valign="top"><?=$item_display['redeem_description']?></td>
						<td width="70px" valign="top" style="text-align:right;padding-right:12px;">Redeem</td>
					</tr>
					<?php	}	?>
					<tr>
						<th colspan="3">Total Amount (RM) :</th>
						<td width="70px" style="text-align:right;padding-right:12px;">
						<?php	echo sprintf('%0.2f', $total_amount);
						?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>