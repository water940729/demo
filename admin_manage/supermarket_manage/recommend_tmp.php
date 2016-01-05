<?php
	require_once('../../conn/conn.php');
	$role=$_SESSION['role'];
	$shop_id=$_SESSION['shop_id'];
	$mall_id=$_SESSION['mall_id'];
	//print_r($_SESSION);
	//Array ( [wii_imgcode] => 7786 [name] => water [role] => 1 [role_area] => 超级管理员 [id] => 10 [shop_id] => 0 [mall_id] => 0 ) 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>商品管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    	<script type="text/javascript" src="../js/upload.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="../js/ueditor.all.min.js"> </script>
        <script type="text/javascript" charset="utf-8" src="../js/lang/zh-cn/zh-cn.js"></script>
		<script>
			function check(){
				var num=$("#goodsNum").val();
				if(num<=0){
					alert("请输入一个大于0的数");
					return false;
				}else{
					var num1=$("#select1 option").length;
					if(num<num1){
						alert("当前推荐的商品已超过"+num+"，请先删除部分当前推荐的商品");
					}else{
						$.ajax({
							type:"POST",
							data:"num="+num,
							url:"recommend_do.php",
							success:function(msg){
								alert(msg);
								location.reload();
							}
						})
					}
				}
			}
			$(function(){
				$("#add").click(function(){
					var num=$("#select1 option").length;
					var num2=$("#select2 option:selected").length;
					var now=$("#now").text();
					if(num+num2<=now){
						var $options=$("#select2 option:selected");
						$options.appendTo("#select1");
					}else{
						alert("推荐商品已满!");
					}
				});
				$("#remove").click(function(){
					var $options=$("#select1 option:selected");
					$options.appendTo("#select2");					
				});
				$("#save").click(function(){
					var $option=$("#select1 option");
					var data="";
					var i=1;
					$option.each(function(){
						data=data+$(this).val()+","+$(this).text()+","+i+";";
						i++;
					});
					$.ajax({
						type:"POST",
						url:"recommend_do.php",
						data:"data="+data+"&type=save",
						success:function(msg){
							alert(msg);
							location.reload();
						}
					})
				});
				$("#down").click(function(){
					var $option=$("#select1 option:selected");
					var $next=$("#select1 option:selected").next("#select1 option");
					$option.insertAfter($next);
				});
				$("#up").click(function(){
					var $option=$("#select1 option:selected");
					var $next=$("#select1 option:selected").prev("#select1 option");
					$option.insertBefore($next);
				});
			})
		</script>
	</head>
	<body>
	<div class="bgintor">
		<div class="tit1">
			<ul>				
				<li><a href="#">商品管理</a> </li>
			</ul>		
		</div>
	<div class="listintor">
		<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
			<span>位置：商品管理 －&gt; <strong>精选推荐</strong></span>
		</div>
		<div class="fromcontent">
				<p><font style="font-size:15px;color:red">推荐基本信息:</font></p>
				<p>当前推荐个数:<span id="now"><?php $sql="select recomm_num,recomm_id from market_info where id=1";
					$result=mysql_query($sql);
					$row=mysql_fetch_array($result);
					//print_r($row);
					echo $row["recomm_num"];
					
					?>
					</span></p>
				<p>当前推荐的商品:
				<?php
					$row["recomm_id"]=trim($row["recomm_id"]);
					echo '<select multiple id="select1" style="width:130px;height:160px;">';
					if(!empty($row["recomm_id"])){
						$item=explode(";",$row["recomm_id"]);//
						$in="(";
						foreach($item as $vi){
							if(!empty($vi)){
								$vo=explode(",",$vi);//id与商品名,权重之间用,隔开
								echo "<option value='{$vo[0]}'>$vo[1]</option>";
								$in.=$vo[0].',';
							}
						}
						$in=substr($in,0,-1).")";//已添加为推荐商品的id
					}
					echo '</select>';
					echo "<button id='remove'>&gt;&gt;</button>";
					echo "<button id='up'>&#8593;</button>";
					echo "<button id='down'>&#8595;</button>";
				?>
				</p>
				<p>可添加推荐的商品:
				<?php
					echo "<button id='add'>&lt;&lt;</button>";
					echo '<select multiple id="select2" style="width:130px;height:160px;">';				
					if(!empty($row["recomm_id"])){
						//echo $in;
						$sql="select id,name from goods where id not in $in";
					}else{
						$sql="select id,name from goods";
					}
					$result=mysql_query($sql);
					while($row=mysql_fetch_array($result)){
						echo"<option value='{$row["id"]}'>$row[name]</option>";
					}
					echo '</select>';
				?>
				<button id="save">保存</button>
				</p>
			<form action="add_goods_do.php" method="post" id="doForm">
			<p><font style="font-size:15px;color:red">修改基本信息:</font></p>
				<p>精选推荐个数：<input class="in1" type="text" name="num" id="goodsNum"/></p>
				<p><input type="button" value="提交" onclick="return check()"></p>
			</form>
		</div>
	</div>
  </div>
 </body>
</html>