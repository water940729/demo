<?php
include_once("functions.php");

$tel = urlencode($_GET["tel"]);
$url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$tel;
$content = html_get($url);
$name = getXmlValue($content, "carrier:'", "'");
$res = array("carrier" => iconv("gbk", "utf8",$name));
echo (json_encode($res));
?>