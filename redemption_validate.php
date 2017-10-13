<?php
// Author: VOONG TZE HOWE
// Date Writen: 19-10-2014
// Description : redemption validate
// Last Modification: 27-10-2014
include('linkList_redemption.php');
$btnRd_redeem_type = (isset($_POST['btnRd_redeem_type']) ? $_POST['btnRd_redeem_type'] : '');

if(!isset($_SESSION['usr_name']))
{
	if(isset($_REQUEST['hyperlink']))
	{
		$message = "Please login to make order! Thanks!";
		
		if($_REQUEST['hyperlink']=='home')
		{	
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
		}
		
		if($_REQUEST['hyperlink']=='promotion')
		{	
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='promotions.php?hyperlink=promotion';</script>";
		}
		
		if($_REQUEST['hyperlink']=='redemption')
		{	
			$pg_id = $_GET['id'];
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='redemption.php?id=$pg_id&hyperlink=redemption';</script>";
		}
		
		if($_REQUEST['hyperlink']=='product')
		{	
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
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
		$message = "Please login to make an order! Thanks!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home';</script>";
		exit;
	}else
	{
		if(!isset($_SESSION['redeem_order_qty']))
		{
			$_SESSION['redeem_order_qty'] = '0';
			$redeem_order_qty = $_SESSION['redeem_order_qty'];
		}
		
		if($_SESSION['redeem_order_qty'] == '0')
		{
			if($btnRd_redeem_type !="")
			{
				$_SESSION['btnRd_redeem_type'] = $btnRd_redeem_type;
			}
			
			if(isset($_GET['id']))
			{
				$pg_id = $_GET['id'];
			}else
			{
				$pg_id = '0';
			}
			
			if($_GET['redeem_id'] != "")
			{
				$redeem_id = $_GET['redeem_id'];
				if($redeem_id !="")
				{
					$_SESSION['redeem_id'][$redeem_order_qty] = $redeem_id;
				}
			}
			
			if(isset($_GET['redeem_category']))
			{
				$redeem_category = $_GET['redeem_category'];
			}
			
			if(isset($_GET['redeem_qty']))
			{
				$redeem_qty = $_GET['redeem_qty'];
				if(isset($redeem_qty))
				{
					$_SESSION['redeem_qty'][$redeem_order_qty] = $redeem_qty;
				}
			}
			
			if(isset($_SESSION['redeem_id'][$redeem_order_qty]))
			{
				$_SESSION['redeem_order_qty']++;
			}

			//for($i=0; $i<$_SESSION['redeem_order_qty']; $i++)
			//{
			//	echo ('Order Qty: '.$_SESSION['redeem_order_qty'].'<br>');
			//	echo ('redeem_id: '.$_SESSION['redeem_id'][$i].'<br>');
			//	echo ('redeem_qty: '.$_SESSION['redeem_qty'][$i].'<br>');
			//	echo ('<br>');
			//}
			
			//echo $_SESSION['redeem_order_qty']; exit;
			$target_url = "";
			if(isset($target_url))
			{
				if(isset($_REQUEST['hyperlink']))
				{
					if($_REQUEST['hyperlink']=='home')
					{
						$target_url .= "<script>window.top.location ='index.php?hyperlink=home&redeem_categories=$redeem_category";
						$target_url .= "'</script>";
							
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='shp_redemption')
					{
						$target_url .= "<script>window.top.location ='shopping_cart_redemption.php?id=$pg_id&hyperlink=product";
						$target_url .= "'</script>";
							
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='redemption')
					{
						$target_url .= "<script>window.top.location ='redemption.php?id=$pg_id&hyperlink=redemption";
						$target_url .= "'</script>";
							
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='promotion')
					{
						$target_url .= "<script>window.top.location ='promotions.php?hyperlink=promotion";
						$target_url .= "'</script>";
							
						echo $target_url;
					}else if($_REQUEST['hyperlink']=='product')
					{
						$target_url .= "<script>window.top.location ='products.php?hyperlink=product&redeem_categories=$redeem_category";
						$target_url .= "'</script>";
							
						echo $target_url;
					}else
					{
						$target_url .= "<script>window.top.location ='index.php?hyperlink=home&redeem_categories=$redeem_category";
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
				if(validate_point($_REQUEST['redeem_id']))
				{
					$redeem_order_qty = $_SESSION['redeem_order_qty'];
					
					if($btnRd_redeem_type !="")
					{
						$_SESSION['btnRd_redeem_type'] = $btnRd_redeem_type;
					}
					
					if(isset($_GET['id']))
					{
						$pg_id = $_GET['id'];
					}else
					{
						$pg_id = '0';
					}
					
					if(isset($_REQUEST['redeem_id']))
					{
						$redeem_id = $_REQUEST['redeem_id'];
						if(isset($redeem_id))
						{
							$_SESSION['redeem_id'][$redeem_order_qty] = $redeem_id;
						}
					}
					
					
					if(isset($_REQUEST['redeem_category']))
					{
						$redeem_category = $_REQUEST['redeem_category'];
					}
					
					if(isset($_REQUEST['redeem_qty']))
					{
						$redeem_qty = $_REQUEST['redeem_qty'];
						if(isset($redeem_qty))
						{
							$_SESSION['redeem_qty'][$redeem_order_qty] = $redeem_qty;
						}
					}
					$_SESSION['redeem_order_qty']++;
					$target_url = "";
					if(isset($target_url))
					{
						if(isset($_REQUEST['hyperlink']))
						{
							if($_REQUEST['hyperlink']=='home')
							{
								$target_url .= "<script>window.top.location ='index.php?hyperlink=home&redeem_categories=$redeem_category";
								$target_url .= "'</script>";
									
								echo $target_url;
							}else if($_REQUEST['hyperlink']=='shp_redemption')
							{
								$target_url .= "<script>window.top.location ='shopping_cart_redemption.php?id=$pg_id&hyperlink=product";
								$target_url .= "'</script>";
									
								echo $target_url;
							}else if($_REQUEST['hyperlink']=='redemption')
							{
								$target_url .= "<script>window.top.location ='redemption.php?id=$pg_id&hyperlink=redemption";
								$target_url .= "'</script>";
									
								echo $target_url;
							}else if($_REQUEST['hyperlink']=='promotion')
							{
								$target_url .= "<script>window.top.location ='promotions.php?hyperlink=promotion";
								$target_url .= "'</script>";
									
								echo $target_url;
							}else if($_REQUEST['hyperlink']=='product')
							{
								$target_url .= "<script>window.top.location ='products.php?hyperlink=product&redeem_categories=$redeem_category";
								$target_url .= "'</script>";
									
								echo $target_url;
							}else
							{
								$target_url .= "<script>window.top.location ='index.php?hyperlink=home&redeem_categories=$redeem_category";
								$target_url .= "'</script>";
									
								echo $target_url;
							}
						}
					}
				}else
				{
					$message = "Note: You do not have enough point to redeem the product. Thanks!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=product';</script>";
					exit;
				}
			}else//if product is repeated product, then...
			{
				if(validate_point($_REQUEST['redeem_id']))
				{
					
					if($btnRd_redeem_type !="")
					{
						$_SESSION['btnRd_redeem_type'] = $btnRd_redeem_type;
					}
					
					if(isset($_REQUEST['redeem_id']))
					{
						$redeem_id = $_REQUEST['redeem_id'];
					}
					
					if(isset($_REQUEST['redeem_qty']))
					{
						$redeem_qty = $_REQUEST['redeem_qty'];
					}
					
					if(isset($_REQUEST['trigger']))
					{
						$trigger = $_REQUEST['trigger'];
					}else
					{
						$trigger = "";
					}
				
					$redeem_order_qty = $_SESSION['redeem_order_qty'];
					if(isset($redeem_order_qty))
					{
						for($i_value='0'; $i_value < $redeem_order_qty; $i_value++)
						{
							if($_SESSION['redeem_id'][$i_value] == $redeem_id)
							{
								if(validate_redeem_qty($redeem_id, $_SESSION['redeem_qty'][$i_value]))
								{
									if($trigger == 'redeem')
									{
										$_SESSION['redeem_qty'][$i_value] = $_SESSION['redeem_qty'][$i_value] + $redeem_qty;
									}else
									{
										$_SESSION['redeem_qty'][$i_value]++;
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
						echo ('Error');
					}
					
					if(isset($_REQUEST['hyperlink']))
					{
						if($_REQUEST['hyperlink']=='home')
						{
							echo "<script language='JavaScript'>window.top.location ='index.php?hyperlink=home&redeem_id=$redeem_id';</script>";
							exit;
						}
						
						if($_REQUEST['hyperlink']=='shp_redemption')
						{
							echo "<script language='JavaScript'>window.top.location ='shopping_cart_redemption.php?hyperlink=product';</script>";
							exit;
						}
						
						if($_REQUEST['hyperlink']=='redemption')
						{
							echo "<script language='JavaScript'>window.top.location ='redemption.php?hyperlink=redemption';</script>";
							exit;
						}
						
						if($_REQUEST['hyperlink']=='promotion')
						{
							echo "<script language='JavaScript'>window.top.location ='promotions.php?hyperlink=promotion';</script>";
							exit;
						}
						
						if($_REQUEST['hyperlink']=='product')
						{
							echo "<script language='JavaScript'>window.top.location ='product.php?hyperlink=product&redeem_id=$redeem_id';</script>";
							exit;
						}
					}
			
				//echo('<br>');
				
				//for($i=0; $i<$_SESSION['redeem_order_qty']; $i++)
				//{
					//echo ('Order Qty: '.$_SESSION['redeem_order_qty'].'<br>');
					//if(isset($_SESSION['redeem_id'][$i]))
					//{
					//	echo ('redeem_id: '.$_SESSION['redeem_id'][$i].'<br>');
					//}
					//if(isset($_SESSION['redeem_qty'][$i]))
					//{
					//	echo ('redeem_qty: '.$_SESSION['redeem_qty'][$i].'<br>');
					//}
					//echo ('<br>');
				//}exit;
				}else
				{
					$message = "Note: You do not have enough point to redeem the product. Thanks!";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script language='JavaScript'>window.top.location ='shopping_cart.php?hyperlink=product';</script>";
					exit;
				}
			}
		}
	}
}else if($act == 'delete')//perform delete action
{
	if(isset($_GET['delete_id']))
	{
		$delete_id = $_GET['delete_id'];
	}
	if(isset($_SESSION['redeem_order_qty']))
	{
		$redeem_order_qty = $_SESSION['redeem_order_qty'];
	}
	
	if($delete_id == '0' && $redeem_order_qty == '1')
	{
		unset($_SESSION['redeem_order_qty']);
		unset($_SESSION['redeem_id'][0]);
		unset($_SESSION['redeem_qty'][0]);
		echo "<script language='JavaScript'>window.top.location ='products.php?hyperlink=product';</script>";
	}else
	{
		$obj = new LinkList();
		$redeem_order = Array();
		
		//insert all the product info into linklist
		for($x=0; $x<$redeem_order_qty; $x++)
		{
			$redeem_order[0][0] = $_SESSION['redeem_id'][$x];
			$redeem_order[0][1] = $_SESSION['redeem_qty'][$x];
			$obj-> insert($redeem_order, $x);
		}
		
		$obj->deleteNode($delete_id);
		$obj->assignSession_redeem();
	}
}

//a function use to avoid repeated product add to cart
function validate_product()
{
	$validate_product = False;
	for($i=0; $i<$_SESSION['redeem_order_qty']; $i++)
	{
		if(isset($_SESSION['redeem_id'][$i]))
		{
			if($_SESSION['redeem_id'][$i] != $_REQUEST['redeem_id'])
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

function validate_redeem_qty($prd_id, $prd_redeem_order_qty)
{
	require_once("connection/pbmartconnection.php");
	$sql = "Select * FROM pbmart_redeem WHERE redeem_id ='$prd_id'";
	$rs = @mysql_query($sql);
	$rw = @mysql_fetch_array($rs);
	
	$redeem_stock = $rw['redeem_stock'];
	
	//echo ('Total stock: '.$redeem_stock.'<br/>');
	//echo ('Current Order qty: '.$prd_redeem_order_qty.'<br/>');
		
	$pd_redeem_order_qty = $prd_redeem_order_qty + 1;
	//echo ('Order qty: '.$pd_redeem_order_qty.'<br/>');
	if($pd_redeem_order_qty <= $redeem_stock && $redeem_stock >= $pd_redeem_order_qty)
	{
		return true;
	}else
	{
		return false;
	}
	unset($redeem_stock);
	unset($prd_redeem_order_qty);
}

//a function use to validate member point when redeem the product
function validate_point($prd_id)
{
	require_once("connection/pbmartconnection.php");
	get_UsrInfo();
	GLOBAL $member_point;
	
	$sql = "Select * FROM pbmart_redeem WHERE redeem_id ='$prd_id'";
	$rs = @mysql_query($sql, $link);
	$rw = @mysql_fetch_array($rs);
	
	$selected_redeem_point = $rw['redeem_point'];
	$total_redeem_points = '0';
	for($i=0; $i< $_SESSION['redeem_order_qty']; $i++)
	{
			if(isset($_SESSION['redeem_id'][$i]))
			{
				$selected_product_id = $_SESSION['redeem_id'][$i];
				$sql_query = @mysql_query("SELECT * FROM pbmart_redeem WHERE redeem_id = '$selected_product_id'");
				$row_query = @mysql_fetch_assoc($sql_query);
				$redeem_points = $row_query['redeem_point'] * $_SESSION['redeem_qty'][$i];
				$total_redeem_points = $total_redeem_points + $redeem_points;
			}
	}
	
	$remain_point = ($member_point - $total_redeem_points) - $selected_redeem_point;
	
	//echo 'Selected Product Redeem Point: '.$selected_redeem_point.'<br/>';
	//echo 'Selected Product Qty: '.$_SESSION['redeem_qty'][0].'<br/>';
	//echo 'Total Redeem Points: '.$total_redeem_points.'<br/>';
	//echo 'Member Point: '.$member_point.'<br/>';
	//echo 'Remaining Point: '.$remain_point.'<br/>';
	
	if($remain_point < 0)
	{
		return false;
		//echo false;
	}else
	{
		return true;
		//echo true;
	}
}
?>