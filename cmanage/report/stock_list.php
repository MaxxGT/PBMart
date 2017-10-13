<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$start = mysqli_real_escape_string($dbconnect, $_POST['start_date']);
	$end = mysqli_real_escape_string($dbconnect, $_POST['end_date']);
	$product = mysqli_real_escape_string($dbconnect, $_POST['product_list']);
	$promotion = mysqli_real_escape_string($dbconnect, $_POST['promotion_list']);
	
	if($product != ""){
		$product_name = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$product'");
		$product_name_display = mysqli_fetch_assoc($product_name);
		$name = $product_name_display['product_name'];
		$class = "Product";
	}else{
		$promotion_name = mysqli_query($dbconnect, "SELECT * FROM pbmart_promotion_category WHERE promotion_category_id='$promotion'");
		$promotion_name_display = mysqli_fetch_assoc($promotion_name);
		$name = $promotion_name_display['promotion_category_name'];
		$class = "Promotion";
	}
	
	$order = mysqli_query($dbconnect, "SELECT * FROM pbmart_order WHERE order_status='1' AND order_date BETWEEN '$start' AND '$end'");
	
	$no = 1;
	$check = 0;
	$total_amount = 0;
	$total_price = 0;
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
		
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
		<script src="../js/datepicker/datetimepicker_css.js"></script>
		
		<style type="text/css" media="print">
			#header, .container, #footer, #logo{
				display:none;
			}
			
			body #content{
				background-image:none;
				border:none;
			}
		</style>
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
			</br>			
			</br>
			</br>
			</br>
			<div id="title">
				<?php	echo $name." (".$start." - ".$end.")";	?>
			</div>
			
			<div id="stock_list">
				<table border="1" width="750px" align="center" cellspacing="0" cellpadding="0" class="box-table-a">
					<tr>
						<th width="30px">No.</th>
						<th width="370px">Product Name</th>
						<th width="100px">Order Date</th>
						<th width="50px">Quantity</th>
						<th width="70px">Amount (RM)</th>
					</tr>
				<?php	while($order_display = mysqli_fetch_array($order)){
							if($class == "Product"){
								$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."' AND order_product_id='$product' AND order_product_class='".$class."'");
							}else{
								$order_list = mysqli_query($dbconnect, "SELECT * FROM pbmart_order_list WHERE order_number='".$order_display['order_number']."' AND order_product_class='".$class."' AND order_product_name LIKE '%".$name."%'");
							}
							
							$order_list_row = mysqli_num_rows($order_list);
							$price = 0;
							
							if($order_list_row != 0){
								while($order_list_display = mysqli_fetch_array($order_list)){
									$total_amount = $total_amount + $order_list_display['order_product_amount'];
									$price = sprintf('%0.2f', (($order_list_display['order_product_price'] + $order_list_display['order_product_handling']) * $order_list_display['order_product_amount']));		
									$total_price = sprintf('%0.2f', ($total_price + $price));						
									
									echo "<tr>";
									echo "<td>".$no++.".</td>";
									echo "<td>".$order_list_display['order_product_name']."</td>";
									echo "<td>".$order_display['order_date']."</td>";
									echo "<td>".$order_list_display['order_product_amount']."</td>";
									echo "<td>".$price."</td>";
									echo "</tr>";
									$check++;
								}
							}
						}
						
						if($check == 0){
							echo "<tr height='100px'>";
							echo "<td colspan='5' align='center' style='vertical-align:middle;font-size:16px;'><strong>This product have no order between these date.</strong></td>";
							echo "</tr>";	
						}
				?>
					<tr>
						<th colspan="3">Total :</th>
						<td><?=$total_amount?></td>
						<td><?=$total_price?></td>
					</tr>
				</table>
			</div>
		
			<?php
				include('../footer.php');
			?>
		</div>
	</body>
</html>