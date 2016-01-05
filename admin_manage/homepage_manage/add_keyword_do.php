<?php
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");
	//print_r($_POST);
	//echo "11";
	$keyword=$_POST["floor_name"];
	$weight=trim($_POST["weight"]);
	if(empty($weight)){
		$weight=1;
	}
	$time=time();
	$role=$_SESSION["mall_id"];
	$sql="insert into keyword_manage(keyword,weight,time,role) values('{$keyword}',$weight,$time,$role)";
	$content="添加了一个关键词，关键词名字".$keyword;
	if(mysql_query($sql)&&(add_system_log($content)==1)){
		$url="keyword_manage.php";
		echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
	}else{
		$url="add_keyword.php";
		echo "<script>alert('添加失败，请重新添加!');window.location.href='".$url."';</script>";
	}
	//echo $sql;
	//echo $content;
?>