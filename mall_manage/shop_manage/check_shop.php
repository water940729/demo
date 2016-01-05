<?php
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
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
		<div class="tit1">
					<ul>				
						<li><a href="#">CheckShop</a></li>
					</ul>		
				</div>		
			<div class="listintor">
				<div class="header1">
					<span>Position:ShopManage －&gt; <strong>CheckShop</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="10%">ShopNo.</td>
							<td width="10%">ShopName</td>
							<td width="10%">Mall</td>
							<td width="10%">Details</td>
							<td width="15%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from shop";
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
							
							$sql1="select * from shop order by id desc limit ".$pagestart.",".$pagesize;
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
							<?php
								if($role<3){
									echo "<a href='../goods_manage/add_goods.php?shop_id={$id}'>AddGoods</a>|";
								}
							?>
								<a href="check_shop_goods.php?shop_id=<?=$id?>&shop_name=<?=$name?>&from=shop">CheckGoods</a>|
								<a href="edit_shop.php?shop_id=<?=$id?>">ModifyShop</a>|
								<a href="javascript:void(0);" onclick="delete_shop(<?=$id?>,'<?=$name?>')">DeleteShop</a>
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
						<?php echo showPage("check_shop.php",$page,$pagecount,"../images");?>
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
	function delete_shop(shop_id,shop_name){
		if(confirm("Goods of the shop will be removed while the shop is removed,confirm to delete the shop:"+shop_name+"?")){
			$.post("delete_shop_do.php",
				{
					shop_id:shop_id
				},
				function(data,status){
					if(data==1){
						alert("Delete success!");
						location.reload();
					}else{
						alert("Delete failed");
					}
				}
			);
		}
	}
</script>