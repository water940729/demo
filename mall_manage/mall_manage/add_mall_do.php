<?php
	require_once('../../conn/conn.php');
	require_once('check_address_do.php');
	$name=addslashes($_POST['name']);
	$province=addslashes($_POST['province']);
	$city=addslashes($_POST['city']);
	$county=addslashes($_POST['county']);
	$detailAddressInfo=addslashes($_POST['detailAddressInfo']);
	$pics=addslashes($_POST['pics']);
	$introduceInfo=addslashes($_POST['introduceInfo']);
	
	$address=$province.$city.$county.$detailAddressInfo;
	$result=getLogLat($address);
	$result1=json_decode($result);
	$longitude=$result1->result->location->lng;
	$latitude=$result1->result->location->lat;
	
	$time=time();
	$insert="insert into mall(name,province,city,county,detail_address,image_url,introduceInfo,longitude,latitude,time) values('$name','$province','$city','$county','$detailAddressInfo','{$_POST["pics"][0]}','$introduceInfo','$longitude','$latitude','$time')";
	if(mysql_query($insert)){
		$mall_id=mysql_insert_id();
		$admin_name=$_SESSION["name"];
			for($i=0;$i<count($_POST["pics"]);++$i){
				$insert_mall_pic="insert into mall_pictures(mall_id,pic_url,time) values('$mall_id','{$_POST["pics"][$i]}','$time')";
				//echo $insert_shop_pic."<br>";
				mysql_query($insert_mall_pic);
			}
			echo "<script>alert('Add success!');window.location.href='check_mall.php';</script>";
	}else{
		echo "<script>alert('Add failed,please try again!');window.location.href='check_mall.php';</script>";
		echo mysql_error();
	}
	
?>
