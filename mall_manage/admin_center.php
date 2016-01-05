<?php
include_once('../conn/conn.php');

if(!isset($_SESSION['id'])){
	header("Location:index.html");
	return;
}
$time=time();
$role=$_SESSION['role'];
$id=$_SESSION['id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="Jiangting@WiiPu -- http://www.wiipu.com" />
		<title> Back-stage Management  Center</title>
	</head>
	<frameset rows="80,*,123" frameborder="no" border="0" framespacing="0" id="top">
	  <frame src="header.php" id="topFrame" scrolling="no" noresize="noresize" title="TopFrame" />
	  <frameset cols="205,7,*" frameborder="no" border="0" framespacing="0" id="frams">
		<frame src="menu.php" id="menuFrame" noresize="noresize" title="menuFrame"/>
		<frame src="switchframe.php"  noresize="noresize" title="switchFrame"/>

		<frame src="main.php" id="mainFrame" name="mainFrame" title="mainFrame" />
	  </frameset>
	  <frame src="footer.php" id="footFrame" scrolling="no" noresize="noresize" title="FootFrame" />
	</frameset>
	<noframes>
		<body>
		</body>
	</noframes>
</html>