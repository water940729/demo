<?php
	require("../../conn/conn.php");
	$id=$_GET["id"];
	$name=$_GET["name"];
	$floorid=$_GET["floorid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>超市管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
			$(function(){
				$("#weight").keyup(function(){
					var val=$(this).val();
					if(val!=""&&(val<1||val>9999)){
						alert("请输入合法的数！");
						$(this).val("");
						//return false;
					}
				});		
			});
		</script>
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
					<span>位置：超市管理 －&gt; <strong>楼层管理</strong> －&gt; <strong>分类管理</strong> －&gt; <strong>添加商品</strong></span>
				</div>
				<div class="content">
					<form action="add_floor_type_goods_do.php?from=<?php echo $_GET["from"]?>" method="post" id="doForm">
						<p>商品名称:<?php echo $name;?></p>
						<p>分类权重:<input class="in1" type="text" name="weight" id="weight"/>(输入1-9999中的任意数，数值越大楼层越靠前，默认为1)</p><br/>
						<br/>
						<input type="submit" value="确定添加"></p>
						<input type="hidden" value="<?=$floorid?>" name="floor_type_id">
						<input type="hidden" value="<?=$id?>" name="goods_id">
						<input type="hidden" value="<?=$name?>" name="goods_name">
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>