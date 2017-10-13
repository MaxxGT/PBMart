<?php
// Author: VOONG TZE HOWE
// Date Writen: 09-10-2014
// Description : small table form for use login
// Last Modification: 24-11-2014

function commercial_user_activate($member_id)
{
	$sql_commercial_active = "SELECT pbmart_member.member_id, pbmart_commercial.commercial_member_id
							  FROM pbmart_member, pbmart_commercial WHERE member_id='$member_id' AND  pbmart_commercial.commercial_member_id = '$member_id'
							  AND pbmart_member.member_commercial_status= '1' AND pbmart_commercial.commercial_status = '1'";				  
	$rs_commercial = @mysql_query($sql_commercial_active);
	$iCount = @mysql_num_rows($rs_commercial);
	return $iCount;
}

if(isset($_SESSION['usr_name']))
{
	get_usrInfo();
}
?>

<script language=JavaScript>
function autoSubmit() {
	var formObject = document.forms['login_form'];
		formObject.submit();
	}
function confirmSubmit(usrname) {
  if (confirm("Are you sure you want to log out?")) {
		autoSubmit();
  }
}
</script>
<link rel="stylesheet" type="text/css" href="css/button.css">

<h2>Member Login<span></span></h2>
<form name="login_form" action="sidebar_login_authentication.php?hyperlink=<?php echo $_GET['hyperlink']; ?>" method="post" autocomplete="on">
			<div class="box-content">
			  <ul>
			  <?php
				if(isset($_SESSION['usr_name']))
				{ ?>
					<BR>
					<font color="#B00000"><strong>
						<li>User Online &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <font color="black"><?php echo $member_first_name; ?></font></li>
						
						<?php if(commercial_user_activate($member_id) !='1')
						{ ?>
							<li>Membership No : <font color="black"><?php echo $member_number; ?></font></li>
						<?php }else
						{ ?>
							<li>Commercial No : <font color="black"><?php echo $commercial_number; ?></font></li>
				  <?php } ?>
						
						
						<li>PB Points &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <font color="black"><?php echo $member_point; ?></font></li>
						<li>PB Tokens &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <font color="black"><?php echo $member_token; ?></font></strong></li>
					</font>
					
					
			<?php }else{ ?>
				<BR>
				<li><strong><font color="#B00000">Email</font></strong></li>
				<li><input type="email" name="email" size="28"></input></li>
				<li><strong><font color="#B00000">Password</strong></font></li>
				<li><input type="password" name="password" size="28" readonly onfocus="$(this).removeAttr('readonly');"></input>
				<a href="rst_psd.php?hyperlink=home">Forgot password?</a>
				</li>				
		<?php }?>

				<?php
				if(isset($_SESSION['usr_name']))
				{
					$disabled = 'Disabled';
				}else
				{
					$disabled = "";
				}
				
				if(!isset($_SESSION['usr_name']))
				{ ?>
					<BR/>
					<input type="submit" name="btnsign" class="btnLogin" <?php echo $disabled; ?>  value="Log In" onclick="autoSubmit();" title="Click to sign in"></input>
					<input type="hidden" name="sign" value='Log In'></input>
					<input type='button' class="sg_button" value='Sign Up' onclick="window.location.href='account.php?hyperlink=account'"></input>
					<!-- <a href="account.php?hyperlink=account" style="text-decoration: none">Sign Up</a> -->
					<BR/>
					
						<table border='0'>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</table>
					
						
				<?php }else{ ?>
					
					<input type="submit" name="sign" class="search-submit" value="Log Out" onclick="return confirm('Are you sure you want to log out?')" title="Click to log out"></input>
					
				<?php } ?>
				
				<table>
					<tr>
						<td></td>
					</tr>
				</table>
				
				<?php
					if(isset($_GET['authenticate_value']))
					{
						$authenticate_value = $_GET['authenticate_value'];
						$current_url = $_GET['current_url'];
						
						if($current_url == 'index')
						{
							if($authenticate_value == 0)
							{?>
								<li><font color='red'>Error! Invalid email or password!</font></li>
							<?php }
						}
					}else
					{?>
						
			  <?php } ?>
		  </ul>
		</div>
	<input type="hidden" name="current_url" value="index"></input>
</form>