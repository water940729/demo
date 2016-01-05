<?php
	define('WIIDBHOST','localhost');
	define('WIIDBUSER','root');
	define('WIIDBPASS','XianLvbu');
	define('WIIDBNAME','sunflowerMall');
	define('WIIDBPRE','info');
	$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
	mysql_select_db(WIIDBNAME, $conn);
	mysql_query("set names utf8");
	$sql1="update goods set monthly_sales=sell";
	$sql2="update goods set quarterly_sales=sell";
	mysql_query($sql1)&&mysql_query($sql2);	
?>