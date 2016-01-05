<?php
	require("../../conn/conn.php");
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])){
		if(isset($_POST["type"])){//修改推荐商品
			//print_r($_POST["data"]);
			$sql="update market_info set recomm_id='{$_POST['data']}' where id=1";
		}else{
			//修改推荐商品的个数
			$sql="update market_info set recomm_num=$_POST[num] where id=1";	
		}
		if(mysql_query($sql)){
			echo "修改成功";
		}else{
			echo "修改失败";
		}
	}else{
		header("location:../admin_center.php");
	}
	//print_r($_SERVER["HTTP_X_REQUESTED_WITH"]);
/*Array
(
    [HTTP_HOST] => 112.124.3.197:8006
    [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0
    [HTTP_ACCEPT] => 
    [HTTP_ACCEPT_LANGUAGE] => zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3
    [HTTP_ACCEPT_ENCODING] => gzip, deflate
    [CONTENT_TYPE] => application/x-www-form-urlencoded; charset=UTF-8
    [HTTP_X_REQUESTED_WITH] => XMLHttpRequest
    [HTTP_REFERER] => http://112.124.3.197:8006/admin_manage/goods_manage/recommend.php
    [CONTENT_LENGTH] => 7
    [HTTP_COOKIE] => PHPSESSID=2miqo2destbuoqlq4n326rsqe1
    [HTTP_CONNECTION] => keep-alive
    [HTTP_PRAGMA] => no-cache
    [HTTP_CACHE_CONTROL] => no-cache
    [PATH] => /usr/kerberos/bin:/usr/local/bin:/bin:/usr/bin:/home/chenhuanyang/bin
    [SERVER_SIGNATURE] => 
    [SERVER_SOFTWARE] => Apache/2.4.3 (Unix) PHP/5.4.8
    [SERVER_NAME] => 112.124.3.197
    [SERVER_ADDR] => 112.124.3.197
    [SERVER_PORT] => 8006
    [REMOTE_ADDR] => 113.139.214.250
    [DOCUMENT_ROOT] => /home/chenhuanyang/local/apache/htdocs
    [REQUEST_SCHEME] => http
    [CONTEXT_PREFIX] => 
    [CONTEXT_DOCUMENT_ROOT] => /home/chenhuanyang/local/apache/htdocs
    [SERVER_ADMIN] => you@example.com
    [SCRIPT_FILENAME] => /home/chenhuanyang/local/apache/htdocs/admin_manage/goods_manage/recommend_do.php
    [REMOTE_PORT] => 58070
    [GATEWAY_INTERFACE] => CGI/1.1
    [SERVER_PROTOCOL] => HTTP/1.1
    [REQUEST_METHOD] => POST
    [QUERY_STRING] => 
    [REQUEST_URI] => /admin_manage/goods_manage/recommend_do.php
    [SCRIPT_NAME] => /admin_manage/goods_manage/recommend_do.php
    [PHP_SELF] => /admin_manage/goods_manage/recommend_do.php
    [REQUEST_TIME_FLOAT] => 1434173651.491
    [REQUEST_TIME] => 1434173651
)
*/
