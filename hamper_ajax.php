<?php
include("connection/pbmartconnection.php");
$q = $_GET["q"];
$hamper_name = $_GET['hamper_name'];

if($q == '0')
{
	$sql_hamper = "SELECT product_name, product_price FROM pbmart_product WHERE product_name='$hamper_name' AND product_model='Home Delivery'";

}else
{
	$sql_hamper = "SELECT product_name, product_price FROM pbmart_product WHERE product_name='$hamper_name' AND product_model='Self Pick Up At SPB'";
}
	$rs_hamper = @mysql_query($sql_hamper);
	$rw_hamper = @mysql_fetch_array($rs_hamper);
	echo 'RM'.$product_price = $rw_hamper['product_price'];
mysql_close($link);
?>