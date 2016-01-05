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
	$content="Delete an administrator account, account information: account name".$row["name"]."，Account number".$row["id"];
	if(add_system_log($content)==1){
		echo 1;
		//echo $content;
	}else{
		echo "Delete failed";
		//echo $content;
		//echo add_system_log($content);
	}
}
else
{
   echo "Delete failed";
}
/*
print_r($_POST);
echo $_POST["admin_manager_id"];
*/
?>