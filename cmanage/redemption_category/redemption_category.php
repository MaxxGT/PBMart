<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "redemption_category.php";
	$limit = 20;

	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	$keyword = "";
	$searchKey = "";
	
	if(isset($_GET['search']) != ""){
		$searchKey = mysqli_real_escape_string($dbconnect, $_GET['search']);

		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redemption_category WHERE redemption_category_name LIKE'%".$searchKey."%'"));
		$total_pages = $total_pages['num'];
	
		$cat_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category WHERE redemption_category_name LIKE'%".$searchKey."%' LIMIT $start, $limit");
		$cat_count = mysqli_num_rows($cat_result);
	}else if(isset($_GET['key']) != ""){
		$keyword = mysqli_real_escape_string($dbconnect, $_GET['key']);

		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redemption_category WHERE redemption_category_name LIKE'".$keyword."%'"));
		$total_pages = $total_pages['num'];
	
		$cat_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category WHERE redemption_category_name LIKE'".$keyword."%' LIMIT $start, $limit");
		$cat_count = mysqli_num_rows($cat_result);
	}else if(!isset($_GET['key']) || isset($_GET['key']) == '0'){
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redemption_category"));
		$total_pages = $total_pages['num'];
		
		$cat_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category LIMIT $start, $limit");
		$cat_count = mysqli_num_rows($cat_result);
	}
	
	if($page == 0)
		$page = 1;
	
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1){
		$pagination.= "<div class=\"pagination\">";
		
		// First button
		if($page > 1)
			$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=redemption\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=redemption\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=redemption\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=redemption\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=redemption\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=redemption\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=redemption\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=redemption\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=redemption\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=redemption\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=redemption\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=redemption\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=redemption\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=redemption\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Category</title>
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
			<div class="breadcrumb">
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../redemption_category/redemption_category.php?hyperlink=redemption">Redemption Category</a></p>
			</div>
			<br />
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form action="add_redemption_category.php" method="POST">
				<table border="0" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th colspan="2" align="center">Add New Redemption Category</th>
					</tr>
					<tr>
						<th>Add Category Status</th>
					<td align="center">
						<?php	if(!isset($_GET['save'])){
								}else{
									$add_result = $_GET['save'];
														
									if($add_result == "true"){
										echo "<span class='success'>Category successfully saved.</span>";
									}else if($add_result == "false"){
										echo "<span>Category could not save into database! Please try again later.</span>";
									}else if($add_result == "empty"){
										echo "<span>Please fill in the name before save!</span>";
									}
								}
						?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="category"><span class="compulsory">*</span>Name : </label>
						</td>
						<td>
							<input type="text" name="category" id="category"/>
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;" style="padding-left:12;">
							<label for="cat_description">Descriptions : </label>
						</td>
						<td>
							<textarea id="cat_description" name="cat_description" rows="3" cols="30"></textarea>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="center">
							<input type="submit" name="cat_save" onClick="return cat_checkEmpty();" Value="Save"/>
						</th>
					</tr>
				</table>	
			</form>
			</br>
			<table border="0" align="center" width="600px" height="40px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="4" align="center">Search Category</th>
				</tr>
				<tr>
					<th width="300px" colspan="2" align="center">
						<input type="textarea" rows="1" cols="50" name="searchKey" id="searchKey"/>
					</th>
					<th colspan="2">
						<input type="button" value="Search" onClick="searchKey();"/>
					</th>
				</tr>
				<tr>
					<td width="10px" align="center" colspan="4">
						<?php	$keywords = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
										
								echo "<a href='redemption_category.php?key=&hyperlink=redemption'><input type='button' name='keyword' id='keyword' value='ALL'/></a>";
										
								for($i=0; $i<26; $i++){
									if($keyword == $keywords[$i]){
										$status = "Disabled";
									}else{
										$status = "";
									}
										
									echo "<a href='redemption_category.php?key=".$keywords[$i]."&hyperlink=redemption'><input type='button' name='keyword' id='keyword' value='".$keywords[$i]."' ".$status."/></a>";
								}
						?>
					</td>
				</tr>
			<!--</table>-->
			<form action="delete_redemption_category.php" method="POST">
				<!--<table border="2" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">-->
					<tr>
						<th colspan="4" align="center">Redemption Category Management </th>
					</tr>
					<tr>
						<th colspan="1">Status:</th>
						<td colspan="3" align="center">
							<?php	if(!isset($_GET['del'])){
									}else{
										$del_result = $_GET['del'];
												
										if($del_result == "true"){
											echo "<span class='success'>Category successfully deleted.</span>";
										}else if($del_result == "false"){
											echo "<span>Category could not be deleted! Please try again later.</span>";
										}else if($del_result == "empty"){
											echo "<span>There is no category to be delete!</span>";
										}else if($del_result == "nemp"){
											echo "<span>Please delete redemption item before delete category!</span>";
										}
									}
									
									if(!isset($_GET['edit'])){
									}else{
										$edit_result = $_GET['edit'];
												
										if($edit_result == "true")
											echo "<span class='success'>Category successfully Edited.</span>";
									}
							?>
						</td>
					</tr>
					<tr>
						<?php	if($cat_count == "0"){
									$bor_style = "border-bottom-style:hidden;";
								}else{
									$bor_style = "";
								}
						?>
						<th width="40px" class="chkBox" style="<?=$bor_style?>">Select</th>
						<th width="200px" style="padding-left:5;">Category Name</th>
						<th>Description</th>
						<th width="100">Click to Edit</th>
					</tr>
					<?php	while($cat_display = mysqli_fetch_array($cat_result)){	?>
						<tr>
							<td align="center" width="40px">
								<input type="checkbox" name="redeem_categoryList[]" value="<?php	echo $cat_display['redemption_category_id'];	?>"/>
							</td>
							<td style="padding-left:5;"><?=$cat_display['redemption_category_name']?></td>
							<td style="padding-left:5;"><?=$cat_display['redemption_category_description']?></td>
							<td width="40px" align="center"><a href="edit_redemption_category.php?cat=<?=$cat_display['redemption_category_id']?>&hyperlink=redemption"><img src="../images/edit.png" width="20px" height="20px" alt="Edit"/></a></td>
						</tr>
					<?php	}	?>
						<tr>
							<th colspan="4" align="center">
								<input type="submit" name="cat_delete" onClick="return deleteCategory();" value="Delete"/> | <input type="submit" name="cat_deleteAll" onClick="return cat_checkDeleteAll();" value="Delete All"/>
							</th>
						</tr>	
						<tr>
							<td height="50px" align="center" colspan="4" style="border-style:hidden;">
								<table border="0" align="center" valign="bottom" width="550px">
									<tr>
										<td align="center" style="border-style:hidden;"><?=$pagination?></td>
									</tr>
								</table>
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
			function search(){
				var keyword = document.getElementById('search').value;

				window.location= 'redemption_category.php?key=' +keyword +'&search='+'&hyperlink=redemption';
			}
			
			function searchKey(){
				var keyword = document.getElementById('searchKey').value;

				window.location= 'redemption_category.php?key=&search='+keyword+'&hyperlink=redemption';
			}

			function cat_checkEmpty(){
				if(document.getElementById("category").value.length === 0){
					alert("Please fill in the name before save!");
					return false;
				}else{
					return true;
				}
			}
			
			function deleteCategory(){
				var category_list = document.getElementsByName('redeem_categoryList[]');
				var category_num = [];
				for(var i = 0; i < category_list.length; i++){
					if(category_list[i].checked){
						category_num++;
					}
				}
				
				if(category_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +category_num +" category(s)?");
				}else{
					alert("Please select 1 or more category to delete!");
				}
				
				if(confirmDelete){
					return true;
				}else{
					return false;
				}
			}
			
			function cat_checkDeleteAll(){
				var confirmDelAll = confirm("Do you wish to delete all categories?");
				
				if(confirmDelAll){
					return true;
				}else{
					return false;
				}
			}
		</script>
	</body>
</html>