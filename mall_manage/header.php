<?php
session_start();
/*
if(!isset($_SESSION['admin_manager_id'])){
	echo "<script>parent.location.href='index.html';</script>";
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>  Head Of Management Interface </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Jiangting@WiiPu -- http://www.wiipu.com" />
	<link rel="stylesheet" href="css/style2.css" type="text/css"/>
 </head>
 <body>
	<div id="header" >
	<img src="images/logo.png"  width="120" height="50"  />	
	<span class="sp1">Mall Center</span>
	</div>
	<div id="quit">
	</div>
	<div id="indx">
		<ul>
			<!--<li><a href="../index.php" target="_blank">前台首页</a></li>
			<li><a href="main.php" target="mainFrame">管理首页</a></li>
			<li><a href="adminpw.php" target="mainFrame">修改密码</a></li>-->
			<li><a target="_parent" href="logout.php">Exist Safety</a></li>
		</ul>
	</div>
 </body>
</html>