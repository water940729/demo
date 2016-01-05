<?php
	$ini_array = parse_ini_file("advertisement.ini", true);
	$ini_array[$_POST["select1"]."_price"][$_POST["select2"]]=$_POST["price"];
	
	$content="";
	foreach($ini_array as $key=>$row){
		$content.="[".$key."]\r\n";
		foreach($row as $k=>$v){
			$content.=$k."=".$v."\r\n";
		}
	}
	if(!$file=fopen("advertisement.tmp","w")){
		exit("Can't modify");
	}
	if(!fwrite($file,$content)){
		exit("Server error");
	}
	fclose($file);
	if(rename("advertisement.tmp","advertisement.ini")){
		echo 1;
	}else{
		echo"Modify the failure, please try again";
	}