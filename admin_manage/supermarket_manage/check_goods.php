<?php
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	$role=$_SESSION['role'];
	$shop_id=$_SESSION['shop_id'];
	$mall_id=$_SESSION['mall_id'];
	$area="";
	if($role==2){
		$area=" where mall_id='$mall_id' ";
	}else if($role==3){
		$area=" where shop_id='$shop_id' ";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>超市管理</title>
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
						<li><a href="#">超市管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：超市管理 －&gt; <strong>查看商品</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="5%">商品序号</td>
							<td width="10%">名称</td>
							<td width="10%">价格</td>
							<td width="10%">分类1</td>
							<td width="10%">分类2</td>
							<td width="10%">分类3</td>
							<td width="10%">所属商户</td>
							<td width="10%">所属商场</td>
							<td width="10%">操作</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from super_goods".$area;
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
							$sql1="select * from super_goods".$area." order by id desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$name=$row1['name'];
								$type1=$row1['type1'];
								$type2=$row1['type2'];
								$type3=$row1["type3"];
								$shop_id=$row1['shop_id'];
								//一级分类
								$sql2="select name from super_goods_type1 where id='$type1'";
								$result2=mysql_query($sql2);
								$row2=mysql_fetch_array($result2);
								$type1_name=$row2['name'];
								//二级分类
								$sql3="select name from super_goods_type2 where id='$type2'";
								$result3=mysql_query($sql3);
								$row3=mysql_fetch_array($result3);
								$type2_name=$row3['name'];
								//三级分类
								$sql5="select name from super_goods_type3 where id='$type3'";
								$result5=mysql_query($sql5);
								$row5=mysql_fetch_array($result5);
								$type3_name=$row5["name"];
								if($shop_id==0){
									$shop_name="葵花自营";
									$mall_name="葵花自营";
								}else{
									$sql4="select * from shop where id='$shop_id'";
									$result4=mysql_query($sql4);
									$row4=mysql_fetch_array($result4);
									$shop_name=$row4['name'];
									$mall_name=$row4['mall_name'];							
								}
								$detail_address=$row1['image_url'];
								$price=$row1['price'];	
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $name?></td>
							<td><?php echo $price?></td>
							<td><?php echo $type1_name?></td>
							<td><?php echo $type2_name?></td>
							<td><?php echo $type3_name?></td>
							<td><?php echo $shop_name?></td>
							<td><?php echo $mall_name?></td>
							<td>
								<!--<a href="../homepage_manage/recommend.php?goods_id=<?=$id?>">推荐到首页</a>|-->
								<a href="edit_goods.php?goods_id=<?=$id?>&from=goods">修改商品</a>|
								<a href="javascript:void(0);" onclick="delete_goods(<?=$id?>)">删除</a>
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
<script>
	function delete_goods(goods_id){
		if(confirm("确认删除吗")){
			$.post("delete_goods_do.php",
				{
					goods_id:goods_id
				},
				function(data,status){
					if(data==1){
						alert("删除成功!");
						location.reload();
					}else{
						alert("删除失败");
					}
				}
			);
		}
	}
</script>