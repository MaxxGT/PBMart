<?php

include("connection/pbmartconnection.php");

if(isset($_POST['product_id']))
{
	$product_id = $_POST['product_id'];
}else
{
	$product_id = "";
}

if(isset($_POST['product_qty']))
{
	$product_qty = $_POST['product_qty'];
}else
{
	$product_qty = "";
}

if(isset($_POST['product_name']))
{
	$product_name = $_POST['product_name'];
}else
{
	$product_name = "";
}

if(isset($_POST['product_category_id']))
{
	$product_category_id = $_POST['product_category_id'];
}else
{
	$product_category_id = "";
}

if(isset($_POST['product_category']))
{
	$product_category = $_POST['product_category'];
}else
{
	$product_category = "";
}

if(isset($_POST['hyperlink']))
{
	$hyperlink = $_POST['hyperlink'];
}else
{
	$hyperlink = "";
}

if(isset($_POST['btnRd']))
{
	$btnRd = $_POST['btnRd'];
}else
{
	$btnRd = "";
}

$tupperware_hamper_id = '0';

if($btnRd == '0')
{
	$sql_hamper = "SELECT product_id, product_name, product_show FROM pbmart_product WHERE product_name='$product_name' AND product_model='Home Delivery'";
	$rs_hamper = @mysql_query($sql_hamper);
	$rw_hamper = @mysql_fetch_array($rs_hamper);
	$tupperware_hamper_id = $rw_hamper['product_id'];
	
}else
{
	$tupperware_hamper_id = $product_id;
}
?>


<form id="tupperware_hamper_form" name="tupperware_hamper_form" action="product_validate.php?act=add&trigger=product" method="post">
	<input type="hidden" name="product_id" value="<?php echo $tupperware_hamper_id; ?>"></input>
	<input type="hidden" name="product_qty" value="<?php echo $product_qty; ?>"></input>
	<input type="hidden" name="product_category_id" value="<?php echo $product_category_id; ?>"></input>
	<input type="hidden" name="product_category" value="<?php echo $product_category; ?>"></input>
	<input type="hidden" name="hyperlink" value="<?php echo $hyperlink; ?>"></input>
	
	<script language="JavaScript">document.tupperware_hamper_form.submit();</script>
</form>


