<?php
if(isset($_POST['product_id']))
{
	$product_id = $_POST['product_id'];
}else
{
	$message = "Error! Please try again later! Thank you!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='spc_prm_add_on.php?hyperlink=product';</script>";
	exit;
}
$product_qty = '1';
?>

<form id="tupperware_prm_form" name="tupperware_prm_form" action="product_validate.php?trigger=product" method='post'>
	<input type="hidden" name="act" value="add"></input>
	<input type="hidden" name="product_qty" value="<?php echo $product_qty;?>"></input>
	<input type="hidden" name="product_id" value="<?php echo $product_id;?>"></input>
	<input type="hidden" name="product_category" value="Product"></input>
	<input type="hidden" name="hyperlink" value="index2"></input>
	<script language="JavaScript">document.tupperware_prm_form.submit();</script>
</form>