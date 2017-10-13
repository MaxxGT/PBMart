<?php
// Author: VOONG TZE HOWE
// Date Writen: 09-10-2014
// Description : index home page
// Last Modification: 11-10-2014

include('header.php');
include("connection/pbmartconnection.php");


//perform site checking for site maintenance
$sql="Select * FROM pbmart_product";
$rs = @mysql_query($sql, $link);
$count = @mysql_num_rows($rs);	

if($count=='0')	
{		
	echo "<script language='JavaScript'>window.top.location ='site_maintainance.php';</script>";		
	exit;	
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();

echo $user_ip;
?>
<html>
<body>
	<table border='0'>
		<tr>
			<td valign='top'>
				<?php include('sidebar/sidebar.php'); ?>
			</td>
			
			<td valign='top'>
				<?php include('special_promotion_2016.php'); ?>
				<!-- End Content Slider -->
			</td>
		</tr>
	</table>
	<!-- End Content -->
<?php
	include('footer/more_product.php');
	include('footer/sidefull.php');
	include('footer/footer.php');
?>
</body>
</html>
