<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	$id=$_POST["id"];
	$sql="delete from homePageGoods where id=$id";
	$sql2="select goods_name,floor_type_id from homePageGoods where id=$id";
	$result=mysql_query($sql2);
	$row=mysql_fetch_array($result);
	if(mysql_query($sql)){
		$content="Remove the floor classification of goods, floor number is".$row["floor_type_id"]."，（0 means recommended），goods is".$row["goods_name"];
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
		echo"Please try again";
	}
?>