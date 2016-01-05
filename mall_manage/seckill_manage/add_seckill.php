<?php
	require("../../conn/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>HomepageManage</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
			$(function(){
				$("#weight").keyup(function(){
					var val=$(this).val();
					if(val!=""&&(val<1||val>9999)){
						alert("Please input a legal number!");
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
					alert('Input floor name!');
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
						<li><a href="#">HomepageManage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:SeckillManage －&gt; <strong>AddSeckill</strong></span>
				</div>
				<div class="content">
					<form action="add_seckill_do.php" method="post" id="doForm">
						<p>SortName:<input class="in1" type="text" name="type_name"/></p><br/>
						<p>SortWeight:<input class="in1" type="text" name="weight" id="weight"/>(Input any number between 1 & 9999,the larger the numerical classification of the front,default is 1)</p><br/>
						<input type="submit" value="Add"></p>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>