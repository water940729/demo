<?php
include_once("../../conn/conn.php");
$name=$_POST['account'];
$select ="select count(*) as count from admin_manage where name='$name'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);
$count=$row['count'];
if($count>0)
{
	echo 1;
}
else
{
   echo -1;
}
?>