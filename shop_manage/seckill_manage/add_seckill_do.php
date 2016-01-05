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
		$content="Added seconds kill classification, classification number is".$id.",Category name".$_POST["type_name"];
		if(add_system_log($content)==1){
			$url="manage_seckill.php";
			echo "<script>alert('Add successful!');window.location.href='".$url."';</script>";
		}else{
			$url="add_seckill.php";
			echo "<script>alert('Add failure, please add it again!');window.location.href='".$url."';</script>";
		}

	}else{
		$url="add_seckill.php";
		echo "<script>alert('Add failure, please add it again!');window.location.href='".$url."';</script>";
	}
?>