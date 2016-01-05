<?php
	//修改三级分类
	require_once("../../conn/conn.php");
	$id=$_GET['id'];//三级分类编号
	$type2_id=$_GET["type2_id"];//二级分类编号
	$sql="select name,attribute1,attribute2,attribute3,attribute4 from goods_type3 where id=$id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
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
						<li><a href="#">商品分类</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：商品管理 －&gt; 商品分类－&gt; <strong>三级分类</strong></span>
				</div>
				<div class="content">
					<div style="text-align:left">
						<p>当前分类：<?php echo$row["name"];?></p><br>
						<form action="modify_shop_foods_do.php" method="post" id="doForm">
							<p>分类名称：<input class="in1" type="text" name="goods_type" value="<?php echo$row["name"];?>"/></p>
							<p>(筛选属性没有可不填，格式为，属性名:属性值1,属性值2  属性名与属性值用英文冒号隔开，多个属性值用英文逗号,隔开)</p><br/>
							<p>筛选属性1：<input class="in1" type="text" name="attribute1" value="<?php echo$row[attribute1]?>"/></p><br/>
							<p>筛选属性2：<input class="in1" type="text" name="attribute2" value="<?php echo$row[attribute2]?>"/></p><br/>
							<p>筛选属性3：<input class="in1" type="text" name="attribute3" value="<?php echo$row[attribute3]?>"/></p><br/>
							<p>筛选属性4：<input class="in1" type="text" name="attribute4" value="<?php echo$row[attribute4]?>"/></p><br/>
							<p><input type="submit" value="修改"></p>
							<input type="hidden" value=2 name="type">
							<input type="hidden" value="<?php echo $id;?>" name="id">
							<input type="hidden" value="<?php echo $type2_id;?>" name="type2_id">
						</form>
					</div>