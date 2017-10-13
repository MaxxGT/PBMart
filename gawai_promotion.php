<?php

if(isset($_POST['btnRd_valuepack']))
{
	$btnRd_valuepack = $_POST['btnRd_valuepack'];
}else
{
	$btnRd_valuepack = "0";
}

$btnRd_VP1 = '';
$btnRd_VP2 = '';

if(isset($_POST['btnRd_gw_product']))
{
	$btnRd_gw_product = $_POST['btnRd_gw_product'];
	
	if($btnRd_gw_product == '0')
	{
		$btnRd_VP1 = '54';
		$btnRd_VP2 = '56';
	}else if($btnRd_gw_product == '1')
	{
		$btnRd_VP1 = '55';
		$btnRd_VP2 = '57';
	}else
	{
		$btnRd_VP1 = '';
		$btnRd_VP2 = '';
	}
}else
{
	$btnRd_gw_product = "";
}
?>

<html>
<script>
function autoSubmit_gw() {
	var formObject_prmA = document.forms['gw_form'];
		formObject_prmA.submit();
	}
</script>
<!DOCTTYPE HTML>
<TITLE>GAWAI PROMOTION</TITLE>
	<BODY>
		<h1>Gawai Promotion</h1>
		<BR/>
		<form name="gw_form" action="gw_prm_prss.php" method="post">
		<table border='1' width="700px" style="border-collapse: collapse;">
			<tr>
				<td><center><B>Step 1</B></center></td>
				<td><center><B>Step 2</B></center></td>
			</tr>
			<tr>
				<td>
					<table border='0'>
						<tr>
							<td>
								<img src="cmanage/product/photo/special.jpg"></img>
							</td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td valign='top'>
											<input type="radio" name="btnRd_gw_product" value="0" <?php if($btnRd_gw_product == '0'){echo "checked"; } ?>>
										</td>
										<td>
											MYGAZ LPG 14KG (REFILL)
											RM26.60 + <BR/>OTHERS RM3.40
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td valign='top'>
											<input type="radio" name="btnRd_gw_product" value="1" <?php if($btnRd_gw_product == '1'){echo "checked"; } ?>>
											</input>
										</td>
										<td>
											SELF PICK UP 
											REFILL GAS 14KG
											AT SPB RM26.60
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td width="600px" valign='top'>
					<table border='0' width='100%' height='100%'>
						<tr>
							<td colspan='3'>
								<input type='radio' name='btnRd_valuepack' value="0" <?php if($btnRd_valuepack == $btnRd_VP1){ echo "checked"; } ?>>
								<B><font size='4' color='black'>Value Pack 1</font></B>
								</input>
							</td>
						</tr>
						
						<tr>	
							<td colspan='3' align='center'>
								<table border='0' width='100%'>
									<tr>
										<td colspan=3>
											
											<table>
												<tr>
													<td></td>
												</tr>
												<tr>
													<center>
														<img src="cmanage/promotion/photo/Value Pack 1.jpg" width='400px' height='150px'></img>
													</center>
												</tr>
											</table>
										</td>
									</tr>
									
									<tr>
										<td width='340px'><B><font color='black'>- Alston Gas Regulator(Auto Cut) with Safety Valve </font></B></td>
										<td colspan='2' align='right'><B><font color='black'>RM23.90</font></B></td>
									</tr>
									<tr>
										<td><B><font color='black'>- Hose(BS3212) 5 feet(Kaki) </font></td>
										<td colspan='2' align='right'><B><font color='black'>RM15.00 </font></td>
									</tr>
									<tr>
										<td><B><font color='black'>- 2x Clip +</font></td>
										<td colspan='2' align='right'><B><font color='black'>RM4.00 </font></td>
									</tr>
									
									<tr>
										<td><B><font color='black'>- Sasiki Double Gas Burner + </font></td>
										<td colspan='2' align='right'><B><font color='black'>RM55.90 </font></td>
									</tr>
									<tr>
										<td colspan='3'>
											
										</td>
									</tr>
									
									<tr>
										<td rowspan='2'><B><font size='7' color='red'><i><center>Save 24%</center></font></B></td>
										<td colspan='2' align='right'><B><font size='3' color='black'>TOTAL <strike>RM98.80</strike> </font></td>
									</tr>
									
									<tr>
										<td align='right'>
											<B><font size='5' color='red'><i>RM75.00 ONLY</i></font></B>
										</td>
									</tr>
									
									<tr>
										<td colspan='2' align='right'>
											<B><font size='3' color='red'><i>EXCLUDE MYGAZ LPG 14KG(REFILL)</i></font></B>
										</td>
									</tr>
									
									<tr>
										<td colspan='3'>
											<hr/>
										</td>
									</tr>
									
								</table>
							</td>
						</tr>

						<tr>
							<td colspan='3'>
								<input type='radio' name='btnRd_valuepack' value="1" <?php if($btnRd_valuepack == $btnRd_VP2){ echo "checked"; } ?>>
									<B><font size='4' color='black'>Value Pack 2</font></B>
								</input>
							</td>
						</tr>

						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						
						
						<tr>	
							<td colspan='3'>
								<table border='0' width='100%'>
									<tr>
										<td colspan=3>
										
											<table>
												<tr>
													<center><img src="cmanage/promotion/photo/Value Pack 2.jpg" width='400px' height='150px'></img></center>
												</tr>
											</table>
										</td>
									</tr>
									
									<tr>
										<td width='340px'><B><font color='black'>- Chelstar Gas Regulator </font></td>
										<td colspan='2' align='right'><B><font color='black'>RM13.90</font></td>
									</tr>
									<tr>
										<td><B><font color='black'>- Hose(Normal) 5 feet(Kaki)</font></td>
										<td colspan='2' align='right'><B><font color='black'>RM10.00 </font></td>
									</tr>
									<tr>
										<td><B><font color='black'>- 2x Clip +</font></td>
										<td colspan='2' align='right'><B><font color='black'>RM4.00 </font></td>
									</tr>
									
									<tr>
										<td><B><font color='black'>- Chelstar Double Gas Burner + </font></td>
										<td colspan='2' align='right'><B><font color='black'>RM45.90 </font></td>
									</tr>
									
									<tr>
										<td rowspan='2'><B><font size='7' color='red'><i><center>Save 26%</center></font></B></td>
										<td align='right'><B><font size='3' color='black'>TOTAL <strike>RM73.80</strike> </font></td>
									</tr>
									
									
									<tr>
										<td align='right' align='right'>
											<B><font size='5' color='red'><i>RM54.50 ONLY</i></font></B>
										</td>
									</tr>
									
									<tr>
										<td colspan='2' align='right'>
											<B><font size='3' color='red'><i>EXCLUDE MYGAZ LPG 14KG(REFILL)</i></font></B>
										</td>
									</tr>
									
								</table>
								  
								
							</td>
						</tr>
						
						<tr>
							<td>
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan='2' align='right'>
					<input type="submit" value="ADD TO CART"></input>
				</td>
			</tr>
		</table>
		</form>
	</BODY>
</html>