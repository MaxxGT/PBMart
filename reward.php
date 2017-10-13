<?php
	include("header.php");
?>
<!DOTYPE HTML>
<HTML>
<BODY>
  <div id="main">
    <div class="cl">&nbsp;</div>
	<table border='0'>
		<tr>
			<td valign=top>
				<!-- Sidebar -->
					<?php include('sidebar.php'); ?>
				<!-- End Sidebar -->
			</td>
			
			<td valign=top>
				<table border=0>
					<tr>
						<td valign=top>
							<!-- Content -->
								<div id="content">
								  <?php include('tupperware_content.php'); ?>
								</div>
							<!-- End Content -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td align='right'>
				<!-- Page Numbers Start -->
					<?php include('products_navigate.php'); ?>
				<!-- Page Numbers End -->
			</td>
		</tr>
	</table>
	<BR/>
	<?php include('footer.php'); ?>
  </div>
</BODY>
</HTML>
