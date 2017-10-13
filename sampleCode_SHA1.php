<?PHP
function iPay88_signature($source)
{
  return base64_encode(hex2bin(sha1($source)));
}

if (!function_exists('hex2bin')){
	function hex2bin($hexSource)
	{
		for ($i=0;$i<strlen($hexSource);$i=$i+2)
		{
		  $bin .= chr(hexdec(substr($hexSource,$i,2)));
		}
	  return $bin;
	}
}
?>