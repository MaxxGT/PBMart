<?php
// Author: VOONG TZE HOWE
// Date Writen: 14-10-2014
// Description : specify product page
// Last Modification: 18-10-2014

// Last Modification: 16-12-2014
// Description: made change the width and height of display product img

// Last Modification: 19-12-2014
// Description: hide total quantity of product

require_once 'config.php';
include('header.php');
require_once("connection/pbmartconnection.php");
get_UsrInfo();
GLOBAL $member_commercial_status;

if(isset($_GET['product_id']))
{
	$product_id = $_GET['product_id'];
}else
{
	$product_id = "";
}

$sql_pbmart_product = "SELECT * FROM pbmart_product WHERE product_id='$product_id'";
$rs = mysql_query($sql_pbmart_product, $link);
$rw = mysql_fetch_array($rs);

$prt_category_id = $rw['product_category_id'];
$prt_category = $rw['product_category'];
$product_name = $rw['product_name'];
$product_model = $rw['product_model'];
$product_description = $rw['product_description'];
$product_price = $rw['product_price'];

$product_commercial_price = $rw['product_commercial_price'];
$product_commercial_price2 = $rw['product_commercial_price2'];

$product_handling = $rw['product_handling'];

$product_commercial_handling = $rw['product_commercial_handling'];
$product_commercial_handling2 = $rw['product_commercial_handling2'];

$product_handling_show = $rw['product_handling_show'];
$product_commercial_handling_show = $rw['product_commercial_handling_show'];
$product_commercial_handling_show2 = $rw['product_commercial_handling_show2'];

if($member_commercial_status =='0')
{
	$total_product_price = $product_price + $product_handling;
}else if($member_commercial_status =='1')
{
	if($member_commercial_class == '1')
	{
		$total_product_price = $product_commercial_price + $product_commercial_handling;
	}else if($member_commercial_class == '2')
	{
		$total_product_price = $product_commercial_price2 + $product_commercial_handling2;
	}else
	{
		$total_product_price = $product_commercial_price + $product_commercial_handling;
	}
	
}else
{
	$total_product_price = $product_price + $product_handling;
}

$product_stock = $rw['product_stock'];

if($member_commercial_status == '1')
{
	if($member_commercial_class == '1')
	{
		$display_product_price = $product_commercial_price;
		$display_product_handling = $product_commercial_handling;
	}else if($member_commercial_class == '2')
	{
		$display_product_price = $product_commercial_price2;
		$display_product_handling = $product_commercial_handling2;
	}else
	{
		$display_product_price = $product_commercial_price;
		$display_product_handling = $product_commercial_handling;
	}
}else
{
	$display_product_price = $product_price;
	$display_product_handling = $product_handling;
}
//determine the quantity maxlength based on the product_stock given
if($product_stock < 10)
{
	$maxsize = 1;
}else if($product_stock > 9)
{
	$maxsize = 2;
}else if($product_stock > 99)
{
	$maxsize = 3;
}else
{
	$maxsize = 1;
}

$product_path = $rw['product_image'];
$product_alt = $rw['product_alt'];

if(isset($_SESSION['order_qty']))
{
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{
		if($product_id == $_SESSION['product_id'][$i])
		{
			$product_stock = $product_stock - $_SESSION['product_qty'][$i];
		}
	}
}
?>

<!DOCTYPE html>
<html>
<title>
PBMART TUPPERWARE
</title>
<head>
	<meta charset='utf-8'/>
	<title>jQuery Zoom Demo</title>
	<style>
		/* these styles are for the demo, but are not required for the plugin */
		.zoom {
			display:inline-block;
			position: relative;
		}
		
		/* magnifying glass icon */
		.zoom:after {
			content:'';
			display:block; 
			width:33px; 
			height:33px; 
			position:absolute; 
			top:0;
			right:0;
			background:url(icon.png);
		}

		.zoom img {
			display: block;
		}

		.zoom img::selection { background-color: transparent; }
	</style>
	
	<script src='js/jquery.zoom.js'></script>
	<script>
		$(document).ready(function(){
			$('#ex1').zoom();
		});
	</script>
</head>
<body>

<!-- http://stackoverflow.com/questions/10909297/number-validate-in-text-box-in-php -->
<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	  
	  function validate(prd_qty)
	  {
		if(document.getElementById('product_qty').value > prd_qty || document.getElementById('product_qty').value <= 0)
		{
			alert('Error: Invalid input value! Please try again!');
			document.getElementById('product_qty').value = "1";
		}
	
		if(document.getElementById('product_qty').value == "")
		{
			alert('Error: Invalid input value! Please try again!');
			document.getElementById('product_qty').value = "1";
		}
}
</script>

