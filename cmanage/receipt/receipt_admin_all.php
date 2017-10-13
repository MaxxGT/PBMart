<?php
	//Last Update: 26-10-2016
	
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	$iCount = $_POST['iCount'];
	$or_no = "";
	$xi='1';
	for($x='1'; $x<$iCount; $x++)
	{
		if(isset($_POST['btnchk'][$x]))
		{
			$btnchk = $_POST['btnchk'][$x];
			if($xi !='1')
			{
				$or_no .=' OR ';
				
			}
			$or_no .="order_number = '".$btnchk."'";
			$xi++;
		}
	}
	
	$total_amount = 0;
	$today_date = '2016-12-29';
	
	if($or_no !='')
	{
		$sql_today_order= "SELECT * FROM pbmart_order WHERE order_delivery = '$today_date' AND order_status='0' AND $or_no";
	}else
	{	
		$sql_today_order= "SELECT * FROM pbmart_order WHERE order_delivery = '$today_date'" ;
	}
	
	
	$rs_today_order = @mysql_query($sql_today_order, $link);
	
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
		<?php
			while($rw_today_order = @mysql_fetch_array($rs_today_order))
			{
				$order_num = $rw_today_order['order_number'];				
		?>
		
		
		<div id="outter">
			<div id="header">
				<img src="images/pbmart.png" alt="PBMart" width="75px" height="75px"/>
				<span id="title">PB MART SDN. BHD. <span id="company">(CO.NO: 666387-H)</span></span>
				<span id="blank"></span>
				<span id="address">
					NO. 15, LOT 628, JALAN KETITIR, BATU KAWA, 93250 KUCHING.
					<span id="ref">
						Refer No 1. _________________
					</span>
					</br>
					TELL: 082 688968<span class="tab"></span>FAX: 082 688653<span class="tab"></span>EMAIL: sales@pbmart.com.my
				</span>
			</div>
			<div>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span id="ref">	
				Refer No 2. _________________
				</span>
			</div>
			<div id="body">
				<table border="0" align="center" width="700px" cellspacing="0" cellpadding="0">
					<tr>
						<th width="100px">Name</th>
						<th width="5px">:</th>
						<?php	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$rw_today_order['order_customer_id']."'");
								$member_display = mysqli_fetch_assoc($member);
								
								if($member_display['member_commercial_status'] == 1){
									$colspan='4';
									$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='".$member_display['member_id']."'");
									$commercial_display = mysqli_fetch_assoc($commercial);
									
									$customer_name = $commercial_display['commercial_company'];
									$member_num = $commercial_display['commercial_number'];
								}else{
									$colspan='2';
									$customer_name = $rw_today_order['order_customer_name'];
									$member_num = $member_display['member_number'];
								}
						?>
						<td width='300px'><?=$customer_name?></td>
						<th width="75px">Order No</th>
						<th width="5px">:</th>
						<td><?=$rw_today_order['order_number']?></td>
					</tr>
					<tr>
						<th width="100px">Phone Number</th>
						<th width="5px">:</th>
						<td width="300px"><?=$rw_today_order['order_customer_contact']?></td>
						<th width="75px">Date</th>
						<th width="5px">:</th>
						<td><?php	echo date("d-m-Y");	?></td>
					</tr>
					<tr>
						<th width="100px">Member Number</th>
						<th width="5px">:</th>
						<td width="300px"><?=$member_num?></td>
						<th width="75px">Order Date</th>
						<th width="5px">:</th>
						<?php
						$originalDate = $rw_today_order['order_date'];
						$newDate = date("d-m-Y", strtotime($originalDate));
						?>
						<td><?=$newDate?></td>
					</tr>
					<tr>
						<th width="100px" style="background-color:white;">Point Balance</th>
						<th width="5px" style="background-color:white;">:</th>
						<td width="300px"><?=$member_display['member_point']?></td>
						
						
						<th width="75px">Delivery Date</th>
						<th width="5px">:</th>
						<?php
						$originalDate = $rw_today_order['order_delivery'];
						$order_delivery = date("d-m-Y", strtotime($originalDate));
						if($rw_today_order['order_time'] == 2){
									$deliver = "(8-12) Noon";
								}else if($rw_today_order['order_time'] == 1){
									$deliver = "(12-4PM)";
								}else if($rw_today_order['order_time'] == 3){
									$deliver = "Immediately";
								}
						?>
						<td><?=$order_delivery.' '.$deliver?></td>
					</tr>
					
					<tr>
						
					</tr>
					<tr>
						<th width="100px">Address</th>
						<th width="5px">:</th>
						<td width="515px" colspan="4"><?=$rw_today_order['order_customer_address']?></td>
					</tr>
					<tr>
						<th width="100px">Remark</th>
						<th width="5px">:</th>
						<td width="515px" colspan="4"><?=$rw_today_order['order_remark']?></td>
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
						<?php if($member_display['member_commercial_status'] == 1)
						{ ?>
						<th width="70px" align='center'>MYGAZ</th>
						<th width="70px" align='center'>PETRONAS</th>
						<?php } ?>
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
									if($member_display['member_commercial_status'] == 1)
									{
										echo "<td width='70px' valign='top' style='text-align:center;padding-right:12px;'>".$rw_today_order['order_mygaz_amount']."</td>";
										echo "<td width='70px' align='center' style='text-align:center;padding-right:12px;'>".$rw_today_order['order_petronas_amount']."</td>";
									}
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
								echo "<td colspan='3' style='text-align:right;padding-right:12px;'>Redemption</td>";
								echo "</tr>";
							}
					?>
					<tr>
						<th colspan="<?php echo $colspan; ?>" style="text-align:right;">Total Amount (RM) : </th>
						<td width="70px" style="text-align:right;padding-right:12px;">
						<?php	echo sprintf('%0.2f', $total_amount);
						?>
						</td>
					</tr>
					<tr>
						<th colspan="<?php echo $colspan; ?>" style="text-align:right;">Point Rewards : </th>
						<td width="70px" style="text-align:right;padding-right:12px;"><?=$rw_today_order['order_total_point']?></td>
					</tr>
				</table>
			</div>
			<div id="signature">
				<table border="1px solid black" align="center" width="700px" cellpadding="0" cellspacing="0" style="border-style:hidden;">
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
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Name</td>
						<td style="border-style:hidden;">:</td>
						<td style="border-style:hidden;">__________________________</td>
					</tr>
					<tr height="10px">
						<td colspan="7" style="border-style:hidden;"></td>
					</tr>
					<tr>
						<td colspan="4" rowspan="2" style="border-style:hidden;color:red;">PS: Please provide us all the details of delivery on the right column so that we can improve our services. Thank you.</td>
						<td style="border-style:hidden;">IC</td>
						<td style="border-style:hidden;">:</td>
						<td style="border-style:hidden;">__________________________</td>
					</tr>
					<tr height="10px">
						<td colspan="7" style="border-style:hidden;"></td>
					</tr>
					<tr>
						<td colspan="4" style="border-style:hidden;"></td>
						<td style="border-style:hidden;">Date&amp;Time</td>
						<td style="border-style:hidden;">:</td>
						<td style="border-style:hidden;">__________________________</td>
					</tr>
				</table>
			</div>
				<table>
					<tr>
						<td></td>
					</tr>
				</table>
		</div>
			<?php } ?>
	</body>
</html>