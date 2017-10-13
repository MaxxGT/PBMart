<?php
	//include('header.php');
	//require_once("connection/pbmartconnection.php");
	if(isset($_POST['product_id']))
	{
		$product_id = $_POST['product_id'];
	}else
	{
		$product_id = "";
	}
	
	if(isset($_POST['btnRd_product']))
	{
		$btnRd_product = $_POST['btnRd_product'];
	}else
	{
		$btnRd_product = "";
	}
	
	if(isset($_POST['btnRd_prev_product']))
	{
		$btnRd_prev_product = $_POST['btnRd_prev_product'];
	}else
	{
		$btnRd_prev_product = "";
	}
	
	if($product_id !="" && $btnRd_product =="")
	{
		$product_id = "";
	}
	
	if($btnRd_prev_product != $btnRd_product)
	{
		$product_id = "";
	}
	
	//echo "step 1:".$btnRd_product.'<BR/>';
	//echo "Prev_id:".$btnRd_prev_product."<BR/>";
	//echo "step 2:".$product_id.'<BR/>';
?>
<html>
<!DOCTTYPE HTML>
<script>
function autoSubmit_A() {
	var formObject_prmA = document.forms['promotionA_form'];
		formObject_prmA.submit();
	}
</script>
<html>
<TITLE>PBMart Home Page</TITLE>
<BODY>
 <div id="main">
 <form name="promotionA_form" action="index.php" method="post">
	<h1>Promotion A</h1>
	<table border='0' width="700px">
		<tr>
			<td valign='top'>
				<table border='1' style="border-color:black" width="60%" height="100%" valign='center'>
					
					<tr>
						<td align='center' colspan='2'><b>PROMOTION A (DOMESTIC)</b></td>
					</tr>
					
					<tr>
						<td align='center' width='40px'><b>Step 1</b></td>
						<td align='center'><b>Step 2</b></td>
					</tr>
					<tr>
						<td width='100px'>
							<img src="cmanage/product/photo/special.jpg"></img>
							<BR/>
								
								<center>
								<input type="radio" name="btnRd_product" value="0" <?php if($btnRd_product == '0'){echo "checked"; } ?> onclick="autoSubmit_A()">
								MYGAZ LPG 14KG (REFILL)<BR/>
								RM26.60 + <BR/>OTHERS RM3.40
								</center>
								</input>
								<BR/>
								&nbsp;&nbsp;
								<input type="radio" name="btnRd_product" value="1" <?php if($btnRd_product == '1'){echo "checked"; } ?> onclick="autoSubmit_A()">
									SELF PICK UP 
									&nbsp;&nbsp;&nbsp;&nbsp;REFILL GAS 14KG AT
									&nbsp;&nbsp;&nbsp;&nbsp;SPB RM26.60
								</input>
								<input type="hidden" name="btnRd_prev_product" value="<?php echo $btnRd_product; ?>"></input>
							<BR/>
							<center><font size='3' color='black'><strong></strong></font></center>
						</td>
						<BR>
						
						<td valign='top'>
							<table border='0' width='550px' valign='center'>
								<tr>
									<td width='137px'>
										<center>
										<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "1";}else{ echo "32";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">		
										<img src="cmanage/promotion/photo/553859accee1e.jpg" width="75px" height="75px"></img></center>
										</a>
									</td>
									<td width='137px'>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "2";}else{ echo "33";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385b4cac9c7.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td width='137px'>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "3";}else{ echo "34";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385c317339a.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "4";}else{ echo "35";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385cce9144a.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									
									
								</tr>
								<tr>
									<td>
										<center>
											<input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_1";}else{ echo "PKG_32";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_1" || $product_id == "PKG_32"){ echo "checked"; } ?>>AXION LIME 750G</input>
										</center>
									</td>
									<td>
										<center>
											<input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_2";}else{ echo "PKG_33";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_2" || $product_id == "PKG_33"){ echo "checked"; } ?>>BIOZIP COLOUR 2.5KG</input>
										</center>
									</td>
									<td>
										<center>
											<input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_3";}else{ echo "PKG_34";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_3" || $product_id == "PKG_34"){ echo "checked"; } ?> >CAPTAIN OATS800G+200G FREE</input>
										</center>
									</td>
									<td>
										<center>
											<input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_4";}else{ echo "PKG_35";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_4" || $product_id == "PKG_35"){ echo "checked"; } ?>>COLGATE TOTAL 160G</input>
										</center>
									</td>
								</tr>
							
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "6";}else{ echo "36";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385cebd0c1f.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
										<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "7";}else{ echo "37";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
										<img src="cmanage/promotion/photo/55385d1305617.jpg" width="75px" height="75px"></img>
										</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "8";}else{ echo "38";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d22bac38.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "9";}else{ echo "39";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d7c46937.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
								</tr>
								<tr>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_6";}else{ echo "PKG_36";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_6" || $product_id == "PKG_36"){ echo "checked"; } ?>>Daia Powder 900G</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_7";}else{ echo "PKG_37";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_7" || $product_id == "PKG_37"){ echo "checked"; } ?>>DAIA FABRIC SOFTENER 1.8L</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_8";}else{ echo "PKG_38";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_8" || $product_id == "PKG_38"){ echo "checked"; } ?>>Dynamo 4.4KG</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_9";}else{ echo "PKG_39";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_9" || $product_id == "PKG_39"){ echo "checked"; } ?>>LIPTON YELLOW LABEL TEA 25BAGS</input></center>
									</td>
									
									
								</tr>
								<!-- Line 3 -->
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "10";}else{ echo "40";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d6bcb1f1.jpg" width="75px" height="75px"></img>
											</a>
											</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "11";}else{ echo "41";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d5b2f5ca.jpg" width="75px" height="75px"></img>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "12";}else{ echo "42";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d4dc4094.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "13";}else{ echo "43";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d3cad59c.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
								</tr>
								<tr>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_10";}else{ echo "PKG_40";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_10" || $product_id == "PKG_40"){ echo "checked"; } ?>>Maggi Curry</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_11";}else{ echo "PKG_41";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_11" || $product_id == "PKG_41"){ echo "checked"; } ?>>MI SEDAAP</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_12";}else{ echo "PKG_42";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_12" || $product_id == "PKG_42"){ echo "checked"; } ?>>MUNCHY CRACKER 300G</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_13";}else{ echo "PKG_43";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_13" || $product_id == "PKG_43"){ echo "checked"; } ?>>SHIELDTOX TWIN PACK</input></center>
									</td>
								</tr>
								
								<!-- Line 4 -->
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "20";}else{ echo "45";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d344f54b.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "22";}else{ echo "47";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d09c6bde.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "23";}else{ echo "48";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55384cbc69f67.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "24";}else{ echo "49";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385d0f0d2b0.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
								</tr>
								
								<tr>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_20";}else{ echo "PKG_45";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_20" || $product_id == "PKG_45"){ echo "checked"; } ?>>NESTLE MILO 480G</input></center>
									</td>
									
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_22";}else{ echo "PKG_47";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_22" || $product_id == "PKG_47"){ echo "checked"; } ?>>BONA MOP</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_23";}else{ echo "PKG_48";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_23" || $product_id == "PKG_48"){ echo "checked"; } ?>>ASTON LOW PRESSURE GAS REGULATOR WITH SAFETY VALVE</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_24";}else{ echo "PKG_49";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_24" || $product_id == "PKG_49"){ echo "checked"; } ?>>CHELSTAR LOW PRESSURE GAS REGULATOR CR-319E</input></center>
									</td>
									
								</tr>
								
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "25";}else{ echo "50";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385cf34c6a8.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "26";}else{ echo "51";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/55385cfbe6762.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "30";}else{ echo "52";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/5534a64b5520d.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=<?php if($btnRd_product !='1'){echo "31";}else{ echo "53";} ?>&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/5534a66e98bc4.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
								</tr>
								
								<tr>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_25";}else{ echo "PKG_50";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_25" || $product_id == "PKG_50"){ echo "checked"; } ?>>DOUBLE BURNER GAS COOKER</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_26";}else{ echo "PKG_51";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_26" || $product_id == "PKG_51"){ echo "checked"; } ?>>DOUBLE BURNER GAS COOKER(SASIKI)</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_30";}else{ echo "PKG_52";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_30" || $product_id == "PKG_52"){ echo "checked"; } ?>>ABC POWDER FIRE EXTINGUISHER 9KG</input></center>
									</td>
									<td>
										<center><input type="radio" name="product_id" value="<?php if($btnRd_product !='1'){echo "PKG_31";}else{ echo "PKG_53";} ?>" onclick="autoSubmit_A()" <?php if($product_id == "PKG_31" || $product_id == "PKG_53"){ echo "checked"; } ?>>ABC POWDER 9KG (BOMBA CERT)</input></center>
									</td>
								</tr>
							</table>
						</td>
					</tr>
	</form>
				<form name="prmA" action="product_validate.php?act=add&id=1&product_category=Promotion&product_qty=1&hyperlink=index" method="post">
					<tr>
						<td colspan='2' align='right'>
							<?php
								//a small function use to check either product is selected and show view chart on specify products
								if(isset($_SESSION['order_qty']) && $_SESSION['order_qty'] !='0')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							?>
							<input type="submit" value="ADD TO CART"></input>
							<input type="hidden" name="btnRd_product" value="<?php echo $btnRd_product; ?>"></input>
							<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"></input>
						</td>
					</tr>
				</form>
				
				</table>
			</td>
		</tr>
	</table>
	
 </div>

</body>
</html>