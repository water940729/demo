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
				$(".check").click(function(){
					var $parent=$(this).parents("tr");
					var id=$parent.attr("id");
					var state=$parent.children(".state").attr("name");
					if(state==1){
						alert("This user has been reviewed");
					}else if(state==-1){
						alert("The user has Invalid");
					}else{
						$.post("check_user.php",{user_id:id},function(data){
							if(data==1){
								alert("Audit Success");
								location.reload();
							}else{
								alert("Unknown error, please try again later");
							}
						});	
					}
				});
				$(".delete").click(function(){
					var $parent=$(this).parents("tr");
					var id=$parent.attr("id");
					var state=$parent.children(".state").attr("name");
					if(state==-1){
						alert("Delete failure, the user has not repeatable");
					}else{
						$.post("delete_user.php",{user_id:id},function(data){
							if(data==1){
								alert("Deleted successfully, the user has been Invalid");
								location.reload();
							}else{
								alert("Unknown error, please try again later");
							}
						});
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
						<li><a href="#">User management</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: user management －&gt;<strong>View user</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="10%">ID</td>							
							    <td width="10%">Account</td>							
							    <td width="10%">Status</td>							
							    <td width="10%">LastLoginTime</td>
								<td width="10%">Operation</td>
							</tr>
							<?php
								$pagesize=20;							
								$select="select count(*) as page_count from user_manage";
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
								$query="select user_id,username,state,last_time from user_manage order by user_id desc limit ".$pagestart.",".$pagesize;
								$res=mysql_query($query);
								while($row=mysql_fetch_array($res)){
							?>
							<tr id="<?php echo $row["user_id"]?>">		 
								<td><?php echo $row["user_id"] ?></td>   
								<td><?php echo $row["username"] ?></td>
								<td class="state" name="<?php echo $row["state"]?>">
							<?php
								switch($row["state"]){
									case 0:
										echo "Check pending";
										break;
									case 1:
										echo "Active";
										break;
									case -1:
										echo "Invalid";
										break;
								}
							?>
								</td> 
								<td><?php echo date("Y-m-d H:i:s",$row["last_time"]); ?></td>
								<td><a href="#" target="mainFrame" class="delete">Delete</a>|<a href="#" target="mainFrame" class="check">Audit</a></td>
							</tr>
							<?php }?>
						
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>There is no relevant information!</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">Current page:<?php echo $page;?>/<?php echo $pagecount;?>page Each page <?php echo $pagesize?> one</div>
						<div class="pageafter">
						<?php echo showPage("search_user.php",$page,$pagecount,"../images");?>
						<div class="clear"></div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>