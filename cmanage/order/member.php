<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
		/* PAGINATION */
	$adjacents = 3;
	$targetpage = "member.php";
	$limit = 15;
	
	$searchKey = "";
	$keyword = "";
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	if(!empty($_GET['page'])){
		$page = mysqli_real_escape_string($dbconnect, $_GET['page']);
		$start = ($page - 1) * $limit;
	}else{
		$page = 0;
		$start = 0;
	}
	
	if(!empty($_GET['search']) != ""){
		$searchKey = mysqli_real_escape_string($dbconnect, $_GET['search']);
		$total_pages_que = "SELECT COUNT(*) as num FROM pbmart_member WHERE member_first_name LIKE'%".$searchKey."%' OR member_last_name LIKE'%".$searchKey."%' OR member_email LIKE'%".$searchKey."%'";
		
		$member_que = "(SELECT
		 member_id AS 'member_id',
		 member_first_name AS 'member_first_name', 
		 member_last_name AS 'member_last_name',
		 member_contact AS 'member_contact',
		 member_email AS 'member_email',
		 '-' AS 'commercial_company' 
		 FROM pbmart_member 
		 WHERE member_first_name LIKE '%".$searchKey."%' OR
			   member_last_name LIKE '%".$searchKey."%' OR
			   member_number LIKE '%".$searchKey."%')
 
		 UNION
		 
		 (SELECT  
		  pbmart_member.member_id AS 'member_id',
		  pbmart_member.member_first_name AS 'member_first_name',
		  pbmart_member.member_last_name AS 'member_last_name',
		  pbmart_member.member_contact AS 'member_contact',
		  pbmart_member.member_email AS 'member_email',
		  commercial_company AS 'commercial_company' 
		  FROM pbmart_commercial INNER JOIN pbmart_member
		  ON pbmart_commercial.commercial_member_id = pbmart_member.member_id
		  AND pbmart_commercial.commercial_member_number = pbmart_member.member_number
		 WHERE commercial_company LIKE '%".$searchKey."%')";
 
 
 
 
	}else if(!empty($_GET['key']) != ""){
		$keyword = mysqli_real_escape_string($dbconnect, $_GET['key']);
		$total_pages_que = "SELECT COUNT(*) as num FROM pbmart_member WHERE member_first_name LIKE'".$keyword."%' OR member_last_name LIKE'".$keyword."%'";
		$member_que = "SELECT * FROM pbmart_member WHERE member_first_name LIKE'".$keyword."%' OR member_last_name LIKE'".$keyword."%' LIMIT $start, $limit";
	}else{
		$total_pages_que = "SELECT COUNT(*) as num FROM pbmart_member";
		$member_que = "(SELECT '-' AS 'commercial_company', member_id, member_first_name, member_last_name, member_contact, member_email FROM pbmart_member LIMIT $start, $limit)";
	}
	
	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, $total_pages_que));
	$total_pages = $total_pages['num'];
	
	$member = mysqli_query($dbconnect, $member_que);
	$member_count = mysqli_num_rows($member);
	
	if($page == 0)
		$page = 1;
	
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1){
		$pagination.= "<div class=\"pagination\">";
		
		// first button
		if($page > 1)
			$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=orders\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=orders\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=orders\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=orders\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=orders\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&$keyword&search=$searchKey&hyperlink=orders\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=orders\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=orders\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=orders\">$counter</a>";
				}
			}
		}
		
		// next button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&$keyword&search=$searchKey&hyperlink=orders\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">next >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Proceed Checkout</title>
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
							  <li><a href="view_order.php"><span>Orders</span></a></li>  
							  <li><a href="make_order.php" class="current"><span>Place Manual Order</span></a></li>
							  <li><a href="order_history.php"><span>Order History</span></a></li> 						  
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		<div class="grid_16" id="content">	
				<br />						
				<br />
				<br />
						<table border="0" width="620px" height="30px" align="center" cellpadding="0" cellspacing="0" >
						</table>
						</br>
						<table border="1" align="center" width="700px" cellpadding="0" cellspacing="0" class="box-table-a">
							<tr>
								<th colspan="4" align="center"> Member Type Selection </th>
							<tr>
							<tr>
								<th colspan="2" onClick="nonExist();"><input type="button" style="width:310px;" value="Non registered member"/></th>
								<th colspan="2" onClick="exist();"><input type="button" style="width:310px;" value="Registered member" disabled/></th>
							</tr>
							<tr>
								<td colspan="4">
									<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
										<tr>	
											<th colspan="2" align="center">Search Members</th>
										</tr>
										<tr>
											<th width="300px" align="center">
												<input type="text" name="searchKey" id="searchKey" size='70' style="text-transform: capitalize;" placeholder='Company/ Member No./ Name' autofocus />
											</th>
											<th>
												<input type="button" value="Search" onClick="searchKeyword();"/>
											</th>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<?php	$keywords = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
																							
														echo "<a href='member.php?key=&hyperlink=orders&page=".$page."'><input type='button' name='keyword' id='keyword' value='ALL'/></a>";
																							
														for($i=0; $i<26; $i++){
															if($keyword == $keywords[$i]){
																$status = "Disabled";
															}else{
																$status = "";
															}
																									
															echo "<a href='member.php?key=".$keywords[$i]."&hyperlink=orders&page=".$page."'><input type='button' name='keyword' id='keyword' value='".$keywords[$i]."' ".$status."/></a>";
														}
												?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<th width="200px" style="padding-left:5;">Company Name</th>
								<th width="150px" style="padding-left:5;">Name</th>
								<th width="150px" style="padding-left:5;">E-mail</th>
								<th style="padding-left:5;">Contact No.</th>
															</tr>
							<?php	while($member_display = mysqli_fetch_array($member)){	?>
								<tr class="link" href="proceed_checkout.php?mem=<?=$member_display['member_id']?>" style="text-decoration: none;">
									<td width="200px" style="padding-left:5;"><?=$member_display['commercial_company']?></td>
									<td width="150px" tyle="padding-left:5;"><?=$member_display['member_first_name']?> <?=$member_display['member_last_name']?>
									</td>
									<td style="padding-left:5;"><?=$member_display['member_email']?></td>
									<td style="padding-left:5;"><?=$member_display['member_contact']?></td>
								</tr>
							<?php	}	?>
									<tr>
										<td  height="50px" colspan="8" style="border-style:hidden;">
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
			$('#searchKey').keydown(function(e){
				if(e.keyCode == '13'){
					searchKeyword()
				}
			});
		
			function searchKeyword(){
				var keyword = document.getElementById('searchKey').value;

				window.location= 'member.php?key=&search='+keyword+'&hyperlink=orders';
			}
		
			function nonExist(){
				window.location = "proceed_checkout.php";
			}
			
			function exist(){
				window.location = "member.php";
			}
			
			$(document).ready(function(){
				$('.link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		</script>
	</body>
</html>