<?php
	require("../../conn/conn.php");
	$id=$_GET["id"];
	$name=$_GET["name"];
	$area=" where floor_id=$id";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>超市管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<!--<script type="text/javascript" src="../js/upload.js"></script>-->
		<script>
			function delete_floor_type(id){
				if(confirm("确认删除")){
					$.ajax({
						data:"id="+id,
						type:"POST",
						url:"delete_floor_type.php",
						success:function(msg){
							alert(msg);
							location.reload();
						}
					})
				}
			}
		</script>
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
					<span>位置：超市管理 －&gt; <strong>楼层管理</strong> －&gt; <strong>分类管理</strong></span>
				</div>
				<div class="content">
					<a href="add_floor_type.php?id=<?php echo $id;?>&name=<?=$name?>"><strong>添加分类</strong></a><br/>
					<table width="100%">
						<tr class="t1">
							<td width="5%">自定义分类名</td>
							<td width="10%">楼层名</td>
							<td width="10%">分类权重</td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">对应的系统分类</td>
							<td width="10%">操作</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from super_floorTypeManage".$area;
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
							$sql1="select * from super_floorTypeManage".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$typename=$row1["typename"];
								$floor_name=$row1["floor_name"];
								$weight=$row1["weight"];
								$type1_name=$row1["type1_name"];
						?>
						<tr>
							<td><?php echo $typename?></td>
							<td><?php echo$floor_name?></td>
							<td><?php echo $weight?></td>
							<td><?php echo $type1_name?></td>
							<?php /*<td><?php echo $type?></td>*/?>
							<td>
								<a href="floor_type_goods_manage.php?id=<?=$id?>">商品管理</a>|
								<a href="javascript:void(0);" onclick="delete_floor_type(<?php echo $id;?>)">删除</a>
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
						<?php echo showPage("check_goods.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>	
		</div>
	</body>
</html>