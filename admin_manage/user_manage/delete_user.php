<?php
	require_once("../../conn/conn.php");
	$id=$_POST["user_id"];
	$sql="update user_manage set state=0 where user_id=$id";
	if(mysql_query($sql)){
		echo 1;
	}else{
		echo 0;
	}