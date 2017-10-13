<?php
// Author: VOONG TZE HOWE
// Date Writen: 12-10-2014
// Description : page navigate of every pages
// Last Modification: 12-10-2014

if(isset($_GET['hyperlink']))
{
	$hyperlink = $_GET['hyperlink'];
	
	if($hyperlink == 'product')
	{
		$url='products.php?hyperlink='.$hyperlink;
		$page = 'Product';
	}
	
	if($hyperlink == 'tupperware')
	{
		$url='tupperware.php?hyperlink='.$hyperlink;
		$page = 'Tupperware';
	}
	
	if($hyperlink == 'promotion')
	{
		$url='promotions_index.php?hyperlink='.$hyperlink;
		$page = 'Promotion';
	}
	
	if($hyperlink == 'redemption')
	{
		$url='redemption.php?hyperlink='.$hyperlink;
		$page = 'Redemption Product';
	}
	
	if($hyperlink == 'account')
	{
		$url='myaccount.php?hyperlink='.$hyperlink;
		$page = 'My Account';
	}
	
	if($hyperlink == 'contact')
	{
		$url='contact.php?hyperlink='.$hyperlink;
		$page = 'Contact Us';
	}
}

if(isset($_REQUEST['product_categories']))
{
	$product_categories = $_REQUEST['product_categories'];
}else
{
	$product_categories ="";
}
if(isset($_REQUEST['keyword']))
{
	$keyword = $_REQUEST['keyword'];
}else
{
	$keyword = "";
}
?>

<p> 
	<a href="index.php?hyperlink=home"> Home </a> --> 
	<a href="<?php echo $url; ?>"> <?php echo $page; ?> </a>
	
	<?php
		if($product_categories !="" && $product_categories =="ALL")
		{ ?>
			--> <a href="<?php echo $url.'&product_categories='.$product_categories.'&keyword='.$keyword; ?>"> <?php echo('All Category'); ?> </a>
			<?php
				if($keyword!="")
				{
					echo ('--> '.$keyword);
				}
			
			?>
<?php   }else if($product_categories !="" && $product_categories !="ALL")
		{ ?>
			--> <a href="<?php echo $url.'&product_categories='.$product_categories.'&keyword='.$keyword; ?>"><?php echo $product_categories; ?> </a> 
		<?php	
			if($keyword!="")
				{
					echo ('--> '.$keyword);
				}?>
<?php   } ?>
</p>