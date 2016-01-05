<?php
	require("../../conn/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Home page management</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
			$(function(){
				$("#weight").keyup(function(){
					var val=$(this).val();
					if(val!=""&&(val<1||val>9999)){
						alert("Please enter the legal number!");
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
					alert('Please fill out the name of floor!');
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
						<li><a href="#">Home page management</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: seckill management －&gt; <strong>Add seconds kill</strong></span>
				</div>
				<div class="content">
					<form action="add_seckill_do.php" method="post" id="doForm">
						<p>Category name:<input class="in1" type="text" name="type_name"/></p><br/>
						<p>Category weight:<input class="in1" type="text" name="weight" id="weight"/>(Input number between 1 to 9999, the larger the numerical classification of the front, the default is 1)</p><br/>
						<input type="submit" value="Add"></p>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>