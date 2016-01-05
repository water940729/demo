<?php
	//根据关键字搜索商品，name已设为索引
	require("../../conn/conn.php");
	$keyword=$_POST["keyword"];
	$sql="select id,name,mall_name,type1_name,type2_name,type3_name from goods where name regexp'{$keyword}'";
	$result=mysql_query($sql);
	$return=array();
	$i=0;
	$num=mysql_num_rows($result);
	if($num==0){
		return 0;
	}else{
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			$return[$i]=$row;
			$i++;
		}
		print_r(json_encode($return));
	}
	/*[{"id":"1","name":"\u7537\u886c\u886b"},
	{"id":"20","name":"\u7537\u886c\u886b"},
	{"id":"21","name":"\u7537\u886c\u886b"},
	{"id":"22","name":"\u7537\u886c\u886b"},
	{"id":"23","name":"\u7537\u886c\u886b"}]
	*/
?>