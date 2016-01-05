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
						<li><a href="#">订单管理</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：订单管理 －&gt;<strong>查看订单</strong></span>
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
								$select="select count(id) as page_count from orderlist";
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
								$query="select id,userid,mall_id,shop_id,productid,ordbuynum,ordprice,username,recname,recaddress,recphone,ordstatus,ordtime from orderlist order by id desc limit ".$pagestart.",".$pagesize;									
								$res=mysql_query($query);
								
								while($row=mysql_fetch_array($res)){
							?>
							<tr id="<?php echo $row["id"];?>">		 
								<td><?php echo $row["id"] ?></td>
								<td><?php echo $row["userid"] ?></td>
								<td><?php echo $row["mall_id"] ?></td>
								<td><?php echo $row["shop_id"] ?></td>
								<td><?php echo $row["productid"] ?></td>
								<td><?php echo $row["ordbuynum"] ?></td>
								<td><?php echo $row["ordprice"] ?></td>								
								<td><?php echo $row["username"] ?></td>
								<td><?php echo $row["recname"] ?></td>
								<td><?php echo $row["recaddress"] ?></td>
								<td><?php echo $row["recphone"] ?></td>
								<td>
							<?php
								switch($row["ordstatus"]){
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
								<td><?php echo $row["ordtime"] ?></td> 
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