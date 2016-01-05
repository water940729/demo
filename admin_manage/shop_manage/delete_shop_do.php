<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");
	$shop_id=$_POST['shop_id'];
	$delete_shop="delete from shop where id=$shop_id";
	$delete_shop_goods="delete from goods where shop_id=$shop_id";
	$delete_info="delete from goods_pictures where goods_id=$goods_id";
	$sql="select name from shop where id=$shop_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$name=$row["name"];
	if(mysql_query($delete_shop)&&mysql_query($delete_shop_goods)){
		$conn="删除了店铺：$name";
		if(add_system_log($conn)){
			echo 1;
		}else{
			echo "-1";
		}
	}else{
		echo "-1";
	}
	
?>
