<?php

function product_verification($prd_id)
{
	require_once("../connection/pbmartconnection.php");
   	$sql = "Select product_id, product_stock, product_limit, product_lifetime_limit FROM pbmart_product WHERE product_id ='$prd_id'";
	$rs = mysqli_query($dbconnect, $sql);
	$rw = mysqli_fetch_array($rs);
	echo '-------------<BR/>';
    echo	$product_stock = $rw['product_stock'];
	exit;	$product_limit = $rw['product_limit'];
	$product_lifetime_limit = $rw['product_lifetime_limit'];	
}

product_verification(1);
?>