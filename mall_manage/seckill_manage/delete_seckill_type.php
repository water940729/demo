<?php
	//删除秒杀分类
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from seckill_type where id=$id";
	$sql1="delete from seckill_goods where type_id=$id";
	$sql3="select id,typename from seckill_type where id=$id";
	$result=mysql_query($sql3);
	$row=mysql_fetch_array($result);
	if(mysql_query($sql)&&mysql_query($sql1)){
		$content="Deleted a sort of seckill,sort number is:".$row["id"].",sort name is:".$row["typename"];
		if(add_system_log($content)==1){
			echo"Delete success!";
		}else{
			echo"Delete failed!";
		}
	}else{
		echo"Delete failed,please try again!";
	}
?>