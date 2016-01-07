<?php
//	print_r($_POST);
/*
Array ( [goodsName] => 测试 [price] => 329 [start] => 2015-06-18 13:00:00 [end] => 2015-06-18 23:00:00 [num] => 300 [extattribute1] => 颜色:红,蓝 [extattribute2] => [extattribute3] => [goodsDesc] => 测试 [pics] => Array ( [0] => /images/2015/06/upload_1434605984662.jpg [1] => /images/2015/06/upload_1434605988300.jpg ) [file] => 54052fefNc29254cb.jpg [filename] => [goods_desc] => [goods_info] =>

测试
) */
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$goodsName=addslashes($_POST['goodsName']);
	$type_id=$_POST["type_id"];
	$price=$_POST["price"];
	$start=strtotime($_POST["start"]);
	$end=0;
	$num=0;
	if(!empty($_POST["attribute1"])){
		$extattribute1=$_POST["extattribute1"];
	}else{
		$extattribute1="";
	}
	if(!empty($_POST["mall"])){
		$mall=$_POST["mall"];
		if(!empty($_POST["shop"])){
			$shop=$_POST["shop"];
		}
	}else{
		$mall=0;
		$shop=0;
	}
	if(!empty($_POST["attribute2"])){
		$extattribute2=$_POST["extattribute2"];
	}else{
		$extattribute2="";
	}
	if(!empty($_POST["attribute3"])){
		$extattribute3=$_POST["extattribute3"];
	}else{
		$extattribute3="";
	}
	if(!empty($_POST["original_price"])){
		$original_price=$_POST["original_price"];
	}else{
		$original_price=0.0;
	}		
	$role=$_SESSION["mall_id"];
	$goods_desc=addslashes($_POST['goodsDesc']);
	$goods_info=addslashes($_POST['goods_info']);
	$keyword=$_POST["keyword"];
	$insert="insert into book_goods(type_id,goodsname,mall,shop,keywords,price,original_price,introduction,img_url,start,end,num,description,extattribute1,extattribute2,extattribute3,role) 
	values($type_id,'{$goodsName}',$mall,$shop,'{$keyword}',$price,$original_price,'{$goods_desc}','{$_POST["pics"][0]}',$start,$end,$num,'{$goods_info}','{$extattribute1}','{$extattribute2}','{$extattribute3}',$role)";
	$url="add_book_goods.php";
	//echo $insert;
	if(mysql_query($insert)){
		$goods_id=mysql_insert_id();
		for($i=0;$i<count($_POST["pics"]);++$i){
			$insert_goods_pic="insert into book_goods_pictures(goods_id,image_url,time) values('$goods_id','{$_POST["pics"][$i]}','$time')";
			//echo $insert_goods_pic."<br>";
			mysql_query($insert_goods_pic);
		}
		$content="添加了一种预售商品，商品信息：商品名".$goodsName;
		if(add_system_log($content)==1){
			$url="manage_book_type.php?id=$type_id";
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
			//echo $content;
		}else{
			echo "<script>alert('添加失败,请重新添加!');window.location.href='".$url."';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
		//echo $insert;
		//echo $insert_goods_pic;
//		print_r($insert);
	}else{	
		echo "<script>alert('添加失败,请重新添加!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}
?>