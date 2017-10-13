<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	
	$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$pro_id'");
	$product_display = mysqli_fetch_assoc($product);
	
	$mem_class =mysqli_real_escape_string($dbconnect, $_GET['class']);
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
						<li><a href="view_order.php"><span>Orders</span></a></li>  
						<li><a href="make_order.php" class="current"><span>Place Manual Order</span></a></li> 
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
		
			<form action="add_to_cart.php?pro=<?=$pro_id?>&class=<?=$mem_class?>&pro_class=prod" method="POST">
				<table border="0" align="center" width="600px" height="200px" cellpadding="0" cellspacing="0"  class="box-table-a">
					<tr>
						<th colspan="2" align="center">Manual Order</th>
					</tr>
					<tr>
						<th align="center">Status</th>
						<td align="center">
						<?php	if(!isset($_GET['add'])){
								}else{
									$add_result = mysqli_real_escape_string($dbconnect, $_GET['add']);
												
									if($add_result == "empty"){
										echo "<span>Please at least add 1 ".$product_display['product_name']." into cart!</span>";
									}else if($add_result == "more"){
										echo "<span>".$product_display['product_name']." amount are more than stock amount!</span>";
									}else if($add_result == "less"){
										echo "<span>".$product_display['product_name']." amount cannot be negative!</span>";
									}
								}
						?>
						</td>
					</tr>
					<tr>	
						<th>Product Image</th>	
						<td colspan="2">
							<img src="../product/<?=$product_display['product_image']?>" width="200px" height="200px" alt="<?=$product_display['product_name']?>"/>
						</td>
					</tr>		
					<tr>	
						<th width="150px" style="padding-left:12;"><label>Category : </label></th>
						<td style="padding-left:12;"><label><?=$product_display['product_category']?></label></td>
					</tr>
					<tr>
						<th style="padding-left:12;"><label>Name : </label></th>
						<td style="padding-left:12;"><label id="product"><?=$product_display['product_name']?></label></td>
					</tr>
					<?php	if($mem_class == "mem"){
								$price = $product_display['product_price'];
								$handling = $product_display['product_handling'];
							}else if($mem_class == "com"){
								$price = $product_display['product_commercial_price'];
								$handling = $product_display['product_commercial_handling'];
							}else if($mem_class == "com_k"){
								$price = $product_display['product_commercial_price2'];
								$handling = $product_display['product_commercial_handling2'];
							}					
					?>
					<tr>
						<th style="padding-left:12;"><label>Price : </label></th>
						<td style="padding-left:12;"><label><?=$price?></label></td>
					</tr>
					<tr>
						<th style="padding-left:12;"><label>Handling Charge : </label></th>
						<td style="padding-left:12;"><label><?=$handling?></label></td>
					</tr>
					<tr>
						<th style="padding-left:12;"><label>Sale percentage for (<?=$product_display['product_sale1']?>) : </label></td>
						<td style="padding-left:12;"><label><?=$product_display['product_sale_percentage1']?></label></td>
					</tr>
					<tr>
						<th style="padding-left:12;"><label>Sale percentage for (<?=$product_display['product_sale2']?>) : </label></td>
						<td style="padding-left:12;"><label><?=$product_display['product_sale_percentage2']?></label></td>
					</tr>
					<tr>
						<th style="padding-left:12;"><label>Sale percentage  for (<?=$product_display['product_sale3']?>): </label></td>
						<td style="padding-left:12;"><label><?=$product_display['product_sale_percentage3']?></label></td>
					</tr>
					<tr>
						<th style="padding-left:12;"><label>Description : </label></th>
						<td style="padding-left:12;"><label><?=$product_display['product_description']?></label></td>
					</tr>
					<tr>
						<th>Quantity to Order</th>	
						<td align="center">
							<input type="number" name="add_cart" id="add_cart" style="width:50px;" value="1"/>&nbsp;of&nbsp;<?=$product_display['product_stock']?>
							<input type="hidden" id="stock" value="<?=$product_display['product_stock']?>"/>
							<input type="hidden" id="member_class" value="<?=$mem_class?>"/>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="add_to_cart" id="add_to_cart" onClick="return checkEmpty();" value="Add to cart"/>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;">
							<input type="button" onClick="back();" value="Back"/>
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
			function checkEmpty(){
				var add_cart = document.getElementById('add_cart').value;
				var product = document.getElementById('product').textContent;
				var stock = document.getElementById('stock').value;

				if(add_cart == 0 || add_cart == "" || add_cart < 0 || add_cart > stock){
					if(add_cart == 0 || add_cart == ""){
						alert("Please at least add 1 " +product +" into cart!");
					}else if(add_cart < 0){
						alert(product +" amount cannot be negative!");
					}else if(add_cart > stock){
						alert(product +" amount are more than stock amount!");
					}
					return false;
				}else{
					return true;
				}
			}
			
			function back(){
				var mem = document.getElementById('member_class').value;
				
				var confirmBack = confirm("Do you wish to go back?");
				
				if(confirmBack){
					window.location = "make_order.php?hyperlink=orders&class=" +mem;
				}
			}
		</script>
	</body>
</html>