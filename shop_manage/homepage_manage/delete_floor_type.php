<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from floorTypeManage where id=$id";
	$sql2="select typename,floor_type_id from floorTypeManage where id=$id";
	$result=mysql_query($sql2);
	$row=mysql_fetch_array($result);
	if(mysql_query($sql)){
		$content="Remove the floor classification, floor number is".$row["floor_type_id"]."，（0 means recommended），classification is".$row["typename"];
		if(add_system_log($content)==1){
			echo"Deleted successful";
			//echo $content;
		}else{
			echo"Delete failed";
			//echo "<script>alert('修改失败!');window.location.href='edit_manage_account.php';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
	}else{
		echo"Delete failed, please try again";
	}
?>