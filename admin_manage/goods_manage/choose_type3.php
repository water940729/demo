<?php
	require("../../conn/conn.php");
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		//echo 11;
		$data=explode(" ",$_POST["value"]);
		$id=$data[0];
		$sql="select attribute1,attribute2,attribute3,attribute4 from goods_type3 where id=$id";
		$result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		$return=array();
		$i=0;
		foreach($row as $item){
			if(!empty($item)){
				$i++;
				$data=explode(":",$item);
				$return[$i]["name"]=$data[0];
				$return[$i]["value"]=explode(",",$data[1]);	
			}
		}
		echo json_encode($return);
		//print_r($return);
	}else{
		header('HTTP/1.1 404 Not Found');
		header("status: 404 Not Found");
	}
?>