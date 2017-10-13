<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$row = 0;

	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "promotion.php";
	$limit = 20;

	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	if(isset($_GET['fill'])){
		$fill = mysqli_real_escape_string($dbconnect, $_GET['fill']);
		
		if($fill !=""){
			
			$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_promotion WHERE promotion_category_id='$fill'"));
			$total_pages = $total_pages['num'];
				
			$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion WHERE promotion_category_id='$fill' LIMIT $start, $limit");
			$pro_count = mysqli_num_rows($pro_result);
		}else{
			$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_promotion"));
			$total_pages = $total_pages['num'];
				
			$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion LIMIT $start, $limit");
			$pro_count = mysqli_num_rows($pro_result);
		}
	}else{
		$fill = "";

		$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_promotion"));
		$total_pages = $total_pages['num'];
			
		$pro_result = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion LIMIT $start, $limit");
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
			$pagination.= "<a href=\"$targetpage?page=1&fill=$fill\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&fill=$fill\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&fill=$fill\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&fill=$fill\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&fill=$fill\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&fill=$fill\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&fill=$fill\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&fill=$fill\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&fill=$fill\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&fill=$fill\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&fill=$fill\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&fill=$fill\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&fill=$fill\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&fill=$fill\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Promotion</title>
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
			<div class="breadcrumb">
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../promotion/promotion.php?hyperlink=products">Promotion</a></p> 
			</div>
            <br />	
            <table border="0">
	            <tr>
		            <td>&nbsp;</td>
	            </tr>
            </table>
			
			<div style="width:800px;margin-left:auto;margin-right:auto;">
				<?php	$promo_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category");
						while($cat_display = mysqli_fetch_array($promo_cat)){	?>
							<a href="promotion.php?hyperlink=products&fill=<?=$cat_display['promotion_category_id']?>"><input type="button" value="<?=$cat_display['promotion_category_name']?>"/></a>
				<?php	}	?>
			</div>
			
			<table border="2" align="center" width="840px" cellpadding="0" class="box-table-a" cellspacing="0">
				<tr>
					<th colspan="4" align="center">Promotion Management</th>
				</tr>
				<tr>
					<th align="center" width="60px">Status :</th>
					<td colspan="3">					
						<?php	if(!isset($_GET['del'])){
								}else{
									$del_pro_result = $_GET['del'];
															
									if($del_pro_result == "true"){
										echo "<span class='success'>Promotion successfully deleted.</span>";
									}else if($del_pro_result == "false"){
										echo "<span>Promotion could not be deleted! Please try again later.</span>";
									}else if($del_pro_result == "empty"){
										echo "<span>There is no Promotion to be delete!</span>";
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
				<form action="delete_promotion.php" method="POST">
				<tr>
					<?php	if($pro_count == "0"){
								$bor_style = "border-bottom-style:hidden;";
							}else{
								$bor_style = "";
							}
					?>
					<th width="60px" class="chkBox" style="<?=$bor_style?>"> Select</th>
					<th width="330px">Promotion</th>
					<th width="60px" class="chkBox" style="<?=$bor_style?>"> Select</th>
					<th width="330px">Promotion</th>
				</tr>
				<tr>
				<?php	while($pro_display = mysqli_fetch_array($pro_result)){	?>
							<td align="center" style="vertical-align:middle;" width="60px" >
								<input type="checkbox" name="promotionList[]" value="<?php	echo $pro_display['promotion_id'];	?>"/>
							</td>
							<td align="center" width="330px" style="padding-left:5;"><a href="edit_promotion.php?pro=<?=$pro_display['promotion_id']?>&hyperlink=products"><img src="<?=$pro_display['promotion_item_photo']?>" alt="<?=$pro_display['promotion_item_photo']?>" width="200px" height="200px"/></a></td>
							
				<?php		$row++;
							if($row%2 == 0){
								echo "</tr>";
								echo "<tr><td colspan='2' style='border-style:hidden;'></td></tr>";
								echo "<tr>";
							}else{
							}
					}	?>
				</tr>
				<tr>
					<th colspan="10" align="center">
						<input  type="submit" name="pro_delete" onClick="return deletePromotion();" value="Delete"/>   |    <input  type="submit" name="pro_deleteAll" onClick="return pro_checkDeleteAll();" value="Delete All" /> 
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

				window.location= 'view_product.php?key=&search='+keyword;
			}
		
			function deletePromotion(){
				var promotion_list = document.getElementsByName('promotionList[]');
				var promotion_num = [];
				for(var i = 0; i < promotion_list.length; i++){
					if(promotion_list[i].checked){
						promotion_num++;
					}
				}
				
				if(promotion_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +promotion_num +" product(s)?");
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