<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category");
?>

<html>
	<head>
		<title>Add Promotion</title>
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
						<li><a href="../product/view_product.php?hyperlink=products"><span>Product</span></a></li>   
						<li><a href="../product/add_product.php?hyperlink=products"><span>Add New Product</span></a></li>
						<li><a href="../category/category.php?hyperlink=products"><span>Product Category</span></a></li>
						<li><a href="../promotion/promotion.php?hyperlink=products"><span>Promotion</span></a></li>
						<li><a href="../promotion_category/promotion_category.php?hyperlink=products"><span>Promotion Category</span></a></li>
						<li><a href="../promotion/add_promotion.php?hyperlink=products" class="current"><span>Add Promotion</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../promotion/add_promotion.php?hyperlink=products">Add Promotion</a></p> 
			</div>
            <br />	
            <table border="0">
	            <tr>
		            <td>&nbsp;</td>
	            </tr>
            </table>
			
			<form enctype="multipart/form-data" action="save_promotion.php" method="POST">
				<table border="0" align="center" class="box-table-a" width="600px" height="200px" cellpadding="0" cellspacing="0">
					<tr>
						<th colspan="2" align="center">Add Promotion</th>
					</tr>
					<tr>
						<th width="200px" style="padding-left:12;">Status :</th>
						<td>
							<?php	if(!isset($_GET['save'])){
									}else{
										$save_result = $_GET['save'];
																			
										if($save_result == "true"){
											echo "<span class='success'>Promotion successfully saved.</span>";
										}else if($save_result == "false"){
											echo "<span>Promotion could not save into database! Please try again later.</span>";
										}else if($save_result == "iFalse"){
											echo "<span>Image(s) could not save into database! Please try again later.</span>";
										}else if($save_result == "empty"){
											echo "<span>Please enter all required fields before save!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="product_name"><span class="compulsory">*</span>Product Name :</label>
						</th>
						<td>
							<input type="text" name="product_name" id="product_name"/>
						</td>
					</tr>
					<tr>
						<th width="200px" style="padding-left:10px;">
							<label for="product_model">Product Model :</label>
						</th>
						<td>
							<input type="text" name="product_model"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="product_ori"><span class="compulsory">*</span>Product Original Price :</labe>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="product_ori" id="product_ori"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="product_new"><span class="compulsory">*</span>Product Sale Price :</label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="product_new" id="product_new"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="product_image"><span class="compulsory">*</span>Product Image : </label>
						</th>
						<td>
							<input type="file" id="product_image" name="product_image"/>
						</td>
					</tr>
					<tr>
						<th width="200px" style="padding-left:10px;">
							<label for="product_description">Product Description :</label>
						</th>
						<td>
							<textarea id="product_description" name="product_description" rows="5" cols="40"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">+</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="item_name"><span class="compulsory">*</span>Item Name :</label>
						</th>
						<td>
							<input type="text" id="item_name" name="item_name"/>
						</td>
					</tr>
					<tr>
						<th width="200px" style="padding-left:10px;">
							<label for="item_model">Item Model :</label>
						</th>
						<td>
							<input type="text" name="item_model"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="item_ori"><span class="compulsory">*</span>Item Original Price :</labe>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="item_ori" id="item_ori"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="item_new"><span class="compulsory">*</span>Item Sale Price :</label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="item_new" id="item_new"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="item_image"><span class="compulsory">*</span>Item Image : </label>
						</th>
						<td>
							<input type="file" id="item_image" name="item_image"/>
						</td>
					</tr>
					<tr>
						<th width="200px" style="padding-left:10px;">
							<label for="item_description">Item Description :</label>
						</th>
						<td>
							<textarea id="item_description" name="item_description" rows="5" cols="40"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">=</td>
					</tr>
					<tr>
						<th>
							<label for="promotion_cat"><span class="compulsory">*</span>Product Category :</label>
						</th>
						<td>
							<?php	echo '<select id="promotion_cat" name="promotion_cat">';
									echo '<option value="">-Please select category...-</option>';
														
									while($promo_cat_display = mysqli_fetch_array($promo_cat)){
							?>
										<option value="<?=$promo_cat_display['promotion_category_id']?>"><?=$promo_cat_display['promotion_category_name']?></option>
							<?php	}
									echo "</select>";
							?>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="package_name"><span class="compulsory">*</span>Package Name :</label>
						</th>
						<td>
							<input type="text" id="package_name" name="package_name"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="package_price"><span class="compulsory">*</span>Package Price :</labe>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="package_price" id="package_price"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="package_point"><span class="compulsory">*</span>Package Points : </label>
						</th>
						<td>
							<input type="number" id="package_point" name="package_point"/> <input type="checkbox" name="promo_double_point"/> Double Point
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="package_stock"><span class="compulsory">*</span>Package Stock : </label>
						</th>
						<td>
							<input type="number" id="package_stock" name="package_stock"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="package_limit"><span class="compulsory">*</span>Package Limit : </label>
						</th>
						<td>
							<input type="number" id="package_limit" name="package_limit"/>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="package_life_limit"><span class="compulsory">*</span>Package Life Time Limit : </label>
						</th>
						<td>
							<input type="number" id="package_life_limit" name="package_life_limit"/>
						</td>
					</tr>
					<tr width="200px">
						<th>
							<label for="new_date"><span class="compulsory">*</span>Start Date : </label>
						</th>
						<td>
							<input type="text" id="new_date" name="new_date" onclick="javascript:NewCssCal('new_date','yyyyMMdd','arrow')" style="cursor:pointer"/>
						</td>
					</tr>
					<tr width="200px">
						<th>
							<label for="end_date"><span class="compulsory">*</span>End Date : </label>
						</th>
						<td>
							<input type="text" id="end_date" name="end_date" onclick="javascript:NewCssCal('end_date','yyyyMMdd','arrow')" style="cursor:pointer"/>
						</td>
					</tr>
					<tr>
						<th width="200px" style="padding-left:10px;">
							<label for="package_description">Package Description :</label>
						</th>
						<td>
							<textarea id="package_description" name="package_description" rows="8" cols="40"></textarea>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">
							<input type="submit" name="add_package" value="Save" onClick="return checkEmptyFields();"/>
							<input type="reset" value="Clear" onClick="return confirmClear();"/>
						</th>
					</tr>
				</table>
			</form>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			
			<?php
				include('../footer.php');
			?>
		</div>
		
		<script>
			function checkEmptyFields(){
				var pro_cat = document.getElementById('promotion_cat').value.length;
				var pro_name = document.getElementById('product_name').value.length;
				var pro_ori = document.getElementById('product_ori').value.length;
				var pro_new = document.getElementById('product_new').value.length;
				var pro_img = document.getElementById('product_image').value.length;
				var item_name = document.getElementById('item_name').value.length;
				var item_ori = document.getElementById('item_ori').value.length;
				var item_new = document.getElementById('item_new').value.length;
				var item_img = document.getElementById('item_image').value.length;
				var pack_name = document.getElementById('package_name').value.length;
				var pack_price = document.getElementById('package_price').value.length;
				var pack_point = document.getElementById('package_point').value.length;
				var pack_new_date = document.getElementById('new_date').value;
				var pack_end_date = document.getElementById('end_date').value;
				var pack_stock = document.getElementById('package_stock').value.length;
				var pack_limit = document.getElementById('package_limit').value.length;
				var pack_life_limit = document.getElementById('package_life_limit').value.length;
				
				if(pro_name === 0 || pro_ori === 0 || pro_new === 0 || pro_img === 0 || item_name === 0 || item_ori === 0 || item_new === 0 || item_img === 0 || pro_cat ===0 || pack_name === 0 || pack_price === 0 || pack_point === 0 || pack_new_date == "" || pack_end_date == "" || pack_stock === 0 || pack_limit === 0 || pack_life_limit === 0){
					var message = "Please fill in the following field(s) before save!";
					
					if(pro_cat === 0)
						message = message + "\n-Product Category";
					if(pro_name === 0)
						message = message + "\n-Product Name";
					if(pro_ori === 0)
						message = message + "\n-Product Original Price";
					if(pro_new === 0)
						message = message + "\n-Product Sale Price";
					if(pro_img === 0)
						message = message + "\n-Product Image";
					if(item_name === 0)
						message = message + "\n-Item Name";
					if(item_ori === 0)
						message = message + "\n-Item Original Price";
					if(item_new === 0)
						message = message + "\n-Item Sale Price";
					if(item_img === 0)
						message = message + "\n-Item Image";
					if(pack_name === 0)
						message = message + "\n-Package Name";
					if(pack_price === 0)
						message = message + "\n-Package Price";
					if(pack_point === 0)
						message = message + "\n-Package Points";
					if(pack_new_date == "")
						message = message + "\n-Start Date";
					if(pack_end_date == "")
						message = message + "\n-End Date";
					if(pack_stock === 0)
						message = message + "\n-Package Stock";
					if(pack_limit === 0)
						message = message + "\n-Package Limit";
					if(pack_life_limit === 0)
						message = message + "\n-Package Life Time Limit";
					
					alert(message);
					return false;
				}else{
					if(pro_ori < 0 || pro_new < 0 || item_ori < 0 || item_new < 0 || pack_price < 0 || pack_point < 0 || pack_stock < 0){
						var pro_ori1 = document.getElementById('product_ori').value;
						var pro_new1 = document.getElementById('product_new').value;
						var item_ori1 = document.getElementById('item_ori').value;
						var item_new1 = document.getElementById('item_new').value;
						var pack_price1 = document.getElementById('package_price').value;
						var pack_stock1 = document.getElementById('package_stock').value;
						var pack_limit1 = document.getElementById('$pack_limit').value;
						var pack_life_limit1 = document.getElementById('$pack_life_limit').value;
						
						var message = "Please make sure the following field(s) is not negative number before save!";
						
						if(pro_ori1 < 0 || pro_ori1 == "")
							message = message + "\n-Product Original Price";
						if(pro_new1 < 0 || pro_new1 == "")
							message = message + "\n-Product Sale Price";
						if(item_ori1 < 0 || item_ori1 == "")
							message = message + "\n-Item Original Price";
						if(item_new1 < 0 || item_new1 == "")
							message = message + "\n-Product Sale Price";
						if(pack_price1 < 0 || pack_price1 == "")
							message = message + "\n-Package Price";
						if(pack_stock1 < 0 || pack_stock1 == "")
							message = message + "\n-Package Stock";
						if(pack_limit1 < 0 || pack_limit1 == "")
							message = message + "\n-Package Limit";
						if(pack_life_limit1 < 0 || pack_life_limit1 == "")
							message = message + "\n-Package Life Time Limit";
						
						return false;
					}
					
					var confirmSave = confirm("Do you wish to save the promotion?");
					
					if(confirmSave){
						return true;
					}else{
						return false;
					}
				}
			}
		
			function confirmClear(){
				var confirmClear = confirm("Do you wish to clear the form?");
					
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
			
			$(document).ready(function () {
				$( "#new_date" ).datepicker({
					changeMonth: true,
					changeYear: true 
				});
			});
			
			$(document).ready(function () {
				$( "#end_date" ).datepicker({
					changeMonth: true,
					changeYear: true 
				});
			});
		</script>
	</body>
</html>