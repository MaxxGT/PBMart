<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product");
	$promotion_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category");
?>

<html>
	<head>
		<title>Stock Reports</title>
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
			#promotion_list{
				display:none;
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
		<script src="../js/datepicker/datetimepicker_css.js"></script>
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
						<li><a href="../report/report.php?hyperlink=reports" class="current"><span>Generate Report</span></a></li> 
						<li><a target="_blank" href="../../"><span>Visit Website </span></a></li>
				   </ul>
				</div>
			</div>
			<!-- TABS END -->
		</div>
		<div class="grid_16" id="content">	
			<br />			
			<div class="breadcrumb">
				<p><a href="../main.php?hyperlink=main">Dashboard</a> >> <a href="../report/report.php?hyperlink=reports">Generate Report</a> >> <a href="../report/stock_report.php?hyperlink=reports">Stock Report</a></p>
			</div>
			</br>
			</br>
			</br>
			<div id="stock">
				<form action="stock_list.php?hyperlink=reports" method="POST"> 
					<table border="2" width="600px" cellspacing="0" cellpadding="0" class="box-table-a">
						<tr>
							<th width="100px">
								<label for="start_date"><span class="compulsory">*</span>From : </label>
							</th>
							<td width="180px">
								<input type="text" name="start_date" id="start_date" onClick="javascript:NewCssCal('start_date','yyyyMMdd','arrow')"/>
							</td>
							<th width="100px">
								<label for="end_date"><span class="compulsory">*</span>To : </label>
							</th>
							<td width="180px">
								<input type="text" name="end_date" id="end_date" onClick="javascript:NewCssCal('end_date','yyyyMMdd','arrow')"/>
							</td>
						</tr>
						<tr>
							<td colspan="4" align="center">
								<input type="button" onClick="enable_product();" id="enable_prod" value="Product" style="width:140px;height:40px;" disabled />
								<input type="button" onClick="enable_promotion();" id="enable_promo" Value="Promotion" style="width:140px;height:40px;"/>
							</td>
						</tr>
						<tr>
							<th>
								<label for="product_list"><span class="compulsory">*</span>Product :</label>
							</th>
							<td colspan="3">
								<select id="product_list" name="product_list" style="width:300px;">
									<option value="">-Please select product...-</option>
									<?php	while($product_display = mysqli_fetch_array($product)){
												echo "<option value='".$product_display['product_id']."'>".$product_display['product_name']."</option>";
											}
									?>
								</select>
								<select id="promotion_list" name="promotion_list" style="width:300px;">
									<option value="">-Please select promotion...-</option>
									<?php	while($promotion_cat_display = mysqli_fetch_array($promotion_cat)){
											echo "<option value='".$promotion_cat_display['promotion_category_id']."'>".$promotion_cat_display['promotion_category_name']."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="4"><input type="submit" value="Generate" name="generate_rep"onClick="return checkFields();"/></td>
						</tr>
					</table>
				</form>
			</div>
			
			<?php
				include('../footer.php');
			?>
		</div>
		
		<script>
			$(document).ready(function () {
				$( "#start_date" ).datepicker({
					changeMonth: true,
					changeYear: true 
				});
				
				$( "#end_date" ).datepicker({
					changeMonth: true,
					changeYear: true 
				});
			});
			
			function enable_product(){
				document.getElementById('promotion_list').style.display = "none";
				document.getElementById('product_list').style.display = "block";
				document.getElementById('promotion_list').value = "";
				document.getElementById('enable_prod').disabled = true;
				document.getElementById('enable_promo').disabled = false;
			}
			
			function enable_promotion(){
				document.getElementById('product_list').style.display = "none";
				document.getElementById('promotion_list').style.display = "block";
				document.getElementById('product_list').value = "";
				document.getElementById('enable_promo').disabled = true;
				document.getElementById('enable_prod').disabled = false;
			}
			
			function checkFields(){
				var start = document.getElementById('start_date').value;
				var end = document.getElementById('end_date').value;
				var product = document.getElementById('product_list').value;
				var promotion = document.getElementById('promotion_list').value;
				
				if(start == "" || end == "" || (product =="" && promotion == "")){
					var message = "Please fill in the following field(s) before proceed!";
					
					if(start == "")
						message = message + "\n-From";
					if(end == "")
						message = message + "\n-To";
					if(product == "" || promotion == ""){
						if(product == "" && promotion == ""){
							message = message + "\n-Product/Promotion";
						}
					}
					
					alert(message);
					return false;
				}
			}
		</script>
	</body>
</html>