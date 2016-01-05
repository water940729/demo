<?php
	require("../../conn/conn.php");
	$id=$_GET["id"];
	$name=$_GET["name"];
	$floorid=$_GET["floorid"];
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
			});
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
					<span>Location: home page management －&gt; <strong>Floor management</strong> －&gt; <strong>Classification Management</strong> －&gt; <strong>Add commodity</strong></span>
				</div>
				<div class="content">
					<form action="add_floor_type_goods_do.php?from=<?php echo $_GET["from"]?>" method="post" id="doForm">
						<p>Commodity name:<?php echo $name;?></p>
						<p>Classification weight:<input class="in1" type="text" name="weight" id="weight"/>(Input number between 1 to 9999, the greater the numerical figure the more, the default is 1)</p><br/>
						<br/>
						<input type="submit" value="Sure to add"></p>
						<input type="hidden" value="<?=$floorid?>" name="floor_type_id">
						<input type="hidden" value="<?=$id?>" name="goods_id">
						<input type="hidden" value="<?=$name?>" name="goods_name">
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>