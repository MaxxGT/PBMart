<?php
	require_once("../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:authentication/login.php");
	}else{
	
	}
	
	if(isset($_GET['code'])){
		$codes = mysqli_real_escape_string($dbconnect, $_GET['code']);
		
		if($codes == "ALL"){
			$codes = "";
		}else{
			$codes = $codes;
		}
	}else{
		$codes = "";
	}

	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "main.php";
	$limit = 10;

	$tomorrow = new DateTime('tomorrow');
	$tomorrow = $tomorrow->format('Y-m-d');
	$day7 = new DateTime('tomorrow');
	$day7 = $day7->modify('+6 day');
	$day7 = $day7->format('Y-m-d');

	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_order WHERE order_customer_address LIKE'%".$codes."%' AND order_status='0' AND order_delivery BETWEEN '0000-00-00' AND '".$day7."'"));
	$total_pages = $total_pages['num'];
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}

	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_customer_address LIKE'%".$codes."%' AND order_status='0' AND order_delivery BETWEEN '0000-00-00' AND '".$day7."' ORDER BY order_delivery ASC, order_time DESC LIMIT $start, $limit");
	
	if($page == 0)
		$page = 1;
	
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1){
		$pagination.= "<div class=\"pagination\">";
		
		// First button
		if($page > 1)
			$pagination.= "<a href=\"$targetpage?page=1&code=$codes\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&code=$codes\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&code=$codes\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&code=$codes\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&code=$codes\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&code=$codes\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&code=$codes\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&code=$codes\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&code=$codes\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&code=$codes\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&code=$codes\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&code=$codes\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&code=$codes\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&code=$codes\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
	
	$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_stock<=15");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Dashboard</title>
		<link rel="stylesheet" type="text/css" href="css/font.css">
		<link rel="stylesheet" type="text/css" href="css/table.css">
		<link rel="stylesheet" type="text/css" href="css/menu.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">	
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		<?php
			include('header.php');
		?>
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="main.php?hyperlink=main" class="current"><span>Dashboard</span></a></li>
						<li><a href="authentication/change.php?hyperlink=main"><span>Change Password</span></a></li>
						<li><a target="_blank" href="../"><span>Visit Website </span></a></li>
						<li><a href="authentication/logout.php"><span>Logout</span></a></li>
				   </ul>
				</div>
			</div>
		<!-- TABS END -->    
		</div>
		
	<div class="grid_16" id="content">	
		<br />
		<div class="breadcrumb">
                   <p><a href="main.php?hyperlink=main">Dashboard</a> </p>
		</div>
                <br />
                <table>
	              <tr>
		          <td>&nbsp;</td>
	              </tr>
                 </table>

		<div class="portlet">	
		                        <table border="1" align="center" width="900px" cellpadding="0" cellspacing="0"ss>
						<tr>
							<td>
								<?php	$post_code = array("ALL", "93200", "93250", "93300", "93350");
										
										for($i=0; $i<5; $i++){
										
											if($post_code[$i] == $codes || ($post_code[$i] == "ALL" && $codes == "")){
												$disable = "disabled";
											}else{
												$disable = "";
											}
								?>
									<a href="main.php?code=<?=$post_code[$i]?>"><input type="button" value="<?=$post_code[$i]?>" style="width:150px;height:50px;" <?=$disable?>/></a>
								<?php	}	?>
							<td>
						</tr>
					</table>
					<table border="1" align="center" width="900px" class="box-table-a" cellpadding="0" cellspacing="0">
						
						<tr>
							<th colspan="7" align="center">Order Management</th>
						</tr>
						<tr>
							<tr>
								<th width="100px" style="padding-left:5;">Order No.</th>
								<th width="80px" style="padding-left:5;">Amount (RM)</th>
								<th width="100px" style="padding-left:5;">Order Date</th>
								<th width="100px" style="padding-left:5;">Delivery Date</th>
								<th width="120px" ststyle="padding-left:5;">Time</th>
								<th width="90px" style="padding-left:5;">Payment Type</th>
								<th width="130px" style="padding-left:5;">Order Status</th>
							</tr>
						</tr>
						<?php	while($order_display = mysqli_fetch_array($order)){	?>
							<tr class="link" href="order/view_orderList.php?or=<?=$order_display['order_number']?>&view=ma&hyperlink=orders">
								<td width="100px" align="left" style="padding-left:5px;"><?=$order_display['order_number']?></td>
								<td width="80px" align="right" style="padding-right:5px;"><?=$order_display['order_amount']?></td>
								<td width="100px" style="padding-left:5;"><?=$order_display['order_date']?></td>
								<td width="100px" style="padding-left:5;"><?=$order_display['order_delivery']?></td>
								<?php	if($order_display['order_time'] == 2){
											$time = "Morning (8-12)";
										}else if($order_display['order_time'] == 1){
											$time = "Afternoon (12-2)";
										}else if($order_display['order_time'] == 3){
											$time = "Immediately";
										}
								?>
								<td width="120px" style="padding-left:5;"><?=$time?></td>
								<td width="90px" style="padding-left:5;"><?=$order_display['order_payment_type']?></td>
								<?php	$today = (date("Y-m-d"));
										$day2 = new DateTime('tomorrow');
										$day3 = new DateTime('tomorrow');
										$day4 = new DateTime('tomorrow');
										$day5 = new DateTime('tomorrow');
										$day5 = new DateTime('tomorrow');
										$day6 = new DateTime('tomorrow');
										
										$day2 = $day2->modify('+1 day');
										$day3 = $day3->modify('+2 day');
										$day4 = $day4->modify('+3 day');
										$day5 = $day5->modify('+4 day');
										$day6 = $day6->modify('+5 day');
										
										$day2 = $day2->format('Y-m-d');
										$day3 = $day3->format('Y-m-d');
										$day4 = $day4->format('Y-m-d');
										$day5 = $day5->format('Y-m-d');
										$day6 = $day6->format('Y-m-d');
										
										$today = strtotime(date("Y-m-d"));
										$dev = strtotime($order_display['order_delivery']);

										if($order_display['order_delivery'] == date("Y-m-d")){
											$status = "<a class='button'><span style='font-size:15px;color:#FFFFFF;'>Today</span>";
										}else if($today > $dev){
											$status = "<a class='button'><span style='font-size:15px;color:#FFFFFF;'>Order Overdue !!</span>";
										}else if($order_display['order_delivery'] == $tomorrow){
											$status = "<a class='button'><span style='font-size:15px;color:#FFFFFF;'>1 Day Left</span>";
										}else if($order_display['order_delivery'] == $day2){
											$status = "<a class='button_orange'><span style='font-size:15px;color:#333;'>2 Days Left</span>";
										}else if($order_display['order_delivery'] == $day3){
											$status = "<a class='button_orange'><span style='font-size:15px;color:#333;'>3 Days Left</span>";
										}else if($order_display['order_delivery'] == $day4){
											$status = "<a class='button_yellow'><span style='font-size:15px;color:#333;'>4 Days Left</span>";
										}else if($order_display['order_delivery'] == $day5){
											$status = "<a class='button_yellow'><span style='font-size:15px;color:#333;'> 5 Days Left</span>";
										}else if($order_display['order_delivery'] == $day6){
											$status = "<a class='button_green'><span style='font-size:15px;color:#FFFFFF;'> 6 Days Left</span>";
										}else if($order_display['order_delivery'] == $day7){
											$status = "<a class='button_green'><span style='font-size:15px;color:#FFFFFF;'>1 Week Left</span>";
										}else{
											$status = "<a class='button_green'><span style='font-size:15px;color:#FFFFFF;'> More than 1 Week </span>";
										}
								?>
								<td width="140px" style="padding-left:5;" ><?=$status?></td>
							</tr>
						<?php	}	?>
						</tr>
							<td colspan="7" align="center" style="border-style:hidden;">
								<table border="0" align="center" valign="bottom" width="600px">
									<tr>
										<td align="center" style="border-style:hidden;"><?=$pagination?></td>
									</tr>
								</table>
							</td>
						</tr>
						</table>
		</div>
		<div class="portlet">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
								<table border="1" width="900px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
									<tr>
										<th colspan="6" align="center">Product Stock Management</th>
									</tr>
									<tr>
										<th width="180px">Category</th>
										<th width="180px">Name</th>
										<th width="100px">Price (RM)</th>
										<th width="100px">Sales (%)</th>
										<th width="80px">Stock</th>
										<th width="180px">Status</th>
									</tr>
									<?php	while($product_display = mysqli_fetch_array($product)){	?>
										<tr class="link" href="product/add_product_stock.php?pro=<?=$product_display['product_id']?>&view=ma&hyperlink=products">
											<td><?=$product_display['product_category']?></td>
											<td><?=$product_display['product_name']?></td>
											<td align="right" style="padding-right:5px;"><?=$product_display['product_price']?></td>
											<td><?=$product_display['product_sale_percentage1']?></td>
											<td><?=$product_display['product_stock']?></td>
											<td>
												<?php	if($product_display['product_stock'] <= 15 && $product_display['product_stock'] >= 10){
															$stock = "<a class='button_yellow'><span style='font-size:15px;color:#333;'>Low Stock !!</span>";
														}else if($product_display['product_stock'] < 10 && $product_display['product_stock'] > 0){
															$stock = "<a class='button_yellow'><span style='font-size:15px;color:#333;'>Low Stock !!</span>";
														}else if($product_display['product_stock'] == 0){
															$stock = "<a class='button'><span style='font-size:15px;color:#FFFFFF;'>No Stock !!</span>";
														}
														echo $stock;
												?>
											</td>
										</tr>
									<?php	}	?>
								</table>
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<?php
				include('footer.php');
			?>
		</div>				
	</div>		
		
		<script>
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		</script>
	 <div class="clear"> </div>	

	</body>
</html>