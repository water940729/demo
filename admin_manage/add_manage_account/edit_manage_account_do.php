<?php
include_once("../../conn/conn.php");
require("../system_manage/add_system_log.php");
$id=$_POST['id'];
$password=$_POST['password'];
$password=md5($password);
$update ="update admin_manage set passwd='$password' where id='$id'";

if(mysql_query($update))
{
	$content="修改了密码";
	if(add_system_log($content)==1){
		echo "<script>alert('修改成功!');window.location.href='edit_manage_account.php';</script>";
		//echo $content;
	}else{
		echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
		//echo $content;
		//echo add_system_log($content);
	}
}
else
{
    echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
}
?>