<?php 
//酸甜苦辣咸麻
require_once('../../conn/conn.php');
for($i=5;$i<25;$i++){
	$food_name="肉夹馍";
	$food_time_expected="30";
	$food_flavor_type="咸";
	$food_price="20元";
	$food_type_id=7;
	$shop_id=$i;
	$food_introduce_info="我很喜欢陕西的特色小吃，我家周围就有两家专门经营陕西小吃的店，我对店里的肉夹馍、凉皮情有独钟，为此特意借出差之际跑到西安大吃了几天，一想到光是自己吃的";
	$insert="insert into food (food_name,food_time_expected,food_flavor_type,food_introduce_info,food_price,food_type_id,shop_id) values ('$food_name','$food_time_expected','$food_flavor_type','$food_introduce_info','$food_price','$food_type_id','$shop_id')";
	echo $insert;
	if(mysql_query($insert)){
		
		echo "<script>alert('插入成功')</script>";
	}
	
}
?>