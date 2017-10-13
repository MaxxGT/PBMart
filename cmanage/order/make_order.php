<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	if(!empty($_GET['pro-class'])){
		$pro_class = mysqli_real_escape_string($dbconnect, $_GET['pro-class']);
	}else{
		$pro_class = "prod";
	}
	
	if(!empty($_GET['class'])){
		$mem_class = mysqli_real_escape_string($dbconnect, $_GET['class']);
	}else{
		$mem_class = "mem";
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "make_order.php";
	$limit = 16;
	
	if($pro_class == "prod"){
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_product"));
		$total_pages = $total_pages['num'];
	}else{
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_promotion"));
		$total_pages = $total_pages['num'];
	}
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	if($pro_class == "prod"){
		$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product LIMIT $start, $limit");
		$product_row = 0;
		$pro_result = "prod";
	}else{
		$promotion = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion LIMIT $start, $limit");
		$promotion_row = 0;
		$pro_result = "prom";
	}
	
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
			$pagination.= "<a href=\"$targetpage?page=1&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&mem=$mem_class&pro-class=$pro_class&hyperlink=orders\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
	
	$cart = mysqli_query($dbconnect, "SELECT * FROM pbmart_admin_cart");
	$cart_row = mysqli_num_rows($cart);
	
	$cart_no = 1;
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
		
		<style>
			.member_class:hover{
				opacity:0.6;
			}
			
			.member_class:hover, .product_promo_class:hover{
				cursor:pointer;
			}
		</style>
		
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
					<th colspan="4" align="center">Member Class</th>
				</tr>
				<?php	if($mem_class == "mem"){
							$mem_text = "font-weight:bold;font-size:16pt;";
							$com_text = "";
							$com_k_text = "";
						}else if($mem_class == "com"){
							$mem_text = "";
							$com_text = "font-weight:bold;font-size:16pt;";
							$com_k_text = "";
						}else if($mem_class == "com_k"){
							$mem_text = "";
							$com_text = "";
							$com_k_text = "font-weight:bold;font-size:16pt;";
						}
				?>
				<tr>
					<td style="background-color:#00E600;text-align:center;<?=$mem_text?>" class="member_class" href="view_product.php?pro=1&hyperlink=orders&class=mem">
						Domestic <BR/>
						RM30.00
					</td>
					<td style="background-color:#FFCC00;text-align:center;<?=$com_text?>" class="member_class" href="view_product.php?pro=1&hyperlink=orders&class=com">
						COMMERCIAL <BR/>
						RM28.60
					</td>
					
					<td style="background-color:Orchid;text-align:center;<?=$com_k_text?>" class="member_class" href="view_product.php?pro=1&hyperlink=orders&class=com_k">
						COMMERCIAL (K)
						<BR/>RM25.60
					</td>
					<td style="background-color:#6495ED;text-align:center;" class="member_class" href="view_product.php?pro=3&hyperlink=orders&class=mem">
						<font color="white">SELF PICK UP <BR/> RM26.60</font>
					</td>
				</tr>
				<tr style="height:40px;">
					<td colspan="4" style="border-style:hidden;"></td>
				</tr>
				<tr>
					<th colspan="4" align="center">Manual Order</th>
				</tr>
				<tr>
					<th>Status</th>
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
					<?php	if($pro_class == "prod"){
								$prod_stat = "LawnGreen";
								$prom_stat = "DarkGray";
								$prod_text = "font-weight:bold;font-size:18pt;";
								$prom_text = "";
							}else{
								$prod_stat = "DarkGray";
								$prom_stat = "LawnGreen";
								$prod_text = "";
								$prom_text = "font-weight:bold;font-size:18pt;";
							}
					?>
					<td colspan="2" align="center" style="background-color:<?=$prod_stat?>;<?=$prod_text?>" class="product_promo_class" href="make_order.php?pro-class=prod&class=<?=$mem_class?>&page=1&hyperlink=orders">
						PRODUCTS
					</td>
					<td colspan="2" align="center" style="background-color:<?=$prom_stat?>;<?=$prom_text?>" class="product_promo_class" href="make_order.php?pro-class=prom&class=<?=$mem_class?>&page=1&hyperlink=orders">
						PROMOTIONS
					</td>
				</tr>
				<tr>
					<?php	if($pro_result == "prod"){
								while($product_display = mysqli_fetch_array($product)){?>
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
												<td>
													<?=$product_display['product_name']?>
													<BR />
													<B>RM <?=number_format($product_display['product_price'] + $product_display['product_handling'],2)?><B />
												</td>
											</tr>
											<tr>
												<td align="center" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;">
													<?php	if($product_display['product_stock'] == '0'){
																echo "<span class='out_of_stock'><font color='red'><B>Out of stock<B /></font></span>";
															}else{
																echo '<B>'.$product_display['product_stock']." in stock<B />";
															}
															$product_row++;
													?>
												</td>
											</tr>
										</table>
									</td>
					<?php			if($product_row%4 == 0){
										echo "</tr>";
										echo "<tr><td colspan='4' style='border-style:hidden;'></td></tr>";
										echo "<tr>";
									}
								}	
							}else if($pro_result == "prom"){
								while($promotion_display = mysqli_fetch_array($promotion)){?>
									<td>
										<table border="0" width="150px" cellpadding="0" cellspacing="0" >
											<tr>
												<?php	if($promotion_display['promotion_package_stock'] == '0'){
															$event = "onClick='return linkStop();'";
														}else{
															$event = "";
														}
												?>
												<td align="center">
													<a href="view_promotion.php?pro=<?=$promotion_display['promotion_id']?>&hyperlink=orders&class=<?=$mem_class?>" <?=$event?>><img src="../promotion/<?=$promotion_display['promotion_item_photo']?>" width="150px" height="150px" alt="<?=$promotion_display['promotion_package_name']?>"/></a>
												</td>
											</tr>
											<tr>
												<td>
													<?=$promotion_display['promotion_package_name']?>
													<BR />
													<B> RM <?=$promotion_display['promotion_package_price']?> <B />
												</td>
											</tr>
											<tr>
												<td align="center" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;">
													<?php	if($promotion_display['promotion_package_stock'] == '0'){
																echo "<span class='out_of_stock'><font color='red'><B>Out of stock<B /><font /></span>";
															}else{
																echo '<B>'.$promotion_display['promotion_package_stock']." in stock<B />";
															}
															$promotion_row++;
													?>
												</td>
											</tr>
										</table>
									</td>
					<?php			if($promotion_row%4 == 0){
										echo "</tr>";
										echo "<tr><td colspan='4' style='border-style:hidden;'></td></tr>";
										echo "<tr>";
									}
								}	
							}
					?>
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
			$(document).ready(function(){
				$('.member_class').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
			
			$(document).ready(function(){
				$('.product_promo_class').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		
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