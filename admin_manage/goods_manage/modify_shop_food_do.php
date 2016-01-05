<?php
	require_once("../../conn/conn.php");
	require("../system_manage/add_system_log.php");	
	$result=mysql_query("select type1_id from goods_type2 where id=$_POST[id]");
	$row=mysql_fetch_array($result);
	$type1_id=$row['type1_id'];
	$sql="update goods_type2 set name='".$_POST[goods_type]."' where id=$_POST[id]";
	if(mysql_query($sql)){
		$content="修改了商品二级分类，分类名称：".$_POST["goods_type"];
		if(add_system_log($content)==1){
			$url='goods_type2.php?id='.$type1_id;
			echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";
			//echo $content;
		}else{
			$url="modify_shop_food.php?id=$_POST[id]";
			echo "<script>alert('修改失败,请重新修改!');window.location.href='".$url."';</script>";
			//echo $content;
				//echo $content;
				//echo add_system_log($content);
		}
	}else{
		$url="modify_shop_food.php?id=$_POST[id]";
		echo "<script>alert('修改失败,请重新修改!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}