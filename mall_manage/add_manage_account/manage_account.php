<?php
	require_once('../../conn/conn.php');
	require_once('../inc_function.php');
	require_once('function.php');
	$role=$_SESSION['role'];
	$mall_id=$_SESSION['mall_id'];
	$area=" ";
	if($role==2){
		$area=" where role=3 and mall_id='$mall_id'";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Account Manage</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1">
					<span>Position:Account Manage －&gt;<strong>Check Account</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="10%">No.</td>							
							    <td width="10%">Manager Account</td>							
							    <td width="10%">Access</td>							
							    <td width="10%">Manage Area</td>							
								<td width="10%">Last Login At</td>
								<td width="10%">This Login At</td>
								<td width="10%">Login Times</td>								
								<td width="10%">Last Login Time</td>
								<td width="10%">Operations</td>
							</tr>
							<?php
								$pagesize=20;							
								$select="select count(*) as page_count from admin_manage".$area;
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
								$query="select id,name,role,mall_id,shop_id,time,last_ip,now_ip,log_num from admin_manage".$area."order by role asc limit ".$pagestart.",".$pagesize;
								$res=mysql_query($query);
								while($row=mysql_fetch_array($res)){
							?>
							<tr>		 
								<td><?php echo $row["id"] ?></td>   
								<td><?php echo $row["name"] ?></td>   
								<td><?php echo getRole($row["role"]) ?></td>   
								<td><?php echo getRoleArea($row["role"],$row["shop_id"],$row["mall_id"]) ?></td> 
								<td><?php echo $row["last_ip"] ?></td> 
								<td><?php echo $row["now_ip"] ?></td>
								<td><?php echo $row["log_num"] ?></td>
								<td><?php echo $row["time"] ?></td>
								<td><a onclick="return check(<?=$row["id"]?>)" href="javascript:void(0)">Delete</a></td> 								
							</tr>
							<?php }?>
						
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>No Related Message</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current<?php echo $page;?>/<?php echo $pagecount;?>Page EveryPage <?php echo $pagesize?> Items</div>
						<div class="pageafter">
						<?php echo showPage("manage_account.php",$page,$pagecount,"../images");?>
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
function check(admin_manager_id)
{
	var del=confirm("Sure to delete?");
	if(del){
		alert(admin_manager_id);
		$.post("delete_manager_account.php",
			{
				admin_manager_id:admin_manager_id
			},
			function(data,status){
				if(data==1){
					alert("Delete success!");
					window.location.href="manage_account.php";
				}else{
					alert("Delete failed!");
					return false;
				}
			}
		)
	}else{
		return false;
	}
}	
</script>