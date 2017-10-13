<?php
	include('header.php');
	get_UsrInfo();
	
	$validate_member = "PB0008/A";
	if($member_number == $validate_member)
	{
		$btnSubmit = "";
	}else
	{
		$btnSubmit = "disabled";
	}
?>
<html>
	<head>
		
	</head>
	<title>
		HAPPY MOTHERS DAY FREE GIFT
	</title>
	
	<table width='100%'>
		<tr>
			<td>
				<h1><font color='red' size='6'><i>Happy Mother's Day Free Gift</i></font></h1>
			</td>
			<td align='right'>
				<img src='cmanage/product/photo/2.jpg' width='600px'  height='140px' />
			</td>
		</tr>
		
		<tr>
			<td colspan='2'>
				<hr>
				</hr>
			</td>
		</tr>

		<table>
			<tr>
				<td>
					<center>
						<?php include('hpy_mr_dy_add_on.php'); ?>
					</center>
				</td>
			</tr>
		</table>
		
		<tr>
			<td>
				<BR />
				<BR />
				<BR />
			</td>
		</tr>
	</table>
</html>

<?php include('footer.php'); ?>