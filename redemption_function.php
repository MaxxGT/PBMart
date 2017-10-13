<?php
function commercial_user($member_id)
{
	$sql_commercial_active = "SELECT pbmart_member.member_id, pbmart_commercial.commercial_member_id
							  FROM pbmart_member, pbmart_commercial WHERE member_id='$member_id' AND  pbmart_commercial.commercial_member_id = '$member_id'
							  AND pbmart_member.member_commercial_status= '1' AND pbmart_commercial.commercial_status = '1'";				  
	$rs_commercial = @mysql_query($sql_commercial_active);
	$iCount = @mysql_num_rows($rs_commercial);
	return $iCount;
}

function tppr_stk_validation()
{
	$sql_tupperware_stock = "SELECT redeem_class FROM pbmart_redeem WHERE redeem_class='Tupperware'";
	$rs_tupperware = @mysql_query($sql_tupperware_stock);
	$iCount = @mysql_num_rows($rs_tupperware);
	return $iCount;
}
?>