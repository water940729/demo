<?php
	//session_start();
    require_once('../conn/conn.php');	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> Manage Homepage </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Jiangting@WiiPu -- http://www.wiipu.com" />
  <link rel="stylesheet" href="css/style2.css" type="text/css"/>
 </head>
 <body id="flow">
	<div class="bgintor">
		<div class="tit1">
			<ul>
				<li><a href="#"> Manage Homepage </a> </li>
			</ul>
		</div>
		<div class="bgintor2">
			<div class="bgvline"></div>
			<div class="bgtitle"><span><img src="images/home.gif" width="16" height="15" alt="" /></span>
				<span><strong>Position</strong>:Homepage</span>
			</div>
			<!--
			<div class="bgintor3">
				<div class="left">
					<div class="title2"></div>
					
					<div class="title1"><span class="s1">当前为开发版</span></div>
					
					<div class="bgintor4">
						<p><a href="#"></a></p>
					</div>
				</div>
			</div>
			-->
			<div class="bgintor3">
				<div class="left">
					<div class="title2"></div>
					<div class="title1"><span class="s1">Information</span></div>
					<div class="bgintor4">
						<p>Honorific<?=$_SESSION["name"]?>,The area you can manage is:<?=$_SESSION["role_area"]?></p>
					</div>
				</div>
			</div>
			<div class="bgintor3">
				<div class="left">
					<div class="title2"></div>
					<!--<div class="title1"><span class="s1">个人信息</span></div>
					<div class="bgintor4">
						<p>尊敬的<?=$_SESSION["role_name"]?>,您好！您所管辖的区域是<?=$_SESSION["role_area"]?></p>
						<p>登录帐号：NULL</p>
					</div>
					-->
				</div>
			</div>
			<div id="main"></div>
		</div>
	</div>
 </body>
</html>
