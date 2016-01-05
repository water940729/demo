<?php
	//修改二级分类
	require_once("../../conn/conn.php");
	$id=$_GET['id'];
	$sql="select name from super_goods_type2 where id=$id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	//print_r($row);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">超市管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：超市管理 －&gt; 商品分类－&gt; <strong>二级分类</strong></span>
				</div>
				<div class="content">
					<div style="text-align:left">
						<p>当前分类：<?php echo $row["name"];?></p><br>
						<form action="modify_shop_food_do.php" method="post" id="doForm">
							<p>分类名称：<input class="in1" type="text" name="goods_type"/>	
							<input type="submit" value="修改"></p>
							<input type="hidden" value=2 name="type">
							<input type="hidden" value="<?php echo $id;?>" name="id">
						</form>
					</div>