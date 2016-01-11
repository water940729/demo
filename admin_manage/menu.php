<?php 
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> Menu </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Jiangting@WiiPu -- http://www.wiipu.com" />
  <link rel="stylesheet" href="css/style2.css" type="text/css"/>
  <style>
  .menu_h3{cursor:pointer;}
  </style>
  <script src="js/jquery-1.6.min.js">
  </script>
  <script>
  $(function(){
	$(".menu_intor").hide();
	$(".menu_h3").click(function(){
		if($(this).siblings(".menu_intor").is(":hidden")){
			$(this).siblings(".menu_intor").show();
		}else{
			$(this).siblings(".menu_intor").hide();
		}
		
	})
  })
  </script>
 </head>	
	<body id="flow">
		<div class="menu" id="me">
			<!--
			<div class="menu_content">
				<div class="menu_h menu_h3">Marketing</div>
				<div class="menu_intor">
					<p><a href="mall_manage/add_mall.php" target="mainFrame">Add Marketing</a></p>
					<p><a href="mall_manage/check_mall.php" target="mainFrame">View Marketing</a></p>
				</div>
			</div>
			-->
			<div class="menu_content">
				<div class="menu_h menu_h3">Store</div>
				<div class="menu_intor">
					<p><a href="shop_manage/add_shop.php" target="mainFrame">Add Store</a></p>
					<p><a href="shop_manage/check_shop.php" target="mainFrame">View Store</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Goods</div>
				<div class="menu_intor">
					<p><a href="goods_manage/add_goods.php" target="mainFrame">Add Goods</a></p>
					<p><a href="goods_manage/check_goods.php" target="mainFrame">View Goods</a></p>
					<p><a href="goods_manage/goods_type1.php" target="mainFrame">Goods Classify</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">User</div>
				<div class="menu_intor">
				<p><a href="user_manage/search_user.php" target="mainFrame">View User</a></p>
			
				<p><a href="user_manage/search_address.php" target="mainFrame">View Address</a></p>
				
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Order</div>
				<div class="menu_intor">
				<p><a href="order_manage/orderManage.php" target="mainFrame">Order Management</a></p>
				<p><a href="order_manage/sum_order.php" target="mainFrame">Order Count</a></p>
				</div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Account Manage</div>
				<div class="menu_intor">
					<p><a href="add_manage_account/add_manage_account.php" target="mainFrame">Add Count</a></p>
					<p><a href="add_manage_account/manage_account.php" target="mainFrame">View Count</a></p>
					<!--<p><a href="add_manage_account/edit_manage_account.php" target="mainFrame">Show</a></p>-->
			   </div>
			</div>
			<!--
			<div class="menu_content">
				<div class="menu_h menu_h3">Article Management</div>
				<div class="menu_intor">
					<p><a href="articles/list.php" target="mainFrame">Article List</a></p>
			   </div>
			</div>
			-->
			<!--<div class="menu_content">
				<div class="menu_h menu_h3">System Setting</div>
				<div class="menu_intor">
					<p><a href="system_manage/system_info.php" target="mainFrame">System Info</a></p>
					<p><a href="system_manage/system_log.php" target="mainFrame">System Log</a></p>
			   </div>
			</div>-->
			<div class="menu_content">
				<div class="menu_h menu_h3">HomePage </div>
				<div class="menu_intor">
					<!--<p><a href="homepage_manage/add_focus.php" target="mainFrame">add focus</a></p>
					<p><a href="homepage_manage/manage_focus.php" target="mainFrame">focus manage</a></p>-->
					<p><a href="homepage_manage/keyword_manage.php" target="mainFrame">keywords manage</a></p>
					<p><a href="homepage_manage/add_keyword.php" target="mainFrame">add keywords</a></p>
					<p><a href="homepage_manage/recommend.php" target="mainFrame">recommend</a></p>
					<p><a href="homepage_manage/floor_manage.php" target="mainFrame">floor manage</a></p>
					<p><a href="homepage_manage/add_floor.php" target="mainFrame">add floor</a></p>
			   </div>
			</div>	
			<!--
			<div class="menu_content">
				<div class="menu_h menu_h3">supermarket</div>
				<div class="menu_intor">
					<p><a href="supermarket_manage/add_goods.php" target="mainFrame">add goods</a></p>
					<p><a href="supermarket_manage/check_goods.php" target="mainFrame">check goods</a></p>
					<p><a href="supermarket_manage/goods_type1.php" target="mainFrame">goods type</a></p>			
					<p><a href="supermarket_manage/add_focus.php" target="mainFrame">add focus</a></p>
					<p><a href="supermarket_manage/manage_focus.php" target="mainFrame">focus manage</a></p>
					<p><a href="supermarket_manage/keyword_manage.php" target="mainFrame">keywords manage</a></p>
					<p><a href="supermarket_manage/add_keyword.php" target="mainFrame">add keywords</a></p>
					<p><a href="supermarket_manage/recommend.php" target="mainFrame">hot sell</a></p>
					<p><a href="supermarket_manage/floor_manage.php" target="mainFrame">floor manage</a></p>
					<p><a href="supermarket_manage/add_floor.php" target="mainFrame">add floor</a></p>
			-->
					<!--<p><a href="supermarket_manage/manage_sales.php" target="mainFrame"></a></p>-->
			<!--		<p><a href="order_manage/orderManage.php?cat=5" target="mainFrame">order manage</a></p>
			   </div>
			</div>			
			-->
			<!--<div class="menu_content">
				<div class="menu_h menu_h3">seckill</div>
				<div class="menu_intor">
					<p><a href="seckill_manage/add_seckill.php" target="mainFrame">add item</a></p>
					<p><a href="seckill_manage/manage_seckill.php" target="mainFrame">manage</a></p>
					<p><a href="seckill_manage/manage_focus.php" target="mainFrame">focus manage</a></p>
					<p><a href="seckill_manage/add_focus.php" target="mainFrame">add focus</a></p>
					<p><a href="order_manage/sum_order.php?cat=2" target="mainFrame">order statistic</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">teambuy</div>
				<div class="menu_intor">
					<p><a href="teambuy_manage/add_teambuy.php" target="mainFrame">add item</a></p>
					<p><a href="teambuy_manage/manage_teambuy.php" target="mainFrame">manage</a></p>
					<p><a href="teambuy_manage/manage_focus.php" target="mainFrame">focus manage</a></p>
					<p><a href="teambuy_manage/add_focus.php" target="mainFrame">add focus</a></p>
					<p><a href="order_manage/sum_order.php?cat=1" target="mainFrame">order statistic</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">trail</div>
				<div class="menu_intor">
					<p><a href="trail_manage/add_trail.php" target="mainFrame">add trail</a></p>
					<p><a href="trail_manage/manage_trail.php" target="mainFrame">trail manage</a></p>
					<p><a href="trail_manage/manage_focus.php" target="mainFrame">focus manage</a></p>
					<p><a href="trail_manage/add_focus.php" target="mainFrame">add focus</a></p>
					<!--<p><a href="trail_manage/orderManage.php" target="mainFrame">order manage</a></p>-->
					 <!--<p><a href="order_manage/sum_order.php?cat=3" target="mainFrame">order statistic</a></p>
			   </div>
			</div>-->
			<!--
			<div class="menu_content">
				<div class="menu_h menu_h3">预售管理</div>
				<div class="menu_intor">
					<p><a href="book_manage/add_book.php" target="mainFrame">添加预售</a></p>
					<p><a href="book_manage/manage_book.php" target="mainFrame">预售管理</a></p>
					<p><a href="book_manage/manage_focus.php" target="mainFrame">焦点图管理</a></p>
					<p><a href="book_manage/add_focus.php" target="mainFrame">添加焦点图</a></p>
					<p><a href="order_manage/sum_order.php?cat=4" target="mainFrame">订单统计</a></p>
			   </div>
			</div>
			-->
			<div class="menu_content">
				<div class="menu_h menu_h3">ad manage</div>
				<div class="menu_intor">
					<p><a href="homepage_manage/add_focus.php" target="mainFrame">add focus</a></p>
                    					<p><a href="homepage_manage/manage_focus.php" target="mainFrame">focus manage</a></p>
					<p><a href="ad_manage/adManage.php" target="mainFrame">advertisement</a></p>
					<!--<p><a href="ad_manage/ad_order.php" target="mainFrame">广告出售订单</a></p>-->
				<!--
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">商品审核</div>
				<div class="menu_intor">
					<p><a href="admin_check/check_goods.php" target="mainFrame">商品审核</a></p>
				-->
					<!--<p><a href="ad_manage/ad_order.php" target="mainFrame">广告出售订单</a></p>-->
			   </div>
			</div>
			<!--
			<div class="menu_content">
				<div class="menu_h menu_h3">消息模板</div>
				<div class="menu_intor">
					<p><a href="msg_manage/msgManage.php" target="mainFrame">消息模板管理</a></p>
					-->
					<!--<p><a href="ad_manage/ad_order.php" target="mainFrame">广告出售订单</a></p>-->
			<!--   
			   </div>
			</div>
			-->
			<div class="menu_content">
				<div class="menu_h menu_h3">finance</div>
				<div class="menu_intor">
					<!--<p><a href="./financialManager/finanacialManage.php" target="mainFrame">deposit</a></p>-->
					<p><a href="./financialManager/finance.php" target="mainFrame">finance statistic</a></p>
					<!--<p><a href="ad_manage/ad_order.php" target="mainFrame">广告出售订单</a></p>-->
			   </div>
			</div>
			<!--<div class="menu_content">
				<div class="menu_h menu_h3">statistic</div>
				<div class="menu_intor">
					<p><a href="./statisticsManage/orderStatistic.php" target="mainFrame">order statistic</a></p>
					<p><a href="./statisticsManage/financeStatistic.php" target="mainFrame">sales statistic</a></p>
			   </div>
			</div>-->

	</body>
</html>