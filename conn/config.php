<?php
	//error_reporting(0);    //网站开发必须关闭此处，网站上线必须打开此处
	header("content-type:text/html;charset=utf-8");
	header("Cache-Control: no-cache");
	error_reporting(0);
	session_set_cookie_params(0,'../');
    session_name('adminPHPSESSID');
	session_start();	

	
	//配置数据库连接参数
	define('WIIDBHOST','localhost');
	define('WIIDBUSER','root');
	define('WIIDBPASS','XianLvbu');
	define('WIIDBNAME','sunflowerMall');
	define('WIIDBPRE','info');
	
	//define('SYSTEM_URL','http://42.121.5.90/g_yujing/');
	//配置管理员密码
	
	//配置中转服务器
	define('SERVER_HOST', 'vicc.so');
	define('SERVER_PORT', 6010);
	
	
	//PC版管理系统配置
	define('URL','/images/');//配置上传图片路径
	if($_SERVER["HTTP_HOST"]=="112.124.3.197:8010"){
		define('SYSTEM_IP','http://112.124.3.197:8010');//配置服务器url
		define('HOME_PATH','/home/chenhuanyang/local/apache/htdocs');	
	}else{
		//define('SYSTEM_IP','http://120.25.124.134');//配置服务器url
		//define('HOME_PATH','/home/wiipu/local/apache/htdocs');
		define('SYSTEM_IP','http://localhost');//配置服务器url
		define('HOME_PATH','C:\wamp\www');		
	}
	//define("SYSTEM_IP","localhost");
	//define('HOME_PATH','c:/wamp/www/Mall');
?>
