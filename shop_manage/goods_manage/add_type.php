<?php 
	require_once("../../conn/conn.php");
	$type=$_GET['type'];
	$id=$_GET['id'];
	$result1=mysql_query($select1);
	$row1=mysql_fetch_array($result1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Commodity category</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">Goods category</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>Location: Commodity management －&gt; <strong>Commodity category</strong></span>
		</div>		
		<div class="fromcontent">
			<form action="add_type_do.php" method="post" id="doForm">
				<p>Category name:<input class="in1" type="text" name="goods_type"/>	
				<input type="button" value="Sure to add" onclick="return check()"></p>
				<input type="hidden" value="<?=$type?>" name="type">
				<input type="hidden" value="<?=$id?>" name="id">
			</form>
		</div>
		<div>
		</div>
	</div> 
  </div>
 </body>
</html>
<script>
form=document.getElementById("doForm");
function check()
{
	if(form.goods_type.value=="")
	{
		alert('Please fill in the user name!');
		form.name.focus();
		return false;
	}else{
		form.submit();
	}	
}
</script>
