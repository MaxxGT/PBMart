<?php
// Author: VOONG TZE HOWE
// Date Writen: 14-02-2015
// Description : promotions_navigate function
// Last Modification:

require_once('products_function.php');
$current_date = date("Y-m-d");


//check for product categories and keyword
if(isset($_REQUEST['product_categories']))
{
	$product_categories = $_REQUEST['product_categories'];
}else
{
	$product_categories ="";
}
//check for keyword
if(isset($_REQUEST['keyword']))
{
	$keyword = $_REQUEST['keyword'];
}else
{
	$keyword = "";
}
$promotion_ids = (isset($_GET['id']) ? $_GET['id'] : '');
$class = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '1');
//$redeem_class = (isset($_REQUEST['redeem_class']) ? $_REQUEST['redeem_class'] : 'normal');
if(isset($class) && isset($redeem_class))
{
	if($class == '1')
	{
		$redeem_class = 'normal';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else if($class == '2')
	{
		$redeem_class = 'royal';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}else
	{
		$redeem_class = 'normal';
		$filter= "WHERE redeem_stock!='0' AND redeem_class='$redeem_class'";
	}
}

$filter=" WHERE promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date'";
								if($promotion_ids !='')
								{
									$filter = $filter. "AND promotion_category_id ='$promotion_ids'";
								}else{
									$filter = $filter;
								}
								$sql_filter = "SELECT * FROM pbmart_promotion $filter AND promotion_show='1'";
							
$sql_product = "SELECT * FROM pbmart_promotion";
$rs = @mysql_query($sql_filter, $link);
$total_product = mysql_num_rows($rs);

$product_row = 2;
$product_col = 3;

$pg = cal_pages($product_row, $product_col, $total_product);

$rows = $pg;
// This is the number of results we want displayed per page
$page_rows = 1;
// This tells us the page number of our last page
$last = ceil($rows/$page_rows);
// This makes sure $last cannot be less than 1
if($last < 1){
	$last = 1;
}
// Establish the $pagenum variable
$pagenum = 1;
// Get pagenum from URL vars if it is present, else it is = 1
if(isset($_GET['pg'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pg']);
}
// This makes sure the page number isn't below 1, or more than our $last page
if ($pagenum < 1) { 
    $pagenum = 1; 
} else if ($pagenum > $last) { 
    $pagenum = $last; 
}
// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
// This is your query again, it is for grabbing just one page worth of rows by applying $limit

$query = @mysql_query($sql_product, $link);
// This shows the user what page they are on, and the total number of pages
$textline1 = "Testimonials (<b>$rows</b>)";
$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
// Establish the $paginationCtrls variable
$paginationCtrls = '';
// If there is more than 1 page worth of results
if($last != 1){
	/* First we check if we are on page one. If we are then we don't need a link to 
	   the previous page or the first page so we do nothing. If we aren't then we
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) 
	{
        $previous = $pagenum - 1;
		$paginationCtrls .= "<a href='promotions.php?hyperlink=promotion&id=$promotion_ids&pg=$previous&product_categories=$product_categories&keyword=$keyword'> Previous | </a>";
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= "<a href='promotions.php?hyperlink=promotion&id=$promotion_ids&pg=$i&product_categories=$product_categories&keyword=$keyword'> $i |</a>";
			}
	    }
    }
	// Render the target page number, but without it being a link
	$paginationCtrls .= '<font color="black"><b>'.$pagenum.'</b></font> | ';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= "<a href='promotions.php?hyperlink=promotion&id=$promotion_ids&pg=$i&product_categories=$product_categories&keyword=$keyword' title='Go To Page $i'> $i |</a>";
		if($i >= $pagenum+4){
			break;
		}
	}
	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
	
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= "<a href='promotions.php?hyperlink=promotion&id=$promotion_ids&pg=$next&product_categories=$product_categories&keyword=$keyword' title='Next Page'> Next</a>";
    }else
	{
		$paginationCtrls.="Next";
	}
}

// Close your database connection
if($pg>= '1' && $pg <= '1')
{
	echo ('Page: <font color="black"><b>1</b></font>');
}else
{
	echo ('Page: ');
}
	
	echo $paginationCtrls;
?>
