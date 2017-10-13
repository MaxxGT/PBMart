<?php

  $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $db = 'pbmart';
    $dbtable = 'mobile_devices';
    $userT='user';
    $type='ios';


    // Connect Database
    $conn = mysql_connect($dbhost,$dbuser,$dbpass) or die (mysql_error());
    mysql_select_db($db, $conn) or die(mysql_error());
   
   
if (isset ($_GET["deviceID"]) && isset ($_GET["email"])){
    $deviceID = $_GET["deviceID"];
    $email = $_GET["email"];

} else {
  $deviceID ="fsfsfsdfsdfsdf";
 
}
//First confirm if user is already registered via website

$result = mysql_query("SELECT * FROM pbmart_member WHERE member_email='$email'",$conn);
$num_rows = mysql_num_rows($result);
// mysql_query($result,$conn) or die(mysql_error();

if ($num_rows > 0)
	{
	

	$sql = "INSERT INTO $dbtable (id, email, device_id, type) SELECT pbmart_member.member_id, pbmart_member.member_email, '$deviceID', '$type' FROM pbmart_member where member_email='$email';";
	$res = mysql_query($sql,$conn) or die(mysql_error());
	}else 
	{
	//This is where I want to return the json bolean value
	
	$response ['status']= 1; 
	echo json_encode($response);

	
	
}







mysql_close($conn);




exit();
?>