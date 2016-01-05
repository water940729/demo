<?php 
session_start();

$user = $_SESSION['user'];
if(!empty($user))
{
	$_SESSION['user'] = $user;
	$welcom = "您好，".$user."！请录入一下信息后提交！</br>";
}

$gender = $_POST['gender'];
$age = $_POST['age'];
$blood = $_POST['blood_type'];
$user = $_POST['user'];

if(!empty($gender)&&!empty($age)&&!empty($blood))
{
	echo "性别：".$gender."</br>";
	echo "年龄：".$age."</br>";
	echo "血型：".$blood."</br>";
	echo "用户：".$user."</br>";
}
else
{
?>
<html>
<head>
	<script language = "JavaScript">
	$url = "http://112.124.3.197:8006/dxltest/testWeb/UserInput.php";
	window.location.href=$url;
	</script>
	</head>
</html> 
<?php
}
?>