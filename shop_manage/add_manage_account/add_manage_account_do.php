<?php
/*
添加管理员


*/
	include_once("../../conn/conn.php");
	require("../system_manage/add_system_log.php");	
	$name=$_POST['name'];
	$role=$_POST['role'];
	$passwd=$_POST['password'];
	$passwd=md5($passwd);
	$time=time();
	if($role==1){
		$insert ="insert into admin_manage(name,passwd,role,time) values('$name','$passwd','$role','$time')";
		$roles="Super Admin";
	}elseif($role==2){
		$mall=$_POST['mall'];
		$insert ="insert into admin_manage(name,passwd,role,mall_id,time) values('$name','$passwd','$role','$mall','$time')";
		$roles="Store manager, store Numbers for management is".$mall;
	}else{
		$shop=$_POST['shop'];
		$select="select mall_id from shop where id='$shop'";
		$result=mysql_query($select);
		$row=mysql_fetch_array($result);
		$mall_id=$row['mall_id'];
		$insert ="insert into admin_manage(name,passwd,role,mall_id,shop_id,time) values('$name','$passwd','$role','$mall_id','$shop','$time')";
		$roles="Merchants manager, store Numbers for management is".$shop;
	}
	
	if(mysql_query($insert)){
		$content="Added an account, account information： account name".$name."，Account permission".$roles;
		if(add_system_log($content)==1){
			$url="manage_account.php";
			echo "<script>alert('Add successful!');window.location.href='".$url."';</script>";
		}else{
			echo "<script>alert('Add failure,please add again!');window.location.href='add_manage_account.php';</script>";
	   }
	}else{
	   echo "<script>alert('Add failure,please add again!');window.location.href='add_manage_account.php';</script>";
	}
?>