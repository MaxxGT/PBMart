<?php
require_once("connection/pbmartconnection.php");
echo "<table border='1'>";
echo "<tr><td><B>Item Name</B></td><td><B>Item Price RM</B></td>";
$sql_promoA = "SELECT promotion_category_id, promotion_item_name, promotion_item_sale, promotion_show FROM pbmart_promotion WHERE promotion_category_id='1' AND promotion_show='1'";
$rs = @mysql_query($sql_promoA);
while($rw = @mysql_fetch_array($rs))
{ 
	echo "<tr><td>".$rw['promotion_item_name']."</td><td align='right'>".$rw['promotion_item_sale']."</tr>";
	
}
echo "</table>";
?>