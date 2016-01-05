<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
	$goodsName=addslashes($_POST['goodsName']);
	$shop_id=$_POST['shop'];
	
	$type=explode(" ",$_POST['goodsType']);
	$goodsType=$type[0];
	$goodsTypename=$type[1];
	
	$type=explode(" ",$_POST['type2']);
	$type2=$type[0];
	$type2_name=$type[1];
	
	$type=explode(" ",$_POST['type3']);
	$type3=$type[0];
	$type3_name=$type[1];
	
	$price=$_POST['price'];
	$goodsnum=trim($_POST["goodsnum"]);
	$pics=$_POST['pics'][0];
	$goods_keywords=addslashes($_POST['keywords']);
	$goods_desc=addslashes($_POST['goodsDesc']);
	$goods_info=addslashes($_POST['goods_info']);
	
	//print_r($_POST["attribute"]);
	//商品的附加属性
	$attribute1=$_POST["attribute"][0];
	$attribute2=$_POST["attribute"][1];
	$attribute3=$_POST["attribute"][2];
	$attribute4=$_POST["attribute"][3];
	
	//商品的可选属性
	if(!empty($_POST["extattribute1"])){
		$extattribute1=$_POST["extattribute1"];
	}else{
		$extattribute1="";
	}
	if(!empty($_POST["extattribute2"])){
		$extattribute2=$_POST["extattribute2"];
	}else{
		$extattribute2="";
	}
	if(!empty($_POST["extattribute3"])){
		$extattribute3=$_POST["extattribute3"];
	}else{
		$extattribute3="";
	}
	if(!empty($_POST["original_price"])){
		$original_price=$_POST["original_price"];
	}else{
		$original_price=0.0;
	}
	$time=time();
	if($shop_id==0){
		$shop_name="葵花自营";
		$mall_name="葵花自营";
		$mall_id=0;
	}else{
		$select="select name,mall_id,mall_name from shop where id='$shop_id'";
		$result=mysql_query($select);
		$row=mysql_fetch_array($result);
		$shop_name=$row['name'];
		$mall_id=$row['mall_id'];
		$mall_name=$row['mall_name'];	
	}
	$insert="insert into super_goods(name,state,shop_id,shop_name,mall_id,mall_name,price,original_price,goodsnum,type1,type1_name,type2,type2_name,type3,type3_name,image_url,goods_keywords,goods_desc,goods_info,time,attribute1,attribute2,attribute3,attribute4,extattribute1,extattribute2,extattribute3) values('$goodsName',1,'$shop_id','$shop_name','$mall_id','$mall_name','$price',$original_price,'$goodsType',$goodsnum,'$goodsTypename','$type2','$type2_name','$type3','$type3_name','{$_POST['pics'][0]}','$goods_keywords','$goods_desc','$goods_info',$time,'$attribute1','$attribute2','$attribute3','$attribute4','$extattribute1','$extattribute2','$extattribute3')";
	$url="add_goods.php";
	if(mysql_query($insert)){
		$goods_id=mysql_insert_id();
		for($i=0;$i<count($_POST["pics"]);++$i){
			$insert_goods_pic="insert into super_goods_pictures(goods_id,pic_url,time) values('$goods_id','{$_POST["pics"][$i]}','$time')";
			//echo $insert_goods_pic."<br>";
			mysql_query($insert_goods_pic);
		}
		$content="添加了一种商品，商品信息：商品名".addslashes("<a href='http://{$_SERVER["HTTP_HOST"]}/good/index/id/{$goods_id}' target='_blank'>$goodsName</a>");
		if(add_system_log($content)==1){
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
			//echo $content;
		}else{
			echo "<script>alert('添加失败,请重新添加!');window.location.href='".$url."';</script>";
			//echo $content;
			//echo add_system_log($content);
		}
	}else{	
		echo "<script>alert('添加失败,请重新添加!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}
?>