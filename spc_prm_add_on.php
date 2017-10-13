<?php
include('header.php');
?>
<!DOTYPE HTML>
<link rel="stylesheet" type="text/css" href="css/shopping_cart/shopping_cart.css" />
<HTML>
	<TITLE>
	</TITLE>
	<HEAD>
	</HEAD>
	<BODY>
		<table border='0'>
			<tr>
				<td valign='top' width='100px'>
					<?php include('sidebar.php'); ?>
				</td>
				<td valign='top'>
					<br/>
					<h1>Special Promotions Add On</h1>
					<BR/>
					<table border='0'>
						<tr>
							<td>
								&nbsp;
							</td>
						</tr>
						<tr>
							<td>
								<?php include('spc_prm_add_on_product.php'); ?>
								<BR/><BR/>
							</td>
						</tr>
						
						<tr>
							<td>
								<?php include('spc_prm_add_on_tupperware.php'); ?>
								<BR/><BR/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table border='0'>
						<tr>
							<td>
								<hr/>
								<BR/>
								<a href="index.php?hyperlink=index" style="text-decoration:none;">
									<input type="button" class="search-submit2" name="btnCheckout" value="Continue Shopping" title="Click to continue shopping"></input>
								</a>
								<a href="checkout_page.php?hyperlink=product" style="text-decoration:none;">
									<input type="button" class="search-submit5" name="btnCheckout" value="Proceed to Checkout" onclick="return confirm('Proceed to checkout?')" title="Click to proceed checkout page"></input>
								</a>
							</td>	
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</BODY>
</HTML>

<?php include('footer.php'); ?>