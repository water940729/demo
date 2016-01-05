<?php 
header("Content-type:text/html;charset=utf8");
$user_name = $_POST['user_name'];
$gender = $_POST['gender'];
$hobby = $_POST['hobby'][0].",".$_POST['hobby'][1].",".$_POST['hobby'][2].",".$_POST['hobby'][3];
$prof = $_POST['occupy'];

if($user_name == "")
{
	echo "请返回输入用户名！";
	exit;
}

echo "用户名：".$user_name."</br>";
echo "姓名：".$gender."</br>";
echo "爱好：".$hobby."</br>";
echo "职业：".$prof."</br>";
?>
