<?php
include('header.php');
// Author: VOONG TZE HOWE
// Date Writen: 11-10-2014
// Description : display different product pages
// Last Modification:
?>
<!DOTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/back-to-top/css/style.css"> <!-- Gem style -->
	<script src="css/back-to-top/js/modernizr.js"></script> <!-- Modernizr -->
  	
	<title>PBMart Products</title>
</head>
<body>
  <!-- Main -->
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
								  <?php include('products_content.php'); ?>
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
<!-- End Main -->
  
	<!-- Side Full -->
		<?php include('sidefull.php'); ?>
	<!-- End Side Full -->
  
	<!-- Footer -->
		<?php include('footer.php'); ?>
	<!-- End Footer -->

  </div>
<!-- End Shell -->
		<a href="#0" class="cd-top">Top</a>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="css/back-to-top/js/main.js"></script> <!-- Gem jQuery -->
</body>
</html>