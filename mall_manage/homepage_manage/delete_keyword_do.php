<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$sql="delete from keyword_manage where id=".$_POST["id"];
	$content="Deleted keyword,No. is:".$id;
	if(mysql_query($sql)&&(add_system_log($content)==1)){
		echo "Delete success!";
	}else{
		echo "Delete failed!";
	}