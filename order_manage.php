<?php
require_once("connection/pbmartconnection.php");

session_start();
	
	if($_SESSION['validation'] == false){
		header("location:cmanage/authentication/login.php");
	}else{
	
	}
	
include('cmanage/report/check_orders_error.php');
include('class/product.php');
include('class/commercial.php');

//function use to get after 5.00pm 's order
function get_aft_order()
{
    $sql_order = "SELECT * FROM pbmart_order WHERE order_time_date >= CAST('17:00:00' AS time) AND order_status='0'";
    $rs_order = @mysql_query($sql_order);
    $iCount = @mysql_num_rows($rs_order);
    return $iCount;
}

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
	
	$current_date = $crt_date->format('d-m-Y');
	return $current_date;
}

function get_currentDateTime2()
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
$crnt_date2 = get_currentDateTime2();

if(isset($_GET['order_date']))
{
	$order_date = $_GET['order_date'];
}else
{
	$order_date = $crnt_date;
}

function cnrvt($d)
{
	$old_date_timestamp = strtotime($d);
	return $new_date = date('d-m-Y', $old_date_timestamp);
}

function sql_cnrvt($d)
{
	$old_date_timestamp = strtotime($d);
	return $new_date = date('Y-m-d', $old_date_timestamp);
}

$crnt_date = cnrvt($order_date);
$sql_crnt_date = sql_cnrvt($order_date);

$date = $crnt_date;
$newdate = strtotime ( '+1 day' , strtotime ( $date ) ) ;
$tmr_date = date ( 'Y-m-j' , $newdate );

$display_date_tmr = new DateTime($tmr_date);
?>

<!-- http://stackoverflow.com/questions/3381462/how-to-create-the-title-alert-effect-like-facebook -->
<script language="JavaScript">
(function () {

var original = "(1)PBMART ORDER";
var timeout;

window.flashTitle = function (newMsg, howManyTimes) {
    function step() {
        document.title = (document.title == original) ? newMsg : original;

        if (--howManyTimes > 0) {
            timeout = setTimeout(step, 1000);
        };
    };

    howManyTimes = parseInt(howManyTimes);

    if (isNaN(howManyTimes)) {
        howManyTimes = 5;
    };

    cancelFlashTitle(timeout);
    step();
};

window.cancelFlashTitle = function () {
    clearTimeout(timeout);
    document.title = original;
};

}());

flashTitle("OR000123", 10); // toggles it 10 times.
</script>

<style>
a.tooltip {outline:none; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;} 
a.tooltip span {
    z-index:10;display:none; padding:14px 20px;
    margin-top:60px; margin-left:-0px;
    width:300px; line-height:16px;
}
a.tooltip:hover span{
    display:inline; position:absolute; 
    border:2px solid #FFF;  color:#EEE;
    background:#333 url(cssttp/css-tooltip-gradient-bg.png) repeat-x 0 0;
}
.callout {z-index:20;position:absolute;border:0;top:-14px;left:120px;}
    
/*CSS3 extras*/
a.tooltip span
{
    border-radius:2px;        
    box-shadow: 0px 0px 8px 4px #666;
    /*opacity: 0.8;*/
}
</style>

