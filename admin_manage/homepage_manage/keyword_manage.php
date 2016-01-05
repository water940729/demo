<?php
	//首页焦点图管理
	
	
	require("../../conn/conn.php");
	$area="where role=".$_SESSION["mall_id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>首页管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
		/*$(function(){
			
		})
		*/
		function delete_keyword(id){
			if(confirm("Make sure")){
				$.ajax({
					data:"id="+id,
					type:"POST",
					url:"delete_keyword_do.php",
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
						<li><a href="#">homepage manage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>location:homepage manage －&gt; <strong>keywords manage</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="5%">keyword no</td>
							<td width="10%">keyword</td>
							<td width="10%">weight</td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">time</td>
							<td width="10%">operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from keyword_manage ".$area;
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
							$sql1="select * from keyword_manage ".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$keyword=$row1["keyword"];
								$time=date("Y-m-d H:i:s",$row1["time"]);
								$weight=$row1["weight"];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $keyword?></td>
							<td><?php echo $weight?></td>
							<td><?php echo $time?>"</td>
							<td>
								<a href="javascript:void(0);" onclick="delete_keyword(<?php echo $id;?>)">delete</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>empty!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">current page:<?php echo $page;?>/<?php echo $pagecount;?>page  <?php echo $pagesize?> piece/page</div>
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