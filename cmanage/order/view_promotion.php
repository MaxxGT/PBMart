<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	$mem_class =mysqli_real_escape_string($dbconnect, $_GET['class']);
	
	$promotion = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_id='$pro_id'");
	$promo_display = mysqli_fetch_assoc($promotion);
	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='".$promo_display['promotion_category_id']."'");
	$promo_cat_display = mysqli_fetch_assoc($promo_cat);
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
			
			<form action="add_to_cart.php?pro=<?=$pro_id?>&class=<?=$mem_class?>&pro_class=promo" method="POST">
				<table border="2" align="center" width="900px" cellpadding="0" class="box-table-a" cellspacing="0">
					<tr>
						<th colspan="4" align="center">Promotion Management</th>
					</tr>
					<tr>
						<th width="280px" colspan="1" style="padding-left:12px;">Status :</th>
						<td colspan="3">
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
						<th colspan="1" style="padding-left:12;">Package Image :</th>
						<td colspan="3">
							<img src="../promotion_category/<?=$promo_cat_display['promotion_category_photo']?>" alt="<?=$promo_cat_display['promotion_category_photo']?>" width="720px" height="190"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Product Category :</label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_category_name']?></label>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Package Name :</label>
						</th>
						<td colspan="3">
							<label id="package"><?=$promo_display['promotion_package_name']?></label>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Package Price :</label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_package_price']?></label>
						</td>
					</tr>
					<?php	if($promo_display['promotion_package_double_point'] == 1){
								$double = "checked";
							}else{
								$double = "";
							}
					?>
					<tr>
						<th style="padding-left:12;">
							<label>Package Points : </label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_package_point']?></label>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Package stock :</label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_package_stock']?></label>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Start Date : </label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_start_date']?></label>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>End Date : </label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_end_date']?></label>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Package Description :</label>
						</th>
						<td colspan="3">
							<label><?=$promo_display['promotion_package_description']?></label>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center" style="padding-left:12;">Package Item</th>
					</tr>
					<tr>
						<th width="220px" style="padding-left:12;">Product Image :</th>
						<td width="240px"><img src="../promotion/<?=$promo_display['promotion_product_photo']?>" alt="<?=$promo_display['promotion_product_name']?>" width="200px" height="200px"></td>
						<th width="100px" style="padding-left:12;">Item Image :</th>
						<td width="240px"><img src="../promotion/<?=$promo_display['promotion_item_photo']?>" alt="<?=$promo_display['promotion_item_name']?>" width="200px" height="200px"/></td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Product Name :</label>
						</th>
						<td>
							<label><?=$promo_display['promotion_product_name']?><label/>
						</td>
						<th style="padding-left:12;">
							<label>Item Name :</label>
						</th>
						<td>
							<label><?=$promo_display['promotion_item_name']?><label/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Product Model :</label>
						</th>
						<td>
							<label><?=$promo_display['promotion_product_model']?><label/>
						</td>
						<th style="padding-left:12;">
							<label>Item Model :</label>
						</th>
						<td>
							<label><?=$promo_display['promotion_item_model']?><label/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Product Price : </label>
						</th>
						<td>
							<label><?=$promo_display['promotion_product_price']?><label/>
						</td>
						<th style="padding-left:12;">
							<label>Item Price : </label>
						</th>
						<td>
							<label><?=$promo_display['promotion_item_price']?><label/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Product Sale : </label>
						</th>
						<td>
							<label><?=$promo_display['promotion_product_sale']?><label/>
						</td>
						<th style="padding-left:12;">
							<label>Item Sale : </label>
						</th>
						<td>
							<label><?=$promo_display['promotion_item_sale']?><label/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label>Product Description :</label>
						</th>
						<td>
							<label><?=$promo_display['promotion_product_description']?></label>
						</td>
						<th width="110px" style="padding-left:12;">
							<label>Item Description :</label>
						</th>
						<td>
							<label><?=$promo_display['promotion_item_description']?></label>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<input type="number" name="add_cart" id="add_cart" style="width:50px;" value="1"/>&nbsp;of&nbsp;<?=$promo_display['promotion_package_stock']?>
							<input type="hidden" id="stock" value="<?=$promo_display['promotion_package_stock']?>"/>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center">
							<input type="submit" name="add_to_cart" id="add_to_cart" value="Add to Cart" onClick="return checkEmpty();"/>
							<input type="hidden" id="member_class" value="<?=$mem_class?>"/>
						</th>
					</tr>
					<tr>
						<td style="border-style:hidden;padding-top:30;">
							<input type="button" name="back" onClick="back();" value="Back"/>
						</td>
					</tr>
				</table>
			</form>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

			<?php
				include('../footer.php');
			?>
		</div>
		
		<script>
			function checkEmpty(){
				var add_cart = document.getElementById('add_cart').value;
				var promotion = document.getElementById('package').textContent;
				var stock = document.getElementById('stock').value;

				if(add_cart == 0 || add_cart == "" || add_cart < 0 || add_cart > stock){
					if(add_cart == 0 || add_cart == ""){
						alert("Please at least add 1 " +promotion +" into cart!");
					}else if(add_cart < 0){
						alert(promotion +" amount cannot be negative!");
					}else if(add_cart > stock){
						alert(promotion +" amount are more than stock amount!");
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