<script type="application/javascript">
function addvalue()
{
	var value = document.getElementById('product_qty').value;
	
	if(value < <?php echo $product_stock; ?>)
	{
		document.getElementById('product_qty').value++;
	}	
}
</script>

<script type="application/javascript">
function minus_value()
{
	var value = document.getElementById('product_qty').value;
	if(value > 1)
	{
		document.getElementById('product_qty').value--;
	}	
}
</script>

<!-- include this file everytime you want to use rating plugin -->
<script src="raty/jquery.raty.js" type="text/javascript"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1033564079989207";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
	<table border="0">
		<tr>
			<td valign=top>
				<!-- Sidebar -->
					<?php include('sidebar.php'); ?>
				<!-- End Sidebar -->
			</td>
			
			<td valign=top>
				<table border="0">
					<tr>
						<td valign=top>
							<!-- Content -->
								<div id="content">
								  <table border="0" style="font-family: verdana; font-size: 12px;" cellpadding="0" width="730px">
									<tr>
										<td>
											<span class='zoom' id='ex1'>
												<img src="cmanage/product/<?php echo $product_path; ?>" title="<?php echo $product_alt; ?>" alt="<?php echo $product_alt; ?>" width="432px" height="350px"></img>
											</span>
										</td>
										
									<form action="product_validate.php?act=add&trigger=product" method="post">
										<td valign="top" width="30%">
											
												<BR><BR><h2><strong><font size="4"><?php //echo $product_name; ?></font></strong><BR><BR>
												<div class="product-desc">
												<?php //echo $product_model; ?>
												<!--<p><?php echo $product_description; ?><br />-->
												  </p></h2>
													<BR>
													<strong><font color='black'>Quantity</font></strong>
													
													<?php
														if($product_id == '7' || $product_id =='8')
														{
															$disabled = "disabled";
															$readonly = "readonly";
															?>
															<input type="text" id="product_qty" name="product_qty" size="3" maxlength="<?php echo $maxsize; ?>" value="1" onblur="validate(<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled';}?> <?php echo $readonly; ?> ></input>
													<?php
														}else
														{
															$disabled = "";
															$readonly = "";
															?> 
															<input type="button" name="btnMinus" value="-" style="height: 20px; width: 15px;" onclick="minus_value()" <?php echo $disabled; ?>></input>
															<input type="text" id="product_qty" name="product_qty" size="3" maxlength="<?php echo $maxsize; ?>" value="1" onblur="validate(<?php echo $product_stock; ?>)" onkeypress="return isNumberKey(event)" <?php if($product_stock==0){echo 'disabled';}?> <?php echo $readonly; ?>></input>
															<input type="button" name="btnPlus" value="+" style="height: 20px; width: 15px;" onclick="addvalue()" <?php echo $disabled; ?>></input>													
													<?php } ?>
													
													<?php
														if($product_stock == '0')
														{
															$disabled = 'disabled';
														}else
														{
															$disabled = "";
														}
													?>
													
													<h3>
														<strong class="price">
															<BR/>
																<?php
																if($member_commercial_status == '0')
																{
																	if($product_handling_show == '1')
																	{
																		echo('RM'.number_format($display_product_price,2));
																		echo "<BR/><font size='2'>+ OTHERS RM";
																		echo number_format($display_product_handling,2);
																		echo "</font>";
																	}else
																	{
																		echo('RM'.number_format($total_product_price,2));
																	}
																}else if($member_commercial_status == '1')
																{
																	if($member_commercial_class == '1')
																	{
																			if($product_commercial_handling_show == '1')
																			{
																				echo('RM'.number_format($display_product_price,2));
																				echo "<BR/><font size='2'>+ OTHERS RM";
																				echo number_format($display_product_handling,2);
																				echo "</font>";
																			}else
																			{
																				echo('RM'.number_format($total_product_price,2));
																			}
																	}else if($member_commercial_class == '2')
																	{
																		if($product_commercial_handling_show2 == '1')
																		{
																			echo('RM'.number_format($display_product_price,2));
																			echo "<BR/><font size='2'>+ OTHERS RM";
																			echo number_format($display_product_handling,2);
																			echo "</font>";
																		}else
																		{
																			echo('RM'.number_format($total_product_price,2));
																		}
																	}else
																	{
																		if($product_commercial_handling_show == '1')
																		{
																			echo('RM'.number_format($display_product_price,2));
																			echo "<BR/><font size='2'>+ OTHERS RM";
																			echo number_format($display_product_handling,2);
																			echo "</font>";
																		}else
																		{
																			echo('RM'.number_format($total_product_price,2));
																		}
																	}
																}else
																{
																	if($product_handling_show == '1')
																	{
																		echo('RM'.number_format($display_product_price,2));
																		echo "<BR/><font size='2'>+ OTHERS RM";
																		echo number_format($display_product_handling,2);
																		echo "</font>";
																	}else
																	{
																		echo('RM'.number_format($total_product_price,2));
																	}
																}
																?>
														</strong>
													
	<?php
      // fetch product details
      $sql = "SELECT `product_id`, `product_name`, `product_price` FROM `pbmart_product` WHERE 1 AND product_id = :pid";
      try {

        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":pid", intval($_GET["product_id"]));
        $stmt->execute();
        // fetching products details
        $products = $stmt->fetchAll();
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

      // fetching ratings for specific product
      $ratings_sql = "SELECT count(*) as count, AVG(ratings_score) as score FROM `pbmart_products_ratings` WHERE 1 AND product_id = :pid";
      $stmt2 = $DB->prepare($ratings_sql);

      try {
        $stmt2->bindValue(":pid", $_GET["product_id"]);
        $stmt2->execute();
        $product_rating = $stmt2->fetchAll();
      } catch (Exception $ex) {
        // you can turn it off in production mode.
        echo $ex->getMessage();
      }

      if (isset($member_id)) {
        // check if user has rated this product or not
        $user_rating_sql = "SELECT count(*) as count FROM `pbmart_products_ratings` WHERE 1 AND product_id = :pid AND user_id= :uid";
        $stmt3 = $DB->prepare($user_rating_sql);
		
        try {
          $stmt3->bindValue(":pid", $_GET["product_id"]);
          $stmt3->bindValue(":uid", $member_id);
          $stmt3->execute();
          $user_product_rating = $stmt3->fetchAll();
        } catch (Exception $ex) {
          // you can turn it off in production mode.
          echo $ex->getMessage();
        }
      }
      ?>
														<BR/>
													<input type="submit" name="sbtButton" value="Add to Cart" title="add to cart" <?php echo $disabled; ?>></input>
													</div></h3>
										</td>
											<input type="hidden" name="product_id" value="<?php echo $product_id; ?>"></input>
											<input type="hidden" name="product_category_id" value="<?php echo $prt_category_id; ?>"></input>
											<input type="hidden" name="product_category" value="<?php echo $prt_category; ?>"></input>
											<input type="hidden" name="hyperlink" value="product"></input>
									</form>
									</tr>
									
									<tr>
										<td colspan="2"><h2><strong><font size="4"><?php echo $product_name; ?></font></strong><BR/><BR/><hr/></td>
										
									</tr>
									
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
												<strong><font size='3' color='black'>Product Description:</font></strong>
												<BR/><BR/>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<?php echo $product_description; ?>
										</td>
									</tr>
									
									<tr>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
												<strong><font color='black' size='3'>Terms and Conditions:</font></strong>
												<BR/><BR/>
										</td>
									</tr>
									
									<tr>
										<td colspan="2">
										<font color='black'>
											1. Tupperware products colour are not able to choose.<BR/>
											2. All Tupperware order will be fufill within 3 to 5 working days.<BR/>
											3. All Tupperware offer only valid while stock last.<BR/>
											4. Order made in Sunday or Public Holiday will be carried to next working day.
										</font>
										</td>
									</tr>
								  </table>
								</div>
							<!-- End Content -->
						</td>
					</tr>
				</table>
			</td>
		</tr>

	</table>
