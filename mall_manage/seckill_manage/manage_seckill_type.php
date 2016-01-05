<?php
	require("../../conn/conn.php");
	$type_id=$_GET["id"];
	$type_name=$_GET["name"];
	$area="where type_id=".$type_id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>HomepageManage</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
		<script>
			//删除楼层
			function delete_seckill_type(id){
				if(confirm("Confirm to delete?")){
					$.ajax({
						type:"POST",
						url:"delete_seckill_goods.php",
						data:"id="+id,
						success:function(msg){
							alert(msg);
							location.reload();
						}
					});
				}
			}
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">SeckillManage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>position:SeckillManage －&gt; <strong>SeckillManage</strong></span>
				</div>
				<div class="content">
					<a href="add_seckill_goods.php?type_id=<?php echo $type_id;?>">AddSeckillGoods</a>
					<table width="100%">
						<tr class="t1">
							<td width="5%">SortNo.</td>
							<td width="10%">GoodsName</td>
							<td width="10%">MallNo.</td>
							<td width="10%">ShopNo.</td>
							<td width="10%">Price</td>
							<td width="10%">StartTime</td>
							<td width="10%">EndTime</td>
							<td width="10%">Amount</td>
							<td width="10%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from seckill_goods ".$area;
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
							$sql1="select * from seckill_goods ".$area." order by id desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$type_id=$row1["type_id"];
								$goodsname=$row1["goodsname"];
								$mall=$row1["mall"];
								$shop=$row1["shop"];
								$price=$row1["price"];
								$start=$row1["start"];
								$end=$row1["end"];
								$num=$row1["num"];
						?>
						<tr>
							<td><?php echo $type_id?></td>
							<td><?php echo $goodsname?></td>
							<td><?php echo $mall?></td>
							<td><?php echo $shop?></td>
							<td><?php echo $price?></td>
							<td><?php echo date("Y-m-d H:i:s",$start)?></td>
							<td><?php echo date("Y-m-d H:i:s",$end)?></td>
							<td><?php echo $num?></td>
							<td>
								<a href="javascript:void(0);" onclick="delete_seckill_type(<?php echo $id;?>)">Delete</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>No such information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current:<?php echo $page;?>/<?php echo $pagecount;?>Page EveryPage <?php echo $pagesize?> Items</div>
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