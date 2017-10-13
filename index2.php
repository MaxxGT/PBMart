<?php
// Author: VOONG TZE HOWE
// Date Writen: 09-10-2014
// Description : index home page
// Last Modification: 11-10-2014

include('header.php');
include("connection/pbmartconnection.php");


//perform site checking for site maintenance
$sql="Select * FROM pbmart_product";
$rs = @mysql_query($sql, $link);
$count = @mysql_num_rows($rs);	

if($count=='0')	
{		
	echo "<script language='JavaScript'>window.top.location ='site_maintainance.php';</script>";		
	exit;	
}
?>
<html>
<body>
	<table border='0'>
		<tr>
			<td valign='top'>
				<?php include('sidebar.php'); ?>
			</td>
			
			<td valign='center'>
				<?php include('content_slider.php'); ?>
				<BR/>
						<?php include('refill_gas_promotion.php'); ?>
					<BR/><BR/>
					
					<?php 
						$current_date = date("Y-m-d");
						$exp_date = "2015-09-10";
						if($current_date <= $exp_date)
						{
							include('weekly_promotion.php');
						}
					?>
					<BR/>
				  <!-- End Content Slider -->
			</td>
		</tr>
	</table>
	<!-- End Content -->
<?php
	include('more_product.php');
	include('sidefull.php');
	include('footer.php');
?>
</body>
</html>
