<?php
	require("../../conn/conn.php");
	//print_r($_SESSION);
	//print_r($_GET);
	/*
	Array ( [wii_imgcode] => 8464 [name] => water [role] => 1 [role_area] => 超级管理员 [id] => 10 [shop_id] => 0 [mall_id] => 0 )

	Array
	(
		[goods_id] => 49
	)
	*/
	$id=0;
	$area=" where role=$_SESSION[mall_id] and floor_type_id=0";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Home page management</title>
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
					alert("Keywords can't be empty");
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
								alert("No corresponding items, please enter a different keyword");
							}else{
								//alert("000");
								$("#search_result").empty();
								var id=$("#search_result").attr("name");
								var data="<table width='100%'><tr class='t1'><td width='5%' class='id'>Product ID</td>"+
								"<td width='10%' class='name'>Product</td>"+"<td width='10%'>Mall</td>"+"<td width='10%'>First classification</td>"+
								"<td width='10%'>Secondary classification</td>"+"<td width='10%'>Third classification</td>"+"<td width='10%'>Operation</td></tr>";
								for(var i in msg){
									data+="<tr>";
									for(var x in msg[i]){
										if(x=="name"){
											data+="<td><a href='<?php echo $goods_url;?>"+msg[i]["id"]+"' target='_blank'>"+msg[i][x]+"</a></td>";
										}else{
											data+="<td>"+msg[i][x]+"</td>";										
										}
									}
									data+="<td><a href='floor_type_goods_add.php?id="+msg[i]["id"]+"&name="+msg[i]["name"]+"&floorid="+id+"&from=recom' class='floor_type_goods_add'>Add</a></td>";
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
			if(confirm("Confirm to remove")){
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
						<li><a href="#">Home page management</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: home page management －&gt; <strong>Recommended management</strong></span>
				</div>
				<div class="content">
						Please enter the commodity keywords:<div class="kuan"><input name="keyword" type="text" /><!--搜索框-->
						<input name="" type="button" value="search" id="search"/></div><!--搜索按钮--><br/>
					<!--<select style="float:left;width:200px;" id="goodslist">
					</select>
					<a href="add_floor.php">添加商品</a></br>
					-->
					<div class="content" id="search_result" name="<?php echo $id?>">
						
					</div>
					<p>The currently displayed items</p>
					<table width="100%">
						<tr class="t1">
							<td width="5%">Product</td>
							<td width="10%">Product weight</td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">Operation</td>
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
								<a href="javascript:void(0);" onclick="delete_floor(<?php echo $id;?>)">Delete</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>There is no relevant information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current page:<?php echo $page;?>/<?php echo $pagecount;?>page Each page <?php echo $pagesize?> one</div>
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