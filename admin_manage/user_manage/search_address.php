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
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">user manager</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location：user manager －&gt;<strong>address manager</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="10%">address number</td>
								<td width="10%">user number</td>							
							    <td width="10%">receiver</td>							
							    <td width="10%">address</td>
								<td width="10%">telphone</td>						
							</tr>
							<?php
								$pagesize=20;							
								$select="select count(address_id) as page_count from address";
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
								if($_SESSION['role']==1){
									$query="select address_id,user_id,username,phone,address from address order by user_id desc limit ".$pagestart.",".$pagesize;	
								}else{
									$query="select address_id,user_id,username,phone,address from address where user_id=$_SESSION[id] desc limit ".$pagestart.",".$pagesize;
								}
								$res=mysql_query($query);
								while($row=mysql_fetch_array($res)){
							?>
							<tr>		 
								<td><?php echo $row["order_id"] ?></td>
								<td><?php echo $row["user_id"] ?></td>								
								<td><?php echo $row["username"] ?></td>
								<td><?php echo $row["address"] ?></td>
								<td><?php echo $row["phone"] ?></td>								
							</tr>
							<?php }?>
						
						</table>
					</form>
					<?php	
						if($count==0){
							echo "<center><b>Without access to relevant information！</b></center>";
						}else{
					?>
					<div class="page">
						<div class="pagebefore">current :<?php echo $page;?>/<?php echo $pagecount;?>page every page<?php echo $pagesize?> piece</div>
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