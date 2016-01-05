<?php
	//首页焦点图管理
	
	
	require("../../conn/conn.php");
	require_once('../inc_function.php');
	$area="where role=".$_SESSION["mall_id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Home page management</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
		/*$(function(){
			
		})
		*/
		function delete_focus(id){
			if(confirm("Confirm Delete")){
				$.ajax({
					data:"id="+id,
					type:"POST",
					url:"delete_focus_do.php",
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
				<div class="tit1">
					<ul>				
						<li><a href="#">Home page management</a></li>
					</ul>		
				</div>				
			<div class="listintor">
				<div class="header1">
					<span>Location: home page management －&gt; <strong>Focus figure management</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="5%">Focus figure ID</td>
							<td width="5%">Chaining</td>
							<td width="10%">Weight</td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">Image</td>
							<td width="10%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from shophomeFocus ".$area;
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
							$sql1="select * from shophomeFocus ".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$weight=$row1["weight"];
								$link_url=$row1['link_url'];
								$image_url=$row1["image_url"];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $link_url?></td>
							<td><?php echo $weight?></td>
							<td><img src="<?php echo $image_url?>"/></td>
							<td>
								<a href="javascript:void(0);" onclick="delete_focus(<?php echo $id;?>)">Delete</a>
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
						<?php echo showPage("manage_focus.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>	
		</div>
	</body>
</html>