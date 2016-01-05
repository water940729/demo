<?php 
	require_once("../../conn/conn.php");
	require_once('../inc_function.php');
	$shop_id=$_GET['shop_id'];
	$mall_id=$_GET['mall_id'];
	$shop_name=$_GET['shop_name'];
	$from=$_GET['from'];
	if($from=='shop'){
		$url='check_shop.php';
	}else if($from=='mall'){
		$url="../mall_manage/check_mall_shop.php?mall_id=$mall_id";
	}
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
						<li><a href="#">MallManage </a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Psoition:MallManage －&gt; <?php if($from=='mall'){ echo "CheckMall"; } ?>－&gt; CheckShop－&gt; <strong>CheckGoods</strong></span>
				</div>
				<div class="content">
					<p><h2>CurrentBusiness:<?=$shop_name?></h2><p><br>
					<table width="100%">
						<tr class="t1">
							<td width="5%">GoodsNo.</td>
							<td width="10%">Name</td>
							<td width="10%">Price</td>
							<td width="10%">Sort1</td>
							<td width="10%">Sort2</td>
							<td width="10%">Shop</td>
							<td width="10%">Mall</td>
							<td width="10%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from goods where shop_id='$shop_id'";
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
							$sql1="select * from goods where shop_id='$shop_id' order by id desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$name=$row1['name'];
								$type1=$row1['type1'];
								$type2=$row1['type2'];
								$shop_id=$row1['shop_id'];
								$sql2="select name from goods_type1 where id='$type1'";
								$result2=mysql_query($sql2);
								$row2=mysql_fetch_array($result2);
								$type1_name=$row2['name'];
								
								$sql3="select name from goods_type2 where id='$type2'";
								$result3=mysql_query($sql3);
								$row3=mysql_fetch_array($result3);
								$type2_name=$row3['name'];
								
								$sql4="select * from shop where id='$shop_id'";
								$result4=mysql_query($sql4);
								$row4=mysql_fetch_array($result4);
								$shop_name=$row4['name'];
								$mall_name=$row4['mall_name'];
								$detail_address=$row1['image_url'];
								$price=$row1['price'];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $name?></td>
							<td><?php echo $price?></td>
							<td><?php echo $type1_name?></td>
							<td><?php echo $type2_name?></td>
							<td><?php echo $shop_name?></td>
							<td><?php echo $mall_name?></td>
							<td>
								<a href="../goods_manage/edit_goods.php?goods_id=<?=$id?>&shop_id=<?=$shop_id?>&shop_name=<?=$shop_name?>&from=shop">ModifyGoods</a>|
								<a href="javascript:void(0);" onclick="delete_goods(<?=$id?>)">Delete</a>
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
						<?php echo showPage("../goods_manage/check_goods.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
					<br>
					<a href="<?=$url?>">Back to check shops</a>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
	function delete_goods(goods_id){
		if(confirm("Comfirm to delete?")){
			$.post("../goods_manage/delete_goods_do.php",
				{
					goods_id:goods_id
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