<?php
//product class
class product
{
	public $_product_id;
	public $_product_category_id;
	public $_product_category;
	public $_product_name;
	public $_product_model;
	public $_product_price;
	public $_product_commercial_price;
	public $_product_commercial_price2;
	public $_product_handling;
	public $_product_commercial_handling;
	public $_product_commercial_handling2;
	public $_product_handling_show;
	public $_product_commercial_handling_show;
	public $_product_commercial_handling_show2;
	public $_product_point;
	public $_product_commercial_point;
	public $_product_commercial_point2;
	public $_product_double_point;
	public $_product_commercial_double_point;
	public $_product_commercial_double_point2;
	public $_product_sale;
	public $_product_sale1;
	public $_product_sale_percentage1;
	public $_product_sale2;
	public $_product_sale_percentage2;
	public $_product_sale3;
	public $_product_sale_percentage3;
	public $_product_stock;
	public $_product_limit;
	public $_product_lifetime_limit;
	public $_product_stock_class;
	public $_product_stock_minimum;
	
	public $_product_image;
	public $_product_alt;
	public $_product_description;
	public $_product_show;
	
	public $_product_add_on;
	public $_product_add_on_category_id;
	public $_product_add_on_category_id2;

	
	function getProductId(){return 'PRODUCT'.str_pad($this->_product_id,4,0000, STR_PAD_LEFT);}
	
	function setProduct
	(
		$product_id, $product_category_id, $product_category, $product_name, $product_model, $product_price, $product_commercial_price, $product_commercial_price2, $product_handling, $product_commercial_handling, $product_commercial_handling2, $product_handling_show, $product_commercial_handling_show, $product_commercial_handling_show2, $product_point, $product_commercial_point, $product_commercial_point2, $product_double_point, $product_commercial_double_point, $product_commercial_double_point2, $product_sale, $product_sale1, $product_sale_percentage1, $product_sale2, $product_sale_percentage2, $product_sale3, $product_sale_percentage3, $product_stock, $product_limit, $product_lifetime_limit, $product_stock_class, $product_stock_minimum, $product_image, $product_alt, $product_description, $product_show, $product_add_on, $product_add_on_main_product_id
	)
	{
		$this->_product_id = $product_id;
		$this->_product_category_id = $product_category_id;
		$this->_product_category = $product_category;
		$this->_product_name = $product_name;
		$this->_product_model = $product_model;
		$this->_product_price = $product_price;
		$this->_product_commercial_price = $product_commercial_price;
		$this->_product_commercial_price2 = $product_commercial_price2;
		$this->_product_handling = $product_handling;
		$this->_product_commercial_handling = $product_commercial_handling;
		$this->_product_commercial_handling2 = $product_commercial_handling2;
		$this->_product_handling_show = $product_handling_show;
		
		$this->_product_commercial_handling_show = $product_commercial_handling_show;
		$this->_product_commercial_handling_show2 =$product_commercial_handling_show2;
		$this->_product_point =$product_point;
		$this->_product_commercial_point =$product_commercial_point;
		$this->_product_commercial_point2 =$product_commercial_point2;
		$this->_product_double_point =$product_double_point;
		$this->_product_commercial_double_point =$product_commercial_double_point;
		$this->_product_commercial_double_point2 =$product_commercial_double_point2;
		$this->_product_sale =$product_sale;
		$this->_product_sale1 =$product_sale1;
		$this->_product_sale_percentage1 =$product_sale_percentage1;
		$this->_product_sale2 =$product_sale2;
		$this->_product_sale_percentage2 =$product_sale_percentage2;
		$this->_product_sale3 =$product_sale3;
		$this->_product_sale_percentage3 =$product_sale_percentage3;
		$this->_product_stock =$product_stock;
		$this->_product_limit =$product_limit;
		$this->_product_lifetime_limit =$product_lifetime_limit;
		
		$this->_product_stock_class = $product_stock_class;
		$this->_product_stock_minimum = $product_stock_minimum;
		
		$this->_product_image =$product_image;
		$this->_product_alt =$product_alt;
		$this->_product_description =$product_description;
		$this->_product_show =$product_show;
		$this->_product_add_on =$product_add_on;
		$this->_product_add_on_main_product_id =$product_add_on_main_product_id;
	}
	
	
}

function get_product_by_id($product_id)
{
	$Product = array();
	$query = "SELECT * FROM pbmart_product WHERE product_id = '$product_id'";
	$result = @mysql_query($query);
	while ($row = @mysql_fetch_array($result))
	{
            $list = new Product();
			$list->setProduct($row['product_id'],$row['product_category_id'],$row['product_category'],$row['product_name'],$row['product_model'],$row['product_price'],$row['product_commercial_price'],$row['product_commercial_price2'],$row['product_handling'],$row['product_commercial_handling'],$row['product_commercial_handling2'],$row['product_handling_show'],$row['product_commercial_handling_show'],$row['product_commercial_handling_show2'],$row['product_point'],$row['product_commercial_point'],$row['product_commercial_point2'],$row['product_double_point'],$row['product_commercial_double_point'],$row['product_commercial_double_point2'],$row['product_sale'],$row['product_sale1'],$row['product_sale_percentage1'],$row['product_sale2'],$row['product_sale_percentage2'],$row['product_sale3'],$row['product_sale_percentage3'],$row['product_stock'],$row['product_limit'],$row['product_lifetime_limit'], $row['product_stock_class'], $row['product_stock_minimum'], $row['product_image'],$row['product_alt'],$row['product_description'],$row['product_show'], $row['product_add_on'], $row['product_add_on_main_product_id']);
			
			$Product[$list->getProductId()] = $list;
	} return $Product;
}

function getProduct_ID($product_id)
{
		global $member_id;
		$query = "SELECT commercial_id, commercial_member_id FROM pbmart_commercial WHERE commercial_member_id = '$member_id'";
		$result = @mysql_query($query);
        $row = @mysql_fetch_assoc($result);
		$commercial_id = $row['commercial_id'];
		return 'PRODUCT'.str_pad($product_id,4,0000, STR_PAD_LEFT);
}
?>
