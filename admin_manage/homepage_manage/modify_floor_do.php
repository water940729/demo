<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
//	print_r($_POST);
	//Array ( [floor_name] => 2F [weight] => 1 [floor_type] => 化妆品 [typename] => 1 [simple_color_value] => [type] => [id] => ) 
	//Array ( [floor_name] => 2F [weight] => 1 [floor_type] => 化妆品 [typename] => 1 [simple_color_value] => #009966 [type] => [id] => ) 
	$floor_name=$_POST["floor_name"];
	$weight=trim($_POST["weight"]);
	if(empty($weight)){
		$weight=1;
	}else{
		$weight=$weight;
	}
	$floor_type=trim($_POST["floor_type"]);
	$id=$_POST["id"];
	//商场是需要添加logo
	if(!empty($_POST["simple_color_value"])){
		$sql="update floorManage set name='{$floor_name}',weight={$weight},background='{$_POST["simple_color_value"]}' where id=$id";	
	}else{
		$sql="update floorManage set name='{$floor_name}',weight={$weight} where id=$id";	
	}
	if(mysql_query($sql)==1){
		$content="修改了楼层，楼层编号为".$id;
		if(add_system_log($content)==1){
			$url="floor_manage.php";
			echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";
		}else{
			$url="modify_floor.php?id=$id";
			echo "<script>alert('修改失败，请重新修改!');window.location.href='".$url."';</script>";
		}
	}else{
		$url="modify_floor.php?id=$id";
		echo "<script>alert('修改失败，请重新修改!');window.location.href='".$url."';</script>";
	}

//	print_r(mysql_query($sql));
?>