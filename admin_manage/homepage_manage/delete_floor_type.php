<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from floorTypeManage where id=$id";
	$sql2="select typename,floor_type_id from floorTypeManage where id=$id";
	$result=mysql_query($sql2);
	$row=mysql_fetch_array($result);
	if(mysql_query($sql)){
		$content="删除了楼层分类，楼层编号为".$row["floor_type_id"]."，（0表示推荐），分类为".$row["typename"];
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