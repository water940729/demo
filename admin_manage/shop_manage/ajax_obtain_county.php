<?php
include_once('sqlHelper.php');

$sqlhelper=new sqlHelper();
$province_name = $_POST['province_name'];
$city_name = $_POST['city_name'];

$sql="select county_name,county_code from county  where province_name='".$province_name."' and city_name='".$city_name."'";
$arr=$sqlhelper->execute_more($sql);

$data=json_encode($arr);
echo  $data;

?>