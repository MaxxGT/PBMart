<?php
include("connection/pbmartconnection.php");
include('cmanage/report/check_orders_error.php');
include('class/product.php');

function get_currentDateTime()
{
	date_default_timezone_set('Asia/Kuching'); // CDT

	$crt_date = new DateTime();
	
	$info = getdate();
	$date = $info['mday'];
	$month = $info['mon'];
	$year = $info['year'];
	$hour = $info['hours'];
	$min = $info['minutes'];
	$sec = $info['seconds'];

	$crt_date->setDate($year, $month, $date);
	
	$current_date = $crt_date->format('Y-m-d');
	return $current_date;
}
$crnt_date = get_currentDateTime();

$date = $crnt_date;
$newdate = strtotime ( '+1 day' , strtotime ( $date ) ) ;
$tmr_date = date ( 'Y-m-j' , $newdate );

$display_date_tmr = new DateTime($tmr_date);
?>

<link rel="stylesheet" type="text/css" href="css/order_manage.css" />
<html>
	<head>
		<title>PBMART ORDER MANAGEMENT</title>
	</head>
	<body>
		<h1>PBMART ORDER MANAGEMENT</h1>
					<table border='0' style="border: 1px solid black; border-collapse: collapse;">
						<thead>
						<tr>
							<td colspan='4'>
								<font size='4'><B>TODAY ORDERS</B></font>
							</td>
							<td>
								<center>
									<font size='4'><B><?php echo date("d-m-Y"); ?></B></font>
								</center>
							</td>
						</tr>
						<tr>
							<th><B>No.</B></th>
							<th><B>Order Number</B></th>
							<th><B>Customer Name</B></th>
							<th><B>Company Name</B></th>
							<th><B>Total Price (RM)</B></th>
						</tr>
						</thead>
						<tbody>
							<?php
								$iCount = '1';
								$sql_today_order="SELECT order_id, order_amount, order_number, order_customer_id, order_customer_name, order_delivery FROM pbmart_order WHERE order_delivery = '$crnt_date' AND order_status !='2' ORDER BY order_id asc" ;
								$rs_today_order = mysql_query($sql_today_order, $link);
								while($rw_today_order = mysql_fetch_array($rs_today_order))
								{ ?>
							<tr>
									<td align='center'><?php echo $iCount; ?>.</td>
									
									
									<?php
										$member_id = $rw_today_order['order_customer_id'];
										$sql_member = "SELECT member_id, member_ic, member_commercial_class, member_commercial_status FROM pbmart_member WHERE member_id='$member_id'";
										$rs_member = mysql_query($sql_member, $link);
										$rw_member = mysql_fetch_array($rs_member);
										$member_ic = $rw_member['member_ic'];
										$member_commercial_class = $rw_member['member_commercial_class'];
										$member_commercial_status = $rw_member['member_commercial_status'];
										
										if($member_commercial_status == '1')
										{
											$sql_commercial="SELECT commercial_member_id, commercial_company FROM pbmart_commercial WHERE commercial_member_id='$member_id'";
											$rs_commercial = mysql_query($sql_commercial, $link);
											$rw_commercial = mysql_fetch_array($rs_commercial);
											$commercial_company = $rw_commercial['commercial_company'];
										}else
										{
											$commercial_company = '-';
										}
										?>
										<?php
											
											if(order_number($rw_today_order['order_number']))
											{ ?>
												<td><B><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_today_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none"><font color='red'><?php echo $rw_today_order['order_number']; ?></font></a></B></td>
												<td title="<?php echo $member_ic; ?>"><B><font color='red'><?php echo $rw_today_order['order_customer_name']; ?></font></B></td>
												<td><B><font color='red'><?php echo $commercial_company; ?></font></B></td>
												<td align='right'><B><font color='red'><?php echo $rw_today_order['order_amount']; ?></font></B></td>
									  <?php }else
											{
												if($member_commercial_class == '1')
												{ ?>
													<td><B><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_today_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none"><?php echo $rw_today_order['order_number']; ?></a></B></td>
													<td title="<?php echo $member_ic; ?>"><B><?php echo $rw_today_order['order_customer_name']; ?></B></td>
													<td><B><?php echo $commercial_company; ?></B></td>
													<td align='right'><B><?php echo $rw_today_order['order_amount']; ?></B></td>
													<?php  
												}else
												{ ?>
													<td><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_today_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none"><?php echo $rw_today_order['order_number']; ?></a></td>
													<td title="<?php echo $member_ic; ?>"><?php echo $rw_today_order['order_customer_name']; ?></td>
													<td><?php echo $commercial_company; ?></td>
													<td align='right'><?php echo $rw_today_order['order_amount']; ?></td>
										  <?php } ?>
								</tr>
					   <?php  }
							$iCount++;	}
							?>
						</tbody>
						<tr>
							<TH colspan='5'>
							<B><font size='4'>TOTAL ORDERS:
								<?php
									echo mysql_num_rows($rs_today_order);
								?>
									</font>
								</B>
							
							</TH>
						</tr>
					</table>
					
					<table style="border: 1px solid black; border-collapse: collapse;">
						<thead>
							<tr>
								<td colspan='4'>
									<font size='4'><B>TOMMOROW ORDERS</B></font>
								</td>
								<td>
									<center>
										<font size='4'><B><?php echo $display_date_tmr->format('d-m-Y'); ?></B></font>
									</center>
								</td>
							</tr>
							<tr>
								<th><B>No.</B></td>
								<th><B>Order Number</B></th>
								<th><B>Customer Name</B></th>
								<th><B>Company Name</B></th>
								<th><B>Total Price (RM)</B></th>
							</tr>
						</thead>
						<tbody>
						<?php
								$iCount2 = '1';
								$sql_tmr_order="SELECT order_id, order_amount, order_number, order_customer_id, order_customer_name, order_delivery FROM pbmart_order WHERE order_delivery = '$tmr_date' ORDER BY order_id asc" ;
								$rs_tmr_order = @mysql_query($sql_tmr_order, $link);
								while($rw_tmr_order = mysql_fetch_array($rs_tmr_order))
								{ ?>
								<tr>
									<td align='center'><?php echo $iCount2; ?>.</td>
									<td><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_tmr_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none"><?php echo $rw_tmr_order['order_number']; ?></a></td>
									
									<?php
										$member_id = $rw_tmr_order['order_customer_id'];
										$sql_member = "SELECT member_id, member_ic, member_commercial_status FROM pbmart_member WHERE member_id='$member_id'";
										$rs_member = mysql_query($sql_member, $link);
										$rw_member = mysql_fetch_array($rs_member);
										$member_ic = $rw_member['member_ic'];
										$member_commercial_status = $rw_member['member_commercial_status'];
										
										if($member_commercial_status == '1')
										{
											$sql_commercial="SELECT commercial_member_id, commercial_company FROM pbmart_commercial WHERE commercial_member_id='$member_id'";
											$rs_commercial = mysql_query($sql_commercial, $link);
											$rw_commercial = mysql_fetch_array($rs_commercial);
											$commercial_company = $rw_commercial['commercial_company'];
										}else
										{
											$commercial_company = '-';
										}
										?>
										<td title="<?php echo $member_ic; ?>"><?php echo $rw_tmr_order['order_customer_name']; ?></td>
										<td><?php echo $commercial_company; ?></td>
										<td align='right'><?php echo $rw_tmr_order['order_amount']; ?></td>
										<?php
									?>
								</tr>
			  <?php  $iCount2++; }
							?>
						</tbody>
						<tr>
							<th colspan='5'><B><font size='5'>Tomorrow Orders:
								<?php
									echo mysql_num_rows($rs_tmr_order);
								?>
									</font>
								</B>
							</th>
						</tr>
					</table>
	</body>
</html>
				