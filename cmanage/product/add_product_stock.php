<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	
	$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id = '$pro_id'");
	$pro_display = mysqli_fetch_assoc($pro_result);
	
	$pro_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_category");
	
	if(isset($_GET['view'])){
		$view = mysqli_real_escape_string($dbconnect, $_GET['view']);
	}
?>
<?php
include('../header/header.php');
?>
<html>
	<head>
		<title>Add Stock</title>
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
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="../product/view_product.php?hyperlink=products" class="current"><span>Product</span></a></li>
						<li><a href="../product/add_product.php?hyperlink=products"><span>Add New Product</span></a></li>
						<li><a href="../category/category.php?hyperlink=products"><span>Product Category</span></a></li>
						<li><a href="../promotion/promotion.php?hyperlink=products"><span>Promotion</span></a></li>
						<li><a href="../promotion_category/promotion_category.php?hyperlink=products"><span>Promotion Category</span></a></li>
						<li><a href="../promotion/add_promotion.php?hyperlink=products"><span>Add Promotion</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
					</ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />
			<div class="breadcrumb">
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../product/view_product.php?hyperlink=products">Products</a> >> <a href="#">Add Product Stock</a></p> 
			</div>
			<br />
			<table>
				<tr>
					<td> </td>
				</tr>
			</table>
			
			<form action="product_add_stock.php?pro=<?=$pro_id?>" method="POST">
				<table align="center" class="box-table-a" width="600px"  cellpadding="0" cellspacing="0">
					<tr align="center">
						<th colspan="2">Add Product Stock Interface</th>
					</tr>
					<tr>
						<th> Add Stock Status : </th>
						<td align="center">
							<?php	if(!isset($_GET['add'])){
									}else{
										$add_result = $_GET['add'];
																
										if($add_result == "true"){
											echo "<span class=success>Stock successfully added.</span>";
										}else if($add_result == "false"){
											echo "<span>Stock could not add into database! Please try again later.</span>";
										}else if($add_result == "empty"){
											echo "<span>Please fill in the number of stock before add!</span>";
										}else if($add_result == "less"){
											echo "<span>Stock amount cannot be less than or 0!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th>Product Image : </th>
						<td >
							<img src="<?=$pro_display['product_image']?>" width="200px" height="200px" alt="<?=$pro_display['product_name']?>"/>
						</td>
					</tr>
					<tr>							
						<th style="padding-left:12px;">
							<label for="product_category">Category : </label>
						</th>
						<td>
							<?php	echo '<select disabled>';
									echo '<option value="">-Please select category...-</option>';

									while($pro_cat_display = mysqli_fetch_array($pro_cat)){
													
										if($pro_cat_display['category_name'] == $pro_display['product_category']){
											$select = "selected";
										}else{
											$select = "";
										}
							?>
									<option value="<?=$pro_cat_display['category_name']?>" <?=$select?>><?=$pro_cat_display['category_name']?></option>
															
							<?php	}
									echo "</select>";
							?>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_name">Name : </label>
						</th>
						<td>
							<input type="text" value="<?=$pro_display['product_name']?>" disabled/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_model">Product Class : </label>
						</th>
						<td>
							<select disabled>
								<option value="0">-Please select class...-</option>
								<?php	if($pro_display['product_class'] == 1){
											$product_se = "selected";
											$promotion_se = "";
										}else if($pro_display['product_class'] == 2){
											$product_se = "";
											$promotion_se = "selected";
										}
								?>
								<option value="1" <?=$product_se?>>Product</option>
								<option value="2" <?=$promotion_se?>>Promotion</option>
							</select>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_model">Product Model : </label>
						</th>
						<td>
							<input type="text" value="<?=$pro_display['product_model']?>" disabled/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							 <label for="product_price">Price : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_price']?>" disabled/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_price">Price (commercial) : </label>
						</th>
						<td>
							<input type="text" value="<?=$pro_display['product_commercial_price']?>" disabled />
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_price2">Price (grocery) : </label>
						</th>
						<td>
							<input type="text" value="<?=$pro_display['product_commercial_price2']?>" disabled />
						</td>
					</tr>
					<?php	if($pro_display['product_handling_show'] == 1){
								$check = "checked";
							}else{
								$check = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_handling">Handling Charge :</label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_handling']?>" disabled /> <input type="checkbox" name="show_charge" <?=$check?> disabled/> Show Charge
						</td>
					</tr>
					<?php	if($pro_display['product_commercial_handling_show'] == 1){
								$com_check = "checked";
							}else{
								$com_check = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_handling">Handling Charge (commercial) :</label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_commercial_handling']?>" disabled /> <input type="checkbox" name="show_commercial_charge" <?=$com_check?> disabled /> Show Charge
						</td>
					</tr>
					<?php	if($pro_display['product_commercial_handling_show2'] == 1){
								$com_check2 = "checked";
							}else{
								$com_check2 = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_handling2">Handling Charge (grocery) :</label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_commercial_handling2']?>" disabled /> <input type="checkbox" name="show_commercial_charge2" <?=$com_check2?> disabled /> Show Charge
						</td>
					</tr>
					<?php	if($pro_display['product_double_point'] == 1){
								$double_check = "checked";
							}else{
								$double_check = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_point">Product Point</label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_point']?>" disabled /> <input type="checkbox" name="double_point" <?=$double_check?> disabled /> Double Point
						</td>
					</tr>
					<?php	if($pro_display['product_commercial_double_point'] == 1){
								$com_double_check = "checked";
							}else{
								$com_double_check = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_point">Product Point (commercial) : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_commercial_point']?>" disabled />  <input type="checkbox" name="double_commercial_point" <?=$com_double_check?> disabled /> Double Point
						</td>
					</tr>
					<?php	if($pro_display['product_commercial_double_point2'] == 1){
								$com_double_check2 = "checked";
							}else{
								$com_double_check2 = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_point2">Product Point (grocery) : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_commercial_point2']?>" disabled /> <input type="checkbox" name="double_commercial_point2" <?=$com_double_check2?> disabled /> Double Point
						</td>
					</tr>
					<!--<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount1">Amount : </label>
							<label for="product_sale_percentage1">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount1" name="product_sale_amount1" value="<?//=$pro_display['product_sale1']?>" disabled/>
							</br>
							<input type="number" id="product_sale_percentage1" name="product_sale_percentage1" value="<?//=$pro_display['product_sale_percentage1']?>" disabled/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount2">Amount : </label>
							<label for="product_sale_percentage2">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount2" name="product_sale_amount2" value="<?//=$pro_display['product_sale2']?>" disabled/>
							</br>
							<input type="number" id="product_sale_percentage2" name="product_sale_percentage2" value="<?//=$pro_display['product_sale_percentage2']?>" disabled/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount3">Amount : </label>
							<label for="product_sale_percentage3">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount3" name="product_sale_amount3" value="<?//=$pro_display['product_sale3']?>" disabled/>
							</br>
							<input type="number" id="product_sale_percentage3" name="product_sale_percentage3" value="<?//=$pro_display['product_sale_percentage3']?>" disabled/>
						</td>
					</tr>-->
					<?php	if($pro_display['product_stock_class'] == "Quantity"){
								$quantity_check = "checked";
								$length_check = "";
								$measurement_display = "none";
							}else{
								$quantity_check = "";
								$length_check = "checked";
								$measurement_display = "block";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_stock_class">Product Stock Class : </label>
						</th>
						<td>
							<p>
								<input type="radio" name="product_stock_class" value="Quantity" onClick="showLength();" <?=$quantity_check?> disabled />Quantity
								<input type="radio" name="product_stock_class" value="Length" onClick="showLength();" <?=$length_check?> disabled />Length
							</p>
							<?php	if($pro_display['product_stock_class'] == "Quantity")
										$measurement_display = "none";
									else
										$measurement_display = "block";			
							?>
							<p style="padding-left:88px;display:<?=$measurement_display?>">
								<select disabled >
									<?php	$measure = array('Milimeter', 'Centimeter', 'Meter', 'Foot');
											
											for($i = 0; $i < sizeof($measure); $i++){
												if($measure[$i] == $pro_display['product_stock_class'])
													echo "<option value='".$measure[$i]."' selected >".$measure[$i]."</option>";
												else
													echo "<option value='".$measure[$i]."'>".$measure[$i]."</option>";
											}
									?>
								</select>
							</p>
						</td>
					</tr>
					<?php	if($pro_display['product_add_on'] == 1){
								$pro_addon = "checked";
							}else{
								$pro_addon = "";
							}
					?>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_add_on">Add on : </label>
						</th>
						<td>
							<input type="checkbox" name="product_add_on" <?=$pro_addon?> disabled /> Add On
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_stock">Stock number : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_stock']?>" disabled />
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_add_stock"><span class="compulsory">*</span>Add Stock : </label>
						</th>
						<td>
							<input type="number" id="product_add_stock" name="product_add_stock"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_stock_minimum">Product Minimum Sell Qty : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_stock_minimum']?>" disabled />
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_limit">Product Limit : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_limit']?>" disabled />
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_life_limit">Product Life Time Limit : </label>
						</th>
						<td>
							<input type="number" value="<?=$pro_display['product_lifetime_limit']?>" disabled />
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12px;">
							<label for="product_description">Description : </label>
						</th>
						<td>
							<textarea value="<?=$pro_display['product_description']?>" rows="3" cols="30" disabled></textarea>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="add_product_stock" value="Add Stock" onClick="return checkStock();" >
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;">
							<input type="button" name="back" onClick="backproduct();" value="Back"/><input type="hidden" id="view" value="<?=$view?>" />
						</td>
					</tr>
				</table>
			</form>
			
			<?php
				include('../footer.php');
			?>
		</div>
		<script>
			function checkStock(){
				if(document.getElementById("product_add_stock").value.length === 0){
					alert("Please fill in the number of stock before add!");
					return false;
				}else{
					
					var pro_add_stock = document.getElementById('product_add_stock').value;
					
					if(pro_add_stock <= 0){
						alert("Stock amount cannot be less than or 0!");
						return false;
					}
					
					return true;
				}
			}
			
			function backproduct(){
				var backCheck = confirm("Do you wish to go back?");
				
				if(backCheck){
					var view = document.getElementById('view').value;
					
						if(view == "ma"){
							window.location = "../main.php";
						}else{
							window.location = "view_product.php?hyperlink=products";
						}
				}else{
					
				}
			}
		</script>
	</body>
</html>