<?php
	require("../../conn/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>预售管理</title>
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
			})
			function check()
			{
				var form=document.getElementById("doForm");
				if(form.type_name.value=="")
				{
					alert('请填写楼层名称！');
					form.name.focus();
					return false;
				}else{
					form.submit();
				}	
			}
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">预售管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：预售管理 －&gt; <strong>添加预售</strong></span>
				</div>
				<div class="content">
					<form action="add_book_do.php" method="post" id="doForm">
						<p>分类名称:<input class="in1" type="text" name="type_name"/></p><br/>
						<p>分类权重:<input class="in1" type="text" name="weight" id="weight"/>(输入1-9999中的任意数，数值越大分类越靠前，默认为1)</p><br/>
						<input type="submit" value="添加"></p>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>