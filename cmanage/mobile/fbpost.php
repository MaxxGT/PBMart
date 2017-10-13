<?php
// require Facebook PHP SDK
// see: https://developers.facebook.com/docs/php/gettingstarted/
require_once("/fbt/facebook.php");
 
// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install
$config = array();
$config['appId'] = '363647217137810';
$config['secret'] = '3664cdabcdace0ecf055bc372c0dc578';
$config['fileUpload'] = false; // optional
 
$fb = new Facebook($config);
 
// define your POST parameters (replace with your own values)
$params = array(
  "access_token" => "363647217137810|j01QM9g1JLWDcR8uB6lWP_oobPg", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
  "message" => "Testing Auto Post - Hamood",
//  "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
  "picture" => "http://i.imgur.com/lHkOsiH.png",
  "name" => "Test",
  "caption" => "Test",
  "description" => "Automatically post on Facebook."
);
 
// post to Facebook
// see: https://developers.facebook.com/docs/reference/php/facebook-api/
try {
  $ret = $fb->api('/1411129302492411/feed', 'POST', $params);
  echo 'Successfully posted to Facebook';
} catch(Exception $e) {
  echo $e->getMessage();
}