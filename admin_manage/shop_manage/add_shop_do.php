<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");
	$name=addslashes($_POST['name']);
	$mall_id=addslashes($_POST['mall']);
	$introduceInfo=addslashes($_POST['introduceInfo']);
	$ratio=$_POST["ratio"];
	$select="select name from mall where id='$mall_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$mall_name=$row['name'];
	$time=time();
	$pics=count($_POST['pics'])-1;
	$insert="insert into shop(name,ratio,detail,logo,time) 
	values('$name','$ratio','$introduceInfo','{$_POST["pics"][$pics]}','$time')";
	if(mysql_query($insert)){
		/*$shop_id=mysql_insert_id();
		//print_r($_POST["pics"]);
		for($i=0;$i<count($_POST["pics"]);++$i){
			$pics=$_POST["pics"][$i];
			$insert_shop_pic="insert into shop_pictures(shop_id,pic_url,time) values('$shop_id','{$_POST['pics'][$i]}','$time')";
			mysql_query($insert_shop_pic);
			if($i==0){
				$pic_id=mysql_insert_id();
				$update="update shop set picid=$pic_id where id=$shop_id";
				mysql_query($update);
			}
		}
		*/
		$content="添加了一个商铺，商铺名为".$name."，商铺编号为".$shop_id."，所属商场为".$mall_name."，商铺简介".$introduceInfo;
		if(add_system_log($content)){
			echo "<script>alert('添加成功!');window.location.href='check_shop.php';</script>";		
		}else{
			echo "<script>alert('添加失败,请重新添加!');window.location.href='check_shop.php';</script>";		
		}
	}else{
		echo "<script>alert('添加失败,请重新添加!');window.location.href='check_shop.php';</script>";
		echo mysql_error();
	}
	//print_r($_POST);
?>
