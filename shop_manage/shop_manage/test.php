<?php 
//酸甜苦辣咸麻
require_once('../../conn/conn.php');
for($i=5;$i<25;$i++){
	$food_name="Rou jia mo";
	$food_time_expected="30";
	$food_flavor_type="salty";
	$food_price="20RMB";
	$food_type_id=7;
	$shop_id=$i;
	$food_introduce_info="I am very fond of shaanxi delicacies around my house has two specializes in shaanxi snack shop, and I have a special liking to store meat clip buns, liangpi, designedly for travel time to go to xi 'an big eat for several days, the thought of to eat alone";
	$insert="insert into food (food_name,food_time_expected,food_flavor_type,food_introduce_info,food_price,food_type_id,shop_id) values ('$food_name','$food_time_expected','$food_flavor_type','$food_introduce_info','$food_price','$food_type_id','$shop_id')";
	echo $insert;
	if(mysql_query($insert)){
		
		echo "<script>alert('Insert successful')</script>";
	}
	
}
?>