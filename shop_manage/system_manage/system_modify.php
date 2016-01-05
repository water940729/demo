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
		mysql_query($sql) or die("EDatabaseError");
		echo 1;
	}catch(Exception $e){
		echo "Unknown abnormal, please try again later";
	}

?>