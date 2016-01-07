<?php 
	session_start();
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
				<div class="menu_h menu_h3">Merchant Information</div>
				<div class="menu_intor">
					<p><a href="info_manage/info.php" target="mainFrame">Merchant Information</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Posts Management</div>
				<div class="menu_intor">
					<p><a href="articles/list.php" target="mainFrame">Posts</a></p>
			   </div>
			</div>				
			<div class="menu_content">
				<div class="menu_h menu_h3">Shop Management</div>
				<div class="menu_intor">
					<p><a href="homepage_manage/add_focus.php" target="mainFrame">Add Focus Picture</a></p>
					<p><a href="homepage_manage/manage_focus.php" target="mainFrame">Focus Picture Management</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Goods Management</div>
				<div class="menu_intor">
					<p><a href="goods_manage/add_goods.php" target="mainFrame">Add Goods</a></p>
					<p><a href="goods_manage/check_goods.php" target="mainFrame">List Goods</a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Order Management</div>
				<div class="menu_intor">
				<p><a href="order_manage/orderManage.php?cat=0" target="mainFrame">All Orders</a></p>
				<!--<p><a href="order_manage/orderManage.php?cat=1" target="mainFrame">Bulk order</a></p>
				<p><a href="order_manage/orderManage.php?cat=2" target="mainFrame">Seconds kill order</a></p>
				<p><a href="order_manage/orderManage.php?cat=3" target="mainFrame">Trial order</a></p>
				<p><a href="order_manage/orderManage.php?cat=4" target="mainFrame">Booking order</a></p>-->
				</div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Account Management </div>
				<div class="menu_intor">
					<p><a href="add_manage_account/edit_manage_account.php" target="mainFrame">Change Password </a></p>
			   </div>
			</div>
			<div class="menu_content">
				<div class="menu_h menu_h3">Financial Management</div>
				<div class="menu_intor">
					<!--<p><a href="financeManage/finance.php" target="mainFrame">Withdrawal processing</a></p>-->
					<p><a href="financeManage/finance_status.php" target="mainFrame">Financial Status</a></p>
			   </div>
			</div>
		</div>
	</body>
</html>