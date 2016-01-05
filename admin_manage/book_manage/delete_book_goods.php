<?php
	//删除秒杀商品
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql1="delete from book_goods where id=$id";
	if(mysql_query($sql1)){
		$content="删除了预售商品，商品编号".$id;
		if(add_system_log($content)==1){
			echo"删除成功";
			//echo $content;
		}else{
			echo"删除失败";
			//echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
	}else{
		echo"删除失败，请重试";
	}
?>