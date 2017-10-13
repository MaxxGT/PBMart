<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}	
		$pro_id = mysqli_real_escape_string($dbconnect, $_GET['id']);
		$pro_cat_id = mysqli_real_escape_string($dbconnect, $_POST['product_category']);
		$pro_name = mysqli_real_escape_string($dbconnect, $_POST['product_name']);
		$pro_class = mysqli_real_escape_string($dbconnect, $_POST['product_class']);
		$pro_model = mysqli_real_escape_string($dbconnect, $_POST['product_model']);
		$pro_price = mysqli_real_escape_string($dbconnect, $_POST['product_price']);
		$com_price = mysqli_real_escape_string($dbconnect, $_POST['commercial_price']);
		$pro_hand = mysqli_real_escape_string($dbconnect, $_POST['product_handling']);
		$com_hand = mysqli_real_escape_string($dbconnect, $_POST['commercial_handling']);
		$pro_point = mysqli_real_escape_string($dbconnect, $_POST['product_point']);
		$com_point = mysqli_real_escape_string($dbconnect, $_POST['commercial_point']);
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
		$pro_description = mysqli_real_escape_string($dbconnect, $_POST['product_description']);

		$product_img = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$pro_id'");
		$pro_img_path = mysqli_fetch_assoc($product_img);
		
		if(isset($_POST['save_edit_product'])){
			if($pro_cat_id == "" || $pro_name == "" || $pro_class == "" || $pro_price == "" || $com_price == "" || $pro_point == "" || $com_point == ""){
				header("location:edit_product.php?pro=$pro_id&save=empty&hyperlink=products");
			}else{
				if(($_FILES['product_image']['size'] <= 0)){
					$pro_img = $pro_img_path['product_image'];
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
							header("location:edit_product.php?pro=$pro_id&save=iFalse&hyperlink=products");
						}
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
				
				if(isset($_POST['product_add_on'])){
					$pro_add_on = 1;
				}else{
					$pro_add_on = 0;
				}
				
				if(isset($_POST['manual'])){
					$order = mysqli_query($dbconnect, "SELECT MAX(order_id) FROM pbmart_order");
					$order_count = mysqli_fetch_row($order);
					
					$product = mysqli_query($dbconnect, "SELECT * FROM pbmart_product WHERE product_id='$pro_id'");
					$product_display = mysqli_fetch_assoc($product);
					
					if($order_count){
				              $order_count = $order_count[0];
			               	      if($order_count < 10){
					            $order_num = "OR00000".$order_count;
			        	      }else if($order_count >= 10 && $order_count < 100){
					            $order_num = "OR0000".$order_count;
				              }else if($order_count >= 100 && $order_count < 1000){
					            $order_num = "OR000".$order_count;
				              }else if($order_count >= 1000 && $order_count < 10000){
					            $order_num = "OR00".$order_count;
				              }
			               }else{
				              $order_num = "OR000001";
			               }
					
					$stock = $product_display['product_stock'] - $pro_stock;
					
					$total_amount = $stock * $pro_price;
					
					/*if($stock < $pro_sale_amount1){
						$pro_sale = 0;
					}else if($stock >= $pro_sale_amount1 && $stock < $pro_sale_amount2){
						$pro_sale = $pro_sale_percentage1;
					}else if($stock >= $pro_sale_amount2 && $stock < $pro_sale_amount3){
						$pro_sale = $pro_sale_percentage2;
					}else{
						$pro_sale = $pro_sale_percentage3;
					}*/
					$pro_sale = 0;
					$total_amount = $total_amount - ($total_amount * $pro_sale / 100);
					
					$date = date("Y-m-d");
					
					$create_order = mysqli_query($dbconnect, "INSERT INTO pbmart_order(order_number, order_amount, order_date, order_delivery, order_customer_name, order_payment_type, order_payment_status, order_status) VALUES ('$order_num', '$total_amount', '$date', '$date', 'Cash', 'Cash', '1', '1')");
					
					$create_order_list = mysqli_query($dbconnect, "INSERT INTO pbmart_order_list(order_number, order_product_id, order_product_name, order_product_price, order_product_sale, order_product_amount) VALUES ('$order_num', '$pro_id', '$pro_name', '$pro_price', '$pro_sale', '$stock')");
				}

			/*if($pro_sale_amount1 == "" || $pro_sale_amount1 == "0")
				$pro_sale_amount1 = 3;
			if($pro_sale_amount2 == "" || $pro_sale_amount2 == "0")
				$pro_sale_amount2 = 5;
			if($pro_sale_amount3 == "" || $pro_sale_amount3 == "0")
				$pro_sale_amount3 = 8;
			
			if($pro_sale_percentage1 == "")
				$pro_sale_percentage1 = 0;
			if($pro_sale_percentage2 == "")
				$pro_sale_percentage2 = 0;
			if($pro_sale_percentage3 == "")
				$pro_sale_percentage3 = 0;*/
				
				$cat = mysqli_query($dbconnect, "SELECT * FROM pbmart_category WHERE category_id='$pro_cat_id'");
				$cat_display = mysqli_fetch_assoc($cat);
				
				$save_edit_pro = mysqli_query($dbconnect, "UPDATE pbmart_product SET product_category_id='$pro_cat_id', product_category='".$cat_display['category_name']."', product_name='$pro_name', product_class='$pro_class', product_model='$pro_model', product_price='$pro_price', product_commercial_price='$com_price', product_handling='$pro_hand', product_commercial_handling='$com_hand', product_handling_show='$display', product_commercial_handling_show='$com_display', product_point='$pro_point', product_commercial_point='$com_point', product_double_point='$double', product_commercial_double_point='$com_double', product_stock_class='$pro_stock_class' , product_stock='$pro_stock', product_stock_minimum='$pro_stock_min', product_limit='$pro_limit', product_lifetime_limit='$pro_life_limit', product_add_on='$pro_add_on', product_image='$pro_img', product_description='$pro_description' WHERE product_id='$pro_id'");
				
				//product_sale1='$pro_sale_amount1', product_sale_percentage1='$pro_sale_percentage1', product_sale2='$pro_sale_amount2', product_sale_percentage2='$pro_sale_percentage2',product_sale3='$pro_sale_amount3', product_sale_percentage3='$pro_sale_percentage3'
				
				if($save_edit_pro){
					header("location:view_product.php?save=true&hyperlink=products");
				}else{
					header("location:edit_product.php?pro=$pro_id&save=false&hyperlink=products");
				}
			}
		}
?>