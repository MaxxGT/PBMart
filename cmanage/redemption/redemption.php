<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$item_id = mysqli_real_escape_string($dbconnect, $_GET['it']);
	$mem_id = mysqli_real_escape_string($dbconnect, $_GET['mem']);
	
	$item = mysqli_query($dbconnect, "SELECT * FROM pbmart_redeem WHERE redeem_id='$item_id'");
	$item_display = mysqli_fetch_assoc($item);
	
	$redeem_cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_redemption_category");
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member WHERE member_id='$mem_id'");
	$member_point = mysqli_fetch_assoc($member);
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
		<script src="../js/datepicker/datetimepicker_css.js"></script>
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
						<li><a href="../redemption/view_redemption.php"><span>Redemption Products</span></a></li> 
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
		<form action="redemption_item.php?it=<?=$item_id?>" method="POST">
			<table border="0" width="600px" align="center" cellpadding="0" cellspacing="0" class="box-table-a">
				<tr>
					<th colspan="2" align="center">Redeem Product</th>
				</tr>
				<tr>
					<th> Product Image</th>
					<td style="border-style:solid;" align="center">
						<img src="<?=$item_display['redeem_image']?>" width="200px" height="200px" alt="<?=$item_display['redeem_image']?>"/>
						<input type="hidden" id="point" value="<?=$member_point['member_point']?>"/>
						<input type="hidden" id="token" value="<?=$member_point['member_token']?>"/>
					</td>
				</tr>
				<tr>
					<th valign="top" style="padding-left:12;">
						<label for="item_cat">Category : </label>
					</th>
					<td>
						<?php	echo "<select id='redeem_category' name='redeem_category' disabled>";
								echo "<option value=''>-Please select category...-</option>";
														
								while($redeem_display = mysqli_fetch_array($redeem_cat)){
										
									if($redeem_display['redemption_category_name'] == $item_display['redeem_category']){
										$select = "selected";
									}else{
										$select = "";
									}
						?>
									<option value="<?=$redeem_display['redemption_category_id']?>" <?=$select?>><?=$redeem_display['redemption_category_name']?></option>
						<?php	}	
								echo "</select>";
						?>
					</td>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="item_name">Name : </label>
					</th>
					<td>
						<input type="text" id="item_name" name="item_name" value="<?=$item_display['redeem_name']?>" disabled />
					</td>
				</tr>				
				<tr>
					<th style="padding-left:12px;">
						<label for="item_model">Model : </label>
					</th>
					<td>
						<input type="text" name="item_model" value="<?=$item_display['redeem_model']?>" disabled />
					</td>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="item_point">Point : </label>
					</th>
					<td>
						<input type="number" id="item_point" name="item_point" value="<?=$item_display['redeem_point']?>" disabled />
					</td>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="item_token">Token : </label>
					</th>
					<td>
						<input type="number" id="item_token" name="item_token" value="<?=$item_display['redeem_token']?>" disabled />
					</td>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="item_stock">Stock number : </label>
					</th>
					<td>
						<input type="number" id="item_stock" name="item_stock" value="<?=$item_display['redeem_stock']?>" disabled />
					</td>
				</tr>
				<tr>
					<th valign="top" style="padding-left:12;">
						<label for="item_description">Description : </label>
					</th>
					<td>
						<textarea id="item_description" name="item_description" rows="3" cols="30" value="<?=$item_display['redeem_description']?>" disabled></textarea>
					</td>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="quantity">Quantity : </label>
					</th>
					<td>
						<input type="number" name="quantity" id="quantity" value="1"/> /<?=$item_display['redeem_stock']?>
					</td>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="choice">Choice : </label>
					</th>
					<td>
						<input type="radio" name="choice" id="red_point" value="point">Point
						<input type="radio" name="choice" id="red_token" value="token">Token
					</td>					
				</tr>
				<tr>
					<th colspan="2" align="center">Delivery</th>
				</tr>
				<tr>
					<th style="padding-left:12;">
						<label for="deliv_date">Delivery Date : </label>
					</th>
					<td>
						<input input="deliv_date" name="deliv_date" id="deliv_date" onclick="javascript:NewCssCal('deliv_date','yyyyMMdd','arrow')"/>
					</td>
				</tr>
				<tr>
					<th align="center" colspan="2">
						<input type="hidden" id="mem_id" name="mem_id" value="<?=$mem_id?>" />
						<input type="submit" name="redeem" value="Redeem" onClick="return checkPoints();"/>
						<input type="hidden" id="stock_qty" value="<?=$item_display['redeem_stock']?>"/>
					</th>
				</tr>
				<tr>
					<td colspan="2" style="border-style:hidden;">
						<input type="button" name="back" onClick="backItem();" value="Back"/>
					</td>
				</tr>
			</table>
		</form>
			
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		<?php
			include('../footer.php');
		?>
	</div>	
	
	<script>
		$(document).ready(function () {
			$( "#deliv_date" ).datepicker({
				changeMonth: true,
				changeYear: true 
			});
		});
			
		function checkPoints(){
			var points = document.getElementById('point').value;
			var tokens = document.getElementById('token').value;
			var item_points = document.getElementById('item_point').value;
			var item_token = document.getElementById('item_token').value;
			var item_stock = document.getElementById('quantity').value;
			var stock = document.getElementById('stock_qty').value;
			var delivery = document.getElementById('deliv_date').value;
			var total = item_points * item_stock;
			var total_tok = item_token * item_stock;
			
			if((item_stock  == "" || item_stock > stock || item_stock <= 0) || delivery == ""){
				if(delivery == ""){
					var deliv_alert = "Please fill in delivery date!";
				}else{
					var deliv_alert = "";
				}
								
				if(item_stock == ""){
					alert("Redeem quantity cannot be empty! " +deliv_alert);
					return false;
				}else if(item_stock > stock){
					alert("Redeem quantity cannot be more than stock quantity! " +deliv_alert);
					return false;
				}else if(item_stock <= 0){
					alert("Redeem quantity cannot be less than zero! " +deliv_alert);
					return false;
				}else{
					alert(deliv_alert);
					return false;
				}
			}else{
				if(document.getElementById('red_point').checked){
					if(points < total){
						alert("This member (current points : " +points +" Points ) does not have enough points to redeem this item.");
						return false;
					}else{
						var confirmRedeem = confirm("Do you wish to redeem this item? " +points +" Points - " +total +" Points = " +(points-total) +" Points?");
						
						if(confirmRedeem){
							return true;
						}else{
							return false;
						}
					}
				}else if(document.getElementById('red_token').checked){
					if(tokens < total_tok){
						alert("This member (current tokens : " +tokens +" Tokens ) does not have enough tokens to redeem this item.");
						return false;
					}else{
						var confirmRedeem = confirm("Do you wish to redeem this item? " +tokens +" Tokens - " +total_tok +" Tokens = " +(tokens-total_tok) +" Tokens?");
						
						if(confirmRedeem){
							return true;
						}else{
							return false;
						}
					}
				}else{
					alert("Please choose between using points or tokens to redeem this item!");
					return false;
				}
			}
		}
			
		function backItem(){
			var confirmBack = confirm("Do you wish to go back?");
			
			if(confirmBack){
				var id = document.getElementById('mem_id').value;
				window.location = "redeem_item.php?mem=" +id +"&hyperlink=redemption";
			}else{
			}
		}
		</script>
	</body>
</html>