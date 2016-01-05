<?php
include_once("functions.php");

$tel = urlencode($_GET["tel"]);
$denom = intval($_GET["denom"]);
$url = "http://tcc.taobao.com/cc/json/mobile_price.htm?denom=".$denom."&phone=".$tel;
$content = html_get($url);
$price = trim(getXmlValue($content, "price:", ","));
$res = array("price" => $price);
echo (json_encode($res));
?>