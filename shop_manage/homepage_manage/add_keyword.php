<?php
	require("../../conn/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Homepage management</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
		<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery.simple-color.js"></script>
		<script>
			function check()
			{
				var form=document.getElementById("doForm");
				if(form.floor_name.value=="")
				{
					alert('Please fill in the name of keywords!');
					form.name.focus();
					return false;
				}else{
					form.submit();
				}	
			}
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
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Homepage management</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: home page management －&gt; <strong>Add Keywords</strong></span>
				</div>
				<div class="content">
					<form action="add_keyword_do.php" method="post" id="doForm">
						<p>Keyword names:<input class="in1" type="text" name="floor_name"/></p><br/>
						<p>Weight of keywords:<input class="in1" type="text" name="weight" id="weight"/>(Input number between 1 to 9999, the greater the numerical figure the more, the default is 1)</p><br/>
						<br/>
						<input type="button" value="Sure to add" onclick="return check()"></p>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>