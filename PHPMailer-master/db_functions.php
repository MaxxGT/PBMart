<?php

class DB_Functions {

  
    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once '../../connection/pbmartconnection.php';
        // connecting to database
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid) {
      
      $result = mysql_query("SELECT * FROM pbmart_member WHERE member_email='$email'");
	$num_rows = mysql_num_rows($result);
// mysql_query($result,$conn) or die(mysql_error();

if ($num_rows > 0)
	{
	

	$sql = "INSERT INTO mobile_devices (id, email, device_id, type) SELECT pbmart_member.member_id, pbmart_member.member_email, '$gcm_regid', 'and' FROM pbmart_member where member_email='$email';";
	$res = mysql_query($sql) or die(mysql_error());
	}else 
	{
	//This is where I want to return the json bolean value
	
	//$response ['status']= 1; 
	//echo json_encode($response);

	
	
}
      /*  // insert user into database
        $result = mysql_query("INSERT INTO gcm_users(name, email, gcm_regid, created_at) VALUES('$name', '$email', '$gcm_regid', NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        *///}
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmail($email) {
        $result = mysql_query("SELECT * FROM mobile_devices WHERE email = '$email' LIMIT 1");
        return $result;
    }

    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM mobile_devices");
        return $result;
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from pbmart_member WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }

}

?>