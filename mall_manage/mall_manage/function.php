<?php
function getLogLat($address){
	$return = file_get_contents("http://api.map.baidu.com/geocoder/v2/?address=".$address."&output=json&ak=2N1eklPu8gvPGsBGkjPkxyWO");
	return $return;
}
?>