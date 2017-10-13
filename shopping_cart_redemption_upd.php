<?php
$id = $_GET['id'];
$redeem_id = $_GET['redeem_id'];
$redeem_category = $_GET['redeem_category'];

?>

<form action="redemption_validate.php?id=<?php echo $id; ?>&act=add&redeem_id=<?php echo $redeem_id; ?>&redeem_category=<?php echo $redeem_category; ?>&redeem_qty=1&hyperlink=shp_redemption" method="post">
<table border="0" valign="center" width='470px'>
	<tr>
		<td>
			<strong>Choose Your Redeem Methods:</strong>
		</td>
	</tr>
	
	<tr>
		<td>
			&nbsp;
		</td>
	</tr>
	
	<tr>
		<td>
			<input type="radio" name="btnRd_redeem_type" value='1' checked>PB Points</input>
		</td>
	</tr>
	
	<tr>
		<td>
			<input type="radio" name="btnRd_redeem_type" value='2'>PB Tokens</input>
		</td>
	</tr>
	
	<tr>
		<td>
			<hr/>
		</td>
	</tr>
	
	<tr>
		<td align='right'>
			<input type='submit' value="Redeem" onclick="return confirm('Are you sure convert to PB Points?')"></input>
		</td>
	</tr>
</table>
</form>