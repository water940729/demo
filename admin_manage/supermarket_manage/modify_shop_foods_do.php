<?php
	
	//修改三级分类页面
	require_once("../../conn/conn.php");
	require("../system_manage/add_system_log.php");	
	$attribute1=addslashes($_POST["attribute1"]);
	$attribute2=addslashes($_POST["attribute2"]);
	$attribute3=addslashes($_POST["attribute3"]);
	$attribute4=addslashes($_POST["attribute4"]);	
	/*
	*$_POST["id"]三级分类
	*$_POST["type2_id"]二级分类
	*
	*返回三级分类页面
	*$_GET['id'];//一级分类
	*$_GET["type1_id"];//二级分类
	*
	*返回modify_shop_foods
	*$_GET['id'];//三级分类编号
	*$_GET["type2_id"];//二级分类编号
	*/
	$result=mysql_query("select type1_id from super_goods_type3 where id=$_POST[id]");
	$row=mysql_fetch_array($result);
	$type1_id=$row['type1_id'];
	$sql="update super_goods_type3 set name='".$_POST[goods_type]."',attribute1='$attribute1',attribute2='$attribute2',attribute3='$attribute3',attribute4='$attribute4' where id=$_POST[id]";
	if(mysql_query($sql)){
		$content="修改了商品二级分类，分类名称：".$_POST["goods_type"];
		if(add_system_log($content)==1){
			$url='goods_type3.php?id='.$type1_id."&type1_id=".$_POST["type2_id"];
			echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";
			//echo $content;
		}else{
			$url="modify_shop_foods.php?id=$_POST[id]&type2_id=".$_POST["type2_id"];
			echo "<script>alert('修改失败,请重新修改!');window.location.href='".$url."';</script>";
			//echo $content;
				//echo $content;
				//echo add_system_log($content);
		}
	}else{
		$url="modify_shop_foods.php?id=$_POST[id]&type2_id=".$_POST["type2_id"];
		echo "<script>alert('修改失败,请重新修改!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}