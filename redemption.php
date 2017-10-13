<?php
include('header.php');
$message = "NOTE: ALL PBMART REDEMPTION POINTS WILL BE UPDATED ON 01 JANUARY 2017. THANK YOU FOR YOUR SUPPORT.";
echo "<script type='text/javascript'>alert('$message');</script>";
// Author: VOONG TZE HOWE
// Date Writen: 11-10-2014
// Description : display different product pages
// Last Modification:11/11/2014
?>
  <!-- Main -->
  <div id="main">
   
    
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
								  <?php include('redemption_content.php'); ?>
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
					<?php include('redemption_products_navigate.php'); ?>
				<!-- Page Numbers End -->
			</td>
		</tr>
	</table>
<!-- End Main -->
  
	<!-- Side Full -->
		<?php include('sidefull.php'); ?>
	<!-- End Side Full -->
  
	<!-- Footer -->
		<?php include('footer.php'); ?>
	<!-- End Footer -->

  </div>
<!-- End Shell -->
</body>
</html>