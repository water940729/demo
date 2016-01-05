<?php
/**
 * 管理员登录
 *
 * @version       v0.01
 * @create time   2011-5-16
 * @update time   
 * @author        jiangting
 * @copyright     Copyright (c) 微普科技 WiiPu Tech Inc. (http://www.wiipu.com)
 */
	require_once('../conn/conn2.php');
	require_once('inc_function.php');
	$name=sqlReplace(trim($_POST['name']));
	$passwd=sqlReplace(trim($_POST['pwd']));
	$code=trim($_POST['code']);
	$sql="select * from admin_manage where name='".$name."' and passwd='".md5($passwd)."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if($row){
		$_SESSION['name'] = $name;
		$_SESSION['role'] = $row['role'];
		$sql="update admin_manage set last_ip=now_ip,now_ip='{$_SERVER[REMOTE_ADDR]}',time=now_time,now_time=NOW(),log_num=log_num+1 where id=$row[id];";
		mysql_query($sql) or die("$row[id]");
		if($row['role']==1){
			$_SESSION["role_area"]="超级管理员";
		}else{
			if($row["role"]==2){
				$sql="select name from mall where id=$row[mall_id]";
				$result=mysql_query($sql) or die("未知原因查询失败");
				$mall=mysql_fetch_array($result);
				$_SESSION["role_area"]=$mall["name"];
			}else{
				$sql="select name from shop where mall_id=$row[mall_id] and id=$row[shop_id]";
				$result=mysql_query($sql) or die("未知原因查询失败");
				$mall=mysql_fetch_array($result);
				$_SESSION["role_area"]=$mall["name"];
			}
		}
		$_SESSION['id'] = $row['id'];
		$_SESSION['shop_id']=$row['shop_id'];
		$_SESSION['mall_id']=$row['mall_id'];
		if($_SESSION["role"]==1){
			header('Location:admin_center.php');	
		}else{
			unset($_SESSION);
			$url="http://".$_SERVER["HTTP_HOST"]."/admin_manage/index.html";
			//echo $url;
			echo"<script>alert('权限不够');window.location.href='".$url."'</script>";
		}

	}else{
		echo "用户名密码错误，返回<a href='index.html'>重新登录</a>";
	}
?>