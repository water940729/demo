<?php 
	//session_start();
	//$role=$_SESSION['role'];
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
	
	$(".menu_content").hover(function(){
		$(this).find(".menu_h3").addClass("spec");
	},function(){
		$(this).find(".menu_h3").removeClass("spec");
	})
	
	$(".menu_intor").find("p").hover(function(){
		$(this).find("a").css("color","orange");
	},function(){
		$(this).find("a").css("color","#353535");
	})
	
  })
  </script>
 </head>	
	<body id="flow">
		<div class="menu" id="me">
			<div class="menu_content">
				<div class="menu_h menu_h3">Basic Information</div>
				<div class="menu_intor">
					<p><a href="info_manage/info.php" target="mainFrame">Basic Information</a></p>
			   </div>
			</div>		
			<div class="menu_content">
				<div class="menu_h menu_h3">Store Manage</div>
				<div class="menu_intor">
					<p><a href="shop_manage/add_shop.php" target="mainFrame">AddStore</a></p>
					<p><a href="shop_manage/check_shop.php" target="mainFrame">CheckStore</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">GoodsManage</div>
				<div class="menu_intor">
					<p><a href="goods_manage/add_goods.php" target="mainFrame">AddGoods</a></p>
					<p><a href="goods_manage/check_goods.php" target="mainFrame">ChekGoods</a></p>
					<p><a href="goods_manage/goods_type1.php" target="mainFrame">GoodsSort</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">OrderManage</div>
				<div class="menu_intor">
				<p><a href="order_manage/sum_order.php?cat=0" target="mainFrame">MallOrders</a></p>
				<p><a href="order_manage/sum_order.php?cat=1" target="mainFrame">GroupOrders</a></p>
				<p><a href="order_manage/sum_order.php?cat=2" target="mainFrame">SeckillOrders</a></p>
				<p><a href="order_manage/sum_order.php?cat=3" target="mainFrame">TryOrders</a></p>
				<p><a href="order_manage/sum_order.php?cat=4" target="mainFrame">PresellOrders</a></p>
				</div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">ArticlesManage</div>
				<div class="menu_intor">
					<p><a href="articles/list.php" target="mainFrame">ArticleList</a></p>
			   </div>
			</div>			
			<div class="menu_content">
				<div class="menu_h menu_h3">AccountManage</div>
				<div class="menu_intor">
					<p><a href="add_manage_account/add_manage_account.php" target="mainFrame">AddAccounts</a></p>
					<p><a href="add_manage_account/manage_account.php" target="mainFrame">CheckAccounts</a></p>
					<p><a href="add_manage_account/edit_manage_account.php" target="mainFrame">ModifyPassword</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">HomepageManage</div>
				<div class="menu_intor">
					<p><a href="homepage_manage/add_focus.php" target="mainFrame">AddFocusPicture</a></p>
					<p><a href="homepage_manage/manage_focus.php" target="mainFrame">FocusPictureManage</a></p>
					<p><a href="homepage_manage/keyword_manage.php" target="mainFrame">KeywordsManage</a></p>
					<p><a href="homepage_manage/add_keyword.php" target="mainFrame">AddKeywords</a></p>
					<p><a href="homepage_manage/recommend.php" target="mainFrame">RecommendManage</a></p>
					<p><a href="homepage_manage/floor_manage.php" target="mainFrame">FloorManage</a></p>
					<p><a href="homepage_manage/add_floor.php" target="mainFrame">AddFloor</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">AdManage</div>
				<div class="menu_intor">
					<p><a href="ad_manage/adManage.php" target="mainFrame">AdManageOnline</a></p>
					<!--<p><a href="ad_manage/ad_order.php" target="mainFrame">广告出售订单</a></p>-->
			   </div>
			</div>
            <div class="menu_content">
				<div class="menu_h menu_h3">FinanceManage</div>
				<div class="menu_intor">
					<p><a href="financeManage/finance.php" target="mainFrame">MonetManage</a></p>
					<p><a href="financeManage/financeManage.php" target="mainFrame">WithdrawManage</a></p>
					<!--<p><a href="ad_manage/ad_order.php" target="mainFrame">广告出售订单</a></p>-->
			   </div>
			</div>
		</div>
	</body>
</html>