<!dotype html>
<link rel="stylesheet" type="text/css" href="css/order_manage.css" />
<link href="glDatePicker-2.0/styles/glDatePicker.darkneon.css" rel="stylesheet" type="text/css">
<link href="styles/glDatePicker.darkneon.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="glDatePicker-2.0/glDatePicker.min.js"></script>
<html>
	<head>
		<meta name='viewport' content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/ico" href="css/favicon.ico">
		<title>PBMART</title>
		<script language="JavaScript">
			<!-- http://www.proglogic.com/code/javascript/time/12hourclock.php
			function clock(){
			var time = new Date()
			var hr = time.getHours()
			var min = time.getMinutes()
			var sec = time.getSeconds()
			var ampm = " PM "
			if (hr < 12){
			ampm = " AM "
			}
			if (hr > 12){
			hr -= 12
			}
			if (hr < 10){
			hr = " " + hr
			}
			if (min < 10){
			min = "0" + min
			}
			if (sec < 10){
			sec = "0" + sec
			}
			
			document.getElementById('txt').innerHTML=hr + ":" + min + ":" + sec + ampm;
			setTimeout("clock()", 1000)
			}
			function showDate(){
			var date = new Date()
			var year = date.getYear()
			if(year < 1000){
			year += 1900
			}
			var monthArray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
			alert( monthArray[date.getMonth()] + " " + date.getDate() + ", " + year)
			}
			window.onload=clock;
			//-->
			
			function autoSubmitForm() {
			var formObject = document.forms['order_manage'];
				formObject.submit();
			}
			
			function autoSubmit(date) {
				window.location.href='order_manage.php?order_date='+date;
			}
		</script>
	</head>
	<body>
		<form name="order_manage" action="cmanage/receipt/receipt_admin_all.php" method="post" target="_new">
					<table border='0' style="border: 1px solid black; border-collapse: collapse;">
						<thead>
						<tr>
							<td colspan='4'>
								<font size='4'><B><a href="../order_manage.php" STYLE="text-decoration: none">TODAY ORDERS</a> &nbsp;&nbsp;
								<input type="text" id="order_date" name="order_date" size='10' style="width:260px; height:25px; background: transparent; border: none; font-size: 18px; font-weight:bold" gldp-id="order_date" value="<?php if(isset($order_date)){echo $order_date;}else{ echo ""; } ?>" />
			
									<script type="text/javascript">
										$('#order_date').glDatePicker(
										{
											
											showAlways: false,
											cssName: 'darkneon',
											allowMonthSelect: true,
											allowYearSelect: true,
											prevArrow: '\u25c4',
											nextArrow: '\u25ba',
											selectableDOW: [0,1,2,3,4,5,6],
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
												autoSubmit(d+'-'+m+'-'+y);
											},
											
											calendarOffset: { x: 0, y: 1 },
										});
									</script>
									
									
								</B></font>
								
							<a href="http://www.pbmart.com.my/cmanage/order/make_order.php?hyperlink=orders" title="New Order" style="text-decoration:none;" target="_new">
								<img src='css/images/Icon_Plus.png' width='30px' height='30px' style="margin:-10px 0px" />
							</a>
							<img src='css/images/print-button.png' width='32px' height='32px' style="margin:-10px -0px" title="Print All or Selected Only" onclick='autoSubmitForm()' />
							</td>
							<td>
								<center>
									<font size='4'>
										<B><div id="txt"></div></B>
									</font>
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
								$sql_today_order="SELECT order_id, order_amount, order_number, order_customer_id, order_customer_name, order_delivery, order_time_date, order_status FROM pbmart_order WHERE order_delivery = '$sql_crnt_date' ORDER BY order_id asc" ;
								$rs_today_order = mysqli_query($dbconnect, $sql_today_order);
								while($rw_today_order = mysqli_fetch_array($rs_today_order))
								{ 
									$order_number = $rw_today_order['order_number'];
									$order_status = $rw_today_order['order_status'];
									if($order_status == '1')
									{
										$order_status = "- COMPLETED";
									}else if($order_status == '2')
									{
										$order_status = "<BR/>&nbsp;&nbsp;&nbsp;CANCELLED";
									}else
									{
										$order_status = "";
									}
									?>
							<tr>
									<td align='center'>
										<?php echo $iCount; ?>.
									</td>
									
									
									<?php
										$member_id = $rw_today_order['order_customer_id'];
										$order_time_date = $rw_today_order['order_time_date'];
										$sql_member = "SELECT member_id, member_ic, member_commercial_class, member_commercial_status FROM pbmart_member WHERE member_id='$member_id'";
										$rs_member = mysqli_query($dbconnect, $sql_member);
										$rw_member = mysqli_fetch_array($rs_member);
										$member_ic = $rw_member['member_ic'];
										$member_commercial_class = $rw_member['member_commercial_class'];
										$member_commercial_status = $rw_member['member_commercial_status'];
										
										if($member_commercial_status == '1')
										{
											$sql_commercial="SELECT commercial_member_id, commercial_company FROM pbmart_commercial WHERE commercial_member_id='$member_id'";
											$rs_commercial = mysqli_query($dbconnect, $sql_commercial);
											$rw_commercial = mysqli_fetch_array($rs_commercial);
											$commercial_company = $rw_commercial['commercial_company'];
										}else
										{
											$commercial_company = '-';
										}
										?>
										<?php
											
											if(order_number($dbconnect,$rw_today_order['order_number']))
											{
												$order_number = $rw_today_order['order_number'];
												$sql_today_order_list = "SELECT order_number, order_product_amount FROM pbmart_order_list WHERE order_number = '$order_number'";
												$rs_today_order_list = mysqli_query($dbconnect,$sql_today_order_list);
												$rw_today_order_list = mysqli_fetch_array($rs_today_order_list);
												$order_product_amount = $rw_today_order_list['order_product_amount'];
												
												?>
												<td>
													
													<input type='checkbox' name='btnchk[<?php echo $iCount; ?>]' id='btnchk[<?php echo $iCount; ?>]' value="<?php echo $order_number; ?>" />
													
												<B><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_today_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none" class="tooltip"><font color='red'><?php echo $rw_today_order['order_number'].' '.$order_status; ?></font></a></B> 
												<a href="javascript:window.print();" target='_new'>	
														<img src='css/images/print.png' width='20px' height='20px' style="margin:-4px -0px" />
													</a>
												</td>
												<td title="<?php echo $member_ic.' ('.$order_time_date.')'; ?>"><B><font color='red'><?php echo $rw_today_order['order_customer_name']; ?></font></B>
												
												<a href="cmanage/member/edit_member.php?mem=<?php echo $rw_today_order['order_customer_id']; ?>&hyperlink=members'" target='_new'>	
														<img src='css/images/default_icon-profile.png' width='20px' height='20px' style="margin:-7px -0px" title=' <?php echo $rw_today_order['order_customer_name']; ?>' />
													</a>
												
												</td>
												<td><B><font color='red'><?php echo $commercial_company; ?></font></B></td>
												<td align='right'><?php echo '<font size=4>'.$rw_today_order['order_amount'].'<font color="blue"> ('.$order_product_amount.')'?></font></td>
									  <?php }else
											{
												$order_number = $rw_today_order['order_number'];
												
												$sql_today_order_list = "SELECT order_number, order_product_amount, order_product_price FROM pbmart_order_list WHERE order_number = '$order_number'";
												$rs_today_order_list = @mysqli_query($dbconnect,$sql_today_order_list);
												$rw_today_order_list = @mysqli_fetch_array($rs_today_order_list);
												$order_product_amount = $rw_today_order_list['order_product_amount'];
												$order_product_price = $rw_today_order_list['order_product_price'];
												
												if($member_commercial_class == '1')
												{ ?>
													<td>
														<input type='checkbox' name='btnchk[<?php echo $iCount; ?>]' id='btnchk[<?php echo $iCount; ?>]' value="<?php echo $order_number; ?>" />
													<B><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_today_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none" class="tooltip"><?php echo $rw_today_order['order_number'].' '.$order_status; ?>
													<span>
														<strong>ORDER INFORMATION</strong><BR />
														<?php echo $order_product_amount.' X '.$order_product_price.' = '.$rw_today_order['order_amount']; ?>
													</span>
													</a></B>
													<a href="cmanage/receipt/receipt_admin.php?or=<?php echo $rw_today_order['order_number']; ?> " target='_new'>	
														<img src='css/images/print.png' width='20px' height='20px' style="margin:-4px -0px" />
													</a>
													</td>
													<td title="<?php echo $member_ic.' ('.$order_time_date.')'; ?>"><B><?php echo $rw_today_order['order_customer_name']; ?></B>
													
														<a href="cmanage/member/edit_member.php?mem=<?php echo $rw_today_order['order_customer_id']; ?>&hyperlink=members'" target='_new'>	
														<img src='css/images/default_icon-profile.png' width='20px' height='20px' style="margin:-7px -0px" title=' <?php echo $rw_today_order['order_customer_name']; ?>' />
													</a>
														
													</td>
													<td><B><?php echo $commercial_company; ?></B></td>
													<td align='right'><?php echo '<font size=4>'.$rw_today_order['order_amount'].'<font color="blue"> ('.$order_product_amount.')'?></font></td>
													<?php  
												}else
												{ ?>
													<td>
														<input type='checkbox' name='btnchk[<?php echo $iCount; ?>]' id='btnchk[<?php echo $iCount; ?>]' value="<?php echo $order_number; ?>" />
													<a href="cmanage/order/view_orderList.php?or=<?php echo $rw_today_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none" class="tooltip"><?php echo $rw_today_order['order_number'].' '.$order_status; ?>
													<span>
														<strong>ORDER INFORMATION</strong><BR />
														<?php echo $order_product_amount.' X '.$order_product_price.' = '.$rw_today_order['order_amount']; ?>
													</span>
													</a>
														
													<a href="cmanage/receipt/receipt_admin.php?or=<?php echo $rw_today_order['order_number']; ?> " target='_new'>	
														<img src='css/images/print.png' width='20px' height='20px' style="margin:-4px -0px" />
													</a>
													</td>
													<td title="<?php echo $member_ic.' ('.$order_time_date.')'; ?>"><?php echo $rw_today_order['order_customer_name']; ?>  
														
													<a href="cmanage/member/edit_member.php?mem=<?php echo $rw_today_order['order_customer_id']; ?>&hyperlink=members'" target='_new'>	
														<img src='css/images/default_icon-profile.png' width='20px' height='20px' style="margin:-7px -0px" title=' <?php echo $rw_today_order['order_customer_name']; ?>' />
													</a>
														
													</td>
													<td><?php echo $commercial_company; ?></td>
													<td align='right'><?php echo '<font size=4>'.$rw_today_order['order_amount'].'<font color="blue"> ('.$order_product_amount.')'?></font></td>
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
									echo mysqli_num_rows($rs_today_order);
								?>
									</font>
								</B>
							
							</TH>
						</tr>
						
						<input type='hidden' name='iCount' id='iCount' value='<?php echo $iCount; ?>' />
						<input type='hidden' name='sql_crnt_date' id='sql_crnt_date' value='<?php echo $sql_crnt_date; ?>' />
					</table>
	</form>
			
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
								$sql_tmr_order="SELECT order_id, order_amount, order_number, order_customer_id, order_customer_name, order_delivery, order_time_date, order_status FROM pbmart_order WHERE order_delivery = '$tmr_date' AND order_status !='1' AND order_status !='2' ORDER BY order_id asc" ;
								$rs_tmr_order = mysqli_query($dbconnect, $sql_tmr_order);
								while($rw_tmr_order = mysqli_fetch_array($rs_tmr_order))
								{ ?>
								<tr>
									<td align='center'><?php echo $iCount2; ?>.</td>
									<td><a href="cmanage/order/view_orderList.php?or=<?php echo $rw_tmr_order['order_number']; ?>&view=ma&hyperlink=orders" target="_new" style="text-decoration:none"><?php echo $rw_tmr_order['order_number']; ?></a></td>
									
									<?php
										$member_id = $rw_tmr_order['order_customer_id'];
										$order_time_date = $rw_tmr_order['order_time_date'];
										$sql_member = "SELECT member_id, member_ic, member_passport_number, member_commercial_status FROM pbmart_member WHERE member_id='$member_id'";
										$rs_member = mysqli_query($dbconnect, $sql_member);
										$rw_member = mysqli_fetch_array($rs_member);
										$member_ic = $rw_member['member_ic'];
										$member_passport_number = $rw_member['member_passport_number'];
										
										if($member_ic !='-')
										{
											$ic = $member_ic;
										}else
										{
											$ic = $member_passport_number;
										}
										
										$member_commercial_status = $rw_member['member_commercial_status'];
										if($member_commercial_status == '1')
										{
											$sql_commercial="SELECT commercial_member_id, commercial_company FROM pbmart_commercial WHERE commercial_member_id='$member_id'";
											$rs_commercial = mysqli_query($dbconnect, $sql_commercial);
											$rw_commercial = mysqli_fetch_array($rs_commercial);
											$commercial_company = $rw_commercial['commercial_company'];
										}else
										{
											$commercial_company = '-';
										}
										?>
										<td title="<?php echo $ic.' ('.$order_time_date.')'; ?>"><?php echo $rw_tmr_order['order_customer_name']; ?></td>
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
									echo mysqli_num_rows($rs_tmr_order);
								?>
									</font>
								</B>
							</th>
						</tr>
					</table>
					
					<table>
					
						<?php
							$sql_unachieved_order="SELECT * FROM pbmart_order WHERE order_status='0' AND order_delivery<'$crnt_date2' ORDER BY order_id asc";
							$rs_unachieved_order = mysqli_query($dbconnect, $sql_unachieved_order);
						?>
						<tr>
							<td colspan='5'><font size='4'><B>PENDING ORDERS (<?php echo mysqli_num_rows($rs_unachieved_order); ?>)</B></font></td>
						</tr>
						<tr>
							<th><B>Order Number</B></th>
							<th><B>Customer Name</B></th>
							<th><B>Order Date</B></th>
							<th><B>Date Delivery</B></th>
							<th align='right'><B>Total Price (RM)</B></th>
						</tr>
						<?php
								while($rw_unachieved_order = mysqli_fetch_array($rs_unachieved_order))
								{ 
						?>
								<tr>
									<td><?php echo $rw_unachieved_order['order_number']; ?></td>
									<td><?php echo $rw_unachieved_order['order_customer_name']; ?></td>
									<td><?php echo $rw_unachieved_order['order_date']; ?></td>
									<td><?php echo $rw_unachieved_order['order_delivery']; ?></td>
									<td align='right'><?php echo $rw_unachieved_order['order_amount']; ?></td>
								</tr>
						<?php } ?>
						
							<tr>
							<TH colspan='5'>
							<B><font size='4'>TOTAL PENDING ORDERS:
							<?php
									echo mysqli_num_rows($rs_unachieved_order);
								?>
									</font>
								</B>
							
							</TH>
						</tr>
					</table>
					
					<table border='0'>
						<tr>
							<td><h1>Summary</h1></td>
						</tr>
						<tr>
							<td><B>Order(After 5'o clock)</B>: <?php echo get_aft_order(); ?></td>
						</tr>
					</table>
	</body>
</html>