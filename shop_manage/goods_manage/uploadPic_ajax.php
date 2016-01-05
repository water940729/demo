<?php
require_once('../../conn/conn.php');
$time=time();
$url=$_POST['url'];
$pic_url=$url;
$insert="insert into goods_pictures_temp(pic_url,admin_name,time) values('".$pic_url."','admin',".$time.")";               
if(mysql_query ( $insert )){
     $rs['result']= "success";
}
echo json_encode($rs);
?>