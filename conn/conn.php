<?php
require_once('config.php');
require_once("check_role.php");
$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
if (!$conn){
		die ('数据库连接失败');
}
mysql_select_db(WIIDBNAME, $conn) or die ("没有找到数据库。");
mysql_query("set names utf8");
?>