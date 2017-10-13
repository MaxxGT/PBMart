<?php
include("connection/pbmartconnection.php");
?>
<!dotype html>
<html>
	<head>
		<B><U>PBMART COMMERCIAL LISTING</U></B>
	</head>
	<body>
		<table border='1' width='100%'>
			<tr>
				<td colspan='6'>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td>No.</td>
				<td>Company Name</td>
				<td>Member Number</td>
				<td>Contact Number</td>
				<td>Price(RM)</td>
				<td>Remark</td>
			</tr>
			
			
				<?php
				$iCount = '1';
				$sql_commercial = "SELECT pbmart_commercial.commercial_company, member_number, pbmart_commercial.commercial_phone, member_commercial_class FROM pbmart_member inner join pbmart_commercial on
									pbmart_member.member_id= pbmart_commercial.commercial_member_id AND
									pbmart_member.member_number = pbmart_commercial.commercial_member_number
									";
				$rs = mysql_query($sql_commercial,$link);
				while($rw = mysql_fetch_array($rs))
				{
					?>
						<tr>
						<td><?php echo $iCount; ?></td>
						<td><?php echo $rw['commercial_company']; ?></td>
						<td><?php echo $rw['member_number']; ?></td>
						<td><?php echo $rw['commercial_phone']; ?></td>
						<td><?php
							if($rw['member_commercial_class'] == '1')
								echo "RM28.60";
							else
								echo "RM25.60";
						?></td>
						</tr>
		  <?php
			$iCount++;
		  }
				?>
				<td>
				</td>
		</table>
	</body>
</html>