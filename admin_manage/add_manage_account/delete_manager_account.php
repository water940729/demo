<?php
include_once("../../conn/conn.php");
require("../system_manage/add_system_log.php");	
//require_once('../check.php');

$admin_manager_id=$_POST['admin_manager_id'];
$delete="delete from admin_manage where id='$admin_manager_id'";
$sql="select id,name from admin_manage where id='$admin_manager_id'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if(mysql_query($delete))
{
	$content="删除了一个管理员账号，账号信息：账号名".$row["name"]."，账号编号".$row["id"];
	if(add_system_log($content)==1){
		echo 1;
		//echo $content;
	}else{
		echo "删除失败";
		//echo $content;
		//echo add_system_log($content);
	}
}
else
{
   echo "删除失败";
}
/*
print_r($_POST);
echo $_POST["admin_manager_id"];
*/
?>