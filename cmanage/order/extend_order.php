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
	
	$no = 1;
	$sub_total1 = 0;
?>

<html>
	<head>
        <title>Edit Order</title>
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
						  <li><a href="view_order.php" class="current"><span>Order</span></a></li>   
						  <li><a href="make_order.php"><span>Place Manual Order</span></a></li>
						  <li><a href="order_history.php"><span>Order History</span></a></li>
			   </ul>
			</div>
		</div>
		<!-- TABS END -->    
	</div>
		
	<div class="grid_16" id="content">	
	<br />						
	<br />
	<br />
	
		
	<form action="extend_order_date.php" method="POST">
		<table border="0" align="center" width="938px" height="600px" cellpadding="0" cellspacing="0" >
		
			<tr align="center">
				<td valign="top">
					
					<table border="1" width="600px" height="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
						<tr>
							<th align="center">Extend Order</th>
						</tr>
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
										<td width="100px" style="padding-left:5;padding-top:5;"><input type="text" name="new_date" id="new_date" value="<?=$order_display['order_delivery']?>" onclick="javascript:NewCssCal('new_date','yyyyMMdd','arrow')" style="cursor:pointer;width:100px;"/></td>
									</tr>
									<tr>
										<th valign="top" width="130px" style="padding-left:5;padding-top:5;">Address : </th>
										<td colspan="3" style="padding-left:5;padding-top:5;"><textarea name='order_customer_address' id='order_customer_address' cols='59' rows='3'><?=$order_display['order_customer_address']?></textarea></td>
									</tr>
									<tr>
										<th valign="top" width="130px" style="padding-left:5;padding-top:5;">Remark : </th>
										<td colspan="3" style="padding-left:5;padding-top:5;"><textarea name='order_remark' id='order_remark' cols='59' rows='3'><?=$order_display['order_remark']?></textarea></td>
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
											<td width="60px" style="padding-left:5;text-align:center;"><?=$order_list_display['order_product_price']?></td>
											<td width="60px" style="padding-left:5;text-align:center;">
												<input type="number" name="order_amount[]" value="<?=$order_list_display['order_product_amount']?>" style="width:40px;" disabled />
												<input type="hidden" name="order_id[]" value="<?=$order_list_display['order_id']?>"/>
												<input type="hidden" name="order_product_id[]" value="<?=$order_list_display['order_product_id']?>"/>
												
											</td>
											<?php	$total = $order_list_display['order_product_price'] * $order_list_display['order_product_amount'];
													$sub_total = $total - (($total * $order_list_display['order_product_sale']) / 100);	?>
											<td width="80px" style="padding-left:5;text-align:center;"><?=$sub_total?></td>
										</tr>
									<?php	$no++;
											$sub_total1 = $sub_total1 + $sub_total;
											$sub_total1 = sprintf('%0.2f', $sub_total1);
											}	?>
										<tr>
											<td colspan="5" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;">
												<input type="checkbox" name="edit_order" id="edit_order" onChange="toggle_edit();"/>Edit order
											</td>
										</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="30px">
								<table border="0" width="600px" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<th width="350px" style="padding-left:5;" align="left">Exchange of Cylinder :</th>
										<td width="70px" style="padding-left:5;" align="center">MYGAZ 
											<input type="number" name="order_mygaz_amount" value="<?=$order_display['order_mygaz_amount']?>" style="width:40px;" disabled />
										</td>
										<td width="70px" style="padding-left:5;" align="center">PETRONAS
											<input type="number" name="order_petronas_amount" value="<?=$order_display['order_petronas_amount']?>" style="width:40px;" disabled />
										</td>
									</tr>
									<tr>
										<th colspan='2' width="540px" style="padding-left:5;" align="left">Sub Amount (RM) :</th>
										<td width="60px" style="padding-left:5;" align="right"><?=$sub_total1?></td>
									</tr>
									<tr>
										<th colspan='2' width="540px" style="padding-left:5;" align="left">Total Handling (RM) : </th>
										<td width="60px" style="padding-left:5;" align="right"><?=$order_display['order_handling']?></td>
									</tr>
									<tr>
										<th colspan='2' width="540px" style="padding-left:5;">Total Amount (RM) : </th>
										<td width="60px" style="padding-left:5;" align="right"><?=$order_display['order_amount']?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<th align="left" style="border-style:hidden;text-align:center;">
								<input type="submit" onClick="return extend();" value="Edit" style="width:100px;height:30px;"/><input type="hidden" name="id" value="<?=$order_num?>"/>
							</th>
						</tr>
						<tr>
							<th style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;">
								</br>
								<input type="button" onClick="goBack();" value="Back"/><input type="hidden" id="view" value="<?=$view?>"/>
							</th>
						</tr>
					</table>
					</br>
				</td>
			</tr>
		</table>
	</form>
			<?php
				include('../footer.php');
			?>
			
	</div>	
		<script>
			$(document).ready(function () {
				$( "#new_date" ).datepicker({
					changeMonth: true,
					changeYear: true 
				});
			});
			
			function extend(){
				var confirmExtend = confirm("Do you wish to edit the order?");
					
				if(confirmExtend){
					return true;
				}else{
					return false;
				}
			}
			
			function goBack(){
				var confirmBack = confirm("Do you wish to go back?");
				
				if(confirmBack){
					window.location = "view_order.php?hyperlink=orders";
				}
			}
			
			function toggle_edit(){
				var or_amount = document.getElementsByName('order_amount[]');
				var or_mygaz_amount = document.getElementsByName('order_mygaz_amount');
				var or_petronas_amount = document.getElementsByName('order_petronas_amount');
				
				if(document.getElementById('edit_order').checked == true){
					for(var i = 0; i < or_amount.length; i++){
						or_amount[i].disabled = false;
						or_mygaz_amount[i].disabled = false;
						or_petronas_amount[i].disabled = false;
					}
				}else{
					for(var i = 0; i < or_amount.length; i++){
						or_amount[i].disabled = true;
						or_mygaz_amount[i].disabled = true;
						or_petronas_amount[i].disabled = true;
					}
				}
			}
		</script>
	</body>
</html>