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
		$content="Added a sort of seckill,sort number:".$id.",sort name:".$_POST["type_name"];
		if(add_system_log($content)==1){
			$url="manage_seckill.php";
			echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
		}else{
			$url="add_seckill.php";
			echo "<script>alert('Add failed,please try again!');window.location.href='".$url."';</script>";
		}

	}else{
		$url="add_seckill.php";
		echo "<script>alert('Add failed,please try again!');window.location.href='".$url."';</script>";
	}
?>