<?php

  $dbhost = 'localhost';
    $dbuser = 'pbmartdb';
    $dbpass = 'swin12345';
    $db = 'pbmart';
    $dbtable = 'iosuser';
    $userT='user';
   $ldatefinal=0;
    
	

    // Connect Database
    $conn = @mysql_connect($dbhost,$dbuser,$dbpass) or die (mysql_error());
    mysql_select_db($db, $conn) or die(mysql_error());
   
   
   
    //Outer Loop to save all eligable customer ID's
    
    $idarray=array();
   		
$firstloop=mysql_query("Select id FROM mobile_devices GROUP BY id",$conn);
$number_of_rows_initial=mysql_num_rows($firstloop);
while (($row = mysql_fetch_array($firstloop, MYSQL_ASSOC)) !== false){
  $idarray[] = $row; // add the row in to the results (data) array
 // print_r($idarray);
}
		

for($counter=0; $counter<$number_of_rows_initial; $counter++)   
		{
			$id=$idarray[$counter]['id'];
			
			
			
//First confirm if user is already registered via website

$result = mysql_query("SELECT TO_DAYS(order_delivery) FROM pbmart_order WHERE order_customer_id=$id",$conn);
$num_rows = mysql_num_rows($result);
// mysql_query($result,$conn) or die(mysql_error();

//echo $num_rows;


$data = array();
$days=array();
$xAxis=array();

$ldate=array();

while (($row = mysql_fetch_array($result, MYSQL_ASSOC)) !== false){
  $data[] = $row; // add the row in to the results (data) array
}

// print_r($data); // print result


//This part is working now!!!!

for ($x = $num_rows-1 ; $x > 0; $x--) {
    $days[$x] = $data[$x]['TO_DAYS(order_delivery)'] -$data[$x-1]['TO_DAYS(order_delivery)'];
    
    $xAxis[$x]=$x;
}

$days[0]=30;
//print_r("<br />",$days);
//print_r($xAxis);




//my implementation of regression calculation

 // calculate sums
  $x_sum = (array_sum($xAxis));
  $y_sum = array_sum($days);
  echo "<br />","Customer ID is: ",$id,"<br />";
  echo "Sum of X Axis: ",$x_sum, "<br />";
  echo "Sum of Y Axis: ",$y_sum,"<br />" ;

  $xx_sum = 0;
  $xy_sum = 0;
  
  for($i = 1; $i < $num_rows; $i++) {
  
    $xy_sum+=@($xAxis[$i]*$days[$i]);
    $xx_sum+=@($xAxis[$i]*$xAxis[$i]);
    
  }
  
  // calculate slope
  $m = (($num_rows * $xy_sum) - ($x_sum * $y_sum)) / (($num_rows * $xx_sum) - ($x_sum * $x_sum));
  
  // calculate intercept
  $b = ($y_sum - ($m * $x_sum)) / $num_rows;

$predict=($m*($num_rows+1))+$b;

echo "The Slope of the Representative line is: ",$m,"<br />";
echo "The Y intercept is ",$b,"<br />";
echo "Predicted next date of delivery in days (from last delivery date) is: ", $predict,"<br />";


//Final Date Calculation

$lastdate=mysql_query("SELECT TO_DAYS(order_delivery) FROM pbmart_order WHERE order_customer_id=$id",$conn);
$num_rows_date = mysql_num_rows($lastdate);
while (($row_date = mysql_fetch_array($lastdate, MYSQL_ASSOC)) !== false){
  $ldate[] = $row_date; // add the row in to the results (data) array
}
echo "Total number of records for the given id are: ",$num_rows_date, "<br />";
$ldatefinal=$ldate[$num_rows_date-1]['TO_DAYS(order_delivery)'];
//if(isset($ldate[$num_rows_date-1]['TO_DAYS(date)'])){}
  //  $ldatefinal=$ldate[$num_rows_date-1]['TO_DAYS(date)'];


echo "Last date in the records for the given ID is ",$ldatefinal,"<br />";
echo "Last date + Prediction days = ",$ldatefinal+$predict,"<br />";


$currentdate=mysql_query("SELECT TO_DAYS(CURDATE())",$conn);

$dcrow = mysql_fetch_assoc($currentdate);

//$dhold=$dcrow['TO_DAYS(CURDATE())'];
//echo "Current Date is: ",$dcrow['TO_DAYS(CURDATE())'],"<br /" ;

//UPON EXECUTION NOTHING BELOW GETS ExEcuted ??

//echo "Last date + Predicted days = ";




if (( (($ldatefinal+$predict) - ($dcrow['TO_DAYS(CURDATE())'])) <3 )&& $predict>0){

echo "Time to Order<br />","</br />";



$deviceid=  mysql_query("Select device_id, type FROM mobile_devices WHERE id=$id");
$row_dev=mysql_fetch_array($deviceid);
echo $row_dev['device_id'],"<br />";
echo $row_dev['type'],"<br />";

// Put your device token here (without spaces):
//echo $devid['id'];

if($row_dev['type']=='ios'){

$deviceToken = $row_dev['device_id'];

// Put your private key's passphrase here:
$passphrase = 'pbmart911';

// Put your alert message here:
$message = "PBMart - Check Your Gas Cylinders! Time to Order? '$id'";

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
}else{
    //to be implemeted for Android
	$deviceToken=$row_dev['device_id'];
	include_once 'GCM.php';
    
    $gcm = new GCM();
    $text="Dear Customer, Its time to check your gas ! Cheers";
    $registatoin_ids = array($deviceToken);
    $message = array("price" => $text);

    $result = $gcm->send_notification($registatoin_ids, $message);
   
    echo $result;
	
    echo "<br />","Test for Android Script","<br />";
	
}

}else if((( (($ldatefinal+$predict) - $dcrow['TO_DAYS(CURDATE())']) >3 && $predict>0) )){
echo "You Got Gas!!<br />","</br />";
}else{
    echo "Linear Regression not Suitable for this Record ID","<br />";
}

}
mysql_close($conn);




exit();
