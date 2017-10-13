<?php
require_once("connection/pbmartconnection.php");
get_UsrInfo();
GLOBAL $member_id;
$total_redemption_points = 0;
$iCount = 0;
?>
<table border='1' frame='box' cellpadding="0" cellspacing="0" width='100%'>
	<tr>
		<th width="50px" style="padding-left:5;"><B>No.</B></th>
		<th width="140px" style="padding-left:5;"><B>Redemption No.</B></th>
		<th width="150px" style="padding-left:5;"><B>Redemption Date</B></th>
		<th width="400px" style="padding-left:5;"><B>Redemption Product</B></th>
		<th width="170px" style="padding-left:5;"><B>Redemption Amount</B></th>
		<th width="150px" style="padding-left:5;"><B>Redemption Points</B></th>
		<th width="90px"><B>Status</B></th>
	</tr>
	
	<?php
		$url = "SELECT * FROM pbmart_redemption_list WHERE redemption_member_id='$member_id'";
		$rs = mysqli_query($dbconnect, $url);
		while($rw = @mysqli_fetch_array($rs))
		{
			$redemption_item_id = $rw['redemption_item_id'];
			$url2 = "SELECT * FROM pbmart_redeem WHERE redeem_id='$redemption_item_id'";
			$rs2 = mysqli_query($dbconnect, $url2);
			$rw2 = @mysqli_fetch_assoc($rs2);
			$redeem_point = $rw2['redeem_point'];
			$iCount++;
			?>
			<tr>
				<td align='center'><?php echo $iCount; ?></td>
				<td align='center'><?php echo $rw['redemption_number']; ?></td>
				<td align='center'><?php echo date("d-m-Y", strtotime($rw['redemption_date'])); ?></td>
				<td align='center'><?php echo $rw['redemption_item']; ?></td>
				<td align='center'><?php echo $rw['redemption_amount']; ?></td>
				
				<td align='right'><?php 
				
				
				
				
				
					
				if($rw['redemption_points'] == $redeem_point)
				{					
					$redemption_points = $rw['redemption_points'] * $rw['redemption_amount']; 
					echo number_format($redemption_points,0);
					$total_redemption_points = $total_redemption_points + $redemption_points;
				}else
				{
					$redemption_points = $redeem_point * $rw['redemption_amount']; 
					echo number_format($redemption_points,0);
				}
				
				?></td>
				<td align='center'><?php
					
					if($rw['redemption_status'] == "0")
						{
							echo ('Pending');
						}else if($rw['redemption_status'] == "2")
						{
							echo ('Cancel');
						}else if($rw['redemption_status'] == "1")
						{
							echo ('Complete');
						}else if($rw['redemption_status'] == "3")
						{
							echo ('Refund');
						}
				
				?></td>
				
			</tr>
			
  <?php } ?>
  
	<tr>
		<td colspan='5' align='right'><B><font color='black' size='4'>Total: <font/></B>&nbsp;</td>
		<td align='right'><B><font color='black' size='4'><?php echo number_format($total_redemption_points,0); ?><font/></B></td>
		<td></td>
	</tr>
  
	<tr>
		<th colspan="8" align="center">
			&nbsp;
		</th>
	</tr>
</table>