<?php 
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>促销公告管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../js/ueditor.all.min.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../js/lang/zh-cn/zh-cn.js"></script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">				
			<ul>
				<li class="l1"><a href="manage_sales.php" target="mainFrame" >公告列表</a> </li>
				<li><a href="add_sales.php">添加公告</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>位置：促销公告管理 －&gt; <strong>添加公告</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_sales_do.php?act=add" method="post" id="doForm">
				<p>公告标题：<input class="in1" type="text" name="title" id="title"/></p>
				<p>商品详情:</p>
					<script id="editor" type="text/plain" name="content" style="width:1024px;height:300px;">
					</script>
					<br>
				
				<input type="button" value="提交" onclick="return check()"></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>
<script>
var editor = new UE.ui.Editor();
editor.render('editor');

	function check()
	{
						var f=document.getElementById('doForm');
						if(f.title.value=="")
						{
							alert('文章标题不能为空');
							f.title.focus();
							return false;
						}
						f.submit();
	}

</script>