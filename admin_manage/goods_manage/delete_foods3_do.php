<?php
	//删除三级分类
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$goods_id=$_POST['goods_id'];//三级级分类ID
	$delete="delete from goods_type3 where id=$goods_id";
	$delete_good="delete from goods where type3=$goods_id";
	$sql="select name from goods_type3 where id=$goods_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if(mysql_query($delete_good)&&mysql_query($delete)){
		$content="删除了商品三级分类，分类名称：".$row["name"];
		if(add_system_log($content)==1){
			echo 1;
				//echo $content;
		}else{
			echo "-1";
				//echo $content;
				//echo add_system_log($content);
		}
	}else{	
		echo "-1";
	}
?>