<script>
  $(function() {
    $('#prd').raty({
      number: 5, starOff: 'raty/img/star-off-big.png', starOn: 'raty/img/star-on-big.png', width: 180, scoreName: "score",
    });
  });
</script>

<script>
  $(document).on('click', '#submit', function() {
<?php
if (!isset($member_id)) {
  ?>
      alert("You need to have a account to rate this product?");
      return false;
<?php } else { ?>

      var score = $("#score").val();
      if (score.length > 0) {
        $("#rating_zone").html('processing...');
        $.post("update_ratings.php", {
          pid: "<?php echo $_GET["product_id"]; ?>",
          uid: "<?php echo $member_id; ?>",
          score: score
        }, function(data) {
          if (!data.error) {
            // success message
            $("#avg_ratings").html(data.updated_rating);
            $("#rating_zone").html(data.message).show();
          } else {
            // failure message
            $("#rating_zone").html(data.message).show();
          }
        }, 'json'
                );
      } else {
        alert("select the ratings.");
      }

<?php } ?>
  });
</script>

<style>
td { height: 100%;}
.bg { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }

td { height: 100%;}
.bg2 { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }
</style>	

<?php
include('sidefull.php');
?>
			<div style="height:51px; width:940px; background:#ebebeb; white-space:nowrap; line-height:50px; padding:0 15px; color:#7b7b7b; position:relative; float:bottom;">
				<?php include('footer.php'); ?>
			</div>
</div>
</body>
</html>