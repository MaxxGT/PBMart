<h1><strong>Account</strong></h1><br /><br />
<?php include('page_navigate.php'); ?>

		<div id="membersignin">
		   <h2><strong>Member Login</strong></h2><br/>
				<table border="0" name="member_login">
					<form name="member_logins" action="account_login_authentication.php?hyperlink=account" method="post">
						<tr>
							<td><strong>Email : </strong></td>
							<td><input type="text" name="email" size="30"></td> 
						</tr>

						<tr>
							<td><strong>Password :</strong> </td>
							<td><input type="password" name="password" size="30"></td>
						</tr>
						
						<tr align="right">
							
							<td colspan="2" align="left">
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
										<input type="submit" name="sign" Value="Log In" <?php echo $disabled; ?> title="Click to log in">
									<?php }else{ ?>
										<input type="submit" name="sign" value="Log Out" onclick="return confirm('Are you sure you want to log out? <?php echo $_SESSION['usr_name']; ?>')" title="Click to log out"></input>
									<?php } ?>
									
									
									
									<?php
								if(isset($_GET['authenticate_value']))
								{
									$authenticate_value = $_GET['authenticate_value'];
									$current_url = $_GET['current_url'];

									if($current_url == 'account')
									{
										if($authenticate_value == 0)
										{?>
											<font color='red' size="2">Error! Invalid email or password!</font>
										<?php }else{ ?>
												&nbsp;
									<?php	}
									}else
									{?>
										&nbsp;
								<?php	}
								}else
								{?>
									&nbsp;
							<?php } ?>
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
								&nbsp;
							</td> <!--blank row -->
						</tr>
						
						
						<input type="hidden" name="current_url" value="account"></input>			
					</form>
				</table>
		</div>