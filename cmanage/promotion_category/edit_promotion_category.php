<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$promo_cat_id = mysqli_real_escape_string($dbconnect, $_GET['pro']);
	
	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='$promo_cat_id'");
	$promo_display = mysqli_fetch_assoc($promo_cat);
?>

<html>
	<head>
		<title>Edit Promotion Category</title>
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
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form enctype="multipart/form-data" action="edit_save_promotion_category.php?pro=<?=$promo_cat_id?>" method="POST">
				<table border="2" align="center" width="920px" cellpadding="0" class="box-table-a" cellspacing="0">
					<tr>
						<th colspan="2" align="center">Promotion Category Management</th>
					</tr>
					<tr>
						<th width="300px">Status :</th>
						<td>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">Promo Category Image :</th>
						<td>
							<img src="<?=$promo_display['promotion_category_photo']?>" alt="<?=$promo_display['promotion_category_name']?>" width="720px" height="190"/>
						</td>
					</tr>
					<tr>
						<th>
							<label for="promotion_name"><span class="compulsory">*</span>Promo Category Name :</label>
						</th>
						<td>
							<input type="text" name="promotion_name" id="promotion_name" value="<?=$promo_display['promotion_category_name']?>"/>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="promotion_description">Promo Category Description :</label>
						</th>
						<td>
							<textarea name="promotion_description" rows="5" cols="30"><?=$promo_display['promotion_category_description']?></textarea>
						</td>
					</tr>
					<tr>
						<th style="padding-left:12;">
							<label for="promotion_image">Promo Category Image : </label>
						</th>
						<td>
							<input type="file" name="promotion_image"/>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">
							<input type="submit" value="Save" name="save_promo_cat" onClick="return checkEmptyFields();"/> <input type="reset" value="Restore" onClick="return confirmClear();"/>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;padding-top:30;">
							<input type="button" name="back" onClick="backPromo();" value="Back"/>
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
				var name = document.getElementById('promotion_name').value.length;
				
				if(name === 0){
					alert("Please fill in the name before save!");
					return false;
				}else{
					return true;
				}
			}
			
			function confirmClear(){
				var confirm_clear = confirm("Do you wish to restore the form to previous data?");
				
				if(confirm_clear){
					return true;
				}else{
					return false;
				}
			}
			
			function backPromo(){
				var confirm_back = confirm("Do you wish to go back?");
				
				if(confirm_back){
					window.location = "promotion_category.php?hyperlink=products";
				}else{
				}
			}
		</script>
	</body>
</html>