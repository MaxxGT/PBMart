<?php
include('header.php');
require_once("connection/pbmartconnection.php");
// Author: VOONG TZE HOWE
// Date Writen: 02 Feb 2014
// Description : Promotion page
// Last Modification:

$current_date = date("Y-m-d");
$others_fee = '3.40';
$count = '0';

$query_promotion = mysql_query("SELECT * FROM pbmart_promotion WHERE promotion_package_stock !='0' AND promotion_package_stock >'0'");
if(@mysql_num_rows($query_promotion) == '0')
{
	echo "<script language='JavaScript'>window.top.location ='more_promotions.php?hyperlink=promotion';</script>";
	exit;
}

$sql_p = "SELECT * FROM pbmart_promotion WHERE promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <= '$current_date' AND promotion_end_date >= '$current_date'";
$query_promotion2 = mysql_query($sql_p);
if(@mysql_num_rows($query_promotion2) == '0')
{
	echo "<script language='JavaScript'>window.top.location ='more_promotions.php?hyperlink=promotion';</script>";
	exit;
}
?>
<!DOCTTYPE HTML>

<style>

#footers {
    position:absolute;
    bottom:0;
    width:100%;
    height:60px;   /* Height of the footer */
}
</style>


<html>
<TITLE>PBMart Promotion Pages</TITLE>
<BODY>
<link rel="stylesheet" type="text/css" href="css/promotion/promotion.css">
 <div id="main">
	<table border='0' width="987px">
		<tr>
			<td width='220px' valign='top'><?php include('sidebar.php'); ?></td>
			<td valign="top">
				<h1> Our Promotions </h1> <br />
				
				<?php include('page_navigate.php'); ?>
				<BR/>
				<table class="hoverTable" border='0' width='480px'>
				<?php
					$sql_query = mysql_query("SELECT * FROM pbmart_promotion_category");
					while($row_promotion = mysql_fetch_array($sql_query))
					{
						$promotion_category_id = $row_promotion['promotion_category_id'];
						$promotion_category_name = $row_promotion['promotion_category_name'];
						$promotion_category_photo = $row_promotion['promotion_category_photo'];
						
						$sql_promotion = mysql_query("SELECT COUNT(*) AS c_promotion FROM pbmart_promotion WHERE promotion_package_stock !='0' AND promotion_package_stock >'0' AND promotion_start_date <='$current_date' AND promotion_end_date >='$current_date' AND promotion_category_id='$promotion_category_id'");
						$r_promotion = mysql_fetch_assoc($sql_promotion);
						$c_promotion = $r_promotion['c_promotion'];
						
						if($c_promotion !='0')
						{
						?>
							<tr>
								<td align='left'>
									<center>
										<a href="promotions.php?hyperlink=promotion&id=<?php echo $promotion_category_id; ?>" title="<?php echo $promotion_category_name; ?>">
											<img align='left' src='cmanage/promotion_category/<?php echo $promotion_category_photo; ?>'></img>
										</a>
									</center>
								</td>
							</tr>
					<?php } 
					} ?>
				</table>
			</td>
		</tr>
	</table>
	</div>
	<div id="footer">
		<?php include('footer.php'); ?>
	</div>
</BODY>
</html>

