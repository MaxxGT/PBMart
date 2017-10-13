<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$mem_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "redeem_item.php";
	$limit = 16;

	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}

	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redeem"));
	$total_pages = $total_pages['num'];
		
	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem LIMIT $start, $limit");
	
	if($page == 0)
		$page = 1;
	
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1){
		$pagination.= "<div class=\"pagination\">";
		
		// First button
		if($page > 1)
			$pagination.= "<a href=\"$targetpage?page=1&key=$keyword\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_id&hyperlink=redemption\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_id&hyperlink=redemption\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&mem=$mem_id&hyperlink=redemption\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&mem=$mem_id&hyperlink=redemption\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&mem=$mem_id&hyperlink=redemption\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&mem=$mem_id&hyperlink=redemption\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_id&hyperlink=redemption\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&mem=$mem_id&hyperlink=redemption\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=redemption\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&mem=$mem_id&hyperlink=redemption\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&mem=$mem_id&hyperlink=redemption\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&mem=$mem_id&hyperlink=redemption\">$counter</a>";
				}
			}
		}
		
		// next button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&mem=$mem_id&hyperlink=redemption\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
	
	$item_rows = 0;
?>

<html>
	<head>
		<title>Manual Redemption</title>
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
						<li><a href="../redemption/view_redemption.php" ><span>Redemption Products</span></a></li> 
						<li><a href="../redemption/redeem.php" class="current"><span>Manual Redemption</span></a></li> 
						<li><a href="../redemption_category/redemption_category.php"><span>Redemption Category</span></a></li> 
						<li><a href="../redemption/add_redemption.php"><span>Add Redemption Product</span></a></li>
						<li><a href="../redemption/view_redemption_list.php"><span>Redemption Orders</span></a></li>
						<li><a href="../redemption/redemption_history.php"><span>Redemption History</span></a></li>
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
			<table border="0" align="center" width="600px" height="250px" cellpadding="0" cellspacing="0" class="box-table-b">
				<tr>
					<td align="center">
						<table border="0" width="600px" height="200px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
							<tr>
								<th colspan="4" align="center">Point Redemption Products</th>
							</tr>
							<tr>
								<th>Order Status</th>
								<td colspan="4" align="center">
									<?php	if(!isset($_GET['order'])){
											}else{
												$create_order = mysqli_real_escape_string($dbconnect, $_GET['order']);
																	
												if($create_order == "true"){
													echo "<span class='success'>Order successfully saved.</span>";
												}
											}
									?>
								</td>
							</tr>
							<tr>
								<?php	while($item_display = mysqli_fetch_array($item)){?>
											<td>
												<table border="1" width="150px" cellpadding="0" cellspacing="0">
													<tr>
														<?php	if($item_display['redeem_stock'] == '0'){
																	$event = "onClick='return linkStop();'";
																}else{
																	$event = "";
																}
														?>
														<td align="center">
															<a href="redemption.php?it=<?=$item_display['redeem_id']?>&mem=<?=$mem_id?>&hyperlink=redemption" <?=$event?>><img src="../redemption/<?=$item_display['redeem_image']?>" width="150px" height="150px" alt="<?=$item_display['redeem_name']?>" /></a>
														</td>
													</tr>
													<tr>
														<td align="center" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;">
															<?php	if($item_display['redeem_stock'] == '0'){
																		echo "<span class='out_of_stock'>Out of stock</span>";
																	}else{
																		echo $item_display['redeem_stock']." in stock";
																	}
																	$item_rows++;
															?>
														</td>
													</tr>
													<tr>
														<td align="center" style="border-left-style:hidden;border-right-style:hidden;border-bottom-style:hidden;"><?=$item_display['redeem_point']?> Points</td><input type="hidden" class="item_point" value="<?=$item_display['redeem_point']?>" />
													</tr>
												</table>
											</td>
											<?php	if($item_rows%4 == 0){
														echo "</tr>";
														echo "<tr><td height='20px' style='border-style:hidden;'></td></tr>";
														echo "<tr>";
													}
											?>
											<?php	}	?>
							</tr>
							<tr>
								<td height="50px" colspan="8" style="border-style:hidden;">
									<table border="0" align="center" valign="bottom" width="600px">
										<tr>
											<td align="center" style="border-style:hidden;"><?=$pagination?></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<?php
				include('../footer.php');
			?>
		</div>	
		
		<script>
			function linkStop(){
				return false;
			}
		</script>
	</body>
</html>