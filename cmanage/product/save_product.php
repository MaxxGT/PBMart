<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}

	if(isset($_POST['save_product'])){	
		$pro_cat_id = mysqli_real_escape_string($dbconnect, $_POST['product_category']);
		$pro_name = mysqli_real_escape_string($dbconnect, $_POST['product_name']);
		$pro_class = mysqli_real_escape_string($dbconnect, $_POST['product_class']);
		$pro_model = mysqli_real_escape_string($dbconnect, $_POST['product_model']);
		$pro_price = mysqli_real_escape_string($dbconnect, $_POST['product_price']);
		$com_price = mysqli_real_escape_string($dbconnect, $_POST['commercial_price']);
		$com_price2 = mysqli_real_escape_string($dbconnect, $_POST['commercial_price2']);
		$pro_hand = mysqli_real_escape_string($dbconnect, $_POST['product_handling']);
		$com_hand = mysqli_real_escape_string($dbconnect, $_POST['commercial_handling']);
		$com_hand2 = mysqli_real_escape_string($dbconnect, $_POST['commercial_handling2']);
		$pro_point = mysqli_real_escape_string($dbconnect, $_POST['product_point']);
		$com_point = mysqli_real_escape_string($dbconnect, $_POST['commercial_point']);
		$com_point2 = mysqli_real_escape_string($dbconnect, $_POST['commercial_point2']);
		/*$pro_sale_amount1 = mysqli_real_escape_string($dbconnect, $_POST['product_sale_amount1']);
		$pro_sale_percentage1 = mysqli_real_escape_string($dbconnect, $_POST['product_sale_percentage1']);
		$pro_sale_amount2 = mysqli_real_escape_string($dbconnect, $_POST['product_sale_amount2']);
		$pro_sale_percentage2 = mysqli_real_escape_string($dbconnect, $_POST['product_sale_percentage2']);
		$pro_sale_amount3 = mysqli_real_escape_string($dbconnect, $_POST['product_sale_amount3']);
		$pro_sale_percentage3 = mysqli_real_escape_string($dbconnect, $_POST['product_sale_percentage3']);*/
		if(!empty($_POST['product_stock_class'])){
			$pro_stock_class = mysqli_real_escape_string($dbconnect, $_POST['product_stock_class']);
			
			if($pro_stock_class == "Length"){
				$pro_stock_min = mysqli_real_escape_string($dbconnect, $_POST['product_stock_minimum']);
				$pro_stock_class = mysqli_real_escape_string($dbconnect, $_POST['product_stock_length_measure']);
			}else{
				$pro_stock_min = 1;
			}
		}else{
			$pro_stock_class = "";
		}
		
		$pro_stock = mysqli_real_escape_string($dbconnect, $_POST['product_stock']);
		$pro_limit = mysqli_real_escape_string($dbconnect, $_POST['product_limit']);
		$pro_life_limit = mysqli_real_escape_string($dbconnect, $_POST['product_life_limit']);
		$pro_image = isset($_FILES['product_image']);
		$pro_description = mysqli_real_escape_string($dbconnect, $_POST['product_description']);
		
		if($pro_cat_id == "" || $pro_name == "" || $pro_class == "" || $pro_price == "" || $com_price == "" || $pro_point == "" || $com_point == "" || $pro_stock_class == "" || $pro_stock == "" || $pro_stock_min == "" || $pro_limit == "" || $pro_life_limit == "" || $pro_image == ""){
			header("location:add_product.php?save=empty&hyperlink=products");
		}else{
			$file_name = $_FILES['product_image']['name'];
			$tmp_name = $_FILES['product_image']['tmp_name']; 
			$type = $_FILES['product_image']['type'];
			$ext = substr(strrchr($file_name, "."), 1);

			switch($ext){ 
				case 'pjpeg':
				$pro_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpg':
				$pro_img = 'photo/'.uniqid('').'.jpg';
				break;

			case 'jpeg': 
				$pro_img = 'photo/'.uniqid('').'.jpg';
				break; 

			case 'gif':
				$pro_img = 'photo/'.uniqid('').'.gif';
				break;
			
			case 'png':
				$pro_img = 'photo/'.uniqid('').'.png';
				break;
			}

			if($pro_img != ''){ 
				if(move_uploaded_file($tmp_name, $pro_img)){
				}else{
					header("location:add_product.php?save=iFalse&hyperlink=products");
				}
			}
			
			if(isset($_POST['show_charge'])){
				$display = 1;
			}else{
				$display = 0;
			}
			
			if(isset($_POST['show_commercial_charge'])){
				$com_display = 1;
			}else{
				$com_display = 0;
			}
			
			if(isset($_POST['show_commercial_charge2'])){
				$com2_display = 1;
			}else{
				$com2_display = 0;
			}
			
			if(isset($_POST['double_point'])){
				$double = 1;
			}else{
				$double = 0;
			}
			
			if(isset($_POST['double_commercial_point'])){
				$com_double = 1;
			}else{
				$com_double = 0;
			}
			
			if(isset($_POST['double_commercial_point2'])){
				$com2_double = 1;
			}else{
				$com2_double = 0;
			}
				
			if(isset($_POST['product_add_on'])){
				$pro_add_on = 1;
			}else{
				$pro_add_on = 0;
			}
			
			/*if($pro_sale_percentage1 == ""){
				$pro_sale_percentage1 = 0;
			}
			
			if($pro_sale_percentage2 == ""){
				$pro_sale_percentage2 = 0;
			}
			
			if($pro_sale_percentage3 == ""){
				$pro_sale_percentage3 = 0;
			}*/
			
			$cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_category WHERE category_id='$pro_cat_id'");
			$cat_display = mysqli_fetch_assoc($cat);
			
			$save_pro = mysqli_query($dbconnect, "INSERT INTO pbmart_product(product_category_id, product_category, product_name, product_class, product_model, product_price, product_commercial_price, product_commercial_price2, product_handling, product_commercial_handling, product_commercial_handling2, product_handling_show, product_commercial_handling_show, product_commercial_handling_show2, product_point, product_commercial_point, product_commercial_point2, product_double_point, product_commercial_double_point, product_commercial_double_point2, product_stock_class, product_stock, product_stock_minimum, product_limit, product_lifetime_limit, product_add_on, product_image, product_alt, product_description) VALUES ('$pro_cat_id', '".$cat_display['category_name']."', '$pro_name', '$pro_class', '$pro_model', '$pro_price', '$com_price', '$com_price2', '$pro_hand', '$com_hand', '$com_hand2', '$display', '$com_display', '$com2_display', '$pro_point', '$com_point', '$com_point2', '$double', '$com_double', '$com2_double', '$pro_stock_class', '$pro_stock', '$pro_stock_min', '$pro_limit', '$pro_life_limit', '$pro_add_on', '$pro_img', '$pro_name', '$pro_description')");
			
			//product_sale1, product_sale_percentage1, product_sale2, product_sale_percentage2, product_sale3, product_sale_percentage3, 
			//'$pro_sale_amount1','$pro_sale_percentage1', '$pro_sale_amount2', '$pro_sale_percentage2', '$pro_sale_amount3', '$pro_sale_percentage3', 
			
			if($save_pro){
				header("location:add_product.php?save=true&hyperlink=products");
			}else{
				header("location:add_product.php?save=false&hyperlink=products");
			}
		}
	}
?>