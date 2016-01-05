<?php
function getLogLat($address){
	$return = file_get_contents("http://api.map.baidu.com/geocoder/v2/?address=".$address."&output=json&ak=vinP0o5y6nW4GfcaRRpdY9u5");
	return $return;
}
?>