<?php
	//print_r($_POST);
	/*Array ( 
	[type_name] => 母婴//分类名
	[typename] => 7//
	[type1_id] =>//一级分类ID
	[type1_name] =>//一级分类名
	[weight] => //分类权重
	[floor_name] => 8F//楼层名
	[floor_id] => 14 //楼层编号)
	*/
	//Array ( [floor_name] => 8F [typename] => 8 [map] => on [type1_id] => 1 [type1_name] => 图书 [weight] => [floor_id] => 14 ) 
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	if(empty($_POST["weight"])){
		$weight=1;
	}else{
		$weight=trim($_POST["weight"]);
	}
	if(isset($_POST["map"])){
		$type1_id=$_POST["type1_id"];
		$type1_name=$_POST["type1_name"];
	}else{
		$type1_id=0;
		$type1_name="无";
	}
	$sql="insert into floorTypeManage(typename,floor_id,floor_name,weight,type1_id,type1_name) values('{$_POST["type_name"]}',{$_POST["floor_id"]},'{$_POST["floor_name"]}',$weight,$type1_id,'{$type1_name}')";
	if(mysql_query($sql)){
		$content="楼层编号".$_POST["floor_id"]."添加分类".$_POST["type_name"];
		if(add_system_log($content)==1){
			$url="floor_type.php?id=$_POST[floor_id]&name=$_POST[floor_name]";//楼层编号和楼层名
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
		}else{
			$url="add_floor_type.php";
			echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
		}
	}else{
		$url="add_floor_type.php";
		echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
	}
	//echo $sql;
?>