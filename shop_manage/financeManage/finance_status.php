

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		// 此商家卖出的所有商品总数
		$sql = 'select count(*) from orderlist where shop_id='.$shopId.' and ordstatus in (1,2,3,4)';
		$good_num = mysql_fetch_row(mysql_query($sql))[0];
		// 获取与此商家关联的所有订单收入总额并减去给商场的钱，即此商家的所有收入
		$sql = 'select sum(ordfee) from orderlist where shop_id='.$shopId.' and ordstatus in (1,2,3,4)';
		$real_earning = mysql_fetch_row(mysql_query($sql))[0] * ($ratio/100);

		echo 'The number of all products sold is '.$good_num;?><br/>
		<?php
		echo 'The whole income is '.$real_earning;
		?>
	</body>
	

</html>