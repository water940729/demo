<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$sql="delete from super_keyword_manage where id=".$_POST["id"];
	$content="删除了关键词，关键词编号为".$id;
	if(mysql_query($sql)&&(add_system_log($content)==1)){
		echo "删除成功";
	}else{
		echo "删除失败";
	}