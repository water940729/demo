<?php
//print_r($_POST);
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	//$image_url=$_POST["pics1"][0]
	$role=$_SESSION["mall_id"];
	$sql="insert into homeFocus(image_url,link_url,weight,role) values('{$_POST["pics1"][0]}','{$_POST["link_url"]}',$_POST[weight],$role)";
	if(mysql_query($sql)){
		$id=mysql_insert_id();
		$content="添加了焦点图，焦点图编号为".$id;
		if(add_system_log($content)==1){
			$url="manage_focus.php";
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
		}else{
			$url="add_focus.php";
			echo "<script>alert('添加失败!');window.location.href='".$url."';</script>";
		}
	}else{
		$url="add_focus.php";
		echo "<script>alert('添加失败!');window.location.href='".$url."';</script>";
	}
?>
