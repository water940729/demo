<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	//print_r($_POST);
	$weight=trim($_POST["weight"]);
	if($_SESSION["role"]==1){
		$role=0;
		$logo=null;
	}else{
		$role=$_SESSION["mall_id"];
		$logo=$_POST["pics"][0];
	}
	if(empty($weight)){
		$weight=1;
	}else{
		$weight=$weight;
	}
	$sql="insert into floorManage(name,weight,role,background,logo) values('{$_POST["floor_name"]}',$weight,$role,'{$_POST["simple_color_value"]}','{$logo}')";
	if(mysql_query($sql)){
		$id=mysql_insert_id();
		$content="添加了楼层，楼层编号为".$id;
		if(add_system_log($content)==1){
			$url="floor_manage.php";
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
		}else{
			$url="add_floor.php";
			echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
		}

	}else{
		$url="add_floor.php";
		echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
	}
?>