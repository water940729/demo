<?php
	require("../../conn/conn.php");
	$id=$_GET["id"];//分类id
	//$sql="select * from homePageGoods where floor_type_id=$id";
	//$result=mysql_query($sql);
	$area=" where floor_type_id=$id";
	$base_url="http://".$_SERVER["HTTP_HOST"];
	$goods_url=$base_url."/good/index/id/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>首页管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<style>
		</style>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
		<script>
		$(function(){
			$("#search").click(function(){
				var keyword=$.trim($(this).prev().val());
				if(keyword==""){
					alert("关键字不能为空");
				}else{
					$.ajax({
						data:"keyword="+keyword,
						url:"search_keyword.php",
						type:"POST",
						dataType:"json",
						success:function(msg){
							/*alert(msg);
							*/
							if(msg==0){
								//没有数据时
								alert("无对应商品，请输入其他关键字");
							}else{
								//alert("000");
								$("#search_result").empty();
								var id=$("#search_result").attr("name");
								var data="<table width='100%'><tr class='t1'><td width='5%' class='id'>商品编号</td>"+
								"<td width='10%' class='name'>商品名</td>"+"<td width='10%'>商城名</td>"+"<td width='10%'>一级分类名</td>"+
								"<td width='10%'>二级分类名</td>"+"<td width='10%'>三级分类名</td>"+"<td width='10%'>操作</td></tr>";
								for(var i in msg){
									data+="<tr>";
									for(var x in msg[i]){
										if(x=="name"){
											data+="<td><a href='<?php echo $goods_url;?>"+msg[i]["id"]+"' target='_blank'>"+msg[i][x]+"</a></td>";
										}else{
											data+="<td>"+msg[i][x]+"</td>";										
										}
									}
									data+="<td><a href='floor_type_goods_add.php?id="+msg[i]["id"]+"&name="+msg[i]["name"]+"&floorid="+id+"' class='floor_type_goods_add'>添加</a></td>";
									data+="</tr>";
								}
								data+="</table>";
								$("#search_result").append(data);
							}
						}
					})
				}
			});
			/*
			$(".floor_type_goods_add").click(function(){
				document.write('<form name=myForm><input type=hidden name=id><input type=hidden name=num><input type=hidden name=floorid></form>');  
				var myForm=document.forms['myForm'];  
				myForm.action='floor_type_goods_add.php';  
				myForm.method='POST'; 
				var dataid=$(this).parents("tr").find("td")
				myForm.id.value=dataid;  
				myForm.num.value=datanum; 
				var floorid=$("#search_result").val();
				myForm.floorid.value=floorid;
				myForm.submit();
				return false;
			})
			*/
		})
		function delete_floor(id){
			if(confirm("确认移除")){
				$.ajax({
					data:"id="+id,
					url:"delete_floor_type_goods_do.php",
					type:"POST",
					success:function(msg){
						alert(msg);
						location.reload();
					}
				})
			}
		}
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">首页管理</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>位置：首页管理 －&gt; <strong>楼层管理</strong> －&gt; <strong>分类管理</strong> －&gt; <strong>商品管理</strong></span>
				</div>
				<div class="content">
						请输入商品关键字:<div class="kuan"><input name="keyword" type="text" /><!--搜索框-->
						<input name="" type="button" value="搜索" id="search"/></div><!--搜索按钮--><br/>
					<!--<select style="float:left;width:200px;" id="goodslist">
					</select>
					<a href="add_floor.php">添加商品</a></br>
					-->
					<div class="content" id="search_result" name="<?php echo $id?>">
						
					</div>
					<p>当前显示的商品</p>
					<table width="100%">
						<tr class="t1">
							<td width="5%">商品名</td>
							<td width="10%">商品权重</td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">操作</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from homePageGoods".$area;
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
							$sql1="select * from homePageGoods".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$floor_type_id=$row1["floor_type_id"];
								$goods_id=$row1["goods_id"];
								$goods_name=$row1["goods_name"];
								$weight=$row1["weight"];
						?>
						<tr>
							<td><a href="<?php echo $goods_url.$goods_id;?>" target="_blank"><?php echo $goods_name?></a></td>
							<td><?php echo $weight?></td>
							<td>
								<a href="javascript:void(0);" onclick="delete_floor(<?php echo $id;?>)">移除</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>没有相关信息！</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">当前页:<?php echo $page;?>/<?php echo $pagecount;?>页 每页 <?php echo $pagesize?> 条</div>
						<div class="pageafter">
						<?php echo showPage("check_goods.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>	
		</div>
	</body>
</html>