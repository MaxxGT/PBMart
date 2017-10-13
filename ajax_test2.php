<?php
include('connection/pbmartconnection.php');
$sql="SELECT ID FROM chattest";
$con = mysql_query($sql);
$new_odr = @mysql_num_rows($con);
$last_order='0';
echo $last_order;	
?>
<!DOTYPE HTML>
<HTML>
<TITLE>

	<?php
		
		echo "PBMART(".$new_odr.")";
	?>
</TITLE>
<table border='1'>
	<tr>
		<td>ID</td>
	</tr>
		<?php
			$sql="SELECT ID FROM chattest";
			$con = mysql_query($sql);
			$lst_odr = @mysql_num_rows($con);
			$last_order = $lst_odr;
			while($test = mysql_fetch_array($con))
			{ ?>
				<tr>
					<td><?php echo $ID = $test['ID']; ?></td>
				</tr>
		<?php }
			
		?>
	</tr>
</table>
</HTML>