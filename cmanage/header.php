<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="css/960.css" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/text.css" />
		<link rel="stylesheet" type="text/css" href="css/red.css" />
		<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />
		
		<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="js/ui.core.js"></script>
		<script type="text/javascript" src="js/ui.sortable.js"></script>    
		<script type="text/javascript" src="js/ui.dialog.js"></script>
		<script type="text/javascript" src="js/ui.datepicker.js"></script>
		<script type="text/javascript" src="js/effects.js"></script>
		<script type="text/javascript" src="js/flot/jquery.flot.pack.js"></script>
		<!--[if IE]>
		<script language="javascript" type="text/javascript" src="js/flot/excanvas.pack.js"></script>
		<![endif]-->
		<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="css/iefix.css" />
		<script src="js/pngfix.js"></script>
		<script>
			DD_belatedPNG.fix('#menu ul li a span span');
		</script>        
		<![endif]-->
		<script id="source" language="javascript" type="text/javascript" src="js/graphs.js"></script>
	</head>
	<body>
	<!-- WRAPPER START -->
		<div class="container_16" id="wrapper">	
			<!--LOGO-->
			<div class="grid_8" id="logo">DASHBOARD</div>
		<!-- Get The Current Page -->
		<?php	if(!isset($_GET['hyperlink'])){
					$hyperlink1 = 'current';
				}else{
					if($_GET['hyperlink']=='main'){
						$hyperlink1 = 'current';
					}
					if($_GET['hyperlink']=='products'){
						$hyperlink2 = 'current';
					}
					if($_GET['hyperlink']=='orders'){
						$hyperlink3 = 'current';
					}
					if($_GET['hyperlink']=='members'){
						$hyperlink4 = 'current';
					}
					if($_GET['hyperlink']=='redemption'){
						$hyperlink5 = 'current';
					}
					if($_GET['hyperlink']=='commercial'){
						$hyperlink6 = 'current';
					}       
					if($_GET['hyperlink']=='reports'){
						$hyperlink7 = 'current';
					}
				}
				?>
		<!-- Get The Current Page End -->
			<div class="grid_16" id="header">
				<!-- MENU START -->
				<div id="menu">
					<ul class="group" id="menu_group_main">
						<li class="item first" id="one"><a href="main.php?hyperlink=main" class="main <?php echo $hyperlink1; ?>" ><span class="outer"><span class="inner dashboard">Dashboard</span></span></a></li>
						<li class="item middle" id="two"><a href="product/view_product.php?hyperlink=products" class="main <?php echo $hyperlink2; ?>"><span class="outer"><span class="inner products">Products</span></span></a></li>   
						<li class="item middle" id="three"><a href="order/view_order.php?hyperlink=orders" class="main <?php echo $hyperlink3; ?>"><span class="outer"><span class="inner orders">Orders</span></span></a></li>
						<li class="item middle" id="four"><a href="member/view_member.php?hyperlink=members" class="main <?php echo $hyperlink4; ?>"><span class="outer"><span class="inner users">Members</span></span></a></li> 
						<li class="item middle" id="five"><a href="banner/banner.php?hyperlink=reward" class="main"><span class="outer"><span class="inner points">Rewards</span></span></a></li>      
						<li class="item middle" id="six"><a href="redemption/view_redemption.php?hyperlink=redemption" class="main <?php echo $hyperlink5; ?>"><span class="outer"><span class="inner redeem">Redemption</span></span></a></li>			
						<li class="item middle" id="seven" disabled><a href="commercial/commercial_order.php?hyperlink=commercial" class="main <?php echo $hyperlink77; ?>""><span class="outer"><span class="inner commercial">Commercial</span></span></a></li> 
						<li class="item last" id="eight"><a href="report/report.php?hyperlink=reports" class="main <?php echo $hyperlink7; ?>"><span class="outer"><span class="inner reports png">Reports</span></span></a></li>        
					</ul>
				</div>
				<!-- MENU END -->
			</div> 
	</body>