<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$cat_id = mysqli_real_escape_string($dbconnect, $_GET['cat']);
	
	$cat_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category WHERE redemption_category_id = '$cat_id'");
	$cat_display = mysqli_fetch_assoc($cat_result);
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/font.css"/>
		<link rel="stylesheet" type="text/css" href="../css/table.css"/>
		<link rel="stylesheet" type="text/css" href="../css/menu.css"/>
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
						<li><a href="../redemption/view_redemption.php?hyperlink=redemption"><span>Redemption Products</span></a></li>
						<li><a href="../redemption/redeem.php?hyperlink=redemption"><span>Manual Redemption</span></a></li> 
						<li><a href="../redemption_category/redemption_category.php?hyperlink=redemption" class="current"><span>Redemption Category</span></a></li> 
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
		<br />
		<br />
			<form action="edit_save_redemption_category.php?id=<?=$cat_display['redemption_category_id']?>" method="POST">
				<table border="0" align="center" width="600px" height="150px" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Edit Category Interface</th>
					</tr>
					<tr>
						<th>Edit Category Status</th>
						<td align="center">
							<?php	if(!isset($_GET['edit'])){
									}else{
										$add_result = $_GET['edit'];
															
										if($add_result == "false"){
											echo "<span>Category could not save into database! Please try again later.</span>";
										}else if($add_result == "empty"){
											echo "<span>Please fill in the name before save!</span>";
										}
									}
							?>
						</td>
					</tr>
					<tr>
						<th>
							<label for="category"><span class="compulsory">*</span>Name : </label>
						</th>
						<td>
							<input type="text" name="category" id="category" value="<?=$cat_display['redemption_category_name']?>"/>
						</td>
					</tr>
					<tr>
						<th valign="top" style="padding-left:12;">
							<label for="cat_description">Descriptions : </label>
						</th>
						<td>
							<textarea id="cat_description" name="cat_description" rows="3" cols="30"><?=$cat_display['redemption_category_description']?></textarea>
						</td>
					</tr>
					<tr>
						<th align="center" colspan="2">
							<input type="submit" name="cat_save" onClick="return cat_checkEmpty();" Value="Save"/>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;">
							<input type="button" name="back" onClick="backCategory();" value="Back"/>
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
			function cat_checkEmpty(){
				if(document.getElementById("category").value.length === 0){
					alert("Please fill in the name before save!");
					return false;
				}else{
					return true;
				}
			}
			
			function backCategory(){
				var backCheck = confirm("Do you wish to go back?");
				
				if(backCheck){
					window.location = "redemption_category.php?hyperlink=redemption";
				}else{
					
				}
			}
		</script>
	</body>
</html>