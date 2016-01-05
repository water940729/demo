<?php
	//include ("../../smarty.php"); //引入配置文件
	// Parse with sections
	$ini_array = parse_ini_file("advertisement.ini", true);
    //$smarty->assign('name',$name); //用定义的变量$name的值("OK")替换掉模版中的<{$name}>
	$id=$_POST["id"];
	
	$array=$ini_array[$id];
	$data="<select class='info' name='select2'>";
	foreach($array as $row){
		$data.="<option value='{$row}' class='select2'>".$row."</option>";
	}
	$data.="</select>";
	//print_r($ini_array);
	echo $data;
?>