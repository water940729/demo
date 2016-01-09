<?php
	//添加焦点图
	require("../../conn/conn.php");
	$sql="select qq,wangwang,shop_display from shop where id=$_SESSION[shop_id]";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Home page management</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
	</head>
	<body>
		<div class="bgintor" style="width:98%;">				
			<div class="listintor" style="border:none;">
				<div class="tit1">
					<ul>				
						<li><a href="#">Home page management</a></li>
					</ul>		
				</div>
				<div class="warp-border" style="border:1px solid #ccc;">
				<div class="header1" style="margin-top:10px;">
					<span>Location: business information －&gt; <strong>Information management </strong></span>
				</div>
				<div class="content">
					<form action="add_info.php" method="post" id="doForm">
						<p>Customer Services's QQ:<input class="in1" type="text" name="qq" value="<?php echo $row["qq"]?>"/></p><br/>
						<p>Customer Services's Wangwang:<input class="in1" type="text" name="wangwang" value="<?php echo $row["wangwang"]?>"/></p><br/>
                        <p>Style of the shop:<input class="in1" type="text" name="shop_display" value="<?php 
                            if($row["shop_display"] == 1){
                                echo "The style sheet 1";
                            } else {
                                echo "The style sheet 2";
                            }
                        ?>" /></p>
                        <br />
						<input type="submit" value="Modify" class="confirm"></p>
					</form>
				</div>
			</div>	
			</div>
		</div>
	</body>
</html>
