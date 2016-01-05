<?php
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	$mall_id=$_GET['mall_id'];
	$select="select name from mall where id='$mall_id'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);
	$mall_name=$row['name'];
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
						<li><a href="#">商场管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：商场管理 －&gt; 查看商场－&gt; <strong>查看店铺</strong></span>
				</div>
				<div class="content">
					<p><h2>当前商场：<?=$mall_name?></h2><p><br>
					<table width="100%">
						<tr class="t1">
							<td width="10%">店铺序号</td>
							<td width="10%">店铺名称</td>
							<td width="10%">所属商城</td>
							<td width="10%">店铺详情</td>
							<td width="15%">操作</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from shop where mall_id='$mall_id'";
							$rest=mysql_query($select);
							$rs=mysql_fetch_array($rest);
							$count=$rs['page_count'];						
							if($count%$pagesize){
							$pagecount = intval($count/$pagesize)+1;
							}else{
								$pagecount = intval($count/$pagesize);
							}
							if(isset($_GET['page'])){
								$page=intval($_GET['page']);
							}else{
								$page=1;
							}
							$pagestart = ($page-1)*$pagesize;
							
							$sql1="select * from shop where mall_id='$mall_id' order by id desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$name=$row1['name'];
								$image_url=$row1['image_url'];
								$detail=$row1['detail'];
								$mall_id=$row1['mall_id'];
								$sql2="select name from mall where id='$mall_id'";
								$result2=mysql_query($sql2);
								$row2=mysql_fetch_array($result2);
								$mall_name=$row2['name'];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $name?></td>
							<td><?php echo $mall_name?></td>
							<td><?php echo $detail?></td>
							<td>
								<a href="../shop_manage/check_shop_goods.php?mall_id=<?=$mall_id?>&shop_id=<?=$id?>&shop_name=<?=$name?>&from=mall">查看商品</a>|
								<a href="../shop_manage/edit_shop.php?mall_id=<?=$mall_id?>&shop_id=<?=$id?>&shop_name=<?=$name?>&from=mall">修改店铺</a>|
								<a href="javascript:void(0);" onclick="delete_shop_class(<?=$shop_id?>)">删除</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>没有相关信息！</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">当前页:<?php echo $page;?>/<?php echo $pagecount;?>页 每页 <?php echo $pagesize?> 条</div>
						<div class="pageafter">
						<?php echo showPage("check_shop.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
					<br>
					<a href="check_mall.php">返回查看商场</a>
				</div>
			</div>	
		</div>
	</body>
</html>
<script>
	function delete_shop_class(shop_id){
		if(confirm("确认删除吗")){
		$.post("delete_shop_do.php",
			{
				shop_id:shop_id,
			},
			function(data,status){
				if(data==1){
					alert("删除成功!");
					location.reload();
				}else{
					alert("删除失败");
				}
			}
	);}
	}
</script>