<?php
	include_once('../../conn/sqlHelper.php');
	$sqlhelper=new sqlHelper();
	$role=$_SESSION['role'];
	$value = $_POST['value'];
	if($value==2){
		$sql="select id,name from mall";
	}else if($value==3){
		$area=" ";
		if($role==1){
			$area=" ";
			$sql="select id,name from mall";
		}else if($role==2){
			$mall_id=$_SESSION['mall_id'];
			$area=" where mall_id='$mall_id' ";
			$sql="select id,name from shop".$area;
		}
	}
	$arr=$sqlhelper->execute_more($sql);
	$data=json_encode($arr);
	echo $data;
?>