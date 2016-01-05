<?php
include_once('../../conn/sqlHelper.php');

$sqlhelper=new sqlHelper();
$type = $_POST['type'];
$value = $_POST['value'];
$sql="select * from super_goods_type2 where type1_id='$value'";
$arr=$sqlhelper->execute_more($sql);

$data=json_encode($arr);
echo  $data;
?>