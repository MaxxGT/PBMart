<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$item_id = mysqli_real_escape_string($dbconnect, $_GET['it']);
	
	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='$item_id'");
	$item_display = mysqli_fetch_assoc($item);
	
	$redeem_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category");
?>

<html>
	<head>
		<title>Edit Redemption Item</title>
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
						<li><a href="../redemption/view_redemption.php?hyperlink=promotions" class="current"><span>Redemption Products</span></a></li> 
						<li><a href="../redemption/redeem.php?hyperlink=promotions"><span>Manual Redemption</span></a></li> 
						<li><a href="../redemption_category/redemption_category.php?hyperlink=redemption"><span>Redemption Category</span></a></li> 
						<li><a href="../redemption/add_redemption.php?hyperlink=promotions"><span>Add Redemption Product</span></a></li>
						<li><a href="../redemption/view_redemption_list.php?hyperlink=promotions"><span>Redemption Orders</span></a></li>
						<li><a href="../redemption/redemption_history.php?hyperlink=promotions"><span>Redemption History</span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				 <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../redemption/view_redemption.php?hyperlink=redemption">Redemption Products</a> >> <a href="#">Edit Redemption Item</a></p>
			</div>
			<br />	
			<form enctype="multipart/form-data" action="edit_save_item.php?it=<?=$item_id?>" method="POST">
				<table border="0" align="center" width="600px" height="100px" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Edit Product</th>
					</tr>
					<tr>
						<th width="200px">Edit Product Status</th>
						<td align="center">
							<?php	if(!isset($_GET['save'])){
									}else{
										$save_result = $_GET['save'];
																			
										if($save_result == "true"){
											echo "<span class='success'>Item successfully saved.</span>";
										}else if($save_result == "false"){
											echo "<span>Item could not save into database! Please try again later.</span>";
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
						<th> Product Image</th>
						<td  style="border-style:solid;" align="center">
							<img src="<?=$item_display['redeem_image']?>" width="200px" height="200px" alt="<?=$item_display['redeem_image']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="item_cat"><span class="compulsory">*</span>Category : </label>
						</th>
						<td>
							<?php	echo "<select id='redeem_category' name='redeem_category'>";
									echo "<option value=''>-Please select category...-</option>";
														
									while($redeem_display = mysqli_fetch_array($redeem_cat)){
										
										if($redeem_display['redemption_category_name'] == $item_display['redeem_category']){
											$select = "selected";
										}else{
											$select = "";
										}
							?>
										<option value="<?=$redeem_display['redemption_category_id']?>" <?=$select?>><?=$redeem_display['redemption_category_name']?></option>
							<?php	}	
									echo "</select>";
							?>
						</td>
					</tr>
					<tr>
						<th>
							<label for="item_class"><span class="compulsory">*</span>Class : </label>
						</th>
						<?php	if($item_display['redeem_class'] == "Royal"){
									$royal = "selected";
									$normal = "";
									$tupper = "";
								}else if($item_display['redeem_class'] == "Normal"){
									$royal = "";
									$normal = "selected";
									$tupper = "";
								}else{
									$royal = "";
									$normal = "";
									$tupper = "selected";
								}
						?>
						<td>
							<select id="redeem_class" name="redeem_class">
								<option value=''>-Please select class...-</option>
								<option value="Normal" <?=$normal?>>Normal Redemption</option>
								<option value="Royal"<?=$royal?>>Royal redemption</option>
								<option value="Tupperware"<?=$tupper?>>Tupperware</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="item_name"><span class="compulsory">*</span>Name : </label>
						</th>
						<td>
							<input type="text" id="item_name" name="item_name" value="<?=$item_display['redeem_name']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="item_model">Model : </label>
						</th>
						<td>
							<input type="text" name="item_model" value="<?=$item_display['redeem_model']?>"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="item_point"><span class="compulsory">*</span>Points : </label>
						</th>
						<td>
							<input type="number" id="item_point" name="item_point" value="<?=$item_display['redeem_point']?>" onChange="checkPoint(this);"/> 0 for not available
						</td>
					</tr>
					<tr>
						<th>
							<label for="item_token"><span class="compulsory">*</span>Token : </label>
						</th>
						<td>
							<input type="number" id="item_token" name="item_token" value="<?=$item_display['redeem_token']?>" onChange="checkToken(this);"/> 0 for not available
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_stock">Stock number : </label>
						</th>
						<td>
							<input type="number" id="item_stock" name="item_stock" value="<?=$item_display['redeem_stock']?>" disabled />
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_image">Photo : </label>
						</th>
					<td>
						<input type="file" id="item_image" name="item_image"/>
					</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_description">Description : </label>
						</th>
						<td>
							<textarea id="item_description" name="item_description" rows="3" cols="30"><?=$item_display['redeem_description']?></textarea>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="save_edit_item" value="Save" onClick="return checkEmptyFields();"/>
							<input type="reset" name="reset_item_fields" value="Reset" onClick="return clearFields();"/>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;">
							<input type="button" name="back" onClick="backProduct();" value="Back"/>
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
			function checkEmptyFields(){
				var item_cat = document.getElementById('redeem_category').value.length;
				var item_class = document.getElementById('redeem_class').value.length;
				var item_name = document.getElementById('item_name').value.length;
				var item_point = document.getElementById('item_point').value.length;
				var item_token = document.getElementById('item_token').value.length;
				var item_stock = document.getElementById('item_stock').value.length;
				
				var item_point1 = document.getElementById('item_point').value;
				var item_token1 = document.getElementById('item_token').value;
				var item_stock1 = document.getElementById('item_stock').value;
				
				if(item_cat === 0 || item_class === 0 || item_name === 0 || item_point === 0 || item_token === 0 || item_image === 0 || item_stock === 0){
					var message = "Please fill in the following field(s) before save!";
					
					if(item_cat === 0)
						message = message + "\n-Item Category";
					if(item_class === 0)
						message = message + "\n-Item Class";
					if(item_name === 0)
						message = message + "\n-Item Name";
					if(item_point === 0)
						message = message + "\n-Point";
					if(item_token === 0)
						message = message + "\n-Token";
					if(item_stock === 0)
						message = message + "\n-Stock Number";
					
					alert(message);
					return false;
				}else{
					if(item_point1 < 0){
						alert("Point cannot be less than 0");
						return false;
					}
					
					if(item_token1 < 0){
						alert("Token cannot be less than 0");
						return false;
					}
					
					if(item_stock2 < 0){
						alert("Stock number cannot be less than 0");
						return false;
					}
					
					return true;
				}
			}
			
			function clearFields(){
				var confirmClear = confirm("Do you wish to clear the form?");
				
				if(confirmClear){
					return true;
				}else{
					return false;
				}
			}
			
			function checkPoint(point){
				var point = document.getElementById('item_point').value;
				
				if(point < 0)
					alert("Point cannot be less than 0");
			}
			
			function checkToken(token){
				var token = document.getElementById('item_token').value;
				
				if(token < 0)
					alert("Token cannot be less than 0");
			}
			
			function backProduct(){
				var backCheck = confirm("Do you wish to go back?");
				
				if(backCheck){
					window.location = "view_redemption.php?hyperlink=redemption";
				}else{
				}
			}
		</script>
	</body>
</html>