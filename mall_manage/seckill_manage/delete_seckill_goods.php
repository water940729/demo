<?php
	//删除秒杀商品
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql1="delete from seckill_goods where id=$id";
	if(mysql_query($sql1)){
		$content="Deleted a kind of seckill goods,goods number is:".$id;
		if(add_system_log($content)==1){
			echo"Delete success";
			//echo $content;
		}else{
			echo"Delete failed";
			//echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
	}else{
		echo"Delete failed,please try again";
	}
?>