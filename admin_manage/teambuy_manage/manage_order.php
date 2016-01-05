<?php
	require_once("../../conn/conn.php");
	require_once("../inc_function.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
		$(function(){
			$(".delete").click(function(){
				if(confirm("确认删除")){
					var id=$(this).parents("tr").attr("id");
					$.post("delete_order.php",{id:id},function(data){
						if(data==1){
							alert("删除成功");
							location.reload();
						}else{
							alert("未知错误，请稍后再试");
						}
					})
				}
			});
		});
		</script>
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">团购管理</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：团购管理 －&gt;<strong>查看订单</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="5%">订单编号</td>
								<td width="5%">客户编号</td>
								<td width="5%">商城编号</td>
								<td width="5%">商家编号</td>
								<td width="5%">商品编号</td>
								<td width="5%">数量</td>
								<td width="5%">总价</td>
								<td width="5%">客户名</td>								
							    <td width="5%">收件人</td>							
							    <td width="5%">地址</td>
								<td width="5%">联系方式</td>
								<td width="5%">状态</td>
							    <td width="5%">订单时间</td>
								<td width="5%">操作</td>
							</tr>
							<?php
								$pagesize=20;							
								$select="select count(order_id) as page_count from teambuy_orderlist";
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
								switch($_SESSION["role"]){
									case 1:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from teambuy_orderlist order by order_id desc limit ".$pagestart.",".$pagesize;									
										break;
									case 2:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from teambuy_orderlist where mall_id=$_SESSION[mall_id] order by order_id desc limit ".$pagestart.",".$pagesize;									
										break;
									case 3:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from teambuy_orderlist where shop_id=$_SESSION[shop_id] order by order_id desc limit ".$pagestart.",".$pagesize;									
										break;
									case 4:
										$query="select order_id,user_id,mall_id,shop_id,good_id,num,price,username,rec_name,address,phone,state,time from teambuy_orderlist where user_id=$_SESSION[id] order by order_id desc limit ".$pagestart.",".$pagesize;								
										break;									
								}
								$res=mysql_query($query);
								while($row=mysql_fetch_array($res)){
							?>
							<tr id="<?php echo $row["order_id"];?>">		 
								<td><?php echo $row["order_id"] ?></td>
								<td><?php echo $row["user_id"] ?></td>
								<td><?php echo $row["mall_id"] ?></td>
								<td><?php echo $row["shop_id"] ?></td>
								<td><?php echo $row["good_id"] ?></td>
								<td><?php echo $row["num"] ?></td>
								<td><?php echo $row["price"] ?></td>								
								<td><?php echo $row["username"] ?></td>
								<td><?php echo $row["rec_name"] ?></td>
								<td><?php echo $row["address"] ?></td>
								<td><?php echo $row["phone"] ?></td>
								<td>
							<?php
								switch($row["state"]){
									case 0:
										echo "未付款";
										break;
									case 1:
										echo "已付款，待收货";
										break;
									case 2:
										echo "已收货";
										break;
									case 3:
										echo "待确认";
										break;
								}
							?>
								</td> 
								<td><?php echo $row["time"] ?></td> 
							<?php/*
								if($_SESSION["role"]==1){
									echo'<td><a href="#" target="mainFrame" class="delete">删除</a></td>';
								}
								*/
							?>
							</tr>
							<?php }?>
						
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>没有相关信息！</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">当前页:<?php echo $page;?>/<?php echo $pagecount;?>页 每页 <?php echo $pagesize?> 条</div>
						<div class="pageafter">
						<?php echo showPage("search_order.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>