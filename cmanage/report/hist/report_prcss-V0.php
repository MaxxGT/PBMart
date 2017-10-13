<?php
$product = (isset($_POST['product']) ? $_POST['product'] : '');
$promotions = (isset($_POST['promotion']) ? $_POST['promotion'] : '');
$year = $_POST['year'];
$month_from  = $_POST['month_from'];
$month_to = $_POST['month_to'];
$btnSubmit = $_POST['btnSubmit'];
?>

<?php 
	if($btnSubmit == "View Report")
	{ ?>
		<form id="form" name="form" action="report_list.php" method="post">
			<input type="hidden" name="year" value="<?php echo $year; ?>"></input>
			<input type="hidden" name="month_from" value="<?php echo $month_from; ?>"></input>
			<input type="hidden" name="month_to" value="<?php echo $month_to; ?>"></input>
			<script language="JavaScript">document.form.submit();</script>
		</form>
	<?php
	}else if($btnSubmit == "Generate PDF")
	{ ?>
		<form id="form" name="form" action="report_pdf.php" method="post">
			<input type="hidden" name="year" value="<?php echo $year; ?>"></input>
			<input type="hidden" name="month_from" value="<?php echo $month_from; ?>"></input>
			<input type="hidden" name="month_to" value="<?php echo $month_to; ?>"></input>
			<script language="JavaScript">document.form.submit();</script>
		</form>
	<?php
	}else if($btnSubmit == "Generate Products Reports")
	{ ?>
		<form id="form" name="form" action="report_product.php" method="post">
			<?php
				if(isset($product) && $product !="")
				{
					foreach($product as $member)
					{
					  echo '<input type="hidden" name="product[]" value="'. $member. '">';
					}
				}
			?>
			<input type="hidden" name="year" value="<?php echo $year; ?>"></input>
			<input type="hidden" name="month_from" value="<?php echo $month_from; ?>"></input>
			<input type="hidden" name="month_to" value="<?php echo $month_to; ?>"></input>
			<script language="JavaScript">document.form.submit();</script>
		</form>
	<?php
	}else if($btnSubmit == "Generate Promotions Reports")
	{ ?>
		<form id="form" name="form" action="report_promotion.php" method="post">
			<?php
				if(isset($promotions) && $promotions !="")
				{	
					foreach($promotions as $member)
					{
					  echo '<input type="hidden" name="promotion[]" value="'. $member. '">';
					}
				}
			?>
			<input type="hidden" name="year" value="<?php echo $year; ?>"></input>
			<input type="hidden" name="month_from" value="<?php echo $month_from; ?>"></input>
			<input type="hidden" name="month_to" value="<?php echo $month_to; ?>"></input>
			<script language="JavaScript">document.form.submit();</script>
		</form>
	<?php
	}else
	{ ?>
		<form id="form" name="form" action="report_list.php" method="post">
			<input type="hidden" name="year" value="<?php echo $year; ?>"></input>
			<input type="hidden" name="month_from" value="<?php echo $month_from; ?>"></input>
			<input type="hidden" name="month_to" value="<?php echo $month_to; ?>"></input>
			<script language="JavaScript">document.form.submit();</script>
		</form>
		
<?php	} ?>

