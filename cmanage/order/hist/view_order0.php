<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "view_order.php";
	$limit = 20;
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	$searchKey = "";
	
	if(isset($_GET['search']) != ""){
		$searchKey = mysqli_real_escape_string($dbconnect, $_GET['search']);
		
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_order WHERE order_number LIKE'%".$searchKey."%' AND order_status='0'"));
		$total_pages = $total_pages['num'];
	
		$cart_order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_number LIKE'%".$searchKey."%' AND order_status='0' AND ePaymentStatus='0' OR ePaymentStatus='2' LIMIT $start, $limit");
		$cart_count = mysqli_num_rows($cart_order);
	}else{
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_order WHERE order_status='0'"));
		$total_pages = $total_pages['num'];
		
		$cart_order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_status='0' AND ePaymentStatus='0' OR ePaymentStatus='2' LIMIT $start, $limit");
		$cart_count = mysqli_num_rows($cart_order);
	}
	
	if($page == 0)
		$page = 1;
	
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1){
		$pagination.= "<div class=\"pagination\">";
		
		// First button
		if($page > 1)
			$pagination.= "<a href=\"$targetpage?page=1&search=$searchKey&hyperlink=orders\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&search=$searchKey&hyperlink=orders\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&search=$searchKey&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&search=$searchKey&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&search=$searchKey&hyperlink=orders\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&search=$searchKey&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&search=$searchKey&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&search=$searchKey&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&search=$searchKey&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&search=$searchKey&hyperlink=orders\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&search=$searchKey&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&search=$searchKey&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&search=$searchKey&hyperlink=orders\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&search=$searchKey&hyperlink=orders\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Order</title>
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
						<li><a href="view_order.php?hyperlink=orders" class="current"><span>Order</span></a></li>   
						<li><a href="make_order.php?hyperlink=orders"><span>Place Manual Order</span></a></li>
						<li><a href="order_history.php?hyperlink=orders"><span>Order History</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../order/view_order.php?hyperlink=orders">Orders</a></p>
			</div>
			<br />
			<table>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>	
					<th colspan="2" align="center">Search Products</th>
				</tr>
				<tr>
					<th width="300px" align="center">
						<input type="text" name="searchKey" id="searchKey"/>
					</th>
					<th>
						<input type="button" value="Search" onClick="searchKey();"/>
					</th>
				</tr>
			</table>
			
			<form action="delete_order.php" method="POST">
				<table border="0" align="center" width="900px" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="8" align="center">Order Management</th>
					</tr>
					<tr>
						<th colspan="2">Order Edit Status</th>
						<td colspan="6">
							<?php	if(!isset($_GET['del'])){
									}else{
										$del_order_result = mysqli_real_escape_string($dbconnect, $_GET['del']);
																
										if($del_order_result == "true"){
											echo "<span class='success'>Order successfully deleted.</span>";
										}else if($del_order_result == "false"){
											echo "<span>Order could not be deleted! Please try again later.</span>";
										}else if($del_order_result == "empty"){
											echo "<span>There is no Order to be delete!</span>";
										}
									}
															
									if(!isset($_GET['com'])){
									}else{
										$com_order_result = mysqli_real_escape_string($dbconnect, $_GET['com']);
																
										if($com_order_result == "true"){
											echo "<span class='success'>Orders successfully completed.</span>";
										}else if($com_order_result == "false"){
											echo "<span>Order could not be completeed! Please try again later.</span>";
										}else if($com_order_result == "oempty"){
											echo "<span>There is no Order to be complete!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<?php	if($cart_count == "0"){
									$bor_style = "border-bottom-style:hidden;";
								}else{
									$bor_style = "";
								}
						?>
						<th width="60px" class="chkBox" style="<?=$bor_style?>">Select</th>
						<th width="100px" style="padding-left:5;">Order No.</th>
						<th width="80px" style="padding-left:5;">Amount (RM)</th>
						<th width="100px" style="padding-left:5;">Order Date</th>
						<th width="100px" style="padding-left:5;">Time</th>
						<th width="100px" style="padding-left:5;">Delivery Date</th>
						<th width="90px" style="padding-left:5;">Points</th>
						<th width="110px" style="padding-left:5;">Status  (Click to Complete)</th>
					</tr>
					<?php	while($cart_order_display = mysqli_fetch_array($cart_order)){	?>
								<tr>
									<td align="center" width="40px">
										<input type="checkbox" name="orderList[]" value="
										<?php	echo $cart_order_display['order_id'];	?>"/>
									</td>
									<td class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="100px" style="padding-left:5;"><?=$cart_order_display['order_number']?></td>
									<td class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="60px" align="right" style="padding-right:5;"><?=$cart_order_display['order_amount']?></td>
									<td class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="100px" style="padding-left:5;"><?=$cart_order_display['order_date']?></td>
									<td class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="100px" style="padding-left:5;"><?=$cart_order_display['order_time_date']?></td>
									<td class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="100px" style="padding-left:5;"><?=$cart_order_display['order_delivery']?></td>
									<?php	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$cart_order_display['order_number']."'");
										$point = 0;
										while($order_list_display = mysqli_fetch_array($order_list)){
											$product_double = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='".$order_list_display['order_product_id']."'");
											$prod_doub = mysqli_fetch_assoc($product_double);
											
											$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$cart_order_display['order_customer_id']."'");
											$member_status = mysqli_fetch_assoc($member);
											
											/*if($member_status['member_commercial_status'] == 0){
												if($prod_doub['product_double_point'] == 1){
													$double = 3;
												}else{
													$double = 1;
												}
											}else if($member_status['member_commercial_status'] == 1){
												if($prod_doub['product_commercial_double_point'] == 1){
													$double = 3;
												}else{
													$double = 1;
												}
											}else if($member_status['member_commercial_status'] == 2){
												if($prod_doub['product_commercial_double_point2'] == 1){
													$double = 3;
												}else{
													$double = 1;
												}
											}*/
											
											$point = $point + ($order_list_display['order_product_point'] * $order_list_display['order_product_amount']);
										}
								?>
									<td class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="90px" style="padding-left:5;"><?=$cart_order_display['order_total_point']?></td>
									<td width="110px" align="center"><a href="complete_order_new.php?or=<?=$cart_order_display['order_number']?>&view=or"><img src="../images/complete.png" alt="Complete Order" height="20px" width="20px" value="Complete Order" onClick="return confirmComplete();" /></a>
									<a href="refund.php?or=<?=$cart_order_display['order_number']?>"><img src="../images/refund.png" height="20px" width="20px" alt="Refund" value="Refund" onClick="return confirmRefund();"/></a>
									<a href="extend_order.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders"><img src="../images/extend.png" alt="Extend Order" height="20px" width="20px" value="Extend Order" onClick="return confirmExtend();" /></a></td>
								</tr>
							<?php	}	?>		
					<tr>
						<th colspan="6" align="center">
							<input type="submit" name="order_delete" onClick="return deleteOrder();" value="Delete"/> <!--| <input type="submit" name="order_deleteAll" onClick="return order_checkDeleteAll();" value="Delete All"/>-->
							
							<input type="submit" name="order_cancel" onClick="return deleteOrder();" value="Cancel Order"/>
						<th colspan="2" align="center">
							<input type="submit" name="complete_orders" onClick="return completeOrders();" value="Complete Orders"/>
						</th>
					</tr>
					<tr>
						<td height="50px" align="center" colspan="8" style="border-style:hidden;">
							<table border="0" align="center" valign="bottom" width="800px">
								<tr>
									<td align="center" style="border-style:hidden;"><?=$pagination?></td>
								</tr>
							</table>
						</td>
					</tr>							
				</table>
		
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			</form>
			<?php
				include('../footer.php');
			?>				
		</div>	
		
		<script>
			function searchKey(){
				var keyword = document.getElementById('searchKey').value;

				window.location= 'view_order.php?key=&search='+keyword+'&hyperlink=orders';
			}
			
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
			
			function confirmComplete(){
				var confirmComplete = confirm("Do you wish to complete the order?");
				
				if(confirmComplete){
					return true;
				}else{
					return false;
				}
			}
			
			function confirmRefund(){
				var confirmRefund = confirm("Do you wish to refund the order?");
				
				if(confirmRefund){
					return true;
				}else{
					return false;
				}
			}
			
			function confirmExtend(){
				var confirmExtend = confirm("Do you wish to extend the order?");
				
				if(confirmExtend){
					return true;
				}else{
					return false;
				}
			}
			
			function deleteOrder(){
				var order_list = document.getElementsByName('orderList[]');
				var order_num = [];
				for(var i = 0; i < order_list.length; i++){
					if(order_list[i].checked){
						order_num++;
					}
				}
				
				if(order_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +order_num +" order(s)?");
				}else{
					alert("Please select 1 or more order to delete!");
				}
				
				if(confirmDelete){
					return true;
				}else{
					return false;
				}
			}
			
			function order_checkDeleteAll(){
				var confirmDelAll = confirm("Do you wish to delete all orders?");
				
				if(confirmDelAll){
					return true;
				}else{
					return false;
				}
			}
			
			function completeOrders(){
				var order_list = document.getElementsByName('orderList[]');
				var order_num = [];
				for(var i = 0; i < order_list.length; i++){
					if(order_list[i].checked){
						order_num++;
					}
				}
				
				if(order_num > 0){
					var confirmComplete = confirm("Do you wish to complete " +order_num +" order(s)?");
				}else{
					alert("Please select 1 or more order to complete!");
				}
				
				if(confirmComplete){
					return true;
				}else{
					return false;
				}
			}
		</script>
	</body>
</html>