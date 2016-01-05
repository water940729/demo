<?php 
	require_once('../../conn/conn.php'); 
	require_once('../check.php'); 
	$id = intval($_GET["id"]);
	if ($id == 0)
	{
		return;
	}
	$sql = "select * from articles where aid=".$id;
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>文章管理</title>
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
				<li class="l1"><a href="list.php" target="mainFrame" >文章列表</a> </li>
				<li class="l1">><a href="add.php">添加文章</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>位置：文章管理 －&gt; <strong>修改文章</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="do.php?act=update" method="post" id="doForm">
				<input type="hidden" name="id" value="<?php echo $id ?>">

				<p>文章标题：<input class="in1" type="text" name="title" id="title" value="<?php echo $row["title"] ?>"/></p>
				<p>商品详情:</p>
					<script id="editor" type="text/plain" name="content" style="width:1024px;height:300px;">
					<?php echo $row["content"] ?>
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
