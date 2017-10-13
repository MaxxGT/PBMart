<?php
require_once("connection/pbmartconnection.php");
function product_verification($prd_id)
{
   	$sql = "Select product_id, product_stock, product_limit, product_lifetime_limit FROM pbmart_product WHERE product_id ='$prd_id'";
		
	 
	$rs = @mysqli_query($dbconnect, $sql);
	$rw = @mysqli_fetch_array($rs);
    echo	$product_stock = $rw['product_stock'];
	exit;	$product_limit = $rw['product_limit'];
		$product_lifetime_limit = $rw['product_lifetime_limit'];
			
}
?>