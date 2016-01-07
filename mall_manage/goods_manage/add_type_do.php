<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");
	if($_SESSION["role"]==1){
		//超级管理员添加商品分类
		$goods_type=$_POST['goods_type'];
		$type=$_POST['type'];
		$id=$_POST['type1_id'];
		$id2=$_POST["type2_id"];
		$time=time();
		if($type==1){
			//$display=$_POST["display"];
			//$logo=$_POST["img_url"]["pics"][0];
			//分类权重
			if(empty($_POST["weight"])){
				$weight=1;
			}else{
				$weight=$_POST["weight"];
			}
			if(isset($_POST["display"])){
				$insert="insert into goods_type1(name,weight,logo,display,typebelong,time) values('$goods_type',$weight,'{$_POST["pics"][0]}',1,0,'$time')";			
			}else{
				$insert="insert into goods_type1(name,weight,logo,display,typebelong,time) values('$goods_type',$weight,'{$_POST["pics"][0]}',0,0,'$time')";
			}
			//echo $insert;
			//print_r($_POST);
			//Array ( [goods_type] => xxxxc [img_url] => [pics] => Array ( [0] => /images/2015/06/upload_1433559349317.jpg ) [file] => btn1.jpg [type] => 1 [id] => 0 ) 
			$url="goods_type1.php";
		}else if($type==2){
			$insert="insert into goods_type2(name,time,type1_id) values('$goods_type','$time','$id')";
			$url="goods_type2.php?id=$id";
		}else{
			$insert="insert into goods_type3(name,time,type1_id,type2_id) values('$goods_type','$time','$id','$id2')";
			$url="goods_type3.php?id=$id&&type1_id=$id2";
		}
		//echo $insert;
		if(mysql_query($insert)){
			$content="Added Goods{$type}levels sort,SortName:".$goods_type;
			if(add_system_log($content)==1){
				echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
				//echo $content;
			}else{
				echo "-1";
				//echo $content;
				//echo add_system_log($content);
			}
			echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
		}else{	
			echo "<script>alert('Add failed,please try again!');window.location.href='".$url."';</script>";
			echo mysql_error();
		}
	}else{
		//商场管理员添加商品分类
		$goods_type=$_POST['goods_type'];
		$type=$_POST['type'];
		$id=$_POST['type1_id'];
		$id2=$_POST["type2_id"];
		$time=time();
		if($type==1){
			//$display=$_POST["display"];
			//$logo=$_POST["img_url"]["pics"][0];
			if(isset($_POST["display"])){
				$insert="insert into goods_type1(name,logo,display,typebelong,time) values('$goods_type','{$_POST["pics"][0]}',1,'{$_SESSION["mall_id"]}','$time')";			
			}else{
				$insert="insert into goods_type1(name,logo,display,typebelong,time) values('$goods_type','{$_POST["pics"][0]}',0,'{$_SESSION["mall_id"]}','$time')";
			}
			//echo $insert;
			//print_r($_POST);
			//Array ( [goods_type] => xxxxc [img_url] => [pics] => Array ( [0] => /images/2015/06/upload_1433559349317.jpg ) [file] => btn1.jpg [type] => 1 [id] => 0 ) 
			$url="goods_type1.php";
		}else if($type==2){
			$insert="insert into goods_type2(name,time,type1_id) values('$goods_type','$time','$id')";
			$url="goods_type2.php?id=$id";
		}else{
			$insert="insert into goods_type3(name,time,type1_id,type2_id) values('$goods_type','$time','$id','$id2')";
			$url="goods_type3.php?id=$id&&type1_id=$id2";
		}
		//echo $insert;
		if(mysql_query($insert)){
			echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
		}else{	
			echo "<script>alert('Add failed,please try again!');window.location.href='".$url."';</script>";
			echo mysql_error();
		}
	}
?>