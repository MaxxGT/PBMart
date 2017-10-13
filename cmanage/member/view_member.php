<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	/* PAGINATION */
	$adjacents = 2;
	$targetpage = "view_member.php";
	$limit = 20;

	$searchKey = "";
	$keyword = "";
	
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
		$member_que = "SELECT * FROM pbmart_member WHERE member_first_name LIKE'%".$searchKey."%' OR member_last_name LIKE'%".$searchKey."%' OR member_email LIKE'%".$searchKey."%' OR member_ic LIKE '".$searchKey."%' LIMIT $start, $limit";
	}else if(!empty($_GET['key']) != ""){
		$keyword = mysqli_real_escape_string($dbconnect, $_GET['key']);
		$total_pages_que = "SELECT COUNT(*) as num FROM pbmart_member WHERE member_first_name LIKE'".$keyword."%' OR member_last_name LIKE'".$keyword."%'";
		$member_que = "SELECT * FROM pbmart_member WHERE member_first_name LIKE'".$keyword."%' OR member_last_name LIKE'".$keyword."%' LIMIT $start, $limit";
	}else{
		$total_pages_que = "SELECT COUNT(*) as num FROM pbmart_member";
		$member_que = "SELECT * FROM pbmart_member LIMIT $start, $limit";
	}
	
	$total_pages = mysqli_fetch_array(mysqli_query($dbconnect, $total_pages_que));
	$total_pages = $total_pages['num'];
	
	$member = mysqli_query($dbconnect, $member_que);
	$member_count = mysqli_num_rows($member);
	
	if($page == 0)
		$page = 1;
	
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1){
		$pagination.= "<div class=\"pagination\">";
		
		// First button
		if($page > 1)
			$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=members\"><< First</a>";
		else
			$pagination.= "<span class=\"disabled\"><< First</span>";
		
		// pages
		if($lastpage < 7 + ($adjacents * 2)){
			for($counter = 1; $counter <= $lastpage; $counter++){
				if($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=members\">$counter</a>";
			}
		}else if($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents  * 2)){
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=members\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=members\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=members\">$lastpage</a>";
			}else if($lastpage - ($adjacents *2) > $page && $page > ($adjacents *2)){
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=members\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=members\">2</a>";
				$pagination.= "...";
				
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=members\">$counter</a>";
				}
				
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&key=$keyword&search=$searchKey&hyperlink=members\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=members\">$lastpage</a>";
			}else{
				$pagination.= "<a href=\"$targetpage?page=1&key=$keyword&search=$searchKey&hyperlink=members\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&key=$keyword&search=$searchKey&hyperlink=members\">2</a>";
				$pagination.= "...";
				
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&key=$keyword&search=$searchKey&hyperlink=members\">$counter</a>";
				}
			}
		}
		
		// Last button
		if($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$lastpage&key=$keyword&search=$searchKey&hyperlink=members\">Last >></a>";
		else
			$pagination.= "<span class=\"disabled\">Last >></span>";
		
		$pagination.= "</div>\n";
	}
?>

