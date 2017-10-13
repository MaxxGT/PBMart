<?php
//a function use to calculate product item to show first based on pg given
function cal_pg($pgs, $product_rows, $product_cols)
{
	$total_pgs = $pgs - 1;
	$pg_total_products = $product_rows * $product_cols;
	$total_pg = ($total_pgs * $pg_total_products) + 1;
	
	return $total_pg;
}

//a small function use to calculate total count from db
function cal($total_count)
{
	return $total_count % 3;
}

function cal_pages($product_rows, $product_cols, $total_products)
{
	$pg_total_products = $product_rows * $product_cols;

	$page = (INT)($total_products / $pg_total_products);
	$remain_products = $total_products % $pg_total_products;

	//echo ('total product: '.$total_products.'<br>');
	//echo ('page: '.$page.'<br>');
	//echo ('remain product: '.$remain_products.'<br>');

	if($remain_products >=1 && $remain_products <= $pg_total_products)
	{ $page++; }

	//echo ('page (after count): '.$page);
	return $page;
}
?>