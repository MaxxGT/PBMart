<?php

require_once("connection/pbmartconnection.php");

if(isset($_POST['btnRd_product']))
{
	$btnRd_product = $_POST['btnRd_product'];
}else
{
	$btnRd_product = "";
}

if(isset($_POST['product_id']))
{
	$product_id = $_POST['product_id'];
	
}else
{
	$product_id = "";
}

$current_date = date('Y-m-d');

if($btnRd_product == '0')
{
	$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '15' AND promotion_show = '1' AND promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
}else if($btnRd_product == '1')
{
	$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '15' AND promotion_show = '0' AND promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
}else
{
	$sql_promoA = "SELECT * FROM pbmart_promotion WHERE promotion_category_id = '15' AND promotion_show = '1' AND promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
}

$rs_promoA = @mysql_query($sql_promoA);
$iCount = '1';
$promotion_id ="";

while($rw_promoA = @mysql_fetch_array($rs_promoA))
{
	if($iCount == $product_id)
	{
		$promotion_id = $rw_promoA["promotion_id"].'<BR/>';
	}
	$iCount++;
}

if($promotion_id == "")
{
	$message = "Error! Please try again later! Thank you!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	exit;
}
?>

<form id="gw_form" name="gw_form" action="product_validate.php?act=add&id=1&product_category=Promotion&product_qty=1&hyperlink=index" method="post">
	<input type="hidden" name="btnRd_product" value="<?php echo $btnRd_product; ?>"></input>
	<input type="hidden" name="product_id" value="<?php echo "PKG_".$promotion_id; ?>"></input>
	<script language="JavaScript">document.gw_form.submit();</script>
</form>