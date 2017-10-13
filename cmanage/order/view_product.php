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
	
	if($mem_class=='com_k')
	{
		$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE product_id='$pro_id'");
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
						<th align="center">Manual Order Status</th>
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
						<th>Member :</th>
						<td align="left">
							<input type="text" name="search" id="search" size='53' style="text-transform: capitalize;" placeholder='Company/ Member No./ Name' autofocus />
							
							<select name='commercial'>
								<option value="0">--Please Select Commercial--</option>
								
							</select>
						</td>
					</tr>
					<tr>
						<th>Quantity to Order :</th>	
						<td>
							
							<input type="number" name="add_cart" id="add_cart" style="width:50px;" value="0" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" /><B>&nbsp; RM <?php echo number_format($price + $handling, 2).' '; ?></B>&nbsp;of&nbsp;<?=$product_display['product_stock']?>
							<input type="hidden" id="stock" value="<?=$product_display['product_stock']?>"/>
						</td>
					</tr>
					<tr>
						<th>Return Cylinder :</th>
						<td>
							
							<input type="number" name="add_cart_mygaz" id="add_cart_mygaz" style="width:50px;" value="0" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" /> &nbsp;<B>MYGAZ</B><BR />
							
							
							<input type="number" name="add_cart_petronas" id="add_cart_petronas" style="width:50px;" value="0" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" /> &nbsp;<B>PETRONAS</B>
							
							<input type="hidden" id="stock" value="<?=$product_display['product_stock']?>"/>
							<input type="hidden" id="member_class" value="<?=$mem_class?>"/>
						</td>
					</tr>
					
					<tr>
						<th> Delivery Date :</th>
						<td>
							<input type="text" id="delivery" name="delivery" onclick="javascript:NewCssCal('delivery','yyyyMMdd','arrow')" style="cursor:pointer" value="<?php echo $crnt_date; ?>" autofocus />
						</td>
					</tr>
					
					<tr>
						<th align="right" colspan="2">
							<input type="button" onClick="back();" value="Back"/>
							<input type="submit" name="add_to_cart" id="add_to_cart" onClick="return checkEmpty();" value="Add to cart"/>
						</th>
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
				var add_cart_mygaz = document.getElementById('add_cart_mygaz').value;
				var add_cart_petronas = document.getElementById('add_cart_petronas').value;
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
				var confirmBack = confirm("Do you wish to go back?");
				
				if(confirmBack){
					window.location = "make_order.php?hyperlink=orders";
				}
			}
		</script>
	</body>
</html>