<?php
require_once("connection/pbmartconnection.php");
$sql_get_flat_order = "SELECT * FROM pbmart_order WHERE flat_handling !='0'";
$rs_get_flat_order = mysql_query($sql_get_flat_order);
while($rw_get_flat_order = mysql_fetch_array($rs_get_flat_order))
{
	echo $rw_get_flat_order['order_number'].'<BR/>';
}