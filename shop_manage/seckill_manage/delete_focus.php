<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from seckill_focus where id=$id";
	if(mysql_query($sql)){
		$content="Delete the focus, focus figure number is ".$id;
		if(add_system_log($content)==1){
			echo"Deleted successfully";
		}else{
			echo"Delete failed";
		}
	}else{
		echo"Delete failed!";
	}
?>