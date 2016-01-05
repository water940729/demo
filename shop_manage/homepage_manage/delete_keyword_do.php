<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$sql="delete from keyword_manage where id=".$_POST["id"];
	$content="Remove the keywords, keyword number is".$id;
	if(mysql_query($sql)&&(add_system_log($content)==1)){
		echo "Delete successful";
	}else{
		echo "Delete failed";
	}