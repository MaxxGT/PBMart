<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	function get_currentDateTime()
	{
		date_default_timezone_set('Asia/Kuching'); // CDT

		$crt_date = new DateTime();
		
		$info = getdate();
		$date = $info['mday'];
		$month = $info['mon'];
		$year = $info['year'];
		$hour = $info['hours'];
		$min = $info['minutes'];
		$sec = $info['seconds'];

		$crt_date->setDate($year, $month, $date);
		
		$current_date = $crt_date->format('Y-m-d');
		return $current_date;
	}

$crnt_date = get_currentDateTime();
	
	if(isset($_GET['mem'])){
		$mem_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
		$member_display = mysqli_fetch_assoc($member);
		
		/*if($member_display['member_telephone'] == "-"){
			$telephone = "";
		}else{
			$telephone = $member_display['member_telephone'];
		}*/
		
		if($member_display['member_contact'] == "-"){
			$contact = "";
		}else{
			$contact = $member_display['member_contact'];
		}
		
		$mem = true;
	}else{
		$mem = false;
	}
	$cart_no = 1;
	$total_amount = 0;
	$total_mygaz = 0;
	$total_petronas = 0;
	$total_handling = 0;
	$cart = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin_cart");
?>

<html>
	<head>
		<title>Proceed Checkout</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/menu.css" />
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
						<li><a href="view_order.php" class="current"><span>Orders</span></a></li>  
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
		
		<form action="checkout.php" method="POST">
			<table border="1" align="center" width="620px" height="250px" cellpadding="0" cellspacing="0" class="box-table-b">
				<tr>
					<td align="center">
						<table border="0" width="600px" height="300px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
							<tr>
								<th colspan="2" align="center">Order Delivery Info</th>
							</tr>
							<tr>
								<th onClick="nonExist();"><input type="button" style="width:310px;" value="Non registered member" disabled/></th>
								<th onClick="exist();"><input type="button" style="width:310px;" value="Registered member"/></th>
							</tr>
							<tr>
								<th>Order Status</th>
								<td align="center">
								<?php	if(!isset($_GET['order'])){
										}else{
											$create_order = mysqli_real_escape_string($dbconnect, $_GET['order']);
																
											if($create_order == "false"){
												echo "<span>Order could not save into database! Please try again later.</span>";
											}else if($create_order == "empty"){
												echo "<span>Please fill in all compulsory field(s) before create!</span>";
											}
										}
								?>
								</td>
							</tr>
							<?php	if($mem){
										echo "<tr>";
										echo "<th width='150px'><label for='first_name'><span class='compulsory'>*</span>First Name : </label></th>";
										echo "<td><input type='text' id='first_name' name='first_name' value='".$member_display['member_first_name']."' /></td>";
										echo "<input type='hidden' name='member_id' value='".$member_display['member_id']."'";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='last_name'><span class='compulsory'>*</span>Last Name : </label></th>";
										echo "<td><input type='text' id='last_name' name='last_name' value='".$member_display['member_last_name']."' /></td>";
										echo "</tr>";
														
										/*echo "<tr>";
										echo "<th style='padding-left:12;' width='150px'><label for='telephone'>Telephone : </label></th>";
										echo "<td><input type='tel' pattern='[0-9]{3}-[0-9]*|[0-9]*' id='telephone' name='telephone' value='".$telephone."' /></td>";
										echo "<tr>";*/
														
										echo "<tr>";
										echo "<th style='padding-left:12;' width='150px'><label for='contact'>contact Number : </label></th>";
										echo "<td><input type='tel' pattern='[0-9]{3}-[0-9]*|[0-9]*' id='contact' name='contact' value='".$contact."' /></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='street_name'><span class='compulsory'>*</span>Street Name : </label></th>";
										echo "<td style='padding-left:8;'><textarea id='street_name' name='street_name' rows='3'cols='50'>".$member_display['member_street_name']."</textarea></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='postcode'><span class='compulsory'>*</span>Postcode : </label></th>";
										echo "<td><input type='text' pattern='[0-9]*' id='postcode' name='postcode' value='".$member_display['member_postcode']."' /></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='city'><span class='compulsory'>*</span>City : </label></th>";
										echo "<td><input type='text' id='city' name='city' value='".$member_display['member_city']."' /></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='state'><span class='compulsory'>*</span>State : </label></th>";
										echo "<td><input type='text' id='state' name='state' value='".$member_display['member_state']."' /></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='country'><span class='compulsory'>*</span>Country : </label></th>";
										echo "<td><input type='text' id='country' name='country' value='".$member_display['member_country']."' /></td>";
										echo "</tr>";
									}else{
										echo "<tr>";
										echo "<th width='150px'><label for='first_name'><span class='compulsory'>*</span>First Name : </label></th>";
										echo "<td><input type='text' id='first_name' name='first_name' /></td>";
										echo "<input type='hidden' name='member_id' value=''";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='last_name'><span class='compulsory'>*</span>Last Name : </label></th>";
										echo "<td><input type='text' id='last_name' name='last_name' /></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th style='padding-left:12;' width='150px'><label for='contact'>contact Number : </label></th>";
										echo "<td><input type='tel' pattern='[0-9]{3}-[0-9]*|[0-9]*' id='contact' name='contact' /></td>";
										echo "</tr>";
														
										/*echo "<tr>";
										echo "<th style='padding-left:12;' width='150px'><label for='mobile'>Mobile Phone : </label></th>";
										echo "<td><input type='tel' pattern='[0-9]{3}-[0-9]*|[0-9]*' id='mobile' name='mobile' /></td>";
										echo "</tr>";*/
														
										echo "<tr>";
										echo "<th width='150px'><label for='street_name'><span class='compulsory'>*</span>Street Name : </label></th>";
										echo "<td style='padding-left:8;'><textarea id='street_name' name='street_name' rows='3' cols='50'></textarea></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='postcode'><span class='compulsory'>*</span>Postcode : </label></th>";
										echo "<td><input type='text' pattern='[0-9]*' id='postcode' name='postcode'/></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='city'><span class='compulsory'>*</span>City : </label></th>";
										echo "<td><input type='text' id='city' name='city' value='Kuching'/></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='state'><span class='compulsory'>*</span>State : </label></th>";
										echo "<td><input type='text' id='state' name='state' value='Sarawak'/></td>";
										echo "</tr>";
														
										echo "<tr>";
										echo "<th width='150px'><label for='country'><span class='compulsory'>*</span>Country : </label></th>";
										echo "<td><input type='text' id='country' name='country' value='Malaysia'/></td>";
										echo "</tr>";
									}
							?>
							<tr>
								<th width='150px'><label for='delivery'><span class='compulsory'>*</span>Delivery : </label></th>
								<td>
									<input type="text" id="delivery" name="delivery" onclick="javascript:NewCssCal('delivery','yyyyMMdd','arrow')" style="cursor:pointer" value="<?php echo $crnt_date; ?>" autofocus />
								</td>
							</tr>
							<tr>
								<th width="150px"><label for="time"><span class='compulsory'>*</span>Preference time : </label></th>
								<td>
									<select id="preferance_time" name="preferance_time">
										<option value="2">Morning (8-12)</option>
										<option value="1">Afternoon (12-4)</option>
										<option value="3">Immediately</option>
									</select>
								</td>
							</tr>
						</table>
										
										<table border="0" align="center" id="item_cart" cellpadding="0" cellspacing="0">
											<tr>
												<td align="left" bgcolor="yellow"><span class="tittle"><h1><B>SHOPPING CART</B></h1></span></td>
											</tr>
											<tr>
												<td colspan='2' align="left">
													<table border="0" width="600px" cellpadding="0" cellspacing="0">
														<thead>
															<tr height='30px'>
																<td width="400px" style="padding-left:5;padding-top:5;">Product</td>
																<td width="90px" align='right'>Price (RM)</td>
																<td width="90px" align='right'>Unit(s)</td>
															</tr>
														</thead>
														<tbody>
															<?php	
																$total_discount = 0;
																while($cart_display = mysqli_fetch_array($cart)){
																	$discount = ($cart_display['cart_product_price'] * $cart_display['cart_product_amount']) - (($cart_display['cart_product_price'] * $cart_display['cart_product_amount']) * $cart_display['cart_product_sale'])/100;
																	$total_discount = $total_discount + $discount;
																	$total_handling = $total_handling + ($cart_display['cart_handling'] * $cart_display['cart_product_amount']);
																	
																	$total_amount = $total_amount + $discount + $total_handling;
																	$total_mygaz = $total_mygaz + $cart_display['cart_mygaz_amount'];
																	$total_petronas = $total_petronas + $cart_display['cart_petronas_amount'];
															?>
																<tr>
																	<td width="400px" style="padding-left:5;padding-top:5;"><?php	echo $cart_no.". ";?><?=$cart_display['cart_product_name']?></td>
																	<td width="100px" align='right'><?=$cart_display['cart_product_price']?></td>
																	<td width="100px" align='right'><?=$cart_display['cart_product_amount']?></td>
																</tr>
															<?php	$cart_no++;
																	}
																	$total_amount2 = $total_discount + $total_handling;
															?>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan='2'>
													<table border="0" id="pricing" width="600px" cellpadding="0" cellspacing="0">
														<thead>
															<tr>
																<td width="480px" align='right'>Return Cylinder:</td>
																<td width="118px" align='right'> &nbsp; MYGAZ ( <?=$total_mygaz?> )
																<BR />
																PETRONAS ( <?=$total_petronas?> )</td>
															</tr>
														</thead>
														
														<thead>
															<tr>
																<td width="480px" align='right'>Handling Charge (RM) : </td>
																<td width="100px" align='right'><?=number_format($total_handling,2)?></td>
															</tr>
														</thead>
														<thead>
															<tr>
																<td colspan='2' width="600px"><hr /></td>
															</tr>
															<tr>
																<td width="400px" align='right'>Total amount (RM) : </td>
																<td width="100px" align='right'><?=number_format($total_amount2,2)?></td>
															</tr>
														</thead>
														
													</table>
												</td>
											</tr>
											<tr>
												<td>
													<input type="button" onClick="goBack();" value="Back" />
												</td>
												<td align='right'>
													<input type="button" name="reset" onClick="return confirmReset();" value="Clear"/>
													<input type="submit" name="checkout" onClick="return confirmCheckout();" value="Checkout"/>
												</td>
													
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td>
										
										<input type="hidden" name="total_handling" value="<?=$total_handling?>"/>
										<input type="hidden" name="total_amount" value="<?=$total_amount2?>"/>
										<input type="hidden" name="total_mygaz" value="<?=$total_mygaz?>"/>
										<input type="hidden" name="total_petronas" value="<?=$total_petronas?>"/>
									</td>
								</tr>
							</table>
							
						</form>
					<p>&nbsp;&nbsp;&nbsp;</p>
				<?php
					include('../footer.php');
				?>
		</div>
		
		<script>
			function nonExist(){
				window.location = "proceed_checkout.php?hyperlink=orders";
			}
			
			function exist(){
				window.location = "member.php?hyperlink=orders";
			}
			
			function confirmReset(){
				var confirmClear = confirm("Do you wish to clear the customer details?");
				
				if(confirmClear){
					document.getElementById('first_name').value = "";
					document.getElementById('last_name').value = "";
					document.getElementById('telephone').value = "";
					document.getElementById('mobile').value = "";
					document.getElementById('street_name').value = "";
					document.getElementById('postcode').value = "";
					document.getElementById('city').value = "";
					document.getElementById('state').value = "";
					document.getElementById('country').value = "";
					document.getElementById('delivery').value = "";
				}
			}
			
			function confirmCheckout(){
			
				var firstName = document.getElementById('first_name').value;
				var lastName = document.getElementById('last_name').value;
				var streetName = document.getElementById('street_name').value;
				var postCode = document.getElementById('postcode').value;
				var city = document.getElementById('city').value;
				var state = document.getElementById('state').value;
				var country = document.getElementById('country').value;
				var delivery = document.getElementById('delivery').value;

				if(firstName == "" || lastName == "" || streetName == "" || postCode == "" || city == "" || state == "" || country == "" || delivery == ""){
				
					var message = "Please fill in the following field(s) before create!";
					
					if(firstName == ""){
						message = message + "\n-First Name";
					}
					if(lastName == ""){
						message = message + "\n-Last Name";
					}
					if(no == "" || streetName == ""){
						message = message + "\n-Street Name";
					}
					if(postCode == ""){
						message = message + "\n-Postcode";
					}
					if(city == ""){
						message = message + "\n-City";
					}
					if(state == ""){
						message = message + "\n-State";
					}
					if(country == ""){
						message = message + "\n-Country";
					}
					if(delivery == ""){
						message = message + "\n-Delivery date";
					}
					
					alert(message);
					return false;
				}else{
					var confirmCheckout = confirm("Do you wish to checkout?");
					
					if(confirmCheckout){
						return true;
					}else{
						return false;
					}
				}
			}
			
			function goBack(){
				var confirmBack = confirm("Do you wish to go back?");
				
				if(confirmBack){
					window.location = "make_order.php?hyperlink=orders";
				}
			}
			
			$(document).ready(function () {
				$( "#delivery" ).datepicker({
					changeMonth: true,
					changeYear: true 
				});
			});
		</script>
	</body>
</html>