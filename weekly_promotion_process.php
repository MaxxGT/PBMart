<?php
require_once("connection/pbmartconnection.php");

$act = (isset($_GET['act']) ? $_GET['act'] : '');
$product_qty = (isset($_POST['product_qty']) ? $_POST['product_qty'] : '');
$promotion_item_name = (isset($_POST['promotion_item_name']) ? $_POST['promotion_item_name'] : '');
$product_id = (isset($_POST['product_id']) ? $_POST['product_id'] : '');
?>

<form id="gw_form" name="gw_form" action="product_validate.php?act=add&trigger=product" method='post'>
	<input type="hidden" name="act" value="<?php echo $act;?>"></input>
	<input type="hidden" name="product_qty" value="<?php echo $product_qty;?>"></input>
	<input type="hidden" name="product_id" value="<?php echo "PKG_".$product_id;?>"></input>
	<input type="hidden" name="product_category" value="Promotion"></input>
	<input type="hidden" name="hyperlink" value="weekly_promotion"></input>
	<script language="JavaScript">document.gw_form.submit();</script>
</form>