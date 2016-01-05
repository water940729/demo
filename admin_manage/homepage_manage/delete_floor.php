<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	//$sql="delete from floorManage"
	$id=$_POST["id"];
	$sql="delete from floorManage where id=$id";
	if(mysql_query($sql)){
		$content="删除了楼层，楼层编号为".$id;
		if(add_system_log($content)==1){
			echo"删除成功";
			//echo $content;
		}else{
			echo"删除失败";
			//echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
		//echo"删除成功";
	}else{
		echo"删除失败";
	}
?>