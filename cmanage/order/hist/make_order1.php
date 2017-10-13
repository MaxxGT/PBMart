<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "make_order.php";
	$limit = 16;
	
	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_product"));
	$total_pages = $total_pages['num'];
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product LIMIT $start, $limit");
	$product_row = 0;
	
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
			$pagination.= "<a href=\"$targetpage?page=1&hyperlink=orders\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=orders\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=orders\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=orders\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=orders\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=orders\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
	
	$cart = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin_cart");
	$cart_row = mysqli_num_rows($cart);
	
	$cart_no = 1;
	
	if(isset($_GET['class'])){
		$mem_class = mysqli_real_escape_string($dbconnect, $_GET['class']);
	}else{
		$mem_class = "mem";
	}
?>

<html>
	<head>
        <title>Manual Order</title>
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
						<li><a href="view_order.php?hyperlink=orders" ><span>Orders</span></a></li>  
						<li><a href="make_order.php?hyperlink=orders" class="current"><span>Place Manual Order</span></a></li> 
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
                <p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../order/view_order.php?hyperlink=orders">Orders</a> >> <a href="../order/make_order.php?hyperlink=orders">Place Manual Order</a></p>
			</div>
            <br />
	
			<table border="0" width="600px" height="200px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="4" align="center">Manual Order</th>
				</tr>
				<tr>
					<th>Order Status</th>
					<td colspan="4" align="center">
						<?php	if(!isset($_GET['order'])){
								}else{
									$create_order = mysqli_real_escape_string($dbconnect, $_GET['order']);
																
									if($create_order == "true"){
										echo "<span class='success'>Order successfully saved.</span>";
									}
								}
						?>
					</td>
				</tr>
				<tr>
					<th colspan="4" align="center">Products</th>
				</tr>
				<tr>
					<td colspan="4"><a href="make_order.php?hyperlink=orders&class=mem"><input type="button" value="Member" name="member" id="member" style="width:80px;height:"/></a> &nbsp&nbsp&nbsp <a href="make_order.php?hyperlink=orders&class=com"><input type="button" value="Commercial" name="commercial" id="commercial"/></a> &nbsp&nbsp&nbsp <a href="make_order.php?hyperlink=orders&class=com_k"><input type="button" value="Commercial (K)" name="commercial_k" id="commercial_k"/></a></td>
				</tr>
				<tr>
					<?php	while($product_display = mysqli_fetch_array($product)){?>
								<td>
									<table border="0" width="150px" cellpadding="0" cellspacing="0" >
										<tr>
											<?php	if($product_display['product_stock'] == '0'){
														$event = "onClick='return linkStop();'";
													}else{
														$event = "";
													}
											?>
											<td align="center">
												<a href="view_product.php?pro=<?=$product_display['product_id']?>&hyperlink=orders&class=<?=$mem_class?>" <?=$event?>><img src="../product/<?=$product_display['product_image']?>" width="150px" height="150px" alt="<?=$product_display['product_name']?>"/></a>
											</td>
										</tr>
										<tr>
											<td><?=$product_display['product_name']?></td>
										</tr>
										<tr>
											<td align="center" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;">
												<?php	if($product_display['product_stock'] == '0'){
															echo "<span class='out_of_stock'>Out of stock</span>";
														}else{
															echo $product_display['product_stock']." in stock";
														}
														$product_row++;
												?>
											</td>
										</tr>
									</table>
								</td>
								<?php	if($product_row%4 == 0){
											echo "</tr>";
											echo "<tr><td colspan='4' style='border-style:hidden;'></td></tr>";
											echo "<tr>";
										}
								?>
					<?php	}	?>
				</tr>
				<tr>
					<td height="50px" align="center" colspan="4" style="border-style:hidden;">
						<table border="0" align="center" valign="bottom" width="600px">
							<tr>
								<td align="center" style="border-style:hidden;"><?=$pagination?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		
		<?php	include "cart.php";	?>
		
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		<?php
			include('../footer.php');
		?>
		</div>	
	
		<script>
			function linkStop(){
				return false;
			}
			
			function hiddenShow(){
				var button = document.getElementById('expand_hide').value;
				
				if(button == "Hide Cart"){
					document.getElementById('hide_show').style.display = 'none';
					document.getElementById('hide_show1').style.display = 'none';
					document.getElementById('expand_hide').value = "Show Cart";
					document.getElementById('cart_table').style.width = '50px';
				}else{
					document.getElementById('hide_show').style.display = '';
					document.getElementById('hide_show1').style.display = '';
					document.getElementById('expand_hide').value = "Hide Cart";
					document.getElementById('cart_table').style.width = '350px';
				}
			}
			
			function confirmClear(){
				var confirmClear = confirm("Do you wish to clear the cart?");
				
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
			
			function proceedCheckout(){
				
				if(document.getElementById('empty').textContent === "There is no item in the cart."){
					alert("There is no item in the cart!");
				}else if(document.getElementById('empty').textContent === ""){
					var confirmProceed = confirm("Proceed to checkout?");
					
					if(confirmProceed){
						window.location = "proceed_checkout.php?hyperlink=orders";
					}
				}
			}
		</script>
	</body>
</html>