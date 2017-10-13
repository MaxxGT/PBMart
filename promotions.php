<?php
include('header.php');
require_once("connection/pbmartconnection.php");
require_once('products_function.php');

// Author: VOONG TZE HOWE
// Date Writen: 02 Feb 2014
// Description : Promotion page
// Last Modification:

if(isset($_SESSION['usr_name']))
{
	get_UsrInfo();
}
$count = 0;
$count2 = 0;
$count3 = 0;
$c_pages = 1;

$product_row = 2;
$product_col = 3;
if(isset($_GET['pg']))
{
	$pg = $_GET['pg'];
}else
{
	$pg = 1;
}

$others_fee = '3.40';
$count = '0';

$promotion_ids = (isset($_GET['id']) ? $_GET['id'] : '');

//$query_promotion = mysql_query($sql_filter);
//if(@mysql_num_rows($query_promotion) == '0')
//{
//	echo "<script language='JavaScript'>window.top.location ='more_promotions.php?hyperlink=promotion';</script>";
//	exit;
//}

?>
<!DOCTTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/back-to-top/css/style.css"> <!-- Gem style -->
		<script src="css/back-to-top/js/modernizr.js"></script> <!-- Modernizr -->
		
		<title>PBMart Promotion Pages</title>
	</head>
<BODY>
<div id="main">
	<table border='0' width="960px">
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
								  <?php include('promotions_content.php'); ?>
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
					<?php include('promotions_navigate.php'); ?>
				<!-- Page Numbers End -->
			</td>
			
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>
	<a href="#0" class="cd-top">Top</a>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="css/back-to-top/js/main.js"></script> <!-- Gem jQuery -->
</BODY>
</html>
<?php include('footer.php'); ?>