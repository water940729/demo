<?php
	require_once("../../conn/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li class="l1"><a href="sum_order.php" target="mainFrame">SortedByMall</a></li>
						<li><a href="#" target="mainFrame">SortedByShop</a></li>
						<li class="l1"><a href="sum_order_good.php" target="mainFrame">SortedByGoods</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:OrderManage －&gt;<strong>GoodsList</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="15%">ShopNo.</td>
								<td width="40%">StatisticalInformation</td>
								<td width="10%">Operation</td>	
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
$query="select id from shop limit ".$pagestart.",".$pagesize;
$res=mysql_query($query);
while($row=mysql_fetch_array($res)){
     $shop_id=$row['id'];
	 $query1="select count(order_id) as total from seckill_orderlist where shop_id=$shop_id and state=0";
     $res1=mysql_query($query1);
	 $row1=mysql_fetch_array($res1);
	 $query1="select count(order_id) as total from seckill_orderlist where shop_id=$shop_id and state=1";
     $res2=mysql_query($query1);
	 $row2=mysql_fetch_array($res2);
	 $query1="select count(order_id) as total from seckill_orderlist where shop_id=$shop_id and state=2";
     $res3=mysql_query($query1);
	 $row3=mysql_fetch_array($res3);
	 $query1="select count(order_id) as total from seckill_orderlist where shop_id=$shop_id and state=3";
     $res4=mysql_query($query1);
	 $row4=mysql_fetch_array($res4);
?>
							<tr>
								<td><?php echo $shop_id;?></td>   
								<td><a href="order_list_stats.php?state=0&type=shop&id=<?php echo $shop_id; ?>">NotPaied:
									<?php
										echo $row1["total"]?$row1["total"]:0;
								    ?>pieces </a>&nbsp;|&nbsp;<a href="order_list_stats.php?state=1&type=shop&id=<?php echo $shop_id; ?>">Paied:
									<?php
										echo $row2["total"]?$row2["total"]:0;
								    ?>pieces </a>&nbsp;|&nbsp;<a href="order_list_stats.php?state=2&type=shop&id=<?php echo $shop_id; ?>">Delivered:
									<?php
										echo $row3["total"]?$row3["total"]:0;
								    ?>pieces </a>&nbsp;|&nbsp;<a href="order_list_stats.php?state=3&type=shop&id=<?php echo $shop_id; ?>">Checked:
									<?php
										echo $row4["total"]?$row4["total"]:0;
								    ?>pieces </a>
								</td>
								<td>
								     <a href="order_list_stats.php?type=shop&id=<?php echo $shop_id; ?>">CheckAllOrder</a>
								</td>
								</tr>
							<?php }?>
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>No such information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current:<?php echo $page;?>/<?php echo $pagecount;?>Page EveryPage <?php echo $pagesize?> Items</div>
						<div class="pageafter">
						<?php echo showPage('order_stats.php',$page,$pagecount);?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>
