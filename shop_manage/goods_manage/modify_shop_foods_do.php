<?php
	
	//修改三级分类页面
	require_once("../../conn/conn.php");
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
	$result=mysql_query("select type1_id from goods_type3 where id=$_POST[id]");
	$row=mysql_fetch_array($result);
	$type1_id=$row['type1_id'];
	$sql="update goods_type3 set name='".$_POST[goods_type]."' where id=$_POST[id]";
	if(mysql_query($sql)){
		$content="Modified the goods secondary classification, classification name:".$_POST["goods_type"];
			$url='goods_type3.php?id='.$type1_id."&type1_id=".$_POST["type2_id"];
			echo "<script>alert('Modify successful!');window.location.href='".$url."';</script>";
			//echo $content;
	}else{
		$url="modify_shop_foods.php?id=$_POST[id]&type2_id=".$_POST["type2_id"];
		echo "<script>alert('Modify failure,please add again!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}