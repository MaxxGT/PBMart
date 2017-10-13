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
		<?php
		include('../header/header.php');
		?>
		
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="../redemption/view_redemption.php?hyperlink=redemption" class="current"><span>Redemption Products</span></a></li> 
						<li><a href="../redemption/redeem.php?hyperlink=redemption"><span>Manual Red</span></a></li> 
						<li><a href="../redemption_category/redemption_category.php?hyperlink=redemption"><span>Redemption Category</span></a></li>  
						<li><a href="../redemption/add_redemption.php?hyperlink=redemption"><span>Add Redemption Product</span></a></li>
						<li><a href="../redemption/view_redemption_list.php?hyperlink=redemption"><span>Redemption Orders</span></a></li>
						<li><a href="../redemption/redemption_history.php?hyperlink=redemption"><span>Redemption History</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
					</ul> 
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
			  <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../redemption/view_redemption.php?hyperlink=redemption">Redemption Products</a> >> <a href="#">Add Product Stock</a></p>
			</div>
			<br />	
			<form enctype="multipart/form-data" action="item_add_stock.php?it=<?=$item_id?>" method="POST">
				<table border="0" align="center" width="600px" height="100px" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Add Stock</th>
					</tr>
					<tr>
						<th> Add Stock Status</th>
						<td align="center">
							<?php	if(!isset($_GET['add'])){
									}else{
										$save_result = $_GET['add'];
																	
										if($save_result == "true"){
											echo "<span class='success'>Item successfully saved.</span>";
										}else if($save_result == "false"){
											echo "<span>Item could not save into database! Please try again later.</span>";
										}else if($save_result == "empty"){
											echo "<span>Stock in cannot be empty!</span>";
										}else if($save_result == "less"){
											echo "<span>Stock in cannot be less than or 0!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th> Product Image :</th>
						<td style="border-style:solid;">
							<img src="<?=$item_display['redeem_image']?>" width="200px" height="200px" alt="<?=$item_display['redeem_image']?>"/>
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_cat">Category : </label>
						</th>
						<td>
							<?php	echo "<select id='redeem_category' name='redeem_category' disabled>";
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
						<th style="padding-left:12;">
							<label for="item_class">Class : </label>
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
							<select id="redeem_class" name="redeem_class" disabled>
								<option value=''>-Please select class...-</option>
								<option value="Normal" <?=$normal?>>Normal Redemption</option>
								<option value="Royal"<?=$royal?>>Royal redemption</option>
								<option value="Tupperware"<?=$tupper?>>Tupperware</option>
							</select>
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_name">Name : </label>
						</th>
						<td>
							<input type="text" id="item_name" name="item_name" value="<?=$item_display['redeem_name']?>" disabled />
						</td>
					</tr>
					<tr>
						<th style="padding-left:12px;">
							<label for="item_model">Model : </label>
						</th>
						<td>
							<input type="text" name="item_model" value="<?=$item_display['redeem_model']?>" disabled />
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_point">Point : </label>
						</th>
						<td>
							<input type="number" id="item_point" name="item_point" value="<?=$item_display['redeem_point']?>" disabled />
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="item_token">Token : </label>
						</th>
						<td>
							<input type="number" id="item_token" name="item_token" value="<?=$item_display['redeem_token']?>" disabled />
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
						<th>
							<label for="item_add_stock"><span class="compulsory">*</span>Add Stock : </label>
						</th>
						<td>
							<input type="number" id="item_add_stock" name="item_add_stock"/>
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="item_description">Description : </label>
						</th>
						<td>
							<textarea id="item_description" name="item_description" rows="3" cols="30" value="<?=$item_display['redeem_description']?>" disabled ></textarea>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="add_item_stock" value="Save" onClick="return checkStock();"/>
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
			function checkStock(){
				if(document.getElementById("item_add_stock").value.length === 0){
					alert("Please fill in the number of stock before add!");
					return false;
				}else{
					
					var pro_add_stock = document.getElementById('item_add_stock').value;
					
					if(pro_add_stock <= 0){
						alert("Stock amount cannot be less than or 0!");
						return false;
					}
					
					return true;
				}
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