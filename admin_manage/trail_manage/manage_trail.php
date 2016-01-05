<?php
	require("../../conn/conn.php");
	/*if($_SESSION["role"]==1){
		$area="where role=0";
	}else{
		$area="where role=$_SESSION[mall_id]";
	}
	*/
	$area="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>首页管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/upload.js"></script>
		<script>
			//删除楼层
			function delete_trail_type(id){
				if(confirm("Make sure")){
					$.ajax({
						type:"POST",
						url:"delete_trail_type.php",
						data:"id="+id,
						success:function(msg){
							alert(msg);
							location.reload();
						}
					});
				}
			}
		</script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">trial manage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>location:trial manage －&gt; <strong>trial manage</strong></span>
				</div>
				<div class="content">
					<a href="add_trail.php">add trial type</a>
					<table width="100%">
						<tr class="t1">
							<td width="5%">type no</td>
							<td width="5%">type name</td>
							<td width="10%">type weight</td>
							<td width="10%">operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from trail_type ".$area;
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
							$sql1="select * from trail_type ".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$weight=$row1["weight"];
								$name=$row1['typename'];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $name?></td>
							<td><?php echo $weight?></td>
							<td>
								<a href="manage_trail_type.php?id=<?=$id?>&name=<?=$name?>">sort management</a>|
								<a href="javascript:void(0);" onclick="delete_trail_type(<?php echo $id;?>)">delete</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>empty！</b></center>";
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