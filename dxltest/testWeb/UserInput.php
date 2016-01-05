<?php 
session_start();

$user = $_POST['user_name'];
if(!empty($user))
{
	$_SESSION['user'] = $user;
	$welcom = "您好，".$user."！请录入一下信息后提交！</br>";
}
?>
<html>
<head>
<title>用户信息输入</title>
<body>
<?php 
	echo $welcom;
?>
<form name = "info" method = "POST" action = "HandleUserInfo.php">
<table>
	<tr>
	<td>性别：</td>
	<td><input type = "radio" name = "gender" value ="男">男
	<input type = "radio" name = "gender" value ="女">女</td>
	</tr>
	<tr>
	<td>年龄：</td>
	<td><input type = "text" name = "age" size = "3"></td>
	</tr>
	<tr>
	<td>血型：</td>
	<td><select name = "blood_type">
		<option value = "A">A型</option>
		<option value = "B">B型</option>
		<option value = "AB">AB型</option>
		<option value = "O">O型</option>
		<option value = "other">其他血型</option>
	</select></td>
	</tr>
	<tr><td align = "center"><input type = "submit" value = "提交"></td></tr>
</table>
</form>
</body>
</head>
</html>