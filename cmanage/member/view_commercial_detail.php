<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	$com_id = mysqli_real_escape_string($dbconnect, $_GET['com']);
	$com = mysqli_query($dbconnect, "SELECT * FROM pbmart_commercial WHERE commercial_id='$com_id'");
	$com_display = mysqli_fetch_assoc($com);
?>

<html>
	<head>
		<title>Commercial Approval</title>
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
			#form49,#form24,#form9,#registration,#borang1,#lesenRuncit,#lesenmpp{
				display:none;
			}
		</style>
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
						<li><a href="view_member.php?hyperlink=members"><span>Members</span></a></li>   
						<li><a href="add_member.php?hyperlink=members"><span>Add New Member</span></a></li>
						<li><a href="view_commercial.php?hyperlink=members" class="current"><span>Commercial Application</span></a></li>
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>
		<div class="grid_16" id="content">	
			<br />						
			<div class="breadcrumb">
			   <p style="float:left; padding-left:10px;"><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../member/view_commercial.php?hyperlink=members">Commercial Application</a> >> <a href="../member/view_commercial_detail.php?hyperlink=members">Commercial Approval</a></p>
			</div>
			<br />	
			<table border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			
			<form action="commercial_status.php" method="POST">
				<table border="0" width="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
					<tr>
						<th align="center" colspan="2">Commercial Application Management</th>
					</tr>
					<tr>
						<th width="150px"><label class="display">Commercial Number : </label></th>
						<td><?=$com_display['commercial_number']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company Name : </label></th>
						<td><?=$com_display['commercial_company']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company number : </label></th>
						<td><?=$com_display['commercial_company_number']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company Phone Number : </label></th>
						<td><?=$com_display['commercial_phone']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company Address : </label></th>
						<td><?=$com_display['commercial_address']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company Postal Code : </label></th>
						<td><?=$com_display['commercial_postcode']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company State : </label></th>
						<td><?=$com_display['commercial_state']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Company Country : </label></th>
						<td><?=$com_display['commercial_country']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Application Date : </label></th>
						<td><?=$com_display['commercial_application_date']?></td>
					</tr>
					<tr>
						<th width="150px"><label for="commercial_class" class="display"><span class="compulsory">*</span>Commercial Class : </label></th>
						<td>
							<select name="commercial_class" id="commercial_class" style="width:172px;">
								<option value="">-Please select class-</option>
								<option value="1">Normal Commercial</option>
								<option value="2">Grocery Commercial</option>
								<option value="3">Staff</option>
							</select>
						</th>
					</tr>
					<tr>
						<th width="150px"><label for="prod_limit" class="display"><span class="compulsory">*</span>Product Limitation : </label></th>
						<td><input type="number" name="prod_limit" id="prod_limit"/></td>
					</tr>
					<tr>
						<th width="150px"><label for="addi_point" class="display"><span class="compulsory">*</span>Additional Point : </label></th>
						<td><input type="number" name="addi_point" id="addi_point"/></td>
					</tr>
					<tr>
						<th align="center" colspan="2">Person In Charge</th>
					</tr>
					<tr>
						<th width="150px"><label class="display">Name : </label></th>
						<td><?=$com_display['commercial_person_incharge']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">IC Number : </label></th>
						<td><?=$com_display['commercial_person_ic']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Position : </label></th>
						<td><?=$com_display['commercial_person_position']?></td>
					</tr>
					<tr>
						<th width="150px"><label class="display">Phone Number : </label></th>
						<td><?=$com_display['commercial_person_phone']?></td>
					</tr>
					<tr height="50px">
						<th align="center" colspan="2" style="vertical-align:middle;">
							<input type="hidden" name="com_id" id="com_id" value="<?=$com_display['commercial_id']?>"/>
							<input type="hidden" name="mem_id" id="mem_id" value="<?=$com_display['commercial_member_id']?>"/>
							<input type="submit" value="Approve" name="approve" style="width:120px;height=:50px;background-color:#00E600;color:white;font-size:16px;" onClick="return check_fields()"/>
							<input type="submit" value="Disapprove" name="disapprove" style="width:120px;height=:50px;background-color:red;color:white;font-size:16px;"/>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="border-style:hidden;">
							<input type="button" name="back" onClick="backMember();" value="Back"/>
						</td>
					</tr>
				</table>
			</form>
			
			<div class="company_form" style="margin-bottom:40px;">
				<div class="form_header">
					Company Trading Form
				</div>
				<div style="margin-top:20px;">
					<div align="left" class="commercial_form">Registration</div>
					<?php	if($com_display['commercial_form_registration'] == ""){
								$label_reg = "<span id='ahrefregistration'>No attachment</span>";
							}else{
								$label_reg = "<a href='#registration' onClick='showRegistration();'><span id='ahrefregistration'>Show form</span></a> <div id='registration'> <embed src='../commercial/commercial_form/".$com_display['commercial_form_registration']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_reg;
					?>
				</div>
				</br>
				<div>
					<div align="left" class="commercial_form">Borang 1</div>
					<?php	if($com_display['commercial_form_borang1'] == ""){
								$label_borang = "<span id='ahrefborang1'>No attachment</span>";
							}else{
								$label_borang = "<a href='#borang1' onClick='showBorang1();'><span id='ahrefborang1'>Show form</span></a> <div id='borang1'> <embed src='../commercial/commercial_form/".$com_display['commercial_form_borang1']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_borang;
					?>
				</div>
				</br>
				<div>
					<div align="left" class="commercial_form">Lesen Runcit</div>
					<?php	if($com_display['commercial_form_lesen_runcit'] == ""){
								$label_les_run = "<span id='ahreflesenRuncit'>No attachment</span>";
							}else{
								$label_les_run = "<a href='#lesenRuncit' onClick='showLesenRuncit();'><span id='ahreflesenRuncit'>Show form</span></a> <div id='lesenRuncit'> <embed src='../commercial/commercial_form/".$com_display['commercial_form_lesen_runcit']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_les_run;
					?>
				</div>
				</br>
				<div style="margin-bottom:20px;">
					<div align="left" class="commercial_form">Lesen Simpanan Petroleum dan LPG</div>
					<?php	if($com_display['commercial_form_mpp'] == ""){
								$label_les_mpp = "<span id='ahreflesenmpp'>No attachment</span>";
							}else{
								$label_les_mpp = "<a href='#lesenmpp' onClick='showLesenMpp();'><span id='ahreflesenmpp'>Show form</span></a> <div id='lesenmpp'> <embed src='../commercial/commercial_form/".$com_display['commercial_form_mpp']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_les_mpp;
					?>
				</div>
			</div>
			
			<div class="company_form">
				<div class="form_header">
					Company Form
				</div>
				<div style="margin-top:20px;">
					<div align="left" class="commercial_form">Form 49</div>
					<?php	if($com_display['commercial_form49'] == ""){
								$label_form49 = "<span id='ahrefform49'>No attachment</span>";
							}else{
								$label_form49 = "<a href='#form49' onClick='showform49();'><span id='ahrefform49'>Show form</span></a> <div id='form49'> <embed src='../commercial/commercial_form/".$com_display['commercial_form49']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_form49;
					?>
				</div>
				</br>
				<div>
					<div align="left" class="commercial_form">Form 24</div>
					<?php	if($com_display['commercial_form24'] == ""){
								$label_form24 = "<span id='1ahrefform24'>No attachment</span>";
							}else{
								$label_form24 = "<a href='#form24' onClick='showform24();'><span id='ahrefform24'>Show form</span></a> <div id='form24'> <embed src='../commercial/commercial_form/".$com_display['commercial_form24']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_form24;
					?>
				</div>
				</br>
				<div style="margin-bottom:20px;">
					<div align="left" class="commercial_form">Form 9</div>
					<?php	if($com_display['commercial_form9'] == ""){
								$label_form9 = "<span id='1ahrefform9'>No attachment</span>";
							}else{
								$label_form9 = "<a href='#form9' onClick='showform9();'><span id='ahrefform9'>Show form</span></a> <div id='form9'> <embed src='../commercial/commercial_form/".$com_display['commercial_form9']."' width='900px' height='500px'> </div>";
							}
							
							echo $label_form9;
					?>
				</div>
			</div>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<?php
				include('../footer.php');
			?>
		</div>
		
		<div id="formsToggle">
			<input type="button" onClick="formToggle()" id="toggle" value="Show All Forms"/>
		</div>
		
		<script>
			function backMember(){
				var backCheck = confirm("Do you wish to go back?");
				
				if(backCheck){
					window.location = "view_commercial.php?hyperlink=members";
				}else{
				}
			}
			
			function check_fields(){
				var limit = document.getElementById('prod_limit').value;
				var point = document.getElementById('addi_point').value;
				var comclass = document.getElementById('commercial_class').value;
				
				if(limit == "" || point == "" || comclass == ""){
					var message = "Please fill in the following:";
					
					if(limit == "")
						message = message + "\n-Porduct Limitation.";
					if(point == "")
						message = message + "\n-Additional Point";
					if(comclass == "")
						message = message + "\n-Commercial Class";
					
					alert(message);
					return false;
				}else{
					return true;
				}
			}
			
			function showRegistration(){
				if(document.getElementById('registration').style.display == 'block'){
					document.getElementById('registration').style.display = 'none';
					document.getElementById('ahrefregistration').innerHTML = "Show form";
				}else{
					document.getElementById('registration').style.display = 'block';
					document.getElementById('ahrefregistration').innerHTML = "Hide form";
				}
			}
			
			function showBorang1(){
				if(document.getElementById('borang1').style.display == 'block'){
					document.getElementById('borang1').style.display = 'none';
					document.getElementById('ahrefborang1').innerHTML = "Show form";
				}else{
					document.getElementById('borang1').style.display = 'block';
					document.getElementById('ahrefborang1').innerHTML = "Hide form";
				}
			}
			
			function showLesenRuncit(){
				if(document.getElementById('lesenRuncit').style.display == 'block'){
					document.getElementById('lesenRuncit').style.display = 'none';
					document.getElementById('ahreflesenRuncit').innerHTML = "Show form";
				}else{
					document.getElementById('lesenRuncit').style.display = 'block';
					document.getElementById('ahreflesenRuncit').innerHTML = "Hide form";
				}
			}
			
			function showLesenMpp(){
				if(document.getElementById('lesenmpp').style.display == 'block'){
					document.getElementById('lesenmpp').style.display = 'none';
					document.getElementById('ahreflesenmpp').innerHTML = "Show form";
				}else{
					document.getElementById('lesenmpp').style.display = 'block';
					document.getElementById('ahreflesenmpp').innerHTML = "Hide form";
				}
			}
			
			function showform49(){
				if(document.getElementById('form49').style.display == 'block'){
					document.getElementById('form49').style.display = 'none';
					document.getElementById('ahrefform49').innerHTML = "Show form";
				}else{
					document.getElementById('form49').style.display = 'block';
					document.getElementById('ahrefform49').innerHTML = "Hide form";
				}
			}
			
			function showform24(){
				if(document.getElementById('form24').style.display == 'block'){
					document.getElementById('form24').style.display = 'none';
					document.getElementById('ahrefform24').innerHTML = "Show form";
				}else{
					document.getElementById('form24').style.display = 'block';
					document.getElementById('ahrefform24').innerHTML = "Hide form";
				}
			}
			
			function showform9(){
				if(document.getElementById('form9').style.display == 'block'){
					document.getElementById('form9').style.display = 'none';
					document.getElementById('ahrefform9').innerHTML = "Show form";
				}else{
					document.getElementById('form9').style.display = 'block';
					document.getElementById('ahrefform9').innerHTML = "Hide form";
				}
			}
			
			function formToggle(){				
				if(document.getElementById('toggle').value == "Show All Forms"){
					document.getElementById('toggle').value = "Hide All Forms";
					
					if(document.getElementById('ahrefregistration').innerHTML != "No attachment"){
						document.getElementById('registration').style.display = 'block';
						document.getElementById('ahrefregistration').innerHTML = "Hide form";
					}
					if(document.getElementById('ahrefborang1').innerHTML != "No attachment"){
						document.getElementById('borang1').style.display = 'block';
						document.getElementById('ahrefborang1').innerHTML = "Hide form";
					}
					if(document.getElementById('ahreflesenRuncit').innerHTML != "No attachment"){
						document.getElementById('lesenRuncit').style.display = 'block';
						document.getElementById('ahreflesenRuncit').innerHTML = "Hide form";
					}
					if(document.getElementById('ahreflesenmpp').innerHTML != "No attachment"){
						document.getElementById('lesenmpp').style.display = 'block';
						document.getElementById('ahreflesenmpp').innerHTML = "Hide form";
					}
					if(document.getElementById('ahrefform49').innerHTML != "No attachment"){
						document.getElementById('form49').style.display = 'block';
						document.getElementById('ahrefform49').innerHTML = "Hide form";
					}
					if(document.getElementById('ahrefform24').innerHTML != "No attachment"){
						document.getElementById('form24').style.display = 'block';
						document.getElementById('ahrefform24').innerHTML = "Hide form";
					}
					if(document.getElementById('ahrefform9').innerHTML != "No attachment"){
						document.getElementById('form9').style.display = 'block';
						document.getElementById('ahrefform9').innerHTML = "Hide form";
					}
				}else{
					document.getElementById('toggle').value = "Show All Forms";
					
					if(document.getElementById('ahrefregistration').innerHTML != "No attachment"){
						document.getElementById('registration').style.display = 'none';
						document.getElementById('ahrefregistration').innerHTML = "Show form";
					}
					if(document.getElementById('ahrefborang1').innerHTML != "No attachment"){
						document.getElementById('borang1').style.display = 'none';
						document.getElementById('ahrefborang1').innerHTML = "Show form";
					}
					if(document.getElementById('ahreflesenRuncit').innerHTML != "No attachment"){
						document.getElementById('lesenRuncit').style.display = 'none';
						document.getElementById('ahreflesenRuncit').innerHTML = "Show form";
					}
					if(document.getElementById('ahreflesenmpp').innerHTML != "No attachment"){
						document.getElementById('lesenmpp').style.display = 'none';
						document.getElementById('ahreflesenmpp').innerHTML = "Show form";
					}
					if(document.getElementById('ahrefform49').innerHTML != "No attachment"){
						document.getElementById('form49').style.display = 'none';
						document.getElementById('ahrefform49').innerHTML = "Show form";
					}
					if(document.getElementById('ahrefform24').innerHTML != "No attachment"){
						document.getElementById('form24').style.display = 'none';
						document.getElementById('ahrefform24').innerHTML = "Show form";
					}
					if(document.getElementById('ahrefform9').innerHTML != "No attachment"){
						document.getElementById('form9').style.display = 'none';
						document.getElementById('ahrefform9').innerHTML = "Show form";
					}
				}
			}
		</script>
	</body>
</html>