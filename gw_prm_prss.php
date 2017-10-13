<?php
include("connection/pbmartconnection.php");

if(isset($_POST['btnRd_valuepack']))
{
	$btnRd_valuepack = $_POST['btnRd_valuepack'];
}else
{
	$btnRd_valuepack = "0";
}

if(isset($_POST['btnRd_gw_product']))
{
	$btnRd_gw_product = $_POST['btnRd_gw_product'];
	
	if($btnRd_gw_product == '0')
	{
		if($btnRd_valuepack == '0')
		{
			$product_id  = '54';
		}else
		{
			$product_id = '56';
		}
	}else if($btnRd_gw_product == '1')
	{
		if($btnRd_valuepack == '0')
		{
			$product_id  = '55';
		}else
		{
			$product_id = '57';
		}
	}else
	{
		$btnRd_VP1 = '';
		$btnRd_VP2 = '';
	}
}else
{
	$btnRd_gw_product = "";
}


$current_date = date('Y-m-d');

$sql_promotion = @mysql_query("SELECT * FROM pbmart_promotion WHERE promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date' AND promotion_id='$product_id'");

$iNums = @mysql_num_rows($sql_promotion);

if($iNums == '0')
{
	$message = "Error! Please try again later! Thank you!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	exit;
}
?>

<form id="gw_form" name="gw_form" action="product_validate.php?act=add&id=1&product_category=Promotion&product_qty=1&hyperlink=index" method="post">
	<input type="hidden" name="btnRd_product" value="<?php echo $btnRd_product; ?>"></input>
	<input type="hidden" name="product_id" value="<?php echo "PKG_".$product_id; ?>"></input>
	<script language="JavaScript">document.gw_form.submit();</script>
</form>

