<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$redeem_num = mysqli_real_escape_string($dbconnect, $_GET['re']);
	$redemption = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_list WHERE redemption_number='$redeem_num'");
	$redeem = mysqli_fetch_assoc($redemption);
	$member_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$member_id'");
	$member_display = mysqli_fetch_assoc($member);
	
	$redeem_point = 0;
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
		<div id="outter">
			<div id="header">
				<img src="images/pbmart.png" alt="PBMart" width="75px" height="75px"/>
				<span id="title">PB MART SDN. BHD. <span id="company">(CO.NO: 666387-H)</span></span>
				<span id="blank"></span>
				<span id="address">
					NO. 15, LOT 628, JALAN KETITIR, BATU KAWA, 93250 KUCHING.
					<span id="ref">
						Refer No. <?=$redeem_num?>
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
						<?php	if($member_display['member_commercial_status'] == 1){
									$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='$member_id'");
									$commercial_display = mysqli_fetch_assoc($commercial);
									$name = $commercial_display['commercial_company'];
								}else{
									$name = $member_display['member_last_name']." ".$member_display['member_first_name'];
								}						
						?>
						<td width="300px"><?=$name?></td>
						<th width="75px">Phone No</th>
						<th width="5px">:</th>
						<td width="60px"><?=$member_display['member_contact']?></td>
					</tr>
					<tr>
						<th width="100px">Address</th>
						<th width="5px">:</th>
						<td width="515px" colspan="4"><?=$redeem['redemption_member_address']?></td>
					</tr>
					<tr>
						<th width="100px">Order Number</th>
						<th width="5px">:</th>
						<td width="300px">
							<?php	if($redeem['redemption_order_ref'] == ""){
										echo "-";
									}else{
										echo $redeem['redemption_order_ref'];
									}
							?>
						<th width="75px">Date</th>
						<th width="5px">:</th>
						<td width="60px"><?php	echo date('Y-m-d');	?></td>
					</tr>
					<tr>
						<th width="100px">Member Number</th>
						<th width="5px">:</th>
						<?php	if($member_display['member_commercial_status'] == 1){
									$mem_number = $commercial_display['commercial_number'];
								}else{
									$mem_number = $member_display['member_number'];
								}
						?>
						<td width="300px"><?=$mem_number?></td>
						</td>
						<th width="75px">Redeem Date</th>
						<th width="5px">:</th>
						<td width="60px"><?=$redeem['redemption_date']?></td>
					</tr>
					<tr>
						<th width="100px">Points Balance</th>
						<th width="5px">:</th>
						<td width="300px"><?=$member_display['member_point']?></td>
						<th width="75px">Delivery Date</th>
						<th width="5px">:</th>
						<td width="60px"><?=$redeem['redemption_delivery_date']?></td>
					</tr>
				</table>
			</div>
			<div id="content">
				<table border="1" align="center" width="680px" height="20px" cellspacing="0" cellpadding="0" id="item">
					<tr height="20px">
						<th width="30px">Qty</th>
						<th width="500px">Items</th>
						<th width="70px" style="text-align:center;">Points</th>
					</tr>
					<?php	mysqli_data_seek($redemption,0);
							while($redeem_display = mysqli_fetch_array($redemption)){
					?>
					<tr>
						<td width="30px" valign="top"><?=$redeem_display['redemption_amount']?></td>
						<td width="250px" valign="top"><?=$redeem_display['redemption_item']?></td>
						<?php	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='".$redeem_display['redemption_item_id']."'");
								$item_display = mysqli_fetch_assoc($item);
								$redeem_point = $redeem_point + $redeem_display['redemption_points'];
						?>
						<td width="70px" valign="top" style="text-align:right;padding-right:12px;"><?=$redeem_display['redemption_points']?></td>
					</tr>
					<?php	}	?>
					<tr>
						<th colspan="2" style="text-align:right;padding-right:4px;">Total Points :  </th>
						<td width="70px" style="text-align:right;padding-right:12px;"><?=$redeem_point?></td>
					</tr>
				</table>
			</div>
			<div>
				<table border="0" align="center" width="700px" cellpadding="0" cellspacing="0" style="border-style:hidden;margin-bottom:10px;">
					<tr>
						<td colspan="6" style="font-size:10pt;">By signing this receipt, I acknowledge that I had redeemed the above item(s) with my PB points.</td>
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
		</div>
	</body>
</html>