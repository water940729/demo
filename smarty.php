<?php
	include("smarty/Smarty.class.php");
	require("conn/conn.php");
	$smarty=new Smarty();
	$smarty->template_dir="templates";
	$smarty->compile_dir="templates_c";
	$smarty->config_dir="config";
        $smarty->cache_dir="cache"; //指定缓存存放目录
        $smarty->caching=false; //关闭缓存（设置为true表示启用缓存）
        $smarty->left_delimiter="<{"; //指定左标签
        $smarty->right_delimiter="}>"; //指定右标
?>
