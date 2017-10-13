<?php
$street_name = $_POST['street_name'];
?>
<script>
	function autoSubmit() {
	var formObject = document.forms['checkout_page'];
		formObject.submit();
	}
</script>

<form name="checkout_page" action="textarea.php?hyperlink=product" method="post">

<table border="0" width="960px">
	<tr>
						
		<td>Address : <span style = "color:red">*</span></td>
		<td>
			<textarea id="street_name" name="street_name" rows="3" cols="40" onblur="autoSubmit()"><?php echo $street_name; ?></textarea>
		</td>
	</tr>
</table>

</form>