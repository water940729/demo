<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	//$sql="delete from floorManage"
	$id=$_POST["id"];
	$sql="delete from floorManage where id=$id";
	if(mysql_query($sql)){
		$content="Deleted floor,No. is".$id;
		if(add_system_log($content)==1){
			echo"Delete success";
			//echo $content;
		}else{
			echo"Delete failed!";
			//echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
		//echo"删除成功";
	}else{
		echo"Delete failed!";
	}
?>