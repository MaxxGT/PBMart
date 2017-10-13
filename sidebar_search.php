<?php
// Author: VOONG TZE HOWE
// Date Writen: 17-10-2014
// Description : search function
// Last Modification: 15-11-2014
// Version:1.0 
if(isset($_REQUEST['product_categories']))
{
	$product_categories = mysql_real_escape_string(strip_tags(trim($_REQUEST['product_categories'])));
}else
{
	$product_categories = "";
}

if(isset($_REQUEST['keyword']))
{
	$keyword = mysql_real_escape_string(strip_tags(trim($_REQUEST['keyword'])));
}else
{
	$keyword = "";
}


$class = (isset($_GET['id']) ? $_GET['id'] : '1');
if(isset($class))
{
	if($class == '1')
	{
		$redeem_class = 'normal';
	}else if($class == '2')
	{
		$redeem_class = 'royal';
	}else
	{
		$redeem_class = 'normal';
	}
}

if(isset($_GET['hyperlink']))
{
	$hyperlink = $_GET['hyperlink'];
	
	if($_GET['hyperlink']=='home')
	{
		$redirect = 'index.php?hyperlink=home';
	}

	if($_GET['hyperlink']=='product')
	{
		$redirect = 'products.php?hyperlink=product';
	}
	
	if($_GET['hyperlink']=='tupperware')
	{
		$redirect = 'tupperware.php?hyperlink=tupperware';
	}

	if($_GET['hyperlink']=='account')
	{
		$redirect = 'myaccount.php?hyperlink=account';
	}
			
	if($_GET['hyperlink']=='contact')
	{
		$redirect = 'contact.php?hyperlink=contact';
	}
	
	if($_GET['hyperlink']=='redemption')
	{
		$redirect = 'redemption.php?hyperlink=redemption';
	}
}

//check hyperlink
if(isset($hyperlink))
{
	if($hyperlink == "product")
	{
		$search_by = "Product";
		$actions = "products.php?hyperlink=product";
		$sql_pbmart_product = "Select product_category AS category FROM pbmart_product WHERE product_stock!='0' GROUP BY product_category";
		
	}else if($hyperlink == "tupperware")
	{
		$search_by = "Tupperware";
		$actions = "tupperware.php?hyperlink=tupperware";
		$sql_pbmart_product = "Select product_category AS category FROM pbmart_product WHERE product_stock!='0' AND product_category_id='16' GROUP BY product_category";
	}else if($hyperlink == "redemption")
	{
		$search_by = "Redemption";
		$actions = "redemption.php?id=$class&hyperlink=redemption";
		$sql_pbmart_product = "Select redeem_category AS category FROM pbmart_redeem WHERE redeem_stock!='0' AND redeem_class ='$redeem_class' GROUP BY redeem_category";
	}else
	{
		$search_by = "Product";
		$actions = "products.php?hyperlink=product";
		$sql_pbmart_product = "Select product_category AS category FROM pbmart_product WHERE product_stock!='0' GROUP BY product_category";
	}
}else
{
	$search_by = "Product";
	$actions = "products.php?hyperlink=product";
	$sql_pbmart_product = "Select product_category AS category FROM pbmart_product WHERE product_stock!='0' GROUP BY product_category";
}
?>

<script language=JavaScript>
	function autoSubmit() {
	var formObject = document.forms['searchForm'];
		formObject.submit();
	}
</script>

<div class="box search">
        <h2>Search by <?php echo $search_by; ?><span></span></h2>
        <div class="box-content">
			
			
			<form action="<?php echo $actions; ?>" method="post">
				<label>Category</label>
				<select class="field" id="product_categories" name="product_categories">
				  <option value="ALL">All Categories</option>
					<?php
						$rs = mysql_query($sql_pbmart_product, $link);
						while($rw = mysql_fetch_array($rs))
						{
							if($rw['category'] == $product_categories)
							{
								$selected_category='selected';
							}else{$selected_category="";}
							?>
							<option value="<?php echo $rw['category']; ?>" <?php echo $selected_category;?>><?php echo $rw['category']; ?></option>
						<?php  $selected_category="";} ?>
				</select>

				<label>Keyword</label>
				<div class="ui-widget">
					<input id="tags" id="Keyword" name="keyword" class="field" value="<?php echo $keyword; ?>" placeholder="Keyword"></input>
				</div>
			

				<input type="submit" name="btnSubmit" class="search-submit" value="Search" title="Click to search the products"/>
				<input type="hidden" name='id' value="<?php echo $class; ?>"></input>
			</form>

			<p>
				<!--<a href="#" class="bul">Advanced search</a><br /> -->
				<a href="contact.php?hyperlink=contact" class="bul">Contact Customer Support</a>
			</p>
        </div>
</div>

<meta charset="utf-8">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css"/>
  <!-- <script src="css/jquery-1.11.1.js"></script> -->
  <script src="js/jquery-ui.js"></script>
  <link rel="stylesheet" href="css/style.css"/>
  <script>
  $(function() {
    var availableTags = [
	<?php
		if($product_categories == "ALL")
		{
			$sql="Select * FROM pbmart_product";
		}else
		{
			$sql="Select * FROM pbmart_product WHERE product_category='$product_categories'";
		}
		$rs = mysql_query($sql, $link);
		while($rw = mysql_fetch_array($rs))
		{
			$product_category = $rw['product_category'];
			$product_name = $rw['product_name'];
			if($product_category != "")
			{
				echo ('"'.$product_name.'",');
			}
		}
	?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>
</meta>