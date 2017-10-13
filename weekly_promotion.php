<?php 
	require_once('products_function.php');
?>
<table border='0' frame="box" width='100%'>
	<tr>
		<td bgcolor="#E6E600" height='50px'>
			<BR/>
			<B><font size='6' color='red'><center>PB MART Weekly Promotions</center></font></B>
			<BR/>
		</td>
	</tr>
	
	<tr>
		<td align='left'>
			<BR/>
			<?php include('countdown_timer.php'); ?>
		</td>
	</tr>
				
	<tr>
		<td>&nbsp;</td>
	</tr>
				
	<tr>
		<td colspan='2'>
			<?php include('weekly_promotion_content.php'); ?>
		</td>
	</tr>
</table>