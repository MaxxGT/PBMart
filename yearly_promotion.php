<form action="product_validate.php?act=add&id=1&product_category=Promotion&product_qty=1&hyperlink=index" name="yearly_promotion_frm">
<table border='1' width='100%' style="border-collapse: collapse;">
	<h1>Yearly Promotion</h1>
	<BR/>
	<tr>
		<td width='1%' align='center'>
			<input type="radio" name="btnRd" checked></input>
		</td>
		<td>
			<strong>3 Month Pack</strong>
		</td>
	</tr>
	<tr>
		<td align='center'>
			<input type="radio" name="btnRd"></input>
		</td>
		<td>
			<strong>6 Month Pack</strong>
		</td>
	</tr>
	<tr>
		<td align='center'>
			<input type="radio" name="btnRd"></input>
		</td>
		<td>
			<strong>9 Month Pack</strong>
		</td>
	</tr>
	<tr>
		<td align='center'>
			<input type="radio" name="btnRd"></input>
		</td>
		<td>
			<strong>1 Year Pack</strong>
		</td>
	</tr>
	<tr>
		<td colspan='2' align='right'>
			<input type="submit" value="ADD TO CART"></input>
		</td>
	</tr>
	<input type="hidden" name="act" value="add"></input>
	<input type="hidden" name="product_qty" value="1"></input>
	<input type="hidden" name="product_category" value="Promotion"></input>
	<input type="hidden" name="product_id" value="<?php echo "PKG_69"; ?>"></input>
</table>
</form>