<?php
	require_once('../../conn/conn.php');
	$mall_id=$_POST['mall_id'];
	$delete_mall="delete from mall where id=$mall_id";
	$delete_mall_shop="delete from shop where mall_id=$mall_id";
	$delete_mall_shop_goods="delete from goods where mall_id=$mall_id";
	$sql="select name from mall where id=$mall_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$content="Deleted the ".$row["name"]." Mall";
	$admin_name=$_SESSION["name"];
	$time=time();
	$log="insert into system_log(admin_name,content,time) values('{$admin_name}','{$content}',$time)";
	if(mysql_query($log)&&mysql_query($delete_mall)&&mysql_query($delete_mall_shop)&&mysql_query($delete_mall_shop_goods)){
		echo 1;
	}else{
		//echo $log;
		echo "Delete failed";
	}
?>
