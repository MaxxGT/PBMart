<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "view_redemption.php";
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
		
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redeem WHERE redeem_name LIKE'%".$searchKey."%'"));
		$total_pages = $total_pages['num'];
	
		$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_name LIKE'%".$searchKey."%' LIMIT $start, $limit");
		$red_count = mysqli_num_rows($redeem);
	}else if(isset($_GET['key']) != ""){
		$keyword = mysqli_real_escape_string($dbconnect, $_GET['key']);

		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redeem WHERE redeem_name LIKE'".$keyword."%'"));
		$total_pages = $total_pages['num'];
	
		$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_name LIKE'".$keyword."%' LIMIT $start, $limit");
		$red_count = mysqli_num_rows($redeem);
	}else if(!isset($_GET['key']) || isset($_GET['key']) == '0'){
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redeem"));
		$total_pages = $total_pages['num'];
		
		$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem LIMIT $start, $limit");
		$red_count = mysqli_num_rows($redeem);
	}
	
	if($page == 0)
		$page = 1;
	
	$prev = $page - 1;
	$next = $page + 1;
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
		<title>Redemption Item</title>
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
						<li><a href="../redemption/redeem.php?hyperlink=redemption"><span>Manual Redemption</span></a></li> 
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
			   <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../redemption/view_redemption.php?hyperlink=redemption">Redemption Products</a></p>
			</div>
			<br />	
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
					
			<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th align="center" colspan="2">Search Redemption Products</th>
				</tr>
				<tr>	
					<th width="300px" >
						<input type="text" name="searchKey" id="searchKey"/>
					</th>
					<th >
						<input type="button" value="Search" onClick="searchKey();"/>
					</th>
				</tr>
				<tr>		
					<td colspan="2" width="10px" align="center">
						<?php	$keywords = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
																	
								echo "<a href='view_redemption.php?key=&hyperlink=redemption'><input type='button' name='keyword' id='keyword' value='ALL'/></a>";
																	
								for($i=0; $i<26; $i++){
									if($keyword == $keywords[$i]){
										$status = "Disabled";
									}else{
										$status = "";
									}
																		
									echo "<a href='view_redemption.php?key=".$keywords[$i]."&hyperlink=redemption'><input type='button' name='keyword' id='keyword' value='".$keywords[$i]."' ".$status."/></a>";
								}
						?>
					</td>
				</tr>
			</table>
						
			<table border="2" align="center" width="800px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="8" align="center">Redemption Products Management</th>
				</tr>
				<tr>
					<th colspan="2">Status :</th>
					<td align="center" colspan="6">
						<?php	if(!isset($_GET['save'])){
								}else{
									$save_result = $_GET['save'];
																
									if($save_result == "true"){
										echo "<span class='success'>Product successfully edited.</span>";
									}
								}
						?>
						<?php	if(!isset($_GET['del'])){
								}else{
									$del_pro_result = $_GET['del'];
														
									if($del_pro_result == "true"){
										echo "<span class='success'>Item successfully deleted.</span>";
									}else if($del_pro_result == "false"){
										echo "<span>Item could not be deleted! Please try again later.</span>";
									}else if($del_pro_result == "empty"){
										echo "<span>There is no Item to be delete!</span>";
									}
								}
						?>
					</td>
				</tr>
											
				<form action="delete_item.php" method="POST">							
					<tr>
						<?php	if($red_count == "0"){
									$bor_style = "border-bottom-style:hidden;";
								}else{
									$bor_style = "";
								}
						?>
						<th width="40px" class="chkBox" style="<?=$bor_style?>">Select</th>
						<th width="100px" style="padding-left:5;">Category</th>
						<th width="70px" style="padding-left:5;">Class</th>
						<th width="250px" style="padding-left:5;">Name</th>
						<th width="100px" style="padding-left:5;">Point</th>
						<th width="60px" style="padding-left:5;">Stock</th>
						<th width="50px" style="padding-left:5;">Edit</th>
						<th width="80px" style="padding-left:5;">Add Stock</th>
					</tr>
						<?php	while($redeem_display = mysqli_fetch_array($redeem)){	?>
					<tr>
						<td align="center" width="40px" >
							<input type="checkbox" name="itemList[]" value="<?php	echo $redeem_display['redeem_id'];	?>"/>
						</td>
						<td width="100px" style="padding-left:5;"><?=$redeem_display['redeem_category']?></td>
						<td width="70px" style="padding-left:5;"><?=$redeem_display['redeem_class']?></td>
						<td width="250px" style="padding-left:5;"><?=$redeem_display['redeem_name']?></td>
						<td width="100px" style="padding-left:5;"><?=$redeem_display['redeem_point']?></td>
						<td width="60px" style="padding-left:5;"><?=$redeem_display['redeem_stock']?></td>
						<td align="center" width="30px" style="padding-left:5;"><a href="edit_item.php?it=<?=$redeem_display['redeem_id']?>&hyperlink=redemption"><img src="../images/edit.png" width="20px" height="20px" alt="Edit"/></a></td>
						<td align="center" width="30px" style="padding-left:5;"><a href="add_item_stock.php?it=<?=$redeem_display['redeem_id']?>&hyperlink=redemption"><img src="../images/add.png" width="20px" height="20px" alt="Add Stock"/></a></td>
					</tr>
					<?php	}	?>
					<tr>
						<th colspan="8" align="center">
							<input type="submit" name="item_delete" onClick="return deleteItem();" value="Delete"/> | <input type="submit" name="item_deleteAll" onClick="return item_checkDeleteAll();" value="Delete All"/>
						</th>
					</tr>
					<tr>
						<td height="50px" align="center" colspan="10" style="border-style:hidden;">
							<table border="0" align="center" valign="bottom" width="600px">
								<tr>
									<td align="center" style="border-style:hidden;"><?=$pagination?></td>
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
			function searchKey(){
				var keyword = document.getElementById('searchKey').value;

				window.location= 'view_redemption.php?key=&search='+keyword+'&hyperlink=redemption';
			}
			
			function deleteItem(){
				var item_list = document.getElementsByName('itemList[]');
				var item_num = [];
				for(var i = 0; i < item_list.length; i++){
					if(item_list[i].checked){
						item_num++;
					}
				}
				
				if(item_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +item_num +" item(s)?");
				}else{
					alert("Please select 1 or more item to delete!");
				}
				
				if(confirmDelete){
					return true;
				}else{
					return false;
				}
			}
			
			function item_checkDeleteAll(){
				var confirmDelAll = confirm("Do you wish to delete all items?");
				
				if(confirmDelAll){
					return true;
				}else{
					return false;
				}
			}
		</script>
	</body>
</html>