<?php
// Author: VOONG TZE HOWE
// Date Writen: 14-11-2014
// Description : checkout page
// Last Modification: 23-04-2015

include('header.php');
get_UsrInfo();
GLOBAL $member_commercial_status;
include("connection/pbmartconnection.php");
$current_date = date("Y-m-d");
$card_subtotal = '0';
$pkg_count = "0";
$prd_count = "0";
$nrm_class = "0";
$ryl_class = "0";
$cm_class = "0";
$tp_class = "0";

$total_exchange_gas = '0';

if(!empty($_SESSION['order_qty']))
{
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{
		if(isset($_SESSION['product_id'][$i]))
		{
			$prd_id = $_SESSION['product_id'][$i];
		}
		
		if(strpos($prd_id, 'PKG_') !== false)
		{
			$pkg_count++;
		}else
		{
			$prd_count++;
		}
	}
}
if(!empty($_SESSION['order_qty']))
{
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{ 
				$product_id = $_SESSION['product_id'][$i];
				$total_handling_charge = '0';
				
				if(strpos($product_id, 'PKG_') !== false)
				{
					$total_handling_charge = '0';
					$product_ids = explode("PKG_", $product_id);
					$product_ids2 = $product_ids[1];
					
					$sql = "Select 
								   promotion_product_category_id,
								   promotion_package_name,
								   promotion_package_price,
								   promotion_category_id,
								   '0' AS product_sale1,
								   '0' AS product_sale_percentage1,
								   '0' AS product_sale2,
								   '0' AS product_sale_percentage2,
								   '0' AS product_sale3,
								   '0' AS product_sale_percentage3,
								   promotion_product_price,
								   promotion_product_sale AS prd_sale,
								   promotion_item_sale AS itm_sale
								   
								   FROM pbmart_promotion WHERE promotion_id='$product_ids2'";
					
					$rs = @mysql_query($sql, $link);
					$rw = @mysql_fetch_array($rs);
					
					if($rw['promotion_product_category_id'] == '1')	
					{
						$total_exchange_gas = $total_exchange_gas + $_SESSION['product_qty'][$i];
					}
					
					//access category of product_sale and product_sale_percentage
					$product_sale1 = $rw['product_sale1'];
					$product_sale_percentage1 = $rw['product_sale_percentage1'];
								
					$product_sale2 = $rw['product_sale2'];
					$product_sale_percentage2 = $rw['product_sale_percentage2'];
								
					$product_sale3 = $rw['product_sale3'];
					$product_sale_percentage3 = $rw['product_sale_percentage3'];
					
					$promotion_product_price = $rw['promotion_product_price'];
					$prd_sale = $rw['prd_sale'];
					$itm_sale = $rw['itm_sale'];
					
					$product_qty = $_SESSION['product_qty'][$i];
					$product_price = $rw['promotion_package_price'];
					$promotion_category_id = $rw['promotion_category_id'];
					
					$promotion_unit_price = $promotion_product_price + $itm_sale;
					
					$cd_subtotal = cal_price($promotion_unit_price, $total_handling_charge, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
					$card_subtotal += $cd_subtotal;	
				}else
				{
					$total_handling_charge = '0';
					$sql = "Select * FROM pbmart_product WHERE product_id='$product_id'";
					$rs = @mysql_query($sql, $link);
					$rw = @mysql_fetch_array($rs);
					
					$product_category_id = $rw['product_category_id'];
					if($product_category_id == '1')
					{
						$total_exchange_gas = $total_exchange_gas + $_SESSION['product_qty'][$i];
					}
					
					//access category of product_sale and product_sale_percentage
					$product_sale1 = $rw['product_sale1'];
					$product_sale_percentage1 = $rw['product_sale_percentage1'];
					$product_sale2 = $rw['product_sale2'];
					$product_sale_percentage2 = $rw['product_sale_percentage2'];		
					$product_sale3 = $rw['product_sale3'];
					$product_sale_percentage3 = $rw['product_sale_percentage3'];
					
					$product_qty = $_SESSION['product_qty'][$i];
					$product_handling = $rw['product_handling'];
					$product_commercial_handling = $rw['product_commercial_handling'];
					$product_commercial_handling2 = $rw['product_commercial_handling2'];
					
					$product_handling_show = $rw['product_handling_show'];
					
					$product_commercial_handling_show = $rw['product_commercial_handling_show'];
					$product_commercial_handling_show2 = $rw['product_commercial_handling_show2'];
					
					$product_price = $rw['product_price'];
					
					$product_commercial_price = $rw['product_commercial_price'];
					$product_commercial_price2 = $rw['product_commercial_price2'];
					
					$product_unit_price = $product_price;
					
					if($member_commercial_status == '0')
					{
						if($product_handling_show == '0')
						{
							$product_unit_price = $product_price + $product_handling;
							$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
						}else
						{
							$product_unit_price = $product_price;
							$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty); //calculate total handling charge
						}
						
					}else if($member_commercial_status == '1')
					{
						if($member_commercial_class == '1')
						{
							if($product_commercial_handling_show == '0')
							{
								$product_unit_price = $product_commercial_price + $product_commercial_handling;
								$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
							}else
							{
								$product_unit_price = $product_commercial_price;
								$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $product_qty); //calculate total handling charge
							}
						}else if($member_commercial_class == '2')
						{
							if($product_commercial_handling_show2 == '0')
							{
								$product_unit_price = $product_commercial_price2 + $product_commercial_handling2;
								$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
							}else
							{
								$product_unit_price = $product_commercial_price2;
								$total_handling_charge = $total_handling_charge + ($product_commercial_handling2 * $product_qty); //calculate total handling charge
							}
						}else
						{
							if($product_commercial_handling_show == '0')
							{
								$product_unit_price = $product_commercial_price + $product_commercial_handling;
								$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
							}else
							{
								$product_unit_price = $product_commercial_price;
								$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $product_qty); //calculate total handling charge
							}
						}
					}else
					{
						if($product_handling_show == '0')
						{
							$product_unit_price = $product_price + $product_handling;
							$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
						}else
						{
							$product_unit_price = $product_price;
							$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty); //calculate total handling charge
						}
						
					}
					
					$cd_subtotal = cal_price($product_unit_price, '0', $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
					
					$card_subtotal+= $cd_subtotal;
				}	
	}
}

