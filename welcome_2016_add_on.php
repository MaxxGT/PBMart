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
		<table border='0' width='999px'>
			<tr>
				<td valign='top' width='100px'>
					<?php include('sidebar.php'); ?>
				</td>
				<td valign='top'>
					<br/>
					<h1>Welcome 2016 Add On</h1>
					<BR/>
					<table border='0' width='860px'>
						<tr>
							<td>
								&nbsp;
							</td>
						</tr>
						
						<tr>
							<td>
								<?php include('wlc_prm_add_on.php'); ?>
								<BR/><BR/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<table border='0' width='100%'>
						<tr>
							<td>
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