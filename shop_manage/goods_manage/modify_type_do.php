<?php
	//修改一级分类
	require("../../conn/conn.php");
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
		$content="Modify the commodity level classification, classification name:".$row["name"];
			echo "<script>alert('Modify successful!');window.location.href='".$url."';</script>";
		//echo 11;
	}else{
		//echo $sql;
		echo "<script>alert('Modify failure,please add again!');window.location.href='".$url."';</script>";
	}
	//echo $sql;