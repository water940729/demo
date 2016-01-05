<?php
	//写系统日志
	function add_system_log($content){
		$time=time();
		$admin_name=$_SESSION["name"];
		$log="insert into system_log(admin_name,content,time) values('{$admin_name}','{$content}',$time)";
		if(mysql_query($log)){
			return 1;
		}else{
			return $log;
		}
	}
?>