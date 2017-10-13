<?php	
	
$message = $_POST['message'];
//$mssg = 'Waky Waky Murti !!!!.';

  $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'pbmart';
    
    
  
    
	
//Mobile Devices Android and iOS Implementation Begins
    // Connect Database
    $conn = @mysql_connect($dbhost,$dbuser,$dbpass) or die (mysql_error());
    mysql_select_db($db, $conn) or die(mysql_error());
   
   
   
    //Outer Loop to save all eligable customer ID's
    
    $idarray=array();
   		
$firstloop=mysql_query("Select device_id,type FROM mobile_devices",$conn);
$number_of_rows_initial=mysql_num_rows($firstloop);
while (($row = mysql_fetch_array($firstloop, MYSQL_ASSOC)) !== false){
  $idarray[] = $row; // add the row in to the results (data) array
 // print_r($idarray);
}
		

for($counter=0; $counter<$number_of_rows_initial; $counter++)   
		{
                $id=$idarray[$counter]['device_id'];
                if($idarray[$counter]['type']=='ios'){
                   // echo $id;
                  //  echo $message;
                  //  $deviceToken = $row_dev['device_id'];

// Put your private key's passphrase here:
$passphrase = 'pbmart911';

// Put your alert message here:
//$message = "PBMart - Check Your Gas Cylinders! Time to Order? '$id'";
$message = $mssg;
////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = @stream_socket_client(
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
$msg = chr(0) . pack('n', 32) . pack('H*', $id) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result){
	echo "<br />",'Message not delivered' . PHP_EOL;
}else{
	echo "<br />",'Message successfully delivered' . PHP_EOL;
}
// Close the connection to the server
fclose($fp);
                }else{
                    $id=$idarray[$counter]['device_id'];
                   // echo $id;
                   // echo $mssg;
                    $message=$mssg;
                    include_once 'GCM.php';
    
    $gcm = new GCM();
    $text=$message;
    $registatoin_ids = array($id);
    $message = array("price" => $text);

    $result = $gcm->send_notification($registatoin_ids, $message);
   
//    echo $result;
	
  //  echo "<br />","Test for Android Script","<br />";
                }
                
                }
	//echo $message;
?>