if(isset($_SESSION['redeem_order_qty']))
{
	for($i=0; $i<$_SESSION['redeem_order_qty']; $i++)
	{
		//redeem_id
		if(isset($_SESSION['redeem_id'][$i]))
		{
			$rdm_id = $_SESSION['redeem_id'][$i];
		}else
		{
			$rdm_id = "";
		}

		//if selected product is not package, then...
		$sql_redeem = "Select * FROM pbmart_redeem WHERE redeem_id = '$rdm_id'";
					
		$rs_redeem = mysql_query($sql_redeem, $link);
		$rw_redeem = mysql_fetch_array($rs_redeem);
		$rdm_class = $rw_redeem['redeem_class'];
		if($rdm_class == "Normal")
		{
			$nrm_class++;
		}
		if($rdm_class == "Royal")
		{
			$ryl_class++;
		}
		if($rdm_class == "Commercial")
		{
			$cm_class++;
		}if($rdm_class == "Tupperware")
		{
			$tp_class++;
		}
	}
}

$message ="Note: You must order one LPG Gas Cylinder or redeem any royal products in other to proceed checkout. Thanks!";
$msg = "<script type='text/javascript'>alert('$message');</script>
		<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
if($pkg_count == '0' && $prd_count=='0')
{
	if($ryl_class=='0')
	{	
		if($nrm_class > 0)
		{	
			echo $msg;
		}else if($cm_class >0)
		{
			echo $msg;
		}else if($tp_class >0)
		{
			echo $msg;
		}
	}
}


if(!isset($_SESSION['usr_name']))
{
	$message = "Please signin to make payment thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
	exit;
}else if(empty($_SESSION['order_qty']) && empty($_SESSION['redeem_order_qty']))
{
	$message = "Please make an order from product pages! Thanks!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
	exit;
}

//amend info data
if(isset($_POST['first_name']) && $_POST['first_name']!="")
{
	$member_first_name = $_POST['first_name'];
}

if(isset($_POST['last_name']) && $_POST['last_name']!="")
{
	$member_last_name = $_POST['last_name'];
}

if(isset($_POST['user_email']) && $_POST['user_email']!="")
{
	$member_email = $_POST['user_email'];
}

if(isset($_POST['tel']) && $_POST['tel']!="")
{
	$member_telephone = $_POST['tel'];
}

if(isset($_POST['mobile']) && $_POST['mobile']!="")
{
	$member_contact = $_POST['mobile'];
}

if(isset($_POST['street_name']) && $_POST['street_name']!="")
{
	$member_street_name = stripslashes($_POST['street_name']);
	$member_street_name = htmlentities($member_street_name);
}

if(isset($_POST['flr_num']) && $_POST['flr_num']!="")
{
	$flr_num = $_POST['flr_num'];
	$dlvy_type = '1';
}else
{
	$dlvy_type = "0";
	$flr_num = "0";
	if($member_flat_floor !='0')
	{
		$flr_num = '1';
	}else
	{
		$member_flat_floor = '0';
	}
}

if(isset($_POST['flr_num']) && $_POST['flr_num']!="")
{
	$flr_num_disabled = "disabled";
	$member_flat_floor = '0';
}else
{
	$flr_num_disabled = "";
}

if(isset($_POST['flr_num']) && $_POST['flr_num']!="")
{
	$member_flat_floor = $_POST['flr_num'];
}

if(isset($_POST['city']) && $_POST['city']!="")
{
	$member_city = $_POST['city'];
}

if(isset($_POST['region_state']) && $_POST['region_state']!="")
{
	$member_state = $_POST['region_state'];
}else if(isset($_POST['region_state']) && $_POST['region_state']=="0")
{
	$member_state="";
}

if(isset($_POST['country']) && $_POST['country']!="")
{
	$member_country = $_POST['country'];
}else if(isset($_POST['country']) && $_POST['country']=="0")
{
	$member_country="";
}

if(isset($_POST['pst_code']) && $_POST['pst_code']!="")
{
	$member_postcode = $_POST['pst_code'];
}else if(isset($_POST['pst_code']) && $_POST['pst_code']=="0")
{
	$member_postcode="";
}

//gather shipping time

if(isset($_POST['shp_time']) && $_POST['shp_time']!='0')
{
	$selected_time = $_POST['shp_time'];
	
	if($selected_time == '3')
	{
		
		$message = "For emergency delivery, please call 082-688968. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		$selected_time = "";
		$selected_date = "";
	}
}else
{
	$selected_time = '0';
}

if(isset($_POST['shp_date']))
{
	$selected_date = $_POST['shp_date'];
}

if(isset($_POST['chk_tnc']))
{
	$chk_tnc = $_POST['chk_tnc'];
}else
{
	$chk_tnc = "unchecked";
}

if(isset($_POST['nbr_mygaz']))
{
	$nbr_mygaz = $_POST['nbr_mygaz'];
}else
{
	$nbr_mygaz = "0";
}

if(isset($_POST['nbr_petronas']))
{
	$nbr_petronas = $_POST['nbr_petronas'];
}else
{
	$nbr_petronas = "0";
}

//if(($nbr_mygaz + $nbr_petronas) > $total_exchange_gas)
//{
//	echo "Note! Cylinder Error!";
//}

if(isset($_POST['order_remark']))
{
	$order_remark = $_POST['order_remark'];
}else
{
	$order_remark = "";
}
?>
<link href="glDatePicker-2.0/styles/glDatePicker.flatwhite.css" rel="stylesheet" type="text/css">
<script type="application/javascript">
function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
		 if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}
</script>

<script language=JavaScript>
	function autoSubmit() {
	var formObject = document.forms['checkout_page'];
		formObject.submit();
	}
</script>

<script>
function showHint(ttl_price, std_time) {
    if (ttl_price.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
			}
        }
        xmlhttp.open("GET", "point_ajax.php?total_price=" + ttl_price + "&std_time=" + std_time, true);
        xmlhttp.send();
    }
}

//http://stackoverflow.com/questions/6714202/how-can-i-disable-the-enter-key-on-my-textarea
function TriggeredKey(e)
{
        var keycode;
        if (window.event)
		{			
			keycode = window.event.keyCode;
        }
		if (window.event.keyCode == 13 ) 
		{	
			event.preventDefault();
		}
}
</script>

