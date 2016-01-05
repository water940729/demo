<?php
	require_once("../../conn/conn.php");
	require_once("../inc_function.php");
	$mallId = $_SESSION['mall_id'];
	
	if(isset($_GET['cat'])){
	$cat = $_GET['cat'];
   }else{
	$cat = 0;
    }
    $tableNameArr = array('Mall','GroupPurchase','Seckill','Try','Presell');
	$tableArr = array('orderlist','teambuy_orderlist','seckill_orderlist','trial_orderlist','book_orderlist');
	
	$result=mysql_query("select id,name from shop where mall_id=".$mallId) or die("Database Error");
	$shopLocation[0]=$_SESSION['mall_name'];
	 while($array=mysql_fetch_array($result)){
		  $shopLocation[$array['id']]=$array['name'];
	 }
	$shopLocation[0]='Self-support';
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
					<li><a href="#">SortedByMall</a></li>
					<!--
					<li class="l1" ><a href="sum_order_shop.php" target="mainFrame">按商铺分类</a></li>
					<li class="l1" ><a href="sum_order_good.php" target="mainFrame">按商品分类</a></li>
					-->
					</ul>		
				</div>
				<div class="listintor">

				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:OrderManage －&gt;<strong>GoodsList----<?php echo $tableNameArr[$cat]; ?></strong></span>
				   <!-- <span style='font-size:16px;'><a href='./sum_order.php?cat=0'>-----------------商城</a ></span><span style='font-size:16px;'><a href='./sum_order.php?cat=1' >---团购</a></span><span style='font-size:16px;' ><a href='./sum_order.php?cat=2' >---秒杀</a></span> -->

				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="15%">MallNo.</td>
								<td width="40%">StatisticalInformation</td>
								<td width="10%">Operation</td>	
							</tr>
<?php
/*
$pagesize=20;
$select="select count(*) as page_count from mall";
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
$query="select id from mall limit ".$pagestart.",".$pagesize;
$res=mysql_query($query);
$tableName = 'orderlist';
*/
$tableName = $tableArr[$cat];
$sql = "SELECT count(id) as sum , shop_id , ordstatus  FROM  `$tableName`  where mall_id = $mallId group by ordstatus,shop_id ORDER BY shop_id ";
$res = mysql_query($sql);
while($row = mysql_fetch_assoc($res)){
	$data[$row['shop_id']][$row['ordstatus']] = $row['sum'];
}
foreach($shopLocation as $key=>$val){
	
?>
							<tr>
								<td><?php echo $val;?></td>   
								<td width='80%'><a href="./orderManage.php?shopId=<?php echo $key; ?>&type=0&cat=<?php echo $cat;?>">Ordered:
									<?php
										echo isset($data[$key][0])?$data[$key][0]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=1&cat=<?php echo $cat;?>">Paied:
									<?php
										echo isset($data[$key][1])?$data[$key][1]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=2&cat=<?php echo $cat;?>">Devilered:
									<?php
										echo isset($data[$key][2])?$data[$key][2]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=3&cat=<?php echo $cat;?>">Taken:
									<?php
										echo isset($data[$key][3])?$data[$key][3]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=4&cat=<?php echo $cat;?>">Changing:
									<?php
										echo isset($data[$key][4])?$data[$key][4]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=5&cat=<?php echo $cat;?>">Changed:
									<?php
										echo isset($data[$key][5])?$data[$key][5]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=6&cat=<?php echo $cat;?>">Returning:
									<?php
										echo isset($data[$key][6])?$data[$key][6]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=7&cat=<?php echo $cat;?>">Returned:
									<?php
										echo isset($data[$key][7])?$data[$key][7]:0;
								    ?>pieces</a>&nbsp;|&nbsp;<a href="./orderManage.php?shopId=<?php echo $key; ?>&type=8&cat=<?php echo $cat;?>">Evalueated:
									<?php
										echo isset($data[$key][8])?$data[$key][8]:0;
								    ?>pieces</a>
								</td>
								<td>
								     <a href="./orderManage.php?shopId=<?php echo $key; ?>&cat=<?php echo $cat;?>">Check</a>
								</td>
								</tr>
							<?php }?>
						</table>
					</form>

				</div>
			</div>
		</div>
	</body>
</html>