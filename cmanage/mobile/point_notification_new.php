<?php

  $dbhost = 'localhost';
    $dbuser = 'pbmartdb';
    $dbpass = 'swin12345';
    $db = 'pbmart';
    
  $pc=$_POST['point'];
  $mssg=$_POST['message'];
 session_start();   
	
$device_counter_point=0;
    // Connect Database
    $conn = @mysql_connect($dbhost,$dbuser,$dbpass) or die (mysql_error());
    mysql_select_db($db, $conn) or die(mysql_error());
   
   
   
    //Outer Loop to save all eligable customer ID's
    
    $idarray=array();
   $data = array();		
$firstloop=mysql_query("SELECT mobile_devices.id, mobile_devices.device_id, mobile_devices.type, pbmart_member.member_point FROM mobile_devices INNER JOIN pbmart_member ON mobile_devices.id = pbmart_member.member_id WHERE pbmart_member.member_point >'$pc'",$conn);
$number_of_rows_initial=mysql_num_rows($firstloop);
while (($row = mysql_fetch_array($firstloop, MYSQL_ASSOC)) !== false){
  $idarray[] = $row; // add the row in to the results (data) array
 // print_r($idarray);
 // echo $idarray[0]['id'];
 // echo  $idarray[0]['device_id'];
 // echo $idarray[0]['type'];
 
}
		

for($counter=0; $counter<$number_of_rows_initial; $counter++)   
		{
			$id=$idarray[$counter]['id'];
			$deviceToken=$idarray[$counter]['device_id'];
			$type=$idarray[$counter]['type'];



if($type=='ios'){

//$deviceToken = $idarray[$counter]['device_id'];
$device_counter_point=$device_counter_point+1;

// Put your private key's passphrase here:
$passphrase = 'pbmart911';

// Put your alert message here:
$message = $mssg;

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS',"<br />" . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result){
	echo "<br />",'Message not delivered' . PHP_EOL;
}else{
	echo "<br />",'Message successfully delivered' . PHP_EOL;
}
// Close the connection to the server
fclose($fp);
}elseif($type=='and'){
  
    //to be implemeted for Android
    
    $device_counter_point=$device_counter_point+1;
	//echo $device_counter;
	
	//$deviceToken = $idarray[$counter]['device_id'];
        //echo $deviceToken,"<br />";
	include_once 'GCM.php';
    
    $gcm = new GCM();
    $text=$mssg;
    $registatoin_ids = array($deviceToken);
    $message = array("price" => $text);

    $result = $gcm->send_notification($registatoin_ids, $message);
   
    echo $result;
	
   
	
}else{
   echo "Nothing To do!","<br /";
}


                }
             

//echo "I am Here";
mysql_close($conn);
$_SESSION['dcp']=$device_counter_point;
//$_SESSION['dcp']=3; 
header('Location: notification.php');

exit();