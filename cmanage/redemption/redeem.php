<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "redeem.php";
	$limit = 20;
	$keyword = "";
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	if(isset($_POST['search']))
	{
		$search = $_POST['search'];
	}else
	{
		$search = '';
	}
	
	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT COUNT(*) as num FROM pbmart_member WHERE member_status='1'"));
	$total_pages = $total_pages['num'];
	
	if(!empty($search) != ""){
		$searchKey = mysqli_real_escape_string($dbconnect, $search);
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_status='1' AND member_first_name LIKE'%".$searchKey."%' OR member_last_name LIKE'%".$searchKey."%' OR member_ic LIKE '".$searchKey."%' LIMIT $start, $limit");
	}else if(!empty($_GET['key']) != ""){
		$keyword = mysqli_real_escape_string($dbconnect, $_GET['key']);
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_first_name LIKE'".$keyword."%' OR member_last_name LIKE'".$keyword."%' LIMIT $start, $limit");
	}else
	{
		$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_status='1' LIMIT $start, $limit");
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
				$pagination.= "<a href=\"$targetpage?page=1&hyperlink=redemption\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&hyperlink=redemption\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&hyperlink=redemption\">$counter</a>";
				}
			}
		}
		
		// next button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&hyperlink=redemption\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
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
						<li><a href="../redemption/redeem.php?hyperlink=redemption" class="current"><span>Manual Redemption</span></a></li> 
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
				<p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../redemption/redeem.php?hyperlink=redemption">Member Points</a></p>
			</div>
			<br />	
			
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
		<form action='redeem.php' method='post'>
			<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>	
					<th colspan="2" align="left">Search Members</th>
				</tr>
				<tr>
					<th width="300px" align="left">
						<input type="text" name="search" id="search" size='38' placeholder='Name /IC No.' autofocus />
					</th>
					<th>
						<input type="button" value="Search" action='submit'/>
					</th>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<?php	$keywords = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
																
								echo "<a href='redeem.php?key=&hyperlink=members'><input type='button' name='keyword' id='keyword' value='ALL'/></a>";
																
								for($i=0; $i<26; $i++){
									if($keyword == $keywords[$i]){
										$status = "Disabled";
									}else{
										$status = "";
									}
																		
									echo "<a href='redeem.php?key=".$keywords[$i]."&hyperlink=members'><input type='button' name='keyword' id='keyword' value='".$keywords[$i]."' ".$status."/></a>";
								}
						?>
					</td>
				</tr>
			</table>
		</form>	
					
						<table border="1" align="center" width="620px" cellpadding="0" cellspacing="0" class="box-table-a">
							<tr>
								<th colspan="4" align='center'>Manual Redemption</th>
							</tr>
							<tr>
								<th width="225px" style="padding-left:5;">Name</th>
								<th width="100px" style="padding-left:5;">Contact</th>
								<th width="225px" style="padding-left:5;">Email</th>
								<th width="80px" style="padding-left:5;">Points</th>
							</tr>
							<?php	while($member_display = mysqli_fetch_array($member)){	?>
								<tr class="link" href="redeem_item.php?mem=<?=$member_display['member_id']?>&hyperlink=redemption">
									<td width="225px" style="padding-left:5;"><?=$member_display['member_first_name']?> <?=$member_display['member_last_name']?>
									</td>
									<td width="100px" style="padding-left:5;"><?=$member_display['member_contact']?></td>
									<td width="225px" style="padding-left:5;"><?=$member_display['member_email']?></td>
									<td align="right" width="70px" style="padding-right:5;"><?=$member_display['member_point']?></td>
								</tr>
							<?php	}	?>
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
					
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
					<?php
					include('../footer.php');
				?>
		</div>
		
		<script>
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
			function searchKeyword(){
				var keyword = document.getElementById('searchKey').value;

				window.location = 'redeem.php?key=&search='+keyword+'&hyperlink=redemption';
			}
		</script>
	</body>
</html>