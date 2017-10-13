<?php
require("connection/pbmartconnection.php");
$product_id = "1";

echo prd_validations($product_id); exit;

function prd_validations($product_id)
{
	$query_stk_stock = "SELECT * FROM pbmart_product WHERE product_id = '$product_id'";
	$rs_stk_stock = @mysql_query($query_stk_stock);
	$rw_stk_stock = @mysql_fetch_array($rs_stk_stock);
	echo $prd_stk_stock = $rw_stk_stock['product_stock'];
}
?>