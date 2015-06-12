<?php
function GetIP(){ 
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
		$ip = getenv("REMOTE_ADDR"); 
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
		$ip = $_SERVER['REMOTE_ADDR']; 
	else 
		$ip = "unknown"; 
	return($ip); 
}
if(isset($_GET["ip"])){
	include_once('geoipcity.inc');
	$gi = geoip_open(realpath('GeoLiteCity.dat'), GEOIP_STANDARD);
	$record = geoip_record_by_addr($gi, $_GET["ip"]);
	if (is_object($record))
	{
		if(strtoupper($record->country_code)!="CN")
		{
			echo "YES";die();
		}
	}
	echo  "YES";die();
}
?>