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
?>
<?php
include('../header/header.php');
?>

<html>
	<head>
		<title>Edit Product</title>
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
			  <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../product/view_product.php?hyperlink=products">Products</a> >> <a href="#">Edit Product</a></p> 
			</div>	
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form enctype="multipart/form-data" action="edit_save_product.php?id=<?=$pro_id?>" method="POST">
				<table border="0" align="center" class="box-table-a" width="600px" height="200px" cellpadding="0" cellspacing="0">
					<tr>
						<th colspan="2" align="center">Edit Product</th>
					</tr>
					<tr>
						<th>Status :</th>
						<td align="center" colspan="2">
							<?php	if(!isset($_GET['save'])){
									}else{
										$save_result = $_GET['save'];
																
										if($save_result == "iFlase"){
											echo "<span>Photo could not save to database! Please try again later.</span>";
										}else if($save_result == "false"){
											echo "<span>Product could not save into database! Please try again later.</span>";
										}else if($save_result == "empty"){
											echo "<span>Please fill in the compulsory field(s) before save!</span>";
										}
									}				
							?>
						</td>
					</tr>
					<tr>
						<th>Product Image </th>	
						<td>
							<img src="<?=$pro_display['product_image']?>" width="200px" height="200px" alt="<?=$pro_display['product_name']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_category"><span class="compulsory">*</span>Product Category : </label>
						</th>
						<td>
							<?php	echo '<select id="product_category" name="product_category">';
									echo '<option value="">-Please select category...-</option>';

									while($pro_cat_display = mysqli_fetch_array($pro_cat)){
													
										if($pro_cat_display['category_name'] == $pro_display['product_category']){
											$select = "selected";
										}else{
											$select = "";
										}
							?>
										<option value="<?=$pro_cat_display['category_id']?>" <?=$select?>><?=$pro_cat_display['category_name']?></option>
															
							<?php	}
									echo "</select>";
							?>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_name"><span class="compulsory">*</span>Product Name : </label>
						</th>
						<td>
							<input type="text" id="product_name" name="product_name" value="<?=$pro_display['product_name']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_model"><span class="compulsory">*</span>Product Class : </label>
						</th>
						<td>
							<select id="product_class" name="product_class">
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
							<input type="text" id="product_model" name="product_model" value="<?=$pro_display['product_model']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							 <label for="product_price"><span class="compulsory">*</span>Product Price : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" id="product_price" name="product_price" value="<?=$pro_display['product_price']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="commercial_price"><span class="compulsory">*</span>Price (commercial) : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" id="commercial_price" name="commercial_price" value="<?=$pro_display['product_commercial_price']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="commercial_price2">Price (grocery) : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" id="commercial_price2" name="commercial_price2" value="<?=$pro_display['product_commercial_price2']?>"/>
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
							<input type="number" step="0.01" id="product_handling" name="product_handling" value="<?=$pro_display['product_handling']?>" onChange="checkHandling(this);" /> <input type="checkbox" name="show_charge" <?=$check?>/> Show Charge
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
							<input type="number" step="0.01" id="commercial_handling" name="commercial_handling" value="<?=$pro_display['product_commercial_handling']?>" onChange="checkCommercialHandling(this);" /> <input type="checkbox" name="show_commercial_charge" <?=$com_check?>/> Show Charge
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
							<input type="number" step="0.01" id="commercial_handling2" name="commercial_handling2" value="<?=$pro_display['product_commercial_handling2']?>" onChange="checkCommercialHandling(this);" /> <input type="checkbox" name="show_commercial_charge2" <?=$com_check2?>/> Show Charge
						</td>
					</tr>
					<?php	if($pro_display['product_double_point'] == 1){
								$double_check = "checked";
							}else{
								$double_check = "";
							}
					?>
					<tr>
						<th>
							<label for="product_point"><span class="compulsory">*</span>Product Point</label>
						</th>
						<td>
							<input type="number" step="1" id="product_point" name="product_point" value="<?=$pro_display['product_point']?>"/> <input type="checkbox" name="double_point" <?=$double_check?>/> Double Point
						</td>
					</tr>
					<?php	if($pro_display['product_commercial_double_point'] == 1){
								$com_double_check = "checked";
							}else{
								$com_double_check = "";
							}
					?>
					<tr>
						<th>
							<label for="commercial_point"><span class="compulsory">*</span>Product Point (commercial) : </label>
						</th>
						<td>
							<input type="number" step="1" id="commercial_point" name="commercial_point" value="<?=$pro_display['product_commercial_point']?>"/> <input type="checkbox" name="double_commercial_point" <?=$com_double_check?>/> Double Point
						</td>
					</tr>
					<?php	if($pro_display['product_commercial_double_point2'] == 1){
								$com_double_check2 = "checked";
							}else{
								$com_double_check2 = "";
							}
					?>
					<tr>
						<th>
							<label for="commercial_point2"><span class="compulsory">*</span>Product Point (grocery) : </label>
						</th>
						<td>
							<input type="number" step="1" id="commercial_point2" name="commercial_point2" value="<?=$pro_display['product_commercial_point2']?>"/> <input type="checkbox" name="double_commercial_point2" <?=$com_double_check2?>/> Double Point
						</td>
					</tr>
					<!--<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount1">Amount : </label>
							<label for="product_sale_percentage1">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount1" name="product_sale_amount1" value="<?//=$pro_display['product_sale1']?>"/>
							</br>
							<input type="number" id="product_sale_percentage1" name="product_sale_percentage1" value="<?//=$pro_display['product_sale_percentage1']?>" onChange="checkDiscount(this);"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount2">Amount : </label>
							<label for="product_sale_percentage2">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount2" name="product_sale_amount2" value="<?//=$pro_display['product_sale2']?>"/>
							</br>
							<input type="number" id="product_sale_percentage2" name="product_sale_percentage2" value="<?//=$pro_display['product_sale_percentage2']?>" onChange="checkDiscount(this);"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount3">Amount : </label>
							<label for="product_sale_percentage3">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount3" name="product_sale_amount3" value="<?//=$pro_display['product_sale3']?>"/>
							</br>
							<input type="number" id="product_sale_percentage3" name="product_sale_percentage3" value="<?//=$pro_display['product_sale_percentage3']?>" onChange="checkDiscount(this);"/>
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
								<input type="radio" name="product_stock_class" id="product_stock_quantity" value="Quantity" onClick="showLength();" <?=$quantity_check?>/>Quantity
								<input type="radio" name="product_stock_class" id="product_stock_length" value="Length" onClick="showLength();" <?=$length_check?>/>Length
							</p>
							<p style="padding-left:88px;display:<?=$measurement_display?>" id="length_toggle">
								<select name="product_stock_length_measure" id="product_stock_length_measure">
									<?php	$measure = array('Milimeter', 'Centimeter', 'Meter', 'Feet');
											
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
							<input type="checkbox" name="product_add_on" <?=$pro_addon?>/> Add On
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_stock">Stock number : </label>
						</th>
						<td>
							<input type="number" id="product_stock" name="product_stock" value="<?=$pro_display['product_stock']?>" /> <input type="checkbox" name="manual"/> Walk in order
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_stock_minimum">Product Minimum Sell Qty : </label>
						</th>
						<td>
							<input type="number" id="product_stock_minimum" name="product_stock_minimum" value="<?=$pro_display['product_stock_minimum']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_limit">Product Limit : </label>
						</th>
						<td>
							<input type="number" id="product_limit" name="product_limit" value="<?=$pro_display['product_limit']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_life_limit">Product Life Time Limit : </label>
						</th>
						<td>
							<input type="number" id="product_life_limit" name="product_life_limit" value="<?=$pro_display['product_lifetime_limit']?>"/>
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12px;">
							<label for="product_description">New Product Description : </label>
						</th>
						<td>
							<textarea id="product_description" name="product_description" rows="8" cols="40"><?=$pro_display['product_description']?></textarea>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_image">New Product Image : </label>
						</th>
						<td>
							<input type="file" id="product_image" name="product_image"/>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="save_edit_product" value="Save" onClick="return checkEmptyFields();"/>
							<input type="reset" name="reset_product_fields" value="Restore" onClick="return clearFields();"/>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;padding-top:30;">
							<input type="button" name="back" onClick="backProduct();" value="Back"/>
						</td>
					</tr>
				</table>
			</form>
						
			<?php
				include('../footer.php');
			?>
		</div>		
			
		<script>
			function showLength(){
				if(document.getElementById('product_stock_quantity').checked)
					document.getElementById('length_toggle').style.display = "none";
				else
					document.getElementById('length_toggle').style.display = "block";
			}
			
			function checkEmptyFields(){
				var pro_category = document.getElementById('product_category').value.length;
				var pro_name = document.getElementById('product_name').value.length;
				var pro_class = document.getElementById('product_class').value;
				var pro_price = document.getElementById('product_price').value.length;
				var com_price = document.getElementById('commercial_price').value.length;
				var pro_point = document.getElementById('product_point').value.length;
				var com_point = document.getElementById('commercial_point').value.length;
				
				var pro_price1 = document.getElementById('product_price').value;
				var com_price1 = document.getElementById('commercial_price').value;
				var pro_point1 = document.getElementById('product_point').value;
				var com_point1 = document.getElementById('commercial_point').value;
				/*var pro_stock1 = document.getElementById('product_stock').value;
				var pro_sale1 = document.getElementById('product_sale_percentage1').value;
				var pro_sale2 = document.getElementById('product_sale_percentage2').value;
				var pro_sale3 = document.getElementById('product_sale_percentage3').value;*/
					
				if(pro_category === 0 || pro_name === 0 || pro_class == 0 || pro_price === 0 || com_price === 0|| pro_point === 0 || com_point === 0){
					var message = "Please fill in the following field(s) before save!";
					
					if(pro_category === 0)
						message = message + "\n-Product Category";
					if(pro_name === 0)
						message = message + "\n-Product Name";
					if(pro_class == 0)
						message = message + "\n-Product Class";
					if(pro_price === 0)
						message = message + "\n-Product Price";
					if(com_price === 0)
						message = message + "\n-Product Price (commercial)";
					if(pro_point === 0)
						message = message + "\n-Product Point";
					if(com_point === 0)
						message = message + "\n-Product Point (commercial)";
						
					alert(message);
					return false;
				}else{
					if(pro_price1 < 0){
						alert("Price cannot be less than RM 0");
						return false;
					}
					
					if(com_price1 < 0){
						alert("Price (commercial) cannot be less than RM 0");
						return false;
					}
					
					if(pro_point1 < 0){
						alert("Point cannot be less than 0");
						return false;
					}
					
					if(com_point1 < 0){
						alert("Point (commercial) cannot be less than 0");
						return false;
					}
						
					/*if((pro_sale1 < 0 || pro_sale1 > 100) || (pro_sale2 < 0 || pro_sale2 > 100) || (pro_sale3 < 0 || pro_sale3 > 100)){
						alert("Sale percentage cannot be less than 0% or more than 100%");
						return false;
					}*/
						
					var confirm_save = confirm("Do you wish to edit the product?");
					
					if(confirm_save){
						return true;
					}else{
						return false;
					}
				}
			}
				
			/*function checkDiscount(discount){
				var dis1 = document.getElementById('product_sale_percentage1').value;
				var dis2 = document.getElementById('product_sale_percentage2').value;
				var dis3 = document.getElementById('product_sale_percentage3').value;
					
				if(dis1 > 100 || dis2 > 100 || dis3 > 100){
					alert("Sale percentage cannot be more than 100%");
				}else if(dis1 < 0 || dis2 < 0 || dis3 < 0){
					alert("Sale percentage cannot be less than 0%");
				}
			}*/
				
			function clearFields(){
				var confirmClear = confirm("Do you wish to restore the form to previous data?");
					
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
				
			function backProduct(){
				var backCheck = confirm("Do you wish to go back?");
					
				if(backCheck){
					window.location = "view_product.php?hyperlink=products";
				}else{
				}
			}
		</script>
	</body>
</html>