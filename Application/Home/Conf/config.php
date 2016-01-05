<?php
$HTTP_HOST="http://".$_SERVER["HTTP_HOST"];

define('WIIDBHOST','localhost');
define('WIIDBUSER','root');
define('WIIDBPASS','XianLvbu');
define('WIIDBNAME','sunflowerMall');
$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
//配置数据库连接参数
mysql_select_db(WIIDBNAME, $conn);
mysql_query("set names utf8");
$sql="select * from system_info";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$HTML_CACHE_TIME=$row["lifetime"];
if($HTML_CACHE_TIME<0){
	$HTML_CACHE_TIME=0;
}
mysql_close($conn);
return array(
	//'配置项'=>'配置值'
	
	'URL_CASE_INSENSITIVE'=>true,//url不区分大小写
	'URL_MODEL'=>2,//兼容模式
	//'URL_ROUTER_ON'   => true, 
	
	'TMPL_L_DELIM'=>'<{', //修改左定界符
	'TMPL_R_DELIM'=>'}>', //修改右定界符
	
	
	//PDO连接方式
	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => 'XianLvbu', // 密码
	'DB_PREFIX' => '', // 数据库表前缀 
	'DB_DSN' => 'mysql:host=localhost;dbname=sunflowerMall;charset=utf8',
    
    
	'HTML_CACHE_ON' => true, // 开启静态缓存
	'HTML_CACHE_TIME' => $HTML_CACHE_TIME, // 全局静态缓存有效期（秒）
	'HTML_FILE_SUFFIX' => '.html', // 设置静态缓存文件后缀
	
	
    //支付宝配置参数
    'alipay_config'=>array(
        'partner' =>'2088911768765723',   //这里是你在成功申请支付宝接口后获取到的PID，以2088开头的16位纯数字；
		'seller_email'=>'371433325@qq.com',//收款支付宝账号，可空
        'key'=>'jr4tse29t14uz4jrmhd5fxtgq2eiyj8q',//这里是你在成功申请支付宝接口后获取到的Key
        'sign_type'=>strtoupper('MD5'),//签名方式 不需修改
        'input_charset'=> strtolower('utf-8'),//字符编码格式 目前支持 gbk 或 utf-8
        'cacert'=> getcwd().'\\cacert.pem',//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
        'transport'=> 'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
          ),	  
         //以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；
        
    'alipay'   =>array(
	     //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
	    'seller_email'=>'371433325@qq.com',//可以为空
	    //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
	    'notify_url'=>$HTTP_HOST.'/Pay/notify_url', 
	    //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
	    'return_url'=>$HTTP_HOST.'/Pay/return_url',
	    //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
	    'successpage'=>$HTTP_HOST.'/order/success',   
	    //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
	    'errorpage'=>$HTTP_HOST.'/order/fail', 
    ),
	
	//短信验证码配置参数好像没用
	'sms_config'=>array(
		'SMS_URL'=>'http://smsapi.c123.cn/OpenPlatform/OpenApi',           //接口地址
		'SMS_AC'=>'1001@500975760001',		                             //用户账号
		'SMS_AUTHKEY','38B45363B0CD29AFA8CF3683A21AD26E',		         //认证密钥
		'SMS_CGID', '2177',                                                  //通道组编号
		'SMS_CSID','2721',
	),
);