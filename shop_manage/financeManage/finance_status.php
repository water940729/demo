

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!--link rel="stylesheet" href="../css/style2.css" type="text/css" /-->
	<style type="text/css">
	
	body{
	font-family:"microsoft yahei";
	font-size:12px;
}
img{
	border:0;
}
a{
	text-decoration:none;
}
#flow{
	overflow-x:hidden;
}
.clear{
	clear:both;
}

.listintor{
	margin:15px 11px 0 6px;
}
.listintor table{
	border:1px solid #C9C9C9;
	border-collapse:collapse;
	margin-bottom:28px;
}
.listintor table tr{
	height:22px;
}
.listintor table tr td{
	border:1px solid #C9C9C9;
	text-align:center;
}
.listintor table tr td.td1{
	text-align:left;
	padding-left:10px;
}
.listintor table tr.t1{
	background-color:#FF7EAC;
	color:white;
}
		.x1{
			color:red;
			font-size:120%
		}
		
.mytable
{
   width:1000px;
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
	</head>
	<body>
		<?php
		// 处理卖家资金统计的后台流程
		// by liuyicheng
		include ("../../conn/conn.php");
		if($_SESSION['role'] != 3){
	  		exit();
		}
		if(isset($_SESSION['shop_id'])){
			$shopId = $_SESSION['shop_id'];
		}else{
			exit();
		}
		// 获取此商家给商场的收入率
		$sql = 'select ratio from shop where id='.$shopId;
		$ratio = mysql_fetch_row(mysql_query($sql))[0];
		// 此商家卖出的所有不同种类的商品
		$res = mysql_query('select distinct productid from orderlist where shop_id='.$shopId);
		$products = array();
		$i = 0;
		while($t = mysql_fetch_row($res)){
			// $t[0]是当前商品id，根据此ID获取商品在订单表中总数
			$m = mysql_fetch_row(mysql_query('select ordbuynum from orderlist where productid='.$t[0].' and shop_id='.$shopId.' and ordstatus=5'));
			$n = mysql_fetch_row(mysql_query('select ordbuynum,sum(ordfee) from orderlist where productid='.$t[0].' and shop_id='.$shopId.' and ordstatus in (1,2,3,4,6)'));
			$g = mysql_fetch_row(mysql_query('select name,price from goods where id='.$t[0]));
			$p = mysql_fetch_row(mysql_query('select pic_url from goods_pictures where goods_id='.$t[0]));
			// 构造临时数组存这玩意
			// 商品号、商品总卖出数量、商品总收入、商品名称、商品价格、商品图片
			$ta = array("name"=>$g[0],"pic"=>$p[0],"price"=>$g[1],"total_sold_out_count"=>$n[0]==null?0:$n[0],"total_returned_count"=>$m[0]==null?0:$m[0],"total_income"=>$n[1]==null?0:$n[1],"actual_income"=>$n[1]*($ratio/100));
			$products[$i] = $ta;
			$i += 1;
		}
		// 此商家卖出的所有商品总数
		$sql = 'select count(*) from orderlist where shop_id='.$shopId.' and ordstatus in (1,2,3,4,6)';
		$good_num = mysql_fetch_row(mysql_query($sql))[0];
		// 获取与此商家关联的所有订单收入总额并减去给商场的钱，即此商家的所有收入
		$sql = 'select sum(ordfee) from orderlist where shop_id='.$shopId.' and ordstatus in (1,2,3,4,6)';
		$real_earning = mysql_fetch_row(mysql_query($sql))[0] * ($ratio/100);
		
		?>
		<div class="listintor">
		<p class='x1'>The commission rate is <?php echo $ratio;?>, </p>
		<p class='x1'>The number of all products sold is <?php echo $good_num;?>, </p>
		<p class='x1'>The whole income is  <?php echo $real_earning;?></p>
		<table class='mytable' width="100%" style="float:left;" id='orderTable'>
		<tr class="t1" id="adTableLine">
		<td>Product Name</td>
		<td>Product Picture</td>
		<td>Product Price(￥)</td>
		<td>Total Sold-out Count</td>
		<td>Total Returned Count</td>
		<td>Total Income(￥)</td>
		<td>Actual Income(￥)</td>
		</tr>
		<?php
			
			echo $products[$i][pic];
			$c_pro=count($products);
		
			for($i=0;$i<$c_pro;$i++)
			{
				$profit_shop=$products[$i][total]*0.8;
				$profit_mall=$products[$i][total]*0.2;
				 echo '<tr><td>'.$products[$i][name].'</td><td><img src="'.$products[$i][pic].'" height="50" width="50"></td><td>'.$products[$i][price].'</td><td>'.$products[$i][total_sold_out_count].'</td><td>'.$products[$i][total_returned_count].'</td><td>'.$products[$i][total_income].'</td><td>'.$products[$i][actual_income].'</td></tr>';
			}
			?>
		</table>
		</div>
	</body>
</html>