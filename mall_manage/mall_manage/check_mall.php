<?php
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css" />
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="bgintor">				
			<div class="listintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">MallManage</a></li>
					</ul>		
				</div>
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Position:MallManage －&gt; <strong>CheckMall</strong></span>
				</div>
				<div class="content">
					<table width="100%">
						<tr class="t1">
							<td width="5%">MallNo.</td>
							<td width="10%">MallName</td>
							<td width="10%">Province</td>
							<td width="10%">City</td>
							<td width="10%">Area</td>
							<td width="20%">DetailAddress</td>
							<td width="20%">MallbriefIntroduction</td>
							<td width="15%">Operation</td>
						</tr>
						<?php
							$pagesize=20;							
							$select="select count(*) as page_count from mall";
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
							$sql1="select * from mall order by id desc limit ".$pagestart.",".$pagesize;
							$result1=mysql_query($sql1);
							while($row1=mysql_fetch_array($result1))
							{	
								$id=$row1['id'];
								$name=$row1['name'];
								$province=$row1['province'];
								$city=$row1['city'];
								$county=$row1['county'];
								$detail_address=$row1['detail_address'];
								$introduceInfo=$row1['introduceInfo'];
						?>
						<tr>
							<td><?php echo $id?></td>
							<td><?php echo $name?></td>
							<td><?php echo $province?></td>
							<td><?php echo $city?></td>
							<td><?php echo $county?></td>
							<td><?php echo $detail_address?></td>
							<td><?php echo $introduceInfo?></td>
							<td>
							<?php
								if($_SESSION["role"]==1){
									echo"<a href='../shop_manage/add_shop.php?mall_id={$id}'>AddStore</a>";
								}
							?>
								<a href="check_mall_shop.php?mall_id=<?=$id?>&mall_name=<?=$name?>">CheckStore</a>|
								<a href="edit_mall.php?mall_id=<?=$id?>">ModifyMall</a>|
								<a href="javascript:void(0);" onclick="delete_mall(<?=$id?>,'<?=$name?>')">Delete</a>
							</td>
						</tr>
						<?php
							}	
						?>
					</table>
					<?php	
						if($count==0){
							echo "<center><b>No such information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current:<?php echo $page;?>/<?php echo $pagecount;?>Page EveryPage <?php echo $pagesize?> Items</div>
						<div class="pageafter">
						<?php echo showPage("check_mall.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>	
		</div>
	</body>
</html>
<script>
	function delete_mall(mall_id,mall_name){
		if(confirm("All stores and goods will be removed when mall being removed,confirm to delete?"+mall_name+"吗")){
			$.post("delete_mall_do.php",
				{
					mall_id:mall_id
				},
				function(data,status){
					if(data==1){
						alert("Delete success!");
						location.reload();
					}else{
						alert(data);
					}
				}
			);
		}
	}
</script>