<link href="styles/glDatePicker.flatwhite.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<form name="checkout_page" action="checkout_page.php?hyperlink=product" method="post">

	<table border="0" width="960px">
		<tr>
			<BR><BR>
			<td colspan="5"><h1><strong>Billing Details</strong></h1><br /><br /></td>
		</tr>
		
		<tr>		
			<td colspan='2'><strong><font size="4">Account Information</font></strong><br/><br/></td>
			<td>&nbsp;</td>
			<td colspan='2'><strong><font size="4">Delivery Address</font></strong><br/><br/></td>
		</tr>
		
		<tr>
			<td>First Name: <span style = "color:red">*</span></td>
			<td><input type="text" id="first_name" name="first_name" size="30" value="<?php echo $member_first_name; ?>" onblur="autoSubmit()"></td>
			
			<td>&nbsp;</td>
							
			<td>Address : <span style = "color:red">*</span></td>
			<td>
				<textarea id="street_name" name="street_name" rows="3" cols="40" onkeypress="TriggeredKey(event);" onblur="autoSubmit()"><?php echo $member_street_name; ?></textarea>
			</td>
		</tr>
		
		<tr>				
			<td>Last Name : <span style = "color:red">*</span></td>
			<td><input type="text" id="last_name" name="last_name" size="30" value="<?php echo $member_last_name; ?>" onblur="autoSubmit()"></input></td>
			<td>&nbsp;</td>
							
			<td>City : <span style = "color:red">*</span></td>
					<td>
						<select id="city" name="city" style="font-family: verdana; font-size: 12px;" onchange="autoSubmit()">
							<option value="0" <?php if(isset($member_state) && $member_state == "0"){echo "selected";}else{ echo "";} ?>>--Select--</option>
								
								<?php
									
									$sql_pbmart_city = "Select * FROM pbmart_service_city";
									$rs_city = mysql_query($sql_pbmart_city, $link);
									while($rw_city = mysql_fetch_array($rs_city))
									{
										$service_city = $rw_city['service_city'];
										if($service_city == $member_city)
										{
											$svr_city = "selected";
										}
										?>
										
										<option value="<?php echo $service_city; ?>" <?php if(isset($svr_city)){echo $svr_city;} ?>><?php echo $service_city; ?></option>
								<?php $svr_city= ""; } ?>
						</select>			
					</td>
		</tr>
		
		<tr>				
			<td>Email : <span style = "color:red">*</span></td>
			<td><input type="email" id="user_email" name="user_email" size="30" value=<?php echo $member_email; ?> onblur="autoSubmit()"></td>
			<td>&nbsp;</td>
			
			<td>State : <span style = "color:red">*</span></td>
			<td>
				<select id="region_state" name="region_state" style="font-family: verdana; font-size: 12px;" onchange="autoSubmit()">
							<option value="0" <?php if(isset($member_state) && $member_state == "0"){echo "selected";}else{ echo "";} ?>>--Select--</option>
								<?php
									$sql_pbmart_state = "Select * FROM pbmart_service_state";
									$rs_state = mysql_query($sql_pbmart_state, $link);
									while($rw_state = mysql_fetch_array($rs_state))
									{
										$service_state = $rw_state['service_state'];
										if($service_state==$member_state)
										{
											$srv_state = "selected";
										}
										?>
										<option value="<?php echo $service_state; ?>"<?php if(isset($srv_state)){echo $srv_state;} ?>><?php echo $service_state; ?></option>
								<?php $srv_state=""; } ?>	
				</select>
			</td>
		</tr>
		
		<tr>
			<td>Contact Number : <span style = "color:red">*</span></td>
			<td><input type="text" id="mobile" name="mobile" size="30" pattern="[0-9]{3}-[0-9]*|[0-9]{8}" value="<?php echo $member_contact; ?>" maxlength="12" onKeyPress="return isNumberKey(event)" onblur="autoSubmit()"></input></td>
			<td>&nbsp;</td>
			
			<td>Country : <span style = "color:red">*</span></td>
					<td>
						<select id="country" name="country" onchange="autoSubmit()">
						<option value="0" <?php if(isset($member_country) && $member_country=="0"){echo "selected";}else{ echo "";} ?>>--Select--</option>
							<?php
									$sql_pbmart_country = "Select * FROM pbmart_service_country";
									$rs_country = mysql_query($sql_pbmart_country, $link);
									while($rw_country = mysql_fetch_array($rs_country))
									{
										$service_country = $rw_country['service_country'];
										if($rw_country['service_country'] == $member_country)
										{
											$srv_country = "selected";
										}
										?>
										
										<option value="<?php echo $service_country; ?>" <?php if(isset($srv_country)){echo $srv_country;} ?>><?php echo $service_country; ?></option>
								<?php 
											$srv_country="";
									} ?>
						</select>
			</td>
		</tr>
		
		<tr>				
			<td></td>
			<td></td>
			<td></td>
			
			<td>Postal/Zip Code : <span style = "color:red">*</span></td>
			
				<!-- <input type="text" id="pst_code" name="pst_code" value="<?php echo $member_postcode; ?>" onKeyPress="return isNumberKey(event)" onblur="autoSubmit()"></input> -->
			<td>
				<!-- <select id="pst_code" name="pst_code" onchange="autoSubmit()">
					<option value="0" <?php if(isset($member_postcode) && $member_postcode=="0"){echo "selected";}else{ echo "";} ?>>-- Select --</option>
					<?php
						$sql_pbmart_pst_code = "Select * FROM pbmart_service_postcode";
						$rs_pst_code = mysql_query($sql_pbmart_pst_code, $link);
						while($rw_pst_code = mysql_fetch_array($rs_pst_code))
						{
							$service_pst_code = $rw_pst_code['post_code'];
							if($rw_pst_code['post_code'] == $member_postcode)
							{
								$srv_pst_code = 'selected';
							}
						?>
							<option value="<?php echo $service_pst_code; ?>" <?php if(isset($srv_pst_code)){echo $srv_pst_code;} ?>><?php echo $service_pst_code; ?></option>
				  <?php 
					$srv_pst_code="";
				  }  ?>
				</select> -->
				<input type="text" name="pst_code" id="pst_code" maxlength='5' size='10' value='<?php echo $member_postcode; ?>' onKeyPress="return isNumberKey(event)" onblur="autoSubmit()"></input>
			</td>
			
		</tr>
		
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan='5'><strong><font size="4">Addition Information</font></strong></td>
		</tr>
		
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
		
		<tr>
			<td>
				Preferred Shipping Time : <span style = "color:red">*</span>
			</td>
			<td>
				<select id="shp_time" name="shp_time" onchange="autoSubmit()">
					<option value="0" <?php if(isset($selected_time) && $selected_time =='0'){echo 'selected';} ?>>Select below</option>
					<option value="2" <?php if(isset($selected_time) && $selected_time =='2'){echo 'selected';} ?>>Morning (8:00am to 12:00pm)</option>
					<option value="1" <?php if(isset($selected_time) && $selected_time =='1'){echo 'selected';} ?>>Afternoon (12:00pm to 4:00pm)</option>
					<option value="3" <?php if(isset($selected_time) && $selected_time =='3'){echo 'selected';} ?>>Emergency Delivery</option>
				</select>
			</td>
			<td></td>
			
			<?php
				if($member_flat_status !='0')
				{ ?>
				<td> Flat Delivery : <font color='red'>**</font></input></td>
				<td>
					<select id="flr_num" name="flr_num" onchange="autoSubmit()">
						<option value="0">- Select Floor -</option>
						<?php
							for($i='1'; $i<101; $i++)
							{
								?>
								<option value="<?php echo $i; ?>" <?php if(isset($member_flat_floor) && $member_flat_floor == $i){echo 'selected';} ?>><?php echo $i; ?></option>
					  <?php }
						?>
						
					</select>
					
					Floor
				</td>
				<?php }else
				{ ?>
					<td></td>
					<td></td>
			<?php } ?>
		</tr>
		
		<tr>
			<td>
				Preferred Shipping Date	: <span style = "color:red">*</span>
			</td>
			
			<td>
				<input type="text" id="shp_date" name="shp_date" size='30' gldp-id="shp_date" value="<?php if(isset($selected_date)){echo $selected_date;}else{ echo ""; } ?>" />
			
			<script src="glDatePicker-2.0/glDatePicker.min.js"></script>
			
			<div gldp-el="shp_date"
				 style="width:300px; height:200px; position:absolute; top:70px; left:100px;">
			</div>
		
			<script type="text/javascript">
				$('#shp_date').glDatePicker(
				{
					
					showAlways: false,
					cssName: 'flatwhite',
					allowMonthSelect: true,
					allowYearSelect: true,
					prevArrow: '\u25c4',
					nextArrow: '\u25ba',
					selectableDOW: [1,2,3,4,5,6],
					hideOnClick: true,
					todayDate: new Date(),
					onClick: function(target, cell, date, data) {
						
					var d = date.getDate(); d = ("0" + d).slice(-2);
					var m = date.getMonth() + 1; m = ("0" + m).slice(-2);
					
					var y = date.getFullYear();
					
						target.val(	d + '-' +
									m + '-' +
									date.getFullYear());

						if(data != null) {
							alert(data.message + '\n' + date);
						}
						autoSubmit();
					},
					
					calendarOffset: { x: 0, y: 1 },
					selectableDateRange: [
						{ from: new Date(2016, 01, 01),
							to: new Date(2016, 01, 06) },
						{ from: new Date(2016, 01, 10),
							to: new Date(2016, 12, 01) },
					],
				});
			</script>
				
				
				
				
				
																				
			
			</td>
			<td></td>
			<?php
				if($member_flat_status !='0')
				{ ?>
					<td colspan='2'>
						<font color="FF0000" size='2'>
							<B>**FOR FLAT DELIVERY, RM1.00 WILL BE CHARGED PER FLOOR</B>
						</font>
					</td>
				<?php }else
				{ ?>
					<td></td>
			<?php } ?>
		</tr>
		
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td colspan='2'></td>
		</tr>
	<?php	
	if($member_commercial_status =='1')
	{ ?>
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan='5'><strong><font size="4">Return Cylinder</font></strong></td>
		</tr>
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
		<tr>
			<td>MYGAZ: <span style = "color:red">*</span></td>
			<td><input type='number' value='<?php echo $nbr_mygaz; ?>' id='nbr_mygaz' name='nbr_mygaz' min='0' onchange='autoSubmit()' /></td>
		</tr>
		<tr>
			<td>PETRONAS: <span style = "color:red">*</span></td>
			<td><input type='number' value='<?php echo $nbr_petronas; ?>' id='nbr_petronas' name='nbr_petronas' min='0' onchange='autoSubmit()' /></td>
		</tr>
	<?php } ?>
	
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
	
		<tr>
			<td colspan='6'>
				<font color="FF0000" size='2'><B>NOTE: ALL GAS ORDER WILL BE CLEAR WITHIN 3 WORKING DAYS</B>
					<BR/>
					<B>ORDER MADE IN SUNDAY OR PUBLIC HOLIDAY WILL BE CARRIED TO NEXT WORKING DAY</B>
					<BR/>
					<BR/>
				</font>
			</td>
		</tr>
		
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
		<tr>
			<td><strong><font size="4">Order Remark</font></strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='5'>
				<textarea id="order_remark" name="order_remark" rows="7" cols="138" onkeypress="TriggeredKey(event);" onblur="autoSubmit()" placeholder='Place your order remark here'><?php echo $order_remark; ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan='6' >
				<div>
					<label>
						<input type="checkbox" id="chk_tnc" name="chk_tnc" <?php if($chk_tnc =='1'){echo "checked"; }else{echo "unchecked";} ?> value='1' onchange="autoSubmit();">
							<B><font size='2'> I have read and accept the 
							
							<a href="service_area.php" target="_blank">services provided area</a>.
							</font></B>
						</input>
					</label>
				</div>
			</td>
		</tr>
		
		
		<tr>
			<td colspan='6'>&nbsp;</td>
		</tr>
	</table>

