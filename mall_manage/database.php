<?php
include_once('conn/conn.php');

/*$sql='create table student_message
(
  student_id int(11) primary key auto_increment,
  student_num varchar(32),
  student_realname varchar(32),
  student_sex varchar(11),
  student_birthday varchar(32),
  student_mobie varchar(32),
  student_school varchar(32),
  student_grade varchar(32),
  student_class varchar(32)

)';*/

$sql ='delete from county';

mysql_query($sql);


?>