<?php
//http://grohsfabian.com/tag/php-script-to-check-server-status/

function getStatus($ip,$port){
   $socket = @fsockopen($ip, $port, $errorNo, $errorStr, 3);
   if(!$socket) return "offline";
     else return "online";
}
 
echo getStatus("www.pbmart.com.my", "80");
?>