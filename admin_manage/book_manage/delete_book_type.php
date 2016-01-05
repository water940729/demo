<?php
	//删除秒杀分类
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from book_type where id=$id";
	$sql1="delete from book_goods where type_id=$id";
	$sql3="select id,typename from book_type where id=$id";
	$result=mysql_query($sql3);
	$row=mysql_fetch_array($result);
	if(mysql_query($sql)&&mysql_query($sql1)){
		$content="删除了预售分类，分类编号为".$row["id"]."，分类为".$row["typename"];
		if(add_system_log($content)==1){
			echo"删除成功";
		}else{
			echo"删除失败";
		}
	}else{
		echo"删除失败，请重试";
	}
?>