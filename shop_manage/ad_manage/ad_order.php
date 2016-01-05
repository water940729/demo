<?php
	require("../../conn/conn.php");
	include ("../../smarty.php"); //引入配置文件
    //$smarty->assign('name',$name); //用定义的变量$name的值("OK")替换掉模版中的<{$name}>
	/*$url=$_SERVER["HTTP_HOST"];
	$smarty->assign("url",$url);
	$result=mysql_query("select * from system_info") or die("数据库异常");
	$array=mysql_fetch_array($result);
	$smarty->assign("array",$array);
	*/
	$smarty->display("../../templates/advertisement/order.html"); //显示模版文件夹中的index.html
?>