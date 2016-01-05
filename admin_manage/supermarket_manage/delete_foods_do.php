<?php
	//删除一级分类
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");		
	$goods_id=$_POST['goods_id'];
	$delete_type1="delete from super_goods_type1 where id=$goods_id";
	$delete_type2="delete from super_goods_type2 where type1_id=$goods_id";
	$delete_type3="delete from super_goods_type3 where type1_id=$goods_id";
	$delete_goods="delete from super_goods where type1=$goods_id";
	$sql="select name from super_goods_type1 where id=$goods_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if(mysql_query($delete_type1)&&mysql_query($delete_type2)&&mysql_query($delete_goods)&&mysql_query($delete_type3)){
		$content="删除了超市商品一级分类，分类名称：".$row["name"];
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