<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");	
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
	$pics=$_POST['pics'];
	$original_price=$_POST["original_price"];
	$goodsnum=trim($_POST["goodsnum"]);
	$goods_keywords=addslashes($_POST['keywords']);
	$goods_desc=addslashes($_POST['goodsDesc']);
	$goods_info=addslashes($_POST['goods_info']);
	$time=time();
	
	$select="select name,mall_id,mall_name from shop where id='$shop_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$shop_name=$row['name'];
	$mall_id=$row['mall_id'];
	$mall_name=$row['mall_name'];
	/*
	Array
(
    [goods_id] => 47
    [from] => goods
    [goodsName] => xxxx
    [shop] => 1
    [goodsType] => 1
    [type2] => 35
    [type3] => 3
    [price] => 121
    [keywords] => 
    [goodsDesc] => 
    [pics] => Array
        (
            [0] => 41
            [1] => 42
            [2] => 43
            [3] => 44
            [4] => 45
            [5] => 46
        )

    [addpics] => Array
        (
            [0] => /images/2015/06/upload_1434076868160.jpg
        )

    [file] => 542d0e29N76846b36.jpg
    [filename] => 
    [goods_desc] => 
)
	*/
	//判断是否上传了图片
	if(isset($_POST["addpics"])){
		$update="update super_goods set name='$goodsName',shop_id='$shop_id',type1='$goodsType',type1_name='$goodsTypename',type2='$type2',type2_name='$type2_name',type3='$type3',type3_name='$type3_name',image_url='{$_POST["addpics"][0]}',price='$price',original_price=$original_price,goodsnum=$goodsnum,goods_keywords='$goods_keywords',goods_desc='$goods_desc',goods_info='$goods_info',mtime='$time' where id='$goods_id'";
		$insert="insert into super_goods_pictures(goods_id,pic_url,time) values($goods_id,'{$_POST["addpics"][0]}',NOW())";	
		for($i=1;$i<count($_POST["addpics"]);$i++){
			$insert=$insert.",($goods_id,'{$_POST["addpics"][$i]}',NOW())";
		}
	}else{
		$update="update super_goods set name='$goodsName',shop_id='$shop_id',type1='$goodsType',type1_name='$goodsTypename',type2='$type2',type2_name='$type2_name',type3='$type3',type3_name='$type3_name',price='$price',original_price=$original_price,goodsnum=$goodsnum,goods_keywords='$goods_keywords',goods_desc='$goods_desc',goods_info='$goods_info',mtime=$time where id='$goods_id'";
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
		$select1="select gp_id from super_goods_pictures where goods_id=$goods_id";
		$result1=mysql_query($select1);
		while($row1=mysql_fetch_array($result1)){
			$gp_id=$row1["gp_id"];
			if(!in_array($gp_id,$pics)){
				$delete="delete from super_goods_pictures where gp_id='$gp_id'";
				mysql_query($delete);
			}
			//echo $insert;
		}
		//echo $insert;
		mysql_query($insert);
		$content="修改了一种商品，商品信息：商品名".addslashes("<a href='http://{$_SERVER["HTTP_HOST"]}/good/index/id/{$goods_id}' target='_blank'>$goodsName</a>");
		if(add_system_log($content)==1){
			echo "<script>alert('添加成功!');window.location.href='".$url."';</script>";
		}else{
			echo "<script>alert('添加失败,请重新添加!');window.location.href='".$url."';</script>";
		}

		
		//echo "<script>alert('修改成功!');window.location.href='".$url."';</script>";
	}else{	
		echo "<script>alert('修改失败,请重新修改!');window.location.href='".$url."';</script>";
		echo mysql_error();
		//echo $insert;
		//echo $update;
	}
	/*
	echo "<pre>";
	print_r($_POST);
	*/
?>