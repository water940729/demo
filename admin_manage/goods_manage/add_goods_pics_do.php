<?php
	require_once('../../conn/conn.php');	 
	$goods_id=$_POST['goods_id'];
	$pic_url=$_POST['pic_url'];
	$time=time();
	$insert="insert into goods_pictures(goods_id,pic_url,time) values('$goods_id','$pic_url','$time')";
	$data=array();
	if(mysql_query($insert)){
		$gp_id=mysql_insert_id();
		$data["gp_id"]=$gp_id;
		$data["result"]=1;
	}else{	
		$data["gp_id"]="";
		$data["result"]="-1";
	}
	echo json_encode($data);
?>