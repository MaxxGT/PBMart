<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_category");
?>

<html>
	<head>
		<title>Add Product</title>
		<link rel="stylesheet" type="text/css" href="../js/alert/alert.css"/>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
		
		<script type="text/javascript" src="../js/alert/confirm.js"></script>
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
		<!--<div id="dialogoverlay"></div>
		<div id="dialogbox">
			<div>
				<div id="dialogboxhead"></div>
				<div id="dialogboxbody"></div>
				<div id="dialogboxfoot"></div>
			</div>
		</div>-->
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="../product/view_product.php?hyperlink=products"><span>Product</span></a></li>
						<li><a href="../product/add_product.php?hyperlink=products" class="current"><span>Add New Product</span></a></li>
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
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../product/view_product.php?hyperlink=products">Products</a> >> <a href="../product/add_product.php?hyperlink=products">Add New Product</a></p> 
			</div>
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form enctype="multipart/form-data" action="save_product.php" method="POST">
				<table border="0" class="box-table-a" width="650px">
					<tr>
						<th colspan="2" align="center"> Add Product  </th>
					</tr>
					<tr>
						<th style="padding-left:12;">Status :</th>
						<td align="center">
							<?php	if(!isset($_GET['save'])){
									}else{
										$save_result = $_GET['save'];
																			
										if($save_result == "true"){
											echo "<span class='success'>Product successfully saved.</span>";
										}else if($save_result == "false"){
											echo "<span>Product could not save into database! Please try again later.</span>";
										}else if($save_result == "iFalse"){
											echo "<span>Image could not save into database! Please try again later.";
										}else if($save_result == "empty"){
											echo "<span>Please fill in compulsory field(s) before save!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_category"><span class="compulsory">*</span>Product Category : </label>
						</th>
						<td>
							<input type="hidden" name="category_id" id="product_category_id"/>
							<?php	echo '<select id="product_category" name="product_category">';
									echo '<option value="">-Please select category...-</option>';
														
									while($pro_cat_display = mysqli_fetch_array($pro_cat)){
							?>
										<option value="<?=$pro_cat_display['category_id']?>"><?=$pro_cat_display['category_name']?></option>
															
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
							<input type="text" id="product_name" name="product_name"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_model"><span class="compulsory">*</span>Product Class : </label>
						</th>
						<td>
							<select id="product_class" name="product_class">
								<option value="0">-Please select class...-</option>
								<option value="1">Product</option>
								<option value="2">Promotion</option>
							</select>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_model">Product Model : </label>
						</th>
						<td>
							<input type="text" id="product_model" name="product_model"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_price"><span class="compulsory">*</span>Price : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" id="product_price" name="product_price" onChange="checkPrice(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="commercial_price"><span class="compulsory">*</span>Price (commercial) : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" id="commercial_price" name="commercial_price" onChange="checkPrice(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="commercial_price2"><span class="compulsory">*</span>Price (grocery) : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" id="commercial_price2" name="commercial_price2" onChange="checkPrice(this)"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_handling">Handling Charge :</label>
						</th>
						<td>
							<input type="number" step="0.01" id="product_handling" name="product_handling" onChange="checkHandling(this);" /> <input type="checkbox" name="show_charge"/> Show Charge
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="commercial_handling">Handling Charge (commercial) :</label>
						</th>
						<td>
							<input type="number" step="0.01" id="commercial_handling" name="commercial_handling" onChange="checkCommercialHandling(this);" /> <input type="checkbox" name="show_commercial_charge"/> Show Charge
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="commercial_handling2">Handling Charge (grocery) :</label>
						</th>
						<td>
							<input type="number" step="0.01" id="commercial_handling2" name="commercial_handling2" onChange="checkCommercialHandling(this);" /> <input type="checkbox" name="show_commercial_charge2"/> Show Charge
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_point"><span class="compulsory">*</span>Product Point : </label>
						</th>
						<td>
							<input type="number" step="1" id="product_point" name="product_point" onChange="checkPoint(this);"/> <input type="checkbox" name="double_point"/> Double Point
						</td>
					</tr>
					<tr>
						<th>
							<label for="commercial_point"><span class="compulsory">*</span>Product Point (commercial) : </label>
						</th>
						<td>
							<input type="number" step="1" id="commercial_point" name="commercial_point" onChange="checkComPoint(this);"/> <input type="checkbox" name="double_commercial_point"/> Double Point
						</td>
					</tr>
					<tr>
						<th>
							<label for="commercial_point2"><span class="compulsory">*</span>Product Point (grocery) : </label>
						</th>
						<td>
							<input type="number" step="1" id="commercial_point2" name="commercial_point2"/> <input type="checkbox" name="double_commercial_point2"/> Double Point
						</td>
					</tr>
					<!--<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount1">Amount : </label>
							<label for="product_sale_percentage1">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount1" name="product_sale_amount1" value="3"/>
							<br />
							<input type="number" id="product_sale_percentage1" name="product_sale_percentage1" onChange="checkDiscount(this);"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount2">Amount : </label>
							<label for="product_sale_percentage2">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount2" name="product_sale_amount2" value="5"/>
							<br />
							<input type="number" id="product_sale_percentage2" name="product_sale_percentage2" onChange="checkDiscount(this);"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_sale_amount3">Amount : </label>
							<label for="product_sale_percentage3">Sale percentage : </label>
						</th>
						<td>
							<input type="number" id="product_sale_amount3" name="product_sale_amount3" value="8"/>
							<br />
							<input type="number" id="product_sale_percentage3" name="product_sale_percentage3" onChange="checkDiscount(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_stock_type"><span class="compulsory">*</span>Product Stock Type : </label>
						</th>
						<td>
							<select name="product_stock_type" id="product_stock_type" onChange="stock_in();">
								<option value="">-Please select type...-</option>
								<option value="restock">Re-stockable</option>
								<option value="unstock">Un-stockable</option>
								<option value="service">Service</option>
							</select>
						</td>
					</tr>-->
					<tr>
						<th>
							<label for="product_stock_class"><span class="compulsory">*</span>Product Stock Class : </label>
						</th>
						<td>
							<p>
								<input type="radio" name="product_stock_class" id="product_stock_quantity" value="Quantity" onClick="showLength();"/>Quantity
								<input type="radio" name="product_stock_class" id="product_stock_length" value="Length" onClick="showLength();"/>Length
							</p>
							<p style="padding-left:88px;display:none" id="length_toggle">
								<select name="product_stock_length_measure" id="product_stock_length_measure">
									<option value="Milimeter">Milimeter</option>
									<option value="Centimeter">Centimeter</option>
									<option value="Meter">Meter</option>
									<option value="Feet">Feet</option>
								</select>
							</p>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="product_add_on">Add on : </label>
						</th>
						<td>
							<input type="checkbox" name="product_add_on"/> Add On
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_stock"><span class="compulsory">*</span>Product Stock Qty : </label>
						</th>
						<td>
							<input type="number" id="product_stock" name="product_stock" onChange="checkStock(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_stock_minimum"><span class="compulsory">*</span>Product Minimum Sell Qty : </label>
						</th>
						<td>
							<input type="number" id="product_stock_minimum" name="product_stock_minimum" onChange="checkStockMin(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_limit"><span class="compulsory">*</span>Product Limit : </label>
						</th>
						<td>
							<input type="number" id="product_limit" name="product_limit" onChange="checkLimit(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_life_limit"><span class="compulsory">*</span>Product Life Time Limit : </label>
						</th>
						<td>
							<input type="number" id="product_life_limit" name="product_life_limit" onChange="checkLifeLimit(this);"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_image"><span class="compulsory">*</span>Product Image : </label>
						</th>
						<td>
							<input type="file" id="product_image" name="product_image"/>
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="product_description">Product Description : </label>
						</th>
						<td>
							<textarea id="product_description" name="product_description" rows="8" cols="40"></textarea>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">
							<input type="submit" name="save_product" value="Save" onClick="return checkEmptyFields2();"/>
							<input type="reset" name="reset_product_fields" value="Clear" onClick="return clearFields();"/>
						</th>
					</tr>
				</table>
			</form>
		</div>
			
		<div class="grid_16" id="content">
			<?php
				include('../footer.php');
			?>
		</div>		
			
		<?php	//include ('../js/alert/alert.php');	?>
		<?php	//include ('../js/alert/confirm.php');	?>
		<script>
			function showLength(){
				if(document.getElementById('product_stock_quantity').checked)
					document.getElementById('length_toggle').style.display = "none";
				else
					document.getElementById('length_toggle').style.display = "block";
			}
		
			function checkEmptyFields(){
				var pro_cat = document.getElementById('product_category').value.length;
				var pro_name = document.getElementById('product_name').value.length;
				var pro_class = document.getElementById('product_class').value;
				var pro_price = document.getElementById('product_price').value.length;
				var com_price = document.getElementById('commercial_price').value.length;
				var com_price2 = document.getElementById('commercial_price2').value.length;
				var pro_point = document.getElementById('product_point').value.length;
				var com_point = document.getElementById('commercial_point').value.length;
				
				if(document.getElementById('product_stock_quantity').checked || document.getElementById('product_stock_length').checked){
					var pro_stock_class = 1;
					var pro_stock_length = document.getElementById('product_stock_length_measure').value;
				}else{
					var pro_stock_class = "";
				}
				
				var pro_stock = document.getElementById('product_stock').value.length;
				var pro_stock_min = document.getElementById('product_stock_minimum').value.length;
				var pro_limit = document.getElementById('product_limit').value.length;
				var pro_life_limit = document.getElementById('product_life_limit').value.length;
				var pro_image = document.getElementById('product_image').value.length;
					
				var pro_price1 = document.getElementById('product_price').value;
				var com_price1 = document.getElementById('commercial_price').value;
				var com_price22 = document.getElementById('commercial_price2').value;
				var pro_point1 = document.getElementById('product_point').value;
				var com_point1 = document.getElementById('commercial_point').value;
				var pro_stock1 = document.getElementById('product_stock').value;
				var pro_stock_min1 = document.getElementById('product_stock_minimum').value;
				var pro_limit1 = document.getElementById('product_limit').value;
				var pro_life_limit1 = document.getElementById('product_life_limit').value;
				/*var pro_sale1 = document.getElementById('product_sale_percentage1').value;
				var pro_sale2 = document.getElementById('product_sale_percentage2').value;
				var pro_sale3 = document.getElementById('product_sale_percentage3').value;*/
					
				if(pro_cat === 0 || pro_name === 0 || pro_class == 0 || pro_price === 0 || com_price === 0 || com_price2 === 0 || pro_point === 0 || com_point === 0 || pro_stock_class == "" || pro_stock == 0 || pro_stock_min == 0 || pro_limit == 0 || pro_life_limit == 0 || pro_image === 0){
					//var message = "Please fill in the field(s) marked with * before save!";
					var message = "Please fill in the following field(s) before save!";
					
					if(pro_cat === 0)
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
					if(pro_stock_class == "")
						message = message + "\n-Product Stock Class";
					if(pro_stock === 0)
						message = message + "\n-Product Stock";
					if(pro_stock_min === 0)
						message = message + "\n-Product Minimum Sell Quantity";
					if(pro_limit === 0)
						message = message + "\n-Product Limit";
					if(pro_life_limit === 0)
						message = message + "\n-Product Life Time Limit";
					if(pro_image === 0)
						message = message + "\n-Product Photo";
						
					//Alert.render(message);
					alert(message);
					return false;
				}else{
					
					if(pro_price1 < 0){
						//Alert.render("Price cannot be less than RM 0");
						alert("Price cannot be less than RM 0");
						return false;
					}
					
					if(com_price1 < 0){
						//Alert.render("Price cannot be less than RM 0");
						alert("Price (commercial) cannot be less than RM 0");
						return false;
					}
					
					if(com_price22 < 0){
						//Alert.render("Price cannot be less than RM 0");
						alert("Price (grocery) cannot be less than RM 0");
						return false;
					}
					
					if(pro_point1 < 0){
						//Alert.render("Point cannot be less than 0");
						alert("Point cannot be less than 0");
						return false;
					}
					
					if(com_point1 < 0){
						//Alert.render("Point cannot be less than 0");
						alert("Point (commercial) cannot be less than 0");
						return false;
					}
					
					if(pro_stock_length < 0){
						alert("Product Stock measurement cannot be less than 0");
						return false;
					}
					
					if(pro_stock1 < 0){
						//Alert.render("Stock amount cannot be less than 0");
						alert("Stock amount cannot be less than 0");
						return false;
					}	
					
					if(pro_stock_min1 < 0){
						//Alert.render("Stock amount cannot be less than 0");
						alert("Stock minimum selling quantity cannot be less than 0");
						return false;
					}
						
					if(pro_limit1 < 0){
						//Alert.render("Stock amount cannot be less than 0");
						alert("Product limit cannot be less than 0");
						return false;
					}
						
					if(pro_life_limit1 < 0){
						//Alert.render("Stock amount cannot be less than 0");
						alert("Product life time limit cannot be less than 0");
						return false;
					}
					
					/*if((pro_sale1 < 0 || pro_sale1 > 100) || (pro_sale2 < 0 || pro_sale2 > 100) || (pro_sale3 < 0 || pro_sale3 > 100)){
						//Alert.render("Sale percentage cannot be less than 0% or more than 100%");
						alert("Sale percentage cannot be less than 0% or more than 100%");
						return false;
					}*/
						
					var confirm_save = confirm("Do you wish to save the product?");
					
					if(confirm_save){
						return true;
					}else{
						return false;
					}
				}
			}
				
			function clearFields(){
				var confirmClear = confirm("Do you wish to clear the form?");
				/*var message = "Do you wish to clear the form?";
				Confirm.render(message);
				*/
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
				
			function checkPrice(price){
				var price = document.getElementById('product_price').value;
					
				if(price < 0){
					//Alert.render("Price cannot be less than RM 0");
					alert("Price cannot be less than RM 0");
				}
			}
			
			function checkPoint(point){
				var point = document.getElementById('product_point').value;
					
				if(point < 0){
					//Alert.render("Point cannot be less than 0");
					alert("Point cannot be less than 0");
				}
			}
			
			function checkComPoint(point){
				var com_point = document.getElementById('commercial_point').value;
					
				if(com_point < 0){
					//Alert.render("Point cannot be less than 0");
					alert("Point (commercial) cannot be less than 0");
				}
			}
			
			function checkHandling(handling){
				var hand = document.getElementById('product_handling').value;
				
				if(hand < 0){
					//Alert.render("Handling charge cannot be less than RM 0");
					alert("Handling charge cannot be less than RM 0");
				}
			}
			
			function show_commercial_charge(handling){
				var hand = document.getElementById('commercial_handling').value;
				
				if(hand < 0){
					//Alert.render("Handling charge cannot be less than RM 0");
					alert("Handling charge (commercial) cannot be less than RM 0");
				}
			}
			
			/*function checkDiscount(discount){
				var dis1 = document.getElementById('product_sale_percentage1').value;
				var dis2 = document.getElementById('product_sale_percentage2').value;
				var dis3 = document.getElementById('product_sale_percentage3').value;
					
				if(dis1 > 100 || dis2 > 100 || dis3 > 100){
					//Alert.render("Sale percentage cannot be more than 100%");
					alert("Sale percentage cannot be more than 100%");
				}else if(dis1 < 0 || dis2 < 0 || dis3 < 0){
					//Alert.render("Sale percentage cannot be less than 0%");
					alert("Sale percentage cannot be less than 0%");
				}
			}*/
				
			function checkStock(stock){
				var stock = document.getElementById('product_stock').value;
				
				if(stock < 0){
					//Alert.render("Stock amount cannot be less than 0");
					alert("Stock amount cannot be less than 0");
				}
			}
				
			function checkStockMin(minimum){
				var minimum = document.getElementById('product_stock_minimum').value;
				
				if(minimum < 0){
					//Alert.render("Stock amount cannot be less than 0");
					alert("Stock minimum selling quantity cannot be less than 0");
				}
			}
			
			function checkLimit(limit){
				var limit = document.getElementById('product_limit').value;
				
				if(limit < 0){
					//Alert.render("Stock amount cannot be less than 0");
					alert("Product limit cannot be less than 0");
				}
			}
				
			function checkLifeLimit(limit){
				var limit = document.getElementById('product_life_limit').value;
				
				if(limit < 0){
					//Alert.render("Stock amount cannot be less than 0");
					alert("Product life time limit cannot be less than 0");
				}
			}
		</script>
	</body>
</html>