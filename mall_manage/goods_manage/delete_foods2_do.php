<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$goods_id=$_POST['goods_id'];//二级分类ID
	$delete="delete from goods_type2 where id=$goods_id";
	$delete_good="delete from goods where type2=$goods_id";
	$sql="select name from goods_type2 where id=$goods_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if(mysql_query($delete_good)&&mysql_query($delete)){
		$content="Deleted level2 sort of goods,name is".$row["name"];
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