<?php
	require_once('../../conn/conn.php');	 
	$shop_id=$_POST['shop_id'];
	$pic_url=$_POST['pic_url'];
	$time=time();
	$insert="insert into shop_pictures(shop_id,pic_url,time) values('$shop_id','$pic_url','$time')";
	$data=array();
	if(mysql_query($insert)){
		$gp_id=mysql_insert_id();
		$data["sp_id"]=$sp_id;
		$data["result"]=1;
	}else{	
		$data["sp_id"]="";
		$data["result"]="-1";
	}
	echo json_encode($data);
?>