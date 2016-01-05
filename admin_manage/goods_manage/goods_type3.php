<?php 
/**
*三级分类显示
*
*/
	require_once("../../conn/conn.php");
	$type1_id=$_GET['id'];//一级分类
	$type2_id=$_GET["type1_id"];//二级分类
	$type=3;
	$select="select * from goods_type2 where type1_id=$type1_id";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$type1_name=$row["name"];//二级分类名称
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">商品分类</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：商品管理 －&gt; 商品分类－&gt; <strong>三级分类</strong></span>
				</div>
				<div class="content">
					<div style="text-align:left">
						<p>当前分类：<?=$type1_name?></p><br>
						<form action="add_type_do.php" method="post" id="doForm">
							<p>分类名称：<input class="in1" type="text" name="goods_type"/></p><br/>
							<p>(筛选属性没有可不填，格式为，属性名:属性值1,属性值2  属性名与属性值用英文冒号隔开，多个属性值用英文逗号,隔开)</p><br/>
							<p>筛选属性1：<input class="in1" type="text" name="attribute1"/></p><br/>
							<p>筛选属性2：<input class="in1" type="text" name="attribute2"/></p><br/>
							<p>筛选属性3：<input class="in1" type="text" name="attribute3"/></p><br/>
							<p>筛选属性4：<input class="in1" type="text" name="attribute4"/></p><br/>
							<p><input type="button" value="确定添加" onclick="return check()"></p>
							<input type="hidden" value=3 name="type">
							<input type="hidden" value="<?=$type1_id?>" name="type1_id">
							<input type="hidden" value="<?=$type2_id?>" name="type2_id">
						</form>
					</div>
					<br/>
					<table style="width:100%">
						<tr class="t1">
							<td style="10%">序号</td>
							<td style="10%">分类名称</td>
							<td style="10%">操作</td>
						</tr>
						<?php
						$select="select * from goods_type3 where type2_id=$type2_id";
						$res=mysql_query($select);
						while($row=mysql_fetch_array($res)){
							$type3_id=$row['id'];
							$type3_name=$row['name'];
						?>
							<tr>
								<td><?php echo $type3_id ?></td>
								<td><?php echo $type3_name?></td>
								<td><a href="<?php echo "modify_shop_foods.php?id=$type3_id&&type2_id=$type2_id";?>">修改</a>|<a href="javascript:void(0);" onclick="delete_foods2(<?php echo $type3_id ?>)">删除</a></td>
							</tr>
						<?php
						}
						?>
					</table>
					<a href='goods_type2.php?id=<?php echo $type1_id;?>'>返回</a>
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
		alert('请填写分类名称！');
		form.name.focus();
		return false;
	}else{
		form.submit();
	}	
}
function delete_foods2(id){
		if(confirm("确认删除吗")){
			$.post("delete_foods3_do.php",
				{
					goods_id:id
				},
				function(data,status){
					if(data==1){
						alert("删除成功!");
						location.reload();
					}else{
						alert(data);
						alert("删除失败");
					}
				}
			);
		}
}
</script>