<html>
	<head>
		<title>Member</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
		
		<style>
			#com_link:hover{
				cursor:pointer;
				width:100px;
			}
		</style>
		
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
						<li><a href="view_member.php?hyperlink=members" class="current"><span>Members</span></a></li>   
						<li><a href="view_salesman.php?hyperlink=members"><span>Salesmans</span></a></li>   
						<li><a href="add_member.php?hyperlink=members"><span>Add New Member</span></a></li>
						<li><a href="add_salesman.php?hyperlink=members"><span>Add New Salesman</span></a></li>
						<li><a href="view_commercial.php?hyperlink=members"><span>Commercial Application</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		<div class="grid_16" id="content">	
			<br />
			<div class="breadcrumb">
			   <p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_member.php?hyperlink=members">Members</a></p>
			</div>
			<br />	
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<table border="0" align="center" width="600px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>	
					<th colspan="2" align="left">Search Members</th>
				</tr>
				<tr>
					<th width="300px" align="left">
						<input type="text" name="searchKey" id="searchKey" size='38' placeholder='Name/ IC No/ Email' />
					</th>
					<th>
						<input type="button" value="Search" onClick="searchKeyword();"/>
					</th>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<?php	$keywords = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
																
								echo "<a href='view_member.php?key=&hyperlink=members'><input type='button' name='keyword' id='keyword' value='ALL'/></a>";
																
								for($i=0; $i<26; $i++){
									if($keyword == $keywords[$i]){
										$status = "Disabled";
									}else{
										$status = "";
									}
																		
									echo "<a href='view_member.php?key=".$keywords[$i]."&hyperlink=members'><input type='button' name='keyword' id='keyword' value='".$keywords[$i]."' ".$status."/></a>";
								}
						?>
					</td>
				</tr>
			</table>
			
			<div style="width:300px;margin-left:20px;">
				<div style="text-align:left;padding-left:10px;"><u><strong>Member Status Legend:</strong></u></div>
					<div>
						<div class="member_legend" style="background-color:#00E600;"></div>
						<div style="text-align:left;margin-left:100px;">Activated</div>
					</div>
					
					<div style="display:block;height:10px;"></div>
					
					<div>
						<div class="member_legend" style="background-color:red;"></div>
						<div style="text-align:left;margin-left:100px;">Deactivated</div>
					</div>
					
					<div style="display:block;height:10px;"></div>
					
					<div>
						<div class="member_legend" id="com_link" href="view_commercial_list.php?hyperlink=members" style="background-color:#FFCC00;"></div>
						<div style="text-align:left;margin-left:100px;">Commercial activated</div>
					</div>
					
					<div style="display:block;height:10px;"></div>
					
					<div>
						<div class="member_legend" style="background-color:black;"></div>
						<div style="text-align:left;margin-left:100px;">Blacklisted</div>
					</div>
			</div>
			
			<table border="1"  width="900px" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="9" align="center">Member Management</th>
				</tr>
				<form action="delete_member.php" method="POST">
				<tr>
					<th>Status :</th>
					<td align="center" colspan="8">
					<?php	if(!isset($_GET['stat'])){
							}else{
								$status_change = mysqli_real_escape_string($dbconnect, $_GET['stat']);													
								if($status_change == "true"){
									echo "<span class='success'>Member successfully activated/ deactivated.</span>";
								}else if($status_change == "false"){
									echo "<span>Member could not be activate/ deactivate! Please try again later.</span>";
								}else if($status_change == "ftrue"){
									echo "<span class='success'>Member point successfully forzen/ defrost.</span>";
								}else if($status_change == "ffalse"){
									echo "<span>Member point could not be forzen/ defrost! Please try again later.</span>";
								}
							}
							
							if(!isset($_GET['del'])){
							}else{
								$del_pro_result = mysqli_real_escape_string($dbconnect, $_GET['del']);
																
								if($del_pro_result == "true"){
									echo "<span class='success'>Member successfully deleted.</span>";
								}else if($del_pro_result == "false"){
									echo "<span>Member could not be deleted! Please try again later.</span>";
								}else if($del_pro_result == "empty"){
									echo "<span>There is no Member to be delete!</span>";
								}
							}
					?>
					</td>
				</tr>
				<tr>
					<?php	if($member_count == "0"){
								$bor_style = "border-bottom-style:hidden;";
							}else{
								$bor_style = "";
							}
					?>
					<th width="60px" class="chkBox" style="<?=$bor_style?>">Select</th>
					<th width="50px" style="padding-left:5;">Member No.</th>
					<th width="300px" style="padding-left:5;">Name</th>
					<th width="150px" style="padding-left:5;">Email</th>
					<th width="30px" style="padding-left:5;">Point</th>
					<th width="30px" style="padding-left:5;">Token</th>
					<th width="70px" style="padding-left:5;">Status</th>
					<th width="35px" style="padding-left:5;">P.F</th>
					<th width="35px" style="padding-left:5;">Edit</th>
				</tr>
				<?php	while($member_display = mysqli_fetch_array($member)){	?>
							<tr>
								<td align="center" width="60px">
									<input type="checkbox" name="memberList[]" value="
									<?php	echo $member_display['member_id'];	?>"/>
								</td>
								<td width="50px" style="padding-left:5;"><?=$member_display['member_number']?>
								</td>
								<td width="200px" style="padding-left:5;"><?=$member_display['member_first_name']?> <?=$member_display['member_last_name']?>
								</td>
								<td width="150px" style="padding-left:5;"><?=$member_display['member_email']?></td>
								<td align="right" width="70px" style="padding-right:5;"><?=$member_display['member_point']?></td>
								<td align="right" width="70px" style="padding-right:5;"><?=$member_display['member_token']?></td>
								<?php	if($member_display['member_status'] == 0){
											$color = "red";
										}else{
											if($member_display['member_commercial_status'] == 1){
												$color = "#FFCC00";
											}else{
												$color = "#00E600";
											}
										}
								?>
								<td width="70px" style="padding-left:5;padding-right:5;">
									<a href="change_member_status.php?mem=<?=$member_display['member_id']?>"><input type="button" name="status" style="background-color:<?=$color?>;width:80px;color:white;"/></a>
								</td>
								<?php	if($member_display['member_point_freeze'] == 0){
											$point_color = "#00E600";
										}else{
											$point_color = "Turquoise";
										}
								?>
								<td width="35px" align="center">
									<a href="freeze_member_point.php?mem=<?=$member_display['member_id']?>"><input type="button" name="status" style="background-color:<?=$point_color?>;width:30px;color:white;"/></a>
								</td>
								<td width="35px" align="center">
									<a href="edit_member.php?mem=<?=$member_display['member_id']?>&hyperlink=members"><img src="../images/edit.png" width="20px" height="20px" alt="Edit member"/></a>
								</td>
							</tr>
				<?php	}	?>
				<tr>
					<th colspan="8" align="center">
						<input type="submit" name="member_delete" onClick="return deleteMember();" value="Delete"/> <!--| <input type="submit" name="mem_deleteAll" onClick="return mem_checkDeleteAll();" value="Delete All"/>-->
					</th>
				</tr>
			</table>
			<div>
				<?=$pagination?>
				<?=$member_count?> of <span style="font-size:16px;color:blue;"><?=$total_pages?></span> members
			</div>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			</form>
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

				window.location = 'view_member.php?key=&search='+keyword+'&hyperlink=members';
			}
		
			$(document).ready(function(){
				$('#com_link').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
			
			function deleteMember(){
				var member_list = document.getElementsByName('memberList[]');
				var member_num = [];
				for(var i = 0; i < member_list.length; i++){
					if(member_list[i].checked){
						member_num++;
					}
				}
				
				if(member_num > 0){
					var confirmDelete = confirm("Do you wish to delete " +member_num +" member(s)?");
				}else{
					alert("Please select 1 or more member to delete!");
				}
				
				if(confirmDelete){
					return true;
				}else{
					return false;
				}
			}
			
			function mem_checkDeleteAll(){
				var confirmDelAll = confirm("Do you wish to delete all members?");
				
				if(confirmDelAll){
					return true;
				}else{
					return false;
				}
			}
		</script>
	</body>
</html>