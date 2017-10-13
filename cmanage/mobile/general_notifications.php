<?php	
	session_start();

	$device_counter=0;
	$mssg = $_POST['ge_message'];
  	$dbhost = 'localhost';
	$dbuser = 'pbmartdb';
    	$dbpass = 'swin12345';
    	$db = 'pbmart';
    
    
    //Face Book Auto Post Implementation
  
 // require Facebook PHP SDK
 // see: https://developers.facebook.com/docs/php/gettingstarted/
    
    require_once("facebook.php");
    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

 
// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install
$config = array();
$config['appId'] = '363647217137810';
$config['secret'] = '3664cdabcdace0ecf055bc372c0dc578';
$config['fileUpload'] = false; // optional
 
$fb = new Facebook($config);
 
// define your POST parameters (replace with your own values)
$params = array(
  "access_token" => "CAAFKvDczeJIBAI2MpLTB3aCGgoSZAZCKyyJNbXemFu7rj6titAnv9xypWC7YcbC1vfNobgA5bSQ3ZBRjmvtL47Bno2ftMFe2igeX21Fr96bX8RAtCtnEz2Xi2bMzdIj27torBXQn2TCIf71tZCEyZAvBcHHh3FQb0MsJE0jxHZC24i54vaTDNAUXLUFV719IiUbtBgECjtQyNVbXPsJVZBV", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
  "message" => $mssg,
//  "link" => "",
 // "picture" => "",
  "name" => "Test",
  "caption" => "Test",
  "description" => "Automatically post on Facebook."
);
 
// post to Facebook
// see: https://developers.facebook.com/docs/reference/php/facebook-api/
try {
  $ret = $fb->api('/1411129302492411/feed', 'POST', $params);
 // echo 'Successfully posted to Facebook',"<br />";
} catch(Exception $e) {
 // echo $e->getMessage(),"<br />";
}
//Face Book Implementation Ends   
    
	
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
 
						}
		
	

	for($counter=0; $counter<$number_of_rows_initial; $counter++)   
		{
                $id=$idarray[$counter]['device_id'];
           	$type=$idarray[$counter]['type'];
           
           
                if($type=='ios'){
                   // echo $id;
                  //  echo $message;
                  //  $deviceToken = $row_dev['device_id'];
                    $device_counter=$device_counter+1;
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

if (!$fp){
	exit("Failed to connect: $err $errstr" . PHP_EOL);
				}else{
				echo 'Connected to APNS',"<br />" . PHP_EOL;
									}
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
                   // $id=$idarray[$counter]['device_id'];
                   // echo $id;
                   // echo $mssg;
                    $message=$mssg;
                    $device_counter=$device_counter+1;
   //                 echo "Number of devices Processed For Push Notifications: '$device_counter'","<br />";
                    include_once 'GCM.php';
    
    $gcm = new GCM();
    $text=$message;
    $registatoin_ids = array($id);
    $message = array("price" => $text);

    $result = $gcm->send_notification($registatoin_ids, $message);
   
    //echo $result;
	
  //  echo "<br />","Test for Android Script","<br />";
                }
                
                }
	//echo $message;
     mysql_close($conn);
     /*       
    Echo "<html>"; 
    Echo "<title>Proccssing Completed</title>"; 
    Echo "<br />";
    Echo "<h1>Processing Completed</h1>";
    Echo "<br />";
    Echo "<b>Press the Back button on Your browser to return to the notification menu page.</b>";   
    */
    $_SESSION['device_counter'] = $device_counter;
    header('Location: notification.php');            
    exit();
                


          