<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from teambuy_focus where id=$id";
	if(mysql_query($sql)){
		$content="删除了团购焦点图，焦点图编号为".$id;
		if(add_system_log($content)==1){
			echo"删除成功";
		}else{
			echo"删除失败";
		}
	}else{
		echo"删除失败!";
	}
?>