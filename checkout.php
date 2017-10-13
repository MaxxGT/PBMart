<?php
// Author: VOONG TZE HOWE
// Date Writen: 01-10-2016
// Description : checkout.php
// Last Modification:

include('session_config.php');
include("connection/pbmartconnection.php");
include("checkout_fnc.php");
get_UsrInfo();
GLOBAL $member_commercial_status;

if(isset($_REQUEST['act'])){
	$act = $_REQUEST['act'];
}

if($act == 'add'){
	
include('checkout_getData.php');

$order_handling = (isset($_REQUEST['total_handling_charge']) ? $_REQUEST['total_handling_charge'] : '');
$total_flat_handling = '0';
$total_flat_handling = (isset($_REQUEST['total_flat_handling']) ? $_REQUEST['total_flat_handling'] : '');

$table_name = "pbmart_order";
$odr_cst_id = $_SESSION['usr_id'];

//get latest order number and convert to new order num
$sql_orders = "SELECT MAX(order_id) AS odr_id FROM pbmart_order";
$rs_orders = mysql_query($sql_orders, $link);
$rw_orders = @mysql_fetch_assoc($rs_orders);
$odr_id = $rw_orders['odr_id']; 

$sql_orders2 = mysql_query("SELECT order_id, order_number FROM pbmart_order WHERE order_id = '$odr_id'");
$rw_orders2 = @mysql_fetch_assoc($sql_orders2);
$odr_num2 = $rw_orders2['order_number'];

$order_num = "";

if($odr_num2 == "")
{
	$odr_num2 = "OR000001";
	$order_num = "OR000001";
}else
{
	$orders_number = explode("OR", $odr_num2);
	$f_orders_num = $orders_number[1] + 1;
	$order_num = 'OR'.str_pad($f_orders_num, 6, '0', STR_PAD_LEFT);

	//check for order number existing
	$sql_odr_num = mysql_query("SELECT order_number FROM pbmart_order WHERE order_number = '$order_num'");
	$odr_count = @mysql_num_rows($sql_odr_num);
	if($odr_count !='0')
	{
		$message = "Error! Please try again later! Thank you!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
}
$order_total_point = $total_point_reward;
$order_amount = $_POST['sub_total'];
$order_date = date("Y-m-d");
$order_date_time = get_currentTime();
$order_delivery = $shp_date;
$order_customer_name = $_SESSION['usr_name'];
$order_customer_id = $_SESSION['usr_id'];
//order_validate($order_customer_id);

$order_payment_status = "0";
$order_status = "0";

$order_customer_address = $street_name.", ".$pst_code." ".$city.", ".$region_state.", ".$country;

		//update client informations
		$query_member_update = "UPDATE pbmart_member
									SET
										member_first_name='$first_name',
										member_last_name='$last_name',
										member_email='$user_email',
										member_telephone='$tel',
										member_contact='$mobile',
										member_street_name='$street_name',
										member_flat_status = '$dlvy_type',
										member_flat_floor='$flr_num',
										member_postcode='$pst_code',
										member_city='$city',
										member_state='$region_state',
										member_country='$country'
									WHERE member_id='$order_customer_id'";
									
		$member_update = @mysql_query($query_member_update);
		
		if($member_update)
		{
			//update session usr_name
			$usr_name = $first_name.' '.$last_name;
			$_SESSION['usr_name'] = $usr_name;
			$order_payment_type = cvrt_paymentType($odr_payment_type);
			if($order_payment_type== 'Cash')
			{
				$ePaymentStatus = '0';
			}else
			{
				$ePaymentStatus = '1';
			}
				
			$sql_pbmart_order = "INSERT INTO pbmart_order
			(order_number,order_amount,flat_handling,order_handling,order_date,order_time_date,order_delivery,order_time,order_customer_id,order_customer_name, order_customer_telephone, order_customer_contact, order_customer_address, order_payment_type, order_payment_status, order_total_point, order_status, order_remark, order_mygaz_amount, order_petronas_amount, ePaymentStatus)

			VALUES ('$order_num','$order_amount','$total_flat_handling','$order_handling','$order_date','$order_date_time','$order_delivery','$shp_time','$order_customer_id','$order_customer_name','$mobile','$mobile','$order_customer_address','$order_payment_type','$order_payment_status','$order_total_point','$order_status','$order_remark','$nbr_mygaz','$nbr_petronas','$ePaymentStatus')";

			$result = @mysql_query($sql_pbmart_order);    

			if($result)
			{	
				$total_handling_charge = '0';
				
				if(!empty($_SESSION['order_qty']))
				{
					for($i=0; $i<$_SESSION['order_qty']; $i++)
					{
						$product_id = $_SESSION['product_id'][$i];
						
						//if selected product is package, then...
						if(strpos($product_id, 'PKG_') !== false)
						{
							//gas order type
							if(isset($_SESSION['odr_gas_type'][$i]))
							{
								$odr_gas_type = $_SESSION['odr_gas_type'][$i];
							}
							
							$product_ids = explode("PKG_", $product_id);
							$product_ids2 = $product_ids[1];
							
							$sql_pbmart_product = "Select 
													promotion_package_name,
													promotion_product_name AS prd_name,
													promotion_product_model,
													promotion_item_name AS itm_name,
													promotion_item_model AS itm_model,
													promotion_package_price,
													promotion_package_point,
													promotion_package_point_ptrs,
													promotion_package_double_point,
													promotion_product_price AS prd_price,
													promotion_product_sale,
													promotion_item_price AS itm_price,
													promotion_item_sale,
													promotion_package_stock AS product_stock,
													'0' AS product_sale1,
													'0' AS product_sale_percentage1,
													'0' AS product_sale2,
													'0' AS product_sale_percentage2,
													'0' AS product_sale3,
													'0' AS product_sale_percentage3,
													promotion_category_id,
													promotion_package_sale
													
							FROM pbmart_promotion WHERE promotion_id = '$product_ids2'";
							$rs = mysql_query($sql_pbmart_product, $link);
							$rw2 = mysql_fetch_array($rs);
							
							$order_product_class = "Promotion";
							$promotion_package_name = $rw2['promotion_package_name'];
							$prd_name = $rw2['prd_name'];
							$promotion_product_model = $rw2['promotion_product_model'];
							$itm_name = $rw2['itm_name'];
							$itm_model = $rw2['itm_model'];
							$promotion_package_price = $rw2['promotion_package_price'];
							$promotion_package_point = $rw2['promotion_package_point'];
							$promotion_package_point_ptrs = $rw2['promotion_package_point_ptrs'];
							$promotion_package_double_point = $rw2['promotion_package_double_point'];
							
							if($promotion_package_double_point =='1')
							{
								$prm_unit_points = $promotion_package_point * 2;
							}else
							{
								$prm_unit_points = $promotion_package_point;
							}
							
							
							$prd_price = $rw2['prd_price'];
							$promotion_product_sale = $rw2['promotion_product_sale'];
							$promotion_product_handling = $promotion_product_sale - $prd_price;
							$itm_price = $rw2['itm_price'];
							$promotion_item_sale = $rw2['promotion_item_sale'];
							$promotion_unit_price = $prd_price;
							
							
							
							$product_stock = $rw2['product_stock'];
							$promotion_category_id = $rw2['promotion_category_id'];
							$promotion_package_sale = $rw2['promotion_package_sale'];
							
							$product_name_gas = $promotion_package_name.' '.$prd_name;
							$product_name_item = $promotion_package_name.' '.$itm_name;
							$product_price = $promotion_package_price;
							
							//access category of product_sale and product_sale_percentage
							$product_sale1 = $rw2['product_sale1'];
							$product_sale_percentage1 = $rw2['product_sale_percentage1'];
							$product_sale2 = $rw2['product_sale2'];
							$product_sale_percentage2 = $rw2['product_sale_percentage2'];
							$product_sale3 = $rw2['product_sale3'];
							$product_sale_percentage3 = $rw2['product_sale_percentage3'];
							
							
							$pro_amount = $_SESSION['product_qty'][$i];
							$remain_pro = $product_stock - $pro_amount;
							$total_product_sale = $promotion_package_sale + $_SESSION['product_qty'][$i];
							
							$product_sale_percentage = cal_prd_sales($product_price, $pro_amount, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
							
							//flat handling
							if($promotion_category_id == '1' || $promotion_category_id == '3' || $promotion_category_id == '4' || $promotion_category_id == '5' || $promotion_category_id == '6' || $promotion_category_id == '7' || $promotion_category_id == '8')
							{
								$total_flat_handling = $total_flat_handling + ($pro_amount * $member_flat_floor);
							}else
							{
								$total_flat_handling = $total_flat_handling + 0;
							}
							
							$sql_gas = "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_class, order_product_name, order_product_model, order_product_price, order_product_handling, order_product_point, order_product_sale, order_product_amount)
							VALUES('$order_num', '$product_ids2', '$order_product_class', '$product_name_gas', '$promotion_product_model', '$promotion_unit_price', '$promotion_product_handling', '$prm_unit_points', '$product_sale_percentage', '$pro_amount')";
							
							$result_gas = @mysql_query($sql_gas);
							if(!$result_gas)
							{
								echo $sql_gas;
								echo ("Failed to create $sql_gas record");
							}
							
							$sql_item = "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_class, order_product_name, order_product_model, order_product_price, order_product_handling, order_product_point, order_product_sale, order_product_amount)

							VALUES ('$order_num', '$product_ids2', '$order_product_class', '$product_name_item', '$itm_model', '$promotion_item_sale', '', '', '$product_sale_percentage', '$pro_amount')";

							$result2 = @mysql_query($sql_item);
							if(!$result2)
							{
								echo $sql;
								echo ("Failed to create $sql_item record");
							}
							
							if($order_payment_type == "Cash")
							{
								$prd_pkg_stock = pkg_validations($product_ids2);
								if($prd_pkg_stock == '0' || $prd_pkg_stock < '0')
								{
									$message = "Error! Please try again later! Thank you!";
									ord_del($order_num, $order_customer_id);
									echo "<script type='text/javascript'>alert('$message');</script>";
									echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
									exit;
								}
								
									if($remain_pro < '0')
									{
										$message = "Error! Please try again later! Thank you!";
										ord_del($order_num, $order_customer_id);
										echo "<script type='text/javascript'>alert('$message');</script>";
										echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
										exit;
									}else
									{
										$query="UPDATE pbmart_promotion
										SET
											promotion_package_stock = '$remain_pro',
											promotion_package_sale = '$total_product_sale'
											WHERE promotion_id = '$product_ids2'";
										$result3 = @mysql_query($query);
										if(!$result3)
										{
											echo ("Failed to update table. DEBUG: .$query");
										}
									}
							}
						}else
						{
							$total_handling_charge = '0';
							$product_unit_price = '0';
							
							//for unit package product
							$sql_pbmart_product = "SELECT * FROM pbmart_product WHERE product_id = '$product_id'";
							$rs = @mysql_query($sql_pbmart_product, $link);
							$rw2 = @mysql_fetch_array($rs);
							$order_product_class = 'Product';
							$product_name = $rw2['product_name'];
							$product_category_id = $rw2['product_category_id'];
							$product_model = $rw2['product_model'];
							$product_price = $rw2['product_price'];
							$product_commercial_price = $rw2['product_commercial_price'];
							$product_commercial_price2 = $rw2['product_commercial_price2'];
							$product_handling = $rw2['product_handling'];
							$product_handling_show = $rw2['product_handling_show'];
							$product_commercial_handling = $rw2['product_commercial_handling'];
							$product_commercial_handling2 = $rw2['product_commercial_handling2'];
							$product_commercial_handling_show = $rw2['product_commercial_handling_show'];
							$product_commercial_handling_show2 = $rw2['product_commercial_handling_show2'];
							
							$product_point = $rw2['product_point'];
							$product_commercial_point = $rw2['product_commercial_point'];
							$product_commercial_point2 = $rw2['product_commercial_point2'];
							
							$product_double_point = $rw2['product_double_point'];
							$product_commercial_double_point = $rw2['product_commercial_double_point'];
							$product_commercial_double_point2 = $rw2['product_commercial_double_point2'];
							
							$product_stock = $rw2['product_stock'];
							$product_sale = $rw2['product_sale'];
							
							//access category of product_sale and product_sale_percentage
							$product_sale1 = $rw2['product_sale1'];
							$product_sale_percentage1 = $rw2['product_sale_percentage1'];
							$product_sale2 = $rw2['product_sale2'];
							$product_sale_percentage2 = $rw2['product_sale_percentage2'];
							$product_sale3 = $rw2['product_sale3'];
							$product_sale_percentage3 = $rw2['product_sale_percentage3'];
							
							$pro_amount = $_SESSION['product_qty'][$i];
							$remain_pro = $product_stock - $pro_amount;
							$total_product_sale = $product_sale + $_SESSION['product_qty'][$i];
							
							//price checking here...
							if($member_commercial_status == '0')
							{
								if($product_handling_show == '0')
								{
									$product_unit_price = $product_price + $product_handling;
									$total_handling_charge = '0';
								}else
								{
									$product_unit_price = $product_price;
									$total_handling_charge = $total_handling_charge + $product_handling;
								}
								//point checking for double point
								if($product_double_point == '1')
								{
									$prd_points = $product_point * 2;
									//$prd_points = $product_point;
								}else
								{
									$prd_points = $product_point;
								}
							}else if($member_commercial_status == '1')
							{
								
								if($member_commercial_class == '1')
								{
									if($product_commercial_handling_show == '0')
									{
										$product_unit_price = $product_commercial_price + $product_commercial_handling;
										$total_handling_charge = '0';
									}else
									{
										$product_unit_price = $product_commercial_price;
										$total_handling_charge = $total_handling_charge + $product_commercial_handling;
									}
									//point checking for double point
									if($product_commercial_double_point == '1')
									{
										$prd_points = $product_commercial_point * 2;
										//$prd_points = $product_commercial_point;
									}else
									{
										$prd_points = $product_commercial_point;
									}
								}else if($member_commercial_class == '2')
								{
									if($product_commercial_handling_show2 == '0')
									{
										$product_unit_price = $product_commercial_price2 + $product_commercial_handling2;
										$total_handling_charge = '0';
									}else
									{
										$product_unit_price = $product_commercial_price2;
										$total_handling_charge = $total_handling_charge + $product_commercial_handling2;
									}
									//point checking for double point
									if($product_commercial_double_point2 == '1')
									{
										$prd_points = $product_commercial_point * 2;
										//$prd_points = $product_commercial_point2;
									}else
									{
										$prd_points = $product_commercial_point2;
									}
								}else
								{
									if($product_commercial_handling_show == '0')
									{
										$product_unit_price = $product_commercial_price + $product_commercial_handling;
										$total_handling_charge = '0';
									}else
									{
										$product_unit_price = $product_commercial_price;
										$total_handling_charge = $total_handling_charge + $product_commercial_handling;
									}
									//point checking for double point
									if($product_commercial_double_point == '1')
									{
										$prd_points = $product_commercial_point * 2;
										//$prd_points = $product_commercial_point;
									}else
									{
										$prd_points = $product_commercial_point;
									}
								}
								
								if($product_id =='1')
								{
									$prd_points = $prd_points + $commercial_additional_point;
								}
							}else
							{
								if($product_handling_show == '0')
								{
									$product_unit_price = $product_price + $product_handling;
									$total_handling_charge = '0';
								}else
								{
									$product_unit_price = $product_price;
									$total_handling_charge = $total_handling_charge + $product_handling;
								}
								if($product_double_point == '1')
								{
									$prd_points = $product_point * 2;
									//$prd_points = $product_point;
								}else
								{
									$prd_points = $product_point;
								}
							}
							
							//flat handling
							if($product_category_id == '1' || $product_category_id== '3')
							{
								$total_flat_handling = $total_flat_handling + ($pro_amount * $member_flat_floor);
							}else
							{
								$total_flat_handling = $total_flat_handling + '0';
							}

							$product_sale_percentage = cal_prd_sales($product_unit_price, $pro_amount, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3);
							
							$sql2 = "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_class, order_product_name, order_product_model, order_product_price, order_product_handling, order_product_point, order_product_sale, order_product_amount)

							VALUES ('$order_num', '$product_id', '$order_product_class', '$product_name', '$product_model', '$product_unit_price', '$total_handling_charge', '$prd_points', '$product_sale_percentage', '$pro_amount')";

							$result2 = @mysql_query($sql2);
							if(!$result2)
							{
								echo $sql;
								echo ("Failed to create $table_name record");
							}
							
							//handling product stock verification
							if($order_payment_type == "Cash")
							{
								
								$prd_stk_stock = prd_validations($product_id);
								if($prd_stk_stock == '0' || $prd_stk_stock < '0')
								{	
									
									$message = "Error! Please try again later! Thank you!";
									ord_del($order_num, $order_customer_id);
									echo "<script type='text/javascript'>alert('$message');</script>";
									echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
									exit;
								}
									if($remain_pro < '0')
									{
										$message = "Error! Please try again later! Thank you!";
										ord_del($order_num, $order_customer_id);
										echo "<script type='text/javascript'>alert('$message');</script>";
										echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
										exit;
									}else
									{
										$query="UPDATE pbmart_product
										SET
											product_sale = '$total_product_sale',
											product_stock = '$remain_pro'
											WHERE product_id = '$product_id'";
										$result3 = @mysql_query($query);
										if(!$result3)
										{
											echo ("Failed to update table. DEBUG: .$query");
										}
									}
							}
						} 
					}
				}

				//redemption code
				include('checkout_redemption.php');
				
				if(isset($result3))
				{
					if($order_payment_type == "Cash")
					{
						echo "<script type='text/javascript'>alert('Thanks for your orders! An Order Confirmation email has been send to your mail! Please check your mail thanks!');</script>";
						echo "<script>window.top.location ='PHPMailer-master/send_mail_receipt.php?order_num=$order_num';</script>";
					}	
				}else
				{
					if($order_payment_type == "Cash")
					{
						echo "<script type='text/javascript'>alert('Thanks for your orders! An Order Confirmation email has been send to your mail! Please check your mail thanks!');</script>";
						echo "<script>window.top.location ='PHPMailer-master/send_mail_receipt.php?order_num=$order_num';</script>";
					}
				}
			}else{
				echo $sql;
				echo ("Failed to create $table_name record");
			}
		}else
		{
			echo ("Failed to update table. DEBUG: .$member_update");
		}
}
?>