<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "order_history.php";
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
		
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_order WHERE  (order_number LIKE '%".$searchKey."%') AND (order_status='1' OR order_status='2' OR order_status='3')"));
		$total_pages = $total_pages['num'];
	
		$cart_order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE (order_number LIKE '%".$searchKey."%') AND (order_status='1' OR order_status='2' OR order_status='3') LIMIT $start, $limit");
		$cart_count = mysqli_num_rows($cart_order);
	}else{
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_order WHERE order_status='1' OR order_status='2' OR order_status='3'"));
		$total_pages = $total_pages['num'];
		
		$cart_order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_status='1' OR order_status='2' OR order_status='3' LIMIT $start, $limit");
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
        <title>Order History</title>
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
						<li><a href="view_order.php?hyperlink=orders"><span>Order</span></a></li>   
						<li><a href="make_order.php?hyperlink=orders"><span>Place Manual Order</span></a></li>
						<li><a href="order_history.php?hyperlink=orders" class="current"><span>Order History</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />						
			<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../order/view_order.php?hyperlink=orders">Orders</a> >> <a href="../order/order_history.php?hyperlink=orders">Order History</a></p>
			<br />	
			<table border="0">
				<tr>
					<td>&nbsp;</td>
			   </tr>
			</table>
		
			<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>	
					<th colspan="2" align="center">Search Order</th>
				</tr>
				<tr>
					<th width="300px" align="center">
						<input type="text" name="searchKey" id="searchKey" autofocus/>
					</th>
					<th>
						<input type="button" value="Search" onClick="searchKey();"/>
					</th>
				</tr>
			</table>
						
			<table border="1" align="center" width="800px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="7" align="center">Order History</th>
				</tr>
				<tr>
					<th width="100px" style="padding-left:5;">Order No.</th>
					<th width="60px" style="padding-left:5;">Amount (RM)</th>
					<th width="100px" style="padding-left:5;">Order Date</th>
					<th width="100px" style="padding-left:5;">Delivery Date</th>
					<th width="120px" ststyle="padding-left:5;">Time</th>
					<th width="90px" style="padding-left:5;">Payment Type</th>
					<th width="90px" style="padding-left:5;">Order Status</th>
				</tr>
				<?php	while($cart_order_display = mysqli_fetch_array($cart_order)){	?>
							<tr class="link" href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=his&hyperlink=orders">
							<td width="100px" style="padding-left:5;"><?=$cart_order_display['order_number']?></td>
							<td width="60px" align="right" style="padding-right:5;"><?=$cart_order_display['order_amount']?></td>
							<td width="100px" style="padding-left:5;"><?=$cart_order_display['order_date']?></td>
							<td width="100px" style="padding-left:5;"><?=$cart_order_display['order_delivery']?></td>
							<?php	if($cart_order_display['order_time'] == 1){
										$time = "Morning (8-12)";
									}else if($cart_order_display['order_time'] == 2){
										$time = "Afternoon (12-2)";
									}else if($cart_order_display['order_time'] == 3){
										$time = "Immediately";
									}
							?>
							<td width="120px" style="padding-left:5;"><?=$time?></td>
							<?php	$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$cart_order_display['order_number']."'");
									$point = 0;
									while($order_list_display = mysqli_fetch_array($order_list)){
										$point = $point + ($order_list_display['order_product_point'] * $order_list_display['order_product_amount']);
									}
							?>
							<td href="view_orderList.php?or=<?=$cart_order_display['order_number']?>&view=or&hyperlink=orders" width="90px" style="padding-left:5;"><?=$point?></td></td>
							<td>
								<?php	if($cart_order_display['order_status'] == 2){
											$status = "<a class='button'><span style='font-size:15px;color:#FFFFFF;'>Cancelled</span>";
										}else if($cart_order_display['order_status'] == 1){
											$status = "<a class='button_green'><span style='font-size:15px;color:#333;'>Completed</span>";
										}else if($cart_order_display['order_status'] == 3){
											$status = "<a class='button_yellow'><span style='font-size:15px;color:#000000;'>Refunded</span>";
										}
										echo $status;
								?>
							</td>
						</tr>
				<?php	}	?>	
				<tr>
					<td height="50px" align="center" colspan="7" style="border-style:hidden;">
						<table border="0" align="center" valign="bottom" width="800px">
							<tr>
								<td align="center" style="border-style:hidden;"><?=$pagination?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
						
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<?php
				include('../footer.php');
			?>
		</div>
		
		<script>
			function searchKey(){
				var keyword = document.getElementById('searchKey').value;

				window.location= 'order_history.php?search='+keyword+'&hyperlink=orders';
			}
		
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		</script>
	</body>
</html>