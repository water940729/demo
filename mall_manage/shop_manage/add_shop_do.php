<?php
	require_once('../../conn/conn.php');
	require("../system_manage/add_system_log.php");
	$name=addslashes($_POST['name']);
	$mall_id=addslashes($_POST['mall']);
	$introduceInfo=addslashes($_POST['introduceInfo']);
	$select="select name from mall where id='$mall_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$mall_name=$row['name'];
	$time=time();
	$insert="insert into shop(name,detail,mall_id,mall_name,time) 
	values('$name','$introduceInfo','$mall_id','$mall_name','$time')";
	if(mysql_query($insert)){
		$shop_id=mysql_insert_id();
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
		$content="Added a shop,shop name is:".$name.",shop number is:".$shop_id."belongs to the mall:".$mall_name.",shop introduction:".$introduceInfo;
		if(add_system_log($content)){
			echo "<script>alert('Add success!');window.location.href='check_shop.php';</script>";		
		}else{
			echo "<script>alert('Add failed,please try again!');window.location.href='check_shop.php';</script>";		
		}
	}else{
		echo "<script>alert('Add failed,please try again!');window.location.href='check_shop.php';</script>";
		echo mysql_error();
	}
	//print_r($_POST);
?>
