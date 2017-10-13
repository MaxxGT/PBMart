<?php
//manage the redemption order here...
				if($_SESSION['redeem_order_qty'] !='0')
				{
					$total_remain_point = '0';
					$redemption = @mysql_query("SELECT MAX(redemption_id) FROM pbmart_redemption_list", $link);
					$redemption_count = @mysql_fetch_row($redemption);
					$rdm_ids = $redemption_count[0];
					$sql_redemption_num = @mysql_query("SELECT redemption_id, redemption_number FROM pbmart_redemption_list WHERE redemption_id='$rdm_ids'", $link);
					$rs_redemption_num = @mysql_fetch_assoc($sql_redemption_num);
					$redeem_no = $rs_redemption_num['redemption_number'];
					if($redeem_no == "")
					{
						$redeem_no = "RE000000";
					}else
					{
						$rdm_no = explode("RE", $redeem_no);
						$redeem_no = $rdm_no[1] + 1; 
						$redeem_no = 'RE'.str_pad($redeem_no, 6, '0', STR_PAD_LEFT);
					}
					
					for($x_value='0'; $x_value < $_SESSION['redeem_order_qty']; $x_value++)
					{
						$table_name_redeem = "pbmart_redemption_list";
						$redeem_id = $_SESSION['redeem_id'][$x_value];
						$sql = "SELECT * FROM pbmart_redeem WHERE redeem_id ='$redeem_id'";
						$rs = @mysql_query($sql);
						$rw = @mysql_fetch_array($rs);
						
						$redeem_name = $rw['redeem_name'];
						$redeem_model = $rw['redeem_model'];
						$redemption_status = '0';

						$redemption_order_ref = $order_num;
						$redemption_member_id = $_SESSION['usr_id'];
						$redemption_member_name = $_SESSION['usr_name'];
						$redemption_member_address = $street_name.", ".$pst_code.", ".$city.", ".$region_state.", ".$country;
						$redemption_item_id = $redeem_id;
						$redemption_item = $redeem_name.' - '.$redeem_model;
						$redemption_image = $rw['redeem_image'];
						$redemption_amount = $_SESSION['redeem_qty'][$x_value];
						
						$redeem_point = $rw['redeem_point'];
						$redeem_stock = $rw['redeem_stock'];
						$redemption_token = $rw['redeem_token'];
						$redemption_points = $redeem_point;
						
						$sql_redemption = "INSERT INTO $table_name_redeem(redemption_number, redemption_date, redemption_time, redemption_delivery_date, redemption_order_ref, redemption_member_id, redemption_member_name, redemption_member_address, redemption_item_id, redemption_item, redemption_amount, redemption_points, redemption_token, redemption_status)
						VALUES ('$redeem_no','$order_date','$order_date_time','$shp_date','$redemption_order_ref','$redemption_member_id','$redemption_member_name','$redemption_member_address','$redemption_item_id','$redemption_item', '$redemption_amount', '$redemption_points', '$redemption_token', '$redemption_status')";

						$result4 = @mysql_query($sql_redemption);
						
						if(!$result4)
						{
							echo ("Failed to create $table_name_redeem. DEBUG: .$sql_redemption");
						}else
						{
							//update the redeem product(remaining stock)
							$total_point = $redeem_point * $redemption_amount;
							$total_remain_point = $total_remain_point + $total_point;
							
							$remain_stock = $redeem_stock - $redemption_amount;
							
								$redeem_product_stock = get_rdm_stock($redeem_id);
								if($redeem_product_stock == '0' || $redeem_product_stock < '0')
								{	
									$message = "Error! Please try again later! Thank you!";
									rdm_ord_del($redeem_no, $redemption_order_ref);
									//delete product or promotion order if order_qty is not empty
									if(!empty($_SESSION['order_qty']))
									{
										ord_del($order_num, $order_customer_id);
									}
									echo "<script type='text/javascript'>alert('$message');</script>";
									echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
									exit;
								}
									if($remain_stock < '0')
									{
										$message = "Error! Please try again later! Thank you!";
										rdm_ord_del($redeem_no, $redemption_order_ref);
										//delete product or promotion order if order_qty is not empty
										if(!empty($_SESSION['order_qty']))
										{
											ord_del($order_num, $order_customer_id);
										}
										echo "<script type='text/javascript'>alert('$message');</script>";
										echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
										exit;
									}else
									{
										//update stock for redeem product
										$query_upd_redeem="UPDATE pbmart_redeem
													SET
														redeem_stock = '$remain_stock'
														WHERE redeem_id = '$redeem_id'";
										$result_upd_redeem = @mysql_query($query_upd_redeem);
										
										if(!$result_upd_redeem)
										{
											echo ("Failed to update table. DEBUG: .$query_upd_redeem");
										}
									}
						}
					}
							$remain_point = $member_point - $total_remain_point;
							valid_point($remain_point);
							//update point for member
							$query_upd_member="UPDATE pbmart_member
										SET
											member_point = '$remain_point'
											WHERE member_id = '$order_customer_id'";
							$result_upd_member = @mysql_query($query_upd_member);
							
							if(!$result_upd_member)
							{
								echo ("Failed to update table. DEBUG: .$query_upd_member");
							}
				}	
?>