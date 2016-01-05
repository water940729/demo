<?php
	//添加焦点图
	require("../../conn/conn.php");
	$qq=$_POST["qq"];
	$wangwang=$_POST["wangwang"];
    $shop_display = $_POST["shop_display"];
	$id=$_SESSION["shop_id"];
	$sql="update shop set qq='$qq',wangwang='$wangwang',shop_display='$shop_display'";
	mysql_query($sql);
	$url="info.php";
	echo "<script language='javascript' type='text/javascript'>";  
	echo "window.location.href='$url'";  
	echo "</script>";
?>
