<?php 
//酸甜苦辣咸麻
require_once('../../conn/conn.php');
for($i=5;$i<25;$i++){
	$food_name="chinese hamburger";
	$food_time_expected="30";
	$food_flavor_type="salty";
	$food_price="￥20";
	$food_type_id=7;
	$shop_id=$i;
	$food_introduce_info="I like ShanXi snacks,there serval shops selling ShanXi snacks near my house,my favorite food are chinese hamburger and cold noodle.That is why I went to XiAn during my evection,all in my mind was food of ShanXi";
	$insert="insert into food (food_name,food_time_expected,food_flavor_type,food_introduce_info,food_price,food_type_id,shop_id) values ('$food_name','$food_time_expected','$food_flavor_type','$food_introduce_info','$food_price','$food_type_id','$shop_id')";
	echo $insert;
	if(mysql_query($insert)){
		
		echo "<script>alert('Insert success')</script>";
	}
	
}
?>