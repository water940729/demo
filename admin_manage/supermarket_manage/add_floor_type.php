<?php
	require("../../conn/conn.php");
	$id=$_GET["id"];
	$name=$_GET["name"];
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
			$("#addType").click(function(){
				var name=$("option:selected").text();
				var prev=$.trim($("#prev").val());//去除首尾空格
				/*if(prev==""){
					var content=name;
				}else{
					var content=prev+","+name;
				}
				*/
				$("#prev").val(name);
				return false;
			});
			$("#map").click(function(){
				if($(this).is(":checked")){
					var id=$("option:selected").val();
					var name=$("option:selected").text();
					$("#type1_id").val(id);
					$("#type1_name").val(name);
				}
				//alert("11");
			});
			$("#weight").keyup(function(){
				var val=$(this).val();
				if(val!=""&&(val<1||val>9999)){
					alert("请输入合法的数！");
					$(this).val("");
					//return false;
				}
			});
		})
		function check(){
			var name=$.trim($("#prev").val());//去除多余空格
			if(name==""){
				alert("分类名称不能为空");
				return false;
			}else{
				$("#doForm").submit();
			}
		}
		</script>
		<!--<script type="text/javascript" src="../js/upload.js"></script>
		<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery.simple-color.js"></script>
		-->
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
					<span>位置：超市管理 －&gt; <strong>添加楼层</strong> －&gt; <strong>分类管理</strong> －&gt; <strong>添加分类</strong></span>
				</div>
				<div class="content">
					<form action="add_floor_type_do.php" method="post" id="doForm">
						<p>分类名称:<input class="in1" type="text" name="type_name" id="prev"/>从现有分类中选择	
						<select name="typename">
							<?php
								$sql="select * from super_goods_type1";
								$result=mysql_query($sql);
								while($rows=mysql_fetch_assoc($result)){
									echo "<option value='{$rows["id"]}'>$rows[name]</option>";
								}
							?>
						</select> <button id="addType">添加</button></p><br/>
						<p><input type="checkbox" name="map" id="map">是否建立关联</p><br/>
						<input type="hidden" name="type1_id" id="type1_id">
						<input type="hidden" name="type1_name" id="type1_name">
						<p>分类权重:<input class="in1" type="text" name="weight" id="weight"/>(输入1-9999中的任意数，数值越大楼层越靠前，默认为1)</p><br/>
						<br/>
						<input type="button" value="确定添加" onclick="return check()"></p>
						<input type="hidden" value="<?=$name?>" name="floor_name">
						<input type="hidden" value="<?=$id?>" name="floor_id">
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>