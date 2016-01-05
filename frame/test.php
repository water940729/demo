<?php
require_once("database.php");
/*$create="create table test(
		id int(11) primary key auto_increment,
		name varchar(32)
	)";
$alter="alter table test add image_url varchar(128)";
if(mysql_query($create)&&mysql_query($alter)){
	echo "1";
}else{
	echo mysql_error();
	echo "-1";
}*/
$db=new dataBase();
$table=array();
$table["id"]="int(11)";
$table["name"]="varchar(32)";
$table["image_Url"]="varchar(128)";
$db->print_table($table);
?>