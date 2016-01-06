<?php
	include_once('../../conn/sqlHelper.php');
	$sqlhelper=new sqlHelper();
	$role=$_SESSION['role'];
	$value = $_POST['value'];
	$sql="select id,name from shop";
	$arr=$sqlhelper->execute_more($sql);
	$data=json_encode($arr);
	echo $data;
?>