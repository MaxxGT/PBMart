<?php

if(isset($_POST['btn1']))
{
	$btn1 = $_POST['btn1'];
}

if(isset($_POST['btn2']))
{
	$btn2 = $_POST['btn2'];
}

if($btn1 == "HOME DELIVERY")
{
	$product_id = '139';
}else if($btn2 = "SELF PICK UP")
{
	$product_id = '140';
}
$product_qty = '1';
?>

<form id="mothers_day_form" name="mothers_day_form" action="product_validate.php?trigger=product" method='post'>
	<input type="hidden" name="act" value="add"></input>
	<input type="hidden" name="product_qty" value="<?php echo $product_qty;?>"></input>
	<input type="hidden" name="product_id" value="<?php echo $product_id;?>"></input>
	<input type="hidden" name="product_category" value="Product"></input>
	<input type="hidden" name="hyperlink" value="mothers_day"></input>
	<script language="JavaScript">document.mothers_day_form.submit();</script>
</form>