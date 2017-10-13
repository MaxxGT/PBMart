<?php
// Author: VOONG TZE HOWE
// Date Writen: 19-10-2014
// Description : product_validate
// Last Modification: 27-10-2014
include('linkList.php');
include('msg.php');

get_UsrInfo();

$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');

if(!isset($_SESSION['usr_name']))
{
	if(isset($_REQUEST['hyperlink']))
	{
		if($_REQUEST['hyperlink']=='home')
		{	
			login_msg('index', 'home');
		}else if($_REQUEST['hyperlink']=='promotion')
		{	
			$message = "Please login to make order! Thanks!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='promotions.php?hyperlink=promotion&id=".$id;
			echo "'</script>";
		}else if($_REQUEST['hyperlink']=='product')
		{	
			login_msg('products', 'product');
		}else if($_REQUEST['hyperlink']=='tupperware')
		{	
			login_msg('tupperwares', 'tupperware');
		}else if($_REQUEST['hyperlink']=='tupperware_hamper')
		{	
			login_msg('index', 'home');
		}else if($_REQUEST['hyperlink']=='index')
		{	
			login_msg('index', 'home');
		}
		else if($_REQUEST['hyperlink']=='index2')
		{	
			login_msg('index', 'home');
		}else
		{
			login_msg('index', 'home');
		}
	}
}else
{
	if(isset($_REQUEST['act']))
	{
		$act = $_REQUEST['act'];
	}
}

