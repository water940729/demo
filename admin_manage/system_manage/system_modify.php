<?php
	try{
		require("../../conn/conn.php");
		$sql="update system_info set ";
		while(list($key,$value)=each($_POST)){
			if(is_array($value)){
				foreach($value as $v){
						$sql.=$key."='".$v."' , ";		
				}
			}else{
				$sql.=$key."='".$value."' , ";
				
			}
		}
		$sql=substr($sql,0,-3);
		$sql.=" where id=0";
		mysql_query($sql) or die("数据库异常");
		echo 1;
	}catch(Exception $e){
		echo "未知异常，请稍后再试";
	}

?>