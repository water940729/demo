<?php
	require("../../conn/conn.php");
	$id=$_GET["id"];
	$name=$_GET["name"];
	$area=" where floor_id=$id";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Home page management</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<!--<script type="text/javascript" src="../js/upload.js"></script>-->
		<script>
			function delete_floor_type(id){
				if(confirm("Confirm Delete")){
					$.ajax({
						data:"id="+id,
						type:"POST",
						url:"delete_floor_type.php",
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
					<span>Location: home page management －&gt; <strong>Floor management</strong> －&gt; <strong>Classification Management</strong></span>
				</div>
				<div class="content">
					<a href="add_floor_type.php?id=<?php echo $id;?>&name=<?=$name?>"><strong>Add Classification</strong></a><br/>
					<table width="100%">
						<tr class="t1">
							<td width="5%">Custom categories name</td>
							<td width="10%">Floor name</td>
							<td width="10%">Classification weight </td>
							<!--<td width="10%">类别</td>-->
							<td width="10%">The corresponding classification system</td>
							<td width="10%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from floorTypeManage".$area;
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
							$sql1="select * from floorTypeManage".$area." order by weight desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$typename=$row1["typename"];
								$floor_name=$row1["floor_name"];
								$weight=$row1["weight"];
								$type1_name=$row1["type1_name"];
						?>
						<tr>
							<td><?php echo $typename?></td>
							<td><?php echo$floor_name?></td>
							<td><?php echo $weight?></td>
							<td><?php echo $type1_name?></td>
							<?php /*<td><?php echo $type?></td>*/?>
							<td>
								<a href="floor_type_goods_manage.php?id=<?=$id?>">Commodity management</a>|
								<a href="javascript:void(0);" onclick="delete_floor_type(<?php echo $id;?>)">Delete</a>
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