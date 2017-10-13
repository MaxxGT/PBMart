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
	
	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='$order_num'");
	
	$redemption = mysqli_query($dbconnect , "SELECT * FROM pbmart_redemption_list WHERE redemption_order_ref='$order_num'");
	$re_row = mysqli_num_rows($redemption);
	$no = 1;
	
	if(isset($_GET['view'])){
		$view = mysqli_real_escape_string($dbconnect, $_GET['view']);
	}
	
	if($view == "his"){
		$history = "class='current'";
		$order = "";
	}else{
		$history = "";
		$order = "class='current'";
	}
	
	$sub_total1 = 0;
?>

<html>
	<head>
        <title>Order Details</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
		
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
		<script src="../js/datepicker/datetimepicker_css.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		<?php
			include('../header/header.php');
		?>
		
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="view_order.php" <?=$order?>><span>Orders</span></a></li>  
						<li><a href="make_order.php"><span>Place Manual Order</span></a></li>
						<li><a href="order_history.php" <?=$history?>><span>Order History</span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		<div class="grid_16" id="content">	
			<br />						
			<br />
			<br />
			
			<table border="0" align="center" width="938px" height="600px" cellpadding="0" cellspacing="0" >
				<tr align="center">
					<td valign="top">
						<table border="1" width="600px" height="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
							<tr>
								<th align="center">Order Receipt</th>
							</tr>
							<?php	if($view == "his"){?>
										<tr>
											<td>
												<form action="completion_date.php" method="POST">
													<table width="600px" height="10px">
														<tr>
															<th style="text-align:left;padding-left:12px;"><label>Status:</label></th>
															<td>
																<?php	if(!isset($_GET['comp'])){
																		}else{
																			$comp_date = mysqli_real_escape_string($dbconnect, $_GET['comp']);
																									
																			if($comp_date == "true"){
																				echo "<span style='color:green'>Completion date successfully saved.</span>";
																			}else if($comp_date == "false"){
																				echo "<span style='color:red;'>Completion date could not save! Please try again later.</span>";
																			}
																		}
																?>
															</td>
														</tr>
														<tr>
															<th style="text-align:left;padding-left:12px;"><label>Complete Date:</label></th>
															<td><input type="text" name="complete_date" id="complete_date" value="<?=$order_display['order_complete_date']?>" onclick="javascript:NewCssCal('complete_date','yyyyMMdd','arrow')" style="cursor:pointer;width:200px;"/></td>
														</tr>
														<tr>
															<th style="text-align:left;padding-left:12px;"><label>Remark:</label></th>
															<td>
																<textarea name="remarks" rows="8" cols="40"><?=$order_display['order_remark']?></textarea>
															</td>
														</tr>
														<tr>
															<th colspan="2">
																<input type="submit"/>
																<input type="hidden" name="order_numbering" value="<?=$order_num?>"/>
															</th>
														</tr>
													</table>
												</form>
											</td>
										</tr>
							<?php	}	?>
							<tr>
								<td valign="top" height="150px">
									<table border="0" width="600px" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<th colspan="4">Customer Details</th>
										</tr>
										<tr>
											<?php	if($order_display['order_status'] == '1'){
														echo "<div id='complete'>";
														echo "<img src='../images/completed.png' width='600px' height='600px'/>";
														echo "</div>";
													}else if($order_display['order_status'] == '2'){
														echo "<div id='complete'>";
														echo "<img src='../images/cancelled.png' width='600px' height='600px'/>";
														echo "</div>";
													}else if($order_display['order_status'] == '3'){
														echo "<div id='complete'>";
														echo "<img src='../images/refunded.png' width='600px' height='600px'/>";
														echo "</div>";
													}
											?>
											<th width="130px" style="padding-left:5;padding-top:5;">Customer Name : </th>
											<td width="180px" style="padding-left:5;padding-top:5;"><?=$order_display['order_customer_name']?></td>
											<th width="100px" style="padding-left:5;padding-top:5;">Order Number : </th>
											<td width="100px" style="padding-left:5;padding-top:5;"><?=$order_display['order_number']?></td>
										</tr>
										<tr>
											<th width="130px" style="padding-left:5;padding-top:5;">Mobile Phone : </th>
											<td width="180px" style="padding-left:5;padding-top:5;"><?=$order_display['order_customer_contact']?></td>
											<th width="110px" style="padding-left:5;padding-top:5;">Order Date : </th>
											<td width="100px" style="padding-left:5;padding-top:5;"><?=$order_display['order_date']?></td>
										</tr>
										<tr>
											<th valign="top" width="130px" style="padding-left:5;padding-top:5;">Payment Method : </th>
											<td valign="top" width="100px" style="padding-left:5;padding-top:5;"><?=$order_display['order_payment_type']?></td>
											<th width="110px" style="padding-left:5;padding-top:5;">Delivery Date : </th>
											<td width="100px" style="padding-left:5;padding-top:5;"><?=$order_display['order_delivery']?></td>
										</tr>
										<tr>
											<th valign="top" width="130px" style="padding-left:5;padding-top:5;">Address : </th>
											<td colspan="3" style="padding-left:5;padding-top:5;"><?=$order_display['order_customer_address']?></td>
										</tr>
										<tr>
											<th valign="top" width="130px" style="padding-left:5;padding-top:5;">Remark : </th>
											<td colspan="3" style="padding-left:5;padding-top:5;"><?=$order_display['order_remark']?></td>
										</tr>
									</table>
									
									
								</td>
							</tr>
							<tr>
								<td valign="top" height="420px">
									<table border="0" width="600px" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<th colspan="5">Ordered Items</th>
										</tr>
										<tr>
											<th width="20px" style="padding-left:5;">No.</th>
											<th width="380px" style="padding-left:5;">Product Name</th>
											<th width="60px" style="padding-left:5;">Price (RM)</th>
											<th width="60px" style="padding-left:5;">Unit(s)</th>
											<th width="80px" style="padding-left:5;">Sub Total (RM)</th>
										</tr>
										<?php	while($order_list_display = mysqli_fetch_array($order_list)){	?>
											<tr>
												<td width="20px" style="padding-left:5;"><?=$no?>. </td>
												<td width="380px" style="padding-left:5;"><?=$order_list_display['order_product_name']?></td>
												<td width="60px" style="padding-left:5;text-align:center;" align="right">
													<?php	$price = sprintf('%0.2f', $order_list_display['order_product_price']);
													echo $price;	?>
												</td>
												<td width="60px" style="padding-left:5;text-align:center;" align="right"><?=$order_list_display['order_product_amount']?></td>
												<?php	$total = $order_list_display['order_product_price'] * $order_list_display['order_product_amount'];
														$sub_total = $total - (($total * $order_list_display['order_product_sale']) / 100);	
														$sub_total = sprintf('%0.2f', $sub_total);?>
												<td width="80px" style="padding-left:5;text-align:center;" align="right"><?=$sub_total?></td>
											</tr>
										<?php	$no++;
												$sub_total1 = $sub_total1 + $sub_total;
												$sub_total1 = sprintf('%0.2f', $sub_total1);
												}	?>
									</table>
								</td>
							</tr>
							<tr>
								<td height="30px">
									<table border="0" width="600px" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<th width="350px" style="padding-left:5;" align="left">Exchange of Cylinder :</th>
											<td width="50px" style="padding-left:5;" align="right">MYGAZ <?=$order_display['order_mygaz_amount']?></td>
											<td width="50px" style="padding-left:5;" align="right">PETRONAS <?=$order_display['order_petronas_amount']?></td>
										</tr>
										<tr>
											<th colspan='2' width="570px" style="padding-left:5;" align="left">Sub Amount (RM) :</th>
											<td width="30px" style="padding-left:5;" align="right"><?=$sub_total1?></td>
										</tr>
										<tr>
											<th colspan='2'width="570px" style="padding-left:5;" align="left">Total Handling (RM) : </th>
											<td width="30px" style="padding-left:5;" align="right"><?=$order_display['order_handling']?></td>
										</tr>
										<tr>
											<th colspan='2' width="570px" style="padding-left:5;" align="left">Total Amount (RM) : </th>
											<td width="30px" style="padding-left:5;" align="right"><?=$order_display['order_amount']?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<th>
									</br>
									<input type="button" onClick="goBack();" value="Back"/>
									<input type="hidden" id="view" value="<?=$view?>"/>
									<input type="hidden" id="mem" value="<?=$order_display['order_customer_id']?>"/>
									<a href="../receipt/receipt_admin.php?or=<?=$order_display['order_number']?>" target="blank"><input type="button" onClick="printReceipt();" value="Receipt"/></a>
								</th>
							</tr>
						</table>
						</br>
						</br>
						</br>
						<?php	if($re_row){	
									echo "<table border='1' width='638px' height='150px' align='center' cellpadding='0' cellspacing='0' class='box-table-a'>";
									echo "<tr>";
									echo "<th align='center'>Redemption Item</th>";
									echo "</tr>";
									echo "<tr>";
									echo "<td>";
									echo "<table border='1' width='600px' height='50px' class='box-table-a' cellpadding='0' cellspacing='0'>";
									echo "<tr>";
									echo "<th width='100px'>Re. Number : </th>";
									echo "<th width='300px'>Redemption Item : </th>";
									echo "<th width='80px'>Unit(s) : </th>";
									echo "</tr>";
										while($redeem_display = mysqli_fetch_array($redemption)){
									echo "<tr class='link' href='../receipt/redemption_receipt.php?re=".$redeem_display['redemption_number']."&mem=".$order_display['order_customer_id']."'>";
									echo "<td>".$redeem_display['redemption_number']."</td>";
									echo "<td>".$redeem_display['redemption_item']."</td>";
									echo "<td>".$redeem_display['redemption_amount']."</td>";
									echo "</tr>";
										}
									echo "</table>";
									echo "</td>";
									echo "</tr>";
									echo "</table>";
								}else{
									echo "<strong>**There is no redemption for this order**</strong>";
								}
						?>
					</td>
				</tr>
			</table>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
				<?php
					include('../footer.php');
				?>

		</div>
	</body>
	
	<script>
		$(document).ready(function(){
			$('.link').click(function(){
				window.location = $(this).attr('href');
				return false;
			});
		});
	
		function goBack(){
			var confirmBack = confirm("Do you wish to go back?");
			
			if(confirmBack){
				var view = document.getElementById('view').value;
				var mem = document.getElementById('mem').value;
				
				if(view == "or"){
					window.location = "view_order.php?hyperlink=orders";
				}else if(view == "his"){
					window.location = "order_history.php?hyperlink=orders";
				}else if(view == "ma"){
					window.location = "../main.php";
				}else if(view == "mem"){
					window.location = "../member/edit_member.php?mem=" +mem+"&hyperlink=members";
				}
			}
		}
	</script>
</html>