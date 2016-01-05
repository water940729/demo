<?php
	require_once('../../conn/conn.php');
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
	$goodsnum=$_POST["goodsnum"];
	$pics=$_POST['pics'][0];
	$goods_keywords=addslashes($_POST['keywords']);
	$goods_desc=addslashes($_POST['goodsDesc']);
	$goods_info=addslashes($_POST['goods_info']);
	$package_info=addslashes($_POST["package_info"]);
	$sales_support=addslashes($_POST["sales_support"]);
	
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
		$original_price=$_POST["price"];
	}
	$discount_left=$price*10%$original_price;
	$discount_temp=$price*10/$original_price;
	if($discount_left==0){
		$discount=$discount_temp;
	}else{
		$discount=number_format($discount_temp,1,".",",");
	}
	$time=time();
	$select="select name,mall_id,mall_name from shop where id='$shop_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	if($shop_id==0){
		$shop_name=$row["mall_name"]."self-support";
		$mall_name=$row["mall_name"]."self-support";
		$mall_id=$_SESSION["mall_id"];
	}else{
		$shop_name=$row['name'];
		$mall_id=$row['mall_id'];
		$mall_name=$row['mall_name'];	
	}
	$insert="insert into goods(name,state,shop_id,shop_name,mall_id,mall_name,price,original_price,goodsnum,discount,type1,type1_name,type2,type2_name,type3,type3_name,image_url,goods_keywords,goods_desc,goods_info,package_info,sales_support,time,attribute1,attribute2,attribute3,attribute4,extattribute1,extattribute2,extattribute3) values('$goodsName',1,'$shop_id','$shop_name','$mall_id','$mall_name','$price',$original_price,$goodsnum,$discount,'$goodsType','$goodsTypename','$type2','$type2_name','$type3','$type3_name','{$_POST['pics'][0]}','$goods_keywords','$goods_desc','$goods_info','$package_info','$sales_support',$time,'$attribute1','$attribute2','$attribute3','$attribute4','$extattribute1','$extattribute2','$extattribute3')";
	$url="add_goods.php";
	if(mysql_query($insert)){
		$goods_id=mysql_insert_id();
		for($i=0;$i<count($_POST["pics"]);++$i){
			$insert_goods_pic="insert into goods_pictures(goods_id,pic_url,time) values('$goods_id','{$_POST["pics"][$i]}','$time')";
			//echo $insert_goods_pic."<br>";
			mysql_query($insert_goods_pic);
		}
		echo "<script>alert('Add success!');window.location.href='".$url."';</script>";
	}else{	
		echo "<script>alert('Add failed,please add again!');window.location.href='".$url."';</script>";
		echo mysql_error();
	}
?>