<?php
// Author: VOONG TZE HOWE
// Date Writen: 14-10-2014
// Description : specify product page
// Last Modification: 18-10-2014

include('header.php');
require_once("connection/pbmartconnection.php");

if(isset($_GET['redeem_id']))
{
	$redeem_id = $_GET['redeem_id'];
}else
{
	$redeem_id = "";
}

$sql_pbmart_product = "SELECT * FROM pbmart_redeem WHERE redeem_id='$redeem_id'";
$rs = mysql_query($sql_pbmart_product, $link);
$rw = mysql_fetch_array($rs);

$redeem_name = $rw['redeem_name'];
$redeem_model = $rw['redeem_model'];
$redeem_category = $rw['redeem_category'];
$redeem_description = $rw['redeem_description'];
$redeem_point = $rw['redeem_point'];
$redeem_image = $rw['redeem_image'];
$redeem_stock = $rw['redeem_stock'];
$redeem_class_product = $rw['redeem_class'];
?>

<script type="text/javascript" src="jscss/lib.js"></script>
<script type="text/javascript" src="jscss/facebox.js"></script>
<script type="text/javascript" src="jscss/val.js"></script>
<script type="text/javascript" src="jscss/dtp.js"></script>
<link rel="stylesheet" type="text/css" href="jscss/slimbox_ex.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscss/data.css" media="screen" />

<!-- http://stackoverflow.com/questions/10909297/number-validate-in-text-box-in-php -->
<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
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
											<img src="cmanage/redemption/<?php echo $redeem_image; ?>" alt="" width="210px" height="200px"></img>
										</td>
										
									<form action="product_validate.php?act=add" method="post">
										<td valign="top" width="30%">
											
												<BR><BR><h2><strong><font size="4"><?php //echo $redeem_name; ?></font></strong><BR><BR>
												<div class="product-desc">
												
												<p><?php //echo $redeem_model; ?><br />
												  </p></h2>
													<h3><strong class="price">Point <?php echo $redeem_point; ?></strong><BR>
													
													<?php
														if($redeem_class_product == "Royal")
														{ 
															if(isset($_SESSION['usr_name']))
															{
																if($member_point >= $redeem_point)
																{ ?>
																<a class='button' href="redemption_validate.php?act=add&redeem_id=<?php echo $redeem_id; ?>&redeem_category=<?php echo $redeem_category; ?>&redeem_qty=1&hyperlink=redemption"><span style='font-size:15px;color:#FFFFFF;'> Redeem</span></a>
															<?php }
															}
														} ?>
												</div></h3>
										</td>
									</form>
									</tr>
									
									<tr>
										<td colspan="2">
											<h2>
												<strong>
													<font size="4"><?php echo $redeem_name; ?></font>
												</strong>
											</h2>
											<BR/>
											<hr/>
										</td>
									</tr>
									
									
									
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
											<font size='3' color='black'>
												<strong>Product Description:</strong>
												<BR/><BR/>
											</font>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<?php echo $redeem_description; ?>
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

<style>
td { height: 100%;}
.bg { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }

td { height: 100%;}
.bg2 { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }
</style>	

<?php
include('sidefull.php');
include('footer.php');
?>
</div>
</body>
</html>