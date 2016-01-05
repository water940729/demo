<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$sql="select * from goods where id=$goods_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$goods_id=$_POST['goods_id'];
	$delete="delete from goods where id=$goods_id";
	$delete_info="delete from goods_pictures where goods_id=$goods_id";
	if(mysql_query($delete)&&mysql_query($delete_info)){
		$content="Deleted a kind of goods,infomation:name".$row["name"].",No.".$row["id"];
		if(add_system_log($content)==1){
			echo 1;
			//echo $content;
		}else{
			echo "-1";
			//echo $content;
			//echo add_system_log($content);
		}
		//echo 1;
	}else{	
		echo "-1";
	}
?>