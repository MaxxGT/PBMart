<?php 
	include('header.php');
	include('sidebar.php');
	
	$usr_email = $_GET['usr_email'];
?>

<!-- End Navigation -->
  </div>
  <!-- End Header -->
<table border=0>
	<td>
		<table border=0>
			<tr>
				<td>
					<img src="css/images/conformation_grl.jpg"></img>
				</td>
			</tr>
		</table>
	</td>
	
	<td>
		<table border=0>
			<tr>
				<td>
					<font size='7'><b>thanks</b></font><BR>
					<font size='5'>for signin up!</font><BR><BR>
					<font size='3'/>Please check your mail <?php echo $usr_email; ?> for confirmation!
					<BR><BR>Thanks!
				</td>
			</tr>
		</table>
	</td>
</table>
<?php include('footer.php'); ?>