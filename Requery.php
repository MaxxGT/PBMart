<?PHP
echo Requery();
function Requery(){

	$MerchantCode = "M01224";
	

	$query = "https://www.mobile88.com/epayment/enquiry.asp?MerchantCode=" . $MerchantCode . "&RefNo=" . str_replace(" ","%20",$RefNo) . "&Amount=" . $Amount;

	$url = parse_url($query);
	$host = $url["host"];
	$path = $url["path"] . "?" . $url["query"];
	$timeout = 1;
	$fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
	
	if ($fp) {
		fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
		while (!feof($fp)) {
		$buf .= fgets($fp, 128);
	}
	
	$lines = preg_split("/\n/", $buf);
	$Result = $lines[count($lines)-1];
	fclose($fp);
	} else {
  # enter error handing code here
}
return $Result;

}
?>