<?php
// Author: VOONG TZE HOWE
// Date Writen: 06-11-2014
// Description : password_upd
// Last Modification: 11-10-2014
?>
<!-- http://stackoverflow.com/questions/10042413/how-to-place-the-table-at-the-middle-of-the-webpage -->
<div id="tableContainer-1">
  <div id="tableContainer-2">
    <form action="myaccount_password_action.php" method="post">
		<table align="center" style="font-family: verdana; font-size: 12px;" border="0" width="350px">

			<tr>
				<td colspan="2"><Strong><font size="3">Edit Password</font></strong></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>

			<tr>
				<td>Current Password: </td>
				<td><input type="password" name="crt_psd" autofocus></input></td>
			</tr>
			
			<tr>
				<td>New Password: </td>
				<td><input type="password" name="nw_psd"></input></td>
			</tr>
			
			<tr>
				<td>Confirm Password: </td>
				<td><input type="password" name="cm_psd"></input></td>
			</tr>
			
			
			
			<tr>
				<td  colspan="2" align="right">
					<input type="Submit" name="btnSubmit" value="Change password"></input>
					<!-- <a href="myaccount_password_upd.php" rel="lightbox" alt="change password"><img src="\pbmart\icon\red_editpassword.png" width="115px" height="24px" title="Change password"></img></a>-->
				</td>
					<input type="hidden" name="act" value="update"></input>
			</tr>
		</table>
	</form>
	</div>
</div>

<style>
  html, body {
    height: 100%;
  }
  #tableContainer-1 {
    height: 100%;
    width: 100%;
    display: table;
  }
  #tableContainer-2 {
    vertical-align: middle;
    display: table-cell;
    height: 100%;
  }
  #myTable {
    margin: 0 auto;
  }
</style>