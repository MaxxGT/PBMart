<?php
include("connection/pbmartconnection.php");
	$product_row = 2;
	$product_col = 3;
?>
<!DOTYPE HTML>
<HTML>
	<TITLE>
	</TITLE>
	<BODY>
		<table border='0'>
			<tr>
				<td colspan='2'><h1>Tupperware Hamper</h1></td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			
					<?php
						$iCount = '0';
						$count3 = '0';
						$hamper_sql = "SELECT * FROM pbmart_product WHERE product_category_id='17' AND product_model='Home Delivery'";
						$hamper_rs = @mysql_query($hamper_sql);
						while($hamper_rw = @mysql_fetch_array($hamper_rs))
						{
							$product_id = $hamper_rw['product_id'];
							$product_name = $hamper_rw['product_name'];
							$product_image = $hamper_rw['product_image'];
							$product_price = $hamper_rw['product_price'];
							if($iCount==0)
											{ //echo ('div class start'); ?>
												<tr>			
									  <?php }
													if($iCount >=0 && $iCount <=2)
													{ //echo $iCount;
															
														if($iCount >= 0 && $iCount <= 1)
														{ $iCount++; ?>
																<td>
																	<a href="hamper_product.php?hyperlink=tupperware_hamper&product_id=<?php echo $product_id; ?>&product_name=<?php echo $product_name; ?>" title="<?php echo $product_name; ?>" style="text-decoration:none">
																		<img src="cmanage/product/<?php echo $product_image; ?>" width='200px' height='250px'></img>
																	</a>
																	<BR/>
																	<font size='3'><B><?php echo $product_name.' <font size=5 color=red>RM'.$product_price.'</font>'; ?></B></font>
																</td>
												  <?php }else
														{ //echo ('div end called');?>
																<td>
																	<a href="hamper_product.php?hyperlink=tupperware_hamper&product_id=<?php echo $product_id; ?>&product_name=<?php echo $product_name; ?>" title="<?php echo $product_name; ?>" style="text-decoration:none">
																		
																		<img src="cmanage/product/<?php echo $product_image; ?>" width='200px' height='250px'></img>
																	</a>
																	<BR/>
																	<font size='3'><B><?php echo $product_name.' <font size=5 color=red>RM'.$product_price.'</font>'; ?></B></font>
																</td>
										 <?php $iCount=0; } ?>			
											  <?php }
											$count3++;
											if($count3 == ($product_row * $product_col))
											{
												echo "</tr>";
												break;
											} ?>
						
						<?php
						}
					?>
			
		</table>
	</BODY>
</HTML>