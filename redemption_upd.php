<?php
// Author: VOONG TZE HOWE
// Date Writen: ...
// Description : redemption_upd
// Last Modification: ...

// Last Modification: 16-12-2014
// Description: add quantity field

// Last Modification: 19-12-2014
// Description: remove total quantity of redeem products

require_once("connection/pbmartconnection.php");
if(isset($_REQUEST['redeem_id']))
{
	$redeem_id = $_REQUEST['redeem_id'];
}

$sql_product = "Select * FROM pbmart_redeem WHERE redeem_stock!='0' AND redeem_id=$redeem_id";	
						$rs = mysql_query($sql_product, $link);
						$total_products = mysql_num_rows($rs);
						$rw = mysql_fetch_array($rs);
					
						$redeem_image = $rw['redeem_image'];
						$redeem_description = $rw['redeem_description'];

if(isset($_REQUEST['redeem_name']))
{
	$redeem_name = $_REQUEST['redeem_name'];
}

if(isset($_REQUEST['product_point']))
{
	$product_point = $_REQUEST['product_point'];
}

if(isset($_REQUEST['redeem_stock']))
{
	$redeem_stock = $_REQUEST['redeem_stock'];
}

if(isset($_REQUEST['qty']))
{
	$quantity = $_REQUEST['qty'];
}else
{
	$quantity = "1";
}
?>

<script language=JavaScript>
	function autoSubmit() {
	var formObject = document.forms['redemption_upd'];
		formObject.submit();
	}
</script>

<script type="application/javascript">
function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}
</script>

<form action="redemption_action.php" method="post">
	<table border="0" align="center">
	<BR>
		<tr>
			<td colspan="5"><font size="4"><strong><u>Redemption Products</u></strong></font><BR><BR></td>
		</tr>
		
		<tr>
			<td colspan="5" align="center">
				<img src="cmanage/redemption/<?php echo $redeem_image; ?>" width="110px" height="100px" alt=""></img>
			</td>
		</tr>
		
		<tr>
			<td colspan="3"><strong>Product Name:</strong></td>
			<td colspan="2"><?php echo $redeem_name; ?></td>
		</tr>
		
		<tr>
			<td colspan="3"><strong>Description:</strong></td>
			<td colspan="2"><?php echo $redeem_description; ?></td>
		</tr>
		
		<tr>	
			<td colspan="3"><strong>Point:</strong></td>
			<td colspan="2"><?php echo $product_point; ?></td>
		</tr>
		
		<tr>
			<td colspan="3"><strong>Quantity:</strong></td>
			<td colspan="2">
				<input type="number" id="qty" name="qty" value="<?php echo $quantity; ?>" onKeyPress="return isNumberKey(event)" autofocus></input>
			</td>
		</tr>
		
		<tr>
			<td colspan="5" align="right"><input type="submit" name="btnSubmit" value="Redeem Product" onclick="return confirm('Are you sure to redeem the products? <?php echo $redeem_name; ?>')"></input></td>
		</tr>
		<input type="hidden" name="act" value="redeem"></input>
		<input type="hidden" name="redeem_name" value="<?php echo $redeem_name; ?>"></input>
		<input type="hidden" name="redemption_image" value="<?php echo $redeem_image; ?>"></input>
		<input type="hidden" name="product_point" value="<?php echo $product_point; ?>"></input>
		<input type="hidden" name="redeem_id" value="<?php echo $redeem_id; ?>"></input>
		<input type="hidden" name="redeem_id" value="<?php echo $redeem_id; ?>"></input>
		<input type="hidden" name="redeem_stock" value="<?php echo $redeem_stock; ?>"></input>
	</table>
</form>