<table border="0" width="989px">
	<tr>
		<td colspan="7">
			<strong>
				<font size="4">
					<div style="align:center;  font-size:18px; height=100px;">
						<center>YOUR ORDERS</center>
						<hr>
					</div>
				</font>
			</strong>
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><h2>Products</h2></td>
		<td colspan="3" align="center"><h2>Price</h2></td>
		<td width='0px' colspan="1" align="center"><h2>Quantity</h2></td>
		
		<!--<td align="center"><h2>Discount %</h2></td>-->
		<td width='120px' align="right"><h2>Total Price</h2></td>
	</tr>
	
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	
	<?php
		//$shipping_handling = '3.40';
		$total_handling_charge = '0';
		$total_point_reward = '0'; //a variable use to calculate the total point of selected product
		$display_others='0';
		$total_flat_handling='0';
		$prm_unit_points = '0';
		
	if(!empty($_SESSION['order_qty']))
	{		
		for($i=0; $i<$_SESSION['order_qty']; $i++)
		{
			$cd_subtotals = '0';
			$product_id = $_SESSION['product_id'][$i];
			//if selected product is package product, then...
			if(strpos($product_id, 'PKG_') !== false)
			{
				$total_handling_charge = '0';
				$product_ids = explode("PKG_", $product_id);
				$product_ids2 = $product_ids[1];
				$sql_pbmart_promotion ="Select 
							  promotion_package_name,
							  promotion_product_category_id,
							  promotion_product_name AS product_name,
							  promotion_product_price,
							  promotion_item_name AS item_name,			   
										   promotion_package_price,
										   promotion_product_sale AS product_price,
										   promotion_package_point,
										   promotion_package_point_ptrs,
										   promotion_package_double_point,
										   promotion_item_sale AS item_price,
										   '0' AS product_sale1,
										   '0' AS product_sale_percentage1,
										   '0' AS product_sale2,
										   '0' AS product_sale_percentage2,
										   '0' AS product_sale3,
										   '0' AS product_sale_percentage3,
										   promotion_category_id,
										   promotion_package_stock AS product_stock
										   FROM pbmart_promotion WHERE promotion_id = '$product_ids2'";
				
				$rs_pbmart_promotion = @mysql_query($sql_pbmart_promotion, $link);
				$rw_pbmart_promotion = @mysql_fetch_array($rs_pbmart_promotion);
				
				$promotion_package_name = $rw_pbmart_promotion['promotion_package_name'];
				$promotion_product_category_id = $rw_pbmart_promotion['promotion_product_category_id'];
				$product_name = $rw_pbmart_promotion['product_name'];
				$item_name = $rw_pbmart_promotion['item_name'];
				
				//access category of product_sale and product_sale_percentage
				$product_sale1 = $rw_pbmart_promotion['product_sale1'];
				$product_sale_percentage1 = $rw_pbmart_promotion['product_sale_percentage1'];
				$product_sale2 = $rw_pbmart_promotion['product_sale2'];
				$product_sale_percentage2 = $rw_pbmart_promotion['product_sale_percentage2'];
				$product_sale3 = $rw_pbmart_promotion['product_sale3'];
				$product_sale_percentage3 = $rw_pbmart_promotion['product_sale_percentage3'];

				$promotion_package_price = $rw_pbmart_promotion['promotion_package_price'];
				$product_qty = $_SESSION['product_qty'][$i];
				$product_price = $rw_pbmart_promotion['product_price'];
				$promotion_package_point = $rw_pbmart_promotion['promotion_package_point'];
				$promotion_package_point_ptrs = $rw_pbmart_promotion['promotion_package_point_ptrs'];
				$promotion_package_double_point = $rw_pbmart_promotion['promotion_package_double_point'];
				$promotion_category_id = $rw_pbmart_promotion['promotion_category_id'];
				
				if($promotion_package_double_point == '1')
				{
					$prm_unit_points = $promotion_package_point * 2;
				}else
				{
					if($promotion_product_category_id =='1')
					{
						$prm_unit_points = ($promotion_package_point_ptrs * $nbr_petronas) + ($promotion_package_point * $nbr_mygaz);
					}else
					{
						$prm_unit_points = 0;
					}
				}
				
				$total_point_reward = $total_point_reward + $prm_unit_points;
				
				$item_price = $rw_pbmart_promotion['item_price'];
				$promotion_product_price = $rw_pbmart_promotion['promotion_product_price'];
				$promotion_unit_price = $promotion_product_price + $item_price;
				
				$discount = cal_discount($promotion_package_price, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2,$product_sale3, $product_sale_percentage3);
				$cd_subtotals = cal_price($promotion_unit_price, $total_handling_charge, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
				
				$promotion_handling_charge = $product_price - $promotion_product_price;
				$display_others = $display_others + ($promotion_handling_charge * $product_qty);
				
				//flat handling
				if($promotion_category_id == '1' || $promotion_category_id == '3' || $promotion_category_id == '4' || $promotion_category_id == '5' || $promotion_category_id == '6' || $promotion_category_id == '7' || $promotion_category_id == '8')
				{
					$total_flat_handling = $total_flat_handling + ($product_qty * $member_flat_floor);
				}else
				{
					$total_flat_handling = $total_flat_handling + 0;
				}
		?>
			<tr>
				<td colspan="2"><font size='2'color='black'><b><?php echo $promotion_package_name.'('.$product_name.' + '.$item_name.')'; ?></b></font></td>
				<td colspan="3" align="center">RM <?php echo number_format($promotion_unit_price,2); ?></td>
				<td colspan="1" align="center"><?php echo $product_qty; ?></td>
				<!--<td align="center"><?php echo $discount; ?></td>-->
				<td align="right"><font size='2'color='black'><b>RM <?php echo number_format($cd_subtotals,2); ?></b></font></td>
			</tr>
			<?php
			}else
			{
				$total_handling_charge = '0';
				$prd_points_petronas = '0';
				$prd_points_mygaz = '0';
				
				$sql_pbmart_product = "Select * FROM pbmart_product WHERE product_id='$product_id'";
				$rs_pbmart_product = @mysql_query($sql_pbmart_product, $link);
				$rw_pbmart_product = @mysql_fetch_array($rs_pbmart_product);
				
				$product_name = $rw_pbmart_product['product_name'];
				$product_category_id = $rw_pbmart_product['product_category_id'];
				$product_model = $rw_pbmart_product['product_model'];
				$product_qty = $_SESSION['product_qty'][$i];
				
				$product_handling = $rw_pbmart_product['product_handling'];
				$product_commercial_handling = $rw_pbmart_product['product_commercial_handling'];
				$product_commercial_handling2 = $rw_pbmart_product['product_commercial_handling2'];
				
				$product_handling_show = $rw_pbmart_product['product_handling_show'];
				$product_commercial_handling_show = $rw_pbmart_product['product_commercial_handling_show'];
				$product_commercial_handling_show2 = $rw_pbmart_product['product_commercial_handling_show2'];
				
				$product_point = $rw_pbmart_product['product_point'];
				$product_commercial_point = $rw_pbmart_product['product_commercial_point'];
				$product_commercial_point2 = $rw_pbmart_product['product_commercial_point2'];
				
				$product_point_ptrs = $rw_pbmart_product['product_point_ptrs'];
				$product_commercial_point_ptrs = $rw_pbmart_product['product_commercial_point_ptrs'];
				$product_commercial_point2_ptrs = $rw_pbmart_product['product_commercial_point2_ptrs'];
				
				$product_double_point = $rw_pbmart_product['product_double_point'];
				$product_commercial_double_point = $rw_pbmart_product['product_commercial_double_point'];
				$product_commercial_double_point2 = $rw_pbmart_product['product_commercial_double_point2'];
				
				//access category of product_sale and product_sale_percentage
				$product_sale1 = $rw_pbmart_product['product_sale1'];
				$product_sale_percentage1 = $rw_pbmart_product['product_sale_percentage1'];
							
				$product_sale2 = $rw_pbmart_product['product_sale2'];
				$product_sale_percentage2 = $rw_pbmart_product['product_sale_percentage2'];
							
				$product_sale3 = $rw_pbmart_product['product_sale3'];
				$product_sale_percentage3 = $rw_pbmart_product['product_sale_percentage3'];
							
				$product_price = $rw_pbmart_product['product_price'];
				$product_commercial_price = $rw_pbmart_product['product_commercial_price'];
				$product_commercial_price2 = $rw_pbmart_product['product_commercial_price2'];
				
				
				$product_unit_price = $product_price;
				
				//price checking here...
				if($member_commercial_status == '0')
				{
					if($product_handling_show == '0')
					{
						$product_unit_price = $product_price + $product_handling;
						$display_others = $display_others + 0;
						$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
					}else
					{
						$product_unit_price = $product_price;
						$display_others = $display_others + ($product_handling * $product_qty);
						$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty); //calculate total handling charge
					}
					
					//point checking
					if($product_double_point == '1')
					{
						$prd_points = $product_point * 2;
					}else
					{
						$prd_points = $product_point;
					}
					
					$total_point_reward = $total_point_reward + ($prd_points * $product_qty); //calculate total award product point
				
				}else if($member_commercial_status =='1')
				{
					if($member_commercial_class == '1')
					{
						if($product_commercial_handling_show == '0')
						{
							$product_unit_price = $product_commercial_price + $product_commercial_handling;
							$display_others = $display_others + 0;
							$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
						}else
						{
							$product_unit_price = $product_commercial_price;
							$display_others = $display_others + ($product_commercial_handling * $product_qty);
							$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $product_qty); //calculate total handling charge
						}
						
						//point checking
						if($product_commercial_double_point == '1')
						{
							$prd_points = $product_commercial_point * 2;
						}else
						{
							if($product_id =='1' || $product_id =='3')
							{
								$prd_points_petronas = $product_commercial_point_ptrs;
								$prd_points_mygaz = $product_commercial_point;
							}else
							{
								$prd_points_mygaz = 0;
								$prd_points_petronas = 0;
								$prd_points = $product_point;
							}
						}
					}else if($member_commercial_class == '2')
					{
						if($product_commercial_handling_show2 == '0')
						{
							$product_unit_price = $product_commercial_price2 + $product_commercial_handling2;
							$display_others = $display_others + 0;
							$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
						}else
						{
							$product_unit_price = $product_commercial_price2;
							$display_others = $display_others + ($product_commercial_handling2 * $product_qty);
							$total_handling_charge = $total_handling_charge + ($product_commercial_handling2 * $product_qty); //calculate total handling charge
						}
						
						//point checking
						if($product_commercial_double_point2 == '1')
						{
							$prd_points = $product_commercial_point2 * 2;
						}else
						{
							if($product_id=='1' || $product_id=='3')
							{
								$prd_points_petronas = $product_commercial_point2_ptrs;
								$prd_points_mygaz = $product_commercial_point2;
							}else
							{
								$prd_points_petronas ='0';
								$prd_points_mygaz ='0';
								$prd_points = $product_point;
							}
						}
					}else
					{
						if($product_commercial_handling_show == '0')
						{
							$product_unit_price = $product_commercial_price + $product_commercial_handling;
							$display_others = $display_others + 0;
							$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
						}else
						{
							$product_unit_price = $product_commercial_price;
							$display_others = $display_others + ($product_commercial_handling * $product_qty);
							$total_handling_charge = $total_handling_charge + ($product_commercial_handling * $product_qty); //calculate total handling charge
						}
						
						//point checking
						if($product_commercial_double_point == '1')
						{
							$prd_points = $product_commercial_point * 2;
						}else
						{
							$prd_points = $product_commercial_point;
						}	
					}
					
					if($product_id == '1' || $product_id =='3')
					{
						$total_point_reward = $total_point_reward + (($prd_points_petronas + $commercial_additional_point) * $nbr_petronas) + (($prd_points_mygaz + $commercial_additional_point) * $nbr_mygaz);
					}else
					{	
						$total_point_reward = $total_point_reward + (($prd_points + $commercial_additional_point) * $product_qty);
					}
					
				}else
				{
					if($product_handling_show == '0')
					{
						$product_unit_price = $product_price + $product_handling;
						$display_others = $display_others + 0;
						$total_handling_charge = $total_handling_charge + 0; //calculate total handling charge
					}else
					{
						$product_unit_price = $product_price;
						$display_others = $display_others + ($product_handling * $product_qty);
						$total_handling_charge = $total_handling_charge + ($product_handling * $product_qty); //calculate total handling charge
					}
					
					//point checking
					if($product_double_point == '1')
					{
						$prd_points = $product_point * 2;
					}else
					{
						$prd_points = $product_point;
					}	
					$total_point_reward = $total_point_reward + ($prd_points * $product_qty); //calculate total award product point					
				}
				
				
				$cd_subtotals = cal_price($product_unit_price, '0', $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
				$discount = cal_discount($product_price, $product_qty, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
				
				//flat handling
				if($product_category_id == '1' || $product_category_id== '3')
				{
					if($product_model == 'Home Delivery')
					{
						$total_flat_handling = $total_flat_handling + ($product_qty * $member_flat_floor);
					}else
					{
						$total_flat_handling = $total_flat_handling;
					}
				}else
				{
					$total_flat_handling = $total_flat_handling + '0';
				}
		?>
			<tr>
				<td colspan="2"><font size='2'color='black'><b><?php echo $product_name.' '.$product_model; ?></b></font></td>
				<td colspan="3" align="center">RM <?php echo number_format($product_unit_price,2); ?></td>
				<td colspan="1" align="center"><?php echo $product_qty; ?></td>
				<!--<td align="center"><?php echo $discount; ?></td>-->
				<td align="right"><font size='2'color='black'><b>RM <?php echo number_format($cd_subtotals,2); ?></b></font></td>
			</tr>
	  <?php } ?>
  <?php } ?>
 <?php } ?>
	
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="6">
				<h2>Point Reward<font color='red'> **</font></h2>
				<hr style=" height:0;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);">
				</hr>
		</td>
		<td align="right">
		<?php 
			if(isset($card_subtotal) && isset($selected_time))
			{
				//display selected product point award only...
				echo $total_point_reward;
			}else
			{
				echo ('0');
			}
			?></td>
	</tr>
	
	<tr>
		<td colspan="6">
			
				<h2>Subtotal</h2>
				<hr style=" height: 0;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
		</td>
		<td align="right">RM <?php echo number_format($card_subtotal,2); ?></td>
	</tr>

	<tr>
		<td colspan="6">
				<h2>Others</h2>
				<hr style=" height: 0;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
		</td>
		<td align="right">RM <?php 
			$others = $display_others;
			echo number_format($others,2); ?></td>
	</tr>
	
	<tr>
		<td colspan="6">
			<h2>Flat Handling</h2>
			<hr style=" height: 0;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
		</td>
		<td align="right">RM <?php 
			if($flr_num == '0')
			{
				echo "0.00";
			}else
			{
				echo number_format($total_flat_handling ,2);
			}
			
			 ?></td>
	</tr>
	
	<tr>
		<td align='right' colspan="6">
				<h2><font size='3' color='black'>Totals</font></h2>
				<hr style=" height: 0;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
		</td>
		
		<td align="right">
			<h2>
				<font size='3' color='black'>
				RM
					<?php
					
						if($flr_num == '0')
						{
							$order_totals = $card_subtotal + $display_others;
						}else
						{
							$order_totals = $card_subtotal + $display_others + $total_flat_handling; 
						}
						echo number_format($order_totals,2);
					?>
				</font>
			</h2>
		</td>
	</tr>
	
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
</form>
	<tr>
		<td>
			<font color="FF0000" size='2'>
				<B>
					**NOTE: POINT REWARD IS CREDITED TO THE ACCOUNT AFTER DELIVERY IS MADE
				</B>
			</font>
		</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="7" >
			<strong>
				<font size="4">
					<div>
						<center>YOUR REDEEM</center>
						<hr/>
					</div>
				</font>
			</strong>
		</td>
	</tr>
	
	<tr>
		<td colspan='3'><b><h2>Products</h2></b></td>
		<td align='center' colspan='2'><b><h2>Points</h2></b></td>
		<td align='center'><b><h2>Quantity</h2></b></td>
		<td align='right'><b><h2>Total Points</h2></b></td>
	</tr>
	
	<tr>
		<td colspan='3'>&nbsp;</td>
		<td colspan='2'>&nbsp;</td>
		<td>&nbsp;</td>
		<td align='right'>&nbsp;</td>
	</tr>
	
	<?php
		$total_subpoint = '0';
		
		if(!isset($_SESSION['redeem_order_qty']))
		{
			$_SESSION['redeem_order_qty'] = '0';
		}
		
		for($x_value='0'; $x_value < $_SESSION['redeem_order_qty']; $x_value++)
		{
			$redeem_id = $_SESSION['redeem_id'][$x_value];
			
			$sql = "SELECT * FROM pbmart_redeem WHERE redeem_id ='$redeem_id'";
			$rs = @mysql_query($sql);
			$rw = @mysql_fetch_array($rs);
			
			$redeem_name = $rw['redeem_name'];
			$redeem_point = $rw['redeem_point'];
			$redeem_qty = $_SESSION['redeem_qty'][$x_value];
			$total_points = $redeem_qty * $redeem_point;
			$total_subpoint = $total_subpoint + $total_points;
		?>
			
			<tr>
				<td colspan='3'><font size='2' color='black'><b><?php echo $redeem_name; ?></b></font></td>
				<td align='center' colspan='2'><?php echo number_format($redeem_point); ?></td>
				<td align='center'><?php echo $redeem_qty;  ?></td>
				<td align='right'><font size='2' color='black'><b><?php echo number_format($total_points); ?></b></font></td>
			</tr>
		<?php } ?>

		<tr>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="6">
				
					<h2>Cart Subpoint</h2>
					<hr style=" height: 0;
					border-top: 1px solid rgba(0, 0, 0, 0.1);
					border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
			</td>
			<td align='right'><?php echo number_format($total_subpoint); ?></td>
		</tr>
		
		<tr>
			<td colspan="6">
				
					<h2>Accumulated Point</h2>
					<hr style=" height: 0;
					border-top: 1px solid rgba(0, 0, 0, 0.1);
					border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
			</td>
			<td align='right'><?php echo number_format($member_point); ?></td>
		</tr>
		
		<tr>
			<td colspan="6" align='right'>
				<h2><font size='3' color='black'>Remaining Point</font></h2>
				<hr style=" height: 0;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				border-bottom: 1px solid rgba(255, 255, 255, 0.3);"/>
			</td>
			<td align='right'>
				<h2><font size='3' color='black'>
				<?php echo number_format($member_point - $total_subpoint); ?>
				</font></h2>
			</td>
		</tr>
		
		<tr>
			<td colspan='7'>&nbsp;</td>
		</tr>
		
<form action="checkout.php" method="post">	
	<tr>
		<td colspan="7">
			<strong>
				<font size="4">
					Select Payment	
				</font>
			</strong>
		</td>
	</tr>
	
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>

	<tr>
	
	<?php
		//if($order_totals < 50)
		//{?>
			<td valign="center">
			<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cash On Delivery</font><BR><BR>
			&nbsp;&nbsp;
			<input type="radio" name="cash_on_delivery_rd" value="0" checked> <img src="icon/cash.png" width="140px" height="60px"></img></input>
		</td>
	<?php //} ?>
	
		<!--<td valign="top">
			 <font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Credit/Debit Card</u></font><BR><BR>
			&nbsp;&nbsp;
			<input type="radio" name="cash_on_delivery_rd" value="2"><img src="icon/VisaMasterCard.jpg" width="140px" height="40px"></img></input>
		</td>
		
		<td>
			<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Online Bank Transfer</u></font><BR><BR>
			&nbsp;&nbsp;
		
			<input type="radio" name="cash_on_delivery_rd" value="6"> <img src="icon/maybank2u.jpg" width="160px" height="60px"></img></input>
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="8"> <img src="icon/alliance-bank-logo.png" width="160px" height="60px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="10"> <img src="icon/AmBank-Group-logo.gif" width="160px" height="60px"></img></input>
			
			<BR><BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="14"> <img src="icon/RHB.png" width="160px" height="45px"></img></input>	
		
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="15"> <img src="icon/HongLeongConnect.png" width="160px" height="60px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="16"> <img src="icon/FPX.png" width="160px" height="40px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="20"> <img src="icon/cimb-clicks.jpg" width="150px" height="50px"></img></input>
			
			<BR>
			&nbsp;&nbsp;&nbsp;<input type="radio" name="cash_on_delivery_rd" value="103"> <img src="icon/affin-bank-logo.jpg" width="150px" height="50px"></img></input>
		</td>-->
	</tr>

	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="7" align="right">
			<span class="bg">
				<input type="submit" value="Place your order" onclick="return confirm('Are you sure to place order?')" title="Click to place your order"></input>
				
				<input type="hidden" name="act" value="add"></input>
				
				<input type="hidden" name="member_id" value="<?php echo $member_id; ?>"></input>
				<input type="hidden" name="member_point" value="<?php echo $member_point; ?>"></input>
				<input type="hidden" name="total_point_reward" value="<?php echo $total_point_reward; ?>"></input>
				
				<input type="hidden" name="shp_time" value="<?php echo $selected_time; ?>"></input>
				<input type="hidden" name="shp_date" value="<?php echo $selected_date; ?>"></input>
				
				<input type="hidden" name="first_name" value="<?php echo $member_first_name; ?>"></input>
				<input type="hidden" name="last_name" value="<?php echo $member_last_name; ?>"></input>
				<input type="hidden" name="user_email" value="<?php echo $member_email; ?>"></input>
				<input type="hidden" name="tel" value="<?php echo $member_telephone; ?>"></input>
				<input type="hidden" name="mobile" value="<?php echo $member_contact; ?>"></input>
				
				<input type="hidden" name="street_name" value="<?php echo $member_street_name; ?>"></input>
				<input type="hidden" name="dlvy_type" value="<?php echo $dlvy_type; ?>"></input>
				<input type="hidden" name="flr_num" value="<?php echo $member_flat_floor; ?>"></input>
				<input type="hidden" name="city" value="<?php echo $member_city; ?>"></input>
				<input type="hidden" name="region_state" value="<?php echo $member_state; ?>"></input>
				<input type="hidden" name="country" value="<?php echo $member_country; ?>"></input>
				<input type="hidden" name="pst_code" value="<?php echo $member_postcode; ?>"></input>
				
				<input type="hidden" name="sub_total" value="<?php echo $order_totals; ?>"></input>
				<input type="hidden" name="total_handling_charge" value="<?php echo $display_others; ?>"></input>
				<input type="hidden" name="total_flat_handling" value="<?php echo $total_flat_handling; ?>"></input>
				
				<input type="hidden" name="chk_tnc" value="<?php echo $chk_tnc; ?>"></input>
				<input type="hidden" name="nbr_mygaz" value="<?php echo $nbr_mygaz; ?>"></input>
				<input type="hidden" name="nbr_petronas" value="<?php echo $nbr_petronas; ?>"></input>
				<input type="hidden" name="total_exchange_gas" value="<?php echo $total_exchange_gas; ?>"></input>
				<input type="hidden" name="order_remark" value="<?php echo $order_remark; ?>"></input>
			</span>
		</td>
	</tr>
</form>

	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
</table>

<?php
function cal_price($prd_price, $tl_handling_charge, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
{
	if($prd_qty >= '1' && $prd_qty < $prd_sales1)
	{
		$prd_sales_percentage = '0';
	}else if($prd_qty >= $prd_sales1 && $prd_qty < $prd_sales2)
	{
		$prd_sales_percentage = $prd_sales_percentage1;
	}else if($prd_qty >= $prd_sales2 && $prd_qty < $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage2;
	}else if($prd_qty >= $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage3;
	}else
	{
		echo ('Internal Error! Please contact webmaster to fix the issue!');
		exit;
	}

	$tl_price = $prd_price * $prd_qty;
	$discount = ($tl_price * $prd_sales_percentage)/100;
	//return ($tl_price - $discount) + $tl_handling_charge;
	return $tl_price + $tl_handling_charge;
	//return $prd_sales_percentage;
}

function cal_discount($prd_price, $prd_qty, $prd_sales1, $prd_sales_percentage1, $prd_sales2, $prd_sales_percentage2, $prd_sales3, $prd_sales_percentage3)
{
	if($prd_qty >= '1' && $prd_qty < $prd_sales1)
	{
		$prd_sales_percentage = '0';
	}else if($prd_qty >= $prd_sales1 && $prd_qty < $prd_sales2)
	{
		$prd_sales_percentage = $prd_sales_percentage1;
	}else if($prd_qty >= $prd_sales2 && $prd_qty < $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage2;
	}else if($prd_qty >= $prd_sales3)
	{
		$prd_sales_percentage = $prd_sales_percentage3;
	}else
	{
		echo ('Internal Error! Please contact webmaster to fix the issue!');
		exit;
	}

	$tl_price = $prd_price * $prd_qty;
	$discount = ($tl_price * $prd_sales_percentage)/100;
	//return $tl_price - $discount;
	return $prd_sales_percentage;
}

//a function use to calculate award point based on the shipping time
function cal_point($total_price, $std_time)
{
	include("connection/pbmartconnection.php");
	$tl_prices = (INT)$total_price;
	$sql_point = "SELECT point_rate1, point_rate2, point_rate3 FROM pbmart_point";
	$rs_point = @mysql_query($sql_point, $link);
	$rw_point = @mysql_fetch_array($rs_point);
	
	$point_rate1 = $rw_point['point_rate1'];
	$point_rate2 = $rw_point['point_rate2'];
	$point_rate3 = $rw_point['point_rate3'];
	
	if($std_time == 2)
	{
		$usr_point = $tl_prices * $point_rate1;
	}else if($std_time == 1)
	{
		$usr_point = $tl_prices * $point_rate2;
	}else if($std_time == 3)
	{
		$usr_point = $tl_prices * $point_rate3;
	}else
	{
		$usr_point = "0";
	}
	return (INT)$usr_point;
}

?>
<style>
td { height: 100%;}
.bg { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }

td { height: 100%;}
.bg2 { background-color: #7f7f7f; color:#fff; width: 100%; height: 100%; display: block; }
</style>

<?php include('footer.php'); ?>