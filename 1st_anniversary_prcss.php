<?php
if(isset($_POST['product_id']))
{
	$product_id = $_POST['product_id'];
}else
{
	$message = "Error! Please try again later! Thank you!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='1st_anniversary_add_on.php?hyperlink=product';</script>";
	exit;
}
$product_qty = '1';
?>

<form id="form" name="form" action="product_validate.php?act=add&trigger=product" method='post'>
	<input type="hidden" name="act" value="add"></input>
	<input type="hidden" name="product_qty" value="<?php echo $product_qty;?>"></input>
	<input type="hidden" name="product_id" value="<?php echo $product_id;?>"></input>
	<input type="hidden" name="product_category" value="Product"></input>
	<input type="hidden" name="hyperlink" value="Product"></input>
	<script language="JavaScript">document.form.submit();</script>
</form>