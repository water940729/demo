<?php 
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Articles Manage</title>
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
				<li class="l1"><a href="list.php" target="mainFrame" >Article List</a> </li>
				<li><a href="add.php">Add Articles</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1">
			<span>Position:Articles Manage －&gt; <strong>Add Articles</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="do.php?act=add" method="post" id="doForm">
				<p>Article Title:<input class="in1" type="text" name="title" id="title"/></p>
				<p>Goods Details:</p>
					<script id="editor" type="text/plain" name="content" style="width:1024px;height:300px;">
					</script>
					<br>
				
				<input type="button" value="Submit" onclick="return check()"></p>
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
							alert('Article title cannot be empty');
							f.title.focus();
							return false;
						}
						f.submit();
	}

</script>
