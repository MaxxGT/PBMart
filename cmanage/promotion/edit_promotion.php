<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$pro_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	
	$promo = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_id='$pro_id'");
	$promo_display = mysqli_fetch_assoc($promo);
	
	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='".$promo_display['promotion_category_id']."'");
	$promo_cat_display = mysqli_fetch_assoc($promo_cat);
?>

<html>
	<head>
		<title>Edit Promotion</title>
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
						<li><a href="../promotion/promotion.php?hyperlink=products" class="current"><span>Promotion</span></a></li>
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
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form enctype="multipart/form-data" action="edit_save_promotion.php?pro=<?=$pro_id?>" method="POST">
				<table border="2" align="center" width="900px" cellpadding="0" class="box-table-a" cellspacing="0">
					<tr>
						<th colspan="4" align="center">Promotion Management</th>
					</tr>
					<tr>
						<th width="280px" colspan="1">Status :</th>
						<td colspan="3">
							<?php	if(!isset($_GET['save'])){
									}else{
										$save_result = $_GET['save'];
																			
										if($save_result == "true"){
											echo "<span style='color:green;'>Promotion successfully saved.</span>";
										}else if($save_result == "false"){
											echo "<span>Promotion could not save into database! Please try again later.</span>";
										}else if($save_result == "empty"){
											echo "<span>Please enter the required field(s) before save!</span>";
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
					<?php	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category");
					?>
					<tr>
						<th>
							<label for="promotion_cat"><span class="compulsory">*</span>Product Category :</label>
						</th>
						<td colspan="3">
							<?php	echo '<select id="promotion_cat" name="promotion_cat">';
									echo '<option value="">-Please select category...-</option>';
														
									while($promo_cat_display = mysqli_fetch_array($promo_cat)){
										if($promo_display['promotion_category_id'] == $promo_cat_display['promotion_category_id']){
											$select = "selected";
										}else{
											$select = "";
										}
							?>
										<option value="<?=$promo_cat_display['promotion_category_id']?>" <?=$select?>><?=$promo_cat_display['promotion_category_name']?></option>
							<?php	}
									echo "</select>";
							?>
						</td>
					</tr>
					<tr>
						<th>
							<label for="package_name"><span class="compulsory">*</span>Package Name :</label>
						</th>
						<td colspan="3">
							<input type="text" name="package_name" id="package_name" value="<?=$promo_display['promotion_package_name']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="package_price"><span class="compulsory">*</span>Package Price :</label>
						</th>
						<td colspan="3">
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="package_price" id="package_price" value="<?=$promo_display['promotion_package_price']?>"/>
						</td>
					</tr>
					<?php	if($promo_display['promotion_package_double_point'] == 1){
								$double = "checked";
							}else{
								$double = "";
							}
					?>
					<tr>
						<th>
							<label for="package_point"><span class="compulsory">*</span>Package Points : </label>
						</th>
						<td colspan="3">
							<input type="number" id="package_point" name="package_point" value="<?=$promo_display['promotion_package_point']?>"/> <input type="checkbox" name="promo_double_point" <?=$double?>/> Double Point
						</td>
					</tr>
					<tr>
						<th>
							<label for="package_stock"><span class="compulsory">*</span>Package stock :</label>
						</th>
						<td colspan="3">
							<input type="number" id="package_stock" name="package_stock" value="<?=$promo_display['promotion_package_stock']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="package_limit"><span class="compulsory">*</span>Package Limit :</label>
						</th>
						<td colspan="3">
							<input type="number" id="package_limit" name="package_limit" value="<?=$promo_display['promotion_package_limit']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="package_life_limit"><span class="compulsory">*</span>Package Life Limit :</label>
						</th>
						<td colspan="3">
							<input type="number" id="package_life_limit" name="package_life_limit" value="<?=$promo_display['promotion_package_lifetime_limit']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="new_date"><span class="compulsory">*</span>Start Date : </label>
						</th>
						<td colspan="3">
							<input type="text" id="new_date" name="new_date" value="<?=$promo_display['promotion_start_date']?>" onclick="javascript:NewCssCal('new_date','yyyyMMdd','arrow')" style="cursor:pointer"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="end_date"><span class="compulsory">*</span>End Date : </label>
						</th>
						<td colspan="3">
							<input type="text" id="end_date" name="end_date" value="<?=$promo_display['promotion_end_date']?>" onclick="javascript:NewCssCal('end_date','yyyyMMdd','arrow')" style="cursor:pointer"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="package_description">Package Description :</label>
						</th>
						<td colspan="3">
							<textarea id="package_description" name="package_description" rows="4" cols="40"><?=$promo_display['promotion_package_description']?></textarea>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center">Package Item</th>
					</tr>
					<tr>
						<th width="220px" style="padding-left:12;">Product Image :</th>
						<td width="240px"><img src="<?=$promo_display['promotion_product_photo']?>" alt="<?=$promo_display['promotion_product_name']?>" width="200px" height="200px"></td>
						<th width="100px" style="padding-left:12;">Item Image :</th>
						<td width="240px"><img src="<?=$promo_display['promotion_item_photo']?>" alt="<?=$promo_display['promotion_item_name']?>" width="200px" height="200px"/></td>
					</tr>
					<tr>
						<th>
							<label for="product_name"><span class="compulsory">*</span>Product Name :</label>
						</th>
						<td>
							<input type="text" name="product_name" id="product_name" value="<?=$promo_display['promotion_product_name']?>"/>
						</td>
						<th>
							<label for="item_name"><span class="compulsory">*</span>Item Name :</label>
						</th>
						<td>
							<input type="text" name="item_name" id="item_name" value="<?=$promo_display['promotion_item_name']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_model">Product Model :</label>
						</th>
						<td>
							<input type="text" name="product_model" value="<?=$promo_display['promotion_product_model']?>"/>
						</td>
						<th style="padding-left:12;">
							<label for="item_model">Item Model :</label>
						</th>
						<td>
							<input type="text" name="item_model" value="<?=$promo_display['promotion_item_model']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_ori"><span class="compulsory">*</span>Product Price : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="product_ori" id="product_ori" value="<?=$promo_display['promotion_product_price']?>"/>
						</td>
						<th>
							<label for="item_ori"><span class="compulsory">*</span>Item Price : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="item_ori" id="item_ori" value="<?=$promo_display['promotion_item_price']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="product_new"><span class="compulsory">*</span>Product Sale : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="product_new" id="product_new" value="<?=$promo_display['promotion_product_sale']?>"/>
						</td>
						<th>
							<label for="item_new"><span class="compulsory">*</span>Item Sale : </label>
						</th>
						<td>
							<input type="text" pattern="[0-9]*|[0-9]*.[0-9]{2}" name="item_new" id="item_new" value="<?=$promo_display['promotion_item_sale']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_image">Product Image : </label>
						</th>
						<td>
							<input type="file" name="product_image"/>
						</td>
						<th style="padding-left:12;">
							<label for="item_image">Item Image : </label>
						</th>
						<td>
							<input type="file" name="item_image"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="product_description">Product Description :</label>
						</th>
						<td style="vertical-align:middle;">
							<textarea name="product_description" rows="5" cols="30"><?=$promo_display['promotion_product_description']?></textarea>
						</td>
						<th width="110px" style="padding-left:12;">
							<label for="item_description">Item Description :</label>
						</th>
						<td>
							<textarea name="item_description" rows="5" cols="30"><?=$promo_display['promotion_item_description']?></textarea>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center">
							<input type="submit" name="edit_save_promotion" value="Save" onClick="return checkEmptyFields();"/> | <input type="reset" value="Restore" onClick="return clearFields();"/>
						</th>
					</tr>
					<tr>
						<td style="border-style:hidden;padding-top:30;">
							<input type="button" name="back" onClick="backProduct();" value="Back"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
		
		<div class="grid_16" id="content">
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
				var item_name = document.getElementById('item_name').value.length;
				var item_ori = document.getElementById('item_ori').value.length;
				var item_new = document.getElementById('item_new').value.length;
				var pack_name = document.getElementById('package_name').value.length;
				var pack_price = document.getElementById('package_price').value.length;
				var pack_point = document.getElementById('package_point').value.length;
				var pack_stock = document.getElementById('package_stock').value.length;
				var pack_limit = document.getElementById('package_limit').value.length;
				var pack_life_limit = document.getElementById('package_life_limit').value.length;
				var pack_new_date = document.getElementById('new_date').value;
				var pack_end_date = document.getElementById('end_date').value;
				
				if(pro_cat === 0 || pro_name === 0 || pro_ori === 0 || pro_new === 0  || item_name === 0 || item_ori === 0 || item_new === 0 || pack_name === 0 || pack_price === 0 || pack_point === 0 || pack_stock === 0 || pack_limit === 0 || pack_life_limit === 0 || pack_new_date == "" || pack_end_date == ""){
					var message = "Please fill in the following field(s) before save!";
					
					if(pro_cat === 0)
						message = message + "\n-Product Category";
					if(pro_name === 0)
						message = message + "\n-Product Name";
					if(pro_ori === 0)
						message = message + "\n-Product Original Price";
					if(pro_new === 0)
						message = message + "\n-Product Sale Price";
					if(item_name === 0)
						message = message + "\n-Item Name";
					if(item_ori === 0)
						message = message + "\n-Item Original Price";
					if(item_new === 0)
						message = message + "\n-Item Sale Price";
					if(pack_name === 0)
						message = message + "\n-Package Name";
					if(pack_price === 0)
						message = message + "\n-Package Price";
					if(pack_point === 0)
						message = message + "\n-Package Points";
					if(pack_stock === 0)
						message = message + "\n-Package Stock";
					if(pack_limit === 0)
						message = message + "\n-Package Limit";
					if(pack_life_limit === 0)
						message = message + "\n-Package Life Time Limit";
					if(pack_new_date == "")
						message = message + "\n-Start Date";
					if(pack_end_date == "")
						message = message + "\n-End Date";
					
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
						var pack_limit1 = document.getElementById('package_limit').value;
						var pack_life_limit1 = document.getElementById('package_life_limit').value;
						
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
						if(pack_stock < 0 || pack_stock == "")
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
					window.location = "promotion.php?hyperlink=products";
				}else{
				}
			}
		</script>
	</body>
</html>