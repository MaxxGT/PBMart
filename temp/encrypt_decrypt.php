<?php
//http://stackoverflow.com/questions/15194663/encrypt-and-decrypt-md5
//a function use to encrypt and decrypt password in secure manner
function encrypt( $password ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $password, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decrypt( $password ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $password ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
?>