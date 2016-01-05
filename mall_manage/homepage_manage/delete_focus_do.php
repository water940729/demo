<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from homeFocus where id=$id";
	if(mysql_query($sql)){
		$content="Deleted focus picture,No. is:".$id;
		if(add_system_log($content)==1){
			echo"Delete success!";
		}else{
			echo"Deleted failed!";
		}
	}else{
		echo"Deleted failed!";
	}
?>