<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	//print_r($_POST);
	$weight=trim($_POST["weight"]);
	$role=$_SESSION["mall_id"];
	if(empty($weight)){
		$weight=1;
	}else{
		$weight=$weight;
	}
	$sql="insert into seckill_type(typename,weight,role) values('{$_POST["type_name"]}',$weight,$role)";
	if(mysql_query($sql)){
		$id=mysql_insert_id();
		$content="添加了秒杀分类，分类编号为".$id.",分类名称".$_POST["type_name"];
		if(add_system_log($content)==1){
			$url="manage_seckill.php";
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
		}else{
			$url="add_seckill.php";
			echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
		}

	}else{
		$url="add_seckill.php";
		echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
	}
?>