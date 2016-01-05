<?php 

include_once('conn/conn.php');
$community_account=$_POST['account'];
$community_sex=$_POST['community_sex'];
//echo $account." ".$pwd." ".$realname." ".$sex." ".$birthday." ".$mobie;
$sql1 = "select * from community_user where community_account='".$community_account."'";
$sql = "insert into community_user (community_account,user_account,community_sex,create_time,head_img_url) values('".$community_account."','".$_SESSION["user_account"]."','".$community_sex."','".date('y-m-j',time())."',' ')";
if (mysql_query($sql1))
	{	
		echo  "<script>alert('This account has been registered!');window.location.href='register.php';</script>";
	}
else
	{
		if(mysql_query($sql))
		{	
			echo "<script>alert('Registered successfully!');window.location.href='adminlogin.html';</script>";
		}
		else
		{
			echo "<script>alert('Registration failed!');window.location.href='register.php';</script>";
		}
}


?>