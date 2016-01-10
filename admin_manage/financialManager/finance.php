<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		
					 
		
	</head>
<style>
.mytable
{
   width:1200px;
   border:1px;  
}
table,th,td{ 
 border : 1px solid black;
}
table td{
    text-align:center;
}
td{
  padding:10px;
}

.myUl
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
ul
{
list-style-type: none;
line-height : 50px;
padding: 0px;
margin: 0px;
}
.adAdLocationUl{
	list-style-type: none;
	line-height : 50px;
	padding: 0px;
	margin: 0px;
	background-color:#F5FFFA;
}
.adAdLocationUl>li{
	text-align:center;
	width:300px;
}
.controllDiv{
	width:1200px;
	height:40px;
	float:left;
}
.controllDiv span{
   float:left;
   margin-left:10px;
   background-color:#ffc0cb;
   padding:5px 5px 5px 5px;
   cursor:pointer;
}
.pageConDiv span{
	width:20px;
	text-align:center;
}
.pageConDiv div{
	float:left;
	margin-left:10px;
    background-color:#ffc0cb;
    padding:5px 5px 5px 5px;
	cursor:pointer;
	
}
</style>

<body>
	<?php
		
	 include ("../../conn/conn.php");
	 
	 if($_SESSION['role'] == 1){
		$shopPage = isset($_GET['shopPage'])?$_GET['shopPage']:0;
		$sql = 'select balanceMoney,useMoney from system_info ';
		$result=mysql_query($sql) or die(mysql_error());
		$siteMoney = mysql_fetch_array($result);
	}else if($_SESSION['role'] == 2){
		$shopPage = $_SESSION['mall_id'];	
	}
	// 总体数组
	$total_result = array();
	$i = 0;
	// 总收入
	$total_income = 0;
	// 店铺名数组
	$res = mysql_query("select id,name from shop");
	while($shop_owners = mysql_fetch_array($res)){
		// 获取佣金比率
		$r = mysql_fetch_row(mysql_query("select ratio from shop where id=".$shop_owners['id']))[0];
		// 查找已退货订单数
		$rd = mysql_query("select count(*) from orderlist where shop_id=".$shop_owners['id']." and ordstatus=5");
		$rd = mysql_fetch_row($rd)[0];
		// 对每一个shop_owner查找总订单数
		$t0 = mysql_query("select count(*) from orderlist where shop_id=".$shop_owners['id']);
		$t_o = mysql_fetch_row($t0)[0];
		// 对每一个shop_owner查找所有产生收入的订单数以及总收入额
		$t = mysql_query("select sum(ordfee) from orderlist where shop_id=".$shop_owners['id']." and ordstatus in (1,2,3,4,6)");
		// 查询结果只可能有一行，直接获取即可
		$rr = mysql_fetch_row($t);
		// 最初收入（没有扣去佣金）
		$cc = $rr[0];
		// 实际商家收入（扣去佣金后）
		$c = $cc * (1 - $r/100);
		// 创建内部数组表示每一个商家对应的名字、佣金比率以及总和
		$a = array("name"=>$shop_owners[1],"ratio"=>$r,"commission"=>$c,"total"=>$cc,"total_ordnum"=>$t_o,"returned_ordnum"=>$rd);
		$total_result[$i] = $a;
		$i += 1;
		$total_income += $c;
	}
	?>



		<div class="bgintor" style='height:800px'>				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li style='text-align:center'>Statistic</li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location：Finance Statistic</span>	
				</div>
				<div class="content" style='height:1000px'>
				<table class='mytable' width="100%" style="float:left;" id='orderTable'>

				<tr style='background-color:white;'><td colspan=4 style='font-size:16px;'>Total Inconme：<?php  echo $total_income?>￥</td></tr>
				<tr style='background-color:#B0E0E6;'>
					<td> Shop Owner</td>
					<td>Commission Ratio(%)</td>
					<td>Commission(￥)</td>
					<td>Total Income(￥)</td>
					<td>Total Order Count</td>
					<td>Returned Order Count</td>
				</tr>
				   
				<?php
				   foreach($total_result as $result){
					   echo "<tr><td>".$result['name']."</td><td>".(100 - $result['ratio'])."</td><td>".$result['commission']."</td><td>".$result['total']."</td><td>".$result['total_ordnum']."</td><td>".$result['returned_ordnum']."</td></tr>";
				   }
				
				?>
			
				</table>
	
			</div>	
		
		</div>
		</div>
	</body>
	
<script type="text/javascript">

</script>

</html>