<?php
// Author: VOONG TZE HOWE
// Date Writen: 16-11-2014
// Description : reset password
// Last Modification:

include('header.php');

if(isset($_GET['sts']) && $_GET['sts']=='esend')
{
	$message = "An password reset instruction has been sent to your email! Please check your email for the instruction set! Thanks";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
}
?>

<form action="rst_psd_validate.php" method="post">
	<table border="0" width="960px" height="850px">
		<tr>
			<td height="40px">
				<BR>
				<h2>
					<font size="4">Can't sign in? Forget your password?</font>
				</h2>
			</td>
		</tr>
		
		<tr>
			<td height="10px">
				<BR>
				Enter your email address below and we'll send you password reset instructions.
			</td>
		</tr>
		
		<tr>
			<td height="10px">
				&nbsp;
			</td>
		</tr>
		
		<tr>
			<td height="10px">
				Enter your email address<BR>
				<input type="email" name='usr_email' placeholder="Your email" size="35" autofocus></input><BR><BR>
				<input type="submit" value="Submit Email"></input>
				<input type="hidden" name="act" value="validate_email"></input>
			</td>
		</tr>
		
		<tr>
			<td height="650px">
				&nbsp;
			</td>
		</tr>
	</table>
</form>
<?php
	include('footer.php');
?>