if($act == 'add')
{
	if($_SESSION['usr_name'] == "")
	{
		login_msg('index', 'home');
	}else
	{
		if(!isset($_SESSION['order_qty']) || (isset($_SESSION['order_qty']) && $_SESSION['order_qty']=='0')) 
		{
			$_SESSION['order_qty'] = '0';
			$order_qty = $_SESSION['order_qty'];
		}
		
		if($_SESSION['order_qty'] == '0')
		{
			if(isset($_REQUEST['product_id']))
			{
				$product_id = $_REQUEST['product_id'];
				
				//a function use to verify product or promotions terms and conditions
				product_verification($product_id);
				
				if(isset($product_id))
				{
					$_SESSION['product_id'][$order_qty] = $product_id;
				}
			}else 
			{
			    $message = "Any error occured, please try again later.";
			    echo "<script type='text/javascript'>alert('$message');</script>";
			    echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home'";
			    echo "'</script>";
			}
			
			if(isset($_REQUEST['product_category_id']))
			{
				$product_category_id = $_REQUEST['product_category_id'];
				$_SESSION['product_category_id'][$order_qty] = $product_category_id;
			}
			
			if(isset($_REQUEST['product_category']))
			{
				$product_category = $_REQUEST['product_category'];
			}
			
			if(isset($_REQUEST['product_qty']))
			{
				$product_qty = product_quantity_verification($product_id, $_REQUEST['product_qty']);
				if(isset($product_qty))
				{
					$_SESSION['product_qty'][$order_qty] = $product_qty;
				}
			}
			
			if(isset($_REQUEST['btnRd_product']))
			{
				$_SESSION['odr_gas_type'][$order_qty] = $_REQUEST['btnRd_product'];
			}else
			{
				$_SESSION['odr_gas_type'][$order_qty] = '0';
			}
			
			if($product_id =='1' && $product_category_id=='1')
			{
				commercial_validate_mygazRefillPrd($product_id, $product_qty, "0");
			}
			
			$_SESSION['order_qty']++;
			// for($i=0; $i<$_SESSION['order_qty']; $i++)
			// {
				// echo ('Order Qty: '.$_SESSION['order_qty'].'<br>');
				// echo ('product_id: '.$_SESSION['product_id'][$i].'<br>');
				// echo ('product_qty: '.$_SESSION['product_qty'][$i].'<br>');
				// echo ('<br>');
			// }echo $_SESSION['order_qty']; exit;
			
			exit;
			
			$target_url = "";
			if(isset($target_url))
			{
				if(isset($_REQUEST['hyperlink']))
				{
					if($_REQUEST['hyperlink']=='home')
					{
						$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='promotion')
					{
						$target_url .= "<script>window.top.location ='promotions.php?hyperlink=promotion&id=".$id;
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='product')
					{
						$target_url .= "<script>window.top.location ='products.php?hyperlink=product&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}
					else if($_REQUEST['hyperlink']=='tupperware')
					{
						$target_url .= "<script>window.top.location ='tupperwares.php?hyperlink=tupperware&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}
					else if($_REQUEST['hyperlink']=='tupperware_hamper')
					{
						$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}
					else if($_REQUEST['hyperlink']=='index')
					{
						if(product_add_on_link($product_id) == true)
						{
							
							$target_url .= "<script>window.top.location ='spc_prm_add_on.php?hyperlink=product&product_categories=$product_category";
						}else
						{
							$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
						}
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='index2')
					{
						if(product_add_on_link($product_id) == true)
						{
							
							$target_url .= "<script>window.top.location ='spc_prm_add_on.php?hyperlink=product&product_categories=$product_category";
						}else
						{
							$target_url .= "<script>window.top.location ='shopping_cart.php?hyperlink=product&product_categories=$product_category";
						}
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='refill_gas_promotion')
					{
						$target_url .= "<script>window.top.location ='shopping_cart.php?hyperlink=product&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='weekly_promotion')
					{
						$target_url .= "<script>window.top.location ='shopping_cart.php?hyperlink=product&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='welcome_2016')
					{
						$target_url .= "<script>window.top.location ='wlc_prm_add_on.php?hyperlink=product&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='promoC')
					{
						$target_url .= "<script>window.top.location ='tupperware_prm_add_on.php?hyperlink=tupperware&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='1st_anniversary')
					{
						$target_url .= "<script>window.top.location ='1st_anniversary_add_on.php?hyperlink=product&product_categories=$product_category&id=$product_category_id";
						$target_url .= "'</script>";
						echo $target_url;
					}else
					{
						$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
						$target_url .= "'</script>";
						echo $target_url;
					}
				}
			}
		}else
		{ 
			//if product is not repeated, then...
			if(validate_product())
			{
				$order_qty = $_SESSION['order_qty'];
				if(isset($_REQUEST['product_id']))
				{
					$product_id = $_REQUEST['product_id'];
					
					if($product_id == '7' || $product_id == '8')
					{
						if(validate_mygazPrd($product_id) > 0)
						{
							$message = "Note: You already order 1 MYGAZ LPG 14KG CYLINDER TANK in your cart! Thanks!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
							exit;
						}
						
						if(validate_mygazDep($product_id) == '1' || validate_mygazDep($product_id) > '0')
						{
							$message = "Note: You already buy this product before! Thanks!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
							exit;
						}
					}
					if(isset($product_id))
					{
						$_SESSION['product_id'][$order_qty] = $product_id;
					}
				}
				
				if(isset($_REQUEST['product_category_id']))
				{
					$product_category_id = $_REQUEST['product_category_id'];
					$_SESSION['product_category_id'][$order_qty] = $product_category_id;
				}
				
				if(isset($_REQUEST['product_category']))
				{
					$product_category = $_REQUEST['product_category'];
				}
				
				if(isset($_REQUEST['product_qty']))
				{
					$product_qty = $_REQUEST['product_qty'];
					if(isset($product_qty))
					{
						$_SESSION['product_qty'][$order_qty] = product_quantity_verification($product_id, $product_qty);
					}
				}
				
				
				
				if(isset($_REQUEST['btnRd_product']))
				{
					$_SESSION['odr_gas_type'][$order_qty] = $_REQUEST['btnRd_product'];
				}else
				{
					$_SESSION['odr_gas_type'][$order_qty] = '0';
				}
				
				
				if($product_id =='1' && $product_category_id =='1')
				{
					commercial_validate_mygazRefillPrd($product_id, $product_qty, "0");
				}
				
				$_SESSION['order_qty']++;
				$target_url = "";
				if(isset($target_url))
				{
					if(isset($_REQUEST['hyperlink']))
					{
						if($_REQUEST['hyperlink']=='home')
						{
							$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
							$target_url .= "'</script>";
								
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='promotion')
						{
							$target_url .= "<script>window.top.location ='promotions.php?hyperlink=promotion&id=".$id;
							$target_url .= "'</script>";
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='product')
						{
							$target_url .= "<script>window.top.location ='products.php?hyperlink=product&product_categories=$product_category";
							$target_url .= "'</script>";
								
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='tupperware')
						{
							$target_url .= "<script>window.top.location ='tupperwares.php?hyperlink=tupperware&product_categories=$product_category";
							$target_url .= "'</script>";
								
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='tupperware_hamper')
						{
								$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
								$target_url .= "'</script>";
									
								echo $target_url;
						}else if($_REQUEST['hyperlink']=='index')
						{
							$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
							$target_url .= "'</script>";
								
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='index2')
						{
							if(product_add_on_link($product_id) == true)
							{
								
								$target_url .= "<script>window.top.location ='spc_prm_add_on.php?hyperlink=product&product_categories=$product_category";
							}else
							{
								if($_REQUEST['hyperlink']=='index2')
								{
									$target_url .= "<script>window.top.location ='spc_prm_add_on.php?hyperlink=product&product_categories=$product_category";
								}else
								{
									$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
								}
							}
							$target_url .= "'</script>";
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='refill_gas_promotion')
						{
							$target_url .= "<script>window.top.location ='shopping_cart.php?hyperlink=product&product_categories=$product_category";
							$target_url .= "'</script>";
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='weekly_promotion')
						{
							$target_url .= "<script>window.top.location ='shopping_cart.php?hyperlink=product&product_categories=$product_category";
							$target_url .= "'</script>";
							echo $target_url;
						}else if($_REQUEST['hyperlink']=='welcome_2016')
						{
							$target_url .= "<script>window.top.location ='wlc_prm_add_on.php?hyperlink=product&product_categories=$product_category";
							$target_url .= "'</script>";
							echo $target_url;
						}else
							{
								$target_url .= "<script>window.top.location ='index.php?hyperlink=home&product_categories=$product_category";
								$target_url .= "'</script>";
									
								echo $target_url;
							}
						}
				}
			}else//if product is repeated product, then...
			{
				if(isset($_REQUEST['product_id']))
				{
					$product_id = $_REQUEST['product_id'];
					product_verification($product_id);
				}else
				{
					$product_id = $_REQUEST['product_id'];
				}
				
				if(isset($_REQUEST['product_category_id']))
				{
					$product_category_id = $_REQUEST['product_category_id'];
				}
				
				if(isset($_REQUEST['product_qty']))
				{
					$product_qty = $_REQUEST['product_qty'];
				}
				
				if(isset($_REQUEST['trigger']))
				{
					$trigger = $_REQUEST['trigger'];
				}else
				{
					$trigger = '';
				}
				
				$order_qty = $_SESSION['order_qty'];
				if(isset($order_qty))
				{
					for($x_value='0'; $x_value < $order_qty; $x_value++)
					{
						if($_SESSION['product_id'][$x_value] =='1' && $_SESSION['product_category_id'][$x_value] =='1')
						{
							commercial_validate_mygazRefillPrd($product_id, $product_qty, $_SESSION['product_qty'][$x_value]);
						}
						
						if($_SESSION['product_id'][$x_value] == $product_id)
						{
							if(validate_product_qty($product_id, $_SESSION['product_qty'][$x_value]))
							{
								if($trigger == 'product')
								{
									$_SESSION['product_qty'][$x_value] = $_SESSION['product_qty'][$x_value] + $product_qty;
								}else{
									$_SESSION['product_qty'][$x_value]++;
								}
							}else
							{
								$message = "Sorry! Products selected is out of stock! Thank for your orders!";
								echo "<script type='text/javascript'>alert('$message');</script>";
								echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=product';</script>";
								exit;
							}
						}
					}
				}else
				{
					echo "";
				}
				
				if(isset($_REQUEST['hyperlink']))
				{
					if($_REQUEST['hyperlink']=='home')
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home&product_id=$product_id';</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='promotion')
					{
						echo "<script language='JavaScript'>window.top.location ='promotions.php?hyperlink=promotion&id=".$id;
						echo "'</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='product')
					{
						echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product&product_id=$product_id';</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='tupperware')
					{
						echo "<script language='JavaScript'>window.top.location ='tupperwares.php?hyperlink=tupperware&product_id=$product_id';</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='tupperware_hamper')
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home&product_id=$product_id';</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='refill_gas_promotion')
					{
						echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=home&product_id=$product_id';</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='index')
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home&product_id=$product_id';</script>";
						exit;
					}else if($_REQUEST['hyperlink']=='index2')
					{
						if(product_add_on_link($product_id) == true)
						{
							echo "<script language='JavaScript'>window.top.location ='spc_prm_add_on.php?hyperlink=product&product_id=$product_id';</script>";
						}else
						{
							if($_REQUEST['hyperlink']=='index2')
							{
								echo "<script language='JavaScript'>window.top.location ='spc_prm_add_on.php?hyperlink=product&product_id=$product_id';</script>";
							}else
							{
								echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=product&product_id=$product_id';</script>";
							}
						}
						
						
						exit;
					}else if($_REQUEST['hyperlink']=='welcome_2016')
					{
						echo "<script language='JavaScript'>window.top.location ='wlc_prm_add_on.php?hyperlink=product&product_id=$product_id';</script>";
						exit;
					}else
					{
						echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home&product_id=$product_id';</script>";
						exit;
					}
				}
			}
		
			// echo('<br>');
			
			// for($i=0; $i<$_SESSION['order_qty']; $i++)
			// {
				// echo ('Order Qty: '.$_SESSION['order_qty'].'<br>');
				// if(isset($_SESSION['product_id'][$i]))
				// {
					// echo ('product_id: '.$_SESSION['product_id'][$i].'<br>');
				// }
				// if(isset($_SESSION['product_qty'][$i]))
				// {
					// echo ('product_qty: '.$_SESSION['product_qty'][$i].'<br>');
				// }
				// echo ('<br>');
			// }
			
		}
		
	}

}else if($act == 'delete')//perform delete action
{
	if(isset($_GET['delete_id']))
	{
		$delete_id = $_GET['delete_id'];
	}
	if(isset($_SESSION['order_qty']))
	{
		$order_qty = $_SESSION['order_qty'];
	}
	
	
	if($delete_id == '0' && $order_qty == '1')
	{
		unset($_SESSION['order_qty']);
		unset($_SESSION['product_id'][0]);
		unset($_SESSION['product_qty'][0]);
		echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
	}else
	{
		$obj = new LinkList();
		$product_order = Array();
		
		//insert all the product info into linklist
		for($x=0; $x<$order_qty; $x++)
		{
			$product_order[0][0] = $_SESSION['product_id'][$x];
			$product_order[0][1] = $_SESSION['product_qty'][$x];
			$obj-> insert($product_order, $x);
		}
		
		$obj->deleteNode($delete_id);
		$obj->assignSession_product();
	}
}

//a function use to avoid repeated product add to cart
function validate_product()
{
	$validate_product = False;
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{
		if(isset($_SESSION['product_id'][$i]))
		{
			if($_SESSION['product_id'][$i] != $_REQUEST['product_id'])
			{
				$validate_product = True;
			}else
			{
				$validate_product = False;
				return $validate_product;
				break;
			}
		}
	}
	return $validate_product;
}

//a function use to check for product stock available
function validate_product_qty($prd_id, $prd_order_qty)
{
	require_once("connection/pbmartconnection.php");
	
	if(strpos($prd_id, 'PKG_') !== false)
	{
		$product_ids = explode("PKG_", $prd_id);
		$product_ids2 = $product_ids[1];
		$sql = "Select promotion_package_stock AS product_stock FROM pbmart_promotion WHERE promotion_id ='$product_ids2'";
	}else
	{
		$sql = "Select product_id, product_stock FROM pbmart_product WHERE product_id ='$prd_id'";
	}
	
		$rs = @mysql_query($sql);
		$rw = @mysql_fetch_array($rs);
		
		$product_stock = $rw['product_stock'];
		
		//echo ('Total stock: '.$product_stock.'<br/>');
		//echo ('Current Order qty: '.$prd_order_qty.'<br/>');
	
	if($product_stock == '0')
	{
		return false;
	}else
	{
		$pd_order_qty = $prd_order_qty + 1;
		//echo ('Order qty: '.$pd_order_qty.'<br/>');
		if($pd_order_qty <= $product_stock && $product_stock >= $pd_order_qty)
		{
			return true;
		}else
		{
			return false;
		}
	}
	unset($product_stock);
	unset($prd_order_qty);
}


//function use to check selected product is either buy before
function validate_mygazDep($prds_id, $prds_class)
{
	require_once("connection/pbmartconnection.php");
	get_UsrInfo();
	GLOBAL $member_id;
	$prd_count = "0";
	
		$sql = "SELECT
				pbmart_order.order_number,
				pbmart_order.order_customer_id,
				pbmart_order.order_status,
				pbmart_order_list.order_product_id,
				pbmart_order_list.order_product_class,
				pbmart_order_list.order_product_amount
			FROM pbmart_order
			INNER JOIN pbmart_order_list
			ON pbmart_order.order_number = pbmart_order_list.order_number
			
			WHERE (pbmart_order_list.order_product_id = '$prds_id')
			AND pbmart_order.order_customer_id = '$member_id' AND pbmart_order_list.order_product_class='$prds_class' AND pbmart_order.order_status !='2'";
	
		$iCount = mysql_query($sql);
		
		if($prds_class == "Promotion")
		{
			while($rw = mysql_fetch_array($iCount))
			{
				$prd_count += $rw['order_product_amount'];
			}
			$prd_count = $prd_count /2;
			echo $prd_count;
			return $prd_count;
		}else
		{
			return $Count = @mysql_num_rows($iCount);	
		}
}

//function use to check validated product is either in cart(Only for specific product)
function validate_mygazPrd($prd_id)
{
	$count = '0';
	$validate_product = False;
	for($i=0; $i<$_SESSION['order_qty']; $i++)
	{
		if(isset($_SESSION['product_id'][$i]))
		{
			if($_SESSION['product_id'][$i] =='7' || $_SESSION['product_id'][$i] =='8' )
			{
				$count = $count + 1;
			}else
			{
				
			}
		}
	}
	return $count;
}

//function use to check product limit for commercial user
function commercial_validate_mygazRefillPrd($prd_id, $prd_qty, $prd_qty_ords)
{
	require_once("connection/pbmartconnection.php");
	get_UsrInfo();
	GLOBAL $member_commercial_status;
	GLOBAL $member_commercial_class;
	GLOBAL $commercial_prd_limit;
	
	if($member_commercial_status == '1')
	{	
		if($member_commercial_class =='1')
		{
			
		}else if($member_commercial_class =='2')
		{
		
			if($prd_id == '1' && $commercial_prd_limit !='0')
			{
				$prd_qty = $prd_qty + $prd_qty_ords;
				if($prd_qty > $commercial_prd_limit)
				{
					echo $prd_qty_ords;
					$message = "*Note: You can only purchase ".$commercial_prd_limit." of the REFILL GAS CYLINDER! Thanks!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
					exit;
				}
			}
		}
	}else
	{
		
	}
}


//function
//1.Check for product stock and display msg
//2.Check for product t&c
function product_verification($prd_id)
{
	require_once("connection/pbmartconnection.php");
	
		if(strpos($prd_id, 'PKG_') !== false)
		{
			$product_ids = explode("PKG_", $prd_id);
			$product_ids2 = $product_ids[1];
			$product_id = $product_ids2;
			$sql = "Select promotion_id, promotion_package_stock AS product_stock, promotion_package_limit AS product_limit, promotion_package_lifetime_limit AS product_lifetime_limit FROM pbmart_promotion WHERE promotion_id ='$product_ids2'";
			$product_class = "Promotion";
		}else
		{
			$sql = "Select product_id, product_stock, product_limit, product_lifetime_limit FROM pbmart_product WHERE product_id ='$prd_id'";
			$product_id = $prd_id;
			$product_class = "Product";
		}
		
			$rs = @mysql_query($sql);
			$rw = @mysql_fetch_array($rs);
			$product_stock = $rw['product_stock'];
			$product_limit = $rw['product_limit'];
			$product_lifetime_limit = $rw['product_lifetime_limit'];
			
			//echo ('Total stock: '.$product_stock.'<br/>');
			//echo ('Current Order qty: '.$prd_order_qty.'<br/>');
		
		if($product_stock == '0')
		{
			error_msg();
		}else
		{
			if($product_lifetime_limit !="0")
			{
				if(validate_mygazDep($product_id, $product_class) >= $product_lifetime_limit)
				{
					limit_product_msg();	
				}else
				{
					
				}
			}
		}
	
	if($_SESSION['order_qty'] != '0')
	{ 
		if($product_limit !='0')
		{ 
			for($i=0; $i<$_SESSION['order_qty']; $i++)
			{
				if(isset($_SESSION['product_id'][$i]))
				{					
					if($_SESSION['product_id'][$i] == $prd_id)
					{
						if($_SESSION['product_qty'][$i] >= $product_limit)
						{
							$message = "Selected product already in your cart! Thank you!";
							echo "<script type='text/javascript'>alert('$message');</script>";
							echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
							exit;
						}
					}
				}
			}
		}else
		{
			return 0;
		}
	}else
	{
		return 0;
	}
	unset($product_stock);
	unset($prd_order_qty);
}

function product_quantity_verification($prd_id, $prd_qty)
{
	require_once("connection/pbmartconnection.php");
	include('class/product.php');
	$product = get_product_by_id($prd_id);
	$product_id = getProduct_ID($prd_id);
	
	
	if(strpos($prd_id, 'PKG_') !== false)
	{
		return $prd_qty;
	}else
	{
		$display_product_price = $product[$product_id]->_product_price;
		if($product[$product_id]->_product_stock_minimum !='1' && $product[$product_id]->_product_stock_minimum !='0')
		{
			if($prd_qty > $product[$product_id]->_product_stock_minimum)
			{
				return $prd_qty;
			}else
			{ 
				return $product[$product_id]->_product_stock_minimum;
			}
		}else
		{
			return $prd_qty;
		}
	}
}

function product_add_on_link($prd_id)
{
	require_once("connection/pbmartconnection.php");
	require_once('class/product.php');
	$product = get_product_by_id($prd_id);
	$product_id = getProduct_ID($prd_id);
	
	if($product[$product_id]->_product_add_on =='1')
	{
		return true;
	}else
	{	
		return false;
	}
}
?>