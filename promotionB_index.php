<?php
	//include('header.php');
	//require_once("connection/pbmartconnection.php");
	$promotion_ids = "2";
?>
<html>
<!DOCTTYPE HTML>
<script>
function autoSubmit() {
	var formObject_prmB = document.forms['promotionB_form'];
		formObject_prmB.submit();
	}
</script>
<html>
<TITLE>PBMart Home Page</TITLE>
<BODY>
 <div id="main">
 <form name="promotionB_form" action="product_validate.php?act=add&id=1&product_id=&product_category=Promotion&product_qty=1&hyperlink=index" method="post">
	<h1>Promotion B</h1>
	<table border='0' width="700px">
		<tr>
			<td valign='top'>
				<table border='1' style="border-color:black" width="720px" height="100%" valign='center'>
					
					<tr>
						<td align='center' colspan='2'><b>PROMOTION B (DOMESTIC)</b></td>
					</tr>
					
					<tr>
						<td align='center' width='150px'><b>Step 1</b></td>
						<td align='center'><b>Step 2</b></td>
					</tr>
					<tr>
						<td width='550px'>
							<img src="cmanage/promotion/photo/54f3ce5858790.jpg" width='100px' height='100px'></img>
							<BR/>
								<input type="radio" checked>CLESSE Gas Regulator WITH SAFETY VALVE
								<BR/>
								(AUTO CUT)</input>
							<BR/>
							<center><font size='3' color='black'><strong></strong></font></center>
						</td>
						<BR>
						
						<td valign='top'>
							<table border='0' width='550px' valign='center'>
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=5&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/54ddbbcb166c3.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=15&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/54e293567ec43.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=16&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/54e293ab1c182.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=17&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/54e294d842f7b.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									
									
								</tr>
								<tr>
									<td>
										<input type="radio" name="product_id" value="PKG_5">Captain Oats 800G</input>
									</td>
									<td>
										<input type="radio" name="product_id" value="PKG_15">COLGATE TOTAL 160G</input>
									</td>
									<td>
										<input type="radio" name="product_id" value="PKG_16">Daia Powder (900G x2)</input>
									</td>
									<td>
										<input type="radio" name="product_id" value="PKG_17">Maggi Curry(2X Package)</input>
									</td>
									
									
								</tr>
							
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=18&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/54e2953172999.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=19&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/54fd4ddb94e9e.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=27&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/5535fa964da8d.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
									<td>
										<center>
											<a href="promotion.php?prd_id=28&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">	
											<img src="cmanage/promotion/photo/54f3ce585889b.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" name="product_id" value="PKG_18">Nestle Milo 480G</input>
									</td>
									<td>
										<input type="radio" name="product_id" value="PKG_19">Cutie Compact Toilet Roll</input>
									</td>
									<td>
										<input type="radio" name="product_id" value="PKG_27">Bona Spray Mop</input>
									</td>
									<td>
										<input type="radio" name="product_id" value="PKG_28">Chelstar Double Gas Burner</input>
									</td>
									
									
								</tr>
								<!-- Line 3 -->
								<tr>
									<td>
										<center>
											<a href="promotion.php?prd_id=29&hyperlink=promotion&id=<?php echo $promotion_ids; ?>">
											<img src="cmanage/promotion/photo/54f3cf09526db.jpg" width="75px" height="75px"></img>
											</a>
										</center>
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" name="product_id" value="PKG_29">Sasaki Double Gas Burner</input>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan='2' align='right'>
							<?php
								//a small function use to check either product is selected and show view chart on specify products
								if(isset($_SESSION['order_qty'])  && $_SESSION['order_qty'] !='0')
								{
									echo "<a href='shopping_cart.php?hyperlink=product' target=_new style='text-decoration: none'>View Cart<img src='icon/tick.png' width='12px' height='12px'></img></a>";
								}
							?>
							<input type="submit" value="ADD TO CART"></input>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
 </div>

</body>
</html>