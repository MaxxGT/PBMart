<?php
//echo "hahahahahahah";

require_once("pbmartconnection.php");


 $username = $_POST['username'];
//$username="hashan000@gmail.com";

$query_search = "select * from pbmart_member where member_email = '".$username."'";
$query_exec = mysql_query($query_search) or die(mysql_error());
$rows = mysql_num_rows($query_exec);
//echo $rows;
 if($rows == 0) { 
 echo "No Such User Found"; 
 }
 else  {
    echo "User Found"; 
}




?>