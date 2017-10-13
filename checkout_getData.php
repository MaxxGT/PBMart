<?php
if(isset($_POST['member_point']) && $_POST['member_point']!='0'){
		$member_point = $_POST['member_point'];
	}
	
	if(isset($_POST['total_point_reward']) && $_POST['total_point_reward']!='0'){
		$total_point_reward = $_POST['total_point_reward'];
	}else{
		$total_point_reward = '0';
	}
	
	if($_POST['shp_time']=='0'){
			$message = "Error: Please select preferred shipping time!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
			exit;
	}	
	
	if(isset($_POST['shp_time']) && $_POST['shp_time']!='0'){
		$shp_time = $_POST['shp_time'];
	}else{
			$message = "Error: Please select preferred shipping time!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
			exit;
	}

	if($shp_time !='3'){
		if(isset($_POST['shp_date']) && $_POST['shp_date']!=''){
			$shp_date = $_POST['shp_date'];
			$d = date_create($shp_date);
			echo $shp_date = date_format($d, 'Y-m-d');
			date_validate($shp_date);
		}else{
			$message = "Error: Please select preferred shipping date!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
			exit;
		}
	}else{
		echo $shp_date = date("Y-m-d");
	}

	if(isset($_POST['cash_on_delivery_rd']) && $_POST['cash_on_delivery_rd']!=""){
		$odr_payment_type = $_POST['cash_on_delivery_rd'];
	}else{
		$message = "Error: Please select payment type! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	//gather account information
	if(isset($_POST['first_name']) && $_POST['first_name']!=""){
		$first_name = $_POST['first_name'];
	}else{
		$message = "Error: Please key in your first name! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['last_name']) && $_POST['last_name']!=""){
		$last_name = $_POST['last_name'];
	}else{
		$message = "Error: Please key in your last name! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['user_email']) && $_POST['user_email']!=""){
		$user_email = $_POST['user_email'];
	}else{
		$message = "Error: Please key in your email! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['tel']) && $_POST['tel']!=""){
		$tel = $_POST['tel'];
	}else{
		$tel = "";
	}

	if(isset($_POST['mobile']) && $_POST['mobile']!=""){
		$mobile = $_POST['mobile'];
	}else{
		$message = "Error: Please key in your mobile number! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	//gather delivery address information

	if(isset($_POST['street_name']) && $_POST['street_name']!=""){
		$street_name = $_POST['street_name'];
	}else{
		$message = "Error: Please key in your street name! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['flr_num']) && $_POST['flr_num']!=""){
		$flr_num = $_POST['flr_num'];
	}else{
		$flr_num = "0";
	}

	if(isset($_POST['dlvy_type']) && $_POST['dlvy_type']!=""){
		$dlvy_type = $_POST['dlvy_type'];
		if($dlvy_type == '0'){
			$flr_num = "0";
		}
	}

	if(isset($_POST['city']) && $_POST['city']!='0'){
		$city = $_POST['city'];
	}else{
		$message = "Error: Please select your city! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['region_state']) && $_POST['region_state']!='0'){
		$region_state = $_POST['region_state'];
	}else{
		$message = "Error: Please select your region state! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['country']) && $_POST['country']!='0'){
		$country = $_POST['country'];
	}else{
		$message = "Error: Please select your country! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}

	if(isset($_POST['pst_code']) && $_POST['pst_code']!='0'){
		$pst_code = $_POST['pst_code'];
	}else{
		$message = "Error: Please select your postcode! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
	
	if(isset($_POST['chk_tnc']) && $_POST['chk_tnc']=='1'){
		
	}else{
		$message = "Error: Please read and accept the services provided area. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
	
	if(isset($_POST['nbr_mygaz']) && $_POST['nbr_mygaz']!=''){
		$nbr_mygaz = $_POST['nbr_mygaz'];
	}else{
		$message = "Error: Please read and accept the services provided area. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
	
	if(isset($_POST['nbr_petronas']) && $_POST['nbr_petronas']!=''){
		$nbr_petronas = $_POST['nbr_petronas'];
	}else{
		$message = "Error: Please read and accept the services provided area. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
	
	if(isset($_POST['total_exchange_gas']) && $_POST['total_exchange_gas']!=''){
		$total_exchange_gas = $_POST['total_exchange_gas'];
	}else{
		$message = "Error: Please read and accept the services provided area. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
	
	if(($nbr_mygaz + $nbr_petronas) > $total_exchange_gas)
	{
		$message = "Error: Exchange cylinder gas greater than order quantity. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
	
if($member_commercial_status =='1')
{
	if(($nbr_mygaz + $nbr_petronas) < $total_exchange_gas)
	{
		$message = "Error: Exchange cylinder gas less than order quantity. Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='checkout_page.php?hyperlink=home';</script>";
		exit;
	}
}

	if(isset($_POST['order_remark']) && $_POST['order_remark']!=''){
		$order_remark = $_POST['order_remark'];
	}
?>