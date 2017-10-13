<?php	
   	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	
	$mssg= mysqli_real_escape_string($dbconnect, $_POST['msg']);
	
	if(!isset($_POST['member'])){
		header("location:notification.php");
	}else{

		$del_pro = $_POST['member'];
		$count = count($del_pro);
		include_once 'GCM.php';
			
			for($i = 0; $i < $count; $i++){
			
                                $mobile = mysqli_query($dbconnect, "SELECT * FROM mobile_devices WHERE device_id='".$del_pro[$i]."'");
                                $type = mysqli_fetch_assoc($mobile);
                                if($type['type'] == "ios"){
                                echo "ios sucks ";



                                }else if($type['type'] == "and"){
                                $gcm = new GCM();
				$regids=array($del_pro[$i]);
                                
				$message = array("price" => $mssg);
				$result = $gcm->send_notification($regids,$message);
                                echo $result;
                                }
                                
				
		}
		
	}
	header("location:notification.php");
?>