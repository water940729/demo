<?php
	//修改一级分类
	require("../../conn/conn.php");
	require("../system_manage/add_system_log.php");	
	//print_r($_POST);
	//Array ( [goods_type] => 测试 [img_url] => [file] => [display] => on [type] => 1 [id] => 12 ) 
	$sql1="select name from goods_type1 where id=$_POST[id]";
	$result=mysql_query($sql1);
	$row=mysql_fetch_array($result);
	$sql="update goods_type1 set name='{$_POST['goods_type']}'";
	if(empty($_POST["weight"])){
		$sql.=",weight=1";
	}else{
		$sql.=",weight=$_POST[weight]";
	}
	if(isset($_POST['pics'])){
		$sql.=",logo='{$_POST['pics'][0]}'";
	}
	if(isset($_POST['display'])){
		$sql.=",display=1";
	}else{
		$sql.=",display=0";
	}
	$sql.=" where id=$_POST[id]";
	$url="goods_type1.php";
	if(mysql_query($sql)){
		$content="修改了商品一级分类，分类名称：".$row["name"];
		if(add_system_log($content)==1){
			echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";
			//echo $content;
		}else{
			echo "<script>alert('修改失败,请重新添加!');window.location.href='".$url."';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
		//echo 11;
	}else{
		//echo $sql;
		echo "<script>alert('修改失败,请重新添加!');window.location.href='".$url."';</script>";
	}
	//echo $sql;