<?php
	require_once('../../conn/conn.php');	 
	$mall_id=$_POST['mall_id'];
	$pic_url=$_POST['pic_url'];
	$time=time();
	$insert="insert into mall_pictures(mall_id,pic_url,time) values('$mall_id','$pic_url','$time')";
	$data=array();
	if(mysql_query($insert)){
		$mp_id=mysql_insert_id();
		$data["mp_id"]=$mp_id;
		$data["result"]=1;
	}else{	
		$data["mp_id"]="";
		$data["result"]="-1";
	}
	echo json_encode($data);
?>