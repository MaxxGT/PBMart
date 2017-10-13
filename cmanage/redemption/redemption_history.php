<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "redemption_history.php";
	$limit = 20;
	
	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_redemption_list WHERE redemption_status='1'"));
	$total_pages = $total_pages['num'];
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	$redeem = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_list WHERE redemption_status='1' LIMIT $start, $limit");
	$red_count = mysqli_num_rows($redeem);
	
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
			$pagination.= "<a href=\"$targetpage?page=1&hyperlink=redemption\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=redemption\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=redemption\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&hyperlink=redemption\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=redemption\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&hyperlink=redemption\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&hyperlink=redemption\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=redemption\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&hyperlink=redemption\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=redemption\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=redemption\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=redemption\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Redemption History</title>
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
						<li><a href="../redemption/view_redemption.php?hyperlink=redemption" ><span>Redemption Products</span></a></li> 
						<li><a href="../redemption/redeem.php?hyperlink=redemption"><span>Manual Redemption</span></a></li> 
						<li><a href="../redemption_category/redemption_category.php?hyperlink=redemption"><span>Redemption Category</span></a></li> 
						<li><a href="../redemption/add_redemption.php?hyperlink=redemption"><span>Add Redemption Product</span></a></li>
						<li><a href="../redemption/view_redemption_list.php?hyperlink=redemption"><span>Redemption Orders</span></a></li>
						<li><a href="../redemption/redemption_history.php?hyperlink=redemption" class="current"><span>Redemption History</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
				 <p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../redemption/redemption_history.php?hyperlink=redemption">Redemption History</a></p>
			</div>
			<br />		
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
						
			<table border="2" align="center" width="700px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="7" align="center">Member Point Redemption History</th>
				</tr>
				<tr>
					<?php	if($red_count == "0"){
								$bor_style = "border-bottom-style:hidden;";
							}else{
								$bor_style = "";
							}
					?>
					<th width="20px" class="chkBox" style="<?=$bor_style?>"></th>
					<th width="100px" style="padding-left:5;">Re. No</th>
					<th width="250px" style="padding-left:5;">Name</th>
					<th width="100px" style="padding-left:5;">Date</th>
					<th width="50px" style="padding-left:5;">Time</th>
					<th width="100px" style="padding-left:5;">Delivery</th>
					<th width="80px" style="padding-left:5;">Status</th>
				</tr>
				<?php	while($redeem_display = mysqli_fetch_array($redeem)){	?>
				<tr>
					<td align="center" width="20px" >
						<input type="checkbox" name="redemptionList[]" value="<?php	echo $redeem_display['redemption_id'];	?>"/>
					</td>
					<td width="100px" style="padding-left:5;"><?=$redeem_display['redemption_number']?></td>
					<td width="250px" style="padding-left:5;">
						<?php	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='".$redeem_display['redemption_member_id']."'");
								$member_com = mysqli_fetch_assoc($member);
								
								if($member_com['member_commercial_status'] == '1'){
									$commercial = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_member_id='".$redeem_display['redemption_member_id']."'");
									$commercial_name = mysqli_fetch_assoc($commercial);
									
									echo $commercial_name['commercial_company'];
								}else{
									echo $redeem_display['redemption_member_name'];
								}
						?>
					</td>
					<td width="100px" style="padding-left:5;"><?=$redeem_display['redemption_date']?></td>
					<td width="50px" style="padding-left:5;"><?=$redeem_display['redemption_time']?></td>
					<td width="100px" style="padding-left:5;"><?=$redeem_display['redemption_delivery_date']?></td>
					<td width="80px" style="padding-left:5;">Completed</td>
				</tr>
				<?php	}	?>
				<tr>
					<td height="50px" align="center" colspan="8" style="border-style:hidden;">
						<table border="0" align="center" valign="bottom" width="600px">
							<tr>
								<td align="center" style="border-style:hidden;"><?=$pagination?></td>
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
	</body>
</html>