<?php
include_once('../../conn/sqlHelper.php');

$sqlhelper=new sqlHelper();
$province_name = $_POST['province_name'];

$sql="select city_name from county  where province_name='".$province_name."' group by city_name";

$arr=$sqlhelper->execute_more($sql);

$data=json_encode($arr);
echo  $data;

?>