<?php
	require_once('../../conn/conn.php');
	$from=$_POST['from'];	
	$goods_id=$_POST['goods_id'];	
	$goodsName=addslashes($_POST['goodsName']);
	$shop_id=$_POST['shop'];
	//一级分类
	$type=explode(" ",$_POST['goodsType']);
	$goodsType=$type[0];
	$goodsTypename=$type[1];
	//二级分类
	$type=explode(" ",$_POST['type2']);
	$type2=$type[0];
	$type2_name=$type[1];
	//三级分类
	$type=explode(" ",$_POST['type3']);
	$type3=$type[0];
	$type3_name=$type[1];
	$price=addslashes($_POST['price']);
	$goodsnum=trim($_POST["goodsnum"]);

	$goods_keywords=addslashes($_POST['keywords']);
	$goods_desc=addslashes($_POST['goodsDesc']);
	$goods_info=addslashes($_POST['goods_info']);
	$package_info=addslashes($_POST["package_info"]);
	$sales_support=addslashes($_POST["sales_support"]);
	
	$attribute1=$_POST["attribute"][0];
	$attribute2=$_POST["attribute"][1];
	$attribute3=$_POST["attribute"][2];
	//$attribute4=$_POST["attribute"][3];
	
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
	$pics=$_POST['pics'];
	$goods_keywords=addslashes($_POST['keywords']);
	$goods_desc=addslashes($_POST['goodsDesc']);
	$goods_info=addslashes($_POST['goods_info']);
	$package_info=addslashes($_POST["package_info"]);
	$sales_support=addslashes($_POST["sales_support"]);	
	$time=time();
	
	$select="select name,mall_id,mall_name from shop where id='$shop_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$shop_name=$row['name'];
	$mall_id=$row['mall_id'];
	$mall_name=$row['mall_name'];

	//判断是否上传了图片
	if(isset($_POST["addpics"])){
		$update="update goods set name='$goodsName',shop_id='$shop_id',type1='$goodsType',type1_name='$goodsTypename',type2='$type2',type2_name='$type2_name',type3='$type3',type3_name='$type3_name',image_url='{$_POST["addpics"][0]}',price=$price,original_price=$original_price,goodsnum=$goodsnum,discount=$discount,goods_keywords='$goods_keywords',goods_desc='$goods_desc',goods_info='$goods_info',package_info='$package_info',sales_support='$sales_support',mtime='$time',extattribute1='$extattribute1',extattribute2='$extattribute2',extattribute3='$extattribute3',attribute1='$attribute1',attribute2='$attribute2',attribute3='$attribute3' where id='$goods_id'";
		$insert="insert into goods_pictures(goods_id,pic_url,time) values($goods_id,'{$_POST["addpics"][0]}',NOW())";	
		for($i=1;$i<count($_POST["addpics"]);$i++){
			$insert=$insert.",($goods_id,'{$_POST["addpics"][$i]}',NOW())";
		}
	}else{
		$update="update goods set name='$goodsName',shop_id='$shop_id',type1='$goodsType',type1_name='$goodsTypename',type2='$type2',type2_name='$type2_name',type3='$type3',type3_name='$type3_name',price='$price',original_price=$original_price,goodsnum=$goodsnum,discount=$discount,goods_keywords='$goods_keywords',goods_desc='$goods_desc',goods_info='$goods_info',package_info='$package_info',sales_support='$sales_support',mtime=$time,extattribute1='$extattribute1',extattribute2='$extattribute2',extattribute3='$extattribute3',attribute1='$attribute1',attribute2='$attribute2',attribute3='$attribute3'  where id='$goods_id'";
	}
	//请求发起位置
	if($from=="goods"){
		$url="check_goods.php";
	}else if($from=="shop"){
		$shop_id=$_POST["shop_id"];
		$shop_name=$_POST["shop_name"];
		$url="../shop_manage/check_shop_goods.php?shop_id=$shop_id&shop_name=$shop_name&from=shop";
	}
	//修改商品信息成功，对保存图片信息的数据库的修改
	if(mysql_query($update)){
		$select1="select gp_id from goods_pictures where goods_id=$goods_id";
		$result1=mysql_query($select1);
		while($row1=mysql_fetch_array($result1)){
			$gp_id=$row1["gp_id"];
			if(!in_array($gp_id,$pics)){
				$delete="delete from goods_pictures where gp_id='$gp_id'";
				mysql_query($delete);
			}
			//echo $insert;
		}
		//echo $insert;
		mysql_query($insert);
		echo "<script>alert('Add successful!');window.location.href='".$url."';</script>";

		
		//echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";
	}else{	
		echo "<script>alert('Modify the failure,please modify again!');window.location.href='".$url."';</script>";
		echo mysql_error();
		//echo $insert;
		//echo $update;
	}
	/*
	echo "<pre>";
	print_r($_POST);
	*/
?>