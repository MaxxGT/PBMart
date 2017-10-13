<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}

	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "view_product.php";
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
		
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_product WHERE product_name LIKE'%".$searchKey."%'"));
		$total_pages = $total_pages['num'];
	
		$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_name LIKE'%".$searchKey."%' LIMIT $start, $limit");
		$pro_count = mysqli_num_rows($pro_result);
	}else if(isset($_GET['key']) != ""){
		$keyword = mysqli_real_escape_string($dbconnect, $_GET['key']);

		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_product WHERE product_name LIKE'".$keyword."%'"));
		$total_pages = $total_pages['num'];
	
		$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_name LIKE'".$keyword."%' LIMIT $start, $limit");
		$pro_count = mysqli_num_rows($pro_result);
	}else if(!isset($_GET['key']) || isset($_GET['key']) == '0'){
		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_product"));
		$total_pages = $total_pages['num'];
		
		$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_product LIMIT $start, $limit");
		$pro_count = mysqli_num_rows($pro_result);
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
			$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=products\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=products\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=products\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=products\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=products\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=products\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=products\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=products\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=products\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=products\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=products\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=products\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=products\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=products\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Product</title>
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
						<li><a href="../product/view_product.php?hyperlink=products" class="current"><span>Product</span></a></li>   
						<li><a href="../product/add_product.php?hyperlink=products"><span>Add New Product</span></a></li>
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
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../product/view_product.php?hyperlink=products">Products</a></p> 
			</div>
            <br />	
            <table border="0">
	            <tr>
		            <td>&nbsp;</td>
	            </tr>
            </table>						
												
			<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>	
					<th colspan="2" align="center">Search Products</th>
				</tr>
				<tr>
					<th width="300px" align="center">
						<input type="text" name="searchKey" id="searchKey"/>
					</th>
					<th>
						<input type="button" value="Search" onClick="searchKey();"/>
					</th>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<?php	$keywords = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
																
							echo "<a href='view_product.php?key=&hyperlink=products'><input type='button' name='keyword' id='keyword' value='ALL'/></a>";
																
							for($i=0; $i<26; $i++){
								if($keyword == $keywords[$i]){
									$status = "Disabled";
								}else{
									$status = "";
								}
															
								echo "<a href='view_product.php?key=".$keywords[$i]."&hyperlink=products'><input type='button' name='keyword' id='keyword' value='".$keywords[$i]."' ".$status."/></a>";
							}
						?>
					</td>
				</tr>
			</table>
									
			<table border="2" align="center" width="900px" cellpadding="0" class="box-table-a" cellspacing="0">
				<tr>
					<th colspan="10" align="center">Product Management</th>
				</tr>
				<tr>
					<th colspan="2" align="center">Status :</th>
					<td colspan="8">					
						<?php	if(!isset($_GET['del'])){
								}else{
									$del_pro_result = $_GET['del'];
															
									if($del_pro_result == "true"){
										echo "<span class='success'>Product successfully deleted.</span>";
									}else if($del_pro_result == "false"){
										echo "<span>Product could not be deleted! Please try again later.</span>";
									}else if($del_pro_result == "empty"){
										echo "<span>There is no product to be delete!</span>";
									}
								}
						?>
						
						<?php	if(!isset($_GET['save'])){
								}else{
									$save_result = $_GET['save'];
														
									if($save_result == "true"){
										echo "<span class='success'>Product successfully edited.</span>";
									}
								}
												
						?>
					</td>
				</tr>
				<form action="delete_product.php" method="POST">
				<tr>
					<?php	if($pro_count == "0"){
								$bor_style = "border-bottom-style:hidden;";
							}else{
								$bor_style = "";
							}
					?>
					<th width="40px" class="chkBox" style="<?=$bor_style?>"> Select</th>
					<th >Category</th>
					<th width="150px" style="padding-left:5;">Name</th>
					<th width="50px" style="padding-left:5;">Price</th>
					<th width="60px" style="padding-left:5;">Sale1 (%)</th>
					<th width="60px" style="padding-left:5;">Sale2 (%)</th>
					<th width="60px" style="padding-left:5;">Sale3 (%)</th>
					<th width="80px" style="padding-left:5;">Stock Qty</th>
					<th width="100px" style="padding-left:5;">Click to Edit Product</th>
					<th width="100px" style="padding-left:5;">Click to Edit Stock Qty</th>
				</tr>
				<?php	while($pro_display = mysqli_fetch_array($pro_result)){	?>
					<tr>
						<td align="center" width="40px" >
							<input type="checkbox" name="productList[]" value="<?php	echo $pro_display['product_id'];	?>"/>
						</td>
						<td width="150px" style="padding-left:5;"><?=$pro_display['product_category']?></td>
						<td width="250px" style="padding-left:5;"><?=$pro_display['product_name']?></td>
						<td width="50px" style="padding-left:5;"><?=$pro_display['product_price']?></td>
						<td width="50px" style="padding-left:5;"><?=$pro_display['product_sale_percentage1']?></td>
						<td width="50px" style="padding-left:5;"><?=$pro_display['product_sale_percentage2']?></td>
						<td width="50px" style="padding-left:5;"><?=$pro_display['product_sale_percentage3']?></td>
						<td width="40px" style="padding-left:5;"><?=$pro_display['product_stock']?></td>
						<td align="center" width="30px" style="padding-left:5;"><a href="edit_product.php?pro=<?=$pro_display['product_id']?>&hyperlink=products"><img src="../images/edit.png" width="20px" height="20px" alt="Edit"/></a></td>
						<td align="center" width="30px" style="padding-left:5;"><a href="add_product_stock.php?pro=<?=$pro_display['product_id']?>&hyperlink=products"><img src="../images/add.png" width="20px" height="20px" alt="Add Stock"/></a></td>
					</tr>
				<?php	}	?>
				<tr>
					<th colspan="10" align="center">
						<input  type="submit" name="pro_delete" onClick="return deleteProduct();" value="Delete Selected Product"/>   |    <input  type="submit" name="pro_deleteAll" onClick="return pro_checkDeleteAll();" value="Delete All Products" /> 
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

				window.location= 'view_product.php?key=&search='+keyword+'&hyperlink=products';
			}
		
			function deleteProduct(){
				var product_list = document.getElementsByName('productList[]');
				var product_num = [];
				for(var i = 0; i < product_list.length; i++){
					if(product_list[i].checked){
						product_num++;
					}
				}
				
				if(product_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +product_num +" product(s)?");
				}else{
					alert("Please select 1 or more product to delete!");
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