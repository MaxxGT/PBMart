<?php
// Author: VOONG TZE HOWE
// Date Writen: 09-10-2014
// Description : header
// Last Modification: 11-10-2014
include('session_config.php');


if(isset($_GET['usr_name'])!=0)
{
	$usr_name = $_GET['usr_name'];
}

if(isset($_SESSION['order_qty']))
{
	$order_qty = $_SESSION['order_qty'];
}else
{
	$order_qty = "";
}

if(isset($_SESSION['redeem_order_qty']))
{
	$redeem_order_qty = $_SESSION['redeem_order_qty'];
}else
{
	$redeem_order_qty = "";
}
$total_order_qty = $order_qty + $redeem_order_qty;

sessionX();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PB MART</title>
<link rel="shortcut icon" href="css/images/gascylindericon.png">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery.jcarousel.pack.js" type="text/javascript"></script>
<script src="js/jquery-func.js" type="text/javascript"></script>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bootstrap/js/jquery-1.9.0.min.js"></script>
	
</head>
<body>
<!-- Shell -->
<div class="shell">
  <!-- Header -->
  <div id="header">
    <h1 id="logo"><a href="index.php?hyperlink=home">PB MART</a></h1>
    <!-- Cart -->
    <div id="cart"> <a href="shopping_cart.php?hyperlink=product" class="cart-link">My Shopping Cart<font color="yellow"><?php 
	
	if(isset($total_order_qty) && $total_order_qty !='0')
	{
		echo ('('.$total_order_qty.')'); 
	}?></font></a>
      
	  <?php
		if(isset($_SESSION["usr_name"]) && !empty($_SESSION["usr_name"]))
		{			require_once("connection/pbmartconnection.php");			
					$usr_ids = $_SESSION["usr_id"];			
					$sql_first_name="Select member_first_name, member_last_name FROM pbmart_member WHERE member_id=$usr_ids";			
					$rs_first_name = @mysql_query($sql_first_name, $link);			
					$rw_first_name = @mysql_fetch_array($rs_first_name);			
					$usr_first_name = $rw_first_name['member_first_name'];
					$usr_last_name = $rw_first_name['member_last_name'];
	  ?>
			<div>Login User: <?php echo $usr_first_name; ?></div>
  <?php } ?>
		
	<?php
		if(empty($_SESSION["usr_name"])==true)
		{ ?>
			<div>Welcome to Pulau Burung!</div>
  <?php } ?>
	  
	    
	  <div class="cl">&nbsp;</div>
     <!-- <span>Articles: <strong>3</strong></span> &nbsp;&nbsp; <span>Cost: <strong>RM5000.00</strong></span> -->
	</div>
    <!-- End Cart -->
    <!-- Navigation -->
    <div id="navigation">
      <ul>
		<?php
		
		if(!isset($_GET['hyperlink']))
		{
			$hyperlink1 = 'active';
		}else
		{
			if($_GET['hyperlink']=='home')
			{
				$hyperlink1 = 'active';
			}
			
			if($_GET['hyperlink']=='promotion')
			{
				$hyperlink8 = 'active';
			}
			
			if($_GET['hyperlink']=='product')
			{
				$hyperlink2 = 'active';
			}
			
			if($_GET['hyperlink']=='account')
			{
				$hyperlink3 = 'active';
			}
			
			if($_GET['hyperlink']=='myaccount')
			{
				$hyperlink7 = 'active';
			}
			
			if($_GET['hyperlink']=='help')
			{
				$hyperlink4 = 'active';
			}
		
			if($_GET['hyperlink']=='contact')
			{
				$hyperlink5 = 'active';
			}
			
			if($_GET['hyperlink']=='redemption')
			{
				$hyperlink6 = 'active';
			}
			
			if($_GET['hyperlink']=='tupperware')
			{
				$hyperlink9 = 'active';
			}
		}
		?>
        <li><a href="index.php?hyperlink=home" class="<?php echo $hyperlink1; ?>">Home</a></li>
		<li><a href="promotions_index.php?hyperlink=promotion" class="<?php echo $hyperlink8; ?>">Promotion</a></li>
        <li><a href="products.php?hyperlink=product" class="<?php echo $hyperlink2; ?>">Products</a></li>
		<li><a href="tupperwares.php?hyperlink=tupperware" class="<?php echo $hyperlink9; ?>">Tupperware</a></li>
		<li><a href="redemption.php?hyperlink=redemption" class="<?php echo $hyperlink6; ?>">Redeem</a></li>
		
	<?php
		if(isset($_SESSION['usr_name']))
		{ ?>
			<li><a href="myaccount.php?hyperlink=myaccount" class="<?php echo $hyperlink7; ?>">My Account</a></li>
  <?php }else
		{ ?>
			<li><a href="account.php?hyperlink=account" class="<?php echo $hyperlink3; ?>">Account</a></li>
  <?php } ?>
		<li><a href="help/help.php?hyperlink=help" class="<?php echo $hyperlink4; ?>">Help</a></li>
        <li><a href="contact/contact.php?hyperlink=contact" class="<?php echo $hyperlink5; ?>">Contact</a></li>
      </ul>
    </div>
    <!-- End Navigation -->
  </div>
<!-- End Header -->