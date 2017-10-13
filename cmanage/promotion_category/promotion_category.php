<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category");
	$promo_count = mysqli_num_rows($promo_cat);
?>

<html>
	<head>
		<title>Add Promotion Category</title>
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
						<li><a href="../promotion_category/promotion_category.php?hyperlink=products" class="current"><span>Promotion Category</span></a></li>
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
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../promotion_category/promotion_category.php?hyperlink=products">Add Promotion Category</a></p> 
			</div>
            <br />	
            <table border="0">
	            <tr>
		            <td>&nbsp;</td>
	            </tr>
            </table>
			
			<form enctype="multipart/form-data" action="save_promotion_category.php" method="POST">
				<table border="0" align="center" class="box-table-a" width="600px" height="200px" cellpadding="0" cellspacing="0">
					<tr>
						<th colspan="2" align="center">Add Promotion Category</th>
					</tr>
					<tr>
						<th width="200px" style="padding-left:12;">Status :</th>
						<td>
							<?php	if(!isset($_GET['add'])){
									}else{
										$save_result = $_GET['add'];
																			
										if($save_result == "true"){
											echo "<span class='success'>Promotion successfully saved.</span>";
										}else if($save_result == "false"){
											echo "<span>Promotion could not save into database! Please try again later.</span>";
										}else if($save_result == "empty"){
											echo "<span>Please enter all required fields before save!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th width="200px">
							<label for="promo_name"><span class="compulsory">*</span>Category Name : </label>
						</th>
						<td>
							<input type="text" name="promo_name" id="promo_name"/>
						</td>
					</tr>
					<tr>
						<th width="200px" style="padding-left:12;">
							<label for="promo_description">Category Description :</label>
						</th>
						<td>
							<textarea id="promo_description" name="promo_description" rows="5" cols="40"></textarea>
						</td>
					</tr>
					<tr>
						<th>
							<label for="promo_image"><span class="compulsory">*</span>Category Image : </label>
						</th>
						<td>
							<input type="file" id="promo_image" name="promo_image"/>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">
							<input type="submit" value="save" name="save_promo" onClick="return checkEmptyFields();"/>
						</th>
					</tr>
				</table>
			</form>
			
			<table border="2" align="center" width="840px" cellpadding="0" class="box-table-a" cellspacing="0">
				<tr>
					<th colspan="2" align="center">Promotion Management</th>
				</tr>
				<tr>
					<th align="center">Status :</th>
					<td>					
						<?php	if(!isset($_GET['del'])){
								}else{
									$del_pro_result = $_GET['del'];
															
									if($del_pro_result == "true"){
										echo "<span class='success'>Promotion category successfully deleted.</span>";
									}else if($del_pro_result == "false"){
										echo "<span>Promotion category could not be deleted! Please try again later.</span>";
									}else if($del_pro_result == "empty"){
										echo "<span>There is no Promotion category to be delete!</span>";
									}
								}
						?>
						
						<?php	if(!isset($_GET['save'])){
								}else{
									$save_result = $_GET['save'];
														
									if($save_result == "true"){
										echo "<span class='success'>Promotion category successfully edited.</span>";
									}
								}			
						?>
					</td>
				</tr>
				<form action="delete_promotion_category.php" method="POST">
				<tr>
					<?php	if($promo_count == "0"){
								$bor_style = "border-bottom-style:hidden;";
							}else{
								$bor_style = "";
							}
					?>
					<th width="60px" class="chkBox" style="<?=$bor_style?>"> Select</th>
					<th width="740px">Promotion</th>
				</tr>
				<?php	while($promo_display = mysqli_fetch_array($promo_cat)){	?>
					<tr>
						<td align="center" style="vertical-align:middle;" width="60px" >
							<input type="checkbox" name="promotionCategoryList[]" value="<?php	echo $promo_display['promotion_category_id'];	?>"/>
						</td>
						<td align="center" width="740px" style="padding-left:5;"><a href="edit_promotion_category.php?pro=<?=$promo_display['promotion_category_id']?>&hyperlink=products"><img src="<?=$promo_display['promotion_category_photo']?>" alt="<?=$promo_display['promotion_category_name']?>" width="720px" height="190"/></a></td>
					</tr>
				<?php	}	?>
				<tr>
					<th colspan="10" align="center">
						<input  type="submit" name="promo_delete" onClick="return deletePromotionCategory();" value="Delete"/>   |    <input  type="submit" name="promo_deleteAll" onClick="return pro_checkDeleteAll();" value="Delete All" /> 
					</th>
				</tr>
				<tr>
					<td height="50px" align="center" colspan="10" style="border-style:hidden;">
						<table border="0" align="center" valign="bottom" width="600px">
							<tr>
								<td align="center" style="border-style:hidden;"><?//=$pagination?></td>
							</tr>
						</table>
					</td>
				</tr>
				</form>
			</table>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			
			<?php
				include('../footer.php');
			?>
		</div>
		
		<script>
			function checkEmptyFields(){
				var name = document.getElementById('promo_name').value.length;
				var photo = document.getElementById('promo_image').value.length;
				
				if(name === 0 || photo === 0){
					var message = "Please fill in the following field(s) before save!";
					
					if(name === 0)
						message = message + "\n-Category Name";
					if(photo === 0)
						message = message + "\n-Category Image";
					
					alert(message);
					return false;
				}else{
					return true;
				}
			}
			
			function deletePromotionCategory(){
				var promotion_cat_list = document.getElementsByName('promotionCategoryList[]');
				var promotion_cat_num = [];
				for(var i = 0; i < promotion_cat_list.length; i++){
					if(promotion_cat_list[i].checked){
						promotion_cat_num++;
					}
				}
				
				if(promotion_cat_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +promotion_cat_num +" promotion category?");
				}else{
					alert("Please select 1 or more promotion category to delete!");
				}
				
				if(confirmDelete){
					return true;
				}else{
					return false;
				}
			}
			
			function pro_checkDeleteAll(){
				var confirmDelAll = confirm("Do you wish to delete all products?");
				
				if(confirmDelAll){
					return true;
				}else{
					return false;
				}
			}
		</script>
	</body>
</html>